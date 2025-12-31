<?php

use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Http\Controllers\Admin\PostController;

Route::prefix('admin/blog')
    ->middleware(['web', 'auth'])
    ->group(function () {

        Route::get('/posts', [PostController::class, 'index']);
        Route::get('/posts/create', [PostController::class, 'create']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
        Route::put('/posts/{post}', [PostController::class, 'update']);
        Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    });
