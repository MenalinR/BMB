<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing page as login page
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
