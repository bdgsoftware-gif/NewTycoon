<?php

namespace App\Services\Search;

use App\Models\Category;
use App\Models\Product;

class CategorySearchService
{
    public function resolveCategoryIds(?string $search): array
    {
        if (!$search) {
            return Category::active()->pluck('id')->all();
        }

        // 1. Categories matching keyword
        $matchedCategoryIds = Category::active()
            ->where('name', 'LIKE', "%{$search}%")
            ->pluck('id')
            ->all();

        // 2. Categories from products matching keyword
        $productCategoryIds = Product::active()
            ->search($search)
            ->pluck('category_id')
            ->unique()
            ->all();

        return array_values(array_unique([
            ...$matchedCategoryIds,
            ...$productCategoryIds,
        ]));
    }

    public function getSidebarCategories(?string $search)
    {
        $categoryIds = $this->resolveCategoryIds($search);

        return Category::active()
            ->whereIn('id', $categoryIds)
            ->withCount(['products' => fn($q) => $q->active()])
            ->orderBy('name')
            ->get();
    }

    public function getCategoriesWithProductCounts(?string $search)
    {
        $categoryIds = $this->resolveCategoryIds($search);

        return Category::active()
            ->whereIn('id', $categoryIds)
            ->with([
                'children' => fn($q) => $q->active()
            ])
            ->withCount([
                'products as products_count' => function ($q) use ($search) {
                    $q->active()
                        ->when($search, fn($q) => $q->search($search));
                }
            ])
            ->get();
    }
}
