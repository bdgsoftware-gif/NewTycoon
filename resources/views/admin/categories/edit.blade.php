@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category: ' . $category->name)

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700">Categories</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Edit</span>
    </li>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Edit Category</h2>
                            <p class="text-sm text-gray-600 mt-1">Update category information</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.categories.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                Update Category
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category Name *
                                </label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $category->name) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Enter category name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Slug Field (Add this if you want to edit slug) -->
                            {{-- <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                                    Slug
                                </label>
                                <input type="text" id="slug" name="slug"
                                    value="{{ old('slug', $category->slug) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="category-slug">
                                <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from name</p>
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <!-- Parent Category -->
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Parent Category
                                </label>
                                <select id="parent_id" name="parent_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($parentCategories as $parent)
                                        @if ($parent->id !== $category->id)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                                @if ($parent->parent)
                                                    ({{ $parent->parent->name }})
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Navigation Order (Add this field) -->
                            {{-- <div>
                                <label for="nav_order" class="block text-sm font-medium text-gray-700 mb-1">
                                    Navigation Order
                                </label>
                                <input type="number" id="nav_order" name="nav_order"
                                    value="{{ old('nav_order', $category->nav_order) }}" min="0"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="0">
                                @error('nav_order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                                    Display Order
                                </label>
                                <input type="number" id="order" name="order"
                                    value="{{ old('order', $category->order) }}" min="0"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="0">
                                @error('order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center mr-4">
                                        <input type="radio" name="is_active" value="1"
                                            {{ old('is_active', $category->is_active) == '1' ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Active</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="is_active" value="0"
                                            {{ old('is_active', $category->is_active) == '0' ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Inactive</span>
                                    </label>
                                </div>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Category Image</h3>

                        <div class="flex items-start space-x-6">
                            <!-- Image Preview -->
                            <div class="w-40">
                                @if ($category->image)
                                    <div id="imagePreview"
                                        class="h-40 w-40 border-2 border-gray-300 rounded-2xl overflow-hidden relative group">
                                        <img id="previewImage" src="{{ asset('storage/' . $category->image) }}"
                                            class="h-full w-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" onclick="removeExistingImage()"
                                                class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="remove_image" id="removeImageField" value="0">
                                    <div id="noImage" class="hidden"></div>
                                @else
                                    <div id="imagePreview"
                                        class="h-40 w-40 border-2 border-dashed border-gray-300 rounded-2xl flex items-center justify-center bg-gray-50 overflow-hidden hidden">
                                        <img id="previewImage" class="h-full w-full object-cover">
                                    </div>
                                    <div id="noImage"
                                        class="h-40 w-40 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center bg-gray-50">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-2 text-xs text-gray-500">No image</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Upload Controls -->
                            <div class="flex-1">
                                <div class="space-y-4">
                                    <div>
                                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                            @if ($category->image)
                                                Replace Image
                                            @else
                                                Upload Image
                                            @endif
                                        </label>
                                        <input type="file" id="image" name="image" accept="image/*"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20"
                                            onchange="previewFile(event)">
                                        <p class="mt-1 text-xs text-gray-500">
                                            Recommended size: 400x400px. Supports: JPG, PNG, GIF, WEBP
                                        </p>
                                        @error('image')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Features -->
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_featured" value="1"
                                                {{ old('is_featured', $category->is_featured) == '1' ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                            <span class="ml-2 text-sm text-gray-700">Mark as featured category</span>
                                        </label>

                                        <label class="flex items-center">
                                            <input type="checkbox" name="show_in_nav" value="1"
                                                {{ old('show_in_nav', $category->show_in_nav) == '1' ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                            <span class="ml-2 text-sm text-gray-700">Show in navigation</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">SEO Settings</h3>
                        <p class="text-sm text-gray-600">Customize how this category appears in search engines</p>

                        <div class="space-y-4">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Meta Title
                                </label>
                                <input type="text" id="meta_title" name="meta_title"
                                    value="{{ old('meta_title', $category->meta_title) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Enter meta title for SEO">
                                <p class="mt-1 text-xs text-gray-500">Recommended: 50-60 characters</p>
                                @error('meta_title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Meta Description
                                </label>
                                <textarea id="meta_description" name="meta_description" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Enter meta description for SEO">{{ old('meta_description', $category->meta_description) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Recommended: 150-160 characters</p>
                                @error('meta_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">
                                    Meta Keywords
                                </label>
                                <input type="text" id="meta_keywords" name="meta_keywords"
                                    value="{{ old('meta_keywords', $category->meta_keywords) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="keyword1, keyword2, keyword3">
                                <p class="mt-1 text-xs text-gray-500">Separate keywords with commas</p>
                                @error('meta_keywords')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-5">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Category Statistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Total Products</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $category->products_count ?? 0 }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Child Categories</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $category->children->count() }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Created</p>
                                <p class="text-lg font-medium text-gray-900">{{ $category->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Last Updated</p>
                                <p class="text-lg font-medium text-gray-900">{{ $category->updated_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.categories.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="button" onclick="deleteCategory()"
                                class="px-4 py-2 bg-red-50 border border-red-200 text-red-700 rounded-xl hover:bg-red-100 transition-colors">
                                Delete Category
                            </button>
                        </div>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Update Category
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Delete Form -->
        <form id="deleteForm" action="{{ route('admin.categories.destroy', $category) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden z-50">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">
                                Delete Category
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete "<span
                                        class="font-medium">{{ $category->name }}</span>"?
                                    This action cannot be undone. All products in this category will be moved to
                                    "Uncategorized".
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="confirmDelete()"
                            class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Delete
                        </button>
                        <button type="button" onclick="closeDeleteModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewFile(event) {
            const preview = document.getElementById('previewImage');
            const previewDiv = document.getElementById('imagePreview');
            const noImageDiv = document.getElementById('noImage');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // If preview div exists, show it
                    if (previewDiv) {
                        previewDiv.classList.remove('hidden');
                        previewDiv.innerHTML = `
                            <img id="previewImage" src="${e.target.result}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" onclick="removeNewImage()" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        `;
                    } else {
                        // Create preview div if it doesn't exist
                        const newPreviewDiv = document.createElement('div');
                        newPreviewDiv.id = 'imagePreview';
                        newPreviewDiv.className =
                            'h-40 w-40 border-2 border-gray-300 rounded-2xl overflow-hidden relative group';
                        newPreviewDiv.innerHTML = `
                            <img id="previewImage" src="${e.target.result}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" onclick="removeNewImage()" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        `;
                        document.querySelector('.w-40').prepend(newPreviewDiv);
                    }

                    // Hide no image div if it exists
                    if (noImageDiv) {
                        noImageDiv.classList.add('hidden');
                    }
                }

                reader.readAsDataURL(file);
            }
        }

        function removeExistingImage() {
            document.getElementById('removeImageField').value = '1';
            document.getElementById('imagePreview').style.display = 'none';

            // Show no image placeholder
            const noImageDiv = document.getElementById('noImage');
            if (!noImageDiv) {
                const newNoImageDiv = document.createElement('div');
                newNoImageDiv.id = 'noImage';
                newNoImageDiv.className =
                    'h-40 w-40 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center bg-gray-50';
                newNoImageDiv.innerHTML = `
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="mt-2 text-xs text-gray-500">No image</p>
                `;
                document.querySelector('.w-40').appendChild(newNoImageDiv);
            } else {
                noImageDiv.classList.remove('hidden');
            }
        }

        function removeNewImage() {
            document.getElementById('image').value = '';
            const previewDiv = document.getElementById('imagePreview');
            const noImageDiv = document.getElementById('noImage');

            if (previewDiv) {
                previewDiv.remove();
            }

            if (noImageDiv) {
                noImageDiv.classList.remove('hidden');
            }
        }

        function deleteCategory() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function confirmDelete() {
            document.getElementById('deleteForm').submit();
        }

        // Auto-generate slug from name
        // document.getElementById('name').addEventListener('input', function() {
        //     const name = this.value;
        //     const slugField = document.getElementById('slug');

        //     // Only auto-generate if slug field is empty or hasn't been manually modified
        //     if (!slugField.dataset.manual && (!slugField.value || slugField.value === '{{ $category->slug }}')) {
        //         const slug = name.toLowerCase()
        //             .replace(/[^\w\s-]/g, '')
        //             .replace(/\s+/g, '-')
        //             .replace(/--+/g, '-');
        //         slugField.value = slug;
        //     }
        // });

        // Mark slug as manually modified
        // document.getElementById('slug').addEventListener('input', function() {
        //     this.dataset.manual = 'true';
        // });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Close modal on background click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        });
    </script>
@endpush
