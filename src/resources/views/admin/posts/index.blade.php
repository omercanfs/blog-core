<!DOCTYPE html>
<html>
<head>
    <title>Blog Yazıları</title>
</head>
<body>

<h1>Blog Yazıları</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Başlık</th>
        <th>Oluşturulma</th>
    </tr>

    @foreach($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->created_at }}</td>
        </tr>
    @endforeach

</table>

</body>
</html>
