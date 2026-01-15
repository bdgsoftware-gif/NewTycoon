<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use App\Observers\ProductObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;

// Services
use App\Services\Product\ProductService;
use App\Services\Product\ProductImageService;
use App\Services\Product\ProductStockService;
use App\Services\Product\ProductPricingService;
use App\Services\Product\ActiveProductService;
use App\Services\Search\ProductSearchService;
use App\Services\Search\CategorySearchService;
use App\Services\Category\CategoryProductsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Services that need dependencies or singleton behavior
        $this->app->singleton(ActiveProductService::class);

        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService(
                $app->make(ProductStockService::class),
                $app->make(ProductPricingService::class),
                $app->make(ProductImageService::class)
            );
        });

        // Services that can be auto-resolved don't need singleton binding
        $this->app->singleton(ProductStockService::class);
        $this->app->singleton(ProductPricingService::class);
        $this->app->singleton(ProductImageService::class);

        // Optional: You can remove these if they have no constructor dependencies
        // Laravel will auto-resolve them
        // $this->app->singleton(ProductSearchService::class);
        // $this->app->singleton(CategorySearchService::class);
        // $this->app->singleton(CategoryProductsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
