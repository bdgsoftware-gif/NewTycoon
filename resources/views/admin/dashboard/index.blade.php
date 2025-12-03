{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <span class="text-gray-500">Dashboard</span>
    </li>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($stats['revenue'], 2) }}</p>
                </div>
                <div class="h-12 w-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <span class="text-sm font-medium text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>12.5%
                </span>
                <span class="text-sm text-gray-500 ml-2">from last month</span>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">
                    <i class="fas fa-user-plus mr-1"></i>{{ $stats['new_users'] }} new today
                </span>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_products'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">Active products</span>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <span class="text-sm font-medium text-red-600">
                    <i class="fas fa-exclamation-circle mr-1"></i>Needs attention
                </span>
            </div>
        </div>
    </div>

    <!-- Charts & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($recent_users as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <span
                                        class="text-gray-600 font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
                @if ($recent_users->isEmpty())
                    <p class="text-gray-500 text-center py-4">No users found</p>
                @endif
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($recent_orders as $order)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                <p class="text-xs text-gray-500">By {{ $order->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}
                                </p>
                                <span
                                    class="text-xs px-2 py-1 rounded-full 
                                {{ $order->status == 'completed'
                                    ? 'bg-green-100 text-green-800'
                                    : ($order->status == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($recent_orders->isEmpty())
                    <p class="text-gray-500 text-center py-4">No orders found</p>
                @endif
            </div>
        </div>
    </div>
@endsection
