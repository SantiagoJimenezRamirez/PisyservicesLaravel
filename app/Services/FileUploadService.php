<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public static function uploadProductImage(Request $request, string $fieldName)
    {
        $uploadsDir = config('uploads.uploads_dir');
        $allowedTypes = config('uploads.allowed_types');
        $maxFileSize = config('uploads.max_file_size');

        $file = $request->file($fieldName);

        if (!$file) {
            throw new \Exception('No file uploaded.');
        }

        if (!in_array($file->getClientMimeType(), $allowedTypes)) {
            throw new \Exception('Only images are allowed.');
        }

        if ($file->getSize() > $maxFileSize) {
            throw new \Exception('File size exceeds the maximum limit.');
        }

        $uniqueName = Str::random(10) . '-' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('public/uploads/products', $uniqueName);

        return Storage::url($path);
    }
}
