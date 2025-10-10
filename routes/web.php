<?php

use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserExhibitionController;
use App\Http\Controllers\ExhibitionUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Маршруты аутентификации (публичные)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});


// Маршрут для ошибок
Route::get('/error', function () {
    return view('error');
})->name('error');

// Публичные маршруты (доступны всем)
Route::get('/exhibitions', [ExhibitionController::class, 'index'])->name('exhibitions.index');
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show'])->name('exhibitions.show');
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');

// Корзина - доступна всем (включая неавторизованных)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{ticket}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{ticket}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{ticket}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Маршруты для авторизованных пользователей
Route::middleware(['auth'])->group(function () {
    // Оформление заказа (только для авторизованных)
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Выход из системы
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    // Маршруты для отношений многие-ко-многим
    Route::get('/users/{id}/exhibitions', [UserExhibitionController::class, 'show'])->name('users.exhibitions');
    Route::get('/exhibitions/{id}/users', [ExhibitionUserController::class, 'show'])->name('exhibitions.users');
});

// Маршруты CRUD (только для авторизованных с правами через Gates)
Route::middleware(['auth'])->group(function () {
    // Билеты CRUDs
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // Выставки CRUD
    Route::get('/exhibitions/create', [ExhibitionController::class, 'create'])->name('exhibitions.create');
    Route::post('/exhibitions', [ExhibitionController::class, 'store'])->name('exhibitions.store');
    Route::get('/exhibitions/{id}/edit', [ExhibitionController::class, 'edit'])->name('exhibitions.edit');
    Route::put('/exhibitions/{id}', [ExhibitionController::class, 'update'])->name('exhibitions.update');
    Route::delete('/exhibitions/{id}', [ExhibitionController::class, 'destroy'])->name('exhibitions.destroy');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('users');
});
/*
// Маршруты администратора (проверка прав через Gates в контроллерах)
Route::prefix('admin')->name('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});
*/

// Добавьте в routes/web.php
Route::get('/debug/auth', function() {
return [
'is_authenticated' => Auth::check(),
'user_id' => Auth::id(),
'user' => Auth::user(),
'session_id' => Session::getId(),
'session_data' => Session::all(),
'csrf_token' => csrf_token(),
];
});

Route::get('/debug/db-sessions', function() {
    $sessions = DB::table('sessions')->get();

    return [
        'total_sessions' => $sessions->count(),
        'sessions' => $sessions->map(function($session) {
            return [
                'id' => $session->id,
                'user_id' => $session->user_id,
                'ip_address' => $session->ip_address,
                'last_activity' => date('Y-m-d H:i:s', $session->last_activity),
                'payload_preview' => substr($session->payload, 0, 100)
            ];
        })
    ];
});
