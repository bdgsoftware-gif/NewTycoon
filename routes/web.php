<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

// ==============================
// PUBLIC FRONTEND ROUTES
// ==============================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])
    ->name('product.show');
    

// Cart / Wishlist
Route::middleware('auth')->group(function () {
    Route::post('/wishlist/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
});

// Order Track (public)
Route::prefix('orders')->group(function () {
    Route::get('/track', [OrderController::class, 'track'])->name('trackOrder');
});

// Static Pages
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Search (public)
Route::get('/search', [HomeController::class, 'search'])->name('search');

// ==============================
// AUTHENTICATED USER ROUTES
// ==============================
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::post('/checkout/{product}', [CheckoutController::class, 'direct'])->name('checkout.direct');
});

// ==============================
// AUTH ROUTES (Login/Signup/Reset)
// ==============================
require __DIR__ . '/auth.php';
