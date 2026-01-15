<?php

namespace App\Services;

use App\Models\Category;

class NavigationService
{
    // Global Navigation using real Category data 
    public function getNavigationCategories(): array
    {
        return Category::active()
            ->showInNav()
            ->root()
            ->orderBy('nav_order')
            ->with(['children' => function ($query) {
                $query->active()->with(['children' => function ($query) {
                    $query->active();
                }]);
            }])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get()
            ->map(function ($category) {
                return $this->formatCategoryForNavigation($category);
            })
            ->toArray();

        $view->with('navigation', $navigation);
    }

    /**
     * Format category data for navigation
     */
    private function formatCategoryForNavigation(Category $category): array
    {
        $formatted = [
            'name' => $category->name,
            'url' => route('categories.show', $category->slug),
            'children' => []
        ];

        // Add second level (children)
        if ($category->children->isNotEmpty()) {
            foreach ($category->children as $child) {
                $childData = [
                    'name' => $child->name,
                    'url' => route('categories.show', $child->slug),
                    'children' => []
                ];

                // Add third level (grandchildren)
                if ($child->children->isNotEmpty()) {
                    foreach ($child->children as $grandchild) {
                        $childData['children'][] = [
                            'name' => $grandchild->name,
                            'url' => route('categories.show', $grandchild->slug),
                        ];
                    }
                }

                $formatted['children'][] = $childData;
            }
        }

        return $formatted;
    }
}
