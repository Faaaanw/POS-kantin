<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

Route::get('/', [HomeController::class, 'index'])-> name('home');
Route::resource('products', ProductController::class);
Route::resource('transactions', TransactionController::class);

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');