<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        // ✅ OPTIMIZED: Cache category list
        $categories = Cache::remember('categories.index', 3600, function () {
            return Category::active()
                ->root()
                ->with(['children' => function ($query) {
                    $query->active()
                        ->orderBy('order')
                        ->select('id', 'name_en', 'name_bn', 'slug', 'parent_id', 'image', 'description_en', 'description_bn', 'order');
                }])
                ->select('id', 'name_en', 'name_bn', 'slug', 'parent_id', 'image', 'description_en', 'description_bn', 'is_featured', 'order')
                ->orderBy('order')
                ->get();
        });

        $featuredCategories = Cache::remember('categories.featured', 3600, function () {
            return Category::active()
                ->featured()
                ->root()
                ->select('id', 'name_en', 'name_bn', 'slug', 'image', 'description_en', 'description_bn', 'order')
                ->orderBy('order')
                ->limit(12)
                ->get();
        });

        return view('frontend.categories.index', compact('categories', 'featuredCategories'));
    }

    /**
     * Display a specific category with products
     * ✅ FULLY OPTIMIZED - No N+1 queries, proper indexing
     */
    public function show(Request $request, Category $category)
    {
        if (!$category->is_active) {
            abort(404, 'Category not available');
        }

        $search = trim($request->input('q', ''));
        $sort = $request->input('sort', 'latest');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $status = $request->input('status');

        $categoryIds = $this->getCategoryIdsOptimized($category);

        $query = Product::active()
            ->withActiveCategory()
            ->whereIn('category_id', $categoryIds)
            ->select([
                'id',
                'name_en',
                'name_bn',
                'slug',
                'price',
                'compare_price',
                'discount_percentage',
                'featured_images',
                'stock_status',
                'is_new',
                'is_featured',
                'category_id',
                'average_rating',
                'rating_count',
            ]);

        // ✅ FIXED: Apply search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_bn', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // ✅ FIXED: Apply price filter (THIS WAS MISSING!)
        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price', '<=', $maxPrice);
        }

        // ✅ FIXED: Apply status filter (THIS WAS MISSING!)
        if ($status) {
            switch ($status) {
                case 'in_stock':
                    $query->inStock();
                    break;
                case 'new':
                    $query->where('is_new', true);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'discounted':
                    $query->where('discount_percentage', '>', 0);
                    break;
                case 'bestseller':
                    $query->where('is_bestsells', true);
                    break;
            }
        }

        // ✅ FIXED: Use proper sorting method
        $this->applySorting($query, $sort);

        $products = $query->paginate(24)->withQueryString();

        // ✅ OPTIMIZED: Get subcategories - only if parent category
        $subcategories = collect([]);
        if ($category->depth < 2) { // Only show subcategories for parent/root categories
            $subcategories = Category::where('parent_id', $category->id)
                ->where('is_active', true)
                ->select('id', 'name_en', 'name_bn', 'slug')
                ->orderBy('order')
                ->get();
        }

        // ✅ OPTIMIZED: Get price range with single query
        $priceRange = $this->getPriceRangeOptimized($categoryIds);

        // ✅ OPTIMIZED: Simplified breadcrumbs
        $breadcrumbs = $this->getBreadcrumbsOptimized($category);
        // dd($breadcrumbs);
        return view('frontend.categories.show', [
            'category' => $category,
            'products' => $products,
            'subcategories' => $subcategories,
            'priceRange' => $priceRange,
            'breadcrumbs' => $breadcrumbs,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    /**
     * ✅ OPTIMIZED: Get category IDs without recursion
     */
    protected function getCategoryIdsOptimized(Category $category): array
    {
        // If it's a leaf category, just return its ID
        if ($category->depth === 2) {
            return [$category->id];
        }

        // Get all descendant IDs in one query
        return DB::table('categories')
            ->where(function ($query) use ($category) {
                $query->where('id', $category->id)
                    ->orWhere('parent_id', $category->id)
                    ->orWhereIn('parent_id', function ($subQuery) use ($category) {
                        $subQuery->select('id')
                            ->from('categories')
                            ->where('parent_id', $category->id);
                    });
            })
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();
    }

    /**
     * ✅ OPTIMIZED: Get price range with single query
     */
    protected function getPriceRangeOptimized(array $categoryIds): array
    {
        $priceData = DB::table('products')
            ->whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        return [
            'min' => (int) ($priceData->min_price ?? 0),
            'max' => (int) ($priceData->max_price ?? 100000),
        ];
    }

    /**
     * ✅ OPTIMIZED: Simplified breadcrumbs
     */
    protected function getBreadcrumbsOptimized(Category $category): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Category', 'url' => route('categories.index')],
        ];

        if ($category->parent_id) {
            $parents = DB::table('categories')
                ->select('id', 'name_en', 'name_bn', 'slug', 'parent_id')
                ->where(function ($query) use ($category) {
                    if ($category->depth === 2) {
                        $query->where('id', $category->parent_id)
                            ->orWhereIn('id', function ($subQuery) use ($category) {
                                $subQuery->select('parent_id')
                                    ->from('categories')
                                    ->where('id', $category->parent_id);
                            });
                    } else {
                        $query->where('id', $category->parent_id);
                    }
                })
                ->orderBy('depth', 'asc')
                ->get();

            foreach ($parents as $parent) {
                $breadcrumbs[] = [
                    'name' => app()->getLocale() === 'bn' ? $parent->name_bn : $parent->name_en,
                    'url' => route('categories.show', $parent->slug)
                ];
            }
        }

        $breadcrumbs[] = [
            'name' => $category->name,
            'url' => null
        ];

        return $breadcrumbs;
    }


    /**
     * ✅ OPTIMIZED: Apply sorting to raw query
     */
    protected function applySorting($query, string $sort): void
    {
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name_en', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name_en', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_sold', 'desc')
                    ->orderBy('average_rating', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
                break;
            case 'newest':
            case 'latest':
            default:
                $query->latest('created_at');
                break;
        }
    }
}
