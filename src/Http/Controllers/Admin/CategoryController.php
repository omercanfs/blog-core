<?php

namespace Omercanfs\BlogCore\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Omercanfs\BlogCore\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('blog-core::admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('blog-core::admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:255']);
        
        $slug = Str::slug($request->name);
        // Basit slug kontrolü (Duplicate varsa sonuna sayı ekleme mantığı eklenebilir)
        
        Category::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->route('admin.blog.categories.index')->with('success', 'Kategori eklendi.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('blog-core::admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate(['name' => 'required|max:255']);
        
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.blog.categories.index')->with('success', 'Kategori güncellendi.');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.blog.categories.index')->with('success', 'Kategori silindi.');
    }
}