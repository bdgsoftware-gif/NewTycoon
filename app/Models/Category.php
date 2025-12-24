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

    //   Scope a query to include categories with products matching search.

    public function scopeWithProductsMatchingSearch($query, $search)
    {
        if (empty($search)) {
            return $query->withActiveProducts();
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhereHas('products', function ($q) use ($search) {
                    $q->active()->search($search);
                })
                ->orWhereHas('children.products', function ($q) use ($search) {
                    $q->active()->search($search);
                });
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

    public function getAllProducts()
    {
        $categoryIds = array_merge([$this->id], $this->getAllDescendantIds());

        return Product::whereIn('category_id', $categoryIds);
    }


    // Get products count including all descendants.

    public function getTotalProductsCountAttribute()
    {
        if (!$this->relationLoaded('descendantsProductsCount')) {
            $categoryIds = array_merge([$this->id], $this->getAllDescendantIds());

            // Get the search term from the request
            $search = request('q', '');

            $query = Product::active()->whereIn('category_id', $categoryIds);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->search($search)
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                });
            }

            return $query->count();
        }

        return $this->descendantsProductsCount;
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
    public function productsQuery($search = null)
    {
        $categoryIds = $this->getAllCategoryIds();

        $query = Product::active()->whereIn('category_id', $categoryIds);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->search($search);
            });
        }

        return $query;
    }

    /**
     * Get product count for search
     */
    public function getProductsCountForSearch($search = null): int
    {
        return $this->productsQuery($search)->count();
    }

    /**
     * Get all categories that should be shown for a search
     */
    public static function getCategoriesForSearch($search = null)
    {
        if (empty($search)) {
            return self::active()
                ->withActiveProducts()
                ->with(['children' => function ($query) {
                    $query->active()
                        ->withActiveProducts()
                        ->orderBy('order');
                }])
                ->whereNull('parent_id')
                ->orderBy('order')
                ->get();
        }

        // Get category IDs that match the search
        $matchingCategoryIds = self::active()
            ->where('name', 'LIKE', "%{$search}%")
            ->pluck('id')
            ->toArray();

        // Get category IDs that have products matching the search
        $productMatchingCategoryIds = Product::active()
            ->search($search)
            ->pluck('category_id')
            ->toArray();

        // Get parent category IDs for all matching categories
        $allMatchingIds = array_merge($matchingCategoryIds, $productMatchingCategoryIds);
        $allCategoryIds = [];

        foreach ($allMatchingIds as $categoryId) {
            $category = self::find($categoryId);
            if ($category) {
                $allCategoryIds = array_merge($allCategoryIds, $category->getAllCategoryIds());
            }
        }

        // Remove duplicates
        $allCategoryIds = array_unique($allCategoryIds);

        // Get all unique parent category IDs from the matching categories
        $parentCategoryIds = self::whereIn('id', $allCategoryIds)
            ->pluck('parent_id')
            ->filter()
            ->unique()
            ->toArray();

        // Combine all category IDs
        $finalCategoryIds = array_merge($allCategoryIds, $parentCategoryIds);
        $finalCategoryIds = array_unique($finalCategoryIds);

        // Get the categories and build hierarchy
        return self::active()
            ->whereIn('id', $finalCategoryIds)
            ->with(['children' => function ($query) use ($finalCategoryIds) {
                $query->active()
                    ->whereIn('id', $finalCategoryIds)
                    ->orderBy('order');
            }])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
    }
}
