<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Redirect root (/) ke login
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (requires login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard setelah login
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Produk & Transaksi
    Route::get('/products/report', [ProductController::class, 'report'])->name('products.report');
    Route::resource('products', ProductController::class);
    Route::resource('transactions', TransactionController::class);

    // Nota transaksi
    Route::get('/transactions/{id}/receipt', [TransactionController::class, 'receipt'])->name('transactions.receipt');

    /*
    |--------------------------------------------------------------------------
    | Admin-only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    });
});
