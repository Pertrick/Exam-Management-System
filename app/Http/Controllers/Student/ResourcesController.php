<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Resources;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchQuery = request()->query('search');
        $resources = Resources::with('subject')->search($searchQuery)->latest()->paginate(6);
        return view('student.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

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

            return view('student.resources.show', [
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
