<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'background',
        'has_content',
        'content_position',
        'badge_en',
        'badge_bn',
        'title_en',
        'title_bn',
        'subtitle_en',
        'subtitle_bn',
        'has_cta',
        'cta_buttons',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'has_content' => 'boolean',
        'has_cta' => 'boolean',
        'is_active' => 'boolean',
        'cta_buttons' => 'array',
    ];

    /** 
     * Scopes 
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getBadgeAttribute(): ?string
    {
        return App::getLocale() === 'bn'
            ? ($this->badge_bn ?: $this->badge_en)
            : $this->badge_en;
    }

    public function getTitleAttribute(): ?string
    {
        return App::getLocale() === 'bn'
            ? ($this->title_bn ?: $this->title_en)
            : $this->title_en;
    }

    public function getSubtitleAttribute(): ?string
    {
        return App::getLocale() === 'bn'
            ? ($this->subtitle_bn ?: $this->subtitle_en)
            : $this->subtitle_en;
    }
}
