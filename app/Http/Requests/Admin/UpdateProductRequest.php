<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $productId = $this->route('product'); // Get product ID from route

        return [
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|gt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'alert_quantity' => 'integer|min:0',
            'track_quantity' => 'boolean',
            'allow_backorder' => 'boolean',
            'model_number' => 'nullable|string|max:100',
            'warranty_period' => 'nullable|string|max:50',
            'warranty_type' => 'nullable|in:replacement,service,parts',

            // Specifications as array
            'specifications' => 'nullable|array',
            'specifications.*' => 'string|max:255',

            // Featured images (max 2, but consider existing ones)
            'featured_images' => 'nullable|array',
            'featured_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',

            // Gallery images (max 5, but consider existing ones)
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',

            // Physical dimensions
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',

            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',

            // Status flags
            'is_featured' => 'boolean',
            'is_bestsells' => 'boolean',
            'is_new' => 'boolean',
            'status' => 'required|in:draft,active,inactive,archived',
            'stock_status' => 'required|in:in_stock,out_of_stock,backorder',

            // Relationships
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',

            // For existing featured/gallery images
            'existing_featured_images' => 'nullable|array',
            'existing_gallery_images' => 'nullable|array',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'sku.unique' => 'This SKU has already been taken by another product.',
            'compare_price.gt' => 'The compare price must be greater than the selling price to show a discount.',
            'featured_images.*.image' => 'Each featured image must be a valid image file.',
            'featured_images.*.max' => 'Each featured image may not be greater than 2MB.',
            'gallery_images.*.image' => 'Each gallery image must be a valid image file.',
            'gallery_images.*.max' => 'Each gallery image may not be greater than 2MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Handle specifications array
        if ($this->has('specifications') && is_string($this->specifications)) {
            $this->merge([
                'specifications' => array_filter(
                    array_map('trim', explode("\n", $this->specifications))
                ),
            ]);
        }

        // Convert boolean fields
        $this->merge([
            'track_quantity' => $this->boolean('track_quantity'),
            'allow_backorder' => $this->boolean('allow_backorder'),
            'is_featured' => $this->boolean('is_featured'),
            'is_bestsells' => $this->boolean('is_bestsells'),
            'is_new' => $this->boolean('is_new'),
        ]);

        // Handle empty arrays
        if (!$this->has('existing_featured_images')) {
            $this->merge(['existing_featured_images' => []]);
        }

        if (!$this->has('existing_gallery_images')) {
            $this->merge(['existing_gallery_images' => []]);
        }

        if (!$this->has('featured_images')) {
            $this->merge(['featured_images' => []]);
        }

        if (!$this->has('gallery_images')) {
            $this->merge(['gallery_images' => []]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check total featured images (existing + new) don't exceed 2
            $existingFeaturedCount = count($this->existing_featured_images ?? []);
            $newFeaturedCount = count($this->featured_images ?? []);

            if ($existingFeaturedCount + $newFeaturedCount > 2) {
                $validator->errors()->add(
                    'featured_images',
                    'Total featured images cannot exceed 2. You have ' . $existingFeaturedCount . ' existing and trying to add ' . $newFeaturedCount . ' new.'
                );
            }

            // Check total gallery images (existing + new) don't exceed 5
            $existingGalleryCount = count($this->existing_gallery_images ?? []);
            $newGalleryCount = count($this->gallery_images ?? []);

            if ($existingGalleryCount + $newGalleryCount > 5) {
                $validator->errors()->add(
                    'gallery_images',
                    'Total gallery images cannot exceed 5. You have ' . $existingGalleryCount . ' existing and trying to add ' . $newGalleryCount . ' new.'
                );
            }
        });
    }
}
