@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('page-title', 'Coupon Management')
@section('page-description', 'Manage discount coupons and promotional codes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-4">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-ticket-alt mr-2"></i>
            {{ $coupons->total() }} Total Coupons
        </div>
    </div>
    <a href="{{ route('admin.coupons.create') }}" 
       class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
        <i class="fas fa-plus mr-2"></i>Create Coupon
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validity</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div>
                            <div class="font-mono font-bold text-lg text-blue-600">{{ $coupon->code }}</div>
                            <div class="text-sm text-gray-600">{{ $coupon->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($coupon->type === 'percentage')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-medium">
                                    {{ $coupon->value }}% OFF
                                </span>
                            @else
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium">
                                    ${{ $coupon->value }} OFF
                                </span>
                            @endif
                        </div>
                        @if($coupon->minimum_amount)
                            <div class="text-xs text-gray-500 mt-1">Min: ${{ $coupon->minimum_amount }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <span class="font-medium">{{ $coupon->used_count }}</span>
                            @if($coupon->usage_limit)
                                / {{ $coupon->usage_limit }}
                            @else
                                / ∞
                            @endif
                        </div>
                        @if($coupon->usage_limit)
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($coupon->used_count / $coupon->usage_limit) * 100 }}%"></div>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            @if($coupon->starts_at)
                                <div class="text-gray-600">From: {{ $coupon->starts_at->format('M d, Y') }}</div>
                            @endif
                            @if($coupon->expires_at)
                                <div class="text-gray-600">Until: {{ $coupon->expires_at->format('M d, Y') }}</div>
                            @else
                                <div class="text-green-600">No expiry</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="toggleStatus({{ $coupon->id }})" 
                                class="status-toggle {{ $coupon->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1 rounded-full text-xs font-medium transition-colors">
                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this coupon?')"
                                        class="text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="text-gray-500">
                            <i class="fas fa-ticket-alt text-4xl mb-4"></i>
                            <p class="text-lg font-medium">No coupons found</p>
                            <p class="text-sm">Create your first coupon to get started</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($coupons->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $coupons->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(couponId) {
    fetch(`/admin/coupons/${couponId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endpush