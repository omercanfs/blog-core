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
            
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider hidden sm:block">Paylaş:</span>
                
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-black hover:text-white transition" title="X'te Paylaş">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-[#1877F2] hover:text-white transition" title="Facebook'ta Paylaş">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036c-2.148 0-2.971.956-2.971 3.594v.376h3.558l-.46 3.667h-3.098v7.98h-4.843Z"/></svg>
                </a>

                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-[#25D366] hover:text-white transition" title="WhatsApp'ta Paylaş">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </a>

                <div x-data="{ copied: false }">
                    <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-800 hover:text-white transition relative" title="Linki Kopyala">
                        <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        <svg x-show="copied" x-cloak class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        
                        <span x-show="copied" x-transition class="absolute -top-8 left-1/2 -translate-x-1/2 bg-black text-white text-[10px] px-2 py-1 rounded shadow-lg whitespace-nowrap">Kopyalandı!</span>
                    </button>
                </div>
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