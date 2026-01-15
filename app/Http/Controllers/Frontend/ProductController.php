<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailsResource;
use App\Services\Product\ActiveProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ActiveProductService $productService
    ) {}

    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 24);
        $search = $request->get('search');
        $category = $request->get('category'); // Changed from category_id to match your form
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sort = $request->get('sort', 'latest');
        $status = $request->get('status');

        $query = Product::query()
            ->with(['category'])
            ->active();

        // Apply search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($category) {
            $query->where('category_id', $category);
        }

        // Apply price range filter
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Apply status filter
        if ($status) {
            switch ($status) {
                case 'in_stock':
                    $query->where('stock_status', 'in_stock');
                    break;
                case 'new':
                    $query->where('is_new', true);
                    break;
                case 'discounted':
                    $query->where('discount_percentage', '>', 0);
                    break;
                    // 'all' case - do nothing
            }
        }

        // Apply sorting
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
            default: // 'latest'
                $query->latest();
                break;
        }

        $products = $query->paginate($perPage);

        // Get categories with product count
        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->orderBy('name')
            ->get();

        // Get price range for filter
        $priceRange = [
            'min' => (int) Product::active()->min('price'),
            'max' => (int) Product::active()->max('price'),
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
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductDetailsResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['category', 'reviews.user'])
            ->firstOrFail();

        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateProductRequest $request, Product $product)
    // {
    //     $product = $this->productService->update($product, $request->validated());

    //     return response()->json([
    //         'message' => 'Product updated successfully',
    //         'data' => new ProductDetailsResource($product)
    //     ]);
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     $this->productService->delete($product);

    //     return response()->json([
    //         'message' => 'Product deleted successfully'
    //     ]);
    // }

    /**
     * Get homepage products
     */
    // public function homepage()
    // {
    //     $products = $this->productService->getHomepageProducts();

    //     return response()->json([
    //         'data' => $products
    //     ]);
    // }

    /**
     * Search products
     */
    // public function search(Request $request)
    // {
    //     $search = $request->get('q');
    //     $filters = $request->only(['category_id', 'min_price', 'max_price', 'sort']);
    //     $perPage = $request->get('per_page', 24);

    //     if (!$search) {
    //         return response()->json(['data' => []], 400);
    //     }

    //     $products = $this->productService->search($search, $filters, $perPage);

    //     return ProductDetailsResource::collection($products);
    // }

    /**
     * Get products by category
     */
    // public function byCategory(Request $request, $categoryId)
    // {
    //     $category = Category::findOrFail($categoryId);
    //     $filters = $request->only(['min_price', 'max_price', 'sort']);
    //     $perPage = $request->get('per_page', 24);

    //     $products = $this->productService->getProductsByCategory($category, $filters, $perPage);

    //     return ProductDetailsResource::collection($products);
    // }

    /**
     * Apply sorting to query
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
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_sold', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
    }
}
