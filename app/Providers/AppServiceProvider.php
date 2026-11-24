<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('access-admin-dashboard', function (User $user) {
            return $user->hasRole('administrador');
        });

        Gate::define('access-professor-dashboard', function (User $user) {
            return $user->hasRole('profesor');
        });
    }
}
