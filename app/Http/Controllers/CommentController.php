<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        return CommentResource::collection(
            $post->comments()->with(['children', 'user'])->paginate(3)
        );
    }

    public function store(Post $post, Request $request)
    {
        
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);

        $comment = $post->comments()->make([
            'body' => strip_tags(trim($request->body))
        ]);

        $request->user()->comments()->save($comment);

        return new CommentResource($comment);
    }
}
