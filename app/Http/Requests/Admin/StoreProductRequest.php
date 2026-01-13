<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            // Basic Information
            'name_en' => ['required', 'string', 'max:255'],
            'name_bn' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],

            // SKU & Slug
            'sku' => ['nullable', 'string', 'max:50', Rule::unique('products', 'sku')],
            'model_number' => ['nullable', 'string', 'max:100'],

            // Descriptions
            'short_description_en' => ['nullable', 'string', 'max:500'],
            'short_description_bn' => ['nullable', 'string', 'max:500'],
            'description_en' => ['required', 'string'],
            'description_bn' => ['nullable', 'string'],

            // Pricing
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'compare_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'cost_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],

            // Inventory
            'quantity' => ['required', 'integer', 'min:0', 'max:999999'],
            'alert_quantity' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'stock_status' => ['required', 'in:in_stock,out_of_stock,backorder'],
            'track_quantity' => ['boolean'],
            'allow_backorder' => ['boolean'],

            // Images
            'featured_images' => ['required', 'array', 'min:1'],
            'featured_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_images' => ['nullable', 'array', 'max:5'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            // Specifications
            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['nullable', 'string', 'max:100'],
            'specifications.*.value' => ['nullable', 'string', 'max:255'],

            // Shipping
            'weight' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'length' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'width' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'height' => ['nullable', 'numeric', 'min:0', 'max:999.99'],

            // Warranty
            'warranty_period' => ['nullable', 'string', 'max:50'],
            'warranty_type'   => ['nullable', 'in:replacement,service,parts'],


            // Status & Flags
            'status' => ['required', 'in:draft,active,inactive,archived'],
            'is_featured' => ['boolean'],
            'is_bestsells' => ['boolean'],
            'is_new' => ['boolean'],

            // SEO
            'meta_title_en' => ['nullable', 'string', 'max:70'],
            'meta_title_bn' => ['nullable', 'string', 'max:70'],
            'meta_description_en' => ['nullable', 'string', 'max:160'],
            'meta_description_bn' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
        ];

        // Add compare price validation
        if ($this->has('compare_price') && $this->compare_price > 0) {
            $rules['compare_price'][] = 'gt:price';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name_en.required' => 'English product name is required.',
            'name_en.max' => 'English name cannot exceed 255 characters.',
            'name_bn.max' => 'Bengali name cannot exceed 255 characters.',

            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',

            'sku.unique' => 'This SKU is already in use.',
            'sku.max' => 'SKU cannot exceed 50 characters.',

            'short_description_en.max' => 'English short description cannot exceed 500 characters.',
            'short_description_bn.max' => 'Bengali short description cannot exceed 500 characters.',

            'description_en.required' => 'English description is required.',

            'price.required' => 'Price is required.',
            'price.min' => 'Price cannot be negative.',
            'price.max' => 'Price is too high.',

            'compare_price.gt' => 'Compare price must be greater than regular price.',

            'quantity.required' => 'Quantity is required.',
            'quantity.min' => 'Quantity cannot be negative.',

            'stock_status.required' => 'Stock status is required.',
            'stock_status.in' => 'Invalid stock status.',

            'featured_images.required' => 'At least one featured image is required.',
            'featured_images.min' => 'At least one featured image is required.',
            'featured_images.*.image' => 'Featured images must be valid image files.',
            'featured_images.*.mimes' => 'Featured images must be JPG, JPEG, PNG, or WEBP.',
            'featured_images.*.max' => 'Featured images cannot exceed 5MB.',

            'gallery_images.max' => 'Maximum 5 gallery images allowed.',
            'gallery_images.*.image' => 'Gallery images must be valid image files.',
            'gallery_images.*.mimes' => 'Gallery images must be JPG, JPEG, PNG, or WEBP.',
            'gallery_images.*.max' => 'Gallery images cannot exceed 5MB.',

            'specifications.*.key.max' => 'Specification key cannot exceed 100 characters.',
            'specifications.*.value.max' => 'Specification value cannot exceed 255 characters.',

            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status.',

            'meta_title_en.max' => 'English meta title cannot exceed 70 characters.',
            'meta_title_bn.max' => 'Bengali meta title cannot exceed 70 characters.',
            'meta_description_en.max' => 'English meta description cannot exceed 160 characters.',
            'meta_description_bn.max' => 'Bengali meta description cannot exceed 160 characters.',

            'warranty_type.in' => 'Warranty type must be days, months, or years.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Ensure boolean values
        $booleans = ['track_quantity', 'allow_backorder', 'is_featured', 'is_bestsells', 'is_new'];

        foreach ($booleans as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => filter_var($this->$field, FILTER_VALIDATE_BOOLEAN),
                ]);
            } else {
                $this->merge([$field => false]);
            }
        }

        // Set default values if not provided
        if (!$this->has('alert_quantity')) $this->merge(['alert_quantity' => 5]);
        if (!$this->has('discount_percentage')) $this->merge(['discount_percentage' => 0]);

        // Clean up specifications array
        if ($this->has('specifications') && is_array($this->specifications)) {
            $cleanSpecs = [];
            foreach ($this->specifications as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $cleanSpecs[] = [
                        'key' => trim($spec['key']),
                        'value' => trim($spec['value'])
                    ];
                }
            }
            $this->merge(['specifications' => $cleanSpecs]);
        }

        // Clean up empty strings to null for optional bilingual fields
        $nullableFields = [
            'name_bn',
            'short_description_en',
            'short_description_bn',
            'description_bn',
            'meta_title_en',
            'meta_title_bn',
            'meta_description_en',
            'meta_description_bn',
            'meta_keywords'
        ];

        foreach ($nullableFields as $field) {
            if (blank($this->input($field))) {
                $this->merge([$field => null]);
            }
        }
    }
}
