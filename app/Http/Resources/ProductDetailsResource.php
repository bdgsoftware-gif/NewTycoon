<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'compare_price' => $this->compare_price,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'quantity' => $this->quantity,
            'alert_quantity' => $this->alert_quantity,
            'track_quantity' => $this->track_quantity,
            'allow_backorder' => $this->allow_backorder,
            'model_number' => $this->model_number,
            'warranty_period' => $this->warranty_period,
            'warranty_type' => $this->warranty_type,
            'specifications' => $this->specifications_array,
            'featured_images' => $this->featured_images_urls,
            'gallery_images' => $this->gallery_images_urls,
            'dimensions' => [
                'weight' => $this->weight,
                'length' => $this->length,
                'width' => $this->width,
                'height' => $this->height,
            ],
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
                'keywords' => $this->meta_keywords,
            ],
            'flags' => [
                'is_featured' => $this->is_featured,
                'is_bestsells' => $this->is_bestsells,
                'is_new' => $this->is_new,
            ],
            'status' => $this->status,
            'stock_status' => $this->stock_status,
            'in_stock' => $this->in_stock,
            'is_low_stock' => $this->is_low_stock,
            'ratings' => [
                'average' => $this->average_rating,
                'count' => $this->rating_count,
            ],
            'sales' => [
                'total_sold' => $this->total_sold,
                'total_revenue' => $this->total_revenue,
            ],
            'profit' => [
                'margin' => $this->profit_margin,
                'per_unit' => $this->profit_per_unit,
            ],
            'category' => $this->whenLoaded('category', function () {
                return new CategoryResource($this->category);
            }),
            'vendor' => $this->whenLoaded('vendor', function () {
                return new UserResource($this->vendor);
            }),
            'reviews' => $this->whenLoaded('reviews', function () {
                return ReviewResource::collection($this->reviews);
            }),
            'url' => $this->url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Customize the response for a given request.
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'version' => '1.0.0',
                'api_version' => 'v1',
            ],
        ];
    }
}
