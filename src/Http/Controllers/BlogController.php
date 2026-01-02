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

        $sidebarCategories = Category::withCount('activePosts')->get();
    
        // View'a yeni isimle gönderiyoruz
        return view('blog-core::front.index', compact('posts', 'sidebarCategories'));
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
        $sidebarCategories = Category::withCount('activePosts')->get();
        return view('blog-core::front.index', compact('posts', 'sidebarCategories', 'category'));
    }

    // Detay Sayfası
    public function show($slug)
    {
        // 1. Yazıyı bul ama sadece AKTİF ise (Taslaksa 404 verir)
        $post = Post::active()->where('slug', $slug)->firstOrFail();
        
        // Yan menü kategorileri (Sayılar düzeltilmiş)
        $sidebarCategories = Category::withCount('activePosts')->get();

        // Okunma sayısını artır
        $post->increment('view_count');

        // 2. Benzer Yazılar (Sadece AKTİF olanlar gelmeli)
        $relatedPosts = Post::active()
                            ->where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id) // Kendisini hariç tut
                            ->latest()
                            ->take(3)
                            ->get();

        return view('blog-core::front.show', compact('post', 'sidebarCategories', 'relatedPosts'));
    }
}