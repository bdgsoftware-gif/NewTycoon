@extends('admin.layouts.app')

@section('title', 'Customer Analytics')
@section('page-title', 'Customer Analytics')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.analytics.index') }}" class="text-gray-500 hover:text-gray-700">Analytics</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Customers</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Period Selector -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Customer Analytics</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.analytics.customers', ['period' => 'week']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'week' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 7 Days
                        </a>
                        <a href="{{ route('admin.analytics.customers', ['period' => 'month']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'month' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 30 Days
                        </a>
                        <a href="{{ route('admin.analytics.customers', ['period' => 'quarter']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'quarter' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 90 Days
                        </a>
                        <a href="{{ route('admin.analytics.customers', ['period' => 'year']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'year' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last Year
                        </a>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">Period: {{ $dateRange['start'] }} to {{ $dateRange['end'] }}</p>
            </div>

            <!-- Customer Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($customerStats['total']) }}
                            </p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 6.75h.008v.008h-.008v-.008zm-13.5 6.75h.008v.008h-.008v-.008zm-13.5-6.75h.008v.008h-.008v-.008z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Active Today</span>
                            <span class="font-medium">{{ $customerStats['active_today'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-gray-600">Avg Orders/Customer</span>
                            <span class="font-medium">{{ number_format($customerStats['avg_order_frequency'], 1) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">New Customers</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">
                                {{ number_format($customerStats['new_this_month']) }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Today</span>
                            <span class="font-medium">{{ $customerStats['new_today'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-gray-600">Last Month</span>
                            <span class="font-medium">{{ $customerStats['new_last_month'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Customer Growth</p>
                            @php
                                $growthRate =
                                    $customerStats['new_last_month'] > 0
                                        ? (($customerStats['new_this_month'] - $customerStats['new_last_month']) /
                                                $customerStats['new_last_month']) *
                                            100
                                        : ($customerStats['new_this_month'] > 0
                                            ? 100
                                            : 0);
                            @endphp
                            <p class="text-2xl font-bold {{ $growthRate >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                                {{ number_format($growthRate, 1) }}%
                            </p>
                        </div>
                        <div class="p-3 {{ $growthRate >= 0 ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                            <svg class="h-6 w-6 {{ $growthRate >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                @if ($growthRate >= 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                @endif
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Monthly Change</span>
                            <span class="font-medium {{ $growthRate >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $growthRate >= 0 ? '+' : '' }}{{ number_format($customerStats['new_this_month'] - $customerStats['new_last_month']) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Retention Rate</p>
                            @php
                                $returningCustomers = \App\Models\User::role('customer')
                                    ->has('orders', '>', 1)
                                    ->count();
                                $retentionRate =
                                    $customerStats['total'] > 0
                                        ? ($returningCustomers / $customerStats['total']) * 100
                                        : 0;
                            @endphp
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($retentionRate, 1) }}%</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Returning Customers</span>
                            <span class="font-medium">{{ $returningCustomers }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Acquisition Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Customer Acquisition</h3>
                <div class="h-96">
                    <canvas id="acquisitionChart"></canvas>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Top Customers by Lifetime Value</h3>
                    <a href="{{ route('admin.analytics.reports.customers') }}"
                        class="text-sm text-primary hover:text-primary-dark">View Report</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Orders</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Spent</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Avg Order</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Order</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($topCustomers as $customer)
                                @php
                                    $lastOrder = $customer->orders()->where('status', 'completed')->latest()->first();
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($customer->profile && $customer->profile->avatar)
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ Storage::url($customer->profile->avatar) }}"
                                                        alt="{{ $customer->name }}">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span
                                                            class="text-gray-500 font-medium">{{ substr($customer->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $customer->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customer->orders_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($customer->orders_sum_total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ $customer->orders_count > 0 ? number_format($customer->orders_sum_total_amount / $customer->orders_count, 2) : '0.00' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($lastOrder)
                                            {{ $lastOrder->created_at->format('M d, Y') }}
                                        @else
                                            Never
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- New Customers -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Recent New Customers</h3>
                    <div class="space-y-4">
                        @foreach ($newCustomers as $customer)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($customer->profile && $customer->profile->avatar)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ Storage::url($customer->profile->avatar) }}"
                                                alt="{{ $customer->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span
                                                    class="text-gray-500 font-medium">{{ substr($customer->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $customer->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</p>
                                    @if ($customer->orders_count > 0)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            {{ $customer->orders_count }} order(s)
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            No orders yet
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Customer Segments -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Customer Segments</h3>
                    <div class="space-y-4">
                        @php
                            $segments = [
                                [
                                    'title' => 'High Value',
                                    'description' => 'Customers with 5+ orders',
                                    'count' => \App\Models\User::role('customer')->has('orders', '>=', 5)->count(),
                                    'color' => 'bg-green-100 text-green-800',
                                ],
                                [
                                    'title' => 'Medium Value',
                                    'description' => 'Customers with 2-4 orders',
                                    'count' => \App\Models\User::role('customer')
                                        ->has('orders', '>=', 2)
                                        ->has('orders', '<=', 4)
                                        ->count(),
                                    'color' => 'bg-blue-100 text-blue-800',
                                ],
                                [
                                    'title' => 'New Customers',
                                    'description' => 'Joined in last 30 days',
                                    'count' => \App\Models\User::role('customer')
                                        ->where('created_at', '>=', now()->subDays(30))
                                        ->count(),
                                    'color' => 'bg-purple-100 text-purple-800',
                                ],
                                [
                                    'title' => 'At Risk',
                                    'description' => 'No orders in 90 days',
                                    'count' => \App\Models\User::role('customer')
                                        ->whereDoesntHave('orders', function ($q) {
                                            $q->where('created_at', '>=', now()->subDays(90));
                                        })
                                        ->has('orders', '>=', 1)
                                        ->count(),
                                    'color' => 'bg-yellow-100 text-yellow-800',
                                ],
                                [
                                    'title' => 'Inactive',
                                    'description' => 'No orders ever',
                                    'count' => \App\Models\User::role('customer')->doesntHave('orders')->count(),
                                    'color' => 'bg-gray-100 text-gray-800',
                                ],
                            ];
                        @endphp

                        @foreach ($segments as $segment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $segment['title'] }}</h4>
                                    <p class="text-xs text-gray-500">{{ $segment['description'] }}</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $segment['color'] }}">
                                        {{ $segment['count'] }} customers
                                    </span>
                                    @if ($customerStats['total'] > 0)
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ number_format(($segment['count'] / $customerStats['total']) * 100, 1) }}%
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Customer Acquisition Chart
            const acquisitionCtx = document.getElementById('acquisitionChart').getContext('2d');
            new Chart(acquisitionCtx, {
                type: 'line',
                data: {
                    labels: @json($customerAcquisition->pluck('date')),
                    datasets: [{
                        label: 'New Customers',
                        data: @json($customerAcquisition->pluck('new_customers')),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
