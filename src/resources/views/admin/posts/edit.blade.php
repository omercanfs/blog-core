@extends('blog-core::admin.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-10">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Yazıyı Düzenle: {{ $post->title }}</h2>
        <div class="flex space-x-2">
            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Görüntüle
            </a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('admin.blog.posts.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Listeye Dön</a>
        </div>
    </div>

    <form action="{{ route('admin.blog.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT') <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Başlık</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="category_id" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Kategori Seçin (Opsiyonel)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kapak Resmi</label>
                
                @if($post->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $post->image) }}" class="h-20 w-auto rounded border p-1">
                        <p class="text-xs text-gray-500 mt-1">Mevcut Resim</p>
                    </div>
                @endif

                <input type="file" name="image" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Değiştirmek istemiyorsanız boş bırakın.</p>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">İçerik</label>
            <textarea name="content" id="editor" rows="10" class="border rounded w-full py-2 px-3">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Güncelle
            </button>
        </div>

    </form>
</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 400,
        language: 'tr',
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    });
</script>
@endsection