<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->category)
            ],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'is_featured' => ['boolean'],
            'show_in_nav' => ['boolean'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'nav_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Get custom validation messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.string' => 'Category name must be a valid text.',
            'name.max' => 'Category name cannot exceed 255 characters.',

            'slug.string' => 'Slug must be a valid text.',
            'slug.max' => 'Slug cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already in use by another category.',

            'parent_id.exists' => 'The selected parent category does not exist.',

            'description.string' => 'Description must be a valid text.',

            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed image formats: PNG, JPG, JPEG, WEBP.',
            'image.max' => 'Image size cannot exceed 2MB.',

            'remove_image.boolean' => 'Remove image flag must be true or false.',

            'is_featured.boolean' => 'Featured flag must be true or false.',
            'show_in_nav.boolean' => 'Navigation display flag must be true or false.',
            'is_active.boolean' => 'Active status must be true or false.',

            'meta_title.string' => 'Meta title must be a valid text.',
            'meta_title.max' => 'Meta title cannot exceed 255 characters.',

            'meta_description.string' => 'Meta description must be a valid text.',
            'meta_keywords.string' => 'Meta keywords must be a valid text.',

            'order.integer' => 'Order must be a whole number.',
            'order.min' => 'Order cannot be negative.',
            'nav_order.integer' => 'Navigation order must be a whole number.',
            'nav_order.min' => 'Navigation order cannot be negative.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'category name',
            'slug' => 'slug',
            'parent_id' => 'parent category',
            'description' => 'description',
            'image' => 'category image',
            'remove_image' => 'remove image',
            'is_featured' => 'featured status',
            'show_in_nav' => 'navigation display',
            'is_active' => 'active status',
            'meta_title' => 'meta title',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
            'order' => 'order',
            'nav_order' => 'navigation order',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure boolean values
        $booleans = ['remove_image', 'is_featured', 'show_in_nav', 'is_active'];

        foreach ($booleans as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => filter_var($this->$field, FILTER_VALIDATE_BOOLEAN),
                ]);
            }
        }

        // Clean up empty strings to null for optional fields
        $nullableFields = ['description', 'meta_title', 'meta_description', 'meta_keywords'];

        foreach ($nullableFields as $field) {
            if ($this->has($field) && trim($this->$field) === '') {
                $this->merge([$field => null]);
            }
        }

        // Set default values if not provided
        if (!$this->has('order')) {
            $this->merge([
                'order' => 0,
            ]);
        }

        if (!$this->has('nav_order')) {
            $this->merge([
                'nav_order' => 0,
            ]);
        }
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        // If remove_image is true, set image to null
        if ($this->boolean('remove_image')) {
            $this->merge([
                'image' => null,
            ]);
        }
    }
}
