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

        // Benzersiz Slug Üretimi
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;

        // Eğer slug veritabanında varsa sonuna -1, -2 ekle
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.blog.posts.index')
                         ->with('success', 'Blog yazısı başarıyla oluşturuldu.');
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

        // Slug güncelleme mantığı opsiyoneldir. 
        // Genelde SEO için URL değişmesi istenmez ama başlık değişirse slug da değişsin dersen buraya ekleme yapabiliriz.
        // Şimdilik sadece title ve content güncelliyoruz.

        $post->update($data);

        return redirect()->route('admin.blog.posts.index')
                         ->with('success', 'Blog yazısı güncellendi.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.blog.posts.index')
                         ->with('success', 'Blog yazısı silindi.');
    }
}