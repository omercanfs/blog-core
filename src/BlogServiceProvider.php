<?php

namespace Omercanfs\BlogCore;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Config dosyası varsa burada merge edilir (şimdilik gerek yok)
    }

    public function boot()
    {
        // Rotaları yükle
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        
        if (file_exists(__DIR__.'/routes/admin.php')) {
            $this->loadRoutesFrom(__DIR__.'/routes/admin.php');
        }

        // Migrationları yükle
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Viewları yükle (NAMESPACE: blog-core)
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'blog-core');
    }
}