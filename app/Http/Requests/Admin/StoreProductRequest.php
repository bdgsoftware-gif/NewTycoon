<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Changed to true, adjust authorization as needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
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

            // Featured images (max 2)
            'featured_images' => 'nullable|array|max:2',
            'featured_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',

            // Gallery images (max 5)
            'gallery_images' => 'nullable|array|max:5',
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

            // For existing featured/gallery images (when updating)
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
            'name.required' => 'The product name is required.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'sku.required' => 'The SKU is required.',
            'sku.unique' => 'This SKU has already been taken. Please use a different SKU.',
            'price.required' => 'The price is required.',
            'price.min' => 'The price must be at least 0.',
            'compare_price.gt' => 'The compare price must be greater than the selling price.',
            'quantity.required' => 'The quantity is required.',
            'quantity.min' => 'The quantity must be at least 0.',
            'featured_images.max' => 'You can upload maximum 2 featured images.',
            'featured_images.*.image' => 'Each featured image must be an image file.',
            'featured_images.*.max' => 'Each featured image may not be greater than 2MB.',
            'gallery_images.max' => 'You can upload maximum 5 gallery images.',
            'gallery_images.*.image' => 'Each gallery image must be an image file.',
            'gallery_images.*.max' => 'Each gallery image may not be greater than 2MB.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'brand_id.exists' => 'The selected brand is invalid.',
            'status.required' => 'Please select a status.',
            'stock_status.required' => 'Please select a stock status.',
            'specifications.*.string' => 'Each specification must be a text value.',
            'specifications.*.max' => 'Each specification may not be greater than 255 characters.',
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

        // Handle empty arrays for existing images
        if (!$this->has('existing_featured_images')) {
            $this->merge(['existing_featured_images' => []]);
        }

        if (!$this->has('existing_gallery_images')) {
            $this->merge(['existing_gallery_images' => []]);
        }
    }
}
