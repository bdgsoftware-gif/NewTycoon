<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\Product\ProductStockService;
use App\Services\Product\ProductPricingService;

class ProductObserver
{
    public function __construct(
        protected ProductStockService $stockService,
        protected ProductPricingService $pricingService
    ) {}

    public function creating(Product $product)
    {
        if (blank($product->name_bn)) {
            $product->name_bn = $product->name_en;
        }
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // Initialize stock status
        $this->stockService->updateStockStatus($product);

        // Calculate initial discount
        $this->pricingService->calculateDiscount($product);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Update stock status if quantity changed
        if ($product->isDirty('quantity')) {
            $this->stockService->updateStockStatus($product);
        }

        // Recalculate discount if pricing changed
        if ($product->isDirty('price') || $product->isDirty('compare_price')) {
            $this->pricingService->calculateDiscount($product);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // You might want to handle soft deletes differently
        if (!$product->trashed()) {
            // Product is permanently deleted
            // Clean up any related data
        }
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        // Update stock status when restored
        $this->stockService->updateStockStatus($product);
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        // Product is permanently deleted
        // Clean up any remaining data
    }
}
