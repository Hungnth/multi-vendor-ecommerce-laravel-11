<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait ImageUploadTrait
{
    public function upload_image(Request $request, $input_name, $path)
    {
        if ($request->hasFile($input_name)) {

            $image = $request->{$input_name};
            $ext = $image->getClientOriginalExtension();
            $image_name = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $image_name);

            return $path . '/' . $image_name;
        }
    }

    public function update_image(Request $request, $input_name, $path, $old_path=null)
    {
        if ($request->hasFile($input_name)) {
            if (File::exists(public_path($old_path))) {
                File::delete(public_path($old_path));
            }

            $image = $request->{$input_name};
            $ext = $image->getClientOriginalExtension();
            $image_name = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $image_name);

            return $path . '/' . $image_name;
        }
    }

    /**
     * Handle delete file
     */
    public function delete_image(string $path): void
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
