<?php

namespace Omercanfs\BlogCore;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Route; // Buna artık burada gerek kalmadı

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Admin rotalarını direkt yüklüyoruz, güvenliği dosyanın içinde sağladık
        if (file_exists(__DIR__.'/routes/admin.php')) {
            $this->loadRoutesFrom(__DIR__.'/routes/admin.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'blog-core');
    }
}