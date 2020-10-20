<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Uuid;

    protected $primaryKey = 'id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'link',
        'image_path'
    ];
}
