@extends('admin.layouts.app')

@section('title', 'Maintenance')
@section('page-title', 'System Maintenance')

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
        <span class="text-gray-700">Maintenance</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- System Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">System Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($systemInfo as $key => $value)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}</p>
                            <p class="text-lg font-semibold text-gray-800 mt-2 break-words">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Storage Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Storage Information</h3>

                <div class="space-y-4">
                    <!-- Storage Usage Bar -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium text-gray-700">Disk Usage</span>
                            <span class="text-gray-600">{{ $storageInfo['used_formatted'] }} of
                                {{ $storageInfo['total_formatted'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            @php
                                $usagePercentage = ($storageInfo['used'] / $storageInfo['total']) * 100;
                                $color =
                                    $usagePercentage > 90
                                        ? 'bg-red-600'
                                        : ($usagePercentage > 70
                                            ? 'bg-yellow-500'
                                            : 'bg-green-600');
                            @endphp
                            <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ $usagePercentage }}%">
                            </div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-2">
                            <span>{{ $storageInfo['free_formatted'] }} free</span>
                            <span>{{ number_format($usagePercentage, 1) }}% used</span>
                        </div>
                    </div>

                    <!-- Storage Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm text-gray-600">Total Storage</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $storageInfo['total_formatted'] }}</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-sm text-gray-600">Used Storage</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">{{ $storageInfo['used_formatted'] }}</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Free Storage</p>
                            <p class="text-2xl font-bold text-gray-600 mt-1">{{ $storageInfo['free_formatted'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Maintenance Actions</h3>
                <p class="text-sm text-gray-600 mb-6">Perform system maintenance tasks to optimize performance</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Clear Cache -->
                    <form action="{{ route('admin.settings.cache.clear') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to clear all caches?')">
                        @csrf
                        <button type="submit"
                            class="w-full p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors text-left group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">Clear Cache</h4>
                                    <p class="text-xs text-gray-500 mt-1">Application, config, route caches</p>
                                </div>
                            </div>
                        </button>
                    </form>

                    <!-- Clear Views -->
                    <form action="{{ route('admin.settings.view.clear') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to clear view cache?')">
                        @csrf
                        <button type="submit"
                            class="w-full p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors text-left group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="p-2 bg-purple-100 rounded-lg group-hover:bg-purple-200">
                                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">Clear View Cache</h4>
                                    <p class="text-xs text-gray-500 mt-1">Compiled views and templates</p>
                                </div>
                            </div>
                        </button>
                    </form>

                    <!-- Create Backup -->
                    <form action="{{ route('admin.settings.backup.create') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to create a backup?')">
                        @csrf
                        <button type="submit"
                            class="w-full p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors text-left group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="p-2 bg-green-100 rounded-lg group-hover:bg-green-200">
                                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">Create Backup</h4>
                                    <p class="text-xs text-gray-500 mt-1">Database and files backup</p>
                                </div>
                            </div>
                        </button>
                    </form>

                    <!-- Optimize -->
                    <form action="{{ route('admin.settings.optimize') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to optimize the application?')">
                        @csrf
                        <button type="submit"
                            class="w-full p-4 bg-orange-50 border border-orange-200 rounded-lg hover:bg-orange-100 transition-colors text-left group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="p-2 bg-orange-100 rounded-lg group-hover:bg-orange-200">
                                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">Optimize</h4>
                                    <p class="text-xs text-gray-500 mt-1">Optimize application performance</p>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Server Information -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Server Information</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">PHP Memory Limit</p>
                                <p class="text-sm font-medium text-gray-900">{{ ini_get('memory_limit') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">PHP Max Execution Time</p>
                                <p class="text-sm font-medium text-gray-900">{{ ini_get('max_execution_time') }} seconds
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">PHP Upload Max Filesize</p>
                                <p class="text-sm font-medium text-gray-900">{{ ini_get('upload_max_filesize') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">PHP Post Max Size</p>
                                <p class="text-sm font-medium text-gray-900">{{ ini_get('post_max_size') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Log Files -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Log Files</h3>

                <div class="space-y-4">
                    @php
                        $logFiles = [
                            ['name' => 'laravel.log', 'size' => '2.5 MB', 'modified' => '2 hours ago'],
                            ['name' => 'error.log', 'size' => '1.2 MB', 'modified' => '1 day ago'],
                            ['name' => 'access.log', 'size' => '5.7 MB', 'modified' => '3 days ago'],
                            ['name' => 'debug.log', 'size' => '450 KB', 'modified' => '1 week ago'],
                        ];
                    @endphp

                    @foreach ($logFiles as $log)
                        <div
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="p-2 bg-gray-100 rounded-lg">
                                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $log['name'] }}</h4>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-gray-500">{{ $log['size'] }}</span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        <span class="text-xs text-gray-500">Modified {{ $log['modified'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="text-primary hover:text-primary-dark text-sm font-medium">
                                    View
                                </button>
                                <button class="text-red-600 hover:text-red-900 text-sm font-medium">
                                    Clear
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Log Retention</h4>
                            <p class="text-sm text-gray-500 mt-1">Automatically delete logs older than 30 days</p>
                        </div>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200">
                            Configure Retention
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
