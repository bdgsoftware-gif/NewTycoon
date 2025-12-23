<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Footer;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\FooterController;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /** * Register services. */
    public function register(): void
    {
        //
    }
    /** * Bootstrap services. */
    public function boot()
    {
        // Global Navigation using real Category data 
        View::composer('*', function ($view) {
            $navigation = Category::active()
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
        });

        // Global Cart Data for authenticated users
        View::composer('*', function ($view) {

            $cartCount = 0;

            if (Auth::check()) {
                $cart = Cart::getCurrentCart();
                $cartCount = $cart?->total_items ?? 0;
            } else {
                // Guest users also can have cart (optional)
                $cart = Cart::getCurrentCart();
                $cartCount = $cart?->total_items ?? 0;
            }

            $view->with('cartCount', $cartCount);
        });


        // Global Footer Data 
        View::composer('*', function ($view) {

            $footerData = (new FooterController)->getFooterData();

            $view->with('footerData', $footerData);
        });
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
