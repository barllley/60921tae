<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserControllerApi;
use App\Http\Controllers\ExhibitionControllerApi;
use App\Http\Controllers\TicketControllerApi;
use App\Http\Controllers\OrderControllerApi;
use App\Http\Controllers\CartControllerApi;
use App\Http\Controllers\CheckoutControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Аутентификация
Route::post('/login', [AuthController::class, 'login']);

// Выставки и билеты
Route::get('/exhibitions', [ExhibitionControllerApi::class, 'index']);
Route::get('/exhibitions/{id}', [ExhibitionControllerApi::class, 'show']);

Route::get('/tickets', [TicketControllerApi::class, 'index']);
Route::get('/tickets/{id}', [TicketControllerApi::class, 'show']);

// Корзина
Route::get('/cart', [CartControllerApi::class, 'index']);
Route::post('/cart/add/{ticketId}', [CartControllerApi::class, 'add']);
Route::delete('/cart/remove/{ticketId}', [CartControllerApi::class, 'remove']);
Route::post('/cart/update/{ticketId}', [CartControllerApi::class, 'update']);
Route::post('/cart/clear', [CartControllerApi::class, 'clear']);


Route::middleware('auth:sanctum')->group(function () {

    // Аутентификация
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Оформление заказа
    Route::get('/checkout', [CheckoutControllerApi::class, 'show']);
    Route::post('/checkout', [CheckoutControllerApi::class, 'process']);

    // Пользователи
    Route::get('/users', [UserControllerApi::class, 'index']);
    Route::get('/users/{id}', [UserControllerApi::class, 'show']);
    Route::get('/users/{id}/orders', [UserControllerApi::class, 'getUserOrders']);
    Route::get('/users/{id}/exhibitions', [UserControllerApi::class, 'getUserExhibitions']);

    // Выставки
    Route::get('/exhibitions-protected', [ExhibitionControllerApi::class, 'indexProtected']);
    Route::get('/exhibitions/{id}/users', [ExhibitionControllerApi::class, 'getExhibitionUsers']);

    // Билеты
    Route::get('/tickets-protected', [TicketControllerApi::class, 'indexProtected']);

    // Заказы
    Route::get('/orders', [OrderControllerApi::class, 'index']);
    Route::get('/orders/{id}', [OrderControllerApi::class, 'show']);
});
