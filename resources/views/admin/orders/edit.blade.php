@extends('admin.layouts.app')

@section('title', 'Edit Order')
@section('page-title', 'Edit Order: ' . $order->order_number)

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
        <span class="text-gray-700">Edit</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" id="orderForm">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Edit Order</h2>
                            <p class="text-sm text-gray-600 mt-1">Update order information</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.orders.show', $order) }}"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                                Update Order
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6 space-y-8">
                    <!-- Customer Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Name *
                                </label>
                                <input type="text" id="customer_name" name="customer_name"
                                    value="{{ old('customer_name', $order->customer_name) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address *
                                </label>
                                <input type="email" id="customer_email" name="customer_email"
                                    value="{{ old('customer_email', $order->customer_email) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number
                                </label>
                                <input type="text" id="customer_phone" name="customer_phone"
                                    value="{{ old('customer_phone', $order->customer_phone) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Shipping Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Name *
                                </label>
                                <input type="text" id="shipping_name" name="shipping_name"
                                    value="{{ old('shipping_name', $order->shipping_name) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address *
                                </label>
                                <input type="email" id="shipping_email" name="shipping_email"
                                    value="{{ old('shipping_email', $order->shipping_email) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number *
                                </label>
                                <input type="text" id="shipping_phone" name="shipping_phone"
                                    value="{{ old('shipping_phone', $order->shipping_phone) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div class="md:col-span-2">
                                <label for="shipping_address_line1" class="block text-sm font-medium text-gray-700 mb-1">
                                    Address Line 1 *
                                </label>
                                <input type="text" id="shipping_address_line1" name="shipping_address_line1"
                                    value="{{ old('shipping_address_line1', $order->shipping_address_line1) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="shipping_address_line2" class="block text-sm font-medium text-gray-700 mb-1">
                                    Address Line 2
                                </label>
                                <input type="text" id="shipping_address_line2" name="shipping_address_line2"
                                    value="{{ old('shipping_address_line2', $order->shipping_address_line2) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">
                                    City *
                                </label>
                                <input type="text" id="shipping_city" name="shipping_city"
                                    value="{{ old('shipping_city', $order->shipping_city) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">
                                    State/Province *
                                </label>
                                <input type="text" id="shipping_state" name="shipping_state"
                                    value="{{ old('shipping_state', $order->shipping_state) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">
                                    Country *
                                </label>
                                <input type="text" id="shipping_country" name="shipping_country"
                                    value="{{ old('shipping_country', $order->shipping_country) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>

                            <div>
                                <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    ZIP/Postal Code *
                                </label>
                                <input type="text" id="shipping_zip_code" name="shipping_zip_code"
                                    value="{{ old('shipping_zip_code', $order->shipping_zip_code) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Billing Information</h3>

                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="billing_same_as_shipping" name="billing_same_as_shipping"
                                value="1"
                                {{ old('billing_same_as_shipping', $order->billing_same_as_shipping) ? 'checked' : '' }}
                                class="h-4 w-4 text-primary rounded border-gray-300 focus:ring-primary">
                            <label for="billing_same_as_shipping" class="ml-2 text-sm text-gray-700">
                                Billing address same as shipping
                            </label>
                        </div>

                        <div id="billingDetails" class="{{ $order->billing_same_as_shipping ? 'hidden' : '' }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name
                                    </label>
                                    <input type="text" id="billing_name" name="billing_name"
                                        value="{{ old('billing_name', $order->billing_name) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div>
                                    <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address
                                    </label>
                                    <input type="email" id="billing_email" name="billing_email"
                                        value="{{ old('billing_email', $order->billing_email) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div>
                                    <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Phone Number
                                    </label>
                                    <input type="text" id="billing_phone" name="billing_phone"
                                        value="{{ old('billing_phone', $order->billing_phone) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="billing_address_line1"
                                        class="block text-sm font-medium text-gray-700 mb-1">
                                        Address Line 1
                                    </label>
                                    <input type="text" id="billing_address_line1" name="billing_address_line1"
                                        value="{{ old('billing_address_line1', $order->billing_address_line1) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div>
                                    <label for="billing_address_line2"
                                        class="block text-sm font-medium text-gray-700 mb-1">
                                        Address Line 2
                                    </label>
                                    <input type="text" id="billing_address_line2" name="billing_address_line2"
                                        value="{{ old('billing_address_line2', $order->billing_address_line2) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div>
                                    <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">
                                        City
                                    </label>
                                    <input type="text" id="billing_city" name="billing_city"
                                        value="{{ old('billing_city', $order->billing_city) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div>
                                    <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">
                                        State/Province
                                    </label>
                                    <input type="text" id="billing_state" name="billing_state"
                                        value="{{ old('billing_state', $order->billing_state) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div>
                                    <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">
                                        Country
                                    </label>
                                    <input type="text" id="billing_country" name="billing_country"
                                        value="{{ old('billing_country', $order->billing_country) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>

                                <div>
                                    <label for="billing_zip_code" class="block text-sm font-medium text-gray-700 mb-1">
                                        ZIP/Postal Code
                                    </label>
                                    <input type="text" id="billing_zip_code" name="billing_zip_code"
                                        value="{{ old('billing_zip_code', $order->billing_zip_code) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Order Items</h3>

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
                                    @foreach ($order->items as $item)
                                        <tr id="item-{{ $item->id }}">
                                            <td class="px-4 py-3">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->product_name }}</div>
                                                    <div class="text-xs text-gray-500">SKU: {{ $item->product_sku }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="items[{{ $item->id }}][unit_price]"
                                                    value="{{ old('unit_price', $item->unit_price) }}" step="0.01"
                                                    min="0"
                                                    class="w-24 px-2 py-1 border border-gray-300 rounded text-sm"
                                                    onchange="updateItemTotal({{ $item->id }})">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="items[{{ $item->id }}][quantity]"
                                                    value="{{ old('quantity', $item->quantity) }}" min="1"
                                                    class="w-16 px-2 py-1 border border-gray-300 rounded text-sm"
                                                    onchange="updateItemTotal({{ $item->id }})">
                                            </td>
                                            <td class="px-4 py-3">
                                                <span id="item-total-{{ $item->id }}"
                                                    class="text-sm font-medium text-gray-900">
                                                    ${{ number_format($item->total_price, 2) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <button type="button" onclick="removeItem({{ $item->id }})"
                                                    class="p-1 text-red-400 hover:text-red-600">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Add Product -->
                        <div>
                            <button type="button" onclick="showAddProductModal()"
                                class="px-4 py-2 border border-dashed border-gray-300 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="h-4 w-4 inline mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Product
                            </button>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="shipping_method" class="block text-sm font-medium text-gray-700 mb-1">
                                        Shipping Method
                                    </label>
                                    <select id="shipping_method" name="shipping_method"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                        <option value="standard"
                                            {{ $order->shipping_method == 'standard' ? 'selected' : '' }}>Standard Shipping
                                        </option>
                                        <option value="express"
                                            {{ $order->shipping_method == 'express' ? 'selected' : '' }}>Express Shipping
                                        </option>
                                        <option value="overnight"
                                            {{ $order->shipping_method == 'overnight' ? 'selected' : '' }}>Overnight
                                            Shipping</option>
                                        <option value="pickup"
                                            {{ $order->shipping_method == 'pickup' ? 'selected' : '' }}>Store Pickup
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">
                                        Payment Method
                                    </label>
                                    <select id="payment_method" name="payment_method"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                        <option value="credit_card"
                                            {{ $order->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card
                                        </option>
                                        <option value="paypal" {{ $order->payment_method == 'paypal' ? 'selected' : '' }}>
                                            PayPal</option>
                                        <option value="bank_transfer"
                                            {{ $order->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                        </option>
                                        <option value="cash_on_delivery"
                                            {{ $order->payment_method == 'cash_on_delivery' ? 'selected' : '' }}>Cash on
                                            Delivery</option>
                                        <option value="other" {{ $order->payment_method == 'other' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="shipping_cost" class="block text-sm font-medium text-gray-700 mb-1">
                                        Shipping Cost
                                    </label>
                                    <input type="number" id="shipping_cost" name="shipping_cost"
                                        value="{{ old('shipping_cost', $order->shipping_cost) }}" step="0.01"
                                        min="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        onchange="updateOrderTotal()">
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span id="subtotal" class="font-medium text-gray-900">
                                        ${{ number_format($order->subtotal, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Discount</span>
                                    <div class="flex items-center">
                                        <input type="number" id="discount_amount" name="discount_amount"
                                            value="{{ old('discount_amount', $order->discount_amount) }}" step="0.01"
                                            min="0"
                                            class="w-20 px-2 py-1 border border-gray-300 rounded text-sm text-right"
                                            onchange="updateOrderTotal()">
                                        <span class="ml-2 text-gray-900">$</span>
                                    </div>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span id="shippingDisplay" class="font-medium text-gray-900">
                                        ${{ number_format($order->shipping_cost, 2) }}
                                    </span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax</span>
                                    <div class="flex items-center">
                                        <input type="number" id="tax_amount" name="tax_amount"
                                            value="{{ old('tax_amount', $order->tax_amount) }}" step="0.01"
                                            min="0"
                                            class="w-20 px-2 py-1 border border-gray-300 rounded text-sm text-right"
                                            onchange="updateOrderTotal()">
                                        <span class="ml-2 text-gray-900">$</span>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between text-base font-semibold">
                                        <span class="text-gray-900">Total</span>
                                        <span id="totalAmount" class="text-gray-900">
                                            ${{ number_format($order->total_amount, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Order Notes</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="customer_note" class="block text-sm font-medium text-gray-700 mb-1">
                                    Customer Note (Visible to Customer)
                                </label>
                                <textarea id="customer_note" name="customer_note" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">{{ old('customer_note', $order->customer_note) }}</textarea>
                            </div>

                            <div>
                                <label for="admin_note" class="block text-sm font-medium text-gray-700 mb-1">
                                    Admin Note (Private)
                                </label>
                                <textarea id="admin_note" name="admin_note" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">{{ old('admin_note', $order->admin_note) }}</textarea>
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
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="on_hold" {{ $order->status == 'on_hold' ? 'selected' : '' }}>On Hold
                                    </option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Payment Status
                                </label>
                                <select id="payment_status" name="payment_status"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>
                                        Failed</option>
                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>
                                        Refunded</option>
                                    <option value="partially_refunded"
                                        {{ $order->payment_status == 'partially_refunded' ? 'selected' : '' }}>Partially
                                        Refunded</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.orders.show', $order) }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="showDeleteModal()"
                                class="px-4 py-2 bg-red-50 border border-red-200 text-red-700 rounded-xl hover:bg-red-100 transition-colors">
                                Delete Order
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden z-50">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">
                                Add Product to Order
                            </h3>
                            <div class="mt-2">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Search Products
                                        </label>
                                        <div class="relative">
                                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            <input type="text" id="modalProductSearch"
                                                placeholder="Search products..."
                                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                        </div>
                                        <div id="modalProductResults" class="mt-2 max-h-60 overflow-y-auto hidden"></div>
                                    </div>

                                    <div id="selectedProductDetails" class="hidden">
                                        <div class="border border-gray-200 rounded-xl p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 id="selectedProductName" class="font-medium text-gray-900"></h4>
                                                    <p id="selectedProductSku" class="text-sm text-gray-500"></p>
                                                    <p id="selectedProductPrice" class="text-sm text-gray-700 mt-1"></p>
                                                </div>
                                                <div class="space-y-2">
                                                    <div>
                                                        <label
                                                            class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                                                        <input type="number" id="productQuantity" min="1"
                                                            value="1"
                                                            class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-xs font-medium text-gray-700 mb-1">Price</label>
                                                        <input type="number" id="productPrice" step="0.01"
                                                            min="0"
                                                            class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="addSelectedProduct()" id="addProductButton" disabled
                            class="inline-flex w-full justify-center rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed sm:ml-3 sm:w-auto">
                            Add Product
                        </button>
                        <button type="button" onclick="closeAddProductModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity hidden z-50">
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">
                                Delete Order
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete order "{{ $order->order_number }}"?
                                    This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                Delete
                            </button>
                        </form>
                        <button type="button" onclick="closeDeleteModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Billing same as shipping toggle
        document.getElementById('billing_same_as_shipping').addEventListener('change', function() {
            const billingDetails = document.getElementById('billingDetails');
            if (this.checked) {
                billingDetails.classList.add('hidden');
            } else {
                billingDetails.classList.remove('hidden');
            }
        });

        // Update item total
        function updateItemTotal(itemId) {
            const priceInput = document.querySelector(`input[name="items[${itemId}][unit_price]"]`);
            const quantityInput = document.querySelector(`input[name="items[${itemId}][quantity]"]`);
            const totalSpan = document.getElementById(`item-total-${itemId}`);

            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const total = price * quantity;

            totalSpan.textContent = `$${total.toFixed(2)}`;
            updateOrderTotal();
        }

        // Remove item
        function removeItem(itemId) {
            const row = document.getElementById(`item-${itemId}`);
            if (row) {
                row.remove();
            }
            updateOrderTotal();
        }

        // Update order total
        function updateOrderTotal() {
            let subtotal = 0;

            // Calculate subtotal from all items
            document.querySelectorAll('[id^="item-total-"]').forEach(element => {
                const totalText = element.textContent.replace('$', '');
                subtotal += parseFloat(totalText) || 0;
            });

            // Get other values
            const shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;
            const discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
            const taxAmount = parseFloat(document.getElementById('tax_amount').value) || 0;

            // Calculate total
            const total = subtotal + shippingCost + taxAmount - discountAmount;

            // Update display
            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('shippingDisplay').textContent = `$${shippingCost.toFixed(2)}`;
            document.getElementById('totalAmount').textContent = `$${total.toFixed(2)}`;
        }

        // Show add product modal
        function showAddProductModal() {
            document.getElementById('addProductModal').classList.remove('hidden');
            document.getElementById('modalProductSearch').focus();
        }

        // Close add product modal
        function closeAddProductModal() {
            document.getElementById('addProductModal').classList.add('hidden');
            document.getElementById('selectedProductDetails').classList.add('hidden');
            document.getElementById('modalProductResults').classList.add('hidden');
            document.getElementById('addProductButton').disabled = true;
            document.getElementById('modalProductSearch').value = '';
        }

        // Add selected product to order
        function addSelectedProduct() {
            const productName = document.getElementById('selectedProductName').textContent;
            const productSku = document.getElementById('selectedProductSku').textContent;
            const quantity = parseInt(document.getElementById('productQuantity').value) || 1;
            const price = parseFloat(document.getElementById('productPrice').value) || 0;

            // Generate a temporary ID for the new item
            const tempId = Date.now();

            // Create new table row
            const newRow = `
            <tr id="item-${tempId}">
                <td class="px-4 py-3">
                    <div>
                        <div class="text-sm font-medium text-gray-900">${productName}</div>
                        <div class="text-xs text-gray-500">SKU: ${productSku}</div>
                        <input type="hidden" name="new_items[${tempId}][product_name]" value="${productName}">
                        <input type="hidden" name="new_items[${tempId}][product_sku]" value="${productSku}">
                    </div>
                </td>
                <td class="px-4 py-3">
                    <input type="number" 
                           name="new_items[${tempId}][unit_price]" 
                           value="${price.toFixed(2)}"
                           step="0.01"
                           min="0"
                           class="w-24 px-2 py-1 border border-gray-300 rounded text-sm"
                           onchange="updateItemTotal(${tempId})">
                </td>
                <td class="px-4 py-3">
                    <input type="number" 
                           name="new_items[${tempId}][quantity]" 
                           value="${quantity}"
                           min="1"
                           class="w-16 px-2 py-1 border border-gray-300 rounded text-sm"
                           onchange="updateItemTotal(${tempId})">
                </td>
                <td class="px-4 py-3">
                    <span id="item-total-${tempId}" class="text-sm font-medium text-gray-900">
                        $${(price * quantity).toFixed(2)}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <button type="button" 
                            onclick="removeItem(${tempId})"
                            class="p-1 text-red-400 hover:text-red-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            </tr>
        `;

            // Add to table
            document.getElementById('orderItems').insertAdjacentHTML('beforeend', newRow);

            // Close modal and update total
            closeAddProductModal();
            updateOrderTotal();
        }

        // Show delete modal
        function showDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        // Close delete modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Search products for modal (simplified version - you'll need to implement actual search)
        document.getElementById('modalProductSearch').addEventListener('input', function() {
            const searchTerm = this.value.trim();

            if (searchTerm.length < 2) {
                document.getElementById('modalProductResults').classList.add('hidden');
                return;
            }

            // In a real implementation, you would fetch products from an API
            // For now, we'll simulate a response
            simulateProductSearch(searchTerm);
        });

        // Simulate product search (replace with actual API call)
        function simulateProductSearch(searchTerm) {
            // This is a mock function - replace with actual API call
            const mockProducts = [{
                    id: 1,
                    name: 'Wireless Headphones',
                    sku: 'WH-001',
                    price: 99.99
                },
                {
                    id: 2,
                    name: 'Smart Watch',
                    sku: 'SW-002',
                    price: 199.99
                },
                {
                    id: 3,
                    name: 'Bluetooth Speaker',
                    sku: 'BS-003',
                    price: 49.99
                },
                {
                    id: 4,
                    name: 'USB-C Cable',
                    sku: 'UC-004',
                    price: 19.99
                },
                {
                    id: 5,
                    name: 'Power Bank',
                    sku: 'PB-005',
                    price: 39.99
                }
            ];

            const results = mockProducts.filter(product =>
                product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.sku.toLowerCase().includes(searchTerm.toLowerCase())
            );

            displayProductResults(results);
        }

        // Display product search results
        function displayProductResults(products) {
            const resultsDiv = document.getElementById('modalProductResults');

            if (products.length === 0) {
                resultsDiv.innerHTML = '<div class="text-center py-4 text-gray-500">No products found</div>';
                resultsDiv.classList.remove('hidden');
                return;
            }

            let html = '<div class="space-y-2">';
            products.forEach(product => {
                html += `
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg cursor-pointer border border-gray-200"
                     onclick="selectProduct(${product.id}, '${product.name}', '${product.sku}', ${product.price})">
                    <div>
                        <div class="font-medium text-gray-900">${product.name}</div>
                        <div class="text-sm text-gray-500">SKU: ${product.sku}</div>
                    </div>
                    <div class="text-sm font-medium text-gray-900">$${product.price.toFixed(2)}</div>
                </div>
            `;
            });
            html += '</div>';

            resultsDiv.innerHTML = html;
            resultsDiv.classList.remove('hidden');
        }

        // Select product from search results
        function selectProduct(id, name, sku, price) {
            document.getElementById('selectedProductName').textContent = name;
            document.getElementById('selectedProductSku').textContent = sku;
            document.getElementById('selectedProductPrice').textContent = `$${price.toFixed(2)}`;
            document.getElementById('productPrice').value = price;

            document.getElementById('selectedProductDetails').classList.remove('hidden');
            document.getElementById('modalProductResults').classList.add('hidden');
            document.getElementById('addProductButton').disabled = false;
            document.getElementById('productQuantity').focus();
        }

        // Initialize event listeners for existing items
        document.addEventListener('DOMContentLoaded', function() {
            // Add onchange listeners to existing item inputs
            document.querySelectorAll('[id^="item-"]').forEach(row => {
                const itemId = row.id.split('-')[1];
                const priceInput = row.querySelector('input[name^="items"][name$="[unit_price]"]');
                const quantityInput = row.querySelector('input[name^="items"][name$="[quantity]"]');

                if (priceInput && quantityInput) {
                    priceInput.addEventListener('change', () => updateItemTotal(itemId));
                    quantityInput.addEventListener('change', () => updateItemTotal(itemId));
                }
            });

            // Add onchange listeners to summary inputs
            document.getElementById('shipping_cost').addEventListener('change', updateOrderTotal);
            document.getElementById('discount_amount').addEventListener('change', updateOrderTotal);
            document.getElementById('tax_amount').addEventListener('change', updateOrderTotal);

            // Add escape key listener for modals
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAddProductModal();
                    closeDeleteModal();
                }
            });

            // Close modals when clicking outside
            document.getElementById('addProductModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeAddProductModal();
                }
            });

            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });
        });
    </script>
@endpush
