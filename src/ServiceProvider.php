<?php

/**
 * Created by PhpStorm.
 * User: baymax
 * Date: 2018/11/19
 * Time: 19:18
 */

namespace Baymax\LaravelUploadFile;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishes([
            __DIR__ . '/upload-file.php' => config_path('upload-file.php'),
        ]);

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/upload-file.php', 'upload-file'
        );
    }
}
