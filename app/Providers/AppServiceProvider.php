<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Blade Directives for Permission Check
        \Illuminate\Support\Facades\Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        \Illuminate\Support\Facades\Blade::if('kader', function () {
            return auth()->check() && auth()->user()->isKader();
        });

        \Illuminate\Support\Facades\Blade::if('bidan', function () {
            return auth()->check() && auth()->user()->isBidan();
        });

        \Illuminate\Support\Facades\Blade::if('haspermission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });
    }
}
