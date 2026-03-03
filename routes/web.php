<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\admin\ProductController;
use App\Http\Controllers\Auth\admin\OfferController;
use App\Http\Controllers\Auth\admin\OrderController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart', [CartController::class, 'order'])->name('cart.order');
    Route::put('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::put('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
});

Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('offers', OfferController::class);
        Route::resource('orders', OrderController::class);
    });

require __DIR__.'/auth.php';
