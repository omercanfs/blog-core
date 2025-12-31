@extends('blog-core::front.layout')

@section('content')
<div class="flex flex-col md:flex-row gap-8">
    
    <div class="w-full md:w-3/4">
        <h1 class="text-3xl font-bold mb-6">
            {{ isset($category) ? $category->name . ' Kategorisi' : 'Tüm Yazılar' }}
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                
                <div class="p-4">
                    @if($post->category)
                        <span class="text-xs font-bold text-blue-600 uppercase">{{ $post->category->name }}</span>
                    @endif

                    <h2 class="text-xl font-bold mt-2">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-500 text-sm mt-3 inline-block">Devamını Oku &rarr;</a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8">{{ $posts->links() }}</div>
    </div>

    <div class="w-full md:w-1/4">
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-xl font-bold mb-4">Kategoriler</h3>
            <ul>
                <li><a href="{{ route('blog.index') }}" class="block py-1 hover:text-blue-600">Tüm Yazılar</a></li>
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('blog.category', $cat->slug) }}" class="block py-1 hover:text-blue-600">
                            {{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
@endsection