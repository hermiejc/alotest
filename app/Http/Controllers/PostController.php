<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        //$posts = $request->user()->posts()->get();
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {   
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $post = new Post;
        return view('posts.create', compact('post'));
    }

    public function store(Request $request)
    {
        $this->validate_post($request);

        $request->user()->posts()->create([
            'title'         => $this->sanitize_post($request->title),
            'slug'          => Str::slug($this->sanitize_post($request->title)),
            'description'   => $this->sanitize_post($request->description),
        ]);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->validate_post($request);

        $post->update([
            'title'         => $this->sanitize_post($request->title),
            'slug'          => Str::slug($this->sanitize_post($request->title)),
            'description'   => $this->sanitize_post($request->description)
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->back();
    }

    public function validate_post(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required|max:200',
            'description'   => 'required|max:1000'
        ]);
    }

    public function sanitize_post($item)
    {
        return strip_tags(trim($item));
    }


}
