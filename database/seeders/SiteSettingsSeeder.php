<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'NexShop', 'group' => 'general', 'type' => 'text', 'label' => 'Site Name'],
            ['key' => 'site_tagline', 'value' => 'Your Premium E-Commerce Destination', 'group' => 'general', 'type' => 'text', 'label' => 'Site Tagline'],
            ['key' => 'site_description', 'value' => 'Premium e-commerce platform with quality products', 'group' => 'general', 'type' => 'textarea', 'label' => 'Site Description'],
            ['key' => 'contact_email', 'value' => 'support@nexshop.com', 'group' => 'general', 'type' => 'email', 'label' => 'Contact Email'],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'group' => 'general', 'type' => 'text', 'label' => 'Contact Phone'],
            
            // Theme Settings
            ['key' => 'primary_color', 'value' => '#3b82f6', 'group' => 'theme', 'type' => 'color', 'label' => 'Primary Color'],
            ['key' => 'secondary_color', 'value' => '#8b5cf6', 'group' => 'theme', 'type' => 'color', 'label' => 'Secondary Color'],
            ['key' => 'accent_color', 'value' => '#f59e0b', 'group' => 'theme', 'type' => 'color', 'label' => 'Accent Color'],
            ['key' => 'font_family', 'value' => 'Inter', 'group' => 'theme', 'type' => 'select', 'label' => 'Font Family'],
            ['key' => 'logo_url', 'value' => '', 'group' => 'theme', 'type' => 'url', 'label' => 'Logo URL'],
            ['key' => 'favicon_url', 'value' => '', 'group' => 'theme', 'type' => 'url', 'label' => 'Favicon URL'],
            
            // E-commerce Settings
            ['key' => 'currency_symbol', 'value' => '$', 'group' => 'ecommerce', 'type' => 'text', 'label' => 'Currency Symbol'],
            ['key' => 'tax_rate', 'value' => '10', 'group' => 'ecommerce', 'type' => 'number', 'label' => 'Tax Rate (%)'],
            ['key' => 'free_shipping_threshold', 'value' => '100', 'group' => 'ecommerce', 'type' => 'number', 'label' => 'Free Shipping Threshold'],
            ['key' => 'shipping_cost', 'value' => '10', 'group' => 'ecommerce', 'type' => 'number', 'label' => 'Standard Shipping Cost'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting + ['is_active' => true]
            );
        }
    }
}