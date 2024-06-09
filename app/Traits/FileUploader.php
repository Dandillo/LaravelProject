<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait FileUploader
{
    public function upload_image($image, $old_image = null, $path = 'images')
    {
        $image_file_path = storage_path("app/public/$path");
//      Удаление старого изображения
        if ($old_image) {
                Storage::delete('public/' . $old_image);
        }
//      Сохранение нового
        $card_name = $image->hashName();
        $card_img = Image::make($image->path());
        $card_img->save($image_file_path . '/' . $card_name);

        return "$path/" .$card_name;
    }

}
