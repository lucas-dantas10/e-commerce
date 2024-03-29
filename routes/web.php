<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/shipping', [ProfileController::class, 'storeShippingAddress'])->name('profile.shipping');
    Route::post('/profile/billing', [ProfileController::class, 'storeBillingAddress'])->name('profile.billing');

    Route::resource('/carrinho', CartController::class);
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/{order}', [CheckoutController::class, 'checkoutOrder'])->name('checkout.order');
    Route::get('/checkout-success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout-failed', [CheckoutController::class, 'failed'])->name('checkout.failed');
    Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';
