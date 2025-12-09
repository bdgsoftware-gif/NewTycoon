@extends('admin.layouts.app')

@section('title', 'Create Order')
@section('page-title', 'Create New Order')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700">Orders</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Create</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Create New Order</h2>
                            <p class="text-sm text-gray-600 mt-1">Create a new order manually</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.orders.index') }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                Create Order
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6 space-y-8">
                    <!-- Customer Selection -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Customer Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Select Customer
                                </label>
                                <select id="customerSelect"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="">Search for a customer...</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" data-name="{{ $customer->name }}"
                                            data-email="{{ $customer->email }}" data-phone="{{ $customer->phone }}">
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Customer Details -->
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name *
                                    </label>
                                    <input type="text" id="customer_name" name="customer_name" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Customer name">
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address *
                                    </label>
                                    <input type="email" id="customer_email" name="customer_email" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="customer@example.com">
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Phone Number
                                    </label>
                                    <input type="text" id="customer_phone" name="customer_phone"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="+1 (555) 123-4567">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Shipping Information
                        </h3>

                        <div class="space-y-4">
                            <!-- Copy from customer -->
                            <div class="flex items-center">
                                <input type="checkbox" id="copyShippingFromCustomer"
                                    class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <label for="copyShippingFromCustomer" class="ml-2 text-sm text-gray-700">
                                    Use customer information for shipping
                                </label>
                            </div>

                            <!-- Shipping Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name *
                                    </label>
                                    <input type="text" id="shipping_name" name="shipping_name" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Shipping name">
                                </div>

                                <div>
                                    <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address *
                                    </label>
                                    <input type="email" id="shipping_email" name="shipping_email" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="shipping@example.com">
                                </div>

                                <div>
                                    <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Phone Number *
                                    </label>
                                    <input type="text" id="shipping_phone" name="shipping_phone" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="+1 (555) 123-4567">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="shipping_address_line1"
                                        class="block text-sm font-medium text-gray-700 mb-1">
                                        Address Line 1 *
                                    </label>
                                    <input type="text" id="shipping_address_line1" name="shipping_address_line1"
                                        required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Street address">
                                </div>

                                <div>
                                    <label for="shipping_address_line2"
                                        class="block text-sm font-medium text-gray-700 mb-1">
                                        Address Line 2
                                    </label>
                                    <input type="text" id="shipping_address_line2" name="shipping_address_line2"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Apartment, suite, unit, etc.">
                                </div>

                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">
                                        City *
                                    </label>
                                    <input type="text" id="shipping_city" name="shipping_city" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="City">
                                </div>

                                <div>
                                    <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">
                                        State/Province *
                                    </label>
                                    <input type="text" id="shipping_state" name="shipping_state" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="State">
                                </div>

                                <div>
                                    <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">
                                        Country *
                                    </label>
                                    <input type="text" id="shipping_country" name="shipping_country" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Country">
                                </div>

                                <div>
                                    <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700 mb-1">
                                        ZIP/Postal Code *
                                    </label>
                                    <input type="text" id="shipping_zip_code" name="shipping_zip_code" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="12345">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Billing Information
                        </h3>

                        <div class="space-y-4">
                            <!-- Same as shipping -->
                            <div class="flex items-center">
                                <input type="checkbox" id="billing_same_as_shipping" name="billing_same_as_shipping"
                                    value="1" checked
                                    class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <label for="billing_same_as_shipping" class="ml-2 text-sm text-gray-700">
                                    Billing address same as shipping
                                </label>
                            </div>

                            <!-- Billing Details (hidden by default) -->
                            <div id="billingDetails" class="hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Full Name
                                        </label>
                                        <input type="text" id="billing_name" name="billing_name"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="Billing name">
                                    </div>

                                    <div>
                                        <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email Address
                                        </label>
                                        <input type="email" id="billing_email" name="billing_email"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="billing@example.com">
                                    </div>

                                    <div>
                                        <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                            Phone Number
                                        </label>
                                        <input type="text" id="billing_phone" name="billing_phone"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="+1 (555) 123-4567">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="billing_address_line1"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Address Line 1
                                        </label>
                                        <input type="text" id="billing_address_line1" name="billing_address_line1"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="Street address">
                                    </div>

                                    <div>
                                        <label for="billing_address_line2"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Address Line 2
                                        </label>
                                        <input type="text" id="billing_address_line2" name="billing_address_line2"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="Apartment, suite, unit, etc.">
                                    </div>

                                    <div>
                                        <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">
                                            City
                                        </label>
                                        <input type="text" id="billing_city" name="billing_city"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="City">
                                    </div>

                                    <div>
                                        <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">
                                            State/Province
                                        </label>
                                        <input type="text" id="billing_state" name="billing_state"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="State">
                                    </div>

                                    <div>
                                        <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">
                                            Country
                                        </label>
                                        <input type="text" id="billing_country" name="billing_country"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="Country">
                                    </div>

                                    <div>
                                        <label for="billing_zip_code"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            ZIP/Postal Code
                                        </label>
                                        <input type="text" id="billing_zip_code" name="billing_zip_code"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                            placeholder="12345">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            Order Items
                        </h3>

                        <div class="space-y-4">
                            <!-- Product Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Add Products
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input type="text" id="productSearch"
                                        placeholder="Search products by name or SKU..."
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>
                                <div id="productResults"
                                    class="hidden absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                                </div>
                            </div>

                            <!-- Order Items Table -->
                            <div class="border border-gray-300 rounded-xl overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Product
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Price
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Quantity
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderItems" class="bg-white divide-y divide-gray-200">
                                        <!-- Items will be added here dynamically -->
                                        <tr id="noItems" class="text-center">
                                            <td colspan="5" class="px-4 py-8 text-gray-500">
                                                No items added yet. Search for products above.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Order Summary -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label for="shipping_method"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Shipping Method
                                            </label>
                                            <select id="shipping_method" name="shipping_method"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                                <option value="standard">Standard Shipping</option>
                                                <option value="express">Express Shipping</option>
                                                <option value="overnight">Overnight Shipping</option>
                                                <option value="pickup">Store Pickup</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="payment_method"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Payment Method
                                            </label>
                                            <select id="payment_method" name="payment_method"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                                <option value="credit_card">Credit Card</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="cash_on_delivery">Cash on Delivery</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span id="subtotal" class="font-medium text-gray-900">$0.00</span>
                                        </div>

                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Discount</span>
                                            <div class="flex items-center">
                                                <span id="discountAmount" class="text-red-600">$0.00</span>
                                                <button type="button" onclick="toggleDiscountInput()"
                                                    class="ml-2 text-xs text-primary hover:text-primary/80">
                                                    Add
                                                </button>
                                            </div>
                                        </div>

                                        <div id="discountInput" class="hidden">
                                            <div class="flex space-x-2">
                                                <input type="number" id="discount" name="discount_amount"
                                                    value="0" step="0.01" min="0"
                                                    class="flex-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm"
                                                    placeholder="Amount">
                                                <button type="button" onclick="applyDiscount()"
                                                    class="px-3 py-1.5 bg-primary text-white text-sm rounded-lg hover:bg-primary/90">
                                                    Apply
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Shipping</span>
                                            <div class="flex items-center">
                                                <span id="shippingCost" class="font-medium text-gray-900">$0.00</span>
                                                <button type="button" onclick="toggleShippingInput()"
                                                    class="ml-2 text-xs text-primary hover:text-primary/80">
                                                    Edit
                                                </button>
                                            </div>
                                        </div>

                                        <div id="shippingInput" class="hidden">
                                            <div class="flex space-x-2">
                                                <input type="number" id="shipping_cost" name="shipping_cost"
                                                    value="0" step="0.01" min="0"
                                                    class="flex-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm"
                                                    placeholder="Shipping cost">
                                                <button type="button" onclick="applyShipping()"
                                                    class="px-3 py-1.5 bg-primary text-white text-sm rounded-lg hover:bg-primary/90">
                                                    Apply
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Tax</span>
                                            <span id="taxAmount" class="font-medium text-gray-900">$0.00</span>
                                        </div>

                                        <div class="border-t border-gray-200 pt-3">
                                            <div class="flex justify-between text-base font-semibold">
                                                <span class="text-gray-900">Total</span>
                                                <span id="totalAmount" class="text-gray-900">$0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Order Notes
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label for="customer_note" class="block text-sm font-medium text-gray-700 mb-1">
                                    Customer Note (Visible to Customer)
                                </label>
                                <textarea id="customer_note" name="customer_note" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Any notes for the customer..."></textarea>
                            </div>

                            <div>
                                <label for="admin_note" class="block text-sm font-medium text-gray-700 mb-1">
                                    Admin Note (Private)
                                </label>
                                <textarea id="admin_note" name="admin_note" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                    placeholder="Internal notes about this order..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Order Status</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Order Status
                                </label>
                                <select id="status" name="status"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed" selected>Completed</option>
                                    <option value="on_hold">On Hold</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Payment Status
                                </label>
                                <select id="payment_status" name="payment_status"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="pending">Pending</option>
                                    <option value="paid" selected>Paid</option>
                                    <option value="failed">Failed</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.orders.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Create Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Order items management
        let orderItems = [];
        let subtotal = 0;
        let discount = 0;
        let shipping = 0;
        let taxRate = 0.1; // 10% tax

        // Customer selection
        document.getElementById('customerSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                document.getElementById('customer_name').value = selectedOption.dataset.name;
                document.getElementById('customer_email').value = selectedOption.dataset.email;
                document.getElementById('customer_phone').value = selectedOption.dataset.phone || '';
            }
        });

        // Copy shipping from customer
        document.getElementById('copyShippingFromCustomer').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('shipping_name').value = document.getElementById('customer_name').value;
                document.getElementById('shipping_email').value = document.getElementById('customer_email').value;
                document.getElementById('shipping_phone').value = document.getElementById('customer_phone').value;
            }
        });

        // Billing same as shipping
        document.getElementById('billing_same_as_shipping').addEventListener('change', function() {
            const billingDetails = document.getElementById('billingDetails');
            if (this.checked) {
                billingDetails.classList.add('hidden');
            } else {
                billingDetails.classList.remove('hidden');
            }
        });

        // Product search
        document.getElementById('productSearch').addEventListener('input', function() {
            const query = this.value;
            if (query.length < 2) {
                document.getElementById('productResults').classList.add('hidden');
                return;
            }

            fetch(`/admin/products/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(products => {
                    const resultsContainer = document.getElementById('productResults');
                    resultsContainer.innerHTML = '';

                    if (products.length === 0) {
                        resultsContainer.innerHTML =
                            '<div class="px-4 py-3 text-sm text-gray-500">No products found</div>';
                    } else {
                        products.forEach(product => {
                            const productElement = document.createElement('div');
                            productElement.className =
                                'px-4 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0';
                            productElement.innerHTML = `
                            <div class="flex justify-between">
                                <div>
                                    <div class="font-medium text-gray-900">${product.name}</div>
                                    <div class="text-sm text-gray-500">${product.sku}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-900">$${product.price}</div>
                                    <div class="text-sm text-gray-500">${product.quantity} in stock</div>
                                </div>
                            </div>
                        `;
                            productElement.addEventListener('click', () => addProductToOrder(product));
                            resultsContainer.appendChild(productElement);
                        });
                    }

                    resultsContainer.classList.remove('hidden');
                });
        });

        function addProductToOrder(product) {
            // Check if product already exists
            const existingItem = orderItems.find(item => item.id === product.id);

            if (existingItem) {
                existingItem.quantity += 1;
                existingItem.total = existingItem.quantity * existingItem.price;
                updateOrderItem(existingItem);
            } else {
                const newItem = {
                    id: product.id,
                    name: product.name,
                    sku: product.sku,
                    price: parseFloat(product.price),
                    quantity: 1,
                    total: parseFloat(product.price)
                };
                orderItems.push(newItem);
                renderOrderItem(newItem);
            }

            updateOrderSummary();
            document.getElementById('productSearch').value = '';
            document.getElementById('productResults').classList.add('hidden');
            document.getElementById('noItems').classList.add('hidden');
        }

        function renderOrderItem(item) {
            const tbody = document.getElementById('orderItems');
            const tr = document.createElement('tr');
            tr.id = `item-${item.id}`;
            tr.className = 'order-item';
            tr.innerHTML = `
            <td class="px-4 py-3">
                <div>
                    <div class="text-sm font-medium text-gray-900">${item.name}</div>
                    <div class="text-xs text-gray-500">SKU: ${item.sku}</div>
                    <input type="hidden" name="items[${item.id}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${item.id}][product_name]" value="${item.name}">
                    <input type="hidden" name="items[${item.id}][product_sku]" value="${item.sku}">
                </div>
            </td>
            <td class="px-4 py-3">
                <input type="number" 
                       name="items[${item.id}][unit_price]" 
                       value="${item.price.toFixed(2)}"
                       step="0.01"
                       min="0"
                       class="w-24 px-2 py-1 border border-gray-300 rounded text-sm"
                       onchange="updateItemPrice(${item.id}, this.value)">
            </td>
            <td class="px-4 py-3">
                <div class="flex items-center space-x-2">
                    <button type="button" 
                            onclick="updateItemQuantity(${item.id}, ${item.quantity - 1})"
                            class="p-1 text-gray-400 hover:text-gray-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    </button>
                    <input type="number" 
                           name="items[${item.id}][quantity]" 
                           value="${item.quantity}"
                           min="1"
                           class="w-16 px-2 py-1 border border-gray-300 rounded text-sm text-center"
                           onchange="updateItemQuantity(${item.id}, parseInt(this.value))">
                    <button type="button" 
                            onclick="updateItemQuantity(${item.id}, ${item.quantity + 1})"
                            class="p-1 text-gray-400 hover:text-gray-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </button>
                </div>
            </td>
            <td class="px-4 py-3">
                <div class="text-sm font-medium text-gray-900">$${item.total.toFixed(2)}</div>
                <input type="hidden" name="items[${item.id}][total_price]" value="${item.total}">
            </td>
            <td class="px-4 py-3">
                <button type="button" 
                        onclick="removeOrderItem(${item.id})"
                        class="p-1 text-red-400 hover:text-red-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </td>
        `;
            tbody.appendChild(tr);
        }

        function updateOrderItem(item) {
            const tr = document.getElementById(`item-${item.id}`);
            if (tr) {
                tr.querySelector(`input[name="items[${item.id}][quantity]"]`).value = item.quantity;
                tr.querySelector(`input[name="items[${item.id}][total_price]"]`).value = item.total;
                tr.querySelector('td:nth-child(4) div').textContent = `$${item.total.toFixed(2)}`;
            }
        }

        function updateItemPrice(itemId, price) {
            const item = orderItems.find(i => i.id === itemId);
            if (item) {
                item.price = parseFloat(price);
                item.total = item.quantity * item.price;
                updateOrderItem(item);
                updateOrderSummary();
            }
        }

        function updateItemQuantity(itemId, quantity) {
            if (quantity < 1) return;

            const item = orderItems.find(i => i.id === itemId);
            if (item) {
                item.quantity = quantity;
                item.total = item.quantity * item.price;
                updateOrderItem(item);
                updateOrderSummary();
            }
        }

        function removeOrderItem(itemId) {
            orderItems = orderItems.filter(item => item.id !== itemId);
            const tr = document.getElementById(`item-${itemId}`);
            if (tr) tr.remove();

            if (orderItems.length === 0) {
                document.getElementById('noItems').classList.remove('hidden');
            }

            updateOrderSummary();
        }

        function updateOrderSummary() {
            // Calculate subtotal
            subtotal = orderItems.reduce((sum, item) => sum + item.total, 0);

            // Calculate tax
            const tax = subtotal * taxRate;

            // Calculate total
            const total = subtotal - discount + shipping + tax;

            // Update UI
            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('discountAmount').textContent = `-$${discount.toFixed(2)}`;
            document.getElementById('shippingCost').textContent = `$${shipping.toFixed(2)}`;
            document.getElementById('taxAmount').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('totalAmount').textContent = `$${total.toFixed(2)}`;

            // Update hidden inputs
            document.querySelector('input[name="subtotal"]')?.value = subtotal.toFixed(2);
            document.querySelector('input[name="tax_amount"]')?.value = tax.toFixed(2);
            document.querySelector('input[name="total_amount"]')?.value = total.toFixed(2);
        }

        function toggleDiscountInput() {
            document.getElementById('discountInput').classList.toggle('hidden');
        }

        function applyDiscount() {
            const discountInput = document.getElementById('discount');
            discount = parseFloat(discountInput.value) || 0;

            if (discount > subtotal) {
                discount = subtotal;
                discountInput.value = discount.toFixed(2);
            }

            updateOrderSummary();
            document.getElementById('discountInput').classList.add('hidden');
        }

        function toggleShippingInput() {
            document.getElementById('shippingInput').classList.toggle('hidden');
        }

        function applyShipping() {
            const shippingInput = document.getElementById('shipping_cost');
            shipping = parseFloat(shippingInput.value) || 0;

            updateOrderSummary();
            document.getElementById('shippingInput').classList.add('hidden');
        }

        // Initialize order summary
        updateOrderSummary();
    </script>
@endpush
