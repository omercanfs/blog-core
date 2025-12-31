<?php

namespace Omercanfs\BlogCore\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Omercanfs\BlogCore\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::latest()->get();
    }

    public function create()
    {
        return 'create form later';
    }

    public function store(Request $request)
    {
        return Post::create($request->all());
    }

    public function edit(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
