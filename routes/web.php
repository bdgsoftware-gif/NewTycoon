<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.details');
Route::post('/checkout/{product}', [CheckoutController::class, 'direct'])->name('checkout.direct');
Route::post('/wishlist/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::prefix('orders')->group(function () {
    Route::get('track', [OrderController::class, 'track'])->name('trackOrder');
});

Route::get('/search', [HomeController::class, 'index'])->name('search');

require __DIR__ . '/auth.php';
