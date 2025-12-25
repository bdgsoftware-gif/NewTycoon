<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use App\Observers\ProductObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;
use App\Services\Product\ProductService;
use App\Services\Product\ProductImageService;
use App\Services\Product\ProductStockService;
use App\Services\Search\ProductSearchService;
use App\Services\Product\ActiveProductService;
use App\Services\Search\CategorySearchService;
use App\Services\Product\ProductPricingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ActiveProductService::class);
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService(
                $app->make(ProductStockService::class),
                $app->make(ProductPricingService::class),
                $app->make(ProductImageService::class)
            );
        });

        $this->app->singleton(ProductStockService::class);
        $this->app->singleton(ProductPricingService::class);
        $this->app->singleton(ProductImageService::class);
        $this->app->singleton(ProductSearchService::class);
        $this->app->singleton(CategorySearchService::class);
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
