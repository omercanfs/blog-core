@extends('blog-core::front.layout')

@section('title', isset($category) ? $category->name . ' Yazıları' : 'Blog')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
    
    <div class="lg:col-span-3">
        
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h1 class="text-3xl font-bold text-gray-800">
                {{ isset($category) ? $category->name : 'Son Yazılar' }}
            </h1>
            @if(isset($category))
                <p class="text-gray-500 mt-1">Bu kategorideki yazılar listeleniyor.</p>
                <a href="{{ route('blog.index') }}" class="text-sm text-blue-500 hover:underline mt-2 inline-block">&larr; Tümüne Dön</a>
            @else
                <p class="text-gray-500 mt-1">Güncel teknoloji ve yazılım dünyasından haberler.</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($posts as $post)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 border border-gray-100 overflow-hidden flex flex-col h-full">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden h-56 relative group">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-2xl">
                                {{ substr($post->title, 0, 1) }}
                            </div>
                        @endif
                        
                        @if($post->category)
                            <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-bold text-blue-600 rounded-full shadow-sm">
                                {{ $post->category->name }}
                            </span>
                        @endif
                    </a>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-xs text-gray-400 mb-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $post->created_at->translatedFormat('d F Y') }}
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mb-3 leading-snug">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600 transition">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>

                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center text-blue-600 font-semibold text-sm hover:text-blue-800 transition">
                            Devamını Oku 
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-10 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-lg">Bu kategoride henüz yazı bulunmuyor.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Kategoriler</h3>
            
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('blog.index') }}" class="flex justify-between items-center p-2 rounded hover:bg-gray-50 transition {{ !isset($category) ? 'text-blue-600 font-bold bg-blue-50' : 'text-gray-600' }}">
                        <span>Tümü</span>
                    </a>
                </li>
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('blog.category', $cat->slug) }}" class="flex justify-between items-center p-2 rounded hover:bg-gray-50 transition {{ (isset($category) && $category->id == $cat->id) ? 'text-blue-600 font-bold bg-blue-50' : 'text-gray-600' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs bg-gray-100 text-gray-500 py-0.5 px-2 rounded-full">{{ $cat->posts_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-8 p-4 bg-indigo-50 rounded-lg border border-indigo-100 text-center">
                <p class="text-indigo-800 font-bold text-sm">BlogCore Bülten</p>
                <p class="text-xs text-indigo-600 mt-1">En yeni yazılardan haberdar olmak için takipte kalın.</p>
            </div>
        </div>
    </div>

</div>
@endsection