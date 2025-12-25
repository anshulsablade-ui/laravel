<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MultipleInsert\BulkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserImportController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('app');
// });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('showRegisterForm');

Route::post('/login', [AuthController::class, 'LoginForm'])->name('login');
Route::post('/register', [AuthController::class, 'RegisterForm'])->name('register');


Route::get('/getCities', [CityController::class, 'getCities'])->name('getCities');


// route group middleware
Route::middleware( 'login')->group(function () {
    Route::get('/users', [ProfileController::class, 'index'])->name('showUsers');
    Route::get('/users/create', [ProfileController::class, 'create'])->name('create.user');
    Route::post('/users/store', [ProfileController::class, 'store'])->name('store.user');
    Route::get('/users/edit/{id}', [ProfileController::class, 'edit'])->name('edit.user');
    Route::put('/users/update', [ProfileController::class, 'update'])->name('update.user');
    Route::delete('/users/delete/{id}', [ProfileController::class, 'delete'])->name('delete.user');
    Route::get('/users/show/{id}', [ProfileController::class, 'show'])->name('show.user');

    Route::get('/loginuserprofile/edit/{id}', [ProfileController::class, 'loginuserprofileEdit'])->name('loginuserprofileEdit');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/countries/list', [CountryController::class, 'index'])->name('showCountrieslist');
    Route::get('/countries', [CountryController::class, 'showCountryForm'])->name('showCountryForm');
    Route::post('/countries', [CountryController::class, 'store'])->name('store.country');
    Route::get('/countries/edit/{id}', [CountryController::class, 'edit'])->name('edit.country');
    Route::put('/countries/update', [CountryController::class, 'update'])->name('update.country');
    Route::delete('/countries/delete/{id}', [CountryController::class, 'delete'])->name('delete.country');

    Route::get('/bulk/add/countries', [CountryController::class, 'showBulkCountryForm'])->name('showBulkCountryForm');
    Route::post('/bulk/store/countries', [CountryController::class, 'bulkStore'])->name('bulkStore.countries');


    Route::get('/cities/list', [CityController::class, 'index'])->name('showCitieslist');
    Route::get('/cities', [CityController::class, 'showCityForm'])->name('showCityForm');
    Route::post('/cities', [CityController::class, 'store'])->name('store.city');
    Route::get('/cities/edit/{id}', [CityController::class, 'edit'])->name('edit.city');
    Route::put('/cities/update', [CityController::class, 'update'])->name('update.city');
    Route::delete('/cities/delete/{id}', [CityController::class, 'delete'])->name('delete.city');

    Route::get('/csv-upload', [UserImportController::class, 'index'])->name('csv.upload');
    Route::post('/csv-import', [UserImportController::class, 'import'])->name('csv.import');


    Route::get('/multistep/form', function () {
            $countries = \App\Models\Countries::select('country_id', 'country_name')->get();
            return view('multistep_form_submit.index', compact('countries'));
        }
    )->name('multistep.form');
});




// Multiple insert form data ---------------------------------------------------------------------
Route::get('/multipleinsert', [BulkController::class, 'index'])->name('multipleinsert');
Route::post('/bulk.store', [BulkController::class, 'store'])->name('bulk.store');

