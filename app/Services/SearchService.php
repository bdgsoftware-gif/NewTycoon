<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Get active category tree (unlimited depth)
     */
    public function getCategoryTree(): array
    {
        return Category::active()
            ->root()
            ->orderBy('nav_order')
            ->orderBy('order')
            ->with(['children' => function ($query) {
                $query->active()
                    ->orderBy('nav_order')
                    ->orderBy('order')
                    ->with(['children' => function ($query) {
                        $query->active()
                            ->orderBy('nav_order')
                            ->orderBy('order');
                    }]);
            }])
            ->get()
            ->map(function ($category) {
                return $this->formatCategoryTree($category);
            })
            ->toArray();
    }

    /**
     * Format category tree recursively
     */
    private function formatCategoryTree(Category $category): array
    {
        $formatted = [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'url' => route('categories.show', $category->slug),
            'children' => [],
            'has_children' => $category->children->isNotEmpty()
        ];

        // Recursively format children
        if ($category->children->isNotEmpty()) {
            foreach ($category->children as $child) {
                $formatted['children'][] = $this->formatCategoryTree($child);
            }
        }

        return $formatted;
    }
}
