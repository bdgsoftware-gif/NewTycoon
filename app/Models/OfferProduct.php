<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferProduct extends Model
{
    use HasFactory;

    protected $table = 'offer_products';

    protected $fillable = [
        'offer_id',
        'product_id',
        'order',
        'custom_data',
    ];

    protected $casts = [
        'custom_data' => 'array',
    ];

    /**
     * Get the offer.
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
