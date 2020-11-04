<?php

namespace App\Http\Controllers;
use App\Model\Post;

use Illuminate\Http\UploadedFile;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    use UploadTrait;


    /**
     * @param UploadedFile $image
     * @param $root
     * @return string
     */
    public function saveImage(UploadedFile $image): string
    {
        $name = '_' . time();
        $folder = '/images/';
        $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
        $this->uploadOne($image, $folder, 'public', $name);

        return $filePath;
    }

    /**
     * @param $idPost
     * @return string
     */
    public function loadImage($idPost)
    {
        $post = Post::query()->where('id',$idPost)->get()->first();
        $imageFile = File::get(public_path($post->image_path));
        $ext = pathinfo(public_path($post->image_path), PATHINFO_EXTENSION);
        dd($ext);
        $base64String = base64_encode($imageFile);
        $imageSrc = 'data:image/'.$ext.'jpeg;base64,' . $base64String;
        return $imageSrc;

    }

}
