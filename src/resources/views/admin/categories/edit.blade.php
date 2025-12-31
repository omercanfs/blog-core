@extends('blog-core::admin.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Yazıyı Düzenle: {{ $post->name }}</h2>
        <a href="{{ route('admin.blog.posts.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Listeye Dön</a>
    </div>

    <form method="POST" action="{{ route('admin.blog.posts.update', ['post' => $post->id]) }}" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Başlık</label>
            <input type="text" name="name" id="name" value="{{ old('name', $post->name) }}" required
                   class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="content">İçerik</label>
            <textarea name="content" id="content" rows="10" required
                      class="shadow-sm border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.blog.posts.index') }}" class="text-gray-600 hover:text-gray-800">İptal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Güncelle
            </button>
        </div>
    </form>
</div>
@endsection