<?php
// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $redirectTo = '/exhibitions';

    public function showRegistrationForm()
    {
        // Проверяем, не авторизован ли уже пользователь
        if (Auth::check()) {
            return redirect($this->redirectTo);
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Проверяем, не авторизован ли уже пользователь
        if (Auth::check()) {
            return redirect($this->redirectTo);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect($this->redirectTo);
    }
}
