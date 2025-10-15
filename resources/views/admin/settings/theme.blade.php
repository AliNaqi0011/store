@extends('admin.layouts.app')

@section('title', 'Theme Settings')
@section('page-title', 'Theme Settings')
@section('page-description', 'Customize your website appearance')

@section('content')
<div class="space-y-6">
    <!-- Live Preview -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Live Preview</h3>
        <div id="theme-preview" class="border-2 border-gray-200 rounded-xl p-6 min-h-64">
            <div class="flex items-center space-x-3 mb-4">
                <div id="preview-logo" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-white"></i>
                </div>
                <span id="preview-title" class="text-2xl font-bold text-blue-600">NexShop</span>
            </div>
            <div class="space-y-3">
                <div id="preview-button" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg">Sample Button</div>
                <div class="text-gray-600">This is how your website will look with the selected theme.</div>
            </div>
        </div>
    </div>

    <!-- Theme Settings Form -->
    <form action="{{ route('admin.settings.theme.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Colors -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-palette mr-2 text-purple-600"></i>
                Color Scheme
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                    <div class="flex items-center space-x-3">
                        <input type="color" name="primary_color" id="primary_color" value="#3b82f6"
                               class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer"
                               onchange="updatePreview()">
                        <input type="text" id="primary_color_text" value="#3b82f6"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Color</label>
                    <div class="flex items-center space-x-3">
                        <input type="color" name="secondary_color" id="secondary_color" value="#8b5cf6"
                               class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer"
                               onchange="updatePreview()">
                        <input type="text" id="secondary_color_text" value="#8b5cf6"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Accent Color</label>
                    <div class="flex items-center space-x-3">
                        <input type="color" name="accent_color" id="accent_color" value="#f59e0b"
                               class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer"
                               onchange="updatePreview()">
                        <input type="text" id="accent_color_text" value="#f59e0b"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Typography -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-font mr-2 text-blue-600"></i>
                Typography
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Font Family</label>
                    <select name="font_family" id="font_family" onchange="updatePreview()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Inter">Inter</option>
                        <option value="Roboto">Roboto</option>
                        <option value="Open Sans">Open Sans</option>
                        <option value="Poppins">Poppins</option>
                        <option value="Montserrat">Montserrat</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Logo & Branding -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-image mr-2 text-green-600"></i>
                Logo & Branding
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo URL</label>
                    <input type="url" name="logo_url" id="logo_url"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://example.com/logo.png">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Favicon URL</label>
                    <input type="url" name="favicon_url" id="favicon_url"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://example.com/favicon.ico">
                </div>
            </div>
        </div>

        <!-- Predefined Themes -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-swatchbook mr-2 text-indigo-600"></i>
                Predefined Themes
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="theme-option border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition-colors" 
                     onclick="applyTheme('blue', '#3b82f6', '#1d4ed8', '#f59e0b')">
                    <div class="flex space-x-2 mb-2">
                        <div class="w-4 h-4 bg-blue-500 rounded"></div>
                        <div class="w-4 h-4 bg-blue-700 rounded"></div>
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                    </div>
                    <p class="font-medium">Ocean Blue</p>
                </div>
                
                <div class="theme-option border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-purple-500 transition-colors"
                     onclick="applyTheme('purple', '#8b5cf6', '#7c3aed', '#f59e0b')">
                    <div class="flex space-x-2 mb-2">
                        <div class="w-4 h-4 bg-purple-500 rounded"></div>
                        <div class="w-4 h-4 bg-purple-700 rounded"></div>
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                    </div>
                    <p class="font-medium">Royal Purple</p>
                </div>
                
                <div class="theme-option border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-green-500 transition-colors"
                     onclick="applyTheme('green', '#10b981', '#059669', '#f59e0b')">
                    <div class="flex space-x-2 mb-2">
                        <div class="w-4 h-4 bg-green-500 rounded"></div>
                        <div class="w-4 h-4 bg-green-600 rounded"></div>
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                    </div>
                    <p class="font-medium">Forest Green</p>
                </div>
                
                <div class="theme-option border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-red-500 transition-colors"
                     onclick="applyTheme('red', '#ef4444', '#dc2626', '#f59e0b')">
                    <div class="flex space-x-2 mb-2">
                        <div class="w-4 h-4 bg-red-500 rounded"></div>
                        <div class="w-4 h-4 bg-red-600 rounded"></div>
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                    </div>
                    <p class="font-medium">Crimson Red</p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="resetTheme()" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                Reset to Default
            </button>
            <button type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Theme
            </button>
        </div>
    </form>
</div>

<script>
function updatePreview() {
    const primaryColor = document.getElementById('primary_color').value;
    const secondaryColor = document.getElementById('secondary_color').value;
    const fontFamily = document.getElementById('font_family').value;
    
    // Update preview elements
    document.getElementById('preview-logo').style.backgroundColor = primaryColor;
    document.getElementById('preview-title').style.color = primaryColor;
    document.getElementById('preview-button').style.backgroundColor = primaryColor;
    document.getElementById('theme-preview').style.fontFamily = fontFamily;
    
    // Update text inputs
    document.getElementById('primary_color_text').value = primaryColor;
    document.getElementById('secondary_color_text').value = secondaryColor;
    document.getElementById('accent_color_text').value = document.getElementById('accent_color').value;
}

function applyTheme(name, primary, secondary, accent) {
    document.getElementById('primary_color').value = primary;
    document.getElementById('secondary_color').value = secondary;
    document.getElementById('accent_color').value = accent;
    updatePreview();
}

function resetTheme() {
    document.getElementById('primary_color').value = '#3b82f6';
    document.getElementById('secondary_color').value = '#8b5cf6';
    document.getElementById('accent_color').value = '#f59e0b';
    document.getElementById('font_family').value = 'Inter';
    updatePreview();
}

// Initialize preview
updatePreview();
</script>
@endsection