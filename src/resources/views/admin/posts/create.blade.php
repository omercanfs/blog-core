@extends('blog-core::admin.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Yeni Blog Yazısı Ekle</h2>
        <a href="{{ route('admin.blog.posts.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Listeye Dön</a>
    </div>

    <form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <select name="category_id" class="border rounded w-full py-2 px-3">
                <option value="">Kategori Seçin</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kapak Resmi</label>
            <input type="file" name="image" class="border rounded w-full py-2 px-3">
        </div>

    </form>
</div>
@endsection