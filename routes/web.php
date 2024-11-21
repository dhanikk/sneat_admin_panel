<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\{LoginController, RegisterController};
use App\Http\Controllers\{DashboardController};


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/languages/{language}/{filename}', [LanguageController::class, 'getLanguageFile']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    Route::get("/", function () {
        return view('admin/welcome');
    })->name('admin');
    Route::get("dashboard", function () {
        return view('admin/welcome');
    })->name('admin.dashboard');
});


Route::get("dashboard", function () {
    return view('welcome');
})->name('dashboard');

