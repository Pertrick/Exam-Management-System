<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use App\Models\Resources;
use Illuminate\Http\Request;
use App\Services\ResourceService;
use App\Http\Controllers\Controller;

use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\Storage;

class ResourcesController extends Controller
{

    public function __construct(private ResourceService $resourceService) {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Resources::with('subject')->latest()->get();
        return view('admin.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all(['id', 'name']);
        $resources = Resources::with('subject')->get();
        return view('admin.resources.create', compact('subjects', 'resources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'nullable|required_if:has_pdf,on|mimes:pdf|max:10240',
            'uploaded_video' => 'nullable|required_if:has_video,on|mimes:mp4,mov,avi|max:51200',
            'video_url' => 'nullable|required_if:has_embed,on|url'
        ]);

        try {
            // Handle cover image upload
            $uploadedCoverImagePath = $request->hasFile('cover_image')
                ? $this->resourceService->uploadFile($request->file('cover_image'), '/uploads/resources/cover_images/')
                : null;

            // Initialize resource paths
            $resourceData = [
                "name" => $validatedData['name'],
                "description" => $validatedData['description'],
                "subject_id" => $validatedData['subject_id'],
                "cover_image" => $uploadedCoverImagePath,
                "pdf_file" => null,
                "uploaded_video" => null,
                "video_url" => null
            ];

            // Handle PDF upload if selected
            if ($request->has('has_pdf') && $request->hasFile('pdf_file')) {
                $resourceData['pdf_file'] = $this->resourceService->uploadFile(
                    $request->file('pdf_file'),
                    '/uploads/resources/pdfs/'
                );
            }

            // Handle video upload if selected
            if ($request->has('has_video') && $request->hasFile('uploaded_video')) {
                $resourceData['uploaded_video'] = $this->resourceService->uploadFile(
                    $request->file('uploaded_video'),
                    '/uploads/resources/videos/'
                );
            }

            // Handle video URL if selected
            if ($request->has('has_embed') && $request->video_url) {
                $resourceData['video_url'] = $request->video_url;
            }

            // Create the resource
            Resources::create($resourceData);

            return redirect()
                ->route('admin.resources.index')
                ->with('success', 'Resource created successfully.');
        } catch (\Exception $e) {
            // Clean up any uploaded files if there was an error
            if (isset($uploadedCoverImagePath)) {
                Storage::disk('public')->delete($uploadedCoverImagePath);
            }
            if (isset($resourceData['pdf_path'])) {
                Storage::disk('public')->delete($resourceData['pdf_path']);
            }
            if (isset($resourceData['video_path'])) {
                Storage::disk('public')->delete($resourceData['video_path']);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create resource: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($uuid)
    {
        try {
            $resource = Resources::where('uuid', $uuid)->firstOrFail();
            $resourceData = [];

            // Handle PDF file
            if ($resource->pdf_file) {
                if (Storage::exists("public" . $resource->pdf_file)) {
                    $resourceData['pdf_url'] = Storage::disk('public')->url($resource->pdf_file);
                }
            }

            // Handle uploaded video
            if ($resource->uploaded_video) {
                if (Storage::exists("public" . $resource->uploaded_video)) {
                    $resourceData['video_url'] = Storage::disk('public')->url($resource->uploaded_video);
                }
            }

            // Handle external video URL
            if ($resource->video_url) {
                $resourceData['external_video_url'] = $resource->video_url;
                $resourceData['embed_url'] =  $this->getEmbedUrl($resource->video_url);
            }

            // Handle cover image
            if ($resource->cover_image) {
                if (Storage::exists("public" . $resource->cover_image)) {
                    $resourceData['cover_url'] = Storage::disk('public')->url($resource->cover_image);
                }
            }

            return view('admin.resources.show', [
                'resource' => $resource,
                'resourceData' => $resourceData
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Resource retrieval failed: ' . $e->getMessage());
        }
    }

    /**
     * Convert video URL to embed URL
     */
    private function getEmbedUrl($url)
    {
        // YouTube
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            $videoId = '';

            if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
                $videoId = $matches[1];
            } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
                $videoId = $matches[1];
            }

            if ($videoId) {
                return "https://www.youtube.com/embed/" . $videoId;
            }
        }

        // Vimeo
        if (str_contains($url, 'vimeo.com')) {
            if (preg_match('/vimeo\.com\/([0-9]+)/', $url, $matches)) {
                return "https://player.vimeo.com/video/" . $matches[1];
            }
        }

        return $url;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = Subject::all(['id', 'name']);
        $resource = Resources::with('subject')->findOrFail($id);
        return view('admin.resources.edit', compact('subjects', 'resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'uploaded_video' => 'nullable|mimes:mp4,mov,avi|max:51200',
            'video_url' => 'nullable|url'
        ]);

        try {
            $resource = Resources::findOrFail($id);

            // Initialize resource data with basic info
            $resourceData = [
                "name" => $validatedData['name'],
                "description" => $validatedData['description'],
                "subject_id" => $validatedData['subject_id']
            ];

            // Handle cover image update
            if ($request->hasFile('cover_image')) {
                $resourceData['cover_image'] = $this->resourceService->updateResourceFile(
                    $resource->cover_image,
                    $request->file('cover_image'),
                    '/uploads/resources/cover_images/'
                );
            }

            // Handle PDF file
            if ($request->has('has_pdf')) {
                if ($request->hasFile('pdf_file')) {
                    $resourceData['pdf_file'] = $this->resourceService->updateResourceFile(
                        $resource->pdf_file,
                        $request->file('pdf_file'),
                        '/uploads/resources/pdfs/'
                    );
                }
            } else {
                // Remove PDF if checkbox is unchecked
                if ($resource->pdf_file) {
                    Storage::disk('public')->delete($resource->pdf_file);
                    $resourceData['pdf_file'] = null;
                }
            }

            // Handle video upload
            if ($request->has('has_video')) {
                if ($request->hasFile('uploaded_video')) {
                    $resourceData['uploaded_video'] = $this->resourceService->updateResourceFile(
                        $resource->uploaded_video,
                        $request->file('uploaded_video'),
                        '/uploads/resources/videos/'
                    );
                }
            } else {
                // Remove video if checkbox is unchecked
                if ($resource->uploaded_video) {
                    Storage::disk('public')->delete($resource->uploaded_video);
                    $resourceData['uploaded_video'] = null;
                }
            }

            // Handle external video URL
            if ($request->has('has_embed')) {
                $resourceData['video_url'] = $request->video_url;
            } else {
                $resourceData['video_url'] = null;
            }

            // Update the resource
            $resource->update($resourceData);

            return redirect()
                ->route('admin.resources.index')
                ->with('success', 'Resource updated successfully.');
        } catch (\Exception $e) {
            // Clean up any newly uploaded files if there was an error
            if (isset($resourceData['cover_image']) && $resourceData['cover_image'] !== $resource->cover_image) {
                Storage::disk('public')->delete($resourceData['cover_image']);
            }
            if (isset($resourceData['pdf_file']) && $resourceData['pdf_file'] !== $resource->pdf_file) {
                Storage::disk('public')->delete($resourceData['pdf_file']);
            }
            if (isset($resourceData['uploaded_video']) && $resourceData['uploaded_video'] !== $resource->uploaded_video) {
                Storage::disk('public')->delete($resourceData['uploaded_video']);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update resource: ' . $e->getMessage());
        }
    }
    /**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    try {
        $resource = Resources::findOrFail($id);

        // Delete cover image if exists
        if ($resource->cover_image && Storage::exists('public' . $resource->cover_image)) {
            Storage::delete('public' . $resource->cover_image);
        }

        // Delete PDF file if exists
        if ($resource->pdf_file && Storage::exists('public' . $resource->pdf_file)) {
            Storage::delete('public' . $resource->pdf_file);
        }

        // Delete uploaded video if exists
        if ($resource->uploaded_video && Storage::exists('public' . $resource->uploaded_video)) {
            Storage::delete('public' . $resource->uploaded_video);
        }

        // Delete the resource record
        $resource->delete();

        return redirect()
            ->route('admin.resources.index')
            ->with('success', 'Resource deleted successfully.');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->with('error', 'Failed to delete resource: ' . $e->getMessage());
    }
}
}
