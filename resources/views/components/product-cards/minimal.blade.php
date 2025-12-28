<!-- resources/views/components/product-cards/minimal.blade.php -->

@php
    $productSlug = $product['slug'] ?? '#';
    $productId = $product['id'] ?? '#';
    $productName = $product['name'] ?? 'Product Name';
    $primaryImage = $product['featured_images'][0] ?? 'images/placeholder.jpg';
    $secondaryImage = $product['featured_images'][1] ?? null;
    $discountedPrice = $product['price'] ?? ($product['compare_price'] ?? 0);
    $originalPrice = $product['compare_price'] ?? 0;
    $discountPercentage = $product['discount_percentage'] ?? 0;
    $inStock = $product['in_stock'] ?? true;
    $isNew = $product['is_new'] ?? false;
@endphp

<div
    class="group relative h-full bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">

    <!-- Image Section -->
    <a href="{{ route('product.show', $productSlug) }}">
        <div class="w-full aspect-square bg-white overflow-hidden relative">
            <img src="{{ $product->featured_image_url }}"
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
            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
            <div class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                <div class="flex space-x-2">
                    <a href="{{ route('checkout.process', $productId) }}"
                        class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-quantico">
                        <span class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 hidden 2xl:block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Buy Now
                        </span>
                    </a>

                    <form action="{{ route('cart.add', $productId) }}" method="POST"
                        class="add-to-cart-form inline-block">
                        @csrf
                        <button type="submit" title="Add to Cart"
                            class="add-to-cart-btn bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg">
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

    @if (!$inStock)
        <div
            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
            <div class="bg-gradient-to-t from-black/90 via-black/70 to-transparent pt-6 pb-4 px-4">
                <div class="flex space-x-2">
                    <a href="{{ route('contact') }}" title="+8801714XXXXXX"
                        class="flex-1 bg-white hover:bg-gray-100 text-gray-900 text-center font-semibold py-2.5 px-4 transition-colors duration-200 text-sm shadow-lg font-quantico">
                        <span class="flex items-center justify-center">
                            <!-- Contact/Phone Icon -->
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Contact Us
                        </span>
                    </a>
                </div>
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
                    TK{{ number_format($discountedPrice, 2) }}
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
                        TK{{ number_format($originalPrice, 2) }}
                    </span>
                </div>
            @endif
        </div>
    </div>

</div>
