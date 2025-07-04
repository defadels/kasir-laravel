<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard API routes
    Route::get('/api/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');
    Route::get('/api/dashboard/stock-alerts', [DashboardController::class, 'getStockAlerts'])->name('dashboard.stock-alerts');

    // Product routes
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.update-stock');

    // Category routes
    Route::resource('categories', CategoryController::class);

    // POS routes
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/search', [POSController::class, 'searchProduct'])->name('pos.search');
    Route::post('/pos/cart/add', [POSController::class, 'addToCart'])->name('pos.cart.add');
    Route::post('/pos/cart/update', [POSController::class, 'updateCart'])->name('pos.cart.update');
    Route::post('/pos/cart/remove', [POSController::class, 'removeFromCart'])->name('pos.cart.remove');
    Route::post('/pos/cart/clear', [POSController::class, 'clearCart'])->name('pos.cart.clear');
    Route::get('/pos/cart', [POSController::class, 'getCart'])->name('pos.cart.get');
    Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');

    // Transaction routes
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::get('/api/transactions/dashboard', [TransactionController::class, 'getDashboardData'])->name('transactions.dashboard-data');
});

require __DIR__.'/auth.php';
