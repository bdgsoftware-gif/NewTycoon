@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings Dashboard')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Settings</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Settings Overview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Settings Overview</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- General Settings -->
                    <a href="{{ route('admin.settings.general') }}"
                        class="group p-6 border border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                                    <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800 group-hover:text-primary">General Settings
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">Site name, email, timezone, etc.</p>
                            </div>
                        </div>
                    </a>

                    <!-- Store Settings -->
                    <a href="{{ route('admin.settings.store') }}"
                        class="group p-6 border border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-green-50 rounded-lg group-hover:bg-green-100 transition-colors">
                                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800 group-hover:text-primary">Store Settings</h4>
                                <p class="text-sm text-gray-500 mt-1">Currency, taxes, checkout options</p>
                            </div>
                        </div>
                    </a>

                    <!-- Email Settings -->
                    <a href="{{ route('admin.settings.email') }}"
                        class="group p-6 border border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-purple-50 rounded-lg group-hover:bg-purple-100 transition-colors">
                                    <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800 group-hover:text-primary">Email Settings</h4>
                                <p class="text-sm text-gray-500 mt-1">SMTP configuration, email templates</p>
                            </div>
                        </div>
                    </a>

                    <!-- Roles & Permissions -->
                    <a href="{{ route('admin.settings.roles.index') }}"
                        class="group p-6 border border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-yellow-50 rounded-lg group-hover:bg-yellow-100 transition-colors">
                                    <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800 group-hover:text-primary">Roles & Permissions
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">User roles and access control</p>
                            </div>
                        </div>
                    </a>

                    <!-- Maintenance -->
                    <a href="{{ route('admin.settings.maintenance') }}"
                        class="group p-6 border border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800 group-hover:text-primary">Maintenance</h4>
                                <p class="text-sm text-gray-500 mt-1">Cache, backups, system info</p>
                            </div>
                        </div>
                    </a>

                    <!-- Permissions -->
                    <a href="{{ route('admin.settings.permissions.index') }}"
                        class="group p-6 border border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all duration-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors">
                                    <svg class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-800 group-hover:text-primary">Permissions</h4>
                                <p class="text-sm text-gray-500 mt-1">Manage system permissions</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">System Information</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Laravel Version</p>
                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ app()->version() }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">PHP Version</p>
                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ phpversion() }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Environment</p>
                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ app()->environment() }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Timezone</p>
                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ config('app.timezone') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
