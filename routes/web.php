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
    ->middleware(['auth', 'verified', 'can:view-dashboard'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard API routes
    Route::get('/api/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');
    Route::get('/api/dashboard/stock-alerts', [DashboardController::class, 'getStockAlerts'])
        ->middleware('can:view-stock-alerts')
        ->name('dashboard.stock-alerts');

    // Product routes with permissions
    Route::middleware('can:view-products')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    });
    
    Route::middleware('can:create-products')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    });
    
    Route::middleware('can:edit-products')->group(function () {
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::patch('/products/{product}', [ProductController::class, 'update']);
    });
    
    Route::middleware('can:delete-products')->group(function () {
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
    
    Route::middleware('can:manage-stock')->group(function () {
        Route::post('/products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.stock');
    });

    // Category routes with permissions
    Route::middleware('can:view-categories')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    });
    
    Route::middleware('can:create-categories')->group(function () {
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    });
    
    Route::middleware('can:edit-categories')->group(function () {
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    });
    
    Route::middleware('can:delete-categories')->group(function () {
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // POS routes with permissions
    Route::middleware('can:access-pos')->group(function () {
        Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
        Route::post('/pos/search', [POSController::class, 'searchProduct'])->name('pos.search');
        Route::post('/pos/cart/add', [POSController::class, 'addToCart'])->name('pos.cart.add');
        Route::post('/pos/cart/update', [POSController::class, 'updateCart'])->name('pos.cart.update');
        Route::post('/pos/cart/remove', [POSController::class, 'removeFromCart'])->name('pos.cart.remove');
        Route::post('/pos/cart/clear', [POSController::class, 'clearCart'])->name('pos.cart.clear');
        Route::get('/pos/cart', [POSController::class, 'getCart'])->name('pos.cart.get');
        Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
    });

    // Transaction routes with permissions
    Route::middleware('can:view-transactions')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    });
    
    // Transaction API routes
    Route::get('/api/transactions/dashboard', [TransactionController::class, 'getDashboardData'])
        ->middleware('can:view-transactions')
        ->name('transactions.dashboard-data');
    
    // Receipt routes (future feature)
    Route::middleware('can:print-receipts')->group(function () {
        Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'printReceipt'])->name('transactions.receipt');
    });

    // API routes for search and filters
    Route::prefix('api')->group(function () {
        Route::get('/products/search', [ProductController::class, 'search'])
            ->middleware('can:view-products')
            ->name('api.products.search');
        
        Route::get('/categories/search', [CategoryController::class, 'search'])
            ->middleware('can:view-categories')
            ->name('api.categories.search');
            
        Route::get('/transactions/export', [TransactionController::class, 'export'])
            ->middleware('can:export-transactions')
            ->name('api.transactions.export');
    });
});

require __DIR__.'/auth.php';
