@extends('admin.layouts.app')

@section('page-title', 'Create Deal')
@section('page-description', 'Create a new deal or promotion')

@section('content')
<div class="bg-white rounded-xl shadow-lg border border-gray-200">
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-6 rounded-t-xl">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold">Create New Deal</h3>
                <p class="text-blue-100 mt-1">Set up a promotional offer for your products</p>
            </div>
            <a href="{{ route('admin.deals.index') }}" class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Back to Deals
            </a>
        </div>
    </div>
    
    <form action="{{ route('admin.deals.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product *</label>
                    <select name="product_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deal Title *</label>
                    <input type="text" name="title" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Flash Sale - 50% Off">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deal description..."></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deal Type *</label>
                    <select name="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="flash">Flash Sale</option>
                        <option value="clearance">Clearance</option>
                        <option value="bundle">Bundle Deal</option>
                        <option value="vip">VIP Deal</option>
                    </select>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Original Price *</label>
                        <input type="number" name="original_price" step="0.01" min="0" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sale Price *</label>
                        <input type="number" name="sale_price" step="0.01" min="0" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0.00">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                        <input type="datetime-local" name="start_date" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                        <input type="datetime-local" name="end_date" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Limit</label>
                    <input type="number" name="stock_limit" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Leave empty for unlimited">
                    <p class="text-sm text-gray-500 mt-1">Maximum number of items available for this deal</p>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active Deal</label>
                </div>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.deals.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Create Deal</button>
        </div>
    </form>
</div>
@endsection