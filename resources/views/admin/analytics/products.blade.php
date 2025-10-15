@extends('admin.layouts.app')

@section('title', 'Product Analytics')
@section('page-title', 'Product Analytics')
@section('page-description', 'Product performance and inventory insights')

@section('content')
<!-- Performance Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Best Sellers -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
            <h3 class="text-lg font-semibold text-green-900">Top Performing Products</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($productData['performance']['best_sellers']->take(10) as $product)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <div class="font-medium text-gray-900">{{ Str::limit($product->name, 30) }}</div>
                        <div class="text-sm text-gray-500">${{ $product->price }} • {{ $product->total_sold }} sold</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-green-600">${{ number_format($product->revenue, 2) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Worst Performers -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
            <h3 class="text-lg font-semibold text-red-900">Products Needing Attention</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($productData['performance']['worst_performers']->take(10) as $product)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <div class="font-medium text-gray-900">{{ Str::limit($product->name, 30) }}</div>
                        <div class="text-sm text-gray-500">${{ $product->price }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-red-600">{{ $product->total_sold }} sold</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Inventory Analytics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm">Low Stock</p>
                <p class="text-3xl font-bold">{{ $productData['inventory']['low_stock']->count() }}</p>
            </div>
            <i class="fas fa-exclamation-triangle text-4xl text-red-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm">Out of Stock</p>
                <p class="text-3xl font-bold">{{ $productData['inventory']['out_of_stock'] }}</p>
            </div>
            <i class="fas fa-times-circle text-4xl text-orange-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-yellow-600 to-orange-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm">Overstocked</p>
                <p class="text-3xl font-bold">{{ $productData['inventory']['overstocked'] }}</p>
            </div>
            <i class="fas fa-warehouse text-4xl text-yellow-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Inventory Value</p>
                <p class="text-2xl font-bold">${{ number_format($productData['inventory']['inventory_value'], 0) }}</p>
            </div>
            <i class="fas fa-dollar-sign text-4xl text-green-200"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Low Stock Alert -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
            <h3 class="text-lg font-semibold text-red-900">Low Stock Alert</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($productData['inventory']['low_stock']->take(10) as $product)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ Str::limit($product->name, 40) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $product->stock_quantity == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Review Analytics -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Review Analytics</h3>
        
        <div class="space-y-4">
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-600">Average Rating</span>
                <div class="flex items-center">
                    <span class="font-semibold text-gray-900 mr-2">{{ number_format($productData['reviews']['avg_rating'], 1) }}</span>
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($productData['reviews']['avg_rating']) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-600">Total Reviews</span>
                <span class="font-semibold text-gray-900">{{ number_format($productData['reviews']['total_reviews']) }}</span>
            </div>
            
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-600">Pending Reviews</span>
                <span class="font-semibold text-orange-600">{{ number_format($productData['reviews']['pending_reviews']) }}</span>
            </div>
            
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="text-gray-600">Products Without Reviews</span>
                <span class="font-semibold text-red-600">{{ number_format($productData['reviews']['products_without_reviews']) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Category Performance -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Category Performance</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Sold</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($productData['categories'] as $category)
                <tr>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $category->product_count }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ number_format($category->total_sold) }}</td>
                    <td class="px-6 py-4 font-semibold text-green-600">${{ number_format($category->revenue, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection