<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $query = Deal::with('product')
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $deals = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $deals->map(function ($deal) {
                return [
                    'id' => $deal->id,
                    'title' => $deal->title,
                    'description' => $deal->description,
                    'product' => [
                        'id' => $deal->product->id,
                        'name' => $deal->product->name,
                        'slug' => $deal->product->slug,
                        'image' => $deal->product->primary_image ? url($deal->product->primary_image) : null,
                        'images' => $deal->product->images
                    ],
                    'original_price' => $deal->original_price,
                    'sale_price' => $deal->sale_price,
                    'discount_percentage' => $deal->discount_percentage,
                    'type' => $deal->type,
                    'stock_limit' => $deal->stock_limit,
                    'sold_count' => $deal->sold_count,
                    'remaining_stock' => $deal->stock_limit ? ($deal->stock_limit - $deal->sold_count) : null,
                    'start_date' => $deal->start_date,
                    'end_date' => $deal->end_date,
                    'time_left' => $this->getTimeLeft($deal->end_date)
                ];
            })
        ]);
    }

    public function featured()
    {
        $deals = Deal::with('product')
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('discount_percentage', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $deals->map(function ($deal) {
                return [
                    'id' => $deal->id,
                    'title' => $deal->title,
                    'product' => [
                        'id' => $deal->product->id,
                        'name' => $deal->product->name,
                        'slug' => $deal->product->slug,
                        'image' => $deal->product->primary_image ? url($deal->product->primary_image) : null
                    ],
                    'original_price' => $deal->original_price,
                    'sale_price' => $deal->sale_price,
                    'discount_percentage' => $deal->discount_percentage,
                    'time_left' => $this->getTimeLeft($deal->end_date)
                ];
            })
        ]);
    }

    private function getTimeLeft($endDate)
    {
        $now = now();
        $end = $endDate;
        
        if ($end <= $now) {
            return 'Expired';
        }
        
        $diff = $now->diff($end);
        
        if ($diff->days > 0) {
            return $diff->days . 'd ' . $diff->h . 'h';
        } elseif ($diff->h > 0) {
            return $diff->h . 'h ' . $diff->i . 'm';
        } else {
            return $diff->i . 'm ' . $diff->s . 's';
        }
    }
}