<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderController;

// Authentication routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login/demo/{userId}', [AuthController::class, 'loginAsDemo'])->name('login.demo');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
    
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::post('/order/{orderId}/rate', [OrderController::class, 'rate'])->name('order.rate');
});
