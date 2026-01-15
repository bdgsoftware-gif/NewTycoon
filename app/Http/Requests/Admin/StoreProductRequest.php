<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Basic info
            'name_en' => ['required', 'string', 'max:255'],
            'name_bn' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],

            // SKU / Slug (optional, auto-generated if empty)
            'sku' => ['nullable', 'string', 'max:50', Rule::unique('products', 'sku')],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')],
            'model_number' => ['nullable', 'string', 'max:100'],

            // Descriptions
            'short_description_en' => ['nullable', 'string', 'max:500'],
            'short_description_bn' => ['nullable', 'string', 'max:500'],
            'description_en' => ['required', 'string'],
            'description_bn' => ['nullable', 'string'],

            // Pricing
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'discount_percentage' => ['nullable', 'integer', 'min:0', 'max:100'],

            // Inventory
            'quantity' => ['required', 'integer', 'min:0'],
            'alert_quantity' => ['nullable', 'integer', 'min:0'],
            'track_quantity' => ['boolean'],
            'allow_backorder' => ['boolean'],
            'stock_status' => ['required', 'in:in_stock,out_of_stock,backorder'],

            // Images
            'featured_images' => ['required', 'array', 'min:1'],
            'featured_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_images' => ['nullable', 'array', 'max:5'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            // Specifications
            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['required_with:specifications.*.value', 'string', 'max:100'],
            'specifications.*.value' => ['required_with:specifications.*.key', 'string', 'max:255'],

            // Shipping
            'weight' => ['nullable', 'numeric', 'min:0'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],

            // Warranty
            'warranty_duration' => ['nullable', 'integer', 'min:0', 'max:99'],
            'warranty_unit' => ['nullable', 'in:days,months,years'],
            'warranty_type' => ['nullable', 'in:replacement,service,parts'],
            'warranty_duration' => ['required_with:warranty_unit'],
            'warranty_unit' => ['required_with:warranty_duration'],


            // Status & flags
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
    }

    protected function prepareForValidation(): void
    {
        // Normalize booleans
        foreach (['track_quantity', 'allow_backorder', 'is_featured', 'is_bestsells', 'is_new'] as $field) {
            $this->merge([$field => filter_var($this->input($field, false), FILTER_VALIDATE_BOOLEAN)]);
        }

        // Defaults
        $this->merge([
            'alert_quantity' => $this->input('alert_quantity', 5),
            'discount_percentage' => $this->input('discount_percentage', 0),
        ]);

        // Clean empty strings → null
        foreach (
            [
                'name_bn',
                'short_description_en',
                'short_description_bn',
                'description_bn',
                'meta_title_en',
                'meta_title_bn',
                'meta_description_en',
                'meta_description_bn',
                'meta_keywords',
                'sku',
                'slug',
                'model_number',
                'warranty_duration',
                'warranty_unit',
                'warranty_type',
            ] as $field
        ) {
            if (blank($this->input($field))) {
                $this->merge([$field => null]);
            }
        }

        // Clean specifications
        if (is_array($this->specifications)) {
            $this->merge([
                'specifications' => collect($this->specifications)
                    ->filter(fn($s) => !empty($s['key']) && !empty($s['value']))
                    ->values()
                    ->toArray(),
            ]);
        }
    }
}
