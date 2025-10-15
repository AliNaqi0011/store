@extends('admin.layouts.app')

@section('title', 'Brands')
@section('page-title', 'Brand Management')
@section('page-description', 'Manage your product brands')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-4">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-tags mr-2"></i>
            {{ $brands->total() }} Total Brands
        </div>
    </div>
    <a href="{{ route('admin.brands.create') }}" 
       class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
        <i class="fas fa-plus mr-2"></i>Add New Brand
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($brands as $brand)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="w-10 h-10 rounded-lg object-cover mr-3">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white font-semibold text-sm">{{ substr($brand->name, 0, 2) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900">{{ $brand->name }}</div>
                                @if($brand->description)
                                    <div class="text-sm text-gray-500">{{ Str::limit($brand->description, 50) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $brand->products_count ?? 0 }} Products
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="toggleStatus({{ $brand->id }})" 
                                class="status-toggle {{ $brand->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1 rounded-full text-xs font-medium transition-colors">
                            {{ $brand->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $brand->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.brands.edit', $brand) }}" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this brand?')"
                                        class="text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-gray-500">
                            <i class="fas fa-tags text-4xl mb-4"></i>
                            <p class="text-lg font-medium">No brands found</p>
                            <p class="text-sm">Create your first brand to get started</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($brands->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $brands->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(brandId) {
    fetch(`/admin/brands/${brandId}/toggle-status`, {
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