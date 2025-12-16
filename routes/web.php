<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [AuthController::class, 'LoginForm'])->name('login');
Route::get('/users', [AuthController::class, 'index'])->name('showUsers');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('showRegisterForm');
Route::post('/register', [AuthController::class, 'RegisterForm'])->name('register');

Route::get('/countries/list', [CountryController::class, 'index'])->name('showCountrieslist');
Route::get('/countries', [CountryController::class, 'showCountryForm'])->name('showCountryForm');
Route::post('/countries', [CountryController::class, 'store'])->name('store.country');
Route::get('/countries/edit/{id}', [CountryController::class, 'edit'])->name('edit.country');
Route::put('/countries/update', [CountryController::class, 'update'])->name('update.country');
Route::delete('/countries/delete/{id}', [CountryController::class, 'delete'])->name('delete.country');


Route::get('/cities/list', [CityController::class, 'index'])->name('showcitieslist');
Route::get('/cities', [CityController::class, 'showCityForm'])->name('showCityForm');
Route::post('/cities', [CityController::class, 'store'])->name('store.city');
Route::get('/cities/edit/{id}', [CityController::class, 'edit'])->name('edit.city');
Route::put('/cities/update', [CityController::class, 'update'])->name('update.city');
Route::delete('/cities/delete/{id}', [CityController::class, 'delete'])->name('delete.city');
