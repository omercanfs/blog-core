<?php

use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Http\Controllers\Admin\PostController;

Route::get('/blog-test', function () {
    return [];
});

Route::prefix('admin/blog')->group(function () {

    Route::get('/posts', [PostController::class, 'index'])
        ->name('admin.blog.posts.index');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('admin.blog.posts.store');

});



