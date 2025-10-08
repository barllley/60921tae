<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Вариант с фасадом Auth
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->is_admin != 1) {
            return redirect('/exhibitions')->with('error', 'Доступ запрещен.');
        }

        return $next($request);
    }
}
