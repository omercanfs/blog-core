<?php

use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Models\Post;

Route::get('/blog-test', function () {
    return Post::all();
});
