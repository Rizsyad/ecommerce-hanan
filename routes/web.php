<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

// auth page
Route::controller(AuthController::class)->middleware(['isLogined'])->group(function () {
    Route::get('login', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::get('logout', 'logout')->name('logout');

    Route::post('login', 'loginProcess')->name('proses-login');
    Route::post('register', 'registerProcess')->name('proses-register');
});

// dashboard
Route::controller(DashboardController::class)
    ->prefix('dashboard')
    ->name('dashboard.')
    ->middleware(['isLogined', 'isAdmin'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

// home page
Route::controller(HomeController::class)
    ->prefix('/')
    ->name('home.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('shop', 'shop')->name('shop');
        Route::get('shop/{id}/detail', 'shopDetail')->name('shopDetail');
        Route::get('cart', 'cart')->name('cart');
        Route::get('checkout', 'checkout')->name('checkout');
    });
