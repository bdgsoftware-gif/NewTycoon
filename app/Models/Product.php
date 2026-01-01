<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'slug',
        'short_description',
        'description',
        'price',
        'compare_price',
        'cost_price',
        'quantity',
        'alert_quantity',
        'track_quantity',
        'allow_backorder',
        'model_number',
        'warranty_period',
        'warranty_type',
        'specifications',
        'featured_images',
        'gallery_images',
        'weight',
        'length',
        'width',
        'height',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'is_bestsells',
        'is_new',
        'status',
        'stock_status',
        'average_rating',
        'rating_count',
        'total_sold',
        'total_revenue',
        'category_id',
        'brand_id',
        'vendor_id',
        'discount_percentage',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'quantity' => 'integer',
        'alert_quantity' => 'integer',
        'track_quantity' => 'boolean',
        'allow_backorder' => 'boolean',
        'specifications' => 'array',
        'featured_images' => 'array',
        'gallery_images' => 'array',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_bestsells' => 'boolean',
        'is_new' => 'boolean',
        'average_rating' => 'decimal:2',
        'rating_count' => 'integer',
        'total_sold' => 'integer',
        'total_revenue' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
    ];

    protected $hidden = [
        'cost_price',
        'vendor_id',
    ];

    protected $appends = [
        'in_stock',
        'discount_amount',
        'featured_images_urls',
        'gallery_images_urls',
        'url',
        'is_low_stock',
        'profit_margin',
        'profit_per_unit',
        'specifications_array',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            // Generate slug once (if missing)
            if (blank($product->slug)) {
                $product->slug = $product->generateUniqueSlug();
            }

            // Generate SKU (if missing)
            if (blank($product->sku)) {
                $product->sku = $product->generateUniqueSku();
            }
        });
    }

    /**
     * Generate unique slug
     */
    public function generateUniqueSlug(?int $excludeId = null): string
    {
        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            static::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate unique SKU
     */
    public function generateUniqueSku(): string
    {
        do {
            $sku = 'SKU-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
        } while (static::where('sku', $sku)->exists());

        return $sku;
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * Get the product's reviews.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the product's order items.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the product's wishlist items.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include bestseller products.
     */
    public function scopeBestsell($query)
    {
        return $query->where('is_bestsells', true);
    }

    /**
     * Scope a query to only include new products.
     */
    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('stock_status', 'in_stock')
                ->orWhere('stock_status', 'backorder');
        });
    }

    /**
     * Scope a query to search products.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('sku', 'LIKE', "%{$search}%")
                ->orWhere('model_number', 'LIKE', "%{$search}%")
                ->orWhere('short_description', 'LIKE', "%{$search}%");
        });
    }


    /**
     * Scope a query to filter by price range.
     */
    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeWithActiveCategory($query)
    {
        return $query->whereHas('category', fn($q) => $q->active());
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock_status === 'in_stock';
    }

    public function scopeOfferAbove($query, float $minDiscount = 10)
    {
        return $query->where(function ($q) use ($minDiscount) {
            $q->where('discount_percentage', '>=', $minDiscount);
        });
    }

    // Single Image fetching
    public function getFeaturedImageUrlAttribute(): string
    {
        $image = $this->featured_images[0] ?? null;

        return $image
            ? asset('storage/' . $image)
            : asset('images/no-image.jpg');
    }
    // Multiple Images fetching
    public function getFeaturedImagesUrlsAttribute(): array
    {
        return collect($this->featured_images ?? [])
            ->map(fn($img) => asset('storage/' . $img))
            ->toArray();
    }
}
