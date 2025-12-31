<?php

namespace Omercanfs\BlogCore\Http\Controllers;

use Illuminate\Routing\Controller;
use Omercanfs\BlogCore\Models\Post;
use Omercanfs\BlogCore\Models\Category;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(9);
        $categories = Category::all(); // Sidebar için
        
        return view('blog-core::front.index', compact('posts', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Sadece bu kategoriye ait yazılar
        $posts = $category->posts()->latest()->paginate(9);
        $categories = Category::all();

        return view('blog-core::front.index', compact('posts', 'categories', 'category'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('blog-core::front.show', compact('post'));
    }
}