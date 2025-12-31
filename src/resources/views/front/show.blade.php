@extends('blog-core::front.layout')

@section('title', $post->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

    <article class="lg:col-span-3">
        
        @if($post->image)
            <div class="w-full h-64 md:h-96 rounded-2xl overflow-hidden mb-8 shadow-sm">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="mb-8">
            @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-3 hover:bg-blue-200 transition">
                    {{ $post->category->name }}
                </a>
            @endif
            
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">{{ $post->title }}</h1>
            
            <div class="flex items-center text-gray-500 text-sm border-b border-gray-100 pb-6">
                <div class="flex items-center mr-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $post->created_at->translatedFormat('d F Y') }}
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Yazar: Admin
                </div>
            </div>
        </div>

        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-12">
            {!! $post->content !!}
        </div>

        <div class="border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-500">Bu yazıyı beğendiniz mi?</p>
        </div>

        @if($relatedPosts->count() > 0)
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Benzer Yazılar</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition">
                            <a href="{{ route('blog.show', $related->slug) }}" class="block h-40 overflow-hidden">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-blue-200"></div>
                                @endif
                            </a>
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800 text-lg mb-2 leading-tight">
                                    <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                                </h4>
                                <span class="text-xs text-gray-500">{{ $related->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </article>

    <div class="lg:col-span-1 hidden lg:block">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Kategoriler</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-blue-600 block p-1">Tümü</a></li>
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('blog.category', $cat->slug) }}" class="flex justify-between text-gray-600 hover:text-blue-600 block p-1">
                            <span>{{ $cat->name }}</span>
                            <span class="text-gray-400 text-xs">({{ $cat->posts_count }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
@endsection