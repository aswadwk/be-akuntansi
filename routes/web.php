<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('auth/login', 'login')->name('web.auth.login')->middleware(['guest']);
    Route::post('auth/login', 'doLogin');
    Route::post('auth/logout', 'logout')->withoutMiddleware(['auth']);
    Route::get('auth/profile', 'me')->name('web.auth.me');
    Route::get('auth/change-password', 'changePassword')->name('web.auth.change-password');
    Route::put('auth/change-password', 'updatePassword')->middleware(['auth', 'user.id']);
});

Route::middleware(['auth', 'user.id'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'index')->name('web.home.index');
    });

    Route::controller(AccountTypeController::class)->group(function () {
        Route::get('/account-types', 'index');
        Route::get('/account-types/create', 'create');
        Route::post('/account-types', 'store');
        Route::get('/account-types/{accountTypeId}/edit', 'edit');
        Route::put('/account-types/{accountTypeId}', 'update');
        Route::delete('/account-types/{accountTypeId}', 'delete');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('/accounts', 'index');
        Route::get('/accounts/create', 'create');
        Route::post('/accounts', 'store');
        Route::get('/accounts/{accountId}/edit', 'edit');
        Route::put('/accounts/{accountId}', 'update');
        Route::delete('/accounts/{accountId}', 'delete');
    });

    Route::controller(JournalController::class)->group(function () {
        Route::get('/journals', 'index');
        Route::get('/journals/create', 'create');
        Route::post('/journals', 'store');
        Route::get('/journals/{transactionId}/edit', 'edit');
        Route::put('/journals/{transactionId}', 'updateJournal');
        Route::delete('/journals/{transactionId}', 'delete');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports/general-ledger/{accountId?}', 'generalLedger');
    });
});
