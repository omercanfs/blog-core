<?php

namespace Omercanfs\BlogCore\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Omercanfs\BlogCore\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('blog-core::admin.posts.index', compact('posts'));
    }


    public function create()
    {
        return view('blog-core::admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        // 👇 SLUG ÜRETİMİ (BURAYA)
        $slug = Str::slug($request->title);

        $count = Post::where('slug', 'like', "{$slug}%")->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        // 👇 KAYIT
        Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.blog.posts.index');
    }


    public function edit(Post $post)
    {
        return view('blog-core::admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        $post->update($data);

        return redirect('/admin/blog/posts');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/admin/blog/posts');
    }

}
