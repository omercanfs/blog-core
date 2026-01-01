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

        // ... (Arama, Filtreleme ve Sıralama kodların burada aynen kalsın) ...
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        switch ($request->sort) {
            case 'view_desc': $query->orderBy('view_count', 'desc'); break;
            case 'view_asc': $query->orderBy('view_count', 'asc'); break;
            case 'oldest': $query->oldest(); break;
            default: $query->latest(); break;
        }
        // ... (Filtreleme bitiş) ...

        $posts = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        // 👇 EKSİK OLAN KISIM BURASI: İstatistikleri Hesapla
        $stats = [
            'total_posts'      => Post::count(),
            'total_categories' => Category::count(),
            'total_views'      => Post::sum('view_count'),
        ];

        // 👇 'stats' değişkenini view'a gönder
        return view('blog-core::admin.posts.index', compact('posts', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        $slug = Str::slug($request->title);
        // İleride slug unique kontrolü eklemelisin: while(Post::where('slug', $slug)->exists()) { ... }

        Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        // Route isminin doğru olduğundan emin ol (routes.php kontrolü)
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
            if($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('blog', 'public');
        }
        
        // Slug güncellemek istersen buraya ekleyebilirsin ama genelde SEO için sabit kalır.

        $post->update($data);

        return redirect()->route('admin.blog.posts.index')->with('success', 'Güncellendi.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->image) {
             Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('admin.blog.posts.index');
    }
}