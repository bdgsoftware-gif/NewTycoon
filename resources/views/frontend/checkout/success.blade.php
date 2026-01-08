@extends('frontend.layouts.app')

@section('title', 'Order Confirmation')
@section('description', 'Thank you for your order')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4 font-quantico">Order Confirmed!</h1>
            <p class="text-lg text-gray-600 mb-6 font-inter">
                Thank you for your purchase. Your order has been received and is being processed.
            </p>

            <!-- Order Details -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 text-left">
                <h2 class="text-xl font-bold text-gray-900 mb-4 font-quantico">Order Details</h2>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-inter">Order Number:</span>
                        <span class="font-semibold text-gray-900 font-quantico">{{ $order->order_number }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 font-inter">Date:</span>
                        <span class="font-semibold text-gray-900 font-quantico">
                            {{ $order->created_at->format('F d, Y h:i A') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 font-inter">Total Amount:</span>
                        <span class="text-lg font-bold text-gray-900 font-quantico">
                            <span class="font-bengali">৳</span>{{ number_format($order->total_amount, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 font-inter">Payment Method:</span>
                        <span class="font-semibold text-gray-900 font-quantico">
                            {{ ucfirst($order->payment_method) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600 font-inter">Status:</span>
                        <span class="font-semibold text-primary font-quantico">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 font-quantico">What's Next?</h3>
                <div class="space-y-3 text-gray-600 font-inter">
                    <p>• You will receive an order confirmation email shortly</p>
                    <p>• We will notify you when your order ships</p>
                    <p>• Estimated delivery: 5-7 business days</p>
                    @if ($order->payment_method == 'cod')
                        <p>• Please keep exact change ready for delivery</p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('orders.track', $order->order_number) }}"
                    class="px-6 py-3 border border-primary text-primary hover:bg-primary-light rounded-lg font-medium font-inter transition-colors duration-200">
                    Track Your Order
                </a>

                <a href="{{ route('products.index') }}"
                    class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors duration-200 font-quantico">
                    Continue Shopping
                </a>
            </div>

            <!-- Contact Support -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-gray-600 font-inter">
                    Need help? <a href="{{ route('contact') }}" class="text-primary hover:underline font-medium">Contact our
                        support team</a>
                </p>
            </div>
        </div>
    </div>
@endsection
