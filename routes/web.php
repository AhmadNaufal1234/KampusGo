<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Mitra\MitraOrderController;


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Default
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/order/create', [CustomerOrderController::class, 'create'])
            ->name('order.create');

        Route::post('/order', [CustomerOrderController::class, 'store'])
            ->name('order.store');

        Route::get('/orders', [CustomerOrderController::class, 'history'])
            ->name('orders.history');

        Route::post('/order/{order}/cancel', [CustomerOrderController::class, 'cancel'])
            ->name('order.cancel');
});

/*
|--------------------------------------------------------------------------
| MITRA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mitra'])
    ->prefix('mitra')
    ->name('mitra.')
    ->group(function () {

        Route::get('/dashboard', [MitraOrderController::class, 'index'])
            ->name('dashboard');

        Route::post('/order/{order}/accept', [MitraOrderController::class, 'accept'])
            ->name('order.accept');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Debug
|--------------------------------------------------------------------------
*/
Route::get('/cek-login', function () {
    return auth()->user();
})->middleware('auth');