<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// auth page
Route::controller(AuthController::class)->prefix('auth')->group(function() {
    
    Route::get('login', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::get('logout', 'logout')->name('logout');

    Route::post('login', 'loginProcess')->name('proses-login');
    Route::post('register', 'registerProcess')->name('proses-register');
});

// dashboard 
Route::controller(DashboardController::class)->prefix('dashboard')->name('dashboard.')->group(function() {
    Route::get('/', 'index')->name('index');
});
Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function() {
    Route::get('/','index')->name('index');
    Route::get('/create','create')->name('create');
    Route::get('/create/process','create')->name('store');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::get('/edit/{id}/process','edit')->name('update');
});
Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function() {
    Route::get('/','index')->name('index');
    Route::get('/create','create')->name('create');
    Route::get('/create/process','create')->name('store');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::get('/edit/{id}/process','edit')->name('update');
});

// home page
Route::controller(HomeController::class)->prefix('/')->name('home.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('shop', 'shop')->name('shop');
});

