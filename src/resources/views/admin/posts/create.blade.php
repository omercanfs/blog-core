@extends('blog-core::admin.layout')

@section('title', 'Yeni Yazı Ekle')

@section('content')
<form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-3/4 space-y-6">
            <a href="{{ route('admin.blog.posts.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-800 mb-4 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                İptal Et ve Dön
            </a>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Yazı Başlığı</label>
                <input type="text" name="title" class="w-full text-2xl font-bold text-slate-800 border-0 border-b-2 border-slate-100 focus:border-indigo-500 focus:ring-0 px-0 py-2 placeholder-slate-300 transition" placeholder="Buraya bir başlık girin..." required>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <textarea name="content" id="editor" rows="20"></textarea>
            </div>
        </div>

        <div class="w-full md:w-1/4 space-y-6">
            <br>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 sticky top-24">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Yayınlama</h3>
                
                <div class="mb-4 flex items-center justify-between bg-slate-50 p-3 rounded-lg border border-slate-100">
                    <span class="text-sm font-bold text-slate-700">Yayında mı?</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="status" value="1" class="sr-only peer" checked> <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Kaydet ve Yayınla
                </button>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800 mb-4 text-sm">Kategori</h3>
                <select name="category_id" class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Seçiniz</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800 mb-4 text-sm">Kapak Resmi</h3>
                <div class="border-2 border-dashed border-slate-200 rounded-lg p-2 mb-3 text-center cursor-pointer hover:bg-slate-50 transition relative group" onclick="document.getElementById('imageInput').click()">
                    <img id="imagePreview" src="" class="hidden w-full h-32 object-cover rounded-md">
                    <div id="uploadPlaceholder" class="py-4">
                        <div class="text-slate-400 mb-1">📷</div>
                        <span class="text-xs text-slate-500 font-medium">Resim Seçmek İçin Tıkla</span>
                    </div>
                </div>
                <input type="file" name="image" id="imageInput" class="hidden" onchange="previewImage(this)">
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', { height: 500, language: 'tr' });
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('uploadPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection