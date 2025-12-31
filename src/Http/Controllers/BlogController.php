<?php

namespace Omercanfs\BlogCore\Http\Controllers;

use Illuminate\Routing\Controller;
use Omercanfs\BlogCore\Models\Post;
use Omercanfs\BlogCore\Models\Category;

class BlogController extends Controller
{
    // Ana Sayfa (Tüm Yazılar)
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(9);
        $categories = Category::withCount('posts')->get(); // Yan menü için kategoriler ve yazı sayıları
        
        return view('blog-core::front.index', compact('posts', 'categories'));
    }

    // Kategoriye Göre Filtreleme
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $posts = $category->posts()->with('category')->latest()->paginate(9);
        $categories = Category::withCount('posts')->get();

        return view('blog-core::front.index', compact('posts', 'categories', 'category'));
    }

    // Detay Sayfası
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        // Yan menü için kategoriler
        $categories = Category::withCount('posts')->get();

        // Benzer Yazılar (Aynı kategorideki diğer 3 yazı)
        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id) // Kendisini hariç tut
                            ->latest()
                            ->take(3)
                            ->get();

        return view('blog-core::front.show', compact('post', 'categories', 'relatedPosts'));
    }
}