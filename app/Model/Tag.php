<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['name'];

    public $timestamps = true;

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
