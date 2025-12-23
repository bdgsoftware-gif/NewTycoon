<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // You should implement your authorization logic here
    }
 
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => 'required|string|max:255',
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($productId)
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId)
            ],
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'alert_quantity' => 'nullable|integer|min:0',
            'track_quantity' => 'boolean',
            'allow_backorder' => 'boolean',
            'model_number' => 'nullable|string|max:100',
            'warranty_period' => 'nullable|string|max:50',
            'warranty_type' => 'nullable|in:replacement,service,parts',
            'specifications' => 'nullable|array',
            'specifications.*' => 'nullable|string',
            'featured_images' => 'nullable|array|max:2',
            'featured_images.*' => 'nullable|string',
            'gallery_images' => 'nullable|array|max:5',
            'gallery_images.*' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
            'status' => 'required|in:draft,active,inactive,archived',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'vendor_id' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'price.min' => 'Price must be greater than 0',
            'compare_price.min' => 'Compare price must be greater than 0',
            'compare_price.gte' => 'Compare price must be greater than or equal to price',
            'quantity.min' => 'Quantity cannot be negative',
            'featured_images.max' => 'You can only upload up to 2 featured images',
            'gallery_images.max' => 'You can only upload up to 5 gallery images',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure boolean fields are properly cast
        $this->merge([
            'track_quantity' => filter_var($this->track_quantity, FILTER_VALIDATE_BOOLEAN),
            'allow_backorder' => filter_var($this->allow_backorder, FILTER_VALIDATE_BOOLEAN),
            'is_featured' => filter_var($this->is_featured, FILTER_VALIDATE_BOOLEAN),
            'is_bestseller' => filter_var($this->is_bestseller, FILTER_VALIDATE_BOOLEAN),
            'is_new' => filter_var($this->is_new, FILTER_VALIDATE_BOOLEAN),
        ]);

        // Convert specifications array to JSON if it's an array
        if (is_array($this->specifications)) {
            $this->merge([
                'specifications' => json_encode(array_filter($this->specifications)),
            ]);
        }
    }
}
