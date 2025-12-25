<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',

        // Ordering
        'order',
        'nav_order',

        // Flags
        'is_featured',
        'show_in_nav',
        'is_active',

        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'show_in_nav' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'nav_order' => 'integer',
    ];

    /* ---------------------------------
     | Boot
     |---------------------------------*/
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /* ---------------------------------
     | Relationships
     |---------------------------------*/
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('nav_order')
            ->orderBy('order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all ancestors (parent, grandparent, etc.).
     */

    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }
    /* ---------------------------------
     | Scopes
     |---------------------------------*/
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeShowInNav($query)
    {
        return $query->where('show_in_nav', true);
    }

    public function scopeWithActiveProducts($query)
    {
        return $query->whereHas('products', function ($q) {
            $q->active();
        });
    }

    /* ---------------------------------
     | Accessors
     |---------------------------------*/
    public function getUrlAttribute(): string
    {
        return route('categories.show', $this->slug);
    }

    public function getFullPathAttribute(): string
    {
        $path = collect([$this->name]);
        $parent = $this->parent;

        while ($parent) {
            $path->prepend($parent->name);
            $parent = $parent->parent;
        }

        return $path->implode(' > ');
    }

    /* ---------------------------------
     | Helpers
     |---------------------------------*/
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function getAllDescendantIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }

        return $ids;
    }

    /**
     * Get all category IDs (including self and all descendants)
     */
    public function getAllCategoryIds(): array
    {
        return array_merge([$this->id], $this->getAllDescendantIds());
    }

    /**
     * Get products query for this category (including descendants)
     */
  

    /**
     * Get product count for search
     */
   

    /**
     * Get all categories that should be shown for a search
     */
   
}
