<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /* -----------------------------------------------------------------
     | Constants
     |------------------------------------------------------------------*/
    public const DEFAULT_FEATURED_IMAGE = 'products/featured/default.jpg';

    /* -----------------------------------------------------------------
     | Mass Assignment
     |------------------------------------------------------------------*/
    protected $fillable = [
        // Bilingual
        'name_en',
        'name_bn',
        'short_description_en',
        'short_description_bn',
        'description_en',
        'description_bn',

        // SEO
        'meta_title_en',
        'meta_title_bn',
        'meta_description_en',
        'meta_description_bn',
        'meta_keywords',

        // Identity
        'sku',
        'slug',

        // Pricing
        'price',
        'compare_price',
        'cost_price',
        'discount_percentage',

        // Inventory
        'quantity',
        'alert_quantity',
        'track_quantity',
        'allow_backorder',
        'stock_status',

        // Product info
        'model_number',
        'warranty_duration',
        'warranty_unit',
        'warranty_type',
        'specifications',

        // Media
        'featured_images',
        'gallery_images',

        // Shipping
        'weight',
        'length',
        'width',
        'height',

        // Flags
        'is_featured',
        'is_bestsells',
        'is_new',
        'status',

        // Relations
        'category_id',
        'brand_id',
        'vendor_id',
    ];

    /* -----------------------------------------------------------------
     | Casts
     |------------------------------------------------------------------*/
    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'discount_percentage' => 'integer',

        'quantity' => 'integer',
        'alert_quantity' => 'integer',

        'track_quantity' => 'boolean',
        'allow_backorder' => 'boolean',

        'is_featured' => 'boolean',
        'is_bestsells' => 'boolean',
        'is_new' => 'boolean',

        'featured_images' => 'array',
        'gallery_images' => 'array',
        'specifications' => 'array',

        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
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

    /* -----------------------------------------------------------------
     | Boot Logic
     |------------------------------------------------------------------*/
    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (blank($product->slug)) {
                $product->slug = $product->generateUniqueSlug($product->id);
            }

            if (blank($product->sku)) {
                $product->sku = $product->generateUniqueSku();
            }
        });
    }

    /* -----------------------------------------------------------------
     | Relationships
     |------------------------------------------------------------------*/
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

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
    /* -----------------------------------------------------------------
     | Scopes
     |------------------------------------------------------------------*/
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

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

    public function scopeInStock($query)
    {
        return $query->whereIn('stock_status', ['in_stock', 'backorder']);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name_en', 'like', "%{$term}%")
                ->orWhere('name_bn', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%")
                ->orWhere('model_number', 'like', "%{$term}%");
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
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function scopeOfferAbove($query, float $minDiscount = 10)
    {
        return $query->where(function ($q) use ($minDiscount) {
            $q->where('discount_percentage', '>=', $minDiscount);
        });
    }





    /* -----------------------------------------------------------------
     | Accessors
     |------------------------------------------------------------------*/
    public function getNameAttribute(): string
    {
        return app()->isLocale('bn')
            ? ($this->name_bn ?: $this->name_en)
            : $this->name_en;
    }

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

    public function getIsLowStockAttribute(): bool
    {
        return $this->track_quantity && $this->quantity <= $this->alert_quantity;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'bn'
            ? ($this->short_description_bn ?: $this->short_description_en)
            : $this->short_description_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'bn'
            ? ($this->description_bn ?: $this->description_en)
            : $this->description_en;
    }

    public function getWarrantyLabelAttribute(): ?string
    {
        if (!$this->warranty_duration || !$this->warranty_unit) {
            return null;
        }

        return "{$this->warranty_duration} " . ucfirst($this->warranty_unit);
    }

    public function getWarrantyExpiryDate(?Carbon $purchaseDate = null): ?Carbon
    {
        if (!$this->warranty_duration || !$this->warranty_unit) {
            return null;
        }

        $purchaseDate ??= now();

        return $purchaseDate->copy()->add(
            $this->warranty_unit,
            $this->warranty_duration
        );
    }

    /* -----------------------------------------------------------------
     | Helpers
     |------------------------------------------------------------------*/
    protected function generateUniqueSlug(?int $ignoreId = null): string
    {
        $base = Str::slug($this->name_en);
        $slug = $base;
        $i = 1;

        while (
            static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    protected function generateUniqueSku(): string
    {
        do {
            $sku = 'SKU-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
        } while (static::where('sku', $sku)->exists());

        return $sku;
    }
}
