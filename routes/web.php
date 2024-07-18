<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

// auth page
Route::controller(AuthController::class)->prefix('auth')->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');

    Route::post('/login', 'loginProcess')->name('proses-login');
    Route::post('/register', 'registerProcess')->name('proses-register');
});

// dashboard 
Route::controller(DashboardController::class)->prefix('dashboard')->group(function() {
    Route::get('/', 'index');
});

// home page
Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index');
});
