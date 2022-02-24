<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
    public function comments()
    {
        return $this->belongsToMany('App\Comment');
    }
}
