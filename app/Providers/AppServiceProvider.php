<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

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
        Blade::if('admin', function () {
            return Auth::user()?->isAdmin() ?? false;
        });
        Blade::if('teacher', function () {
            return Auth::user()?->isAdmin() ?? false;
        });
        Blade::if('student', function () {
            return Auth::user()?->isAdmin() ?? false;
        });
        Blade::if('role', function (string|array $role) {
            if (is_array($role)) return Auth::user()?->hasRole(...$role) ?? false;
            return Auth::user()?->hasRole(...$role) ?? false;
        });
    }
}
