@extends('blog-core::admin.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-10">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Yeni Blog Yazısı Ekle</h2>
        <a href="{{ route('admin.blog.posts.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Listeye Dön</a>
    </div>

    <form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Başlık</label>
            <input type="text" name="title" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Yazı başlığını girin..." required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="category_id" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Kategori Seçin (Opsiyonel)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kapak Resmi</label>
                <input type="file" name="image" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">İçerik</label>
            <textarea name="content" id="editor" rows="10" class="border rounded w-full py-2 px-3"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Kaydet ve Yayınla
            </button>
        </div>

    </form>
</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    // 'editor' id'li textarea'yı CKEditor'e çevir
    CKEDITOR.replace('editor', {
        height: 400, // Editör yüksekliği
        language: 'tr', // Türkçe dil desteği
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images', // İleride dosya yöneticisi eklersek burası lazım olacak
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    });
</script>
@endsection