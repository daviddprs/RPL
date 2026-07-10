<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Customer-facing menu page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Cart
Route::get('/cart', [OrderController::class, 'cart'])->name('cart.index');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Order placement
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/my', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Staff Dashboard (admin, kasir, barista)
    Route::middleware('role:admin,kasir,barista')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Kasir Routes
    Route::middleware('role:admin,kasir')->prefix('kasir')->group(function () {
        Route::get('/orders', [StaffController::class, 'kasirOrders'])->name('kasir.orders');
        Route::post('/orders/{order}/verify-payment', [StaffController::class, 'verifyPayment'])->name('kasir.verify-payment');
        Route::post('/orders/{order}/update-status', [StaffController::class, 'updateOrderStatus'])->name('kasir.update-status');
    });

    // Barista Routes
    Route::middleware('role:admin,barista')->prefix('barista')->group(function () {
        Route::get('/orders', [StaffController::class, 'baristaOrders'])->name('barista.orders');
        Route::post('/orders/{order}/update-status', [StaffController::class, 'baristaUpdateStatus'])->name('barista.update-status');
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Menu Management
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class)->names('admin.menus');
        // Category Management
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
        // Staff Management
        Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class)->names('admin.staff');
        // Analytics
        Route::get('/analytics', [DashboardController::class, 'index'])->name('admin.analytics');
    });
});
