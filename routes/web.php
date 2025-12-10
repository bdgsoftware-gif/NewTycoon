<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

// ==============================
// PUBLIC FRONTEND ROUTES
// ==============================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category:slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/products/brand/{brand:slug}', [ProductController::class, 'brand'])->name('products.brand');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Brands
Route::get('/brands', [ProductController::class, 'brands'])->name('brands.index');

// Search
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Cart Routes (available for guests)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Wishlist (requires auth)
Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
    Route::post('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
    Route::post('/move-to-cart/{product}', [WishlistController::class, 'moveToCart'])->name('moveToCart');
});

// Checkout
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
});

// Order Tracking (public)
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/track', [OrderController::class, 'track'])->name('track');
    Route::get('/{order}/tracking', [OrderController::class, 'tracking'])->name('tracking');
});

// Reviews
Route::middleware('auth')->prefix('reviews')->name('reviews.')->group(function () {
    Route::post('/{product}', [ReviewController::class, 'store'])->name('store');
    Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
    Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
});

// User Profile
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [ProfileController::class, 'orderDetails'])->name('order.details');
    Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
    Route::put('/addresses/{address}', [ProfileController::class, 'updateAddress'])->name('addresses.update');
    Route::delete('/addresses/{address}', [ProfileController::class, 'deleteAddress'])->name('addresses.delete');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Static Pages
Route::view('/about', 'frontend.pages.about')->name('about');
Route::view('/contact', 'frontend.pages.contact')->name('contact');
Route::view('/terms', 'frontend.pages.terms')->name('terms');
Route::view('/privacy', 'frontend.pages.privacy')->name('privacy');
Route::view('/faq', 'frontend.pages.faq')->name('faq');
Route::view('/shipping', 'frontend.pages.shipping')->name('shipping');
Route::view('/returns', 'frontend.pages.returns')->name('returns');

// Contact Form
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Newsletter
Route::post('/newsletter', [HomeController::class, 'newsletter'])->name('newsletter.subscribe');

// ==============================
// AUTHENTICATED USER DASHBOARD
// ==============================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    // User Orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/my-orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/my-orders/{order}/return', [OrderController::class, 'return'])->name('orders.return');

    // Downloads (if applicable)
    Route::get('/downloads', [ProfileController::class, 'downloads'])->name('downloads');
    // User Profile Management
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updateProfilePassword'])->name('profile.password.update');
    Route::delete('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
});

// ==============================
// AUTH ROUTES
// ==============================
require __DIR__ . '/auth.php';

// ==============================
// ADMIN ROUTES
// ==============================
require __DIR__ . '/admin.php';
