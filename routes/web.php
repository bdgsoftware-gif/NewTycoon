<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Route::prefix('orders')->group(function () {
    Route::get('track', [OrderController::class, 'track'])->name('trackOrder');
});

Route::get('/search', [HomeController::class, 'index'])->name('search');

require __DIR__ . '/auth.php';
