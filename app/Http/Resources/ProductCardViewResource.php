<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCardViewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'price' => (float) $this->price,
            'compare_price' => (float) $this->compare_price,
            'discount_percentage' => (int) $this->discount_percentage,

            'is_new' => (bool) $this->is_new,
            'in_stock' => $this->stock_status === 'in_stock',
            'is_featured' => (bool) $this->is_featured,

            'image' => data_get($this->featured_images, '0'),
        ];
    }
}
