<?php

use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Http\Controllers\Admin\PostController;

Route::get('/blog-test', function () {
    return [];
});

Route::prefix('admin/blog')->group(function () {

    Route::get('/posts', [PostController::class, 'index'])
        ->name('admin.blog.posts.index');

    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('admin.blog.posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('admin.blog.posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('admin.blog.posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('admin.blog.posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('admin.blog.posts.destroy');
});




