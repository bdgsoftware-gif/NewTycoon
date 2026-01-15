<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en' => ['required', 'string', 'max:255'],
            'name_bn' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->category)
            ],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'description_en' => ['nullable', 'string'],
            'description_bn' => ['nullable', 'string'],
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

    public function messages(): array
    {
        return [
            'name_en.required' => 'English category name is required.',
            'name_en.string' => 'English name must be a valid text.',
            'name_en.max' => 'English name cannot exceed 255 characters.',

            'name_bn.string' => 'Bengali name must be a valid text.',
            'name_bn.max' => 'Bengali name cannot exceed 255 characters.',

            'slug.string' => 'Slug must be a valid text.',
            'slug.max' => 'Slug cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already in use by another category.',

            'parent_id.exists' => 'The selected parent category does not exist.',

            'description_en.string' => 'English description must be a valid text.',
            'description_bn.string' => 'Bengali description must be a valid text.',

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

    protected function prepareForValidation(): void
    {
        // Auto-generate slug from English name if not provided
        if (!$this->has('slug') && $this->has('name_en')) {
            $this->merge([
                'slug' => Str::slug($this->name_en),
            ]);
        }

        // Ensure boolean values
        $booleans = ['remove_image', 'is_featured', 'show_in_nav', 'is_active'];

        foreach ($booleans as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => filter_var($this->$field, FILTER_VALIDATE_BOOLEAN),
                ]);
            }
        }

        // Set default values if not provided
        if (!$this->has('order')) $this->merge(['order' => $this->category->order ?? 0]);
        if (!$this->has('nav_order')) $this->merge(['nav_order' => $this->category->nav_order ?? 0]);

        // Clean up empty strings to null
        $nullableFields = ['name_bn', 'description_en', 'description_bn', 'meta_title', 'meta_description', 'meta_keywords'];

        foreach ($nullableFields as $field) {
            if ($this->has($field) && trim($this->$field) === '') {
                $this->merge([$field => null]);
            }
        }
    }

    protected function passedValidation(): void
    {
        if ($this->boolean('remove_image')) {
            $this->merge(['image' => null]);
        }
    }
}
