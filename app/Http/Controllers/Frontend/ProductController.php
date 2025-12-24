<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailsResource;
use App\Services\Product\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 24);
        $search = $request->get('search');
        $categoryId = $request->get('category_id');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sort = $request->get('sort', 'newest');
        $status = $request->get('status');

        $query = Product::with(['category'])
            ->when($search, function ($q) use ($search) {
                $q->search($search);
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->byCategory($categoryId);
            })
            ->when($minPrice && $maxPrice, function ($q) use ($minPrice, $maxPrice) {
                $q->priceRange($minPrice, $maxPrice);
            })
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            });

        // Apply sorting
        $this->applySorting($query, $sort);

        $products = $query->paginate($perPage);

        return ProductDetailsResource::collection($products);
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
    public function show(Product $product)
    {
        $product->load(['category', 'vendor', 'reviews.user']);

        return new ProductDetailsResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->update($product, $request->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductDetailsResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Get homepage products
     */
    public function homepage()
    {
        $products = $this->productService->getHomepageProducts();

        return response()->json([
            'data' => $products
        ]);
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        $filters = $request->only(['category_id', 'min_price', 'max_price', 'sort']);
        $perPage = $request->get('per_page', 24);

        if (!$search) {
            return response()->json(['data' => []], 400);
        }

        $products = $this->productService->search($search, $filters, $perPage);

        return ProductDetailsResource::collection($products);
    }

    /**
     * Get products by category
     */
    public function byCategory(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $filters = $request->only(['min_price', 'max_price', 'sort']);
        $perPage = $request->get('per_page', 24);

        $products = $this->productService->getProductsByCategory($category, $filters, $perPage);

        return ProductDetailsResource::collection($products);
    }

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
