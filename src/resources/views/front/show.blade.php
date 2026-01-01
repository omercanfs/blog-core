@extends('blog-core::front.layout')

@section('title', $post->title)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

    <article class="lg:col-span-3">
        
        @if($post->image)
            <div class="relative w-full h-64 md:h-[450px] rounded-3xl overflow-hidden mb-8 shadow-md">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                     @if($post->category)
                        <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-3 hover:bg-blue-700 transition">
                            {{ $post->category->name }}
                        </a>
                    @endif
                    <h1 class="text-2xl md:text-4xl font-bold text-white leading-tight shadow-black drop-shadow-md">
                        {{ $post->title }}
                    </h1>
                </div>
            </div>
        @else
            <div class="mb-8 border-b border-slate-200 pb-6">
                 @if($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-3">
                        {{ $post->category->name }}
                    </a>
                @endif
                <h1 class="text-3xl md:text-5xl font-bold text-slate-900 leading-tight mb-4">{{ $post->title }}</h1>
            </div>
        @endif

        <div class="flex items-center justify-between text-slate-500 text-sm mb-8 px-1">
            <div class="flex items-center gap-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold mr-2">A</div>
                    <span>Admin</span>
                </div>
                <span class="text-slate-300">•</span>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $post->created_at->translatedFormat('d F Y') }}
                </div>
            </div>
            
            <div class="flex gap-2">
                <button class="text-slate-400 hover:text-blue-600 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></button>
            </div>
        </div>

        <div class="prose prose-lg prose-slate max-w-none text-slate-700 leading-loose">
            {!! $post->content !!}
        </div>

        @if($relatedPosts->count() > 0)
            <div class="mt-16 pt-10 border-t border-slate-200">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-600 rounded-full"></span>
                    Bunlar da İlginizi Çekebilir
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <div class="group">
                            <a href="{{ route('blog.show', $related->slug) }}" class="block h-40 rounded-xl overflow-hidden mb-3 relative">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-3xl">📄</div>
                                @endif
                            </a>
                            <h4 class="font-bold text-slate-800 leading-snug group-hover:text-blue-600 transition">
                                <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                            </h4>
                            <span class="text-xs text-slate-400 mt-1 block">{{ $related->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </article>

    <aside class="lg:col-span-1 space-y-8 mt-10 lg:mt-0">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 sticky top-24">
            <h3 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Kategoriler</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('blog.index') }}" class="flex justify-between items-center text-slate-600 hover:text-blue-600 hover:bg-slate-50 px-2 py-1.5 rounded transition">
                        <span>Tümü</span>
                    </a>
                </li>
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('blog.category', $cat->slug) }}" class="flex justify-between items-center text-slate-600 hover:text-blue-600 hover:bg-slate-50 px-2 py-1.5 rounded transition">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs text-slate-400">({{ $cat->posts_count }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </aside>

</div>
@endsection