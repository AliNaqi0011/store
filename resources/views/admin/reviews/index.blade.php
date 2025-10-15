@extends('admin.layouts.app')

@section('title', 'Reviews')
@section('page-title', 'Review Management')
@section('page-description', 'Moderate customer reviews and ratings')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-4">
        <div class="bg-gradient-to-r from-yellow-600 to-orange-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-star mr-2"></i>
            {{ $reviews->total() }} Total Reviews
        </div>
        
        <div class="flex space-x-2">
            <a href="{{ route('admin.reviews.index') }}" 
               class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                All
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg {{ request('status') === 'pending' ? 'bg-orange-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                Pending
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-lg {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                Approved
            </a>
        </div>
    </div>
    
    <div class="flex space-x-2">
        <button onclick="showBulkActions()" id="bulkActionBtn" class="bg-gray-600 text-white px-4 py-2 rounded-lg hidden">
            <i class="fas fa-tasks mr-2"></i>Bulk Actions
        </button>
    </div>
</div>

<form id="bulkForm" action="{{ route('admin.reviews.bulk-action') }}" method="POST" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
    @csrf
    <div class="flex items-center space-x-4">
        <select name="action" required class="px-3 py-2 border border-gray-300 rounded-lg">
            <option value="">Select Action</option>
            <option value="approve">Approve Selected</option>
            <option value="reject">Reject Selected</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Apply</button>
        <button type="button" onclick="hideBulkActions()" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Cancel</button>
    </div>
</form>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <input type="checkbox" id="selectAll" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <input type="checkbox" name="reviews[]" value="{{ $review->id }}" class="review-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                        </div>
                        @if($review->title)
                            <div class="font-medium text-gray-900 mb-1">{{ $review->title }}</div>
                        @endif
                        <div class="text-sm text-gray-600">{{ Str::limit($review->comment, 100) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $review->product->name }}</div>
                        <div class="text-sm text-gray-500">SKU: {{ $review->product->sku }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $review->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $review->user->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $review->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.reviews.show', $review) }}" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-800 transition-colors">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this review?')"
                                        class="text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-gray-500">
                            <i class="fas fa-star text-4xl mb-4"></i>
                            <p class="text-lg font-medium">No reviews found</p>
                            <p class="text-sm">Customer reviews will appear here</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($reviews->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
const selectAllCheckbox = document.getElementById('selectAll');
const reviewCheckboxes = document.querySelectorAll('.review-checkbox');
const bulkActionBtn = document.getElementById('bulkActionBtn');
const bulkForm = document.getElementById('bulkForm');

selectAllCheckbox.addEventListener('change', function() {
    reviewCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    toggleBulkActions();
});

reviewCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', toggleBulkActions);
});

function toggleBulkActions() {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    if (checkedBoxes.length > 0) {
        bulkActionBtn.classList.remove('hidden');
    } else {
        bulkActionBtn.classList.add('hidden');
        hideBulkActions();
    }
}

function showBulkActions() {
    bulkForm.classList.remove('hidden');
}

function hideBulkActions() {
    bulkForm.classList.add('hidden');
}

// Add selected review IDs to bulk form
document.getElementById('bulkForm').addEventListener('submit', function() {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    checkedBoxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'reviews[]';
        input.value = checkbox.value;
        this.appendChild(input);
    });
});
</script>
@endpush