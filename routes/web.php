<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Mitra\MitraOrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Mitra\MitraTopupController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\Admin\AdminDashboardController;


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Default
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/order', [CustomerOrderController::class, 'create'])
            ->name('order.create');

        Route::post('/order', [CustomerOrderController::class, 'store'])
            ->name('order.store');

        Route::get('/orders', [CustomerOrderController::class, 'history'])
            ->name('orders.history');

        Route::post('/order/{order}/cancel', [CustomerOrderController::class, 'cancel'])
            ->name('order.cancel');

        Route::get('/topup', [TopUpController::class, 'create'])
            ->name('topup');

        Route::post('/topup', [TopUpController::class, 'store'])
            ->name('topup.store');
    });

Route::post(
    '/mitra/order/{order}/complete',
    [MitraOrderController::class, 'complete']
)->name('mitra.order.complete');

// routes/web.php
Route::middleware(['auth'])->group(function () {

    Route::get('/mitra/topup', [MitraTopupController::class, 'index'])
        ->name('mitra.topup');

    Route::post('/mitra/topup', [MitraTopupController::class, 'store'])
        ->name('mitra.topup.store');
});

    Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
    });


/*
|--------------------------------------------------------------------------
| MITRA ROUTES
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

        Route::post('/order/{order}/reject', [MitraOrderController::class, 'reject'])
            ->name('order.reject');

        Route::post('/order/{order}/arrived', [MitraOrderController::class, 'arrived'])
            ->name('order.arrived');

        Route::post('/order/{order}/on-way', [MitraOrderController::class, 'onWay'])
            ->name('order.onway');
    });

/*
|--------------------------------------------------------------------------
| CHAT (Customer ↔ Driver)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/order/{order}/chat', [ChatController::class, 'send'])
        ->name('order.chat.send');
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


Route::middleware(['auth'])->group(function () {
    Route::get('/topup', [TopUpController::class, 'create'])
        ->name('topup');

    Route::post('/topup', [TopUpController::class, 'store'])
        ->name('topup.store');
});

/*
|--------------------------------------------------------------------------
| DEBUG
|--------------------------------------------------------------------------
*/
Route::get('/cek-login', function () {
    return auth()->user();
})->middleware('auth');