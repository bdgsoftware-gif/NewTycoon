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

<div
    class="group relative h-full bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">

    <!-- Image Section -->
    <a href="{{ route('product.show', $productSlug) }}">
        <div class="w-full aspect-square bg-white overflow-hidden relative">
            <img src="{{ asset($primaryImage) }}"
                class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 group-hover:opacity-0">
            <img src="{{ asset($secondaryImage ?? $primaryImage) }}"
                class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100 {{ !$secondaryImage ? 'group-hover:scale-105' : '' }}">
        </div>

    </a>

    <!-- Stock Badge -->
    @if (!$inStock)
        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 z-20 font-quantico">
            OUT OF STOCK
        </div>
    @elseif($isNew)
        <div class="absolute top-2 right-2 bg-accent text-white text-xs font-bold px-2 py-1 z-20 font-quantico">
            NEW
        </div>
    @endif

    <!-- Buy Now Overlay -->
    @if ($inStock)
        <div
            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-30">
            <div class="bg-gradient-to-t from-black/80 to-transparent pt-6 pb-3 px-4">
                <a href="{{ route('checkout.direct', $productId) }}"
                    class="block w-full bg-primary hover:bg-primary-dark text-white text-center font-semibold py-2.5 px-4 transition-colors duration-200 shadow-lg hover:shadow-xl transform">
                    <span class="flex items-center justify-center font-quantico">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Buy Now
                    </span>
                </a>
            </div>
        </div>
    @endif
    <!-- Product Info -->
    <div class="p-4 border-t border-gray-100 flex-grow flex flex-col">

        <a href="{{ route('product.show', $productSlug) }}"
            class="font-medium font-quantico text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 flex-grow">
            {{ $productName }}
        </a>

        <!-- Price + Wishlist -->
        <div class="mt-auto">
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold font-quantico text-gray-900">
                    ${{ number_format($discountedPrice, 2) }}
                </span>

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

            @if ($discountPercentage > 0)
                <div class="flex items-center space-x-2 mt-2 font-inter">
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
