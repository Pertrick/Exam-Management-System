<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\ResourceService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $settings =  Setting::first();
        $settings->update([
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'main_color' => $request->main_color ?? $settings->main_color
        ]);

        return redirect()->back()->with('success', 'Request Successful!');
    }


    public function upload(Request $request, ResourceService $resourceService)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpeg,png,jpg,gif|max:4096'
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $uploadedResourcePath = $resourceService->uploadFile($file, '/cover-image/');

                $settings = Setting::first();

                if ($settings) {
                    if ($settings->cover_image) {
                        Storage::disk('public')->delete($settings->cover_image);
                    }

                    $settings->update(['cover_image' => $uploadedResourcePath]);
                } else {

                    Setting::create([
                        'cover_image' => $uploadedResourcePath,
                        'main_color' => '#000000',
                        'primary_color' => '#000000',
                        'secondary_color' => '#000000'
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'path' => $uploadedResourcePath
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file was uploaded'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
