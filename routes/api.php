<?php

use App\Http\Controllers\UserControllerApi;
use App\Http\Controllers\ExhibitionControllerApi;
use App\Http\Controllers\TicketControllerApi;
use App\Http\Controllers\OrderControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Пользователи
Route::get('/users', [UserControllerApi::class, 'index']);
Route::get('/users/{id}', [UserControllerApi::class, 'show']);
Route::get('/users/{id}/orders', [UserControllerApi::class, 'getUserOrders']);
Route::get('/users/{id}/exhibitions', [UserControllerApi::class, 'getUserExhibitions']);

// Выставки
Route::get('/exhibitions', [ExhibitionControllerApi::class, 'index']);
Route::get('/exhibitions/{id}', [ExhibitionControllerApi::class, 'show']);

// Билеты
Route::get('/tickets', [TicketControllerApi::class, 'index']);
Route::get('/tickets/{id}', [TicketControllerApi::class, 'show']);

// Заказы
Route::get('/orders', [OrderControllerApi::class, 'index']);
Route::get('/orders/{id}', [OrderControllerApi::class, 'show']);
