@extends('blog-core::admin.layout')

@section('title', 'Yeni Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.blog.categories.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-800 mb-4 transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kategorilere Dön
    </a>

    <div class="bg-white shadow-lg shadow-slate-200/50 rounded-xl overflow-hidden border border-slate-100">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xl font-bold text-slate-800">Yeni Kategori Ekle</h2>
            <p class="text-sm text-slate-500">Sitenizde içerikleri gruplamak için yeni bir alan oluşturun.</p>
        </div>

        <form action="{{ route('admin.blog.categories.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Adı</label>
                <input type="text" name="name" id="nameInput" placeholder="Örn: Teknoloji Haberleri" 
                       class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 flex justify-between">
                    Slug (URL Yapısı)
                    <span class="text-xs font-normal text-slate-400">Otomatik oluşturulur</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-slate-400 text-sm font-mono">/</span>
                    <input type="text" name="slug" id="slugInput" placeholder="teknoloji-haberleri" 
                           class="w-full pl-6 border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 font-mono text-sm shadow-sm transition">
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Basit Slug Oluşturucu
    const nameInput = document.getElementById('nameInput');
    const slugInput = document.getElementById('slugInput');

    nameInput.addEventListener('input', function() {
        let text = this.value;
        let slug = text.toLowerCase()
            .replace(/ğ/g, 'g')
            .replace(/ü/g, 'u')
            .replace(/ş/g, 's')
            .replace(/ı/g, 'i')
            .replace(/ö/g, 'o')
            .replace(/ç/g, 'c')
            .replace(/[^a-z0-9\s-]/g, '') // Harf rakam boşluk tire dışındakileri sil
            .replace(/\s+/g, '-')         // Boşlukları tire yap
            .replace(/-+/g, '-');         // Çoklu tireleri tek tire yap
        
        slugInput.value = slug;
    });
</script>
@endsection