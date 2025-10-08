<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate для проверки администратора
        Gate::define('admin-access', function ($user) {
            return $user && $user->is_admin == 1;
        });

        // Gate для управления пользователями
        Gate::define('manage-users', function ($user) {
            return $user && $user->is_admin == 1;
        });

        // Gate для управления выставками (CRUD)
        Gate::define('manage-exhibitions', function ($user) {
            return $user && $user->is_admin == 1;
        });

        // Gate для управления билетами (CRUD)
        Gate::define('manage-tickets', function ($user) {
            return $user && $user->is_admin == 1;
        });

        // Gate для доступа к оформлению заказа (только авторизованные)
        Gate::define('access-checkout', function ($user) {
            return $user !== null; // Только авторизованные
        });

        // Gate для редактирования своего профиля
        Gate::define('edit-profile', function ($user, $targetUser) {
            return $user && ($user->id === $targetUser->id || $user->is_admin == 1);
        });
    }
}
