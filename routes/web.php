<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountHelperController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('web.home.index');
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

    Route::controller(AccountHelperController::class)->group(function () {
        Route::get('/account-helpers', 'index')->name('web.accountHelpers.index');
        Route::get('/account-helpers/create', 'create');
        Route::post('/account-helpers', 'store');
        Route::get('/account-helpers/{accountHelperId}/edit', 'edit');
        Route::put('/account-helpers/{accountHelperId}', 'update');
        Route::delete('/account-helpers/{accountHelperId}', 'delete');
    });

    Route::controller(JournalController::class)->group(function () {
        Route::get('/journals', 'index');
        Route::get('/journals/create', 'create');
        Route::post('/journals', 'store');
        Route::get('/journals/{transactionId}/edit', 'edit');
        Route::put('/journals/{transactionId}', 'updateJournal');
        Route::delete('/journals/{transactionId}', 'delete');
    });

    // Settings
    Route::controller(UserController::class)->group(function () {
        Route::get('/setting-users', 'index')->name('web.users.index');
        Route::get('/setting-users/create', 'create');
        Route::post('/setting-users', 'store');
        Route::get('/setting-users/{userId}/edit', 'edit');
        Route::put('/setting-users/{userId}', 'update');
        Route::delete('/setting-users/{userId}', 'delete');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports/general-ledger/{accountId?}', 'generalLedger');
        Route::get('/reports/account-helper/{accountHelperId?}', 'accountHelper'); // Buku besar
        Route::get('/reports/worksheet', 'worksheet'); // Neraca Lajur

        // Laporan Keuangan
        Route::get('/reports/profit-loss', 'profitLoss'); // Laporan Laba Rugi
    });

    // Settings Report
    Route::controller(SettingReportController::class)->group(function () {
        Route::get('/setting-reports/profit-loss', 'profitLoss')->name('web.setting-report.profit-loss');
        Route::post('/setting-reports/profit-loss', 'storeProfitLoss');
    });
});
