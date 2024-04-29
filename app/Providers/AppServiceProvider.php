<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('has_at_least_one_value', function ($attribute, $value, $parameters) {
            if (!is_array($value)) {
                return false;
            }

            return array_filter($value, function ($item) {
                return !is_null($item);
            }) !== [];
        });
    }
}
