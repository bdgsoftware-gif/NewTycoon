<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'brand_description',
        'product_image',
        'product_link',
        'payment_methods',
        'social_links'
    ];

    protected $casts = [
        'payment_methods' => 'array',
        'social_links' => 'array'
    ];
}
