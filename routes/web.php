<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('dashboard');;
}); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/carrinho', CartController::class);
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/{order_id}', [CheckoutController::class, 'checkoutOrder'])->name('checkout.order');
    Route::get('/checkout-success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout-failed', [CheckoutController::class, 'failed'])->name('checkout.failed');
    Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');
});

require __DIR__ . '/auth.php';
