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
        $this->publishes([
            __DIR__.'/../config/laralang.php' => config_path('laralang.php'),
        ], 'laralang_config');
        
        $this->loadTranslationsFrom(__DIR__.'/translations', 'laralang');
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
