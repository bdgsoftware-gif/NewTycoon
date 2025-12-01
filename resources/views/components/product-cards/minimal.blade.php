<!-- resources/views/components/product-cards/minimal.blade.php -->
@php
    $productSlug = $product['slug'] ?? '#';
    $productId = $product['id'] ?? '#';
    $productName = $product['name'] ?? 'Product Name';
    $primaryImage = $product['images'][0] ?? 'images/placeholder.jpg';
    $secondaryImage = $product['images'][1] ?? null;
    $discountedPrice = $product['discounted_price'] ?? ($product['original_price'] ?? 0);
    $originalPrice = $product['original_price'] ?? 0;
    $discountPercentage = $product['discount_percentage'] ?? 0;
    $inStock = $product['in_stock'] ?? true;
    $isNew = $product['is_new'] ?? false;
@endphp

<a href="{{ $productSlug !== '#' ? route('product.details', $productSlug) : '#' }}" class="block group h-full">
    <div
        class="bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col h-full">
        <!-- Image Container with Hover Effect -->
        <div class="relative bg-white overflow-hidden flex-shrink-0" style="height: 250px;">
            <div class="relative w-full h-full">
                <!-- Primary Image -->
                <img src="{{ asset($primaryImage) }}" alt="{{ $productName }}"
                    class="absolute inset-0 w-full h-full object-contain p-4 transition-opacity duration-300 group-hover:opacity-0">

                <!-- Secondary Image (Shows on Hover) -->
                @if ($secondaryImage)
                    <img src="{{ asset($secondaryImage) }}" alt="{{ $productName }} - View 2"
                        class="absolute inset-0 w-full h-full object-contain p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                @else
                    <!-- Fallback: Zoom effect on single image -->
                    <img src="{{ asset($primaryImage) }}" alt="{{ $productName }}"
                        class="absolute inset-0 w-full h-full object-contain p-4 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:scale-105">
                @endif

                <!-- Stock Badge -->
                @if (!$inStock)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1">
                        OUT OF STOCK
                    </div>
                @elseif($isNew)
                    <div class="absolute top-2 right-2 bg-blue-500 text-white text-xs font-bold px-2 py-1">
                        NEW
                    </div>
                @endif

                <!-- Buy Now Button (Shows on Hover) -->
                @if ($inStock)
                    <a href="{{ $productId !== '#' ? route('checkout.direct', $productId) : '#' }}"
                        class="absolute top-2 left-2 bg-primary text-white px-3 py-1.5 text-xs font-medium opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 hover:bg-primary-dark z-10">
                        Buy Now
                    </a>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="p-4 border-t border-gray-100 flex-grow flex flex-col">
            <!-- Product Title -->
            <h3
                class="font-medium text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 flex-grow">
                {{ $productName }}
            </h3>

            <!-- Price Section -->
            <div class="mt-auto">
                <!-- Current Price -->
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-lg font-bold text-gray-900">
                            ${{ number_format($discountedPrice, 2) }}
                        </span>
                    </div>

                    <!-- Wishlist Button (for out of stock) -->
                    @if (!$inStock)
                        <button class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                            title="Add to Wishlist">
                            <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Discount/Save Info -->
                @if ($discountPercentage > 0)
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1">
                            Save {{ $discountPercentage }}%
                        </span>
                        <span class="text-xs text-gray-500 line-through">
                            ${{ number_format($originalPrice, 2) }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</a>
