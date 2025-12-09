<!-- resources/views/components/product-cards/modern.blade.php -->
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
    $rating = $product['rating'] ?? 0;
    $reviewCount = $product['review_count'] ?? 0;

    // Calculate discounted price if not provided but discount percentage is
    if ($discountPercentage > 0 && $discountedPrice == $originalPrice) {
        $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);
    }
@endphp

<div
    class="group relative h-full bg-white border border-gray-200 hover:border-primary transition-all duration-300 overflow-hidden shadow-sm hover:shadow-xl flex flex-col">
    <!-- Product Link -->
    <a href="{{ route('product.show', $productSlug) }}" class="flex-grow flex flex-col">
        <!-- Image Container -->
        <div class="relative w-full aspect-square bg-gradient-to-br from-gray-50 to-white overflow-hidden">
            <!-- Image with gradient overlay -->
            <div class="absolute inset-0 flex items-center justify-center p-4">
                <img src="{{ asset($primaryImage) }}" alt="{{ $productName }}"
                    class="max-h-full max-w-full object-contain transition-transform duration-700 group-hover:scale-110">
            </div>

            <!-- Gradient Overlay on Hover -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/0 via-black/0 to-black/0 group-hover:from-black/5 group-hover:via-black/0 group-hover:to-black/0 transition-all duration-500">
            </div>

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col space-y-1 z-10">
                @if ($isNew)
                    <span
                        class="bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold px-3 py-1.5 font-quantico">
                        NEW
                    </span>
                @endif
                @if (!$inStock)
                    <span class="bg-gray-700/90 text-white text-xs font-bold px-3 py-1.5 font-quantico">
                        SOLD OUT
                    </span>
                @endif
            </div>

            <!-- Discount Badge (Right side) -->
            @if ($discountPercentage > 0)
                <div class="absolute top-3 right-3 z-10">
                    <span
                        class="bg-gradient-to-r from-accent to-orange-500 text-white text-xs font-bold px-3 py-1.5 font-quantico">
                        -{{ $discountPercentage }}% OFF
                    </span>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="p-4 flex-grow flex flex-col">
            <!-- Product Name -->
            <h3 title="{{ $productName }}"
                class="font-medium text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 font-cambay flex-grow">
                {{ $productName }}
            </h3>

            <!-- Price and Rating Row -->
            <div class="mt-auto">
                <div class="flex items-center justify-between mb-2">
                    <!-- Price -->
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
                        <div class="w-2 h-2 rounded-full {{ $inStock ? 'bg-green-500' : 'bg-red-500' }} mr-1"></div>
                        <span class="text-xs font-medium {{ $inStock ? 'text-green-600' : 'text-red-600' }} font-inter">
                            {{ $inStock ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>

                <!-- Save Amount -->
                @if ($discountPercentage > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-xs bg-green-50 text-green-700 font-medium px-2 py-1 rounded font-inter">
                            Save TK{{ number_format($originalPrice - $discountedPrice, 0) }}
                        </span>

                        <!-- Quick Actions -->
                        @if ($inStock)
                            <div class="flex items-center space-x-1">
                                <button class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                                    title="Add to Wishlist"
                                    onclick="event.preventDefault(); addToWishlist({{ $productId }})">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>

                                <form action="{{ route('cart.add', $productId) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="p-1 hover:text-primary transition-colors duration-200"
                                        title="Add to Cart">
                                        <svg class="w-4 h-4 text-gray-400 hover:text-primary" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </a>

    <!-- Quick Buy Button (Bottom Overlay) -->
    @if ($inStock)
        <div
            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
            <div class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                <div class="flex space-x-2">
                    <a href="{{ route('checkout.process', $productId) }}"
                        class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-quantico">
                        <span class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Quick Buy
                        </span>
                    </a>

                    <form action="{{ route('cart.add', $productId) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Cart
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
