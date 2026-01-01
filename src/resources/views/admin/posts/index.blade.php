@extends('blog-core::admin.layout')

@section('content')
<div class="bg-white shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Blog Yazıları</h2>
            <a href="{{ route('admin.blog.posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                + Yeni Yazı Ekle
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Başlık</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Okunma</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="h-10 w-10 rounded object-cover">
                            @else
                                <span class="h-10 w-10 rounded bg-gray-200 block"></span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($post->slug, 20) }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->category)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $post->category->name }}
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Genel
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $post->created_at->translatedFormat('d M Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.blog.posts.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Düzenle</a>
                            
                            <form action="{{ route('admin.blog.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Bu yazıyı silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Sil</button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm text-gray-900">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($post->view_count) }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Henüz hiç yazı eklenmemiş.
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