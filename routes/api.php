<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'RegisterForm']);
Route::post('/login', [AuthController::class, 'LoginForm']);


Route::middleware('jwtauth')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);


    Route::post('/update/users', [ProfileController::class, 'update']);
    Route::delete('/delete/users/{id}', [ProfileController::class, 'delete']);
});