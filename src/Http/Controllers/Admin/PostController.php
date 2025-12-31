<?php

namespace Omercanfs\BlogCore\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Omercanfs\BlogCore\Models\Post;
use Omercanfs\BlogCore\Models\Category; // Eklendi

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        return view('blog-core::admin.posts.index', compact('posts'));
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