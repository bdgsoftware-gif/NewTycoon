<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\SettingsController;

// ==============================
// ADMIN ROUTES (Admin Only)
// ==============================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users Management (with permission check)
    Route::prefix('users')->name('users.')->middleware('permission:manage_users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Products Management
    Route::prefix('products')->name('products.')->middleware('permission:manage_products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Categories
    Route::prefix('categories')->name('categories.')->middleware('permission:manage_products')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->middleware('permission:view_orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('updateStatus');
    });

    // Content Management
    Route::prefix('content')->name('content.')->middleware('permission:manage_content')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('index');
        Route::get('/create', [ContentController::class, 'create'])->name('create');
        Route::post('/', [ContentController::class, 'store'])->name('store');
        Route::get('/{content}/edit', [ContentController::class, 'edit'])->name('edit');
        Route::put('/{content}', [ContentController::class, 'update'])->name('update');
        Route::delete('/{content}', [ContentController::class, 'destroy'])->name('destroy');
    });

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->middleware('permission:view_reports')
        ->name('analytics');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])
        ->middleware('permission:manage_settings')
        ->name('settings');
});

// ==============================
// MODERATOR ROUTES (Admin + Moderator)
// ==============================
Route::middleware(['auth', 'anyrole:admin,moderator'])->prefix('moderate')->name('moderate.')->group(function () {
    Route::get('/content', [ContentController::class, 'moderate'])->name('content');
    Route::get('/comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments');
    Route::put('/comments/{comment}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');
});
