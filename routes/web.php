<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServicePriceController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    // Bisa diakses admin & customer (dibatasi logic-nya di dalam controller masing-masing)
    Route::resource('orders', OrderController::class);
    Route::get('/orders/{order}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/orders/{order}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Khusus admin
    Route::middleware(['admin'])->group(function () {
        Route::resource('service_prices', ServicePriceController::class)->except(['show']);

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/orders/{order}/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::patch('/payments/{payment}/confirm', [PaymentController::class, 'confirmReceived'])->name('payments.confirm');

        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });
});