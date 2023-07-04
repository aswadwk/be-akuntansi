<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AccountTypeController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware(['auth:api', 'user.id'])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('auth.register')->withoutMiddleware(['auth:api', 'user.id']);
        Route::post('login', 'login')->name('auth.login')->withoutMiddleware(['auth:api', 'user.id']);
        Route::post('logout', 'logout')->name('auth.logout');
        Route::post('refresh', 'refresh')->name('auth.refresh');
        Route::get('me', 'me')->name('auth.me');
    });

    Route::controller(AccountTypeController::class)->group(function () {
        Route::get('account-types/{id?}', 'index')->name('account-type.index');
        Route::post('account-types', 'store')->name('account-type.store');
        Route::put('account-types/{id}', 'update')->name('account-type.update');
        Route::delete('account-types/{id}', 'delete')->name('account-type.delete');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('accounts/{id?}', 'index')->name('account.index');
        Route::post('accounts', 'store')->name('account.store');
        Route::put('accounts/{id}', 'update')->name('account.update');
        Route::delete('accounts/{id}', 'delete')->name('account.delete');
    });

    Route::controller(PartnerController::class)->group(function () {
        Route::get('partners/{parnerId?}', 'index')->name('partner.index');
        Route::post('partners', 'store')->name('partner.store');
        Route::put('partners/{id}', 'update')->name('partner.update');
        Route::delete('partners/{id}', 'delete')->name('partner.delete');
    });

    Route::controller(DivisionController::class)->group(function () {
        Route::get('divisions/{id?}', 'index')->name('division.index');
        Route::get('divisions/{id}', 'show')->name('division.show');
        Route::post('divisions', 'store')->name('division.store');
        Route::put('divisions/{id}', 'update')->name('division.update');
        Route::delete('divisions/{id}', 'delete')->name('division.delete');
    });

    Route::controller(JournalController::class)->group(function () {
        Route::get('journals', 'index')->name('journal.index');
        Route::post('journals', 'store')->name('journal.store')->withoutMiddleware('user.id');
    });

    Route::controller(TransactionController::class)->group(function () {
        Route::get('transactions', 'index')->name('transaction.index');
        Route::get('transactions/{id}', 'show')->name('transaction.show');
        Route::post('transactions', 'store')->name('transaction.store')->withoutMiddleware('user.id');
        Route::put('transactions/{id}', 'update')->name('transaction.update')->withoutMiddleware('user.id');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('general-ledger/{accountId}', 'buku_besar')->name('reports.general-ledger');
        Route::get('neraca-lajur', 'neraca_lajur')->name('reports.neraca-lajur');
        Route::get('buku-pembantu/{partnerId}', 'buku_pembantu')->name('reports.buku-pembantu');
        Route::get('neraca', 'neraca')->name('reports.neraca');
        Route::get('account-hutang', 'account_hutang')->name('reports.account-hutang');
        Route::get('account-piutang', 'account_piutang')->name('reports.account-piutang');
    });
});
