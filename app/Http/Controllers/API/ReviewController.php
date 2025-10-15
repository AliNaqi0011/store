<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        $review = $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'is_approved' => true,
        ]);

        // Update product rating
        $this->updateProductRating($product);

        return response()->json([
            'success' => true,
            'message' => 'Review added successfully',
            'data' => $review->load('user')
        ], 201);
    }

    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->with('user')
            ->where('is_approved', true)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    private function updateProductRating(Product $product)
    {
        $avgRating = $product->reviews()
            ->where('is_approved', true)
            ->avg('rating');
        
        $reviewsCount = $product->reviews()
            ->where('is_approved', true)
            ->count();

        $product->update([
            'rating' => round($avgRating, 1),
            'reviews_count' => $reviewsCount
        ]);
    }
}