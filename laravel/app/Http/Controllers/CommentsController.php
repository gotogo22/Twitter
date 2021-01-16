<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;


class CommentsController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'tweet_id' =>['required', 'integer'],
            'text'     => ['required', 'string', 'max:140']
        ]);

        $validator->validate();
        $comment->commentStore($user->id, $data);

        return back();
    }

public function show(Tweet $tweet, Comment $comment)
    {
        $user = auth()->user();
        $tweet = $tweet->getcommnet($tweet->id);
        $comments = $comment->getComments($tweet->id);

        return view('tweets.show', [
            'user'     => $user,
            'tweet' => $tweet,
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $user = auth()->user();
        $comments = $comment->getEditComment($user->id, $comment->id);

        if (!isset($comments)) {
            return redirect('tweets');
        }

        return view('comments.edit', [
            'user'   => $user,
            'comments' => $comments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'text' => ['required', 'string', 'max:140']
        ]);
        $validator->validate();

        $comment->commentUpdate($comment->id, $data);
        // dd();
        return redirect('tweets/' .$comment->tweet_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commnet $commnet)
    {
        $user = auth()->user();
        $commnet->commentDestroy($user->id, $commnet->id);

        return back();
    }
}
