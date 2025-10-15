<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255'
        ]);

        $subscriber = NewsletterSubscriber::create([
            'email' => $request->email,
            'name' => $request->name,
            'is_active' => true,
            'subscribed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to newsletter!'
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:newsletter_subscribers,email'
        ]);

        $subscriber = NewsletterSubscriber::where('email', $request->email)->first();
        $subscriber->unsubscribe();

        return response()->json([
            'success' => true,
            'message' => 'Successfully unsubscribed from newsletter!'
        ]);
    }
}