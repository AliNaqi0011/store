@extends('admin.layouts.app')

@section('title', 'Analytics')
@section('page-title', 'Analytics Dashboard')
@section('page-description', 'Business insights and performance metrics')

@section('content')
<div class="space-y-8">
    <!-- Revenue Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Revenue -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Today's Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format($analytics['overview']['today_revenue'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
            </div>
        </div>

        <!-- This Month -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">This Month</p>
                    <p class="text-3xl font-bold">${{ number_format($analytics['overview']['month_revenue'], 2) }}</p>
                    <p class="text-green-100 text-xs">
                        @if($analytics['sales']['revenue_growth'] > 0)
                            <i class="fas fa-arrow-up"></i> +{{ number_format($analytics['sales']['revenue_growth'], 1) }}%
                        @else
                            <i class="fas fa-arrow-down"></i> {{ number_format($analytics['sales']['revenue_growth'], 1) }}%
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold">{{ number_format($analytics['overview']['total_orders']) }}</p>
                    <p class="text-purple-100 text-xs">{{ $analytics['overview']['pending_orders'] }} pending</p>
                </div>
                <div class="w-12 h-12 bg-purple-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total Customers</p>
                    <p class="text-3xl font-bold">{{ number_format($analytics['overview']['total_customers']) }}</p>
                    <p class="text-orange-100 text-xs">{{ $analytics['customers']['new_customers_this_month'] }} new this month</p>
                </div>
                <div class="w-12 h-12 bg-orange-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Revenue Trend (Last 30 Days)</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Top Selling Products</h3>
            <div class="space-y-4">
                @forelse($analytics['products']['top_selling'] as $product)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">{{ $product->total_sold }}</p>
                        <p class="text-xs text-gray-500">sold</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-chart-bar text-3xl mb-3"></i>
                    <p>No sales data available yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Products Stats -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="font-semibold text-gray-900 mb-4">Products Overview</h4>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Products</span>
                    <span class="font-semibold">{{ $analytics['overview']['total_products'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Active Products</span>
                    <span class="font-semibold text-green-600">{{ $analytics['overview']['total_products'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Low Stock</span>
                    <span class="font-semibold text-red-600">{{ $analytics['overview']['low_stock_products'] }}</span>
                </div>
            </div>
        </div>

        <!-- Orders Stats -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="font-semibold text-gray-900 mb-4">Orders Overview</h4>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Today's Orders</span>
                    <span class="font-semibold">{{ $analytics['overview']['today_orders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">This Month</span>
                    <span class="font-semibold">{{ $analytics['overview']['month_orders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-semibold text-yellow-600">{{ $analytics['overview']['pending_orders'] }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="font-semibold text-gray-900 mb-4">Quick Actions</h4>
            <div class="space-y-3">
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center space-x-3 p-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                    <span>View Orders</span>
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center space-x-3 p-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-box text-green-600"></i>
                    <span>Manage Products</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" 
                   class="flex items-center space-x-3 p-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-users text-purple-600"></i>
                    <span>View Customers</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueData = @json($analytics['charts']['daily_revenue']);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: revenueData.map(item => item.date),
        datasets: [{
            label: 'Revenue',
            data: revenueData.map(item => item.revenue),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value;
                    }
                }
            }
        }
    }
});
</script>
@endsection