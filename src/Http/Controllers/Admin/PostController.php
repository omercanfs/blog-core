<?php

namespace Omercanfs\BlogCore\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Omercanfs\BlogCore\Models\Post;
use Omercanfs\BlogCore\Models\Category;

class PostController extends Controller
{
   public function index(Request $request)
    {
        // 1. Sorguyu Başlat
        $query = Post::with('category');

        // 2. Arama Filtresi (Başlıkta Ara)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 3. Kategori Filtresi
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 4. Sıralama (Okunma sayısı veya Tarih)
        switch ($request->sort) {
            case 'view_desc':
                $query->orderBy('view_count', 'desc'); // Çok okunan en üstte
                break;
            case 'view_asc':
                $query->orderBy('view_count', 'asc'); // Az okunan en üstte
                break;
            case 'oldest':
                $query->oldest(); // En eski
                break;
            default:
                $query->latest(); // Varsayılan: En yeni
                break;
        }

        // 5. Sayfalama (Filtreleri linklerde koru)
        $posts = $query->paginate(10)->withQueryString();

        // 6. Kategorileri de gönder (Select kutusu için)
        $categories = Category::all();

        return view('blog-core::admin.post.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all(); // Seçim kutusu için
        return view('blog-core::admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Resim Yükleme
        $imagePath = null;
        if ($request->hasFile('image')) {
            // storage/app/public/blog klasörüne kaydeder
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        $slug = Str::slug($request->title);
        // (Slug benzersizlik kontrol kodların buraya...)

        Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.blog.posts.index')->with('success', 'Yazı eklendi.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('blog-core::admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Eski resmi sil istersen: Storage::disk('public')->delete($post->image);
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.blog.posts.index')->with('success', 'Güncellendi.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        // Resmi de silebilirsin
        if($post->image) {
             Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('admin.blog.posts.index');
    }

}