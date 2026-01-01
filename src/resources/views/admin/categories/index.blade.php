@extends('blog-core::admin.layout')

@section('title', 'Kategoriler')

@section('content')
<div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/50">
        <div>
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg text-lg">🏷️</span>
                Kategoriler
            </h2>
            <p class="text-sm text-slate-500 mt-1">Blog yazılarınızı gruplandırın ve düzenleyin.</p>
        </div>
        <a href="{{ route('admin.blog.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-lg shadow-indigo-200 transition flex items-center gap-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Yeni Kategori Ekle
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori Adı</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Slug (URL)</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Yazı Sayısı</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($categories as $category)
                <tr class="hover:bg-slate-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3 text-sm">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                            <div class="text-sm font-bold text-slate-800">{{ $category->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="bg-slate-100 text-slate-600 py-1 px-2 rounded text-xs font-mono border border-slate-200">
                            /{{ $category->slug }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        {{-- Eğer controllerda withCount('posts') kullandıysan burası çalışır, yoksa boş geçer --}}
                        {{ $category->posts_count ?? '-' }} Yazı
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 p-2 hover:bg-indigo-50 rounded-lg transition" title="Düzenle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz? Altındaki yazılar kategorisiz kalacaktır.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-900 p-2 hover:bg-rose-50 rounded-lg transition" title="Sil">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            <span class="text-lg font-medium text-slate-600">Henüz Kategori Yok</span>
                            <p class="text-sm mt-1 mb-4">Blog yazılarınızı düzenlemek için ilk kategorinizi ekleyin.</p>
                            <a href="{{ route('admin.blog.categories.create') }}" class="text-indigo-600 hover:underline font-medium">Kategori Ekle &rarr;</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection