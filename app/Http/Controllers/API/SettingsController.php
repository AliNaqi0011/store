<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    public function getPublicSettings()
    {
        $settings = SiteSetting::where('is_active', true)->get()->pluck('value', 'key');
        
        return response()->json([
            'site_name' => $settings['site_name'] ?? 'NexShop',
            'site_tagline' => $settings['site_tagline'] ?? 'Your Premium E-Commerce Destination',
            'primary_color' => $settings['primary_color'] ?? '#3b82f6',
            'secondary_color' => $settings['secondary_color'] ?? '#8b5cf6',
            'accent_color' => $settings['accent_color'] ?? '#f59e0b',
            'font_family' => $settings['font_family'] ?? 'Inter',
            'logo_url' => $settings['logo_url'] ?? null,
            'favicon_url' => $settings['favicon_url'] ?? null,
            'contact_email' => $settings['contact_email'] ?? 'support@nexshop.com',
            'contact_phone' => $settings['contact_phone'] ?? '+1 (555) 123-4567',
            'social_links' => json_decode($settings['social_links'] ?? '{}', true),
            'currency_symbol' => $settings['currency_symbol'] ?? '$',
        ]);
    }
}