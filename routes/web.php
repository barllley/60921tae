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

// Маршруты для билетов (полный CRUD)
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

// Маршруты для отношений многие-ко-многим (только просмотр связей)
Route::get('/users/{id}/exhibitions', [UserExhibitionController::class, 'show'])->name('users.exhibitions');
Route::get('/exhibitions/{id}/users', [ExhibitionUserController::class, 'show'])->name('exhibitions.users');
