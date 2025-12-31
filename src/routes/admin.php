<?php

use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Http\Controllers\Admin\PostController;

Route::prefix('admin/blog')
    ->name('admin.blog.')
    ->group(function () {

        Route::get('/posts', [PostController::class, 'index'])
            ->name('posts.index');

        Route::get('/posts/create', [PostController::class, 'create'])
            ->name('posts.create');

        Route::post('/posts', [PostController::class, 'store'])
            ->name('posts.store');

        // ID parametresini {id} olarak açıkça belirtelim
        Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
            ->name('posts.edit');

        Route::put('/posts/{id}', [PostController::class, 'update'])
            ->name('posts.update');

        Route::delete('/posts/{id}', [PostController::class, 'destroy'])
            ->name('posts.destroy');
    });