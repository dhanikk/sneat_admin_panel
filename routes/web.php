<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\RoleController;
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
        Route::get('/permission', 'index')->name('permission.index')->middleware('permission:view.permission');
        Route::get('permission/create', 'create')->name('permission.create')->middleware('permission:create.permission');
        Route::post('permission/store', 'store')->name('permission.store');
        Route::get('permission/{permission}/edit', 'edit')->name('permission.edit')->middleware('permission:update.permission');
        Route::post('permission/update', 'update')->name('permission.update');
        Route::delete('permission/{permission}', 'destroy')->name('permission.destroy')->middleware('permission:delete.permission');
        Route::post('permission/moduleStore', 'moduleStore')->name('permission.module');
        Route::post('permission/delete', 'deleteSinglePermission')->name('permission.delete');
    });
    Route::controller(RoleController::class)->group(function () {
        Route::get('/role', 'index')->name('role.index')->middleware('permission:view.role');
        Route::get('role/create', 'create')->name('role.create')->middleware('permission:create.role');
        Route::post('role/store', 'store')->name('role.store');
        Route::get('role/{role}/edit', 'edit')->name('role.edit')->middleware('permission:update.role');
        Route::post('role/{role}', 'update')->name('role.update');
        Route::delete('role/{role}', 'destroy')->name('role.destroy')->middleware('permission:delete.role');
        Route::post('/role/{roleId}/updateStatus', 'updateStatus')->name('role.updateStatus');
    });
});



