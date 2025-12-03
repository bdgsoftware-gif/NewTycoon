<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;

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

        // User actions
        Route::post('/{user}/activate', [UserController::class, 'activate'])->name('activate');
        Route::post('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
        Route::post('/{user}/impersonate', [UserController::class, 'impersonate'])->name('impersonate');
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

        // Product actions
        Route::post('/{product}/feature', [ProductController::class, 'toggleFeature'])->name('toggle.feature');
        Route::post('/{product}/bestseller', [ProductController::class, 'toggleBestseller'])->name('toggle.bestseller');
        Route::post('/{product}/stock', [ProductController::class, 'updateStock'])->name('update.stock');
        Route::post('/{product}/images', [ProductController::class, 'uploadImages'])->name('upload.images');
        Route::delete('/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('delete.image');
    });

    // Categories
    Route::prefix('categories')->name('categories.')->middleware('permission:manage_products')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');

        // Category actions
        Route::post('/{category}/feature', [CategoryController::class, 'toggleFeature'])->name('toggle.feature');
        Route::post('/{category}/status', [CategoryController::class, 'toggleStatus'])->name('toggle.status');
        Route::get('/{category}/products', [CategoryController::class, 'products'])->name('products');
    });

    // Brands
    Route::prefix('brands')->name('brands.')->middleware('permission:manage_products')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/', [BrandController::class, 'store'])->name('store');
        Route::get('/{brand}', [BrandController::class, 'show'])->name('show');
        Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::put('/{brand}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('destroy');

        // Brand actions
        Route::post('/{brand}/feature', [BrandController::class, 'toggleFeature'])->name('toggle.feature');
        Route::post('/{brand}/status', [BrandController::class, 'toggleStatus'])->name('toggle.status');
        Route::get('/{brand}/products', [BrandController::class, 'products'])->name('products');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->middleware('permission:view_orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('update.status');
        Route::put('/{order}/payment', [OrderController::class, 'updatePayment'])->name('update.payment');
        Route::post('/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('invoice');
        Route::post('/{order}/refund', [OrderController::class, 'refund'])->name('refund');
        Route::post('/{order}/ship', [OrderController::class, 'ship'])->name('ship');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    // Content Management
    Route::prefix('content')->name('content.')->middleware('permission:manage_content')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('index');
        Route::get('/create', [ContentController::class, 'create'])->name('create');
        Route::post('/', [ContentController::class, 'store'])->name('store');
        Route::get('/{content}', [ContentController::class, 'show'])->name('show');
        Route::get('/{content}/edit', [ContentController::class, 'edit'])->name('edit');
        Route::put('/{content}', [ContentController::class, 'update'])->name('update');
        Route::delete('/{content}', [ContentController::class, 'destroy'])->name('destroy');

        // Content actions
        Route::post('/{content}/publish', [ContentController::class, 'publish'])->name('publish');
        Route::post('/{content}/archive', [ContentController::class, 'archive'])->name('archive');
        Route::post('/{content}/featured', [ContentController::class, 'toggleFeatured'])->name('toggle.featured');

        // Content types
        Route::get('/pages', [ContentController::class, 'pages'])->name('pages');
        Route::get('/posts', [ContentController::class, 'posts'])->name('posts');
        Route::get('/faqs', [ContentController::class, 'faqs'])->name('faqs');
        Route::get('/testimonials', [ContentController::class, 'testimonials'])->name('testimonials');
        Route::get('/announcements', [ContentController::class, 'announcements'])->name('announcements');
    });

    // Analytics
    Route::prefix('analytics')->name('analytics.')->middleware('permission:view_reports')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::get('/sales', [AnalyticsController::class, 'sales'])->name('sales');
        Route::get('/users', [AnalyticsController::class, 'users'])->name('users');
        Route::get('/products', [AnalyticsController::class, 'products'])->name('products');
        Route::get('/revenue', [AnalyticsController::class, 'revenue'])->name('revenue');
        Route::get('/export', [AnalyticsController::class, 'export'])->name('export');
        Route::get('/reports', [AnalyticsController::class, 'reports'])->name('reports');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->middleware('permission:manage_settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/', [SettingsController::class, 'update'])->name('update');

        // General Settings
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::put('/general', [SettingsController::class, 'updateGeneral'])->name('update.general');

        // Email Settings
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
        Route::put('/email', [SettingsController::class, 'updateEmail'])->name('update.email');

        // Payment Settings
        Route::get('/payment', [SettingsController::class, 'payment'])->name('payment');
        Route::put('/payment', [SettingsController::class, 'updatePayment'])->name('update.payment');

        // Shipping Settings
        Route::get('/shipping', [SettingsController::class, 'shipping'])->name('shipping');
        Route::put('/shipping', [SettingsController::class, 'updateShipping'])->name('update.shipping');

        // Roles & Permissions
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [SettingsController::class, 'roles'])->name('index');
            Route::get('/create', [SettingsController::class, 'createRole'])->name('create');
            Route::post('/', [SettingsController::class, 'storeRole'])->name('store');
            Route::get('/{role}/edit', [SettingsController::class, 'editRole'])->name('edit');
            Route::put('/{role}', [SettingsController::class, 'updateRole'])->name('update');
            Route::delete('/{role}', [SettingsController::class, 'destroyRole'])->name('destroy');
            Route::post('/{role}/permissions', [SettingsController::class, 'syncPermissions'])->name('sync.permissions');
        });

        // Permissions
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [SettingsController::class, 'permissions'])->name('index');
            Route::post('/', [SettingsController::class, 'storePermission'])->name('store');
            Route::put('/{permission}', [SettingsController::class, 'updatePermission'])->name('update');
            Route::delete('/{permission}', [SettingsController::class, 'destroyPermission'])->name('destroy');
        });

        // Backup & Maintenance
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::post('/backup/create', [SettingsController::class, 'createBackup'])->name('backup.create');
        Route::post('/cache/clear', [SettingsController::class, 'clearCache'])->name('cache.clear');
    });

    // Media Library (Optional but useful)
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('index');
        Route::post('/upload', [\App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('upload');
        Route::delete('/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('destroy');
    });
});

// ==============================
// MODERATOR ROUTES (Admin + Moderator)
// ==============================
Route::middleware(['auth', 'anyrole:admin,moderator'])->prefix('moderate')->name('moderate.')->group(function () {
    Route::get('/content', [ContentController::class, 'moderate'])->name('content');

    // Comments
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('index');
        Route::get('/pending', [\App\Http\Controllers\Admin\CommentController::class, 'pending'])->name('pending');
        Route::put('/{comment}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('approve');
        Route::put('/{comment}/reject', [\App\Http\Controllers\Admin\CommentController::class, 'reject'])->name('reject');
        Route::delete('/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('destroy');
    });

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('index');
        Route::get('/pending', [\App\Http\Controllers\Admin\ReviewController::class, 'pending'])->name('pending');
        Route::put('/{review}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('approve');
        Route::put('/{review}/reject', [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('destroy');
    });

    // Users (Limited access)
    Route::get('/users', [UserController::class, 'moderate'])->name('users');
});
