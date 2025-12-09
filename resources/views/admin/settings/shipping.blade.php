@extends('admin.layouts.app')

@section('title', 'Shipping Settings')
@section('page-title', 'Shipping Settings')

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
        <span class="text-gray-700">Shipping</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Shipping Settings</h3>
                    <p class="text-sm text-gray-500 mt-1">Configure shipping methods and rates</p>
                </div>

                <form method="POST" action="{{ route('admin.settings.update.shipping') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- General Settings -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">General Settings</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="shipping_enabled" value="1"
                                            {{ $settings['shipping_enabled'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Enable Shipping</span>
                                    </label>
                                    @error('shipping_enabled')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Free Shipping
                                        Threshold</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span
                                                class="text-gray-500 sm:text-sm">{{ config('settings.currency_symbol', '$') }}</span>
                                        </div>
                                        <input type="number" name="free_shipping_threshold"
                                            value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold']) }}"
                                            step="0.01" min="0"
                                            class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    @error('free_shipping_threshold')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Set to 0 for no free shipping</p>
                                </div>
                            </div>
                        </div>

                        <!-- Measurement Units -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Measurement Units</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Weight Unit</label>
                                    <select name="weight_unit"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="kg" {{ $settings['weight_unit'] == 'kg' ? 'selected' : '' }}>
                                            Kilograms (kg)</option>
                                        <option value="lb" {{ $settings['weight_unit'] == 'lb' ? 'selected' : '' }}>
                                            Pounds
                                            (lb)</option>
                                        <option value="g" {{ $settings['weight_unit'] == 'g' ? 'selected' : '' }}>Grams
                                            (g)</option>
                                        <option value="oz" {{ $settings['weight_unit'] == 'oz' ? 'selected' : '' }}>
                                            Ounces
                                            (oz)</option>
                                    </select>
                                    @error('weight_unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dimension Unit</label>
                                    <select name="dimension_unit"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="cm" {{ $settings['dimension_unit'] == 'cm' ? 'selected' : '' }}>
                                            Centimeters (cm)</option>
                                        <option value="in" {{ $settings['dimension_unit'] == 'in' ? 'selected' : '' }}>
                                            Inches (in)</option>
                                        <option value="m" {{ $settings['dimension_unit'] == 'm' ? 'selected' : '' }}>
                                            Meters (m)</option>
                                        <option value="ft" {{ $settings['dimension_unit'] == 'ft' ? 'selected' : '' }}>
                                            Feet
                                            (ft)</option>
                                    </select>
                                    @error('dimension_unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Methods -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Shipping Methods</h4>

                            <div class="space-y-6">
                                <!-- Standard Shipping -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="p-2 bg-blue-100 rounded-lg">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h5 class="text-sm font-medium text-gray-900">Standard Shipping</h5>
                                            <p class="text-sm text-gray-500">3-5 business days</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="shipping_methods[]" value="standard"
                                                {{ in_array('standard', $settings['shipping_methods']) ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                                        </label>
                                        <div class="w-32">
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span
                                                        class="text-gray-500 sm:text-sm">{{ config('settings.currency_symbol', '$') }}</span>
                                                </div>
                                                <input type="number" name="standard_shipping_cost"
                                                    value="{{ old('standard_shipping_cost', $settings['standard_shipping_cost']) }}"
                                                    step="0.01" min="0"
                                                    class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Express Shipping -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="p-2 bg-green-100 rounded-lg">
                                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h5 class="text-sm font-medium text-gray-900">Express Shipping</h5>
                                            <p class="text-sm text-gray-500">1-2 business days</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="shipping_methods[]" value="express"
                                                {{ in_array('express', $settings['shipping_methods']) ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                                        </label>
                                        <div class="w-32">
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span
                                                        class="text-gray-500 sm:text-sm">{{ config('settings.currency_symbol', '$') }}</span>
                                                </div>
                                                <input type="number" name="express_shipping_cost"
                                                    value="{{ old('express_shipping_cost', $settings['express_shipping_cost']) }}"
                                                    step="0.01" min="0"
                                                    class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- International Shipping -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="p-2 bg-purple-100 rounded-lg">
                                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h5 class="text-sm font-medium text-gray-900">International Shipping</h5>
                                            <p class="text-sm text-gray-500">7-14 business days</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="shipping_methods[]" value="international"
                                                {{ in_array('international', $settings['shipping_methods']) ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                                        </label>
                                        <div class="w-32">
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span
                                                        class="text-gray-500 sm:text-sm">{{ config('settings.currency_symbol', '$') }}</span>
                                                </div>
                                                <input type="number" value="24.99" disabled
                                                    class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Local Pickup -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="p-2 bg-yellow-100 rounded-lg">
                                                <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h5 class="text-sm font-medium text-gray-900">Local Pickup</h5>
                                            <p class="text-sm text-gray-500">Pick up from our store</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="shipping_methods[]" value="pickup"
                                                {{ in_array('pickup', $settings['shipping_methods']) ? 'checked' : '' }}
                                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                                        </label>
                                        <div class="w-32">
                                            <div class="relative">
                                                <input type="number" value="0" disabled
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Zones -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Shipping Zones</h4>
                            <p class="text-sm text-gray-500 mb-4">Configure shipping rates by region or country</p>

                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h5 class="text-sm font-medium text-gray-900">Current Zones</h5>
                                    <button type="button" onclick="addShippingZone()"
                                        class="px-3 py-1.5 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-dark">
                                        Add Zone
                                    </button>
                                </div>

                                <div id="shippingZonesContainer" class="space-y-4">
                                    <!-- Zones will be added here dynamically -->
                                    <div class="text-center py-8">
                                        <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">No shipping zones configured</p>
                                        <p class="text-xs text-gray-400">Click "Add Zone" to create your first shipping
                                            zone
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Save Shipping Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let zoneCounter = 0;

        function addShippingZone() {
            zoneCounter++;
            const zonesContainer = document.getElementById('shippingZonesContainer');

            // Clear initial message if it exists
            if (zonesContainer.children.length === 1 && zonesContainer.children[0].classList.contains('text-center')) {
                zonesContainer.innerHTML = '';
            }

            const zoneDiv = document.createElement('div');
            zoneDiv.className = 'border border-gray-200 rounded-lg p-4 bg-white';
            zoneDiv.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <h6 class="text-sm font-medium text-gray-900">Shipping Zone #${zoneCounter}</h6>
            <button type="button" onclick="removeShippingZone(this)"
                class="text-red-600 hover:text-red-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Zone Name</label>
                <input type="text" name="zone_names[]" placeholder="e.g., Domestic"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Countries</label>
                <input type="text" name="zone_countries[]" placeholder="e.g., US, CA, UK"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                <p class="mt-1 text-xs text-gray-500">Comma-separated country codes</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Standard Rate</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" name="zone_standard_rates[]" placeholder="0.00" step="0.01" min="0"
                        class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Express Rate</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" name="zone_express_rates[]" placeholder="0.00" step="0.01" min="0"
                        class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
    `;

            zonesContainer.appendChild(zoneDiv);
        }

        function removeShippingZone(button) {
            const zoneDiv = button.closest('.border');
            zoneDiv.remove();

            // Show message if no zones left
            const zonesContainer = document.getElementById('shippingZonesContainer');
            if (zonesContainer.children.length === 0) {
                zonesContainer.innerHTML = `
            <div class="text-center py-8">
                <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-2 text-sm text-gray-500">No shipping zones configured</p>
                <p class="text-xs text-gray-400">Click "Add Zone" to create your first shipping zone</p>
            </div>
        `;
            }
        }
    </script>
@endpush
