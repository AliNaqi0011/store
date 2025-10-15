<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'NexShop',
                'label' => 'Site Name',
                'description' => 'The name of your website',
                'type' => 'text',
                'group' => 'general'
            ],
            [
                'key' => 'site_description',
                'value' => 'Modern E-commerce Platform',
                'label' => 'Site Description',
                'description' => 'Brief description of your website',
                'type' => 'textarea',
                'group' => 'general'
            ],
            [
                'key' => 'site_logo',
                'value' => '/images/logo.png',
                'label' => 'Site Logo',
                'description' => 'URL to your site logo',
                'type' => 'text',
                'group' => 'general'
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@nexshop.com',
                'label' => 'Contact Email',
                'description' => 'Main contact email address',
                'type' => 'email',
                'group' => 'general'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1 (555) 123-4567',
                'label' => 'Contact Phone',
                'description' => 'Main contact phone number',
                'type' => 'text',
                'group' => 'general'
            ],

            // Theme Settings
            [
                'key' => 'primary_color',
                'value' => '#3B82F6',
                'label' => 'Primary Color',
                'description' => 'Main brand color',
                'type' => 'color',
                'group' => 'theme'
            ],
            [
                'key' => 'secondary_color',
                'value' => '#8B5CF6',
                'label' => 'Secondary Color',
                'description' => 'Secondary brand color',
                'type' => 'color',
                'group' => 'theme'
            ],
            [
                'key' => 'font_family',
                'value' => 'Inter',
                'label' => 'Font Family',
                'description' => 'Main font for the website',
                'type' => 'select',
                'group' => 'theme'
            ],

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/nexshop',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL',
                'type' => 'text',
                'group' => 'social'
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/nexshop',
                'label' => 'Twitter URL',
                'description' => 'Twitter profile URL',
                'type' => 'text',
                'group' => 'social'
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/nexshop',
                'label' => 'Instagram URL',
                'description' => 'Instagram profile URL',
                'type' => 'text',
                'group' => 'social'
            ],

            // E-commerce Settings
            [
                'key' => 'currency',
                'value' => 'USD',
                'label' => 'Currency',
                'description' => 'Default currency code',
                'type' => 'text',
                'group' => 'ecommerce'
            ],
            [
                'key' => 'tax_rate',
                'value' => '10',
                'label' => 'Tax Rate (%)',
                'description' => 'Default tax rate percentage',
                'type' => 'text',
                'group' => 'ecommerce'
            ],
            [
                'key' => 'free_shipping_threshold',
                'value' => '100',
                'label' => 'Free Shipping Threshold',
                'description' => 'Minimum order amount for free shipping',
                'type' => 'text',
                'group' => 'ecommerce'
            ],
            [
                'key' => 'enable_reviews',
                'value' => '1',
                'label' => 'Enable Reviews',
                'description' => 'Allow customers to leave product reviews',
                'type' => 'boolean',
                'group' => 'ecommerce'
            ]
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}