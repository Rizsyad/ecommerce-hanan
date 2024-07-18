<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->prefix('auth')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/process',[AuthController::class, 'loginProcess'])->name('loginProcess');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register/process',[AuthController::class, 'registerProcess'])->name('registerProcess');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



// Route::get('/', function () {
//     return 'hssalso';
// });
