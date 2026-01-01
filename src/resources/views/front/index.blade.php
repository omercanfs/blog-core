@extends('blog-core::front.layout')

@section('title', isset($category) ? $category->name . ' Yazıları' : 'Blog - Son Yazılar')

@section('content')

<div class="lg:hidden mb-8 -mx-4 px-4 sticky top-16 z-40 bg-slate-50/95 backdrop-blur py-2 border-b border-slate-200">
    <div class="flex overflow-x-auto gap-3 hide-scroll pb-1">
        <a href="{{ route('blog.index') }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition {{ !isset($category) ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200' }}">
            Tümü
        </a>
        @foreach($categories as $cat)
            {{-- SADECE YAZI SAYISI 0'DAN BÜYÜKSE GÖSTER --}}
            @if($cat->posts_count > 0)
                <a href="{{ route('blog.category', $cat->slug) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition {{ (isset($category) && $category->id == $cat->id) ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200' }}">
                    {{ $cat->name }}
                </a>
            @endif
        @endforeach
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
    
    <div class="lg:col-span-3">
        
        <div class="mb-8 pb-4 border-b border-slate-200">
            <h1 class="text-2xl md:text-4xl font-bold text-slate-800 tracking-tight">
                {{ isset($category) ? $category->name : 'Son Yazılar' }}
            </h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base">
                @if(isset($category))
                    "{{ $category->name }}" kategorisindeki içerikler listeleniyor. <a href="{{ route('blog.index') }}" class="text-blue-600 hover:underline font-medium">Tümüne dön</a>
                @else
                    Güncel yazılarımız ve haberlerimizden haberdar olun.
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($posts as $post)
                <article class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
                    <a href="{{ route('blog.show', $post->slug) }}" class="relative block h-56 overflow-hidden">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-slate-200 to-slate-300 flex items-center justify-center">
                                <span class="text-4xl">📝</span>
                            </div>
                        @endif
                        
                        @if($post->category)
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-blue-700 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                {{ $post->category->name }}
                            </span>
                        @endif
                    </a>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center text-xs text-slate-400 mb-3 gap-2">
                            <span class="flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $post->created_at->translatedFormat('d F Y') }}
                            </span>
                        </div>

                        <h2 class="text-lg font-bold text-slate-800 mb-3 leading-snug group-hover:text-blue-600 transition line-clamp-2">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="text-slate-500 text-sm mb-5 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                                Okumaya Başla
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-1 md:col-span-2 text-center py-16 bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                    <div class="text-5xl mb-4">📭</div>
                    <h3 class="text-lg font-bold text-slate-700">Henüz Yazı Yok</h3>
                    <p class="text-slate-500">Bu kategoride henüz içerik eklenmemiş veya yayında değil.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="lg:col-span-1 space-y-8">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 sticky top-24">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                Kategoriler
            </h3>
            <div class="space-y-1">
                <a href="{{ route('blog.index') }}" class="flex justify-between items-center px-3 py-2 rounded-lg text-sm font-medium transition ...">
                    <span>Tümü</span>
                </a>
                
                @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat->slug) }}" class="...">
                        <span>{{ $cat->name }}</span>
                        <span class="text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">
                            {{ $cat->posts_count }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection