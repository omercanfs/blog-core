<?php

namespace Omercanfs\BlogCore;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; // 👈 İŞTE BU SATIR EKSİKTİ!

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Web Rotaları (Varsa)
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Admin Rotaları
        if (file_exists(__DIR__.'/routes/admin.php')) {
            Route::middleware(['web']) // Artık hata vermez
                 ->group(__DIR__ . '/routes/admin.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'blog-core');
    }
}