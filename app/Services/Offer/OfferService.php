<?php

namespace App\Services\Offer;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\Product\ProductService;

class OfferService
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Get active offers for homepage.
     */
    public function getActiveOffers(int $limit = 3): array
    {
        return Cache::remember('active_offers', 1800, function () use ($limit) {
            return Offer::active()
                ->limit($limit)
                ->get()
                ->map(function ($offer) {
                    return $this->getOfferWithProducts($offer);
                })
                ->toArray();
        });
    }

    /**
     * Get specific offer with products.
     */
    public function getOfferWithProducts(Offer $offer): array
    {
        $products = $this->getOfferProducts($offer);

        return [
            'offer' => $offer,
            'products' => $products,
            'data' => $this->prepareOfferData($offer),
        ];
    }

    /**
     * Get products for an offer.
     */
    public function getOfferProducts(Offer $offer, int $limit = null): array
    {
        $limit = $limit ?? $offer->product_limit;

        $products = match ($offer->product_source) {
            'manual' => $this->getManualProducts($offer, $limit),
            'discount' => $this->getDiscountedProducts($offer, $limit),
            'category' => $this->getCategoryProducts($offer, $limit),
            'tag' => $this->getTagProducts($offer, $limit),
            default => $this->getManualProducts($offer, $limit),
        };

        return $this->formatProductsForDisplay($products);
    }

    /**
     * Get manually selected products.
     */
    protected function getManualProducts(Offer $offer, int $limit): array
    {
        return $offer->products()
            ->with(['category'])
            ->active()
            ->limit($limit)
            ->get()
            ->map(function ($product) use ($offer) {
                return $this->applyCustomProductData($product, $offer);
            })
            ->toArray();
    }

    /**
     * Get discounted products.
     */
    protected function getDiscountedProducts(Offer $offer, int $limit): array
    {
        $config = $offer->source_config ?? [];
        $minDiscount = $config['min_discount'] ?? 10;
        $maxDiscount = $config['max_discount'] ?? 100;

        return Product::with(['category'])
            ->active()
            ->inStock()
            ->where('discount_percentage', '>=', $minDiscount)
            ->where('discount_percentage', '<=', $maxDiscount)
            ->orderBy('discount_percentage', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get products from specific category.
     */
    protected function getCategoryProducts(Offer $offer, int $limit): array
    {
        $config = $offer->source_config ?? [];
        $categoryId = $config['category_id'] ?? null;

        if (!$categoryId) {
            return [];
        }

        return Product::with(['category'])
            ->active()
            ->inStock()
            ->where('category_id', $categoryId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get products by tag.
     */
    protected function getTagProducts(Offer $offer, int $limit): array
    {
        // If you have a tagging system, implement here
        return [];
    }

    /**
     * Apply custom product data from offer pivot.
     */
    protected function applyCustomProductData($product, Offer $offer)
    {
        $pivot = $product->pivot ?? null;

        if ($pivot && $pivot->custom_data) {
            $customData = $pivot->custom_data;

            if (isset($customData['title'])) {
                $product->custom_title = $customData['title'];
            }

            if (isset($customData['image'])) {
                $product->custom_image = $customData['image'];
            }

            if (isset($customData['price_override'])) {
                $product->custom_price = $customData['price_override'];
            }
        }

        return $product;
    }

    /**
     * Format products for display.
     */
    protected function formatProductsForDisplay(array $products): array
    {
        return array_map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['custom_title'] ?? $product['name'],
                'slug' => $product['slug'],
                'original_price' => $product['custom_price'] ?? $product['price'],
                'discounted_price' => $this->calculateDiscountedPrice($product),
                'discount_percentage' => $product['discount_percentage'] ?? 0,
                'in_stock' => $product['stock_status'] === 'in_stock',
                'is_new' => $product['is_new'] ?? false,
                'images' => $this->getProductImages($product),
                'category' => $product['category']['name'] ?? null,
                'url' => route('products.show', $product['slug']),
                'add_to_cart_url' => route('cart.add', $product['id']),
                'buy_now_url' => route('checkout.process', $product['id']),
            ];
        }, $products);
    }

    /**
     * Calculate discounted price.
     */
    protected function calculateDiscountedPrice(array $product): float
    {
        $price = $product['custom_price'] ?? $product['price'];

        if (isset($product['discount_percentage']) && $product['discount_percentage'] > 0) {
            return $price * (1 - ($product['discount_percentage'] / 100));
        }

        if (isset($product['compare_price']) && $product['compare_price'] > $price) {
            return $price;
        }

        return $price;
    }

    /**
     * Get product images.
     */
    protected function getProductImages(array $product): array
    {
        $images = [];

        // Use custom image if available
        if (isset($product['custom_image'])) {
            $images[] = asset('storage/' . $product['custom_image']);
        }

        // Add featured images
        if (isset($product['featured_images']) && is_array($product['featured_images'])) {
            foreach ($product['featured_images'] as $image) {
                if (is_string($image) && !empty($image)) {
                    $images[] = strpos($image, 'http') === 0 ? $image : asset('storage/' . $image);
                }
            }
        }

        // Add gallery images
        if (isset($product['gallery_images']) && is_array($product['gallery_images'])) {
            foreach ($product['gallery_images'] as $image) {
                if (is_string($image) && !empty($image)) {
                    $images[] = strpos($image, 'http') === 0 ? $image : asset('storage/' . $image);
                }
            }
        }

        // Ensure at least one image
        if (empty($images)) {
            $images[] = asset('images/products/placeholder.jpg');
        }

        // Ensure at least two images for hover effect
        if (count($images) === 1) {
            $images[] = $images[0];
        }

        return array_slice($images, 0, 5);
    }

    /**
     * Prepare offer data for view.
     */
    protected function prepareOfferData(Offer $offer): array
    {
        return [
            'background_type' => $offer->background_type,
            'background_image' => $offer->background_url,
            'background_video' => $offer->background_video ? asset('storage/' . $offer->background_video) : null,
            'background_color' => $offer->background_color,
            'title' => $offer->title,
            'subtitle' => $offer->subtitle,
            'main_banner_image' => $offer->main_banner_url,
            'timer_enabled' => $offer->timer_enabled,
            'timer_end_date' => $offer->timer_end_date?->format('Y-m-d H:i:s'),
            'view_all_link' => $offer->formatted_view_all_link,
            'view_all_text' => $offer->view_all_text,
            'products_count' => $offer->products_count,
        ];
    }

    /**
     * Create a new offer.
     */
    public function create(array $data): Offer
    {
        return DB::transaction(function () use ($data) {
            $offer = Offer::create($data);

            if (isset($data['products'])) {
                $this->syncProducts($offer, $data['products']);
            }

            Cache::forget('active_offers');

            return $offer;
        });
    }

    /**
     * Update an offer.
     */
    public function update(Offer $offer, array $data): Offer
    {
        return DB::transaction(function () use ($offer, $data) {
            $offer->update($data);

            if (isset($data['products'])) {
                $this->syncProducts($offer, $data['products']);
            }

            Cache::forget('active_offers');

            return $offer->fresh();
        });
    }

    /**
     * Sync products for an offer.
     */
    protected function syncProducts(Offer $offer, array $products): void
    {
        $syncData = [];

        foreach ($products as $index => $product) {
            $syncData[$product['id']] = [
                'order' => $product['order'] ?? $index,
                'custom_data' => isset($product['custom_data']) ? json_encode($product['custom_data']) : null,
            ];
        }

        $offer->products()->sync($syncData);
    }

    /**
     * Delete an offer.
     */
    public function delete(Offer $offer): bool
    {
        $deleted = $offer->delete();

        if ($deleted) {
            Cache::forget('active_offers');
        }

        return $deleted;
    }

    /**
     * Record offer view.
     */
    public function recordView(Offer $offer): void
    {
        $offer->incrementViewCount();
    }

    /**
     * Record offer click.
     */
    public function recordClick(Offer $offer): void
    {
        $offer->incrementClickCount();
    }
}
