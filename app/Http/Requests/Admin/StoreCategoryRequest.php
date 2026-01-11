<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'is_featured' => ['boolean'],
            'show_in_nav' => ['boolean'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
            'nav_order' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.string' => 'Category name must be a valid text.',
            'name.max' => 'Category name cannot exceed 255 characters.',

            'slug.string' => 'Slug must be a valid text.',
            'slug.max' => 'Slug cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already in use. Please choose a different one.',

            'parent_id.exists' => 'The selected parent category does not exist.',

            'description.string' => 'Description must be a valid text.',

            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be in PNG, JPG, JPEG, or WEBP format.',
            'image.max' => 'Image size cannot exceed 2MB.',

            'is_featured.boolean' => 'Featured flag must be true or false.',
            'show_in_nav.boolean' => 'Navigation display flag must be true or false.',
            'is_active.boolean' => 'Active status must be true or false.',

            'meta_title.string' => 'Meta title must be a valid text.',
            'meta_title.max' => 'Meta title cannot exceed 255 characters.',

            'meta_description.string' => 'Meta description must be a valid text.',
            'meta_keywords.string' => 'Meta keywords must be a valid text.',

            'order.integer' => 'Order must be a whole number.',
            'nav_order.integer' => 'Navigation order must be a whole number.',
        ];
    }
}
