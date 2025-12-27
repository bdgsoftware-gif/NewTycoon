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
                    <a href="{{ route('product.show', $product->slug) }}" class="block relative">
                        <div class="relative w-full aspect-square bg-gray-100 overflow-hidden">
                            <img src="{{ asset($product['featured_images'][0]) }}"
                                class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105">

                            <!-- Product Badges -->
                            @if ($product->is_new)
                                <span
                                    class="absolute top-3 left-3 bg-gradient-to-r from-primary to-primary-dark text-white text-xs font-bold px-3 py-1 rounded-full font-inter">
                                    New
                                </span>
                            @endif

                            @if ($product->discount_percentage > 0)
                                <span
                                    class="absolute top-3 right-3 bg-gradient-to-r from-red-600 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold font-quantico shadow-md">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif

                            <!-- Hover Overlay with Actions -->
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div
                                    class="transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 space-y-3">
                                    @if ($product->in_stock)
                                        <form action="{{ route('checkout.process', $product->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <button type="submit" title="Click to Buy"
                                                class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg font-quantico">
                                                Buy Now
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
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
                                            onclick="quickView({{ $product->id }})">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            class="add-to-cart-form inline-block">
                                            @csrf
                                            <button type="submit" title="Add to Cart"
                                                class="add-to-cart-btn bg-white p-3 rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-110 {{ !$product->in_stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ !$product->in_stock ? 'disabled' : '' }}>
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

                    <!-- Product Info - Elegant with Divider -->
                    <div class="p-5">
                        <!-- Product Name -->
                        <a href="{{ route('product.show', $product->slug) }}" class="block mb-1"
                            title="{{ $product->name }}">
                            <h3
                                class="text-base font-medium text-gray-900 hover:text-primary transition-colors duration-200 line-clamp-2 mb-1 font-cambay">
                                {{ $product->name }}
                            </h3>
                        </a>

                        <!-- Divider -->
                        <div class="h-px bg-gray-200 mb-1"></div>

                        <!-- Price Section -->
                        <div class="space-y-1">
                            @if ($product->discount_percentage > 0)
                                <div class="flex items-end justify-between">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900 font-quantico">
                                            TK{{ number_format($product->price, 2) }}
                                        </span>
                                        <div class="mt-1">
                                            <span class="text-sm text-gray-500 line-through font-cambay">
                                                TK{{ number_format($product->compare_price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between pt-1">
                                            <div class="flex items-center space-x-1">
                                                <!-- Wishlist Icon -->
                                                <button type="button"
                                                    class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                    title="Add to Wishlist">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-gray-400 hover:text-red-500" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                </button>

                                                <!-- Cart/Call Icon -->
                                                @if ($product->in_stock)
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                        class="add-to-cart-form inline-block">
                                                        @csrf
                                                        <button type="submit"
                                                            class="add-to-cart-btn p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                            title="Add to Cart"
                                                            {{ !$product->in_stock ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                            {{ !$product->in_stock ? 'disabled' : '' }}>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-gray-400 hover:text-primary"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('contact') }}"
                                                        class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 inline-block"
                                                        title="Call for Availability +8801714XXXXXX">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-gray-400 hover:text-green-600"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74L9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33Z" " />
                                                        </svg>
                                                    </a>
 @endif
                                            </div>
                                        </div>

                                        <span class="text-xs text-emerald-600 font-medium">
                                            {{ $product->in_stock ? '✓ Available' : '✗ Sold Out' }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start justify-between">
                                    <span class="text-2xl font-bold text-gray-900 font-quantico">
                                        TK{{ number_format($product->price, 2) }}
                                    </span>
                                    <div>
                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between pt-1">
                                            <div class="flex items-center space-x-1">
                                                <!-- Wishlist Icon -->
                                                <button type="button"
                                                    class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                    title="Add to Wishlist">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-gray-400 hover:text-red-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                </button>

                                                <!-- Cart Icon -->
                                                <button type="button"
                                                    class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200"
                                                    title="Add to Cart">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-gray-400 hover:text-primary"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <span class="text-xs text-primary font-medium">
                                            {{ $product->in_stock ? '✓ Available' : '✗ Sold Out' }}
                                        </span>
                                    </div>
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
                <a href="{{ route('products.index') }}" target="_self"
                    class="bg-primary text-white px-8 py-3 rounded-full font-semibold hover:bg-primary-dark transition-all duration-300 transform hover:scale-105 font-quantico">
                    View More Products
                </a>
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
