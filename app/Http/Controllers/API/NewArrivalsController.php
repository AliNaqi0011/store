<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class NewArrivalsController extends Controller
{
    public function index()
    {
        $newArrivals = Product::newArrivals()
            ->active()
            ->with(['category', 'brand', 'images'])
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $newArrivals
        ]);
    }
}