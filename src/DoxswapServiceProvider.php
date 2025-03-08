<?php

declare(strict_types=1);

namespace Blaspsoft\Doxswap;

use Blaspsoft\Doxswap\Doxswap;
use Illuminate\Support\ServiceProvider;
use Blaspsoft\Doxswap\ConversionService;

class DoxswapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('doxswap.php'),
            ], 'doxswap-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'doxswap');

        $this->app->bind('doxswap', function () {
            new ConversionService(
                config('libre_office_path'),
                config('libre_office_args'),
            );
        });
    }
}
