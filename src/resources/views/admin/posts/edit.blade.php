@extends('blog-core::admin.layout')

@section('title', 'Yazıyı Düzenle')

@section('content')
<form action="{{ route('admin.blog.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="flex flex-col md:flex-row gap-6">
        
        <div class="w-full md:w-3/4 space-y-6">
            <a href="{{ route('admin.blog.posts.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-800 mb-4 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Blog Listesine Dön
            </a>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Yazı Başlığı</label>
                    <span class="text-xs text-slate-400 font-mono">Slug: {{ $post->slug }}</span>
                </div>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                       class="w-full text-2xl font-bold text-slate-800 border-0 border-b-2 border-slate-100 focus:border-indigo-500 focus:ring-0 px-0 py-2 placeholder-slate-300 transition" required>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <textarea name="content" id="editor" rows="20">{{ old('content', $post->content) }}</textarea>
            </div>

        </div>

        <div class="w-full md:w-1/4 space-y-6">
            <br>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 sticky top-24">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Durum & Yayın</h3>
                
                <div class="flex flex-col gap-3 mb-4">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Güncelle
                    </button>

                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="w-full bg-white border border-slate-300 text-slate-700 font-medium py-2 px-4 rounded-lg hover:bg-slate-50 transition text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Sitede Gör
                    </a>
                </div>
                
                <div class="text-xs text-slate-400 text-center">
                    Son güncelleme:<br> {{ $post->updated_at->diffForHumans() }}
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800 mb-4 text-sm">Kategori</h3>
                <select name="category_id" class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Seçiniz</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800 mb-4 text-sm">Kapak Resmi</h3>
                
                <div class="border-2 border-dashed border-slate-200 rounded-lg p-2 mb-3 text-center cursor-pointer hover:bg-slate-50 transition relative group" onclick="document.getElementById('imageInput').click()">
                    <img id="imagePreview" 
                         src="{{ $post->image ? asset('storage/' . $post->image) : '' }}" 
                         class="{{ $post->image ? '' : 'hidden' }} w-full h-32 object-cover rounded-md">
                    
                    <div id="uploadPlaceholder" class="{{ $post->image ? 'hidden' : '' }} py-4">
                        <div class="text-slate-400 mb-1">📷</div>
                        <span class="text-xs text-slate-500 font-medium">Değiştirmek için tıkla</span>
                    </div>

                    @if($post->image)
                    <div class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center rounded-md">
                        <span class="text-white text-xs font-bold">Resmi Değiştir</span>
                    </div>
                    @endif
                </div>

                <input type="file" name="image" id="imageInput" class="hidden" onchange="previewImage(this)">
                @if($post->image)
                    <p class="text-[10px] text-slate-400 text-center">Mevcut resim yüklü.</p>
                @endif
            </div>

        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 500,
        language: 'tr'
    });

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