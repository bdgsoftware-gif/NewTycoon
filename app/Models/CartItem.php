<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'options'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'options' => 'array'
    ];

    /**
     * Get the cart
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get item total
     */
    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    /**
     * Get formatted options
     */
    public function getFormattedOptionsAttribute()
    {
        if (!$this->options) {
            return '';
        }
        
        return collect($this->options)
            ->map(function ($value, $key) {
                return ucfirst($key) . ': ' . $value;
            })
            ->implode(', ');
    }
}