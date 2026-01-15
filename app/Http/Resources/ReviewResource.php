<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'title' => $this->title,
            'comment' => $this->comment,
            'pros' => $this->pros ? json_decode($this->pros, true) : [],
            'cons' => $this->cons ? json_decode($this->cons, true) : [],
            'images' => $this->images ? array_map(function ($image) {
                return asset('storage/' . $image);
            }, json_decode($this->images, true)) : [],
            'is_verified_purchase' => $this->is_verified_purchase,
            'is_featured' => $this->is_featured,
            'status' => $this->status,
            'helpful_count' => $this->helpful_count,
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
            'product' => $this->whenLoaded('product', function () {
                return [
                    'id' => $this->product->id,
                    'name' => $this->product->name,
                    'slug' => $this->product->slug,
                    'image' => $this->product->featured_images_urls[0] ?? null,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
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
