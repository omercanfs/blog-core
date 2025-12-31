<?php

use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Http\Controllers\Admin\PostController;
use Omercanfs\BlogCore\Http\Controllers\BlogController;

Route::middleware(['web'])
    ->group(function () {
        
        Route::get('/blog', [BlogController::class, 'index'])
            ->name('blog.index');

        Route::get('/blog/{slug}', [BlogController::class, 'show'])
            ->name('blog.show');
    });

Route::middleware(['web', 'auth', 'can:view-blog-admin']) // 👈 EKLENEN KISIM: Session ve $errors değişkenini aktif eder
    ->prefix('admin/blog')
    ->name('admin.blog.')
    ->group(function () {

        Route::get('/posts', [PostController::class, 'index'])
            ->name('posts.index');

        Route::get('/posts/create', [PostController::class, 'create'])
            ->name('posts.create');

        Route::post('/posts', [PostController::class, 'store'])
            ->name('posts.store');

        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
            ->name('posts.edit');

        Route::put('/posts/{post}', [PostController::class, 'update'])
            ->name('posts.update');

        Route::delete('/posts/{post}', [PostController::class, 'destroy'])
            ->name('posts.destroy');
    });