<?php


namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Facade;
use Intervention\Image\Facades\Image;

class ImageFactory extends Facade
{
    public static function upload($image, $destination, $width, $height, $image_name = null)
    {
        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0777, true, true);
        }

        if (is_null($image_name))
            $image_name = time() . '.' . $image->extension();

        $img = Image::make($image->path());

        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination . '/' . $image_name);
    }


}
