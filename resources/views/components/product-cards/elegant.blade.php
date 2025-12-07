<!-- resources/views/components/product-cards/elegant.blade.php -->
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
        $discountedPrice = $originalPrice * (1 - ($discountPercentage / 100));
    }
@endphp

<div class="group relative h-full bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 rounded-xl overflow-hidden flex flex-col">
    <!-- Product Link -->
    <a href="{{ route('product.show', $productSlug) }}" class="flex-grow flex flex-col">
        <!-- Image Container -->
        <div class="relative w-full aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
            <!-- Main Image -->
            <div class="absolute inset-0 flex items-center justify-center p-4">
                <img src="{{ asset($primaryImage) }}" alt="{{ $productName }}"
                    class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-110">
            </div>
            
            <!-- Hover Image -->
            <div class="absolute inset-0 flex items-center justify-center p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                <img src="{{ asset($secondaryImage) }}" alt="{{ $productName }}"
                    class="max-h-full max-w-full object-contain">
            </div>
            
            <!-- Badges -->
            <div class="absolute top-3 right-3 flex flex-col space-y-1 z-10">
                @if ($isNew)
                    <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded-lg shadow-sm font-quantico">
                        NEW
                    </span>
                @endif
                @if ($discountPercentage > 0)
                    <span class="bg-accent text-white text-xs font-semibold px-2 py-1 rounded-lg shadow-sm font-quantico">
                        -{{ $discountPercentage }}%
                    </span>
                @endif
            </div>
            
            <!-- Stock Status -->
            @if (!$inStock)
                <div class="absolute top-3 left-3 bg-gray-600/90 text-white text-xs font-semibold px-2 py-1 rounded-lg shadow-sm font-quantico z-10">
                    OUT OF STOCK
                </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div class="p-4 flex-grow flex flex-col">
            <!-- Product Name -->
            <h3 class="font-medium text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 font-cambay flex-grow">
                {{ $productName }}
            </h3>
            
            <!-- Price -->
            <div class="mt-auto">
                <div class="flex items-baseline justify-between">
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
                    
                    <!-- Wishlist Button -->
                    <button class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                        title="Add to Wishlist"
                        onclick="event.preventDefault(); addToWishlist({{ $productId }})">
                        <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                
                <!-- Save Amount -->
                @if ($discountPercentage > 0)
                    <div class="mt-1">
                        <span class="text-xs text-gray-600 font-inter">
                            Save TK{{ number_format($originalPrice - $discountedPrice, 0) }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </a>
    
    <!-- Quick Actions (Bottom Overlay) -->
    @if ($inStock)
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pt-8 pb-4 px-4">
            <div class="flex space-x-2">
                <!-- Quick Buy -->
                <a href="{{ route('checkout.direct', $productId) }}"
                    class="flex-1 bg-primary hover:bg-primary-dark text-white text-center font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-sm font-quantico shadow-lg">
                    Buy Now
                </a>
                
                <!-- Quick Add to Cart -->
                <form action="{{ route('cart.add', $productId) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-sm shadow-lg">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Add
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>