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
        // Register Gates for Permissions
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            // Admin has all permissions
            if ($user->isAdmin()) {
                return true;
            }
        });

        // Define gates for each permission
        \Illuminate\Support\Facades\Gate::define('manage_users', function ($user) {
            return $user->hasPermission('manage_users');
        });

        \Illuminate\Support\Facades\Gate::define('manage_keluarga', function ($user) {
            return $user->hasPermission('manage_keluarga');
        });

        \Illuminate\Support\Facades\Gate::define('manage_balita', function ($user) {
            return $user->hasPermission('manage_balita');
        });

        \Illuminate\Support\Facades\Gate::define('manage_ibu_hamil', function ($user) {
            return $user->hasPermission('manage_ibu_hamil');
        });

        \Illuminate\Support\Facades\Gate::define('manage_lansia', function ($user) {
            return $user->hasPermission('manage_lansia');
        });

        \Illuminate\Support\Facades\Gate::define('manage_pemeriksaan', function ($user) {
            return $user->hasPermission('manage_pemeriksaan');
        });

        \Illuminate\Support\Facades\Gate::define('edit_pemeriksaan', function ($user) {
            return $user->hasPermission('edit_pemeriksaan');
        });

        \Illuminate\Support\Facades\Gate::define('view_data', function ($user) {
            return $user->hasPermission('view_data');
        });

        \Illuminate\Support\Facades\Gate::define('view_reports', function ($user) {
            return $user->hasPermission('view_reports');
        });

        \Illuminate\Support\Facades\Gate::define('delete_data', function ($user) {
            return $user->hasPermission('delete_data');
        });

        \Illuminate\Support\Facades\Gate::define('export_data', function ($user) {
            return $user->hasPermission('export_data');
        });

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
