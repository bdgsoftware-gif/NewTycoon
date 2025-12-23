<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'parent_id' => $this->parent_id,

            // Ordering
            'order' => $this->order,
            'nav_order' => $this->nav_order,

            // Flags
            'is_featured' => $this->is_featured,
            'show_in_nav' => $this->show_in_nav,
            'is_active' => $this->is_active,

            // SEO
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
                'keywords' => $this->meta_keywords,
            ],

            // Relations
            'children' => $this->whenLoaded(
                'children',
                fn() =>
                CategoryResource::collection($this->children)
            ),

            // Helpers
            'url' => $this->url,
            'full_path' => $this->full_path,
            'has_children' => $this->hasChildren(),

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
