<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function suggest(Request $request)
    {
        try {
            $query = $request->input('q', '');

            if (empty($query) || strlen($query) < 2) {
                return response()->json([]);
            }

            // Search products
            $products = Product::where('status', 'active')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('sku', 'LIKE', "%{$query}%")
                        ->orWhere('short_description', 'LIKE', "%{$query}%");
                })
                ->limit(8)
                ->get(['id', 'name', 'slug', 'price', 'featured_image', 'stock_status', 'is_new', 'discount_percentage']);

            // Search categories
            $categories = Category::where('is_active', true)
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
                    'image' => $this->getImageUrl($product->featured_image),
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

    public function search(Request $request)
    {
        $search = $request->input('q', '');
        $sort = $request->input('sort', 'latest');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $status = $request->input('status', 'all');

        // Base query for products
        $query = Product::query()->where('status', 'active');

        // Apply search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('sku', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Apply category filter
        if ($category) {
            $query->where('category_id', $category);
        }

        // Apply price range
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Apply status filters
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
            case 'featured':
                $query->where('is_featured', true);
                break;
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
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Get products with pagination
        $products = $query->paginate(12)->withQueryString();

        // Get categories for filter sidebar
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('order')
            ->get();

        // Get price range
        $priceRange = [
            'min' => Product::min('price') ?? 0,
            'max' => Product::max('price') ?? 10000
        ];

        // Prepare search results data
        $products->getCollection()->transform(function ($product) {
            $product->discounted_price = $product->discount_percentage > 0
                ? $product->price - ($product->price * $product->discount_percentage / 100)
                : $product->price;

            $product->original_price = $product->price;
            $product->in_stock = $product->stock_status === 'in_stock';

            return $product;
        });

        return view('frontend.search.results', compact(
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
}
