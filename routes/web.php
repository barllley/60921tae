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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Маршруты аутентификации
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Маршрут для ошибок
Route::get('/error', function () {
    return view('error');
})->name('error');

// Публичные маршруты (доступны всем)
Route::get('/exhibitions', [ExhibitionController::class, 'index'])->name('exhibitions.index');
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show'])->name('exhibitions.show');
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');

// Защищенные маршруты (только для авторизованных)
Route::middleware(['auth'])->group(function () {
    // Билеты
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // Выставки (добавьте!)
    Route::get('/exhibitions/create', [ExhibitionController::class, 'create'])->name('exhibitions.create');
    Route::post('/exhibitions', [ExhibitionController::class, 'store'])->name('exhibitions.store');
    Route::get('/exhibitions/{id}/edit', [ExhibitionController::class, 'edit'])->name('exhibitions.edit');
    Route::put('/exhibitions/{id}', [ExhibitionController::class, 'update'])->name('exhibitions.update');
    Route::delete('/exhibitions/{id}', [ExhibitionController::class, 'destroy'])->name('exhibitions.destroy');
});

// Маршруты для отношений многие-ко-многим
Route::get('/users/{id}/exhibitions', [UserExhibitionController::class, 'show'])->name('users.exhibitions');
Route::get('/exhibitions/{id}/users', [ExhibitionUserController::class, 'show'])->name('exhibitions.users');

// Корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{ticket}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{ticket}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{ticket}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Оформление заказа из корзины
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
