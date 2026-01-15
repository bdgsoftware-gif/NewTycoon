<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\ProductCardViewResource;
use App\Services\Category\CategoryProductsService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryProductsService;

    public function __construct(CategoryProductsService $categoryProductsService)
    {
        $this->categoryProductsService = $categoryProductsService;
    }

    /**
     * Display all categories.
     */
    public function index()
    {
        $categories = Category::active()
            ->with(['children' => function ($query) {
                $query->active()->with(['children' => function ($query) {
                    $query->active();
                }]);
            }])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $featuredCategories = Category::active()
            ->featured()
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('frontend.categories.index', compact('categories', 'featuredCategories'));
    }

    /**
     * Display a specific category with products.
     */
    public function show(Request $request, Category $category)
    {
        $search = trim($request->input('q', ''));
        $sort = $request->input('sort', 'latest');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $status = $request->input('status', 'all');

        // Get products for this category
        $productQuery = $this->categoryProductsService->getCategoryProducts(
            $category,
            $search,
            $sort,
            $minPrice,
            $maxPrice,
            $status
        );

        // Get paginated products
        $products = ProductCardViewResource::collection(
            $productQuery->paginate(12)->withQueryString()
        );

        // Get related categories for filter sidebar
        $categories = $this->categoryProductsService->getRelatedCategoriesForSearch($category, $search);

        // Get price range
        $priceRange = $this->categoryProductsService->getPriceRange($category, $search);

        // Get breadcrumb
        $breadcrumb = $category->getParentCategories();

        return view('frontend.categories.show', [
            'category' => $category,
            'products' => $products,
            'categories' => $categories,
            'priceRange' => $priceRange,
            'breadcrumb' => $breadcrumb,
            'search' => $search,
            'sort' => $sort,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'status' => $status,
            'totalProductsCount' => $category->getProductsCount($search),
        ]);
    }
}
