<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AccountTypeController;
use App\Http\Controllers\Api\AuthController;
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

Route::prefix('v1')->middleware('auth:api', 'user.id')->group( function (){

    Route::controller(AuthController::class)->group(function (){
        Route::post('register', 'register')->name('auth.register')->withoutMiddleware('auth:api', 'user.id');
        Route::post('login', 'login')->name('auth.login')->withoutMiddleware('auth:api', 'user.id');
        Route::post('logout', 'logout')->name('auth.logout');
        Route::post('refresh', 'refresh')->name('auth.refresh');
        Route::get('me', 'me')->name('auth.me');
    });

    Route::controller(AccountTypeController::class)->group(function (){
        Route::get('account-types/{id?}', 'index')->name('account-type.index');
        Route::post('account-types', 'store')->name('account-type.store');
        Route::patch('account-types/{id}', 'update')->name('account-type.update');
        Route::delete('account-types/{id}', 'delete')->name('account-type.delete');
    });

    Route::controller(AccountController::class)->group(function (){
        Route::get('accounts/{id?}', 'index')->name('account.index');
        Route::post('accounts', 'store')->name('account.store');
        Route::patch('accounts/{id}', 'update')->name('account.update');
        Route::delete('accounts/{id}', 'delete')->name('account.delete');
    });

});
