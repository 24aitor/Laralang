<?php

namespace Aitor24\Laralang;

use Illuminate\Support\ServiceProvider;

class LaralangServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }
        
        $this->publishes([
            __DIR__.'/../config/laralang.php' => config_path('laralang.php'),
        ], 'laralang_config');

        $this->loadTranslationsFrom(__DIR__.'/translations', 'laralang');
        $this->loadMigrationsFrom(__DIR__.'/Migrations', 'laralang');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralang');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
