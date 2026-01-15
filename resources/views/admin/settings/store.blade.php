@extends('admin.layouts.app')

@section('title', 'Store Settings')
@section('page-title', 'Store Settings')

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
        <span class="text-gray-700">Store</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Store Settings</h3>
                    <p class="text-sm text-gray-500 mt-1">Configure your store preferences and policies</p>
                </div>

                <form method="POST" action="{{ route('admin.settings.update.store') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Store Status -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Store Status</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Status</label>
                                    <select name="store_status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="open" {{ $settings['store_status'] == 'open' ? 'selected' : '' }}>
                                            Open
                                            for Business</option>
                                        <option value="closed"
                                            {{ $settings['store_status'] == 'closed' ? 'selected' : '' }}>
                                            Closed Temporarily</option>
                                    </select>
                                    @error('store_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="maintenance_mode" value="1"
                                            {{ $settings['maintenance_mode'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Enable Maintenance Mode</span>
                                    </label>
                                    <p class="mt-1 text-xs text-gray-500">Only administrators can access the store</p>
                                    @error('maintenance_mode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Registration & Checkout -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Registration & Checkout</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="allow_registration" value="1"
                                            {{ $settings['allow_registration'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Allow User Registration</span>
                                    </label>
                                    @error('allow_registration')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="require_email_verification" value="1"
                                            {{ $settings['require_email_verification'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Require Email Verification</span>
                                    </label>
                                    @error('require_email_verification')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="allow_guest_checkout" value="1"
                                            {{ $settings['allow_guest_checkout'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Allow Guest Checkout</span>
                                    </label>
                                    @error('allow_guest_checkout')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Amount</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span
                                                class="text-gray-500 sm:text-sm">{{ $settings['currency_symbol'] }}</span>
                                        </div>
                                        <input type="number" name="minimum_order_amount"
                                            value="{{ old('minimum_order_amount', $settings['minimum_order_amount']) }}"
                                            step="0.01" min="0"
                                            class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    @error('minimum_order_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Set to 0 for no minimum</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tax Settings -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Tax Settings</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tax_enabled" value="1"
                                            {{ $settings['tax_enabled'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Enable Tax Calculation</span>
                                    </label>
                                    @error('tax_enabled')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tax_inclusive" value="1"
                                            {{ $settings['tax_inclusive'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Prices Include Tax</span>
                                    </label>
                                    @error('tax_inclusive')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tax Rate (%)</label>
                                    <div class="relative">
                                        <input type="number" name="tax_rate"
                                            value="{{ old('tax_rate', $settings['tax_rate']) }}" step="0.01"
                                            min="0" max="100"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                    @error('tax_rate')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Currency Settings -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Currency Settings</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency Symbol</label>
                                    <input type="text" name="currency_symbol"
                                        value="{{ old('currency_symbol', $settings['currency_symbol']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('currency_symbol')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency Position</label>
                                    <select name="currency_position"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="left"
                                            {{ $settings['currency_position'] == 'left' ? 'selected' : '' }}>Left ($100)
                                        </option>
                                        <option value="right"
                                            {{ $settings['currency_position'] == 'right' ? 'selected' : '' }}>Right (100$)
                                        </option>
                                        <option value="left_space"
                                            {{ $settings['currency_position'] == 'left_space' ? 'selected' : '' }}>Left
                                            with
                                            space ($ 100)</option>
                                        <option value="right_space"
                                            {{ $settings['currency_position'] == 'right_space' ? 'selected' : '' }}>Right
                                            with
                                            space (100 $)</option>
                                    </select>
                                    @error('currency_position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Decimal Places</label>
                                    <select name="decimal_places"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="0" {{ $settings['decimal_places'] == 0 ? 'selected' : '' }}>0
                                            (100)</option>
                                        <option value="1" {{ $settings['decimal_places'] == 1 ? 'selected' : '' }}>1
                                            (100.0)</option>
                                        <option value="2" {{ $settings['decimal_places'] == 2 ? 'selected' : '' }}>2
                                            (100.00)</option>
                                        <option value="3" {{ $settings['decimal_places'] == 3 ? 'selected' : '' }}>3
                                            (100.000)</option>
                                        <option value="4" {{ $settings['decimal_places'] == 4 ? 'selected' : '' }}>4
                                            (100.0000)</option>
                                    </select>
                                    @error('decimal_places')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Save Store Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
