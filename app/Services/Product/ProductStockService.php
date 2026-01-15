<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductStockService
{
    /**
     * Update product stock status
     */
    public function updateStockStatus(Product $product): void
    {
        if ($product->quantity <= 0) {
            $product->stock_status = $product->allow_backorder ? 'backorder' : 'out_of_stock';
        } else {
            $product->stock_status = 'in_stock';
        }

        $product->saveQuietly();
    }

    /**
     * Increment product stock
     */
    public function incrementStock(Product $product, int $quantity): void
    {
        $product->increment('quantity', $quantity);
        $this->updateStockStatus($product);
    }

    /**
     * Decrement product stock
     */
    public function decrementStock(Product $product, int $quantity): void
    {
        if ($product->track_quantity) {
            $product->decrement('quantity', $quantity);
            $this->updateStockStatus($product);
        }
    }

    /**
     * Check if product is in stock
     */
    public function isInStock(Product $product): bool
    {
        return $product->stock_status === 'in_stock' ||
            ($product->stock_status === 'backorder' && $product->allow_backorder);
    }

    /**
     * Check if product is low stock
     */
    public function isLowStock(Product $product): bool
    {
        return $product->quantity <= $product->alert_quantity;
    }

    /**
     * Update sold quantity and revenue
     */
    public function recordSale(Product $product, int $quantity, float $price): void
    {
        $product->increment('total_sold', $quantity);
        $product->increment('total_revenue', $quantity * $price);
        $this->decrementStock($product, $quantity);
    }

    /**
     * Reverse sale (for refunds/cancellations)
     */
    public function reverseSale(Product $product, int $quantity, float $price): void
    {
        $product->decrement('total_sold', $quantity);
        $product->decrement('total_revenue', $quantity * $price);
        $this->incrementStock($product, $quantity);
    }

    /**
     * Get stock summary
     */
    public function getStockSummary(Product $product): array
    {
        return [
            'quantity' => $product->quantity,
            'stock_status' => $product->stock_status,
            'alert_quantity' => $product->alert_quantity,
            'is_low_stock' => $this->isLowStock($product),
            'track_quantity' => $product->track_quantity,
            'allow_backorder' => $product->allow_backorder,
            'total_sold' => $product->total_sold,
            'total_revenue' => $product->total_revenue,
        ];
    }
}
