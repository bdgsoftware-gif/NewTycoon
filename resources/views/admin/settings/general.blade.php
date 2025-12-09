@extends('admin.layouts.app')

@section('title', 'General Settings')
@section('page-title', 'General Settings')

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
        <span class="text-gray-700">General</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">General Settings</h3>
                    <p class="text-sm text-gray-500 mt-1">Configure basic site settings and preferences</p>
                </div>

                <form method="POST" action="{{ route('admin.settings.update.general') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Site Information -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Site Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                                    <input type="text" name="site_name"
                                        value="{{ old('site_name', $settings['site_name']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        required>
                                    @error('site_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Email</label>
                                    <input type="email" name="site_email"
                                        value="{{ old('site_email', $settings['site_email']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        required>
                                    @error('site_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Phone</label>
                                    <input type="text" name="site_phone"
                                        value="{{ old('site_phone', $settings['site_phone']) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    @error('site_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Address</label>
                                    <textarea name="site_address" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">{{ old('site_address', $settings['site_address']) }}</textarea>
                                    @error('site_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Regional Settings -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Regional Settings</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                                    <select name="timezone"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        @foreach ($timezones as $timezone)
                                            <option value="{{ $timezone }}"
                                                {{ $settings['timezone'] == $timezone ? 'selected' : '' }}>
                                                {{ $timezone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('timezone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                    <select name="site_currency"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        @foreach ($currencies as $code => $name)
                                            <option value="{{ $code }}"
                                                {{ $settings['site_currency'] == $code ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('site_currency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                                    <select name="date_format"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="Y-m-d" {{ $settings['date_format'] == 'Y-m-d' ? 'selected' : '' }}>
                                            YYYY-MM-DD (2023-12-31)</option>
                                        <option value="d/m/Y" {{ $settings['date_format'] == 'd/m/Y' ? 'selected' : '' }}>
                                            DD/MM/YYYY (31/12/2023)</option>
                                        <option value="m/d/Y" {{ $settings['date_format'] == 'm/d/Y' ? 'selected' : '' }}>
                                            MM/DD/YYYY (12/31/2023)</option>
                                        <option value="d M Y" {{ $settings['date_format'] == 'd M Y' ? 'selected' : '' }}>
                                            DD
                                            Mon YYYY (31 Dec 2023)</option>
                                        <option value="M d, Y"
                                            {{ $settings['date_format'] == 'M d, Y' ? 'selected' : '' }}>Mon
                                            DD, YYYY (Dec 31, 2023)</option>
                                    </select>
                                    @error('date_format')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
                                    <select name="time_format"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="H:i:s" {{ $settings['time_format'] == 'H:i:s' ? 'selected' : '' }}>
                                            24-hour (14:30:45)</option>
                                        <option value="h:i:s A"
                                            {{ $settings['time_format'] == 'h:i:s A' ? 'selected' : '' }}>
                                            12-hour (02:30:45 PM)</option>
                                        <option value="h:i A" {{ $settings['time_format'] == 'h:i A' ? 'selected' : '' }}>
                                            12-hour short (02:30 PM)</option>
                                    </select>
                                    @error('time_format')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Display Settings -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Display Settings</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Items Per Page</label>
                                    <input type="number" name="pagination_limit"
                                        value="{{ old('pagination_limit', $settings['pagination_limit']) }}" min="5"
                                        max="100"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        required>
                                    <p class="mt-1 text-xs text-gray-500">Number of items to display per page in lists</p>
                                    @error('pagination_limit')
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
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
