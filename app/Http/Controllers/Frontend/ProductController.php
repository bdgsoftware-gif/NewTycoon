<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Product\ActiveProductService;

class ProductController extends Controller
{
    public function __construct(
        protected ActiveProductService $productService
    ) {}

    /**
     * Display a listing of products with filters
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search');
        $category = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sort = $request->get('sort', 'latest');
        $status = $request->get('status');

        // Base query with active category check
        $query = Product::query()
            ->with(['category:id,name_en,name_bn,slug,parent_id'])
            ->active()
            ->withActiveCategory();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_bn', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('model_number', 'like', "%{$search}%")
                    ->orWhere('short_description_en', 'like', "%{$search}%")
                    ->orWhere('short_description_bn', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($category) {
            // Get category and all its descendant IDs
            $categoryModel = Category::where('id', $category)
                ->orWhere('slug', $category)
                ->first();

            if ($categoryModel) {
                $categoryIds = $categoryModel->getAllCategoryIds();
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Apply price range filter
        if ($minPrice !== null && $minPrice !== '') {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('price', '<=', $maxPrice);
        }

        // Apply status filter
        if ($status) {
            switch ($status) {
                case 'in_stock':
                    $query->inStock();
                    break;
                case 'out_of_stock':
                    $query->where('stock_status', 'out_of_stock');
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

        $this->applySorting($query, $sort);

        // Paginate results
        $products = $query->paginate($perPage)->withQueryString();

        $categories = Category::active()
            ->leaf()
            ->select('id', 'name_en', 'name_bn', 'slug', 'parent_id', 'depth')
            ->with('parent:id,name_en,name_bn')
            ->withCount(['products' => function ($query) {
                $query->active()->withActiveCategory();
            }])
            ->having('products_count', '>', 0)
            ->orderBy('name_en')
            ->get();

        // Get price range for filter
        $activePrices = Product::active()
            ->withActiveCategory()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        $priceRange = [
            'min' => (int) ($activePrices->min_price ?? 0),
            'max' => (int) ($activePrices->max_price ?? 100000),
        ];

        return view('frontend.products.index', compact(
            'products',
            'categories',
            'priceRange',
            'search',
            'category',
            'minPrice',
            'maxPrice',
            'sort',
            'status'
        ));
    }

    /**
     * Display the specified product
     */

    public function show($slug)
    {
        // ✅ OPTIMIZED: Load only needed columns
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->select([
                'id',
                'name_en',
                'name_bn',
                'slug',
                'sku',
                'model_number',
                'price',
                'compare_price',
                'discount_percentage',
                'short_description_en',
                'short_description_bn',
                'description_en',
                'description_bn',
                'featured_images',
                'gallery_images',
                'stock_status',
                'quantity',
                'category_id',
                'weight',
                'length',
                'width',
                'height',
                'warranty_duration',
                'warranty_unit',
                'specifications',
                'average_rating',
                'rating_count',
                'total_sold'
            ])
            ->with([
                'category:id,name_en,name_bn,slug,parent_id,depth,is_active',
                'category.parent:id,name_en,name_bn,slug',
            ])
            ->firstOrFail();

        // ✅ Check category is active
        if ($product->category && !$product->category->is_active) {
            abort(404);
        }

        // ✅ OPTIMIZED: Get reviews with pagination
        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('reviews.product_id', $product->id)
            ->where('reviews.is_approved', true)
            ->select([
                'reviews.id',
                'reviews.rating',
                'reviews.comment',
                'reviews.created_at',
                'users.name as user_name',
                'users.avatar as user_avatar'
            ])
            ->orderBy('reviews.created_at', 'desc')
            ->limit(10)
            ->get();

        // ✅ OPTIMIZED: Get related products with raw query
        $relatedProducts = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '!=', $product->id)
            ->where('products.status', 'active')
            ->where('categories.is_active', true)
            ->where('products.stock_status', 'in_stock')
            ->select([
                'products.id',
                'products.name_en',
                'products.name_bn',
                'products.slug',
                'products.price',
                'products.compare_price',
                'products.discount_percentage',
                'products.featured_images',
                'products.stock_status',
                'products.average_rating',
                'products.rating_count'
            ])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // ✅ Get breadcrumbs
        $breadcrumbs = $this->getBreadcrumbsOptimized($product);
        // dd($breadcrumbs);
        // ✅ Track view (async, no performance impact)
        $this->trackProductView($product);

        return view('frontend.products.show', compact('product', 'reviews', 'relatedProducts', 'breadcrumbs'));
    }

    /**
     * Get breadcrumbs for product
     */
    protected function getBreadcrumbsOptimized($product): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Products', 'url' => route('products.index')],
        ];

        if ($product->category) {
            // Add category chain
            if ($product->category->parent) {
                $breadcrumbs[] = [
                    'name' => $product->category->parent->name,
                    'url' => route('categories.show', $product->category->parent->slug)
                ];
            }

            $breadcrumbs[] = [
                'name' => $product->category->name,
                'url' => route('categories.show', $product->category->slug)
            ];
        }

        $breadcrumbs[] = [
            'name' => $product->name,
            'url' => null
        ];

        return $breadcrumbs;
    }

    /**
     * Track product view
     */
    protected function trackProductView($product): void
    {
        // Increment view count (async job recommended for production)
        DB::table('products')
            ->where('id', $product->id)
            ->increment('views_count');
    }

    /**
     * Get products by category (alternative route)
     */
    public function category($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->active()
            ->firstOrFail();

        // Check if category hierarchy is fully active
        if (!$category->isFullyActive()) {
            abort(404, 'Category not available');
        }

        // Get all category IDs including descendants
        $categoryIds = $category->getAllCategoryIds();

        $products = Product::query()
            ->with(['category:id,name_en,name_bn,slug'])
            ->active()
            ->withActiveCategory()
            ->whereIn('category_id', $categoryIds)
            ->latest()
            ->paginate(24);

        // Get subcategories
        $subCategories = $category->children()
            ->active()
            ->withCount(['products' => function ($query) {
                $query->active()->withActiveCategory();
            }])
            ->get();

        return view('frontend.products.category', compact('category', 'products', 'subCategories'));
    }

    /**
     * Apply sorting to query
     * ✅ FIXED: Use actual database columns
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
                $query->orderBy('name_en', 'asc');  // ✅ FIXED: Use column name
                break;
            case 'name_desc':
                $query->orderBy('name_en', 'desc');  // ✅ FIXED: Use column name
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
                $query->latest('created_at');
                break;
            case 'latest':
            default:
                $query->latest('created_at');
                break;
        }
    }
}
