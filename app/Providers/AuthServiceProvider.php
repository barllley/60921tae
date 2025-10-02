<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Ticket;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Gate для проверки является ли пользователь администратором
        Gate::define('admin-access', function (?User $user) {
            return $user && strtolower(trim($user->email)) === 'admin@example.com';
        });

        // Gate для проверки может ли пользователь редактировать билет
        Gate::define('edit-ticket', function (?User $user, Ticket $ticket) {
            // Если пользователь не авторизован - доступ запрещен
            if (!$user) {
                return false;
            }

            // Администратор может редактировать любые билеты
            if (strtolower(trim($user->email)) === 'admin@example.com') {
                return true;
            }

        });
    }
}
