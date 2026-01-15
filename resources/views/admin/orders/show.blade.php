@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order: ' . $order->order_number)

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
        <span class="text-gray-700">Details</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <!-- Order Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h1>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $order->status_badge_color }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $order->payment_status_badge_color }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <p class="text-gray-600 mt-2">
                        Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.orders.edit', $order) }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                        Edit Order
                    </a>
                    <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                        Print Invoice
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white rounded-xl hover:shadow-md transition-all">
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <div class="px-6 py-4">
                                <div class="flex items-start">
                                    @if ($item->product_image)
                                        <img src="{{ Storage::url($item->product_image) }}"
                                            alt="{{ $item->product_name }}"
                                            class="h-16 w-16 object-cover rounded-lg border border-gray-200">
                                    @else
                                        <div
                                            class="h-16 w-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-900">{{ $item->product_name }}
                                                </h3>
                                                <p class="text-sm text-gray-500 mt-1">SKU: {{ $item->product_sku }}</p>
                                                @if ($item->attributes)
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        @foreach (json_decode($item->attributes, true) as $key => $value)
                                                            {{ ucfirst($key) }}: {{ $value }}@if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">
                                                    ${{ number_format($item->unit_price, 2) }}</p>
                                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-2 flex justify-between text-sm">
                                            <span class="text-gray-500">Subtotal:</span>
                                            <span
                                                class="font-medium text-gray-900">${{ number_format($item->total_price, 2) }}</span>
                                        </div>
                                        @if ($item->discount_amount > 0)
                                            <div class="mt-1 flex justify-between text-sm">
                                                <span class="text-gray-500">Discount:</span>
                                                <span
                                                    class="text-red-600">-${{ number_format($item->discount_amount, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Order Notes</h2>
                    </div>
                    <div class="p-6">
                        <!-- Customer Note -->
                        @if ($order->customer_note)
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Customer Note</h3>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                                    <p class="text-sm text-gray-700">{{ $order->customer_note }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Admin Notes -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Admin Notes</h3>
                            @if ($order->admin_note)
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                                    <p class="text-sm text-gray-700">{{ $order->admin_note }}</p>
                                </div>
                            @endif

                            <!-- Add Admin Note Form -->
                            <form action="{{ route('admin.orders.add.note', $order) }}" method="POST">
                                @csrf
                                <div class="space-y-3">
                                    <textarea name="admin_note" rows="3"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                                        placeholder="Add a note about this order..."></textarea>
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all">
                                            Add Note
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                            </div>

                            @if ($order->discount_amount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Discount</span>
                                    <span class="text-red-600">-${{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span
                                    class="font-medium text-gray-900">${{ number_format($order->shipping_cost, 2) }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium text-gray-900">${{ number_format($order->tax_amount, 2) }}</span>
                            </div>

                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between text-base font-semibold">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Customer Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">Customer</h3>
                                <p class="text-sm text-gray-900">{{ $order->customer_name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->customer_email }}</p>
                                @if ($order->customer_phone)
                                    <p class="text-sm text-gray-600">{{ $order->customer_phone }}</p>
                                @endif
                                @if ($order->user)
                                    <a href="{{ route('admin.users.show', $order->user) }}"
                                        class="text-sm text-primary hover:underline mt-1 inline-block">
                                        View Customer Profile
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Shipping Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">Shipping Address</h3>
                                <p class="text-sm text-gray-900">{{ $order->shipping_name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->shipping_address_line1 }}</p>
                                @if ($order->shipping_address_line2)
                                    <p class="text-sm text-gray-600">{{ $order->shipping_address_line2 }}</p>
                                @endif
                                <p class="text-sm text-gray-600">
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }}
                                    {{ $order->shipping_zip_code }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $order->shipping_country }}</p>
                                <p class="text-sm text-gray-600">{{ $order->shipping_phone }}</p>
                                <p class="text-sm text-gray-600">{{ $order->shipping_email }}</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">Shipping Method</h3>
                                <p class="text-sm text-gray-900">{{ ucfirst($order->shipping_method) }}</p>
                                @if ($order->tracking_number)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-700">Tracking Number: {{ $order->tracking_number }}
                                        </p>
                                        <p class="text-xs text-gray-500">Carrier: {{ $order->carrier ?? 'N/A' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Payment Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">Payment Method</h3>
                                <p class="text-sm text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                                @if ($order->payment_gateway)
                                    <p class="text-xs text-gray-500">Gateway: {{ $order->payment_gateway }}</p>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">Transaction</h3>
                                @if ($order->transaction_id)
                                    <p class="text-sm text-gray-900">{{ $order->transaction_id }}</p>
                                @else
                                    <p class="text-sm text-gray-500">No transaction ID</p>
                                @endif
                                @if ($order->paid_at)
                                    <p class="text-xs text-gray-500">Paid on {{ $order->paid_at->format('M d, Y h:i A') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Order Actions</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Status Update -->
                            <div x-data="{ showStatusForm: false }">
                                <button @click="showStatusForm = !showStatusForm"
                                    class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors text-sm font-medium">
                                    Update Status
                                </button>

                                <div x-show="showStatusForm" @click.away="showStatusForm = false"
                                    class="mt-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <form action="{{ route('admin.orders.update.status', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="space-y-3">
                                            <select name="status"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm">
                                                <option value="pending"
                                                    {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing"
                                                    {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                                </option>
                                                <option value="on_hold"
                                                    {{ $order->status == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                                <option value="completed"
                                                    {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                                                </option>
                                                <option value="cancelled"
                                                    {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                </option>
                                                <option value="refunded"
                                                    {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                            </select>
                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="showStatusForm = false"
                                                    class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-sm bg-primary text-white rounded-lg hover:bg-primary/90">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Payment Status Update -->
                            <div x-data="{ showPaymentForm: false }">
                                <button @click="showPaymentForm = !showPaymentForm"
                                    class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors text-sm font-medium">
                                    Update Payment Status
                                </button>

                                <div x-show="showPaymentForm" @click.away="showPaymentForm = false"
                                    class="mt-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <form action="{{ route('admin.orders.update.payment', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="space-y-3">
                                            <select name="payment_status"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm">
                                                <option value="pending"
                                                    {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="paid"
                                                    {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="failed"
                                                    {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed
                                                </option>
                                                <option value="refunded"
                                                    {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded
                                                </option>
                                                <option value="partially_refunded"
                                                    {{ $order->payment_status == 'partially_refunded' ? 'selected' : '' }}>
                                                    Partially Refunded</option>
                                            </select>
                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="showPaymentForm = false"
                                                    class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-sm bg-primary text-white rounded-lg hover:bg-primary/90">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Shipping Update -->
                            @if ($order->status == 'processing' || $order->status == 'shipped')
                                <div x-data="{ showShippingForm: false }">
                                    <button @click="showShippingForm = !showShippingForm"
                                        class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors text-sm font-medium">
                                        {{ $order->tracking_number ? 'Update Tracking' : 'Add Tracking' }}
                                    </button>

                                    <div x-show="showShippingForm" @click.away="showShippingForm = false"
                                        class="mt-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <form action="{{ route('admin.orders.ship', $order) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700 mb-1">Tracking
                                                        Number</label>
                                                    <input type="text" name="tracking_number"
                                                        value="{{ $order->tracking_number }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm"
                                                        placeholder="Enter tracking number">
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-xs font-medium text-gray-700 mb-1">Carrier</label>
                                                    <input type="text" name="carrier" value="{{ $order->carrier }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm"
                                                        placeholder="e.g., UPS, FedEx, DHL">
                                                </div>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" @click="showShippingForm = false"
                                                        class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="px-3 py-1.5 text-sm bg-primary text-white rounded-lg hover:bg-primary/90">
                                                        {{ $order->tracking_number ? 'Update' : 'Add' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <!-- Send Invoice -->
                            <form action="{{ route('admin.orders.send.invoice', $order) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors text-sm font-medium">
                                    Resend Invoice
                                </button>
                            </form>

                            <!-- Cancel Order -->
                            @if (!in_array($order->status, ['cancelled', 'refunded', 'completed']))
                                <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to cancel this order?')"
                                        class="w-full px-4 py-2.5 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-colors text-sm font-medium">
                                        Cancel Order
                                    </button>
                                </form>
                            @endif

                            <!-- Refund Order -->
                            @if ($order->payment_status == 'paid' && $order->status != 'refunded')
                                <div x-data="{ showRefundForm: false }">
                                    <button @click="showRefundForm = !showRefundForm"
                                        class="w-full px-4 py-2.5 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition-colors text-sm font-medium">
                                        Refund Order
                                    </button>

                                    <div x-show="showRefundForm" @click.away="showRefundForm = false"
                                        class="mt-3 p-4 bg-red-50 rounded-xl border border-red-200">
                                        <form action="{{ route('admin.orders.refund', $order) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-red-700 mb-1">Refund
                                                        Amount</label>
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-red-600 sm:text-sm">$</span>
                                                        </div>
                                                        <input type="number" name="amount"
                                                            value="{{ $order->total_amount }}" step="0.01"
                                                            min="0" max="{{ $order->total_amount }}"
                                                            class="pl-7 w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-colors text-sm bg-white"
                                                            placeholder="0.00">
                                                    </div>
                                                    <p class="text-xs text-red-600 mt-1">Max:
                                                        ${{ number_format($order->total_amount, 2) }}</p>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-xs font-medium text-red-700 mb-1">Reason</label>
                                                    <textarea name="reason" rows="2"
                                                        class="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-colors text-sm"
                                                        placeholder="Reason for refund"></textarea>
                                                </div>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" @click="showRefundForm = false"
                                                        class="px-3 py-1.5 text-sm text-red-600 hover:text-red-900">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to issue a refund?')"
                                                        class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                        Issue Refund
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle tracking info form
        function toggleTrackingForm() {
            const form = document.getElementById('trackingForm');
            form.classList.toggle('hidden');
        }

        // Copy order number
        function copyOrderNumber() {
            const orderNumber = '{{ $order->order_number }}';
            navigator.clipboard.writeText(orderNumber).then(() => {
                alert('Order number copied to clipboard!');
            });
        }
    </script>
@endpush
