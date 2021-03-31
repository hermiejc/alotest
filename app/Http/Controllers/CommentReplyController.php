<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    public function store(Comment $comment, Request $request)
    {
       
        $this->authorize('reply', $comment);

        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);

        $reply = $comment->children()->make([
            'body' => strip_tags(trim($request->body))
        ]);

        $reply->commentable()->associate($comment->commentable);

        $request->user()->comments()->save($reply);

        return new CommentResource($reply);
    }
}
