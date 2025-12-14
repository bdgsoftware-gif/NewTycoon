@extends('admin.layouts.app')

@section('title', 'Create Category')
@section('page-title', 'Create New Category')

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
        <span class="text-gray-700">Create</span>
    </li>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Category Information</h2>
                            <p class="text-sm text-gray-600 mt-1">Fill in the details to create a new category</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.categories.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                Create Category
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
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Enter category name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Parent Category -->
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Parent Category
                                </label>
                                <select id="parent_id" name="parent_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($parentCategories as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                                    Display Order
                                </label>
                                <input type="number" id="order" name="order" value="{{ old('order', 0) }}"
                                    min="0"
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
                                            {{ old('is_active', true) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Active</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="is_active" value="0"
                                            {{ old('is_active') === '0' ? 'checked' : '' }}
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
                                placeholder="Enter category description">{{ old('description') }}</textarea>
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
                            </div>

                            <!-- Upload Controls -->
                            <div class="flex-1">
                                <div class="space-y-4">
                                    <div>
                                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                            Upload Image
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
                                                {{ old('is_featured') ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                            <span class="ml-2 text-sm text-gray-700">Mark as featured category</span>
                                        </label>

                                        <label class="flex items-center">
                                            <input type="checkbox" name="show_on_homepage" value="1"
                                                {{ old('show_on_homepage') ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                            <span class="ml-2 text-sm text-gray-700">Show on homepage</span>
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
                                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
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
                                    placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
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
                                    value="{{ old('meta_keywords') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="keyword1, keyword2, keyword3">
                                <p class="mt-1 text-xs text-gray-500">Separate keywords with commas</p>
                                @error('meta_keywords')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Create Category
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
                    preview.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                    noImageDiv.classList.add('hidden');
                }

                reader.readAsDataURL(file);
            } else {
                previewDiv.classList.add('hidden');
                noImageDiv.classList.remove('hidden');
            }
        }

        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-');

            // If you have a slug field, uncomment this:
            // document.getElementById('slug').value = slug;

            // If you have meta title, auto-fill it
            if (!document.getElementById('meta_title').value) {
                document.getElementById('meta_title').value = name + ' - Shop Category';
            }

            // If you have meta description, auto-fill it
            if (!document.getElementById('meta_description').value && document.getElementById('description')
                .value) {
                const desc = document.getElementById('description').value;
                document.getElementById('meta_description').value = desc.substring(0, 160);
            }
        });
    </script>
@endpush
