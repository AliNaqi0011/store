@extends('admin.layouts.app')

@section('page-title', 'Deal Management')
@section('page-description', 'Manage deals and promotions')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Active Deals</p>
                <p class="text-3xl font-bold">{{ $deals->where('is_active', true)->count() }}</p>
            </div>
            <i class="fas fa-fire text-2xl text-blue-200"></i>
        </div>
    </div>
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Total Savings</p>
                <p class="text-3xl font-bold">${{ number_format($deals->sum(function($deal) { return ($deal->original_price - $deal->sale_price) * $deal->sold_count; }), 0) }}</p>
            </div>
            <i class="fas fa-dollar-sign text-2xl text-green-200"></i>
        </div>
    </div>
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">Items Sold</p>
                <p class="text-3xl font-bold">{{ $deals->sum('sold_count') }}</p>
            </div>
            <i class="fas fa-shopping-cart text-2xl text-purple-200"></i>
        </div>
    </div>
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm">Avg Discount</p>
                <p class="text-3xl font-bold">{{ $deals->avg('discount_percentage') ? number_format($deals->avg('discount_percentage'), 0) : 0 }}%</p>
            </div>
            <i class="fas fa-percentage text-2xl text-orange-200"></i>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Deals & Promotions</h3>
            <p class="text-gray-600 text-sm">Manage your store deals and promotional offers</p>
        </div>
        <a href="{{ route('admin.deals.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg">
            <i class="fas fa-plus mr-2"></i>Create New Deal
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deal Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($deals as $deal)
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="relative">
                                <img src="{{ $deal->product->primary_image ?? 'https://via.placeholder.com/60x60' }}" alt="{{ $deal->product->name }}" class="w-12 h-12 rounded-xl object-cover shadow-md">
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                    {{ $deal->discount_percentage }}%
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">{{ $deal->product->name }}</div>
                                <div class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-barcode mr-1"></i>{{ $deal->product->sku }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900 mb-1">{{ $deal->title }}</div>
                        @if($deal->description)
                            <div class="text-sm text-gray-500">{{ Str::limit($deal->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-bold mb-2 inline-block">
                            {{ $deal->discount_percentage }}% OFF
                        </div>
                        <div class="text-sm">
                            <span class="text-gray-500 line-through">${{ number_format($deal->original_price, 2) }}</span>
                            <span class="text-green-600 font-bold ml-2 text-lg">${{ number_format($deal->sale_price, 2) }}</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Save ${{ number_format($deal->original_price - $deal->sale_price, 2) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $deal->type === 'flash' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $deal->type === 'clearance' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $deal->type === 'bundle' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $deal->type === 'vip' ? 'bg-purple-100 text-purple-800' : '' }}">
                            {{ ucfirst($deal->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($deal->isActive())
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            </div>
                        @elseif($deal->start_date > now())
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Scheduled</span>
                            </div>
                        @else
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Expired</span>
                            </div>
                        @endif
                        @if($deal->stock_limit)
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $deal->sold_count }}/{{ $deal->stock_limit }} sold
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="text-gray-900 font-medium">{{ $deal->start_date->format('M d, Y') }}</div>
                        <div class="text-gray-500">{{ $deal->start_date->format('h:i A') }}</div>
                        <div class="text-xs text-gray-400 mt-1">to {{ $deal->end_date->format('M d, Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.deals.show', $deal) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-medium hover:bg-blue-200 transition-colors">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <a href="{{ route('admin.deals.edit', $deal) }}" class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg text-xs font-medium hover:bg-indigo-200 transition-colors">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.deals.destroy', $deal) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-medium hover:bg-red-200 transition-colors" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-12 mx-8">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-tags text-white text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No deals created yet</h3>
                            <p class="text-gray-600 mb-6">Start creating amazing deals to boost your sales</p>
                            <a href="{{ route('admin.deals.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>Create Your First Deal
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($deals->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $deals->links() }}
    </div>
    @endif
</div>
@endsection