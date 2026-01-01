<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Yönetim Paneli</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-main.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6', // İsteğe göre marka rengi
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center font-bold text-xl text-primary">
                        BlogCore Panel
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="{{ route('admin.blog.posts.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium text-gray-900">
                            Yazılar
                        </a>
                        <a href="{{ route('admin.blog.categories.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium text-gray-900">
                            Kategoriler
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ url('/admin/dashboard') }}" target="_blank" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center">
                        <!-- Dashboard / Ev ikonu -->
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9v8a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-8z" />
                        </svg>
                        Admine Dön
                    </a>
                    |
                    <a href="{{ url('/blog') }}" target="_blank" class="text-gray-500 hover:text-gray-700 font-medium text-sm flex items-center">
                        <!-- Blog / Kalem ikonu -->
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                        Siteyi Görüntüle
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="py-10">
        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>