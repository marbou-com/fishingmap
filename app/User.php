<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;      

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo_url',
        'name',
        'email',
        'password',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id', 'id');
        //return $this->hasMany(Post::class);
    }

    public function users(){//トップページで使う｜フォローしてくれている
        return $this->hasMany('App\Follow', 'from_follow_id', 'id');
    }

    public function users_to(){//トップページのユーザーをもっと見るで使う｜フォローしている
        return $this->hasMany('App\Follow', 'to_follow_id', 'id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
