@extends('admin.layouts.app')

@section('title', 'SEO Management')
@section('page-title', 'SEO Management')
@section('page-description', 'Manage meta tags and SEO settings')

@section('content')
<!-- SEO Form -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Add/Update SEO Settings</h3>
    
    <form action="{{ route('admin.marketing.store-seo') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Page Type *</label>
                <select name="page_type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Page Type</option>
                    <option value="home">Home Page</option>
                    <option value="products">Products Page</option>
                    <option value="categories">Categories Page</option>
                    <option value="about">About Page</option>
                    <option value="contact">Contact Page</option>
                    <option value="blog">Blog Page</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Page ID (Optional)</label>
                <input type="text" name="page_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Specific page/product/category ID">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title * (Max 60 chars)</label>
            <input type="text" name="meta_title" required maxlength="60" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="SEO optimized title">
            <div class="text-sm text-gray-500 mt-1">Characters: <span id="titleCount">0</span>/60</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description * (Max 160 chars)</label>
            <textarea name="meta_description" required maxlength="160" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="SEO optimized description"></textarea>
            <div class="text-sm text-gray-500 mt-1">Characters: <span id="descCount">0</span>/160</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="keyword1, keyword2, keyword3">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Open Graph Title</label>
                <input type="text" name="og_title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Social media title">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Open Graph Image</label>
                <input type="file" name="og_image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Open Graph Description</label>
            <textarea name="og_description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Social media description"></textarea>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Custom Head Tags</label>
            <textarea name="custom_head_tags" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="<script>, <link>, or other custom head tags"></textarea>
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-save mr-2"></i>Save SEO Settings
        </button>
    </form>
</div>

<!-- Existing SEO Settings -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Current SEO Settings</h3>
    </div>
    
    @forelse($seoSettings as $pageType => $settings)
    <div class="border-b border-gray-200 last:border-b-0">
        <div class="px-6 py-4">
            <h4 class="font-medium text-gray-900 mb-3 capitalize">{{ str_replace('_', ' ', $pageType) }}</h4>
            
            @foreach($settings as $setting)
            <div class="bg-gray-50 rounded-lg p-4 mb-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Meta Title:</span>
                        <p class="text-gray-600">{{ $setting->meta_title }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Meta Description:</span>
                        <p class="text-gray-600">{{ Str::limit($setting->meta_description, 100) }}</p>
                    </div>
                    @if($setting->page_id)
                    <div>
                        <span class="font-medium text-gray-700">Page ID:</span>
                        <p class="text-gray-600">{{ $setting->page_id }}</p>
                    </div>
                    @endif
                    <div>
                        <span class="font-medium text-gray-700">Last Updated:</span>
                        <p class="text-gray-600">{{ $setting->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="px-6 py-12 text-center">
        <div class="text-gray-500">
            <i class="fas fa-search text-4xl mb-4"></i>
            <p class="text-lg font-medium">No SEO settings found</p>
            <p class="text-sm">Add your first SEO configuration above</p>
        </div>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
document.querySelector('input[name="meta_title"]').addEventListener('input', function() {
    document.getElementById('titleCount').textContent = this.value.length;
});

document.querySelector('textarea[name="meta_description"]').addEventListener('input', function() {
    document.getElementById('descCount').textContent = this.value.length;
});
</script>
@endpush