@extends('blog-core::admin.layout')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-center justify-between group hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Toplam İçerik</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ number_format($stats['total_posts']) }}</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl group-hover:scale-110 transition">📝</div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-center justify-between group hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Aktif Kategoriler</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ number_format($stats['total_categories']) }}</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl group-hover:scale-110 transition">🏷️</div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-center justify-between group hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Toplam Okunma</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ number_format($stats['total_views']) }}</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl group-hover:scale-110 transition">👁️</div>
    </div>
</div>

<div class="bg-white shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-gray-800">Blog Yazıları</h2>
            <a href="{{ route('admin.blog.posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Yeni Yazı Ekle
            </a>
        </div>

        <form action="{{ route('admin.blog.posts.index') }}" method="GET" class="bg-slate-50 p-4 rounded-xl mb-6 border border-slate-200">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4"> <div class="relative md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Yazı başlığı ara..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <div>
                    <select name="status" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-gray-600">
                        <option value="">Tüm Durumlar</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Yayında (Aktif)</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Taslak (Pasif)</option>
                    </select>
                </div>

                <div>
                    <select name="category_id" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-gray-600">
                        <option value="">Tüm Kategoriler</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-slate-800 text-white py-2 px-4 rounded-lg hover:bg-slate-900 transition flex items-center justify-center gap-2">Filtrele</button>
                    @if(request()->anyFilled(['search', 'category_id', 'sort', 'status']))
                        <a href="{{ route('admin.blog.posts.index') }}" class="bg-gray-200 text-gray-600 p-2 rounded-lg hover:bg-gray-300 flex items-center justify-center" title="Temizle">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>

            </div>
        </form>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Resim</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Başlık</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Durum</th> <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Okunma</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="h-10 w-14 rounded object-cover shadow-sm border border-gray-100">
                            @else
                                <span class="h-10 w-14 rounded bg-gray-100 flex items-center justify-center text-lg border border-gray-200">📝</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $post->title }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $post->created_at->translatedFormat('d M Y') }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->status)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Yayında
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                    Taslak
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ $post->category->name ?? 'Genel' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            👁️ {{ number_format($post->view_count) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.blog.posts.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded hover:bg-indigo-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.blog.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded hover:bg-red-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">Kayıt bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $posts->links() }}</div>
    </div>
</div>
@endsection