@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product: ' . $product->name)

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
        <span class="text-gray-700">Edit</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            id="productForm">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Edit Product</h2>
                            <p class="text-sm text-gray-600 mt-1">Update product information</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.products.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                Update Product
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
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $product->name) }}" required
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
                                <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="e.g., PROD-ABC123">
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
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
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
                                    placeholder="Brief description of the product">{{ old('short_description', $product->short_description) }}</textarea>
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
                                    placeholder="Detailed product description">{{ old('description', $product->description) }}</textarea>
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
                                    <input type="number" id="price" name="price"
                                        value="{{ old('price', $product->price) }}" step="0.01" min="0"
                                        required
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
                                        value="{{ old('compare_price', $product->compare_price) }}" step="0.01"
                                        min="0"
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
                                        value="{{ old('cost_price', $product->cost_price) }}" step="0.01"
                                        min="0"
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
                                <input type="number" id="quantity" name="quantity"
                                    value="{{ old('quantity', $product->quantity) }}" min="0" required
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
                                    value="{{ old('alert_quantity', $product->alert_quantity) }}" min="0"
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
                                            {{ old('track_quantity', $product->track_quantity) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Track quantity</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="allow_backorder" value="1"
                                            {{ old('allow_backorder', $product->allow_backorder) ? 'checked' : '' }}
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
                                        @if ($product->featured_image)
                                            <div id="featuredPreview"
                                                class="h-48 w-48 border-2 border-gray-300 rounded-2xl overflow-hidden relative group">
                                                <img id="featuredImage"
                                                    src="{{ Storage::url($product->featured_image) }}"
                                                    class="h-full w-full object-cover">
                                                <div
                                                    class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <button type="button" onclick="removeFeaturedImage()"
                                                        class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="remove_featured_image" id="removeFeaturedImage"
                                                value="0">
                                        @else
                                            <div id="featuredPreview"
                                                class="h-48 w-48 border-2 border-dashed border-gray-300 rounded-2xl flex items-center justify-center bg-gray-50 overflow-hidden hidden">
                                                <img id="featuredImage" class="h-full w-full object-cover">
                                            </div>
                                            <div id="noFeaturedImage"
                                                class="h-48 w-48 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center bg-gray-50">
                                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-500">No image</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" id="featured_image" name="featured_image" accept="image/*"
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

                                <!-- Existing Gallery -->
                                @if ($product->gallery_images && count($product->gallery_images) > 0)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-2">Existing Gallery Images:</p>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach ($product->gallery_images as $index => $image)
                                                <div class="relative group">
                                                    <img src="{{ Storage::url($image) }}"
                                                        class="h-40 w-full object-cover rounded-xl border border-gray-200">
                                                    <div
                                                        class="absolute top-2 right-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <button type="button"
                                                            onclick="removeExistingGalleryImage({{ $index }})"
                                                            class="p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="remove_gallery_images" id="removeGalleryImages"
                                            value="">
                                    </div>
                                @endif

                                <!-- New Gallery Upload -->
                                <div class="mt-1">
                                    <input type="file" id="gallery_images" name="gallery_images[]" multiple
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20"
                                        onchange="previewGalleryImages(event)">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Add more images to gallery. Supports: JPG, PNG, GIF, WEBP
                                    </p>
                                    @error('gallery_images')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- New Gallery Preview -->
                                <div id="galleryPreview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 hidden">
                                    <!-- New images will be added here dynamically -->
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
                                    <input type="number" id="weight" name="weight"
                                        value="{{ old('weight', $product->weight) }}" step="0.01" min="0"
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
                                    <input type="number" id="length" name="length"
                                        value="{{ old('length', $product->length) }}" step="0.01" min="0"
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
                                    <input type="number" id="width" name="width"
                                        value="{{ old('width', $product->width) }}" step="0.01" min="0"
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
                                    <input type="number" id="height" name="height"
                                        value="{{ old('height', $product->height) }}" step="0.01" min="0"
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
                                        <option value="draft"
                                            {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="active"
                                            {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                        <option value="archived"
                                            {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived
                                        </option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Flags -->
                                <div class="space-y-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_featured" value="1"
                                            {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_bestseller" value="1"
                                            {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-700">Bestseller</span>
                                    </label>

                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_new" value="1"
                                            {{ old('is_new', $product->is_new) ? 'checked' : '' }}
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
                                        value="{{ old('meta_title', $product->meta_title) }}"
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
                                        placeholder="Product meta description">{{ old('meta_description', $product->meta_description) }}</textarea>
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
                                        value="{{ old('meta_keywords', $product->meta_keywords) }}"
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

                    <!-- Product Statistics -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Product Statistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Total Sold</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $product->total_sold }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Total Revenue</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($product->total_revenue, 2) }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Rating</p>
                                <div class="flex items-center">
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ number_format($product->average_rating, 1) }}</p>
                                    <svg class="h-5 w-5 text-yellow-400 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 ml-1">({{ $product->rating_count }})</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600">Created</p>
                                <p class="text-lg font-medium text-gray-900">{{ $product->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.products.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="button" onclick="showDeleteModal()"
                                class="px-4 py-2 bg-red-50 border border-red-200 text-red-700 rounded-xl hover:bg-red-100 transition-colors">
                                Delete Product
                            </button>
                        </div>
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
                                Update Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
                                Delete Product
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete "<span
                                        class="font-medium">{{ $product->name }}</span>"?
                                    This action cannot be undone. All associated data will be permanently removed.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                Delete
                            </button>
                        </form>
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
        let removedGalleryIndices = [];

        function previewFeaturedImage(event) {
            const preview = document.getElementById('featuredImage');
            const previewDiv = document.getElementById('featuredPreview');
            const noImageDiv = document.getElementById('noFeaturedImage');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    if (previewDiv) {
                        previewDiv.classList.remove('hidden');
                        previewDiv.innerHTML = `
                        <img id="featuredImage" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button type="button" onclick="removeFeaturedImage()" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    `;
                    }
                    if (noImageDiv) {
                        noImageDiv.classList.add('hidden');
                    }
                }

                reader.readAsDataURL(file);
            }
        }

        function removeFeaturedImage() {
            document.getElementById('removeFeaturedImage').value = '1';
            document.getElementById('featuredPreview').classList.add('hidden');
            if (document.getElementById('noFeaturedImage')) {
                document.getElementById('noFeaturedImage').classList.remove('hidden');
            }
            document.getElementById('featured_image').value = '';
        }

        function removeExistingGalleryImage(index) {
            removedGalleryIndices.push(index);
            document.getElementById('removeGalleryImages').value = JSON.stringify(removedGalleryIndices);

            // Hide the image (in real app, you'd remove it from DOM)
            event.target.closest('.relative').classList.add('hidden');
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
                        <button type="button" onclick="removeNewGalleryImage(this)" class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
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

        function removeNewGalleryImage(button) {
            button.closest('.relative').remove();
        }

        function saveAsDraft() {
            document.getElementById('status').value = 'draft';
            document.getElementById('productForm').submit();
        }

        function showDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

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
    </script>
@endpush
