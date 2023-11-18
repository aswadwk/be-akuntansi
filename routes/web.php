<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('auth/login', 'login')->name('web.auth.login');
    Route::post('auth/login', 'doLogin');
    Route::post('auth/logout', 'logout')->withoutMiddleware(['auth']);
});

Route::middleware(['auth', 'user.id'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('/accounts', 'index');
    });

    Route::controller(AccountTypeController::class)->group(function () {
        Route::get('/account-types', 'index');
        Route::get('/account-types/create', 'create');
        Route::post('/account-types', 'store');
        Route::get('/account-types/{accountTypeId}', 'edit');
        Route::put('/account-types/{accountTypeId}', 'update');
        Route::delete('/account-types/{accountTypeId}', 'delete');
    });
});
