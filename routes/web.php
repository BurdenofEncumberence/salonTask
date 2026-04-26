<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('services', ServiceController::class);
    Route::resource('appointments', BookingController::class);
    Route::resource('payments', PaymentController::class)->except(['create', 'store', 'destroy']);
    Route::post('/payments/process/{booking}', [PaymentController::class, 'processPayment'])->name('payments.process');
});

require __DIR__.'/auth.php';