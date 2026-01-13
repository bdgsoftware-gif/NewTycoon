<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'footer_column_id',
        'title_en',
        'title_bn',
        'url',
        'sort_order',
        'is_active'
    ];

    public function column(): BelongsTo
    {
        return $this->belongsTo(FooterColumn::class, 'footer_column_id');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'bn'
            ? ($this->title_bn ?: $this->title_en)
            : $this->title_en;
    }
}
