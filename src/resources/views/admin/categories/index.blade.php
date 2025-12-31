@extends('blog-core::admin.layout')

@section('content')
<div class="bg-white shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Kategoriler</h2>
            <a href="{{ route('admin.blog.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Yeni Ekle</a>
        </div>

        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">İsim</th>
                    <th class="text-left py-2">Slug</th>
                    <th class="text-right py-2">İşlem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr class="border-b">
                    <td class="py-2">{{ $category->name }}</td>
                    <td class="py-2">{{ $category->slug }}</td>
                    <td class="text-right py-2">
                        <a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="text-blue-600 mr-2">Düzenle</a>
                        <form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Silinsin mi?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Sil</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection