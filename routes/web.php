<?php

use App\Http\Controllers\AccountController;
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

Route::middleware(['auth'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('/account-types', 'accountTypes');
    });
});

// Route::get('/account-types', function () {
//     return inertia('Account/Type');
// });

// Route::get('/accounts', function () {
//     return inertia('Account/Index');
// });
