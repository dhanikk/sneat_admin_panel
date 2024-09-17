<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{DashboardController};


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/languages/{language}/{filename}', [LanguageController::class, 'getLanguageFile']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function(){
    Route::get("dashboard", function () {
        return view('welcome');
    })->name('dashboard');
});
