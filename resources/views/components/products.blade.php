<!-- Products Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-8xl mx-auto px-4">
        <!-- Section Title -->
        <h2
            class="text-3xl sm:text-4xl md:text-5xl font-semibold text-center text-gray-900 mb-12 leading-tight font-quantico">
            Featured Products
        </h2>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-6">
            @foreach ($products as $product)
                <div class="group bg-white rounded-3xl overflow-hidden relative">
                    <!-- Product Image with Overlay -->
                    <a href="{{ route('product.show', $product['slug']) }}" class="block relative">
                        <div class="relative w-full aspect-square bg-gray-100 overflow-hidden">
                            <img src="{{ asset($product['images'][0]) }}"
                                class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105">

                            <!-- Product Badges -->
                            @if ($product['is_new'])
                                <span
                                    class="absolute top-3 left-3 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold px-3 py-1 rounded-full font-inter">
                                    New
                                </span>
                            @endif

                            @if ($product['discount_percentage'] > 0)
                                <span
                                    class="absolute top-3 right-3 bg-gradient-to-r from-red-600 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold font-quantico shadow-md">
                                    -{{ $product['discount_percentage'] }}%
                                </span>
                            @endif

                            <!-- Hover Overlay with Actions -->
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div
                                    class="transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 space-y-3">
                                    @if ($product['in_stock'])
                                        <form action="{{ route('checkout.direct', $product['id']) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <button type="submit" title="Click to Buy"
                                                class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg font-quantico">
                                                Buy Now
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishlist.add', $product['id']) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center space-x-2">
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                                <span class="font-quantico">Add to Wishlist</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Quick Actions -->
                                    <div class="flex justify-center space-x-3">
                                        <button title="View Details"
                                            class="bg-white p-3 rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-110"
                                            onclick="quickView({{ $product['id'] }})">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <form action="{{ route('cart.add', $product['id']) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <button type="submit" title="Add to Cart"
                                                class="bg-white p-3 rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-110 {{ !$product['in_stock'] ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ !$product['in_stock'] ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Product Info - Option 3: Elegant with Divider -->
                    <div class="p-5">
                        <!-- Product Name -->
                        <a href="{{ route('product.show', $product['slug']) }}" class="block mb-1"
                            title="{{ $product['name'] }}">
                            <h3
                                class="text-base font-medium text-gray-900 hover:text-primary transition-colors duration-200 line-clamp-2 mb-1 font-cambay">
                                {{ $product['name'] }}
                            </h3>
                        </a>

                        <!-- Divider -->
                        <div class="h-px bg-gray-200 mb-1"></div>

                        <!-- Price Section -->
                        <div class="space-y-1">
                            @if ($product['discount_percentage'] > 0)
                                <div class="flex items-end justify-between">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900 font-quantico">
                                            TK{{ number_format($product['discounted_price'], 2) }}
                                        </span>
                                        <div class="mt-1">
                                            <span class="text-sm text-gray-500 line-through font-cambay">
                                                TK{{ number_format($product['original_price'], 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-emerald-600 font-medium">
                                        {{ $product['in_stock'] ? '✓ Available' : '✗ Sold Out' }}
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-gray-900 font-quantico">
                                        TK{{ number_format($product['original_price'], 2) }}
                                    </span>
                                    <span
                                        class="text-xs {{ $product['in_stock'] ? 'text-emerald-600' : 'text-rose-600' }} font-medium">
                                        {{ $product['in_stock'] ? '✓ In Stock' : '✗ Out of Stock' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load More Button -->
        @php
            $loadMore = count($products) > 2;
        @endphp
        @if (isset($loadMore) && $loadMore)
            <div class="text-center mt-12">
                <button
                    class="bg-primary text-white px-8 py-3 rounded-full font-semibold hover:bg-primary-dark transition-all duration-300 transform hover:scale-105 font-quantico">
                    Load More Products
                </button>
            </div>
        @endif
    </div>
</section>
@push('scripts')
    <script>
        function quickView(productId) {
            // Implement quick view modal functionality
            console.log('Quick view for product:', productId);
            // You can use AJAX to fetch product details and show in a modal
        }

        // Add to wishlist with feedback
        document.addEventListener('DOMContentLoaded', function() {
            const wishlistForms = document.querySelectorAll('form[action*="wishlist"]');

            wishlistForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Add your AJAX request here
                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: form.querySelector(
                                    'input[name="product_id"]')?.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                alert('Product added to wishlist!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endpush
