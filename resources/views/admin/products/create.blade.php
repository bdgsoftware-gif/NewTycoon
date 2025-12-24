@extends('admin.layouts.app')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">Products</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Create</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Product Information</h2>
                            <p class="text-sm text-gray-600 mt-1">Fill in the details to create a new product</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.products.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                Create Product
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6 space-y-8">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Basic Information
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="lg:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Product Name *
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Enter product name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">
                                    SKU (Stock Keeping Unit)
                                </label>
                                <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="e.g., PROD-ABC123">
                                <p class="mt-1 text-xs text-gray-500">Leave blank to auto-generate</p>
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category *
                                </label>
                                <select id="category_id" name="category_id" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Brand -->
                            <div>
                                <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Brand
                                </label>
                                <select id="brand_id" name="brand_id"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Short Description -->
                            <div class="lg:col-span-2">
                                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Short Description *
                                </label>
                                <textarea id="short_description" name="short_description" rows="2" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Brief description of the product">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Full Description -->
                            <div class="lg:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Description
                                </label>
                                <textarea id="description" name="description" rows="5"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Detailed product description">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pricing
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Price *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="price" name="price" value="{{ old('price') }}"
                                        step="0.01" min="0" required
                                        class="pl-7 w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0.00">
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Compare Price -->
                            <div>
                                <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Compare at Price
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="compare_price" name="compare_price"
                                        value="{{ old('compare_price') }}" step="0.01" min="0"
                                        class="pl-7 w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0.00">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Show a strikethrough price</p>
                                @error('compare_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cost Price -->
                            <div>
                                <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Cost Price
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="cost_price" name="cost_price"
                                        value="{{ old('cost_price') }}" step="0.01" min="0"
                                        class="pl-7 w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0.00">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">For profit calculations</p>
                                @error('cost_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Inventory -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Inventory
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                    Quantity *
                                </label>
                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}"
                                    min="0" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="0">
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alert Quantity -->
                            <div>
                                <label for="alert_quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                    Low Stock Alert
                                </label>
                                <input type="number" id="alert_quantity" name="alert_quantity"
                                    value="{{ old('alert_quantity', 5) }}" min="0"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="5">
                                @error('alert_quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Inventory Management -->
                            <div class="md:col-span-2 space-y-4">
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="track_quantity" value="1"
                                            {{ old('track_quantity', true) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Track quantity</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="allow_backorder" value="1"
                                            {{ old('allow_backorder') ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Allow backorder</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Product Images
                        </h3>

                        <div class="space-y-6">
                            <!-- Featured Image -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Featured Image *
                                </label>
                                <div class="mt-1 flex items-center space-x-6">
                                    <div class="w-48">
                                        <div id="featuredPreview"
                                            class="h-48 w-48 border-2 border-dashed border-gray-300 rounded-2xl flex items-center justify-center bg-gray-50 overflow-hidden hidden">
                                            <img id="featuredImage" class="h-full w-full object-cover">
                                        </div>
                                        <div id="noFeaturedImage"
                                            class="h-48 w-48 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center bg-gray-50">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">No image</p>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" id="featured_image" name="featured_image" accept="image/*"
                                            required
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20"
                                            onchange="previewFeaturedImage(event)">
                                        <p class="mt-1 text-xs text-gray-500">
                                            Main product image. Recommended: 800x800px. Supports: JPG, PNG, GIF, WEBP
                                        </p>
                                        @error('featured_image')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Gallery Images -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Gallery Images
                                </label>
                                <div class="mt-1">
                                    <input type="file" id="gallery_images" name="gallery_images[]" multiple
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20"
                                        onchange="previewGalleryImages(event)">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Additional product images. Supports: JPG, PNG, GIF, WEBP
                                    </p>
                                    @error('gallery_images')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gallery Preview -->
                                <div id="galleryPreview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 hidden">
                                    <!-- Images will be added here dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Shipping
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">
                                    Weight (kg)
                                </label>
                                <div class="relative">
                                    <input type="number" id="weight" name="weight" value="{{ old('weight') }}"
                                        step="0.01" min="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">kg</span>
                                    </div>
                                </div>
                                @error('weight')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dimensions -->
                            <div>
                                <label for="length" class="block text-sm font-medium text-gray-700 mb-1">
                                    Length (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" id="length" name="length" value="{{ old('length') }}"
                                        step="0.01" min="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">cm</span>
                                    </div>
                                </div>
                                @error('length')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="width" class="block text-sm font-medium text-gray-700 mb-1">
                                    Width (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" id="width" name="width" value="{{ old('width') }}"
                                        step="0.01" min="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">cm</span>
                                    </div>
                                </div>
                                @error('width')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700 mb-1">
                                    Height (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" id="height" name="height" value="{{ old('height') }}"
                                        step="0.01" min="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">cm</span>
                                    </div>
                                </div>
                                @error('height')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status & SEO -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Status -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900">Status & Flags</h3>

                            <div class="space-y-4">
                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Status *
                                    </label>
                                    <select id="status" name="status" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>
                                            Archived</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Flags -->
                                <div class="space-y-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_featured" value="1"
                                            {{ old('is_featured') ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_bestsells" value="1"
                                            {{ old('is_bestsells') ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Bestseller</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_new" value="1"
                                            {{ old('is_new', true) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">New Arrival</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900">SEO Settings</h3>

                            <div class="space-y-4">
                                <!-- Meta Title -->
                                <div>
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">
                                        Meta Title
                                    </label>
                                    <input type="text" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Product meta title">
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
                                        placeholder="Product meta description">{{ old('meta_description') }}</textarea>
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
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="saveAsDraft()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Save as Draft
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Create Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function previewFeaturedImage(event) {
            const preview = document.getElementById('featuredImage');
            const previewDiv = document.getElementById('featuredPreview');
            const noImageDiv = document.getElementById('noFeaturedImage');
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

        function previewGalleryImages(event) {
            const previewDiv = document.getElementById('galleryPreview');
            const files = event.target.files;

            previewDiv.innerHTML = '';
            previewDiv.classList.remove('hidden');

            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imageDiv = document.createElement('div');
                        imageDiv.className = 'relative group';
                        imageDiv.innerHTML = `
                        <img src="${e.target.result}" class="h-40 w-full object-cover rounded-xl border border-gray-200">
                        <button type="button" onclick="removeGalleryImage(this)" class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    `;
                        previewDiv.appendChild(imageDiv);
                    }

                    reader.readAsDataURL(file);
                }
            } else {
                previewDiv.classList.add('hidden');
            }
        }

        function removeGalleryImage(button) {
            button.closest('.relative').remove();
            // Update file input (this is simplified - in real app you'd need to handle FileList)
        }

        function saveAsDraft() {
            document.getElementById('status').value = 'draft';
            document.getElementById('productForm').submit();
        }

        // Auto-calculate profit margin
        document.getElementById('price').addEventListener('input', calculateProfit);
        document.getElementById('cost_price').addEventListener('input', calculateProfit);

        function calculateProfit() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const cost = parseFloat(document.getElementById('cost_price').value) || 0;

            if (price > 0 && cost > 0) {
                const margin = ((price - cost) / price) * 100;
                const profit = price - cost;

                // You can display this info somewhere
                console.log(`Profit Margin: ${margin.toFixed(2)}%`);
                console.log(`Profit per unit: $${profit.toFixed(2)}`);
            }
        }

        // Auto-fill SEO fields
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            if (!document.getElementById('meta_title').value) {
                document.getElementById('meta_title').value = name + ' - Buy Online';
            }
        });

        document.getElementById('short_description').addEventListener('input', function() {
            const desc = this.value;
            if (!document.getElementById('meta_description').value) {
                document.getElementById('meta_description').value = desc.substring(0, 160);
            }
        });
    </script>
@endpush
