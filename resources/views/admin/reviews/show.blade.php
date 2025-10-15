@extends('admin.layouts.app')

@section('title', 'Review Details')
@section('page-title', 'Review Details')
@section('page-description', 'View and moderate customer review')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.reviews.index') }}" 
           class="text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Reviews
        </a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Review Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Review Content</h3>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                        {{ $review->is_approved ? 'Approved' : 'Pending Approval' }}
                    </span>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-2xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                        <span class="ml-3 text-xl font-medium text-gray-900">{{ $review->rating }}/5</span>
                    </div>
                    
                    @if($review->title)
                    <div>
                        <h4 class="font-medium text-gray-900 text-lg">{{ $review->title }}</h4>
                    </div>
                    @endif
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                    
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar mr-2"></i>
                        Submitted on {{ $review->created_at->format('F d, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>
            
            <!-- Moderation Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Moderation Actions</h3>
                
                <div class="flex space-x-4">
                    @if(!$review->is_approved)
                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-check mr-2"></i>Approve Review
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition-colors">
                                <i class="fas fa-times mr-2"></i>Reject Review
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this review? This action cannot be undone.')"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>Delete Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-semibold text-sm">{{ substr($review->user->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $review->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $review->user->email }}</div>
                        </div>
                    </div>
                    
                    <div class="pt-3 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Total Reviews:</span>
                                <span class="font-medium">{{ $review->user->reviews()->count() }}</span>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span>Member Since:</span>
                                <span class="font-medium">{{ $review->user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h3>
                
                <div class="space-y-3">
                    @if($review->product->primary_image)
                        <img src="{{ asset('storage/' . $review->product->primary_image) }}" 
                             alt="{{ $review->product->name }}" 
                             class="w-full h-32 object-cover rounded-lg">
                    @endif
                    
                    <div>
                        <div class="font-medium text-gray-900">{{ $review->product->name }}</div>
                        <div class="text-sm text-gray-500">SKU: {{ $review->product->sku }}</div>
                        <div class="text-sm text-gray-500">Price: ${{ $review->product->price }}</div>
                    </div>
                    
                    <div class="pt-3 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Total Reviews:</span>
                                <span class="font-medium">{{ $review->product->reviews()->count() }}</span>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span>Average Rating:</span>
                                <span class="font-medium">{{ number_format($review->product->reviews()->avg('rating'), 1) }}/5</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.products.edit', $review->product) }}" 
                       class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        View Product
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection