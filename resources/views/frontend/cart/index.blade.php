@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')
@section('description', 'Review your shopping cart items')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-quantico">Shopping Cart</h1>
            <p class="text-gray-600 font-inter">Review your items and proceed to checkout</p>
        </div>

        @if ($cart && $cart->items->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <!-- Desktop Cart Table -->
                    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <!-- Table Header -->
                        <div class="grid grid-cols-12 gap-4 p-6 border-b border-gray-200 bg-gray-50">
                            <div class="col-span-6">
                                <span class="font-semibold text-gray-900 font-inter">Product</span>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="font-semibold text-gray-900 font-inter">Price</span>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="font-semibold text-gray-900 font-inter">Quantity</span>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="font-semibold text-gray-900 font-inter">Total</span>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div class="divide-y divide-gray-200">
                            @foreach ($cart->items as $item)
                                @php
                                    $product = $item->product;
                                    $itemTotal = $item->quantity * $item->price;
                                    $primaryImage = $product->featured_image_url ?? 'images/placeholder.jpg';
                                    $inStock = $product->in_stock;
                                @endphp

                                <div class="grid grid-cols-12 gap-4 p-6 items-center">
                                    <!-- Product Info -->
                                    <div class="col-span-6">
                                        <div class="flex items-center space-x-4">
                                            <!-- Product Image -->
                                            <a href="{{ route('product.show', $product->slug) }}" class="flex-shrink-0">
                                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                                                    <img src="{{ asset($primaryImage) }}" alt="{{ $product->name }}"
                                                        class="w-full h-full object-contain">
                                                </div>
                                            </a>

                                            <!-- Product Details -->
                                            <div>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="font-medium text-gray-900 hover:text-primary transition-colors duration-200 font-cambay line-clamp-2">
                                                    {{ $product->name }}
                                                </a>

                                                @if (!$inStock)
                                                    <div class="mt-1">
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800 font-inter">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Out of Stock
                                                        </span>
                                                    </div>
                                                @endif

                                                <!-- Remove Button -->
                                                <button onclick="removeFromCart({{ $product->id }})"
                                                    class="mt-2 text-sm text-red-600 hover:text-red-800 font-inter transition-colors duration-200">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-span-2 text-center">
                                        <span class="text-gray-900 font-semibold font-quantico">
                                            TK{{ number_format($item->price, 2) }}
                                        </span>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-span-2">
                                        <div class="flex items-center justify-center">
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button
                                                    onclick="updateQuantity({{ $product->id }}, {{ $item->quantity - 1 }})"
                                                    class="px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>

                                                <input type="number" value="{{ $item->quantity }}" min="1"
                                                    max="{{ $product->track_quantity ? $product->quantity : 999 }}"
                                                    class="w-16 text-center border-0 focus:ring-0 focus:outline-none font-inter [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                    onchange="updateQuantity({{ $product->id }}, this.value)">

                                                <button
                                                    onclick="updateQuantity({{ $product->id }}, {{ $item->quantity + 1 }})"
                                                    class="px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                    {{ !$inStock && $product->track_quantity ? 'disabled' : '' }}>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total -->
                                    <div class="col-span-2 text-center">
                                        <span class="text-lg font-bold text-gray-900 font-quantico">
                                            TK{{ number_format($itemTotal, 2) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mobile Cart Items -->
                    <div class="md:hidden space-y-4">
                        @foreach ($cart->items as $item)
                            @php
                                $product = $item->product;
                                $itemTotal = $item->quantity * $item->price;
                                $primaryImage = $product->featured_image_url ?? 'images/placeholder.jpg';
                                $inStock = $product->in_stock;
                            @endphp

                            <div class="bg-white rounded-xl border border-gray-200 p-4">
                                <div class="flex items-start space-x-4">
                                    <!-- Product Image -->
                                    <a href="{{ route('product.show', $product->slug) }}" class="flex-shrink-0">
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                                            <img src="{{ asset($primaryImage) }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                    </a>

                                    <!-- Product Info -->
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="font-medium text-gray-900 hover:text-primary transition-colors duration-200 font-cambay line-clamp-2">
                                                    {{ $product->name }}
                                                </a>

                                                <div class="mt-1">
                                                    <span class="text-gray-900 font-semibold font-quantico">
                                                        TK{{ number_format($item->price, 2) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Remove Button -->
                                            <button onclick="removeFromCart({{ $product->id }})"
                                                class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>

                                        @if (!$inStock)
                                            <div class="mt-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800 font-inter">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Out of Stock
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Quantity Controls -->
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button
                                                    onclick="updateQuantity({{ $product->id }}, {{ $item->quantity - 1 }})"
                                                    class="px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>

                                                <input type="number" value="{{ $item->quantity }}" min="1"
                                                    max="{{ $product->track_quantity ? $product->quantity : 999 }}"
                                                    class="w-16 text-center border-0 focus:ring-0 focus:outline-none font-inter [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                    onchange="updateQuantity({{ $product->id }}, this.value)">

                                                <button
                                                    onclick="updateQuantity({{ $product->id }}, {{ $item->quantity + 1 }})"
                                                    class="px-3 py-2 text-gray-600 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                                    {{ !$inStock && $product->track_quantity ? 'disabled' : '' }}>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Item Total -->
                                            <div class="text-right">
                                                <div class="text-sm text-gray-500 font-inter">Total</div>
                                                <div class="text-lg font-bold text-gray-900 font-quantico">
                                                    TK{{ number_format($itemTotal, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cart Actions -->
                    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <a href="{{ route('products.index') }}"
                            class="flex items-center text-primary hover:text-primary-dark font-medium font-inter transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Continue Shopping
                        </a>

                        <div class="flex gap-3">
                            <button onclick="clearCart()"
                                class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg font-medium font-inter transition-colors duration-200">
                                Clear Cart
                            </button>

                            <a href="{{ route('checkout.index') }}"
                                class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-quantico">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-quantico">Order Summary</h2>

                        <!-- Summary Details -->
                        <div class="space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-inter">Subtotal</span>
                                <span
                                    class="text-gray-900 font-semibold font-quantico">TK{{ number_format($cart->subtotal, 2) }}</span>
                            </div>

                            <!-- Shipping -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-inter">Shipping</span>
                                <span class="text-gray-900 font-semibold font-quantico">TK0.00</span>
                            </div>

                            <!-- Tax -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-inter">Tax</span>
                                <span class="text-gray-900 font-semibold font-quantico">TK0.00</span>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900 font-quantico">Total</span>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-gray-900 font-quantico">
                                            TK{{ number_format($cart->subtotal, 2) }}
                                        </div>
                                        <div class="text-sm text-gray-500 font-inter mt-1">
                                            Including VAT
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout.index') }}"
                            class="mt-6 w-full bg-primary hover:bg-primary-dark text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 text-center block font-quantico">
                            Proceed to Checkout
                        </a>

                        <!-- Payment Methods -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3 font-inter">We Accept</h3>
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                                <div class="w-10 h-6 bg-gray-200 rounded"></div>
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-inter">Secure checkout</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mt-6 bg-white rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 font-quantico">Have a Promo Code?</h3>
                        <form class="space-y-3">
                            <div class="flex gap-2">
                                <input type="text" placeholder="Enter promo code"
                                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                                <button type="submit"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-medium font-inter transition-colors duration-200">
                                    Apply
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 font-inter">Apply promo code at checkout</p>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="mb-6">
                    <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 mb-3 font-quantico">Your cart is empty</h2>
                <p class="text-gray-500 mb-6 font-inter">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-quantico">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Update quantity
        function updateQuantity(productId, quantity) {
            if (quantity < 1) {
                removeFromCart(productId);
                return;
            }

            fetch(`/cart/${productId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        quantity: parseInt(quantity)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to update cart totals
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to update quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the cart');
                });
        }

        // Remove item from cart
        function removeFromCart(productId) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return;
            }

            fetch(`/cart/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to update cart
                        window.location.reload();
                    } else {
                        alert('Failed to remove item from cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while removing the item');
                });
        }

        // Clear entire cart
        function clearCart() {
            if (!confirm('Are you sure you want to clear your entire cart?')) {
                return;
            }

            fetch(`/cart/clear`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data && data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while clearing the cart');
                });
        }

        // Update cart counter in navbar (if you have one)
        function updateCartCounter() {
            fetch('/cart/summary')
                .then(response => response.json())
                .then(data => {
                    // Update cart counter element in navbar
                    const cartCounter = document.querySelector('.cart-counter');
                    if (cartCounter) {
                        cartCounter.textContent = data.count;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent form submission on enter in quantity inputs
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            });

            // Debounce function for quantity updates
            const debounce = (func, wait) => {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            };

            // Apply debounce to quantity inputs
            const debouncedUpdate = debounce((productId, quantity) => {
                updateQuantity(productId, quantity);
            }, 500);

            // Add event listeners for quantity inputs
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.getAttribute('data-product-id') ||
                        this.closest('[data-product-id]')?.getAttribute('data-product-id');
                    if (productId) {
                        debouncedUpdate(productId, this.value);
                    }
                });
            });
        });
    </script>
@endpush
