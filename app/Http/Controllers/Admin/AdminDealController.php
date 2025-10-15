<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminDealController extends Controller
{
    public function index()
    {
        $deals = Deal::with('product')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.deals.index', compact('deals'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.deals.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'stock_limit' => 'nullable|integer|min:1',
            'type' => 'required|in:flash,clearance,bundle,vip',
            'is_active' => 'boolean'
        ]);

        // Calculate discount percentage
        $validated['discount_percentage'] = round((($validated['original_price'] - $validated['sale_price']) / $validated['original_price']) * 100);
        $validated['is_active'] = $request->has('is_active');

        Deal::create($validated);

        return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully');
    }

    public function show(Deal $deal)
    {
        $deal->load('product');
        return view('admin.deals.show', compact('deal'));
    }

    public function edit(Deal $deal)
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.deals.edit', compact('deal', 'products'));
    }

    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'stock_limit' => 'nullable|integer|min:1',
            'type' => 'required|in:flash,clearance,bundle,vip',
            'is_active' => 'boolean'
        ]);

        $validated['discount_percentage'] = round((($validated['original_price'] - $validated['sale_price']) / $validated['original_price']) * 100);
        $validated['is_active'] = $request->has('is_active');

        $deal->update($validated);

        return redirect()->route('admin.deals.index')->with('success', 'Deal updated successfully');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('admin.deals.index')->with('success', 'Deal deleted successfully');
    }
}