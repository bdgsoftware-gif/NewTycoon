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
        'name_en',
        'name_bn',
        'description_en',
        'description_bn',
        'slug',
        'image',
        'parent_id',
        'order',
        'nav_order',
        'is_featured',
        'show_in_nav',
        'is_active',
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
                $category->slug = Str::slug($category->name_en);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name_en') && empty($category->slug)) {
                $category->slug = Str::slug($category->name_en);
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
     * Get all category IDs including descendants
     */
    public function getAllCategoryIds(): array
    {
        return array_merge([$this->id], $this->getAllDescendantIds());
    }

    /**
     * Get products query for category with search
     */
    public function getProductsQuery(?string $search = null)
    {
        $categoryIds = $this->getAllCategoryIds();

        return Product::active()
            ->whereIn('category_id', $categoryIds)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->search($search)
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                });
            });
    }

    /**
     * Get product count for category with search
     */
    public function getProductsCount(?string $search = null): int
    {
        return $this->getProductsQuery($search)->count();
    }

    /**
     * Get parent categories
     */
    public function getParentCategories()
    {
        $parents = collect();
        $parent = $this->parent;

        while ($parent) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'bn'
            ? ($this->name_bn ?: $this->name_en)
            : $this->name_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'bn'
            ? ($this->description_bn ?: $this->description_en)
            : $this->description_en;
    }
}
