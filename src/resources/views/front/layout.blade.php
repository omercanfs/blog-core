<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-blog.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm backdrop-blur-md bg-white/90">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                
               <a href="{{ route('blog.index') }}" class="flex items-center gap-2 group">
    
                    <div class="bg-indigo-600 text-white p-1.5 rounded-lg group-hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16v16H4z"/>
                            <path d="M8 8h8"/>
                            <path d="M8 12h8"/>
                            <path d="M8 16h5"/>
                        </svg>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xl font-bold text-slate-800 leading-none tracking-tight">
                            <span class="text-indigo-600">Blog</span>{{ config('app.name', 'DijitalKöy'); }}
                        </span>
                        <span class="text-[10px] text-slate-400 font-medium tracking-wide">GÜNCEL İÇERİKLER</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Ana Site</a>
                    <a href="{{ route('blog.index') }}" class="text-sm font-medium text-blue-600">Blog Anasayfa</a>
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md text-slate-600 hover:bg-slate-100 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-collapse class="md:hidden bg-white border-t border-slate-100 shadow-lg">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ route('blog.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 bg-blue-50">Blog Anasayfa</a>
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900">Ana Siteye Dön</a>
                
                <div class="border-t border-slate-100 my-2 pt-2">
                    <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kategoriler</p>
                    @if(isset($categories))
                        @foreach($categories as $cat)
                            @if($cat->posts_count > 0)
                                <a href="{{ route('blog.category', $cat->slug) }}" class="flex justify-between items-center px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">{{ $cat->posts_count }}</span>
                                </a>
                            @endif
                            @endforeach
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </div>

    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <p class="font-bold text-slate-800"><span class="text-indigo-600">Blog</span>{{ config('app.name', 'DijitalKöy'); }}</p>
                    <p class="text-sm text-slate-500 mt-1">Güncel yazılarımız ve haberlerimizden haberdar olun.</p>
                </div>
                <div class="text-sm text-slate-400">
                    &copy; {{ date('Y') }} Tüm hakları saklıdır.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>