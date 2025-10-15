@extends('admin.layouts.app')

@section('title', 'Newsletter Management')
@section('page-title', 'Newsletter Management')
@section('page-description', 'Manage newsletter subscribers and campaigns')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Total Subscribers</p>
                <p class="text-3xl font-bold">{{ number_format($stats['total']) }}</p>
            </div>
            <i class="fas fa-users text-4xl text-blue-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Active Subscribers</p>
                <p class="text-3xl font-bold">{{ number_format($stats['active']) }}</p>
            </div>
            <i class="fas fa-user-check text-4xl text-green-200"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">New This Month</p>
                <p class="text-3xl font-bold">{{ number_format($stats['this_month']) }}</p>
            </div>
            <i class="fas fa-user-plus text-4xl text-purple-200"></i>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-900">Subscribers List</h3>
    <a href="{{ route('admin.marketing.export-subscribers') }}" 
       class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
        <i class="fas fa-download mr-2"></i>Export CSV
    </a>
</div>

<!-- Subscribers Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed</th>
                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($subscribers as $subscriber)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $subscriber->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $subscriber->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $subscriber->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $subscriber->is_active ? 'Active' : 'Unsubscribed' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $subscriber->subscribed_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($subscriber->is_active)
                            <form action="{{ route('admin.marketing.unsubscribe', $subscriber) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to unsubscribe this user?')"
                                        class="text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fas fa-user-times"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-gray-500">
                            <i class="fas fa-envelope text-4xl mb-4"></i>
                            <p class="text-lg font-medium">No subscribers found</p>
                            <p class="text-sm">Newsletter subscribers will appear here</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($subscribers->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $subscribers->links() }}
    </div>
    @endif
</div>
@endsection