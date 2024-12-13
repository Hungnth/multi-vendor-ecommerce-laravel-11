<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, $input_name, $path)
    {
        if ($request->hasFile($input_name)) {

            $image = $request->{$input_name};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }

    public function uploadMultiImage(Request $request, $input_name, $path)
    {
        $imagePaths = [];
        if ($request->hasFile($input_name)) {

            $images = $request->{$input_name};

            foreach ($images as $image) {
                $ext = $image->getClientOriginalExtension();
                $imageName = 'media_' . uniqid() . '.' . $ext;
                $image->move(public_path($path), $imageName);

                $imagePaths[] = $path . '/' . $imageName;
            }
            return $imagePaths;
        }
    }

    public function updateImage(Request $request, $input_name, $path, $old_path = null)
    {
        if ($request->hasFile($input_name)) {
            if (File::exists(public_path($old_path))) {
                File::delete(public_path($old_path));
            }

            $image = $request->{$input_name};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }

    /**
     * Handle delete file
     */
    public function deleteImage(string $path): void
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
