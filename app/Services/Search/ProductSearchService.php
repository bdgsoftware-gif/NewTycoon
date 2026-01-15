<?php

namespace App\Services\Search;

use App\Models\Product;
use App\Models\Category;

class ProductSearchService
{
    public function buildQuery(
        ?string $search,
        ?int $category,
        ?float $minPrice,
        ?float $maxPrice,
        string $status,
        array $categoryIds
    ) {
        return Product::query()
            ->active()
            ->when($search, fn($q) => $q->search($search))
            ->when($category, fn($q) => $q->where('category_id', $category))
            ->when(!$category && $categoryIds, fn($q) => $q->whereIn('category_id', $categoryIds))
            ->when(
                $minPrice !== null && $maxPrice !== null,
                fn($q) => $q->whereBetween('price', [$minPrice, $maxPrice])
            )
            ->with('category');
    }
}
