@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')
@section('page-description', 'Manage your website configuration')

@section('content')
<div class="space-y-8">
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-6 rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all transform hover:scale-105 cursor-pointer">
            <div class="flex items-center space-x-3">
                <i class="fas fa-palette text-2xl"></i>
                <div>
                    <h3 class="font-semibold">Theme Settings</h3>
                    <p class="text-sm opacity-90">Colors, fonts, logo</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white p-6 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all transform hover:scale-105 cursor-pointer">
            <div class="flex items-center space-x-3">
                <i class="fas fa-file-alt text-2xl"></i>
                <div>
                    <h3 class="font-semibold">Pages</h3>
                    <p class="text-sm opacity-90">Manage website pages</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white p-6 rounded-xl hover:from-green-600 hover:to-teal-600 transition-all transform hover:scale-105 cursor-pointer">
            <div class="flex items-center space-x-3">
                <i class="fas fa-bars text-2xl"></i>
                <div>
                    <h3 class="font-semibold">Navigation</h3>
                    <p class="text-sm opacity-90">Menu management</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6 rounded-xl hover:from-orange-600 hover:to-red-600 transition-all transform hover:scale-105 cursor-pointer">
            <div class="flex items-center space-x-3">
                <i class="fas fa-search text-2xl"></i>
                <div>
                    <h3 class="font-semibold">SEO Settings</h3>
                    <p class="text-sm opacity-90">Meta tags, sitemap</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        
        @foreach($settings as $group => $groupSettings)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 capitalize flex items-center">
                <i class="fas fa-cog mr-2 text-blue-600"></i>
                {{ str_replace('_', ' ', $group) }} Settings
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($groupSettings as $setting)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $setting->label }}
                        @if($setting->description)
                            <span class="text-xs text-gray-500 block">{{ $setting->description }}</span>
                        @endif
                    </label>
                    
                    @if($setting->type === 'textarea')
                        <textarea name="settings[{{ $setting->key }}]" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="{{ $setting->label }}">{{ $setting->value }}</textarea>
                    
                    @elseif($setting->type === 'boolean')
                        <div class="flex items-center">
                            <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" 
                                   {{ $setting->value ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Enable {{ $setting->label }}</label>
                        </div>
                    
                    @elseif($setting->type === 'color')
                        <div class="flex items-center space-x-3">
                            <input type="color" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"
                                   class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ $setting->value }}"
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="#000000" readonly>
                        </div>
                    
                    @elseif($setting->type === 'select')
                        <select name="settings[{{ $setting->key }}]"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Inter" {{ $setting->value === 'Inter' ? 'selected' : '' }}>Inter</option>
                            <option value="Roboto" {{ $setting->value === 'Roboto' ? 'selected' : '' }}>Roboto</option>
                            <option value="Open Sans" {{ $setting->value === 'Open Sans' ? 'selected' : '' }}>Open Sans</option>
                            <option value="Poppins" {{ $setting->value === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                        </select>
                    
                    @else
                        <input type="{{ $setting->type === 'email' ? 'email' : 'text' }}" 
                               name="settings[{{ $setting->key }}]" 
                               value="{{ $setting->value }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="{{ $setting->label }}">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection