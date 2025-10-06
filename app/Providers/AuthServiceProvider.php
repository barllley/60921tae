<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        Gate::define('is-admin', function (User $user) {
            return $user->is_admin === 1;
        });

        Gate::define('manage-tickets', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('manage-exhibitions', function (User $user) {
            return $user->is_admin;
        });
    }
}
