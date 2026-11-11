<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServicePriceController;
use App\Models\ServicePrice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Sudah login -> langsung ke dashboard sesuai perannya
    if (auth()->check()) {
        return redirect()->route('home');
    }

    return view('welcome', [
        'services' => ServicePrice::orderBy('id')->take(4)->get(),
    ]);
});

// Halaman Layanan & Harga untuk tamu (boleh dilihat tanpa login)
Route::get('/layanan', [CatalogController::class, 'index'])->name('catalog');

Auth::routes();

Route::get('/home', [DashboardController::class, 'index'])->middleware('auth')->name('home');

Route::middleware(['auth'])->group(function () {

    // Keranjang & checkout (1 alamat untuk jasa + produk)
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/{key}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{key}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'store'])->name('cart.store');

    // Customer membatalkan pesanan (saat status Menunggu atau Diproses, dicek di controller)
    Route::get('/orders/{order}/cancel', [OrderController::class, 'cancelForm'])->name('orders.cancel.form');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Bisa diakses admin & customer (dibatasi logic-nya di dalam controller masing-masing)
    Route::resource('orders', OrderController::class);
    Route::get('/orders/{order}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/orders/{order}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Customer upload bukti pembayaran (QR DANA)
    Route::post('/payments/{payment}/proof', [PaymentController::class, 'uploadProof'])->name('payments.proof');

    // Profil (admin & customer dua-duanya bisa akses)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Layanan & Harga: lihat daftar bisa diakses admin & customer
    Route::get('/service_prices', [ServicePriceController::class, 'index'])->name('service_prices.index');

    // Khusus admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/service_prices/create', [ServicePriceController::class, 'create'])->name('service_prices.create');
        Route::post('/service_prices', [ServicePriceController::class, 'store'])->name('service_prices.store');
        Route::get('/service_prices/{service_price}/edit', [ServicePriceController::class, 'edit'])->name('service_prices.edit');
        Route::put('/service_prices/{service_price}', [ServicePriceController::class, 'update'])->name('service_prices.update');
        Route::delete('/service_prices/{service_price}', [ServicePriceController::class, 'destroy'])->name('service_prices.destroy');

        // Produk (kertas, pulpen, pensil, dst.)
        Route::resource('admin/products', ProductController::class)
            ->except('show')
            ->names('admin.products');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/orders/{order}/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::patch('/payments/{payment}/confirm', [PaymentController::class, 'confirmReceived'])->name('payments.confirm');

        // Laporan penjualan (grafik + PDF)
        Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/admin/reports/pdf', [ReportController::class, 'pdf'])->name('admin.reports.pdf');

        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });
});
