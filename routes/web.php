<?php

use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserExhibitionController;
use App\Http\Controllers\ExhibitionUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Маршруты для выставок
Route::get('/exhibitions', [ExhibitionController::class, 'index'])->name('exhibitions.index');
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show'])->name('exhibitions.show');

// Маршруты для билетов
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');

// Маршруты для отношений многие-ко-многим
Route::get('/users/{id}/exhibitions', [UserExhibitionController::class, 'show'])->name('users.exhibitions');
Route::get('/exhibitions/{id}/users', [ExhibitionUserController::class, 'show'])->name('exhibitions.users');
