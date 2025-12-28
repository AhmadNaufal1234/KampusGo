<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Mitra\MitraOrderController;
use App\Http\Controllers\Customer\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::view('/customer/dashboard', 'customer.dashboard');
});

Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::view('/mitra/dashboard', 'mitra.dashboard');
    Route::view('/mitra/saldo', 'mitra.saldo');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/order', [OrderController::class, 'create']);
    Route::post('/customer/order', [OrderController::class, 'store']);
});

Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra/dashboard', [MitraOrderController::class, 'index']);
    Route::post('/mitra/order/{order}/accept', [MitraOrderController::class, 'accept']);
});

Route::get('/cek-login', function () {
    return auth()->user();
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    Route::get('/customer/order/create', [OrderController::class, 'create'])
        ->name('customer.order.create');

    Route::get('/customer/orders', [OrderController::class, 'history'])
        ->name('customer.orders.history');

        Route::post('/order', [OrderController::class, 'store'])
        ->name('customer.order.store');

});

Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/order/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('order.cancel');

});


require __DIR__.'/auth.php';