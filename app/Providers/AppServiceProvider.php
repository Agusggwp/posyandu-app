<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
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
        Event::listen(Login::class, function (Login $event): void {
            $actor = $event->user;

            if (! $actor) {
                return;
            }

            $isStaffUser = $actor instanceof User;
            $actorName = $actor->name ?? $actor->nama_lengkap ?? $actor->email ?? ('ID ' . $actor->id);
            $actorType = $isStaffUser ? 'User' : class_basename($actor);

            try {
                ActivityLog::create([
                    'user_id' => $isStaffUser ? $actor->id : null,
                    'action' => 'login',
                    'model' => $actorType,
                    'model_id' => $actor->id,
                    'description' => $actorType . ' login: ' . $actorName,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } catch (\Throwable $e) {
                // Never break authentication flow due to logging issues.
            }
        });

        Event::listen(Logout::class, function (Logout $event): void {
            if (! $event->user) {
                return;
            }

            $actor = $event->user;
            $isStaffUser = $actor instanceof User;
            $actorName = $actor->name ?? $actor->nama_lengkap ?? $actor->email ?? ('ID ' . $actor->id);
            $actorType = $isStaffUser ? 'User' : class_basename($actor);

            try {
                ActivityLog::create([
                    'user_id' => $isStaffUser ? $actor->id : null,
                    'action' => 'logout',
                    'model' => $actorType,
                    'model_id' => $actor->id,
                    'description' => $actorType . ' logout: ' . $actorName,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } catch (\Throwable $e) {
                // Never break authentication flow due to logging issues.
            }
        });

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
