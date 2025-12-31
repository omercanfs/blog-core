@extends('blog-core::admin.layout')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Yeni Kategori Ekle</h2>

    <form action="{{ route('admin.blog.categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Kategori Adı</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kaydet</button>
    </form>
</div>
@endsection