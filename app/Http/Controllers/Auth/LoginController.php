<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $redirectTo = '/exhibitions';

    public function showLoginForm()
    {

        return view('auth.login');
    }


public function login(Request $request)
{
    Log::info('=== DATABASE SESSION LOGIN START ===', [
        'email' => $request->email,
        'session_driver' => config('session.driver')
    ]);

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        Log::info('=== DATABASE AUTH SUCCESS ===', [
            'user_id' => Auth::id(),
            'session_id' => $request->session()->getId()
        ]);

        $request->session()->regenerate();

        // Проверим запись в базе данных
        $sessionRecord = DB::table('sessions')
            ->where('id', $request->session()->getId())
            ->first();

        Log::info('=== SESSION DB RECORD ===', [
            'session_exists' => !is_null($sessionRecord),
            'session_user_id' => $sessionRecord->user_id ?? null
        ]);

        return $this->authenticated($request, Auth::user());
    }

    throw ValidationException::withMessages([
        'email' => 'Неверные учетные данные.',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->is_admin == 1) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->intended($this->redirectPath());
    }

    public function redirectPath()
    {
        return $this->redirectTo;
    }
}
