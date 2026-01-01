@if($posts->isNotEmpty())
<section class="mt-12 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl md:text-2xl font-bold text-slate-800 flex items-center gap-2">
            <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg text-lg">✍️</span>
            {{ $title }}
        </h2>
        <a href="{{ route('blog.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition">
            Tümünü Gör <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <article class="bg-white rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full group">
            <a href="{{ route('blog.show', $post->slug) }}" class="relative h-48 overflow-hidden">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="{{ $post->title }}">
                @else
                    <div class="w-full h-full bg-slate-50 flex items-center justify-center text-3xl">📝</div>
                @endif
                
                @if($post->category)
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-[10px] font-bold px-2 py-1 rounded text-indigo-900 uppercase tracking-wide shadow-sm">
                        {{ $post->category->name }}
                    </span>
                @endif
            </a>
            
            <div class="p-5 flex flex-col flex-grow">
                <div class="text-xs text-slate-400 mb-3 flex items-center gap-2 border-b border-slate-50 pb-3">
                    <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $post->created_at->translatedFormat('d M') }}</span>
                    <span>•</span>
                    <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ number_format($post->view_count) }}</span>
                </div>

                <h3 class="font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-indigo-600 transition text-lg">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h3>

                <p class="text-sm text-slate-500 line-clamp-2 mb-4 leading-relaxed">
                    {{ Str::limit(strip_tags($post->content), 90) }}
                </p>

                <div class="mt-auto">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider flex items-center gap-1">
                        Oku <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endif