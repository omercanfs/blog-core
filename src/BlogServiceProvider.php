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
        // Web Rotaları (Varsa)
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Admin Rotaları - BURAYI DEĞİŞTİRDİK 👇
        // loadRoutesFrom yerine Route::middleware... kullanıyoruz.
        if (file_exists(__DIR__.'/routes/admin.php')) {
            Route::middleware(['web']) // Web grubu (Session, Errors, CSRF)
                 ->group(__DIR__ . '/routes/admin.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'blog-core');
    }
}