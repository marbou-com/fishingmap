<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_follow_id',
        'to_follow_id',
        'is_follow',
    ];


       /**
     * query scope to judge the post is liked or not
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @param int $postId
     *
     * @return follow
     */
    public function scopeFindByUserIdAndToUserId($query, int $userId, int $toUserId): follow
    {
        return $query
            ->where('from_follow_id', $userId)
            ->where('to_follow_id', $toUserId)
            ->first();
    }
    //reration

}
