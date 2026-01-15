@extends('admin.layouts.app')

@section('title', 'Payment Settings')
@section('page-title', 'Payment Settings')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.settings.index') }}" class="text-gray-500 hover:text-gray-700">Settings</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Payment</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Payment Settings</h3>
                    <p class="text-sm text-gray-500 mt-1">Configure payment gateways and options</p>
                </div>

                <form method="POST" action="{{ route('admin.settings.update.payment') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- General Settings -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">General Settings</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                    <select name="currency"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="USD" {{ $settings['currency'] == 'USD' ? 'selected' : '' }}>US
                                            Dollar
                                            (USD)</option>
                                        <option value="EUR" {{ $settings['currency'] == 'EUR' ? 'selected' : '' }}>Euro
                                            (EUR)
                                        </option>
                                        <option value="GBP" {{ $settings['currency'] == 'GBP' ? 'selected' : '' }}>
                                            British
                                            Pound (GBP)</option>
                                        <option value="JPY" {{ $settings['currency'] == 'JPY' ? 'selected' : '' }}>
                                            Japanese
                                            Yen (JPY)</option>
                                        <option value="CAD" {{ $settings['currency'] == 'CAD' ? 'selected' : '' }}>
                                            Canadian
                                            Dollar (CAD)</option>
                                        <option value="AUD" {{ $settings['currency'] == 'AUD' ? 'selected' : '' }}>
                                            Australian
                                            Dollar (AUD)</option>
                                    </select>
                                    @error('currency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- PayPal Settings -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-800">PayPal Settings</h4>
                                <label class="flex items-center">
                                    <input type="checkbox" name="paypal_enabled" value="1"
                                        {{ $settings['paypal_enabled'] ? 'checked' : '' }}
                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Enable PayPal</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">PayPal Mode</label>
                                    <select name="paypal_mode"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="sandbox"
                                            {{ $settings['paypal_mode'] == 'sandbox' ? 'selected' : '' }}>
                                            Sandbox (Testing)</option>
                                        <option value="live" {{ $settings['paypal_mode'] == 'live' ? 'selected' : '' }}>
                                            Live
                                            (Production)</option>
                                    </select>
                                    @error('paypal_mode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Client ID</label>
                                    <input type="text" name="paypal_client_id"
                                        value="{{ old('paypal_client_id', $settings['paypal_client_id']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('paypal_client_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Client Secret</label>
                                    <input type="password" name="paypal_client_secret"
                                        value="{{ old('paypal_client_secret', $settings['paypal_client_secret']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('paypal_client_secret')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stripe Settings -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-800">Stripe Settings</h4>
                                <label class="flex items-center">
                                    <input type="checkbox" name="stripe_enabled" value="1"
                                        {{ $settings['stripe_enabled'] ? 'checked' : '' }}
                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Enable Stripe</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Publishable Key</label>
                                    <input type="text" name="stripe_key"
                                        value="{{ old('stripe_key', $settings['stripe_key']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('stripe_key')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Secret Key</label>
                                    <input type="password" name="stripe_secret"
                                        value="{{ old('stripe_secret', $settings['stripe_secret']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('stripe_secret')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Webhook Secret</label>
                                    <input type="password" name="stripe_webhook_secret"
                                        value="{{ old('stripe_webhook_secret', $settings['stripe_webhook_secret']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('stripe_webhook_secret')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">For handling Stripe webhook events</p>
                                </div>
                            </div>
                        </div>

                        <!-- Other Payment Methods -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Other Payment Methods</h4>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-900">Cash on Delivery</h5>
                                        <p class="text-sm text-gray-500">Pay when you receive your order</p>
                                    </div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="cod_enabled" value="1"
                                            {{ $settings['cod_enabled'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Enable</span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-900">Bank Transfer</h5>
                                        <p class="text-sm text-gray-500">Direct bank transfer payment</p>
                                    </div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="bank_transfer_enabled" value="1"
                                            {{ $settings['bank_transfer_enabled'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Enable</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bank Details</label>
                                <textarea name="bank_details" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Bank name, account number, routing number, etc.">{{ old('bank_details', $settings['bank_details']) }}</textarea>
                                @error('bank_details')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Displayed to customers when they select bank transfer
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Save Payment Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
