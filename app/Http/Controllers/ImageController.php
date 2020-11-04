<?php

namespace App\Http\Controllers;

use App\Model\Image;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;

class ImageController extends Controller
{
    use UploadTrait;


    /**
     * @param UploadedFile $image
     * @param $root
     * @return string
     */
    public function saveImage(UploadedFile $image, $root): string
    {
//        $image = $request->file('image');
        $name = '_' . time();
        $folder = '/images/';
        $filePath = $root . $folder . $name . '.' . $image->getClientOriginalExtension();
        $this->uploadOne($image, $folder, 'public', $name);

        return $filePath;
    }

    public function loadImage($id)
    {
        
    }

}
