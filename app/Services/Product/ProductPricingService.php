<?php

namespace App\Services\Product;

use App\Models\Product;

class ProductPricingService
{
    /**
     * Calculate discount percentage
     */
    public function calculateDiscount(Product $product): void
    {
        if ($product->compare_price && $product->compare_price > $product->price) {
            $discount = (($product->compare_price - $product->price) / $product->compare_price) * 100;
            $product->discount_percentage = round($discount, 2);
        } else {
            $product->discount_percentage = 0;
        }

        $product->saveQuietly();
    }

    /**
     * Get discount amount
     */
    public function getDiscountAmount(Product $product): float
    {
        if ($product->compare_price && $product->compare_price > $product->price) {
            return $product->compare_price - $product->price;
        }

        return 0;
    }

    /**
     * Get profit margin
     */
    public function getProfitMargin(Product $product): float
    {
        if ($product->cost_price > 0 && $product->price > 0) {
            return (($product->price - $product->cost_price) / $product->price) * 100;
        }

        return 0;
    }

    /**
     * Get profit per unit
     */
    public function getProfitPerUnit(Product $product): float
    {
        return $product->price - $product->cost_price;
    }

    /**
     * Get pricing summary
     */
    public function getPricingSummary(Product $product): array
    {
        return [
            'price' => $product->price,
            'compare_price' => $product->compare_price,
            'cost_price' => $product->cost_price,
            'discount_percentage' => $product->discount_percentage,
            'discount_amount' => $this->getDiscountAmount($product),
            'profit_margin' => $this->getProfitMargin($product),
            'profit_per_unit' => $this->getProfitPerUnit($product),
            'is_on_sale' => $product->compare_price > $product->price,
        ];
    }

    /**
     * Validate pricing
     */
    public function validatePricing(array $data): array
    {
        $errors = [];

        if (isset($data['price']) && $data['price'] <= 0) {
            $errors['price'] = 'Price must be greater than 0';
        }

        if (isset($data['compare_price']) && $data['compare_price'] <= 0) {
            $errors['compare_price'] = 'Compare price must be greater than 0';
        }

        if (isset($data['cost_price']) && $data['cost_price'] < 0) {
            $errors['cost_price'] = 'Cost price cannot be negative';
        }

        if (isset($data['price']) && isset($data['compare_price'])) {
            if ($data['compare_price'] < $data['price']) {
                $errors['compare_price'] = 'Compare price must be greater than or equal to price';
            }
        }

        if (isset($data['price']) && isset($data['cost_price'])) {
            if ($data['price'] < $data['cost_price']) {
                $errors['price'] = 'Price cannot be less than cost price';
            }
        }

        return $errors;
    }

    /**
     * Apply discount
     */
    public function applyDiscount(Product $product, float $percentage): void
    {
        if ($percentage > 0 && $percentage <= 100) {
            $discountedPrice = $product->price * (1 - ($percentage / 100));
            $product->compare_price = $product->price;
            $product->price = round($discountedPrice, 2);
            $this->calculateDiscount($product);
            $product->save();
        }
    }
}
