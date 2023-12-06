<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageHelper
{
    public static function uploadImage(UploadedFile $file)
    {
        $validator = Validator::make(['file' => $file], ['file' => 'image']);
        if ($validator->fails()) return null;

        $file->store('public/images');
        $name = $file->hashName();

        return $name;
    }

    public static function url(string $name = null, string $fallback = null)
    {
        return $name ? Storage::url('public/images/' . $name) : $fallback;
    }

}