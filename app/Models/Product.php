<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        'featured_image',
        'gallery_images',
        'weight',
        'length',
        'width',
        'height',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'is_bestseller',
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
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'quantity' => 'integer',
        'alert_quantity' => 'integer',
        'track_quantity' => 'boolean',
        'allow_backorder' => 'boolean',
        'gallery_images' => 'array',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_new' => 'boolean',
        'average_rating' => 'decimal:2',
        'rating_count' => 'integer',
        'total_sold' => 'integer',
        'total_revenue' => 'decimal:2',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'cost_price',
        'vendor_id',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Generate SKU if not provided
            if (empty($product->sku)) {
                $product->sku = 'PROD-' . strtoupper(Str::random(8));
            }

            // Generate slug if not provided
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            // Ensure unique slug
            $originalSlug = $product->slug;
            $count = 1;
            while (static::where('slug', $product->slug)->exists()) {
                $product->slug = $originalSlug . '-' . $count++;
            }
        });

        static::updating(function ($product) {
            // Update slug if name changed
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            // Update stock status based on quantity
            if ($product->isDirty('quantity')) {
                $product->updateStockStatus();
            }
        });

        static::saving(function ($product) {
            // Calculate discount percentage
            if ($product->compare_price > $product->price) {
                $product->discount_percentage = round(($product->compare_price - $product->price) / $product->compare_price * 100);
            } else {
                $product->discount_percentage = 0;
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the vendor that owns the product.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Get the product's reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the product's order items.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the product's wishlist items.
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Update stock status based on quantity.
     */
    public function updateStockStatus()
    {
        if ($this->quantity <= 0) {
            if ($this->allow_backorder) {
                $this->stock_status = 'backorder';
            } else {
                $this->stock_status = 'out_of_stock';
            }
        } else {
            $this->stock_status = 'in_stock';
        }

        if (!$this->isDirty('stock_status')) {
            $this->saveQuietly(['stock_status']);
        }
    }

    /**
     * Check if product is in stock.
     */
    public function getInStockAttribute()
    {
        return $this->stock_status === 'in_stock' || $this->stock_status === 'backorder';
    }

    /**
     * Get the discount amount.
     */
    public function getDiscountAmountAttribute()
    {
        if ($this->compare_price > $this->price) {
            return $this->compare_price - $this->price;
        }

        return 0;
    }

    /**
     * Get the product's main image URL.
     */
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            if (strpos($this->featured_image, 'http') === 0) {
                return $this->featured_image;
            }

            return Storage::url($this->featured_image);
        }

        return asset('images/products/fr-06.jpg');
    }

    /**
     * Get the product's gallery images URLs.
     */
    public function getGalleryImagesUrlsAttribute()
    {
        if (!$this->gallery_images || empty($this->gallery_images)) {
            return [$this->featured_image_url];
        }

        return array_map(function ($image) {
            if (strpos($image, 'http') === 0) {
                return $image;
            }

            return Storage::url($image);
        }, $this->gallery_images);
    }

    /**
     * Get the product's URL.
     */
    public function getUrlAttribute()
    {
        return route('products.show', $this->slug);
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
    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
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
                ->orWhere('short_description', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
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

    /**
     * Increment sold quantity and revenue.
     */
    public function incrementSold($quantity, $price)
    {
        $this->increment('total_sold', $quantity);
        $this->increment('total_revenue', $quantity * $price);

        if ($this->track_quantity) {
            $this->decrement('quantity', $quantity);
            $this->updateStockStatus();
        }
    }

    /**
     * Decrement sold quantity and revenue (for refunds/cancellations).
     */
    public function decrementSold($quantity, $price)
    {
        $this->decrement('total_sold', $quantity);
        $this->decrement('total_revenue', $quantity * $price);

        if ($this->track_quantity) {
            $this->increment('quantity', $quantity);
            $this->updateStockStatus();
        }
    }

    /**
     * Check if product quantity is low.
     */
    public function getIsLowStockAttribute()
    {
        return $this->quantity <= $this->alert_quantity;
    }

    /**
     * Calculate profit margin.
     */
    public function getProfitMarginAttribute()
    {
        if ($this->cost_price > 0 && $this->price > 0) {
            return (($this->price - $this->cost_price) / $this->price) * 100;
        }

        return 0;
    }

    /**
     * Calculate profit per unit.
     */
    public function getProfitPerUnitAttribute()
    {
        return $this->price - $this->cost_price;
    }
}
