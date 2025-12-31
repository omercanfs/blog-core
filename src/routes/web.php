<?php

use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Http\Controllers\BlogController;

// Bu grup sadece 'web' middleware kullanır.
// 'auth' YOKTUR, çünkü burası herkese açıktır.
Route::middleware(['web'])
    ->group(function () {
        
        Route::get('/blog', [BlogController::class, 'index'])
            ->name('blog.index');

        Route::get('/blog/{slug}', [BlogController::class, 'show'])
            ->name('blog.show');
    });