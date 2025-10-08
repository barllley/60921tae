<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    /**
     * Проверка прав администратора через Gate
     */
    private function checkAdminAccess()
    {
        if (!Gate::allows('admin-access')) {
            return redirect('/exhibitions')->with('error', 'Доступ запрещен. Недостаточно прав.');
        }

        return null;
    }

    /**
     * Главная страница админки
     */
    public function dashboard()
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) {
            return $accessCheck;
        }

        return view('admin.dashboard');
    }

    /**
     * Управление пользователями
     */
    public function users()
    {
        $accessCheck = $this->checkAdminAccess();
        if ($accessCheck) {
            return $accessCheck;
        }

        $users = User::all();
        return view('admin.users', compact('users'));
    }
}
