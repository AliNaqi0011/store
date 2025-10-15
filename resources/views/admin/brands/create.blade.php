@extends('admin.layouts.app')

@section('title', 'Create Brand')
@section('page-title', 'Create Brand')
@section('page-description', 'Add a new brand to your store')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Brand Information</h3>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Enter brand name">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Brand description (optional)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand Logo</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors" id="logoUploadArea">
                        <div class="space-y-2">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                            <p class="text-gray-600">Click to upload logo or drag and drop</p>
                            <p class="text-sm text-gray-500">Supported: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                        <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden">
                    </div>
                    <div id="logoPreview" class="mt-4 hidden">
                        <img id="previewImage" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active (Brand will be visible in store)
                    </label>
                </div>
            </div>
        </div>
        
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.brands.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            
            <button type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Create Brand
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const logoUploadArea = document.getElementById('logoUploadArea');
const logoInput = document.getElementById('logoInput');
const logoPreview = document.getElementById('logoPreview');
const previewImage = document.getElementById('previewImage');

logoUploadArea.addEventListener('click', () => logoInput.click());

logoInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            logoPreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush