@extends('blog-core::admin.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Yeni Blog Yazısı Ekle</h2>
        <a href="{{ route('admin.blog.posts.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Listeye Dön</a>
    </div>

    <form action="{{ route('admin.blog.posts.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Başlık</label>
            <input type="text" name="title" id="title" required
                   class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                   placeholder="Blog yazısının başlığı...">
            @error('title')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="content">İçerik</label>
            <textarea name="content" id="content" rows="10" required
                      class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                      placeholder="Yazı içeriği buraya..."></textarea>
            @error('content')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Kaydet ve Yayınla
            </button>
        </div>
    </form>
</div>
@endsection