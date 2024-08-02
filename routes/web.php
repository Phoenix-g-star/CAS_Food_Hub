<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Define routes for each panel with respective middleware
Route::middleware(['auth', 'seller:Admin'])->prefix('admin')->group(function () {
    Route::get('/admin', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'seller:Customer'])->prefix('customer')->group(function () {
    Route::get('/customer', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'seller:Seller'])->prefix('seller')->group(function () {
    Route::get('/seller', [AuthenticatedSessionController::class, 'store']);
});

require __DIR__.'/auth.php';
