<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/languages/{language}/{filename}', [LanguageController::class, 'getLanguageFile']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::group(['middleware' => ['auth']], function(){

    Route::get("dashboard", [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permission', 'index')->name('permission.index');
        Route::get('permission/create', 'create')->name('permission.create');
        Route::post('permission/store', 'store')->name('permission.store');
        Route::get('permission/{permission}/edit', 'edit')->name('permission.edit');
        Route::post('permission/update', 'update')->name('permission.update');
        Route::delete('permission/{permission}', 'destroy')->name('permission.destroy');
        Route::post('permission/moduleStore', 'moduleStore')->name('permission.module');
        Route::post('permission/delete', 'deleteSinglePermission')->name('permission.delete');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/role', 'index')->name('role.index');
        Route::get('role/create', 'create')->name('role.create');
        Route::post('role/store', 'store')->name('role.store');
        Route::get('role/{role}/edit', 'edit')->name('role.edit');
        Route::post('role/{role}', 'update')->name('role.update');
        Route::delete('role/{role}', 'destroy')->name('role.destroy');
        Route::post('/role/{roleId}/updateStatus', 'updateStatus')->name('role.updateStatus');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user.index');
        Route::get('user/create', 'create')->name('user.create');
        Route::post('user/store', 'store')->name('user.store');
        Route::get('user/{user}/edit', 'edit')->name('user.edit');
        Route::post('user/{user}', 'update')->name('user.update');
        Route::delete('user/{user}', 'destroy')->name('user.destroy');
        Route::post('/user/{userId}/updateStatus', 'updateStatus')->name('user.updateStatus');
    });

});



