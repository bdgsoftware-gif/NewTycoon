<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\SearchTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCardViewResource;

class SearchController extends Controller
{
    public function suggest(Request $request)
    {
        try {
            $query = $request->input('q', '');

            if (empty($query) || strlen($query) < 2) {
                return response()->json([]);
            }

            if ($query) {
                SearchTerm::updateOrCreate(
                    ['term' => $query],
                    [
                        'search_count' => DB::raw('search_count + 1'),
                        'last_searched_at' => now(),
                    ]
                );
            }

            // Search products
            $products = Product::active()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('sku', 'LIKE', "%{$query}%")
                        ->orWhere('short_description', 'LIKE', "%{$query}%");
                })
                ->limit(8)
                ->get(['id', 'name', 'slug', 'price', 'featured_images', 'stock_status', 'is_new', 'discount_percentage']);

            // Search categories
            $categories = Category::active()
                ->where('name', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get(['id', 'name', 'slug']);

            $suggestions = [];

            // Add products to suggestions
            foreach ($products as $product) {
                $suggestions[] = [
                    'type' => 'product',
                    'id' => $product->id,
                    'name' => $product->name,
                    'url' => route('product.show', $product->slug),
                    'price' => number_format($product->price, 2),
                    'image' => $this->getImageUrl($product->featured_images[0]),
                    'in_stock' => $product->stock_status === 'in_stock',
                    'is_new' => $product->is_new,
                    'discount_percentage' => $product->discount_percentage,
                    'highlight' => $this->highlightText($product->name, $query)
                ];
            }

            // Add categories to suggestions
            foreach ($categories as $category) {
                $suggestions[] = [
                    'type' => 'category',
                    'id' => $category->id,
                    'name' => $category->name,
                    'url' => route('categories.show', $category->slug),
                    'highlight' => $this->highlightText($category->name, $query)
                ];
            }

            return response()->json($suggestions);
        } catch (\Exception $e) {
            flash('Search suggestion error', 'error');
            Log::error('Search suggestion error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'An error occurred while searching',
                'message' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    private function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('images/products/fr-06.jpg');
        }

        if (strpos($imagePath, 'http') === 0) {
            return $imagePath;
        }

        return asset('storage/' . ltrim($imagePath, '/'));
    }

    private function highlightText($text, $query)
    {
        if (empty($query)) {
            return e($text);
        }

        $pattern = '/(' . preg_quote($query, '/') . ')/i';
        $highlighted = preg_replace($pattern, '<span class="font-bold text-primary">$1</span>', e($text));

        return $highlighted ?: e($text);
    }

    public function search(Request $request)
    {
        $search = trim($request->input('q', ''));
        $sort = $request->input('sort', 'latest');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $status = $request->input('status', 'all');

        // Track search term
        if ($search && strlen($search) >= 2) {
            SearchTerm::updateOrCreate(
                ['term' => $search],
                [
                    'search_count' => DB::raw('search_count + 1'),
                    'last_searched_at' => now(),
                ]
            );
        }

        // Get all products matching search (including category matches)
        $productQuery = $this->buildProductQuery($search, $category, $minPrice, $maxPrice, $status);
        $this->applySorting($productQuery, $sort);

        // Get paginated products
        $products = ProductCardViewResource::collection(
            $productQuery->paginate(12)->withQueryString()
        );

        // Get categories for filter sidebar
        $categories = Category::getCategoriesForSearch($search);

        // If a category is selected, ensure it's included
        if ($category) {
            $categories = $this->ensureSelectedCategoryIncluded($categories, $category);
        }

        // Get price range for filters
        $priceRange = $this->getPriceRange($productQuery);

        // Get total products count for "All Categories"
        $allProductsCount = $this->getAllProductsCount($search);

        return view('frontend.search.results', compact(
            'products',
            'categories',
            'priceRange',
            'search',
            'category',
            'minPrice',
            'maxPrice',
            'sort',
            'status',
            'allProductsCount'
        ));
    }

    /**
     * Build optimized product query
     */
    private function buildProductQuery($search, $category, $minPrice, $maxPrice, $status)
    {
        $query = Product::query()->active()->withActiveCategory();

        // Apply search (including category matches)
        if (!empty($search)) {
            $query->searchWithCategories($search);
        }

        // Apply category filter - including child categories
        if ($category) {
            $categoryModel = Category::find($category);
            if ($categoryModel) {
                $categoryIds = $categoryModel->getAllCategoryIds();
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Apply price range
        if ($minPrice) {
            $query->where('price', '>=', (float) $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // Apply status filters
        $this->applyStatusFilter($query, $status);

        return $query;
    }

    /**
     * Get all products count for search
     */
    private function getAllProductsCount($search)
    {
        $query = Product::active();

        if ($search) {
            $query->searchWithCategories($search);
        }

        return $query->count();
    }

    /**
     * Ensure selected category is included in categories list
     */
    private function ensureSelectedCategoryIncluded($categories, $selectedCategoryId)
    {
        $selectedCategory = Category::with('ancestors')->find($selectedCategoryId);

        if (!$selectedCategory || $categories->contains('id', $selectedCategoryId)) {
            return $categories;
        }

        // Check if any ancestor is in the list
        $parent = $selectedCategory->parent;
        while ($parent) {
            if ($categories->contains('id', $parent->id)) {
                return $categories;
            }
            $parent = $parent->parent;
        }

        // If not found, add the category as a root category
        $categories->push($selectedCategory);

        return $categories->sortBy('order');
    }

    /**
     * Apply status filter to query
     */
    private function applyStatusFilter($query, $status)
    {
        switch ($status) {
            case 'in_stock':
                $query->where('stock_status', 'in_stock');
                break;
            case 'out_of_stock':
                $query->where('stock_status', 'out_of_stock');
                break;
            case 'new':
                $query->where('is_new', true);
                break;
            case 'discounted':
                $query->where('discount_percentage', '>', 0);
                break;
            case 'featured':
                $query->where('is_featured', true);
                break;
        }
    }

    /**
     * Apply sorting to query
     */
    private function applySorting($query, $sort)
    {
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_sold', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }
    }

    /**
     * Get price range for current filters
     */
    private function getPriceRange($query)
    {
        // Clone query to get min/max without affecting pagination
        $rangeQuery = clone $query;

        return [
            'min' => (float) ($rangeQuery->min('price') ?? 0),
            'max' => (float) ($rangeQuery->max('price') ?? 10000)
        ];
    }
    
}
