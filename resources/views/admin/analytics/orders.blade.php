@extends('admin.layouts.app')

@section('title', 'Order Analytics')
@section('page-title', 'Order Analytics')

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
        <span class="text-gray-700">Orders</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Period Selector -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Order Analytics</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.analytics.orders', ['period' => 'week']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'week' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 7 Days
                        </a>
                        <a href="{{ route('admin.analytics.orders', ['period' => 'month']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'month' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 30 Days
                        </a>
                        <a href="{{ route('admin.analytics.orders', ['period' => 'quarter']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'quarter' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 90 Days
                        </a>
                        <a href="{{ route('admin.analytics.orders', ['period' => 'year']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'year' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last Year
                        </a>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">Period: {{ $dateRange['start'] }} to {{ $dateRange['end'] }}</p>
            </div>

            <!-- Order Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($orderStats['total']) }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Today</span>
                            <span class="font-medium">{{ $orderStats['today'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-gray-600">This Month</span>
                            <span class="font-medium">{{ $orderStats['this_month'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Completed Orders</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($orderStats['completed']) }}
                            </p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Completion Rate</span>
                            <span class="font-medium">
                                {{ $orderStats['total'] > 0 ? number_format(($orderStats['completed'] / $orderStats['total']) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($orderStats['pending']) }}
                            </p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Processing</span>
                            <span class="font-medium">{{ $orderStats['processing'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-gray-600">Active Total</span>
                            <span class="font-medium">{{ $orderStats['pending'] + $orderStats['processing'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Avg Order Value</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">
                                ${{ number_format($orderStats['avg_value'], 2) }}
                            </p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Avg Processing Time</span>
                            <span class="font-medium">{{ number_format($averageProcessingTime, 1) }} hours</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders by Status Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Orders by Status</h3>
                <div class="h-96">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>

            <!-- Orders by Day -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Orders by Day of Week</h3>
                <div class="h-80">
                    <canvas id="ordersByDayChart"></canvas>
                </div>
            </div>

            <!-- Detailed Order Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Order Status Breakdown</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($ordersByStatus as $status)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status->status == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($status->status == 'processing'
                                            ? 'bg-blue-100 text-blue-800'
                                            : ($status->status == 'completed'
                                                ? 'bg-green-100 text-green-800'
                                                : ($status->status == 'cancelled'
                                                    ? 'bg-red-100 text-red-800'
                                                    : ($status->status == 'on_hold'
                                                        ? 'bg-orange-100 text-orange-800'
                                                        : ($status->status == 'refunded'
                                                            ? 'bg-purple-100 text-purple-800'
                                                            : 'bg-gray-100 text-gray-800'))))) }}">
                                    {{ ucfirst($status->status) }}
                                </span>
                                <span class="text-lg font-bold text-gray-800">{{ $status->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full"
                                    style="width: {{ $orderStats['total'] > 0 ? ($status->count / $orderStats['total']) * 100 : 0 }}%">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ $orderStats['total'] > 0 ? number_format(($status->count / $orderStats['total']) * 100, 1) : 0 }}%
                                of total orders
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Processing Metrics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Order Processing Timeline</h3>
                    <div class="space-y-6">
                        @php
                            $timelineMetrics = [
                                [
                                    'title' => 'Order to Processing',
                                    'description' => 'Average time from order to processing',
                                    'value' => $this->getAverageTimeToProcessing(),
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'color' => 'text-blue-500',
                                ],
                                [
                                    'title' => 'Processing to Shipping',
                                    'description' => 'Average processing time',
                                    'value' => number_format($averageProcessingTime, 1) . ' hours',
                                    'icon' =>
                                        'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                    'color' => 'text-green-500',
                                ],
                                [
                                    'title' => 'Shipping to Delivery',
                                    'description' => 'Average shipping duration',
                                    'value' => $this->getAverageShippingTime(),
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'color' => 'text-purple-500',
                                ],
                                [
                                    'title' => 'Total Order Cycle',
                                    'description' => 'Average order to delivery time',
                                    'value' => $this->getAverageOrderCycleTime(),
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'color' => 'text-orange-500',
                                ],
                            ];
                        @endphp

                        @foreach ($timelineMetrics as $metric)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div
                                        class="p-2 {{ str_replace('text', 'bg', $metric['color']) }} bg-opacity-10 rounded-lg">
                                        <svg class="h-6 w-6 {{ $metric['color'] }}" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $metric['icon'] }}" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $metric['title'] }}</h4>
                                    <p class="text-sm text-gray-500">{{ $metric['description'] }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-semibold text-gray-800">{{ $metric['value'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Order Activity -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Order Activity</h3>
                        <a href="{{ route('admin.orders.index') }}"
                            class="text-sm text-primary hover:text-primary-dark">View
                            All</a>
                    </div>
                    <div class="space-y-4">
                        @php
                            $recentOrders = \App\Models\Order::with('user')->latest()->take(8)->get();
                        @endphp

                        @foreach ($recentOrders as $order)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div>
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="text-sm font-medium text-gray-900 hover:text-primary">
                                        {{ $order->order_number }}
                                    </a>
                                    <p class="text-xs text-gray-500">{{ $order->customer_name }}</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $order->status_badge_color }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">${{ number_format($order->total_amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cancellation Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-800 mb-4">Cancellation Insights</h4>
                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $cancelledCount = $orderStats['cancelled'];
                                $cancellationRate =
                                    $orderStats['total'] > 0 ? ($cancelledCount / $orderStats['total']) * 100 : 0;
                                $avgCancellationTime = $this->getAverageCancellationTime();
                            @endphp

                            <div class="text-center p-3 bg-red-50 rounded-lg">
                                <p class="text-sm text-gray-600">Cancellation Rate</p>
                                <p class="text-xl font-bold text-red-600 mt-1">{{ number_format($cancellationRate, 1) }}%
                                </p>
                            </div>
                            <div class="text-center p-3 bg-orange-50 rounded-lg">
                                <p class="text-sm text-gray-600">Avg Time to Cancel</p>
                                <p class="text-xl font-bold text-orange-600 mt-1">{{ $avgCancellationTime }}</p>
                            </div>
                        </div>
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
            // Order Status Chart
            const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($ordersByStatus->pluck('status')->map(fn($s) => ucfirst($s))),
                    datasets: [{
                        data: @json($ordersByStatus->pluck('count')),
                        backgroundColor: [
                            'rgb(245, 158, 11)', // yellow for pending
                            'rgb(59, 130, 246)', // blue for processing
                            'rgb(16, 185, 129)', // green for completed
                            'rgb(239, 68, 68)', // red for cancelled
                            'rgb(249, 115, 22)', // orange for on_hold
                            'rgb(139, 92, 246)', // purple for refunded
                            'rgb(107, 114, 128)' // gray for failed
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });

            // Orders by Day Chart
            const dayCtx = document.getElementById('ordersByDayChart').getContext('2d');

            // Prepare data in correct order
            const daysOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            const dayData = daysOrder.map(day => {
                const dayRecord = @json($ordersByDay).find(d => d.day === day);
                return dayRecord ? dayRecord.count : 0;
            });

            new Chart(dayCtx, {
                type: 'bar',
                data: {
                    labels: daysOrder,
                    datasets: [{
                        label: 'Orders',
                        data: dayData,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
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
