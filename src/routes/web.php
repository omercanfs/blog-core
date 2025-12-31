<?php
use Illuminate\Support\Facades\Route;
use Omercanfs\BlogCore\Http\Controllers\Admin\PostController;
use Omercanfs\BlogCore\Http\Controllers\Admin\CategoryController; // YENİ
use Omercanfs\BlogCore\Http\Controllers\BlogController;

// 1. ZİYARETÇİ (Public)
Route::middleware(['web'])->group(function () {
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    // Kategori Filtreleme Rotası
    Route::get('/blog/kategori/{slug}', [BlogController::class, 'category'])->name('blog.category'); 
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
});

// 2. ADMİN
Route::middleware(['web', 'auth', 'can:view-blog-admin'])
    ->prefix('admin/blog')
    ->name('admin.blog.')
    ->group(function () {
        
        // Post Rotaları (Aynı kalıyor...)
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

        // 👇 KATEGORİ ROTALARI (YENİ)
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });