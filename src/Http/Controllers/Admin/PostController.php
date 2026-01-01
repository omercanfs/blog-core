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
        // filled() yerine doğrudan boşluk kontrolü yapıyoruz.
        // Çünkü "0" değeri filled fonksiyonunda false dönebilir.
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
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

  // STORE METODU İÇİN DE AYNISINI YAPMAYI UNUTMA
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required',
            'category_id' => 'nullable|exists:blog_categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Slug oluştur
        $data['slug'] = Str::slug($request->title);
        
        // Status ekle
        $data['status'] = $request->has('status') ? true : false;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        Post::create($data);

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
        
        // 1. Doğrulama (Validate)
        // Dikkat: validate fonksiyonu sadece buradaki alanları $data değişkenine döndürür.
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required',
            'category_id' => 'nullable|exists:blog_categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // 2. CHECKBOX KONTROLÜ (Kritik Nokta Burası)
        // Checkbox işaretliyse request'te 'status' vardır -> true yap
        // İşaretli değilse request'te yoktur -> false yap
        $data['status'] = $request->has('status') ? true : false;

        // 3. Resim İşlemleri
        if ($request->hasFile('image')) {
            if($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('blog', 'public');
        }
        
        // 4. Güncelleme
        $post->update($data);

        return redirect()->route('admin.blog.posts.index')->with('success', 'Yazı güncellendi.');
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