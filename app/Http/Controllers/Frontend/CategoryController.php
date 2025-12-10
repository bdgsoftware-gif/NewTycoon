<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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
     * Display a single category and its products.
     */
    public function show(Request $request, Category $category)
    {
        // Get filter parameters
        $search = $request->query('search');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sort = $request->query('sort', 'latest');
        $status = $request->query('status', 'all');

        // Get all category IDs including descendants
        $categoryIds = $this->getAllCategoryIds($category);

        // Start query
        $query = Product::active()
            ->whereIn('category_id', $categoryIds);

        // Apply search filter
        if ($search) {
            $query->search($search);
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
        $products = $query->paginate(12);

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
                'discount_percentage' => $product->compare_price > $product->price
                    ? round((($product->compare_price - $product->price) / $product->compare_price) * 100)
                    : 0,
                'images' => $product->gallery_images_urls,
                'in_stock' => $product->in_stock,
                'is_new' => $product->is_new,
                'rating' => (float) $product->average_rating,
                'review_count' => $product->rating_count,
                'stock_status' => $product->stock_status,
                'short_description' => $product->short_description,
            ];
        });

        // Get subcategories
        $subcategories = Category::active()
            ->where('parent_id', $category->id)
            ->orderBy('order')
            ->get();

        // Get breadcrumb
        $breadcrumb = $this->getBreadcrumb($category);

        return view('frontend.categories.show', compact(
            'category',
            'products',
            'subcategories',
            'breadcrumb',
            'search',
            'minPrice',
            'maxPrice',
            'sort',
            'status'
        ));
    }

    /**
     * Get all category IDs including descendants.
     */
    private function getAllCategoryIds(Category $category)
    {
        $ids = [$category->id];

        // Get all children recursively
        $this->getDescendantIds($category, $ids);

        return $ids;
    }

    /**
     * Recursively get descendant category IDs.
     */
    private function getDescendantIds(Category $category, &$ids)
    {
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            $this->getDescendantIds($child, $ids);
        }
    }

    /**
     * Get breadcrumb for category.
     */
    private function getBreadcrumb(Category $category)
    {
        $breadcrumb = collect([$category]);
        $parent = $category->parent;

        while ($parent) {
            $breadcrumb->prepend($parent);
            $parent = $parent->parent;
        }

        return $breadcrumb;
    }
}
