<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }
        
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::with(['images', 'brand'])->find($item['product_id']);
            $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;
            
            if ($product) {
                $price = $variant ? $variant->price : $product->price;
                $itemTotal = $price * $item['quantity'];
                $total += $itemTotal;

                $cartItems[] = [
                    'id' => $id,
                    'product_id' => $product->id,
                    'variant_id' => $variant?->id,
                    'name' => $product->name,
                    'sku' => $variant ? $variant->sku : $product->sku,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                    'image' => $product->images->where('is_primary', true)->first()?->image_path,
                    'brand' => $product->brand?->name,
                    'variant_attributes' => $variant ? $variant->attributeValues->map(function ($value) {
                        return [
                            'attribute' => $value->attribute->name,
                            'value' => $value->value,
                        ];
                    }) : [],
                ];
            }
        }

        return response()->json([
            'items' => $cartItems,
            'count' => array_sum(array_column($cart, 'quantity')),
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductVariant::findOrFail($request->variant_id) : null;

        // Check if product is active
        if (!$product->is_active) {
            return response()->json(['message' => 'Product is not available'], 400);
        }

        // Check stock only if stock is managed
        if ($product->manage_stock) {
            $stockQuantity = $variant ? $variant->stock_quantity : $product->stock_quantity;
            if ($stockQuantity <= 0) {
                return response()->json(['message' => 'Product is out of stock'], 400);
            }
            if ($request->quantity > $stockQuantity) {
                return response()->json(['message' => 'Insufficient stock. Only ' . $stockQuantity . ' items available'], 400);
            }
        }

        $cart = session()->get('cart', []);
        $cartKey = $request->product_id . ($variant ? '_' . $variant->id : '');

        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $request->quantity;
            
            // Check total quantity against stock if managed
            if ($product->manage_stock) {
                $stockQuantity = $variant ? $variant->stock_quantity : $product->stock_quantity;
                if ($newQuantity > $stockQuantity) {
                    return response()->json(['message' => 'Cannot add more items. Total would exceed available stock'], 400);
                }
            }
            
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);
        session()->save(); // Force session save

        return response()->json([
            'message' => 'Item added to cart',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json(['message' => 'Item not found in cart'], 404);
        }

        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return response()->json(['message' => 'Cart updated']);
    }

    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Item removed from cart']);
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json(['message' => 'Cart cleared']);
    }
}