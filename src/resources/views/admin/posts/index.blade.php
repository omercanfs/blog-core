@extends('blog-core::admin.layout')

@section('content')
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Yazı başlığı ara..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <div>
                    <select name="category_id" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-gray-600">
                        <option value="">Tüm Kategoriler</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="sort" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:ring-blue-500 focus:border-blue-500 text-gray-600">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>En Yeni</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>En Eski</option>
                        <option value="view_desc" {{ request('sort') == 'view_desc' ? 'selected' : '' }}>Çok Okunanlar 🔥</option>
                        <option value="view_asc" {{ request('sort') == 'view_asc' ? 'selected' : '' }}>Az Okunanlar</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-slate-800 text-white py-2 px-4 rounded-lg hover:bg-slate-900 transition flex items-center justify-center gap-2">
                        Filtrele
                    </button>
                    @if(request()->anyFilled(['search', 'category_id', 'sort']))
                        <a href="{{ route('admin.blog.posts.index') }}" class="bg-gray-200 text-gray-600 p-2 rounded-lg hover:bg-gray-300 flex items-center justify-center" title="Filtreleri Temizle">
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tarih</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Okunma</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="h-12 w-16 rounded object-cover shadow-sm border border-gray-100">
                            @else
                                <span class="h-12 w-16 rounded bg-gray-100 flex items-center justify-center text-xl border border-gray-200">📝</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $post->title }}</div>
                            <div class="text-xs text-gray-500 font-mono mt-0.5">{{ Str::limit($post->slug, 25) }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->category)
                                <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $post->category->name }}
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full bg-gray-100 text-gray-600">
                                    Genel
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $post->created_at->translatedFormat('d M Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm font-medium text-gray-700 bg-gray-50 px-2 py-1 rounded w-fit">
                                <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($post->view_count) }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.blog.posts.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded hover:bg-indigo-100 transition" title="Düzenle">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                
                                <form action="{{ route('admin.blog.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Bu yazıyı silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded hover:bg-red-100 transition" title="Sil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-4xl mb-2">🔍</span>
                                <span class="font-medium">Sonuç bulunamadı</span>
                                <span class="text-sm text-gray-400">Arama kriterlerinizi değiştirip tekrar deneyin.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection