@extends('blog-core::front.layout')

@section('title', 'Son Yazılar')

@section('content')
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Blog Yazıları</h1>
        <p class="text-gray-600">Güncel teknoloji ve yazılım dünyasından haberler.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-indigo-500 w-full"></div>
                
                <div class="p-6">
                    <span class="text-xs font-semibold text-blue-600 uppercase">Yazı</span>
                    <h2 class="mt-2 text-xl font-bold text-gray-800 hover:text-blue-600 transition">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="mt-2 text-gray-600 text-sm">
                        {{ Str::limit(strip_tags($post->content), 100) }}...
                    </p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ $post->created_at->translatedFormat('d F Y') }}</span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Oku &rarr;</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection