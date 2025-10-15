<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user'])->latest();
        
        if ($request->status === 'pending') {
            $query->where('is_approved', false);
        } elseif ($request->status === 'approved') {
            $query->where('is_approved', true);
        }
        
        $reviews = $query->paginate(15);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['product', 'user']);
        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    public function reject(Review $review)
    {
        $review->update(['is_approved' => false]);
        return redirect()->back()->with('success', 'Review rejected successfully!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'reviews' => 'required|array',
            'reviews.*' => 'exists:reviews,id'
        ]);

        $reviews = Review::whereIn('id', $request->reviews);

        switch ($request->action) {
            case 'approve':
                $reviews->update(['is_approved' => true]);
                $message = 'Reviews approved successfully!';
                break;
            case 'reject':
                $reviews->update(['is_approved' => false]);
                $message = 'Reviews rejected successfully!';
                break;
            case 'delete':
                $reviews->delete();
                $message = 'Reviews deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}