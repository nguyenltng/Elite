<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tile', 'description',
    ];
}
