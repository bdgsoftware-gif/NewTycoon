<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'brand_description_en',
        'brand_description_bn',
        'product_image',
        'product_link',
        'payment_methods',
        'social_links'
    ];

    protected $casts = [
        'payment_methods' => 'array',
        'social_links' => 'array'
    ];

    public function getBrandDescriptionAttribute(): string
    {
        return app()->getLocale() === 'bn'
            ? ($this->brand_description_bn ?: $this->brand_description_en)
            : $this->brand_description_en;
    }
}
