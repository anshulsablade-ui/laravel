<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('/register', [AuthController::class, 'RegisterForm'])->name('register');
// Route::post('/login', [AuthController::class, 'LoginForm'])->name('login');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
