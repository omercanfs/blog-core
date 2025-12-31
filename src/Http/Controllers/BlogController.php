<?php

namespace Omercanfs\BlogCore\Http\Controllers;

use Illuminate\Routing\Controller;
use Omercanfs\BlogCore\Models\Post;

class BlogController extends Controller
{
    // Tüm yazıları listele
    public function index()
    {
     
        // En son eklenen en başta (Pagination ekledik ki sayfa şişmesin)
        $posts = Post::latest()->paginate(9); 
        
        return view('blog-core::front.index', compact('posts'));
    }

    // Tekil yazı detayı (Slug ile)
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        return view('blog-core::front.show', compact('post'));
    }
}