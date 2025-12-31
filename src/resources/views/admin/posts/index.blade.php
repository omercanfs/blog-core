<!DOCTYPE html>
<html>
<head>
    <title>Blog Yazıları</title>
</head>
<body>

<p>
    <a href="/admin/blog/posts/create">+ Yeni Blog Yazısı</a>
</p>

<h1>Blog Yazıları</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Başlık</th>
        <th>Oluşturulma</th>
        <th>İşlem</th>
    </tr>

    @foreach($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>

            <td>{{ $post->title }}</td>

            <td>{{ $post->created_at }}</td>

            <td>
                <a href="/admin/blog/posts/{{ $post->id }}/edit">Düzenle</a>

                <form method="POST"
                      action="/admin/blog/posts/{{ $post->id }}"
                      style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Silmek istediğine emin misin?')">
                        Sil
                    </button>
                </form>
            </td>
        </tr>
    @endforeach

</table>

</body>
</html>
