<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // --- CUSTOM ROUTES MUST GO BEFORE THE RESOURCE ---
    Route::get('/transactions/adjustment', [InventoryTransactionController::class, 'adjustmentForm'])->name('transactions.adjustment');
    Route::post('/transactions/adjustment', [InventoryTransactionController::class, 'processAdjustment'])->name('transactions.adjustment.store');
    Route::get('/reports', [InventoryTransactionController::class, 'reports'])->name('transactions.reports');
    // ---------------------------------------

    // Inventory Resource Routes
    Route::resource('transactions', InventoryTransactionController::class)->except(['edit', 'update']);
    
    // Product Resource Routes
    Route::resource('products', ProductController::class)->except(['destroy']);

    // API Routes for AJAX Polling
    Route::get('/api/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/api/products/low-stock', [DashboardController::class, 'lowStock']);
    Route::get('/api/transactions/recent', [DashboardController::class, 'recentTransactions']);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';