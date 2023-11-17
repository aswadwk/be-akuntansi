<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return inertia('Dashboard/Index')->middleware('auth');
});

Route::get('/test', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('auth/login', 'login');
    Route::post('auth/login', 'doLogin');
    Route::post('auth/logout', 'logout')->withoutMiddleware(['auth']);
});
