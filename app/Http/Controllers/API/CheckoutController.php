<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'billing_address' => 'required|array',
            'billing_address.first_name' => 'required|string|max:50',
            'billing_address.last_name' => 'required|string|max:50',
            'billing_address.email' => 'required|email|max:100',
            'billing_address.phone' => 'required|string|min:10|max:15',
            'billing_address.address_line_1' => 'required|string|max:255',
            'billing_address.address_line_2' => 'nullable|string|max:255',
            'billing_address.city' => 'required|string|max:100',
            'billing_address.state' => 'required|string|max:100',
            'billing_address.postal_code' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:100',
            'shipping_address' => 'required|array',
            'shipping_address.first_name' => 'required|string|max:50',
            'shipping_address.last_name' => 'required|string|max:50',
            'shipping_address.phone' => 'required|string|min:10|max:15',
            'shipping_address.address_line_1' => 'required|string|max:255',
            'shipping_address.address_line_2' => 'nullable|string|max:255',
            'shipping_address.city' => 'required|string|max:100',
            'shipping_address.state' => 'required|string|max:100',
            'shipping_address.postal_code' => 'required|string|max:20',
            'shipping_address.country' => 'required|string|max:100',
            'payment_method' => 'required|string|in:stripe,cod',
            'coupon_code' => 'nullable|string|exists:coupons,code',
            'notes' => 'nullable|string|max:500',
            'cart_items' => 'required|array|min:1',
            'cart_items.*.product_id' => 'required|exists:products,id',
            'cart_items.*.variant_id' => 'nullable|exists:product_variants,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
        ]);

        $cartItems = $request->cart_items;
        if (empty($cartItems)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        return DB::transaction(function () use ($request, $cartItems) {
            $subtotal = 0;
            $orderItems = [];

            // Calculate subtotal and prepare order items
            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['product_id']);
                $variant = $item['variant_id'] ? ProductVariant::findOrFail($item['variant_id']) : null;
                
                // Validate stock availability
                if ($product->manage_stock) {
                    $stockQuantity = $variant ? $variant->stock_quantity : $product->stock_quantity;
                    if ($item['quantity'] > $stockQuantity) {
                        return response()->json([
                            'message' => "Insufficient stock for {$product->name}. Only {$stockQuantity} available."
                        ], 400);
                    }
                }
                
                $price = $variant ? $variant->price : $product->price;
                $itemTotal = $price * $item['quantity'];
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_variant_id' => $variant?->id,
                    'product_name' => $product->name,
                    'product_sku' => $variant ? $variant->sku : $product->sku,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                    'product_options' => $variant ? $variant->attributeValues->map(function ($value) {
                        return [
                            'attribute' => $value->attribute->name,
                            'value' => $value->value,
                        ];
                    })->toArray() : null,
                ];
            }

            // Apply coupon discount
            $discountAmount = 0;
            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)->valid()->first();
                if ($coupon) {
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                    $coupon->increment('used_count');
                }
            }

            // Calculate totals
            $taxAmount = $subtotal * 0.1; // 10% tax
            $shippingAmount = $subtotal > 100 ? 0 : 10; // Free shipping over $100
            $totalAmount = $subtotal + $taxAmount + $shippingAmount - $discountAmount;

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'currency' => 'USD',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'billing_address' => $request->billing_address,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            // Handle payment method
            if ($request->payment_method === 'cod') {
                // Cash on Delivery - Order confirmed immediately
                $order->update([
                    'status' => 'confirmed',
                    'payment_status' => 'pending'
                ]);
                
                // Reduce stock for managed products
                foreach ($cartItems as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product && $product->manage_stock) {
                        if ($item['variant_id']) {
                            $variant = ProductVariant::find($item['variant_id']);
                            if ($variant) {
                                $variant->decrement('stock_quantity', $item['quantity']);
                            }
                        } else {
                            $product->decrement('stock_quantity', $item['quantity']);
                        }
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully with Cash on Delivery',
                    'order' => $order->load('items'),
                ]);
            } else {
                // Stripe Payment
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $totalAmount * 100,
                    'currency' => 'usd',
                    'metadata' => [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                    ],
                ]);

                $order->update(['payment_intent_id' => $paymentIntent->id]);

                return response()->json([
                    'success' => true,
                    'order' => $order->load('items'),
                    'client_secret' => $paymentIntent->client_secret,
                ]);
            }
        });
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)->valid()->first();

        if (!$coupon) {
            return response()->json(['message' => 'Invalid coupon code'], 400);
        }

        $discount = $coupon->calculateDiscount($request->subtotal);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'coupon' => [
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ],
        ]);
    }

    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event['type'] === 'payment_intent.succeeded') {
            $paymentIntent = $event['data']['object'];
            $order = Order::where('payment_intent_id', $paymentIntent['id'])->first();
            
            if ($order) {
                $order->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid'
                ]);
                
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product && $product->manage_stock) {
                        if ($item->product_variant_id) {
                            $variant = ProductVariant::find($item->product_variant_id);
                            if ($variant) {
                                $variant->decrement('stock_quantity', $item->quantity);
                            }
                        } else {
                            $product->decrement('stock_quantity', $item->quantity);
                        }
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}