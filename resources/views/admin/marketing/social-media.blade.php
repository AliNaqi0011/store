@extends('admin.layouts.app')

@section('title', 'Social Media Integration')
@section('page-title', 'Social Media Integration')
@section('page-description', 'Manage social media links and tracking codes')

@section('content')
<form action="{{ route('admin.marketing.update-social-media') }}" method="POST" class="space-y-8">
    @csrf
    
    <!-- Social Media Links -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Social Media Links</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook URL
                </label>
                <input type="url" name="facebook_url" value="{{ $socialSettings['facebook_url'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://facebook.com/yourpage">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter URL
                </label>
                <input type="url" name="twitter_url" value="{{ $socialSettings['twitter_url'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://twitter.com/youraccount">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram URL
                </label>
                <input type="url" name="instagram_url" value="{{ $socialSettings['instagram_url'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://instagram.com/youraccount">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-linkedin text-blue-700 mr-2"></i>LinkedIn URL
                </label>
                <input type="url" name="linkedin_url" value="{{ $socialSettings['linkedin_url'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://linkedin.com/company/yourcompany">
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube URL
                </label>
                <input type="url" name="youtube_url" value="{{ $socialSettings['youtube_url'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://youtube.com/channel/yourchannel">
            </div>
        </div>
    </div>
    
    <!-- Tracking Codes -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Tracking & Analytics</h3>
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook Pixel ID
                </label>
                <input type="text" name="facebook_pixel" value="{{ $socialSettings['facebook_pixel'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="123456789012345">
                <p class="text-sm text-gray-500 mt-1">Enter your Facebook Pixel ID for conversion tracking</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-google text-red-600 mr-2"></i>Google Analytics Tracking ID
                </label>
                <input type="text" name="google_analytics" value="{{ $socialSettings['google_analytics'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="G-XXXXXXXXXX or UA-XXXXXXXXX-X">
                <p class="text-sm text-gray-500 mt-1">Enter your Google Analytics tracking ID</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fab fa-google text-blue-600 mr-2"></i>Google Tag Manager ID
                </label>
                <input type="text" name="google_tag_manager" value="{{ $socialSettings['google_tag_manager'] }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="GTM-XXXXXXX">
                <p class="text-sm text-gray-500 mt-1">Enter your Google Tag Manager container ID</p>
            </div>
        </div>
    </div>
    
    <!-- Social Media Preview -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Social Media Preview</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-3">Active Social Links</h4>
                <div class="space-y-2">
                    @if($socialSettings['facebook_url'])
                        <a href="{{ $socialSettings['facebook_url'] }}" target="_blank" class="flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fab fa-facebook mr-2"></i>Facebook
                        </a>
                    @endif
                    @if($socialSettings['twitter_url'])
                        <a href="{{ $socialSettings['twitter_url'] }}" target="_blank" class="flex items-center text-blue-400 hover:text-blue-600">
                            <i class="fab fa-twitter mr-2"></i>Twitter
                        </a>
                    @endif
                    @if($socialSettings['instagram_url'])
                        <a href="{{ $socialSettings['instagram_url'] }}" target="_blank" class="flex items-center text-pink-600 hover:text-pink-800">
                            <i class="fab fa-instagram mr-2"></i>Instagram
                        </a>
                    @endif
                    @if($socialSettings['linkedin_url'])
                        <a href="{{ $socialSettings['linkedin_url'] }}" target="_blank" class="flex items-center text-blue-700 hover:text-blue-900">
                            <i class="fab fa-linkedin mr-2"></i>LinkedIn
                        </a>
                    @endif
                    @if($socialSettings['youtube_url'])
                        <a href="{{ $socialSettings['youtube_url'] }}" target="_blank" class="flex items-center text-red-600 hover:text-red-800">
                            <i class="fab fa-youtube mr-2"></i>YouTube
                        </a>
                    @endif
                </div>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-3">Tracking Status</h4>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Facebook Pixel</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $socialSettings['facebook_pixel'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $socialSettings['facebook_pixel'] ? 'Active' : 'Not Set' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Google Analytics</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $socialSettings['google_analytics'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $socialSettings['google_analytics'] ? 'Active' : 'Not Set' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Tag Manager</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $socialSettings['google_tag_manager'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $socialSettings['google_tag_manager'] ? 'Active' : 'Not Set' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-save mr-2"></i>Save Settings
        </button>
    </div>
</form>
@endsection