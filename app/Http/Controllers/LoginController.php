<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Показ формы логина
    public function login()
    {
        return view('auth.login');
    }

    // Аутентификация пользователя
    public function authenticate(Request $request)
    {
        // Валидация полей
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Попытка аутентификации
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/exhibitions');
        }

        // Если аутентификация не удалась
        throw ValidationException::withMessages([
            'email' => 'Неверные учетные данные.'
        ]);
    }

    // Выход пользователя
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
