<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getComments(Int $tweet_id)
    {
        return $this->with('user')->where('tweet_id', $tweet_id)->get();
    }

    public function commentStore(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->tweet_id = $data['tweet_id'];
        $this->text = $data['text'];
        $this->save();

        return;
    }

    public function getEditComment(Int $user_id, Int $commnet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $commnet_id)->first();
    }

    public function commentUpdate(Int $commnet_id, Array $data)
    {

        $this->id = $commnet_id;
        $this->text = $data['text'];
        $this->update();
        return;
    }

    public function commentDestroy(Int $user_id, Int $commnet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $commnet_id)->delete();
    }


}
