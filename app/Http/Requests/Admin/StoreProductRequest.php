<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'name' => 'required|string|max:255|unique:products,name' . ($productId ? ',' . $productId : ''),
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'compare_price' => 'nullable|numeric|min:0|max:999999.99|gt:price',
            'cost_price' => 'nullable|numeric|min:0|max:999999.99',
            'quantity' => 'required|integer|min:0',
            'alert_quantity' => 'nullable|integer|min:0',
            'track_quantity' => 'boolean',
            'allow_backorder' => 'boolean',
            'model_number' => 'nullable|string|max:100',
            'warranty_period' => 'nullable|integer|min:0',
            'warranty_type' => 'nullable|string|in:days,months,years',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'required|string|max:100',
            'specifications.*.value' => 'required|string|max:255',

            // Featured Images: max 2, at least 1
            'featured_images' => 'required|array|min:1|max:2',
            'featured_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:min_width=300,min_height=300',

            // Gallery Images: max 5
            'gallery_images' => 'nullable|array|max:5',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:min_width=300,min_height=300',

            'weight' => 'nullable|numeric|min:0|max:999.99',
            'length' => 'nullable|numeric|min:0|max:999.99',
            'width' => 'nullable|numeric|min:0|max:999.99',
            'height' => 'nullable|numeric|min:0|max:999.99',

            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',

            'is_featured' => 'boolean',
            'is_bestsells' => 'boolean',
            'is_new' => 'boolean',

            'status' => 'required|in:draft,active,inactive,archived',
            'stock_status' => 'required|in:in_stock,out_of_stock,backorder',

            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'name.unique' => 'This product name already exists',
            'category_id.required' => 'Please select a category',
            'description.required' => 'Product description is required',
            'price.required' => 'Price is required',
            'price.min' => 'Price must be at least 0',
            'compare_price.gt' => 'Compare price must be greater than regular price',
            'quantity.required' => 'Quantity is required',
            'featured_images.required' => 'At least one featured image is required',
            'featured_images.max' => 'Maximum 2 featured images allowed',
            'featured_images.*.image' => 'Featured images must be valid image files',
            'featured_images.*.max' => 'Featured image size must not exceed 5MB',
            'gallery_images.max' => 'Maximum 5 gallery images allowed',
            'gallery_images.*.image' => 'Gallery images must be valid image files',
            'gallery_images.*.max' => 'Gallery image size must not exceed 5MB',
            'status.required' => 'Please select a status',
            'stock_status.required' => 'Please select stock status',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'featured_images' => 'featured images',
            'gallery_images' => 'gallery images',
            'featured_images.*' => 'featured image',
            'gallery_images.*' => 'gallery image',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Please fix the errors below.')
        );
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Auto-generate slug from name
        if ($this->has('name')) {
            $slug = Str::slug($this->name);
            $originalSlug = $slug;
            $counter = 1;

            // Check if slug exists (excluding current product)
            $productId = $this->route('product') ? $this->route('product')->id : null;
            $query = \App\Models\Product::where('slug', $slug);
            if ($productId) {
                $query->where('id', '!=', $productId);
            }

            // Make slug unique
            while ($query->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
                $query = \App\Models\Product::where('slug', $slug);
                if ($productId) {
                    $query->where('id', '!=', $productId);
                }
            }

            $this->merge([
                'slug' => $slug,
            ]);
        }

        // Auto-generate SKU if not provided
        if (!$this->has('sku') || empty($this->sku)) {
            $sku = 'SKU-' . strtoupper(Str::random(3)) . '-' . date('Ymd') . '-' . rand(100, 999);
            $this->merge([
                'sku' => $sku,
            ]);
        }

        // Ensure SKU is unique
        if ($this->has('sku')) {
            $sku = $this->sku;
            $productId = $this->route('product') ? $this->route('product')->id : null;
            $query = \App\Models\Product::where('sku', $sku);
            if ($productId) {
                $query->where('id', '!=', $productId);
            }

            if ($query->exists()) {
                $counter = 1;
                $originalSku = $sku;

                while ($query->exists()) {
                    $sku = $originalSku . '-' . $counter;
                    $counter++;
                    $query = \App\Models\Product::where('sku', $sku);
                    if ($productId) {
                        $query->where('id', '!=', $productId);
                    }
                }

                $this->merge([
                    'sku' => $sku,
                ]);
            }
        }
    }
}
