<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'background_type',
        'background_image',
        'background_video',
        'background_color',
        'main_banner_image',
        'timer_enabled',
        'timer_end_date',
        'view_all_link',
        'view_all_text',
        'product_source',
        'source_config',
        'product_limit',
        'status',
        'start_date',
        'end_date',
        'order',
        'view_count',
        'click_count',
    ];

    protected $casts = [
        'timer_enabled' => 'boolean',
        'timer_end_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'source_config' => 'array',
        'view_count' => 'integer',
        'click_count' => 'integer',
    ];

    protected $appends = [
        'is_active',
        'products_count',
        'background_url',
        'main_banner_url',
        'time_left',
    ];

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        parent::boot();

        static::creating(function ($offer) {
            if (empty($offer->slug)) {
                $offer->slug = Str::slug($offer->title);
            }
        });

        static::saved(function () {
            Cache::forget('active_offers');
        });

        static::deleted(function () {
            Cache::forget('active_offers');
        });
    }

    /**
     * Get the products for this offer.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'offer_products')
            ->withPivot(['order', 'custom_data'])
            ->orderBy('offer_products.order')
            ->withTimestamps();
    }

    /**
     * Get active offers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('order')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Check if offer is currently active.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' &&
            (!$this->start_date || $this->start_date <= now()) &&
            (!$this->end_date || $this->end_date >= now());
    }

    /**
     * Get products count.
     */
    public function getProductsCountAttribute(): int
    {
        return Cache::remember("offer.{$this->id}.products_count", 3600, function () {
            return $this->products()->count();
        });
    }

    /**
     * Get background URL.
     */
    public function getBackgroundUrlAttribute(): ?string
    {
        if ($this->background_type === 'color' && $this->background_color) {
            return null;
        }

        if ($this->background_image) {
            return asset('storage/' . $this->background_image);
        }

        return asset('images/offers/default-bg.jpg');
    }

    /**
     * Get main banner URL.
     */
    public function getMainBannerUrlAttribute(): ?string
    {
        if ($this->main_banner_image) {
            return asset('storage/' . $this->main_banner_image);
        }

        return asset('images/offers/main-banner.jpeg');
    }

    /**
     * Get time left in seconds.
     */
    public function getTimeLeftAttribute(): ?int
    {
        if (!$this->timer_enabled || !$this->timer_end_date) {
            return null;
        }

        return max(0, $this->timer_end_date->diffInSeconds(now()));
    }

    /**
     * Increment view count.
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Increment click count.
     */
    public function incrementClickCount(): void
    {
        $this->increment('click_count');
    }

    /**
     * Get formatted view all link.
     */
    public function getFormattedViewAllLinkAttribute(): string
    {
        if (!$this->view_all_link) {
            return route('products.index');
        }

        if (Str::startsWith($this->view_all_link, ['http://', 'https://', '/'])) {
            return $this->view_all_link;
        }

        try {
            return route($this->view_all_link);
        } catch (\Exception $e) {
            return '#';
        }
    }
}
