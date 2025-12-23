<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    public function __construct(
        protected ProductStockService $stockService,
        protected ProductPricingService $pricingService,
        protected ProductImageService $imageService
    ) {}

    /**
     * Create a new product
     */
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            // Handle images
            $data = $this->imageService->processImages($data);

            // Generate SKU if not provided
            if (empty($data['sku'])) {
                $data['sku'] = 'PROD-' . strtoupper(Str::random(8));
            }

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['name']);
            }

            // Create product
            $product = Product::create($data);

            // Initialize stock status
            $this->stockService->updateStockStatus($product);

            // Calculate discount percentage
            $this->pricingService->calculateDiscount($product);

            // Clear cache
            $this->clearCache();

            return $product->fresh();
        });
    }

    /**
     * Update product
     */
    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            // Handle images if present
            if (isset($data['featured_images']) || isset($data['gallery_images'])) {
                $data = $this->imageService->processImages($data, $product);
            }

            // Regenerate slug if name changed
            if (isset($data['name']) && $data['name'] !== $product->name) {
                $data['slug'] = $this->generateUniqueSlug($data['name'], $product->id);
            }

            $product->update($data);

            // Update stock status if quantity changed
            if (isset($data['quantity'])) {
                $this->stockService->updateStockStatus($product);
            }

            // Recalculate pricing
            $this->pricingService->calculateDiscount($product);

            // Clear cache
            $this->clearCache();

            return $product->fresh();
        });
    }

    /**
     * Delete product
     */
    public function delete(Product $product): bool
    {
        // Delete associated images first
        $this->imageService->deleteProductImages($product);

        $deleted = $product->delete();

        if ($deleted) {
            $this->clearCache();
        }

        return $deleted;
    }

    /**
     * Get product by slug
     */
    public function getBySlug(string $slug): ?Product
    {
        return Cache::remember("product.slug.{$slug}", 3600, function () use ($slug) {
            return Product::with(['category', 'vendor', 'reviews'])
                ->where('slug', $slug)
                ->active()
                ->first();
        });
    }

    /**
     * Get products for homepage
     */
    public function getHomepageProducts(array $options = []): array
    {
        return Cache::remember('homepage.products', 1800, function () use ($options) {
            $limit = $options['limit'] ?? 12;

            return [
                'featured' => $this->getFeaturedProducts($limit),
                'new_arrivals' => $this->getNewArrivals($limit),
                'bestsells' => $this->getBestsells($limit),
                'recommended' => $this->getRecommendedProducts($limit),
            ];
        });
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 12)
    {
        return Product::with(['category'])
            ->featured()
            ->active()
            ->inStock()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get new arrivals
     */
    public function getNewArrivals(int $limit = 12)
    {
        return Product::with(['category'])
            ->new()
            ->active()
            ->inStock()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get bestsellers
     */
    public function getBestsells(int $limit = 12)
    {
        return Product::with(['category'])
            ->bestsell()
            ->active()
            ->inStock()
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recommended products
     */
    public function getRecommendedProducts(int $limit = 12)
    {
        // This could be based on user history, ratings, or similar products
        return Product::with(['category'])
            ->active()
            ->inStock()
            ->orderBy('average_rating', 'desc')
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory(Category $category, array $filters = [], int $perPage = 24)
    {
        $query = Product::with(['category'])
            ->active()
            ->where('category_id', $category->id);

        // Apply filters
        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            $query->priceRange($filters['min_price'], $filters['max_price']);
        }

        if (isset($filters['sort'])) {
            $this->applySorting($query, $filters['sort']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Search products
     */
    public function search(string $query, array $filters = [], int $perPage = 24)
    {
        $searchQuery = Product::with(['category'])
            ->active()
            ->search($query);

        // Apply filters
        if (isset($filters['category_id'])) {
            $searchQuery->byCategory($filters['category_id']);
        }

        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            $searchQuery->priceRange($filters['min_price'], $filters['max_price']);
        }

        if (isset($filters['sort'])) {
            $this->applySorting($searchQuery, $filters['sort']);
        }

        return $searchQuery->paginate($perPage);
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

    /**
     * Generate unique slug
     */
    protected function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        $query = Product::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count++;
            $query = Product::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Clear product cache
     */
    protected function clearCache(): void
    {
        Cache::forget('homepage.products');
        Cache::tags(['products'])->flush();
    }
}
