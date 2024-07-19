<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;

Route::get('/sendmail', [TestController::class, 'testmail']);

// auth page
Route::controller(AuthController::class)->middleware(['isLogined'])->group(function () {
    Route::get('login', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::get('logout', 'logout')->name('logout');

    Route::post('login', 'loginProcess')->name('proses-login');
    Route::post('register', 'registerProcess')->name('proses-register');
});

// dashboard 
Route::controller(DashboardController::class)->prefix('dashboard')->name('dashboard.')->group(function() {
    Route::get('/', 'index')->name('index');

    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function() {
        Route::get('/','index')->name('index');
        Route::get('/create','create')->name('create');
        Route::post('/create/process','store')->name('store');
        Route::get('/{slug}/edit','edit')->name('edit');
        Route::put('/{slug}/edit//process','update')->name('update');
        Route::delete('/delete/{slug}','destroy')->name('destroy');
    });
    
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function() {
        Route::get('/','index')->name('index');
        Route::get('/create','create')->name('create');
        Route::post('/create/process','store')->name('store');
        Route::get('/edit/{slug}','edit')->name('edit');
        Route::put('/edit/{slug}/process','update')->name('update');
        Route::delete('/delete/{slug}','destroy')->name('destroy');
        Route::get('{slug}/list-image','listImage')->name('list-image');
        Route::get('{slug}/add-image','addImage')->name('add-image');
        Route::post('{slug}/add-image/store','storeImage')->name('store-image');
        Route::delete('{slug}/delete-image/{id}/delete','deleteImage')->name('delete-image');
    });
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
