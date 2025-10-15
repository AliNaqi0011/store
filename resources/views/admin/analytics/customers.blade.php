@extends('admin.layouts.app')

@section('title', 'Customer Analytics')
@section('page-title', 'Customer Analytics')
@section('page-description', 'Customer behavior and demographic insights')

@section('content')
<!-- Demographics Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Total Customers</p>
                <p class="text-3xl font-bold">{{ number_format($customerData['demographics']['total_customers']) }}</p>
            </div>
            <i class="fas fa-users text-4xl text-blue-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">New This Month</p>
                <p class="text-3xl font-bold">{{ number_format($customerData['demographics']['new_this_month']) }}</p>
            </div>
            <i class="fas fa-user-plus text-4xl text-green-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">Active Customers</p>
                <p class="text-3xl font-bold">{{ number_format($customerData['demographics']['active_customers']) }}</p>
            </div>
            <i class="fas fa-user-check text-4xl text-purple-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm">Repeat Customers</p>
                <p class="text-3xl font-bold">{{ number_format($customerData['demographics']['repeat_customers']) }}</p>
            </div>
            <i class="fas fa-redo text-4xl text-orange-200"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Customer Behavior -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Customer Behavior</h3>
        
        <div class="space-y-4">
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-600">Avg Orders per Customer</span>
                <span class="font-semibold text-gray-900">{{ $customerData['behavior']['avg_orders_per_customer'] }}</span>
            </div>
            
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-600">Avg Time Between Orders</span>
                <span class="font-semibold text-gray-900">{{ $customerData['behavior']['avg_time_between_orders'] }} days</span>
            </div>
        </div>
        
        <div class="mt-6">
            <h4 class="font-medium text-gray-900 mb-3">Most Active Hours</h4>
            <div class="space-y-2">
                @foreach($customerData['behavior']['most_active_hours'] as $hour)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $hour->hour }}:00</span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($hour->orders / $customerData['behavior']['most_active_hours']->max('orders')) * 100 }}%"></div>
                        </div>
                        <span class="text-sm text-gray-500">{{ $hour->orders }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Customer Retention -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Customer Retention</h3>
        
        <div class="text-center mb-6">
            <div class="text-4xl font-bold text-blue-600 mb-2">{{ $customerData['retention']['retention_rate'] }}%</div>
            <div class="text-gray-600">Overall Retention Rate</div>
        </div>
        
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">One-time Customers</span>
                <span class="font-semibold text-gray-900">{{ number_format($customerData['retention']['customer_segments']['one_time']) }}</span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Repeat Customers</span>
                <span class="font-semibold text-gray-900">{{ number_format($customerData['retention']['customer_segments']['repeat']) }}</span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-gray-600">VIP Customers (5+ orders)</span>
                <span class="font-semibold text-gray-900">{{ number_format($customerData['retention']['customer_segments']['vip']) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Customer Lifetime Value -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Customer Lifetime Value</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="text-center">
            <div class="text-3xl font-bold text-green-600 mb-2">${{ number_format($customerData['lifetime_value']->avg_clv ?? 0, 2) }}</div>
            <div class="text-gray-600">Average CLV</div>
        </div>
        
        <div class="text-center">
            <div class="text-3xl font-bold text-purple-600 mb-2">${{ number_format($customerData['lifetime_value']->max_clv ?? 0, 2) }}</div>
            <div class="text-gray-600">Highest CLV</div>
        </div>
    </div>
</div>
@endsection