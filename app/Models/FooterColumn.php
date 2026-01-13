<?php

namespace App\Models;

use App\Models\FooterLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterColumn extends Model
{
    use HasFactory;

    protected $fillable = ['title_en', 'title_bn', 'sort_order', 'is_active'];

    public function links(): HasMany
    {
        return $this->hasMany(FooterLink::class)->orderBy('sort_order');
    }

    public function activeLinks(): HasMany
    {
        return $this->hasMany(FooterLink::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'bn'
            ? ($this->title_bn ?: $this->title_en)
            : $this->title_en;
    }
}
