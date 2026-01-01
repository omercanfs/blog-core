<?php

namespace Omercanfs\BlogCore\Http\Controllers; // Namespace'in Front klasöründe olduğundan emin ol

use Illuminate\Routing\Controller;
use Omercanfs\BlogCore\Models\Post;
use Omercanfs\BlogCore\Models\Category;

class BlogController extends Controller
{
    // Ana Sayfa (Tüm Yazılar)
    public function index()
    {
        // 1. Sadece AKTİF (active) yazıları getir
        $posts = Post::active()
                     ->with('category')
                     ->latest()
                     ->paginate(9);

        // 2. Kategorileri getir ama sayıları sadece YAYINDAKİLER için say
        $categories = Category::withCount('activePosts')
            ->having('active_posts_count', '>', 0) // 0 olanları veritabanından hiç çekme
            ->get();
        
        return view('blog-core::front.index', compact('posts', 'categories'));
    }

    // Kategoriye Göre Filtreleme
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // 1. Kategorinin sadece AKTİF yazılarını getir
        $posts = $category->posts()
                          ->active() // Modeldeki scopeActive çalışır
                          ->with('category')
                          ->latest()
                          ->paginate(9);

        // 2. Yan menü sayılarını yine doğru say
        $categories = Category::withCount('activePosts')
            ->having('active_posts_count', '>', 0) // 0 olanları veritabanından hiç çekme
            ->get();

        return view('blog-core::front.index', compact('posts', 'categories', 'category'));
    }

    // Detay Sayfası
    public function show($slug)
    {
        // 1. Yazıyı bul ama sadece AKTİF ise (Taslaksa 404 verir)
        $post = Post::active()->where('slug', $slug)->firstOrFail();
        
        // Yan menü kategorileri (Sayılar düzeltilmiş)
        $categories = Category::withCount('activePosts')
            ->having('active_posts_count', '>', 0) // 0 olanları veritabanından hiç çekme
            ->get();

        // Okunma sayısını artır
        $post->increment('view_count');

        // 2. Benzer Yazılar (Sadece AKTİF olanlar gelmeli)
        $relatedPosts = Post::active()
                            ->where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id) // Kendisini hariç tut
                            ->latest()
                            ->take(3)
                            ->get();

        return view('blog-core::front.show', compact('post', 'categories', 'relatedPosts'));
    }
}