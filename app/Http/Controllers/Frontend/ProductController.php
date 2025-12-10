<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index(Request $request)
    {
        // $footerController = new FooterController();
        // $footerData = $footerController->getFooterData();
        // $homeController = new HomeController();
        // $navigation = $homeController->getNavigation();
        // Get filter parameters
        $search = $request->query('search');
        $category = $request->query('category');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sort = $request->query('sort', 'latest');
        $status = $request->query('status', 'all');

        // Start query
        $query = Product::active();

        // Apply search filter
        if ($search) {
            $query->search($search);
        }

        // Apply category filter
        if ($category) {
            $query->byCategory($category);
        }

        // Apply price range filter
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Apply status filter
        if ($status !== 'all') {
            switch ($status) {
                case 'in_stock':
                    $query->inStock();
                    break;
                case 'new':
                    $query->new();
                    break;
                case 'featured':
                    $query->featured();
                    break;
                case 'bestseller':
                    $query->bestseller();
                    break;
                case 'discounted':
                    $query->where('compare_price', '>', 0)
                        ->whereColumn('compare_price', '>', 'price');
                    break;
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
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get paginated products
        $products = $query->paginate(20);

        // Transform products for frontend
        $products->getCollection()->transform(function ($product) {
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'original_price' => (float) $product->price,
                'discounted_price' => $product->compare_price > $product->price
                    ? (float) $product->price
                    : (float) $product->price,
                'discount_percentage' => (int) $product->discount_percentage ?? 0,
                'images' => $product->gallery_images_urls,
                'in_stock' => $product->in_stock,
                'is_new' => $product->is_new,
                'rating' => (float) $product->average_rating,
                'review_count' => $product->rating_count,
                'stock_status' => $product->stock_status,
                'short_description' => $product->short_description,
            ];
        });

        // Get categories for filter dropdown (if you have a Category model)
        $categories = Category::active()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // Get price range for filter
        $priceRange = [
            'min' => (int) Product::active()->min('price'),
            'max' => (int) Product::active()->max('price'),
        ];

        // dd(compact(
        //     'products',
        //     'categories',
        //     'priceRange',
        //     'search',
        //     'category',
        //     'minPrice',
        //     'maxPrice',
        //     'sort',
        //     'status'
        // ));

        return view('frontend.products.index', compact(
            // 'navigation',
            // 'footerData',
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
}
