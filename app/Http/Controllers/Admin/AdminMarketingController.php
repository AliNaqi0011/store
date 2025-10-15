<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Models\SeoSetting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdminMarketingController extends Controller
{
    public function newsletter()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(15);
        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::active()->count(),
            'this_month' => NewsletterSubscriber::whereMonth('created_at', now()->month)->count()
        ];
        
        return view('admin.marketing.newsletter', compact('subscribers', 'stats'));
    }

    public function exportSubscribers()
    {
        $subscribers = NewsletterSubscriber::active()->get();
        
        $csv = "Email,Name,Subscribed Date\n";
        foreach ($subscribers as $subscriber) {
            $csv .= "{$subscriber->email},{$subscriber->name},{$subscriber->subscribed_at}\n";
        }
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="newsletter_subscribers.csv"');
    }

    public function seo()
    {
        $seoSettings = SeoSetting::all()->groupBy('page_type');
        return view('admin.marketing.seo', compact('seoSettings'));
    }

    public function storeSeo(Request $request)
    {
        $request->validate([
            'page_type' => 'required|string',
            'page_id' => 'nullable|string',
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('og_image');
        
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        SeoSetting::updateOrCreate(
            ['page_type' => $request->page_type, 'page_id' => $request->page_id],
            $data
        );

        return redirect()->back()->with('success', 'SEO settings updated successfully!');
    }

    public function socialMedia()
    {
        $socialSettings = [
            'facebook_url' => SiteSetting::getValue('facebook_url'),
            'twitter_url' => SiteSetting::getValue('twitter_url'),
            'instagram_url' => SiteSetting::getValue('instagram_url'),
            'linkedin_url' => SiteSetting::getValue('linkedin_url'),
            'youtube_url' => SiteSetting::getValue('youtube_url'),
            'facebook_pixel' => SiteSetting::getValue('facebook_pixel'),
            'google_analytics' => SiteSetting::getValue('google_analytics'),
            'google_tag_manager' => SiteSetting::getValue('google_tag_manager')
        ];
        
        return view('admin.marketing.social-media', compact('socialSettings'));
    }

    public function updateSocialMedia(Request $request)
    {
        $settings = [
            'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url',
            'facebook_pixel', 'google_analytics', 'google_tag_manager'
        ];

        foreach ($settings as $setting) {
            SiteSetting::setValue($setting, $request->input($setting));
        }

        return redirect()->back()->with('success', 'Social media settings updated successfully!');
    }

    public function unsubscribeNewsletter(NewsletterSubscriber $subscriber)
    {
        $subscriber->unsubscribe();
        return redirect()->back()->with('success', 'Subscriber unsubscribed successfully!');
    }
}