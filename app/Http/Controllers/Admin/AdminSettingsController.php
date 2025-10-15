<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function theme()
    {
        $themeSettings = SiteSetting::where('group', 'theme')->get();
        return view('admin.settings.theme', compact('themeSettings'));
    }

    public function updateTheme(Request $request)
    {
        $themeData = [
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'accent_color' => $request->accent_color,
            'font_family' => $request->font_family,
            'logo_url' => $request->logo_url,
            'favicon_url' => $request->favicon_url,
        ];

        foreach ($themeData as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key, 'group' => 'theme'],
                ['value' => $value, 'label' => ucfirst(str_replace('_', ' ', $key))]
            );
        }

        return redirect()->back()->with('success', 'Theme settings updated successfully');
    }

    public function pages()
    {
        $pages = \App\Models\Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function createPage()
    {
        return view('admin.pages.create');
    }

    public function storePage(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages',
            'content' => 'required',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        \App\Models\Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully');
    }
}