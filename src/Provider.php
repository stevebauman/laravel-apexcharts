<?php

namespace Akaunting\Apexcharts;

use Akaunting\Apexcharts\Charts;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias(Charts::class, 'apexcharts');

        $this->mergeConfigFrom(__DIR__ . '/Config/apexcharts.php', 'apexcharts');
    }

    /**
     * When this method is apply we have all laravel providers and methods available
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'apexcharts');

        $this->publishes([
            __DIR__ . '/Config/apexcharts.php'  => config_path('apexcharts.php'),
            __DIR__ . '/Public'                 => public_path('vendor/apexcharts'),
            __DIR__ . '/Views'                  => resource_path('views/vendor/apexcharts'),
        ], 'apexcharts');

        $this->registerBladeDirectives();
    }

    public function registerBladeDirectives()
    {
        Blade::directive('apexchartsScripts', function ($expression) {
            return '{!! \Akaunting\Apexcharts\Charts::loadScript(' . $expression . ') !!}';
        });
    }
}