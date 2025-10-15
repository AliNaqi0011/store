<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')
            ->active()
            ->rootCategories()
            ->orderBy('sort_order')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function show($slug)
    {
        $category = Category::with(['children', 'products.brand', 'products.images'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $products = $category->products()
            ->with(['brand', 'images'])
            ->active()
            ->inStock()
            ->paginate(12);

        return response()->json([
            'category' => new CategoryResource($category),
            'products' => ProductResource::collection($products),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }
}