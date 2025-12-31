@extends('blog-core::front.layout')

@section('title', $post->title)

@section('content')
    <article class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-sm">
        <div class="mb-6 border-b border-gray-100 pb-6">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
            <div class="flex items-center text-gray-500 text-sm">
                <span>{{ $post->created_at->translatedFormat('d F Y') }}</span>
                <span class="mx-2">•</span>
                <span>Yazar: Admin</span>
            </div>
        </div>

        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($post->content)) !!}
        </div>

        <div class="mt-10 pt-6 border-t border-gray-100">
            <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                &larr; Tüm Yazılara Dön
            </a>
        </div>
    </article>
@endsection