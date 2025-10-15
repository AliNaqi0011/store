<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with(['items.product', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return OrderResource::collection($orders);
    }

    public function show(Request $request, $orderNumber)
    {
        $order = $request->user()
            ->orders()
            ->with(['items.product.images', 'items.variant'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return new OrderResource($order);
    }

    public function cancel(Request $request, $orderNumber)
    {
        $order = $request->user()
            ->orders()
            ->where('order_number', $orderNumber)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'delivered')
            ->firstOrFail();

        // Only allow cancellation if order is pending or confirmed
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json([
                'message' => 'Order cannot be cancelled at this stage'
            ], 400);
        }

        $order->update(['status' => 'cancelled']);

        // Restore stock if order was confirmed
        if ($order->status === 'confirmed') {
            foreach ($order->items as $item) {
                if ($item->product && $item->product->manage_stock) {
                    if ($item->product_variant_id) {
                        $item->variant?->increment('stock_quantity', $item->quantity);
                    } else {
                        $item->product->increment('stock_quantity', $item->quantity);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Order cancelled successfully',
            'order' => new OrderResource($order->fresh())
        ]);
    }
}