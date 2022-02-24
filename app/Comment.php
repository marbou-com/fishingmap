<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'description'
    ];


    //一つの投稿が一人のユーザーに紐づく
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    //一つの投稿が一人のユーザーに紐づく
    public function post() {
        return $this->belongsTo('App\User', 'post_id', 'id');
    }
    public function tags()
    {
        //dd($this->belongsToMany('App\Tag'));
        return $this->belongsToMany('App\Tag');
    }
}
