@extends('frontend.layouts.app')

@section('title', $category->name)
@section('description', $category->meta_description ?? $category->name . ' products')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 font-inter">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary transition-colors duration-200">
                            Home
                        </a>
                    </li>
                    @foreach ($breadcrumb as $crumb)
                        <li class="inline-flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            @if (!$loop->last)
                                <a href="{{ route('categories.show', $crumb->slug) }}"
                                    class="text-gray-600 hover:text-primary transition-colors duration-200">
                                    {{ $crumb->name }}
                                </a>
                            @else
                                <span class="text-gray-900 font-medium">{{ $crumb->name }}</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>

        <!-- Category Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-quantico">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="text-gray-600 font-inter">{{ $category->description }}</p>
            @endif
        </div>

        <!-- Subcategories -->
        @if ($subcategories->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 font-quantico">Subcategories</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach ($subcategories as $subcategory)
                        <a href="{{ route('categories.show', $subcategory->slug) }}"
                            class="group bg-white border border-gray-200 rounded-lg p-3 text-center hover:border-primary hover:shadow-md transition-all duration-200">
                            @if ($subcategory->image)
                                <div class="w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full overflow-hidden p-2">
                                    <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}"
                                        class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-200">
                                </div>
                            @endif
                            <h3
                                class="font-medium text-gray-900 group-hover:text-primary transition-colors duration-200 font-cambay text-xs">
                                {{ $subcategory->name }}
                            </h3>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Products Grid -->
        <div>
            <!-- Filters and Sort -->
            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 bg-white p-4 rounded-xl border border-gray-200">
                <p class="text-gray-600 font-inter">
                    Showing <span class="font-semibold">{{ $products->firstItem() ?? 0 }}</span>
                    to <span class="font-semibold">{{ $products->lastItem() ?? 0 }}</span>
                    of <span class="font-semibold">{{ $products->total() }}</span> products
                </p>

                <div class="flex items-center gap-2">
                    <span class="text-gray-700 font-inter text-sm">Sort by:</span>
                    <select name="sort" id="sortSelect"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm font-inter focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest
                        </option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High
                        </option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to
                            Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z
                        </option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A
                        </option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            @if ($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        @php
                            $productSlug = $product['slug'] ?? '#';
                            $productId = $product['id'] ?? '#';
                            $productName = $product['name'] ?? 'Product Name';
                            $primaryImage = $product['images'][0] ?? 'images/placeholder.jpg';
                            $secondaryImage = $product['images'][1] ?? $primaryImage;
                            $discountedPrice = $product['discounted_price'] ?? ($product['original_price'] ?? 0);
                            $originalPrice = $product['original_price'] ?? 0;
                            $discountPercentage = $product['discount_percentage'] ?? 0;
                            $inStock = $product['in_stock'] ?? true;
                            $isNew = $product['is_new'] ?? false;
                        @endphp

                        <!-- Product Card (same as products page) -->
                        <div
                            class="group relative h-full bg-white border border-gray-200 hover:border-primary rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col">
                            <!-- Product Card Content (copy from your products index.blade.php) -->
                            <!-- Use the same product card structure as your products page -->
                            <a href="{{ route('product.show', $productSlug) }}">
                                <div
                                    class="relative w-full aspect-square bg-gradient-to-br from-gray-50 to-white overflow-hidden">
                                    <img src="{{ asset($primaryImage) }}" alt="{{ $productName }}"
                                        class="absolute inset-0 w-full h-full object-contain transition-opacity duration-500 group-hover:opacity-0">
                                    <img src="{{ asset($secondaryImage) }}" alt="{{ $productName }}"
                                        class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-500 group-hover:opacity-100">

                                    <!-- Badges -->
                                    <div class="absolute top-3 left-3 flex flex-col space-y-1 z-10">
                                        @if ($isNew)
                                            <span
                                                class="bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold px-3 py-1.5 font-quantico rounded">
                                                NEW
                                            </span>
                                        @endif
                                        @if (!$inStock)
                                            <span
                                                class="bg-gray-700/90 text-white text-xs font-bold px-3 py-1.5 font-quantico rounded">
                                                SOLD OUT
                                            </span>
                                        @endif
                                    </div>

                                    @if ($discountPercentage > 0)
                                        <div class="absolute top-3 right-3 z-10">
                                            <span
                                                class="bg-gradient-to-r from-accent to-orange-500 text-white text-xs font-bold px-3 py-1.5 font-quantico rounded">
                                                -{{ $discountPercentage }}% OFF
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <!-- Product Info -->
                            <div class="p-4 flex-grow flex flex-col">
                                <a href="{{ route('product.show', $productSlug) }}"
                                    class="font-medium text-gray-900 text-sm mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-200 font-cambay flex-grow">
                                    {{ $productName }}
                                </a>

                                <!-- Price -->
                                <div class="mt-auto">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-baseline space-x-2">
                                            <span class="text-lg font-bold text-gray-900 font-quantico">
                                                TK{{ number_format($discountedPrice, 0) }}
                                            </span>
                                            @if ($discountPercentage > 0)
                                                <span class="text-sm text-gray-500 line-through font-inter">
                                                    TK{{ number_format($originalPrice, 0) }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Stock Indicator -->
                                        <div class="flex items-center">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $inStock ? 'bg-green-500' : 'bg-red-500' }} mr-1">
                                            </div>
                                            <span
                                                class="text-xs font-medium {{ $inStock ? 'text-green-600' : 'text-red-600' }} font-inter">
                                                {{ $inStock ? 'In Stock' : 'Out of Stock' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->withQueryString()->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <!-- No Products Found -->
                <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                    <div class="mb-6">
                        <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2 font-quantico">No products found</h3>
                    <p class="text-gray-500 mb-6 font-inter">No products available in this category yet.</p>
                    <a href="{{ route('products.index') }}"
                        class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-quantico">
                        Browse All Products
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sort select change handler
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('sort', this.value);
                    window.location.href = url.toString();
                });
            }
        });
    </script>
@endpush
