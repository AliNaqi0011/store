@extends('admin.layouts.app')

@section('page-title', 'Customer Details')
@section('page-description', 'View customer information and order history')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
        <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to Customers
        </a>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h4>
                <div class="space-y-3">
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-gray-600">Name:</span>
                        <span class="text-gray-900">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-gray-600">Email:</span>
                        <span class="text-gray-900">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-gray-600">Email Verified:</span>
                        <span>
                            @if($user->email_verified_at)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Verified</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Not Verified</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-gray-600">Joined:</span>
                        <span class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Order Statistics</h4>
                <div class="space-y-3">
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-gray-600">Total Orders:</span>
                        <span class="text-gray-900 font-semibold">{{ $user->orders->count() }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-gray-600">Total Spent:</span>
                        <span class="text-gray-900 font-semibold">${{ number_format($user->orders->sum('total_amount'), 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-gray-600">Last Order:</span>
                        <span class="text-gray-900">
                            @if($user->orders->count() > 0)
                                {{ $user->orders->sortByDesc('created_at')->first()->created_at->format('M d, Y') }}
                            @else
                                No orders yet
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($user->orders->count() > 0)
        <div class="mt-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Recent Orders</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($user->orders->sortByDesc('created_at')->take(10) as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $order->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg transition-colors">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection