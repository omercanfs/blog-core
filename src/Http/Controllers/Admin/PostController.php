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

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;

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

    // 👇 DEĞİŞİKLİK 1: (Post $post) yerine ($id) kullandık
  public function edit($id)
{
    // 1. Gelen ID'yi kontrol et
    $post = Post::find($id);

    // 2. Ekrana bas ve kodun çalışmasını durdur (Debug)
    dd([
        'DEBUG_RAPORU' => 'Controller Kontrolü',
        'Gelen_ID' => $id,
        'Post_Durumu' => $post ? 'DOLU (Bulundu)' : 'BOŞ (Bulunamadı)',
        'Post_Verisi' => $post
    ]);

    return view('blog-core::admin.posts.edit', compact('post'));
}

    // 👇 DEĞİŞİKLİK 2: Update işleminde de ID kullanıyoruz
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        $post->update($data);

        return redirect()->route('admin.blog.posts.index')
                         ->with('success', 'Blog yazısı güncellendi.');
    }

    // 👇 DEĞİŞİKLİK 3: Silme işleminde de ID kullanıyoruz
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.blog.posts.index')
                         ->with('success', 'Blog yazısı silindi.');
    }
}