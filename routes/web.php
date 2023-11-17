<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return inertia('Dashboard/Index');
});

Route::get('/test', function () {
    return view('welcome');
});
