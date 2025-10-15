@extends('admin.layouts.app')

@section('title', 'Sales Report')
@section('page-title', 'Sales Report')
@section('page-description', 'Detailed sales analytics and performance metrics')

@section('content')
<div class="mb-6">
    <form method="GET" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>Generate Report
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Total Revenue</p>
                <p class="text-3xl font-bold">${{ number_format($salesData['summary']->total_revenue, 2) }}</p>
            </div>
            <i class="fas fa-dollar-sign text-4xl text-green-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Total Orders</p>
                <p class="text-3xl font-bold">{{ number_format($salesData['summary']->total_orders) }}</p>
            </div>
            <i class="fas fa-shopping-cart text-4xl text-blue-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">Avg Order Value</p>
                <p class="text-3xl font-bold">${{ number_format($salesData['summary']->avg_order_value, 2) }}</p>
            </div>
            <i class="fas fa-chart-line text-4xl text-purple-200"></i>
        </div>
    </div>
</div>

<!-- Daily Breakdown Chart -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Daily Sales Breakdown</h3>
    <canvas id="dailySalesChart" height="100"></canvas>
</div>

<!-- Top Products -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Top Selling Products</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity Sold</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($salesData['top_products'] as $product)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $product->quantity_sold }}</td>
                    <td class="px-6 py-4 text-gray-600">${{ number_format($product->revenue, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('dailySalesChart').getContext('2d');
const dailySalesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($salesData['daily_breakdown']->pluck('date')) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($salesData['daily_breakdown']->pluck('revenue')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endpush