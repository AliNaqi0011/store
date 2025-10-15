@extends('admin.layouts.app')

@section('page-title', 'Contact Message Details')
@section('page-description', 'View and manage contact message')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Message from {{ $contact->first_name }} {{ $contact->last_name }}</h3>
        <a href="{{ route('admin.contacts.index') }}" class="text-blue-600 hover:text-blue-900">← Back to Messages</a>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Message Content -->
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $contact->subject }}</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info & Actions -->
            <div class="space-y-6">
                <!-- Contact Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-3">Contact Information</h5>
                    <div class="space-y-2">
                        <div>
                            <span class="text-sm text-gray-600">Name:</span>
                            <p class="font-medium">{{ $contact->first_name }} {{ $contact->last_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Email:</span>
                            <p class="font-medium">{{ $contact->email }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Date:</span>
                            <p class="font-medium">{{ $contact->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Status Update -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-3">Status</h5>
                    <form action="{{ route('admin.contacts.status', $contact) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                        </select>
                    </form>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-900 mb-3">Quick Actions</h5>
                    <div class="space-y-2">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-reply mr-2"></i>Reply via Email
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this message?')"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class="fas fa-trash mr-2"></i>Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection