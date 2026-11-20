<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/produk/{product:slug}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CartController::class, 'placeOrder'])->name('checkout.store');
Route::get('/pesanan/{order:order_number}', [CartController::class, 'confirmation'])
    ->middleware('throttle:30,1')
    ->name('orders.confirmation');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('products', AdminProductController::class)->except('show');
        Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    });
});
