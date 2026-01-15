@extends('frontend.layouts.app')

@section('title', 'Checkout')
@section('description', 'Complete your purchase')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-quantico">Checkout</h1>
            <p class="text-gray-600 font-inter">Complete your purchase in just a few steps</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <!-- Step 1 -->
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-semibold font-inter">
                            1
                        </div>
                        <div class="ml-2 font-medium text-primary font-inter">Shipping</div>
                    </div>

                    <!-- Line -->
                    <div class="w-24 h-1 bg-gray-300 mx-4"></div>

                    <!-- Step 2 -->
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold font-inter">
                            2
                        </div>
                        <div class="ml-2 font-medium text-gray-600 font-inter">Payment</div>
                    </div>

                    <!-- Line -->
                    <div class="w-24 h-1 bg-gray-300 mx-4"></div>

                    <!-- Step 3 -->
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold font-inter">
                            3
                        </div>
                        <div class="ml-2 font-medium text-gray-600 font-inter">Confirmation</div>
                    </div>
                </div>
            </div>
        </div>

        <form id="checkoutForm" class="flex flex-col lg:flex-row gap-8">
            @csrf

            <!-- Left Column - Shipping & Payment -->
            <div class="lg:w-2/3 space-y-8">
                <!-- Shipping Address -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 font-quantico">Shipping Address</h2>

                    <!-- Existing Addresses -->
                    @if ($user && $addresses->where('type', 'shipping')->count() > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3 font-inter">Select an existing
                                address</label>
                            <div class="space-y-3">
                                @foreach ($addresses->where('type', 'shipping') as $address)
                                    <label
                                        class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary transition-colors duration-200">
                                        <input type="radio" name="shipping_address_id" value="{{ $address->id }}"
                                            class="mt-1 text-primary focus:ring-primary"
                                            {{ $address->is_default ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900 font-inter">
                                                {{ $address->first_name }} {{ $address->last_name }}
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1 font-inter">
                                                {{ $address->address_line_1 }}<br>
                                                @if ($address->address_line_2)
                                                    {{ $address->address_line_2 }}<br>
                                                @endif
                                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                                                {{ $address->country }}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-2 font-inter">
                                                {{ $address->phone }} • {{ $address->email }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <label class="flex items-center">
                                    <input type="radio" name="use_existing_shipping" value="0"
                                        class="text-primary focus:ring-primary" checked>
                                    <span class="ml-2 text-sm text-gray-700 font-inter">Use a new address</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- New Address Form -->
                    <div id="newShippingAddress" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">First Name *</label>
                                <input type="text" name="shipping_first_name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Last Name *</label>
                                <input type="text" name="shipping_last_name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Email *</label>
                                <input type="email" name="shipping_email"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Phone *</label>
                                <input type="tel" name="shipping_phone"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Address Line 1 *</label>
                            <input type="text" name="shipping_address_1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Address Line 2
                                (Optional)</label>
                            <input type="text" name="shipping_address_2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">City *</label>
                                <input type="text" name="shipping_city"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">State/Province
                                    *</label>
                                <input type="text" name="shipping_state"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Postal Code *</label>
                                <input type="text" name="shipping_postal_code"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Country *</label>
                            <select name="shipping_country"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                                required>
                                <option value="">Select Country</option>
                                <option value="Bangladesh" selected>Bangladesh</option>
                                <option value="India">India</option>
                                <option value="United States">United States</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <!-- Add more countries as needed -->
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 font-quantico">Billing Address</h2>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="same_as_shipping" name="same_as_shipping"
                                class="rounded border-gray-300 text-primary focus:ring-primary" checked>
                            <span class="ml-2 text-gray-700 font-inter">Same as shipping address</span>
                        </label>
                    </div>

                    <!-- Billing Address Form (Hidden by default) -->
                    <div id="billingAddressForm" class="space-y-4 hidden">
                        @if ($user && $addresses->where('type', 'billing')->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3 font-inter">Select an existing
                                    address</label>
                                <div class="space-y-3">
                                    @foreach ($addresses->where('type', 'billing') as $address)
                                        <label
                                            class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary transition-colors duration-200">
                                            <input type="radio" name="billing_address_id" value="{{ $address->id }}"
                                                class="mt-1 text-primary focus:ring-primary">
                                            <div class="ml-3">
                                                <div class="font-medium text-gray-900 font-inter">
                                                    {{ $address->first_name }} {{ $address->last_name }}
                                                </div>
                                                <div class="text-sm text-gray-600 mt-1 font-inter">
                                                    {{ $address->address_line_1 }}<br>
                                                    @if ($address->address_line_2)
                                                        {{ $address->address_line_2 }}<br>
                                                    @endif
                                                    {{ $address->city }}, {{ $address->state }}
                                                    {{ $address->postal_code }}<br>
                                                    {{ $address->country }}
                                                </div>
                                                <div class="text-sm text-gray-500 mt-2 font-inter">
                                                    {{ $address->phone }} • {{ $address->email }}
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <!-- Similar form fields as shipping address -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">First Name
                                        *</label>
                                    <input type="text" name="billing_first_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Last Name
                                        *</label>
                                    <input type="text" name="billing_last_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                                </div>
                            </div>

                            <!-- Add other billing fields as needed -->
                        </div>
                    </div>
                </div>

                <!-- Shipping Method -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 font-quantico">Shipping Method</h2>

                    <div class="space-y-4">
                        <label
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary transition-colors duration-200">
                            <div class="flex items-center">
                                <input type="radio" name="shipping_method" value="standard"
                                    class="text-primary focus:ring-primary" checked>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900 font-inter">Standard Shipping</div>
                                    <div class="text-sm text-gray-600 mt-1 font-inter">5-7 business days • Free</div>
                                </div>
                            </div>
                            <div class="text-lg font-bold text-gray-900 font-quantico">Free</div>
                        </label>

                        <label
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary transition-colors duration-200">
                            <div class="flex items-center">
                                <input type="radio" name="shipping_method" value="express"
                                    class="text-primary focus:ring-primary">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900 font-inter">Express Shipping</div>
                                    <div class="text-sm text-gray-600 mt-1 font-inter">2-3 business days</div>
                                </div>
                            </div>
                            <div class="text-lg font-bold text-gray-900 font-quantico">TK200</div>
                        </label>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 font-quantico">Payment Method</h2>

                    <div class="space-y-4">
                        <label
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary transition-colors duration-200">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="cod"
                                    class="text-primary focus:ring-primary" checked>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900 font-inter">Cash on Delivery</div>
                                    <div class="text-sm text-gray-600 mt-1 font-inter">Pay when you receive your order
                                    </div>
                                </div>
                            </div>
                            <div class="text-primary">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </label>

                        <label
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-primary transition-colors duration-200">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="card"
                                    class="text-primary focus:ring-primary">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900 font-inter">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-600 mt-1 font-inter">Pay securely with your card</div>
                                </div>
                            </div>
                            <div class="text-primary">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                    <path fill-rule="evenodd"
                                        d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 font-quantico">Order Notes (Optional)</h2>
                    <textarea name="notes" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter"
                        placeholder="Special instructions for your order..."></textarea>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:w-1/3">
                <div class="sticky top-6 space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-quantico">Order Summary</h2>

                        <!-- Order Items -->
                        <div class="space-y-4 mb-6">
                            @foreach ($cart->items as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden mr-3">
                                            <img src="{{ asset($item->product->featured_image_url) }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm font-cambay line-clamp-1">
                                                {{ $item->product->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 font-inter">
                                                Qty: {{ $item->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-gray-900 font-semibold font-quantico">
                                        <span
                                            class="font-bengali">৳</span>{{ number_format($item->quantity * $item->price, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary Details -->
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-inter">Subtotal</span>
                                <span class="font-semibold text-gray-900 font-quantico"><span
                                        class="font-bengali">৳</span>{{ number_format($cart->subtotal, 2) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600 font-inter">Shipping</span>
                                <span class="font-semibold text-gray-900 font-quantico">
                                    <span id="shippingAmount">TK0.00</span>
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600 font-inter">Tax</span>
                                <span class="font-semibold text-gray-900 font-quantico">TK0.00</span>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold text-gray-900 font-quantico">Total</span>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-gray-900 font-quantico">
                                            <span class="font-bengali">৳</span><span
                                                id="totalAmount">{{ number_format($cart->subtotal, 2) }}</span>
                                        </div>
                                        <div class="text-sm text-gray-500 font-inter mt-1">
                                            Including VAT
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms"
                                class="mt-1 rounded border-gray-300 text-primary focus:ring-primary" required>
                            <span class="ml-2 text-sm text-gray-700 font-inter">
                                I agree to the <a href="#" class="text-primary hover:underline">Terms &
                                    Conditions</a>
                                and <a href="#" class="text-primary hover:underline">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <!-- Guest Checkout / Create Account -->
                    @if (!$user)
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <label class="flex items-start mb-4">
                                <input type="checkbox" name="create_account"
                                    class="mt-1 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="ml-2 text-sm text-gray-700 font-inter">Create an account for faster
                                    checkout</span>
                            </label>

                            <div id="passwordField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Password *</label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-inter">
                            </div>
                        </div>
                    @endif

                    <!-- Place Order Button -->
                    <button type="submit" id="placeOrderBtn"
                        class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 text-center font-quantico text-lg">
                        Place Order
                    </button>

                    <!-- Security Badge -->
                    <div class="text-center">
                        <div class="inline-flex items-center text-sm text-gray-600 font-inter">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Secure SSL Encryption
                        </div>
                    </div>

                    <!-- Continue Shopping -->
                    <div class="text-center">
                        <a href="{{ route('cart.index') }}"
                            class="inline-flex items-center text-primary hover:text-primary-dark font-medium font-inter transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const sameAsShippingCheckbox = document.getElementById('same_as_shipping');
            const billingAddressForm = document.getElementById('billingAddressForm');
            const shippingMethodRadios = document.querySelectorAll('input[name="shipping_method"]');
            const createAccountCheckbox = document.querySelector('input[name="create_account"]');
            const passwordField = document.getElementById('passwordField');

            // Toggle billing address form
            if (sameAsShippingCheckbox && billingAddressForm) {
                sameAsShippingCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        billingAddressForm.classList.add('hidden');
                    } else {
                        billingAddressForm.classList.remove('hidden');
                    }
                });
            }

            // Toggle password field for guest checkout
            if (createAccountCheckbox && passwordField) {
                createAccountCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        passwordField.classList.remove('hidden');
                    } else {
                        passwordField.classList.add('hidden');
                    }
                });
            }

            // Handle shipping method change
            shippingMethodRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateOrderSummary();
                });
            });

            // Form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Disable button to prevent double submission
                placeOrderBtn.disabled = true;
                placeOrderBtn.innerHTML = 'Processing...';

                try {
                    const formData = new FormData(this);
                    const response = await fetch('{{ route('checkout.process') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Redirect to success page
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Checkout failed. Please try again.');
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.innerHTML = 'Place Order';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.innerHTML = 'Place Order';
                }
            });

            // Update order summary based on shipping method
            function updateOrderSummary() {
                const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
                const subtotal = {{ $cart->subtotal }};
                let shippingAmount = 0;

                if (selectedShipping && selectedShipping.value === 'express') {
                    shippingAmount = 200;
                }

                // Update UI
                const shippingElement = document.getElementById('shippingAmount');
                const totalElement = document.getElementById('totalAmount');

                if (shippingElement && totalElement) {
                    shippingElement.textContent = `<span class="font-bengali">৳</span>${shippingAmount.toFixed(2)}`;
                    totalElement.textContent = (subtotal + shippingAmount).toFixed(2);
                }
            }

            // Validate shipping address fields when using new address
            document.querySelectorAll('input[name="use_existing_shipping"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const newAddressForm = document.getElementById('newShippingAddress');
                    const shippingInputs = newAddressForm.querySelectorAll('[required]');

                    if (this.value === '0') {
                        // Using new address - make fields required
                        shippingInputs.forEach(input => input.required = true);
                    } else {
                        // Using existing address - remove required attribute
                        shippingInputs.forEach(input => input.required = false);
                    }
                });
            });

            // Initialize summary
            updateOrderSummary();
        });
    </script>
@endpush
