<!DOCTYPE html>
<html>
<head>
    <title>Yeni Blog Yazısı</title>
</head>
<body>

<h1>Yeni Blog Yazısı</h1>

<form method="POST" action="/admin/blog/posts">
    @csrf

    <p>
        <label>Başlık</label><br>
        <input type="text" name="title">
    </p>

    <p>
        <label>İçerik</label><br>
        <textarea name="content" rows="8"></textarea>
    </p>

    <button type="submit">Kaydet</button>
</form>

</body>
</html>
