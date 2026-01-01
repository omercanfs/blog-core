<?php

namespace Omercanfs\BlogCore;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Omercanfs\BlogCore\View\Components\BlogWidget;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // 1. ZİYARETÇİ ROTALARI (Public)
        // src/routes/web.php dosyasını yükler
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // 2. ADMİN ROTALARI (Private)
        // src/routes/admin.php dosyasını yükler
        if (file_exists(__DIR__.'/routes/admin.php')) {
            $this->loadRoutesFrom(__DIR__.'/routes/admin.php');
        }

        // Diğer yüklemeler...
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'blog-core');

        // Bileşeni 'x-blog-widget' olarak kullanabilmek için kaydediyoruz
        Blade::component('blog-widget', BlogWidget::class);
    }
}