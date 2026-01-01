<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yönetim Paneli') - BlogCore</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-blog.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#4f46e5', secondary: '#1e293b' }
                }
            }
        }
    </script>
    <style>
        .cke_chrome { border-color: #e2e8f0 !important; border-radius: 0.5rem !important; overflow: hidden; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center gap-8">
                    <a href="{{ route('admin.blog.posts.index') }}" class="flex items-center gap-2 group">
                        <div class="bg-indigo-600 text-white p-1.5 rounded-lg group-hover:bg-indigo-700 transition shadow-md shadow-indigo-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800 tracking-tight leading-none">Blog<span class="text-indigo-600">Core</span></span>
                            <span class="text-[10px] text-slate-400 font-medium">YÖNETİM PANELİ</span>
                        </div>
                    </a>

                    <div class="hidden sm:flex space-x-1">
                        <a href="{{ route('admin.blog.posts.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.blog.posts.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            Yazılar
                        </a>
                        <a href="{{ route('admin.blog.categories.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.blog.categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            Kategoriler
                        </a>
                    </div>
                </div>

                <div class="hidden sm:flex items-center gap-4">
                    <a href="{{ url('/admin/dashboard') }}" target="_blank" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 flex items-center gap-1 transition">
                        Süper Admin
                    </a>
                    <span class="text-slate-300">|</span>
                    <a href="{{ url('/blog') }}" target="_blank" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 flex items-center gap-1 transition">
                        Blog'a Git &rarr;
                    </a>
                </div>

                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Menüyü Aç</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="hidden sm:hidden bg-white border-t border-slate-100" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('admin.blog.posts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.blog.posts.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    📝 Yazılar
                </a>
                <a href="{{ route('admin.blog.categories.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.blog.categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    🏷️ Kategoriler
                </a>
                
                <div class="border-t border-slate-100 my-2 pt-2">
                    <a href="{{ url('/blog') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium text-slate-500 hover:text-indigo-600">
                        🌍 Blog Sayfasını Gör
                    </a>
                    <a href="{{ url('/admin/dashboard') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium text-slate-500 hover:text-indigo-600">
                        🔐 Süper Admin Paneli
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-8">
        <main class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4"> @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm" role="alert">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }
    </script>

</body>
</html>