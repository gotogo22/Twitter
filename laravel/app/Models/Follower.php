<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $primaryKey = [
        'following_id',
        'followed_id'
    ];
    protected $fillable = [
        'following_id',
        'followed_id'
    ];
    public $timestamps = false;
    public $incrementing = false;

    public function getFollowCount($user_id)
    {
         //自モデルの引数のユーザーIDのフォローワー数をカウントする
        return $this->where('following_id', $user_id)->count();

    }

    public function getFollowerCount($user_id)
    {
        //自モデルの引数のユーザーIDのフォロー数をカウントする
        return $this->where('followed_id', $user_id)->count();
    }

    public function followingIds(Int $user_id)
    {
        // SELECT followed_id FROM followers WHERE following_id = 1
        return $this->where('following_id', $user_id)->get('followed_id');
    }

}
