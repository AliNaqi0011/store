<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlistItems = $request->user()
            ->wishlists()
            ->with(['product.category', 'product.brand', 'product.images'])
            ->get();

        $products = $wishlistItems->map(function ($item) {
            return $item->product;
        });

        return ProductResource::collection($products);
    }

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $productId,
        ]);

        return response()->json([
            'message' => 'Product added to wishlist',
            'in_wishlist' => true,
        ]);
    }

    public function destroy(Request $request, $productId)
    {
        $request->user()
            ->wishlists()
            ->where('product_id', $productId)
            ->delete();

        return response()->json([
            'message' => 'Product removed from wishlist',
            'in_wishlist' => false,
        ]);
    }
}