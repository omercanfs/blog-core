<?php

namespace Omercanfs\BlogCore;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if (file_exists(__DIR__.'/routes/admin.php')) {
            $this->loadRoutesFrom(__DIR__.'/routes/admin.php');
        }

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }


}
