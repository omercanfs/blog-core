<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal">

    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('blog.index') }}" class="text-xl font-bold text-gray-800">
                Blog
            </a>
            <a href="/" class="text-gray-600 hover:text-gray-900">Ana Sayfaya Dön</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>

    <footer class="bg-white border-t border-gray-200 mt-12 py-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} Tüm hakları saklıdır.
    </footer>

</body>
</html>