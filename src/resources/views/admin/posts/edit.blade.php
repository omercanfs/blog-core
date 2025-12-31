<!DOCTYPE html>
<html>
<head>
    <title>Blog Düzenle</title>
</head>
<body>

<h1>Blog Düzenle</h1>

<form method="POST" action="/admin/blog/posts/{{ $post->id }}">
    @csrf
    @method('PUT')

    <p>
        <label>Başlık</label><br>
        <input type="text" name="title" value="{{ $post->title }}">
    </p>

    <p>
        <label>İçerik</label><br>
        <textarea name="content" rows="8">{{ $post->content }}</textarea>
    </p>

    <button type="submit">Güncelle</button>
</form>

</body>
</html>
