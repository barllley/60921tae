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

Route::post('/login', [AuthController::class, 'login']);

// Exhibitions routes with pagination support
Route::get('/exhibitions', [ExhibitionControllerApi::class, 'index']);
Route::get('/exhibitions/{id}', [ExhibitionControllerApi::class, 'show']);
Route::get('/exhibitions_total', [ExhibitionControllerApi::class, 'total']); // NEW

// Tickets routes with pagination support
Route::get('/tickets', [TicketControllerApi::class, 'index']);
Route::get('/tickets/{id}', [TicketControllerApi::class, 'show']);
Route::get('/tickets_total', [TicketControllerApi::class, 'total']); // NEW

Route::get('/cart', [CartControllerApi::class, 'index']);
Route::post('/cart/add/{ticketId}', [CartControllerApi::class, 'add']);
Route::delete('/cart/remove/{ticketId}', [CartControllerApi::class, 'remove']);
Route::post('/cart/update/{ticketId}', [CartControllerApi::class, 'update']);
Route::post('/cart/clear', [CartControllerApi::class, 'clear']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::get('/checkout', [CheckoutControllerApi::class, 'show']);
    Route::post('/checkout', [CheckoutControllerApi::class, 'process']);

    Route::get('/orders', [OrderControllerApi::class, 'index']);
    Route::get('/orders/{id}', [OrderControllerApi::class, 'show']);

    Route::get('/users/{id}/orders', [UserControllerApi::class, 'getUserOrders']);
    Route::get('/users/{id}/exhibitions', [UserControllerApi::class, 'getUserExhibitions']);

    Route::get('/users', [UserControllerApi::class, 'index']);
    Route::get('/users/{id}', [UserControllerApi::class, 'show']);
    Route::get('/exhibitions/{id}/users', [ExhibitionControllerApi::class, 'getExhibitionUsers']);
});
