<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ResourceService
{
    /**
     * Upload a file and return the uploaded file path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @return string
     * @throws \Exception if file upload fails
     */
    public function uploadFile(UploadedFile $file, string $path): string
    {
        try {
            $extension = $file->getClientOriginalExtension();
            $uniqueId = Str::random(6);
    
            $filename = substr($uniqueId, 0, 4) . '_' . substr($uniqueId, 4, 2) . '.' . $extension;
            $file->storeAs('public' . $path, $filename);

            return $path . $filename;
        } catch (\Exception $e) {
            throw new \Exception("Failed to upload file: " . $e->getMessage());
        }
    }
    


    /**
     * Update a resource file, delete the existing file if necessary.
     *
     * @param  string|null  $existingPath
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $path
     * @return string|false  Updated file path or false on failure
     */
    public function updateResourceFile(?string $existingPath, UploadedFile $file, string $path)
    {
        try {
            $uploadedFilePath = $this->uploadFile($file, $path);

            if ($existingPath && Storage::exists('public' . $existingPath)) {
                Storage::delete('public' . $existingPath);
            }

            return $uploadedFilePath;
        } catch (\Exception $e) {
            throw new \Exception("Failed to update resource file: " . $e->getMessage());
        }
    }
}
