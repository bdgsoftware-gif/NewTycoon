@extends('admin.layouts.app')

@section('title', 'Tax Settings')
@section('page-title', 'Tax Settings')

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
        <span class="text-gray-700">Tax</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Tax Settings</h3>
                    <p class="text-sm text-gray-500 mt-1">Configure tax calculations and rates</p>
                </div>

                <form method="POST" action="{{ route('admin.settings.update.tax') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- General Tax Settings -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">General Tax Settings</h4>
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
                                    <p class="mt-1 text-xs text-gray-500">Display prices with tax included</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Tax Rate (%)</label>
                                    <div class="relative">
                                        <input type="number" name="default_tax_rate"
                                            value="{{ old('default_tax_rate', $settings['default_tax_rate']) }}"
                                            step="0.01" min="0" max="100"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                    @error('default_tax_rate')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tax Registration
                                        Number</label>
                                    <input type="text" name="tax_registration_number"
                                        value="{{ old('tax_registration_number', $settings['tax_registration_number']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('tax_registration_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">e.g., VAT, GST, Sales Tax ID</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tax by Country -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-medium text-gray-800">Tax by Country</h4>
                                <label class="flex items-center">
                                    <input type="checkbox" name="tax_by_country" value="1"
                                        {{ $settings['tax_by_country'] ? 'checked' : '' }}
                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Enable Country-specific Taxes</span>
                                </label>
                            </div>

                            <p class="text-sm text-gray-500 mb-4">Configure different tax rates for different countries</p>

                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h5 class="text-sm font-medium text-gray-900">Country Tax Rates</h5>
                                    <button type="button" onclick="addTaxRate()"
                                        class="px-3 py-1.5 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-dark">
                                        Add Tax Rate
                                    </button>
                                </div>

                                <div id="taxRatesContainer" class="space-y-4">
                                    <!-- Default rate -->
                                    <div
                                        class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">Default Rate</span>
                                            <p class="text-xs text-gray-500">Applies to all countries not listed below</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm text-gray-600">{{ $settings['default_tax_rate'] }}%</span>
                                        </div>
                                    </div>

                                    <!-- Country rates will be added here -->
                                </div>
                            </div>
                        </div>

                        <!-- Tax Classes -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Tax Classes</h4>
                            <p class="text-sm text-gray-500 mb-4">Create tax classes for different types of products</p>

                            <div class="space-y-4">
                                @php
                                    $taxClasses = [
                                        [
                                            'name' => 'Standard',
                                            'rate' => $settings['default_tax_rate'] . '%',
                                            'description' => 'Default tax class for most products',
                                        ],
                                        [
                                            'name' => 'Reduced',
                                            'rate' => '5%',
                                            'description' => 'Reduced rate for essential goods',
                                        ],
                                        ['name' => 'Zero', 'rate' => '0%', 'description' => 'Tax-exempt products'],
                                        [
                                            'name' => 'Digital',
                                            'rate' => $settings['default_tax_rate'] . '%',
                                            'description' => 'Digital products and services',
                                        ],
                                    ];
                                @endphp

                                @foreach ($taxClasses as $class)
                                    <div
                                        class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-900">{{ $class['name'] }}</h5>
                                            <p class="text-sm text-gray-500">{{ $class['description'] }}</p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm font-medium text-gray-900">{{ $class['rate'] }}</span>
                                            <button class="text-primary hover:text-primary-dark text-sm font-medium">
                                                Edit
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tax Display -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Tax Display Settings</h4>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-900">Show Prices Including Tax</h5>
                                        <p class="text-sm text-gray-500">Display product prices with tax included</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer"
                                            {{ $settings['tax_inclusive'] ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                        </div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-900">Show Tax on Cart Page</h5>
                                        <p class="text-sm text-gray-500">Display tax breakdown in shopping cart</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                        </div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-900">Show Tax on Product Pages</h5>
                                        <p class="text-sm text-gray-500">Display "Price includes tax" message on product
                                            pages
                                        </p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer"
                                            {{ $settings['tax_inclusive'] ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Save Tax Settings
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
        let taxRateCounter = 0;

        function addTaxRate() {
            taxRateCounter++;
            const container = document.getElementById('taxRatesContainer');

            const rateDiv = document.createElement('div');
            rateDiv.className = 'flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg';
            rateDiv.innerHTML = `
        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Country</label>
                <select class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">State/Region</label>
                <input type="text" placeholder="Optional" 
                    class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
            </div>
            <div class="flex items-end space-x-2">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tax Rate (%)</label>
                    <input type="number" step="0.01" min="0" max="100" placeholder="0.00"
                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                </div>
                <button type="button" onclick="removeTaxRate(this)"
                    class="p-1 text-red-600 hover:text-red-900">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    `;

            // Insert after the default rate (first child)
            container.insertBefore(rateDiv, container.children[1]);
        }

        function removeTaxRate(button) {
            const rateDiv = button.closest('.bg-white');
            rateDiv.remove();
        }
    </script>
@endpush
