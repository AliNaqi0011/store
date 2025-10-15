<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $group = $request->get('group', 'general');
        
        $settings = SiteSetting::when($group !== 'all', function($query) use ($group) {
            return $query->where('group', $group);
        })->get()->groupBy('group');

        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            
            if ($setting) {
                $setting->update([
                    'value' => match($setting->type) {
                        'json' => json_encode($value),
                        'boolean' => $value ? '1' : '0',
                        default => (string) $value
                    }
                ]);
            }
        }

        return response()->json(['message' => 'Settings updated successfully']);
    }

    public function getPublicSettings()
    {
        $publicSettings = [
            'site_name' => SiteSetting::get('site_name', 'NexShop'),
            'site_logo' => SiteSetting::get('site_logo'),
            'site_favicon' => SiteSetting::get('site_favicon'),
            'primary_color' => SiteSetting::get('primary_color', '#3b82f6'),
            'secondary_color' => SiteSetting::get('secondary_color', '#8b5cf6'),
            'currency' => SiteSetting::get('currency', 'USD'),
            'currency_symbol' => SiteSetting::get('currency_symbol', '$'),
            'contact_email' => SiteSetting::get('contact_email'),
            'contact_phone' => SiteSetting::get('contact_phone'),
            'social_links' => SiteSetting::get('social_links', []),
            'footer_text' => SiteSetting::get('footer_text'),
            'maintenance_mode' => SiteSetting::get('maintenance_mode', false),
        ];

        return response()->json($publicSettings);
    }
}