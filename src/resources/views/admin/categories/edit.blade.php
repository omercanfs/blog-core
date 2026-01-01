@extends('blog-core::admin.layout')

@section('title', 'Kategori Düzenle')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.blog.categories.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-800 mb-4 transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        İptal Et ve Dön
    </a>

    <div class="bg-white shadow-lg shadow-slate-200/50 rounded-xl overflow-hidden border border-slate-100">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kategori Düzenle</h2>
                <p class="text-sm text-slate-500">"{{ $category->name }}" kategorisini güncelliyorsunuz.</p>
            </div>
        </div>

        <form action="{{ route('admin.blog.categories.update', $category->id) }}" method="POST" class="p-6 space-y-6">
            @csrf @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Adı</label>
                <input type="text" name="name" value="{{ $category->name }}" id="nameInput"
                       class="w-full border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Slug (URL)</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-slate-400 text-sm font-mono">/</span>
                    <input type="text" name="slug" value="{{ $category->slug }}" id="slugInput"
                           class="w-full pl-6 border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 font-mono text-sm shadow-sm transition">
                </div>
                <p class="text-xs text-amber-600 mt-2 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Dikkat: Slug değişirse eski linkler çalışmayabilir.
                </p>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                    Güncelle
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Edit sayfasında da slug otomasyonu olsun ama kullanıcı elle değiştirirse müdahale etmesin
    const nameInput = document.getElementById('nameInput');
    const slugInput = document.getElementById('slugInput');
    let isSlugManuallyChanged = false;

    slugInput.addEventListener('input', () => { isSlugManuallyChanged = true; });

    nameInput.addEventListener('input', function() {
        if (!isSlugManuallyChanged) {
            let text = this.value;
            let slug = text.toLowerCase()
                .replace(/ğ/g, 'g')
                .replace(/ü/g, 'u')
                .replace(/ş/g, 's')
                .replace(/ı/g, 'i')
                .replace(/ö/g, 'o')
                .replace(/ç/g, 'c')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            slugInput.value = slug;
        }
    });
</script>
@endsection