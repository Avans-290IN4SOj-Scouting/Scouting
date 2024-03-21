<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

use App\Services\ShoppingCartService;
use App\Services\ShoppingCartParser;

class ShoppingCartProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ShoppingCartService::class, function (Application $app) {
            return new ShoppingCartService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // ?
    }
}
