<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // days
        
        $analytics = [
            'overview' => $this->getOverviewStats(),
            'sales' => $this->getSalesData($period),
            'products' => $this->getProductStats(),
            'customers' => $this->getCustomerStats(),
            'charts' => [
                'daily_revenue' => $this->getDailyRevenue($period),
                'category_sales' => $this->getCategorySales(),
                'customer_acquisition' => $this->getCustomerAcquisition($period)
            ]
        ];

        return view('admin.analytics.index', compact('analytics', 'period'));
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        
        $salesData = $this->getDetailedSalesReport($startDate, $endDate);
        
        return view('admin.analytics.sales-report', compact('salesData', 'startDate', 'endDate'));
    }

    public function customerAnalytics()
    {
        $customerData = [
            'demographics' => $this->getCustomerDemographics(),
            'behavior' => $this->getCustomerBehavior(),
            'retention' => $this->getCustomerRetention(),
            'lifetime_value' => $this->getCustomerLifetimeValue()
        ];
        
        return view('admin.analytics.customers', compact('customerData'));
    }

    public function productAnalytics()
    {
        $productData = [
            'performance' => $this->getProductPerformance(),
            'inventory' => $this->getInventoryAnalytics(),
            'reviews' => $this->getProductReviewAnalytics(),
            'categories' => $this->getCategoryPerformance()
        ];
        
        return view('admin.analytics.products', compact('productData'));
    }

    private function getOverviewStats()
    {
        return [
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_products' => Product::where('stock_quantity', '<', 10)->count(),
            'today_revenue' => Order::whereDate('created_at', today())->where('status', '!=', 'cancelled')->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'month_revenue' => Order::whereMonth('created_at', now()->month)->where('status', '!=', 'cancelled')->sum('total_amount'),
            'month_orders' => Order::whereMonth('created_at', now()->month)->count()
        ];
    }



    private function getProductStats()
    {
        return [
            'top_selling' => DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.name', 'products.price', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name', 'products.price')
                ->orderByDesc('total_sold')
                ->limit(10)
                ->get(),
            'low_stock' => Product::where('stock_quantity', '<', 10)
                ->orderBy('stock_quantity')
                ->limit(10)
                ->get(['name', 'stock_quantity']),
        ];
    }

    private function getCustomerStats()
    {
        return [
            'new_customers_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'top_customers' => DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select('users.name', 'users.email', DB::raw('SUM(orders.total_amount) as total_spent'))
                ->where('orders.status', '!=', 'cancelled')
                ->groupBy('users.id', 'users.name', 'users.email')
                ->orderByDesc('total_spent')
                ->limit(10)
                ->get(),
        ];
    }

    private function getDailyRevenue($period = 30)
    {
        return Order::where('created_at', '>=', now()->subDays($period))
            ->where('status', '!=', 'cancelled')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'revenue' => (float) $item->revenue
                ];
            });
    }

    private function getSalesData($period)
    {
        $startDate = now()->subDays($period);
        $previousPeriodStart = now()->subDays($period * 2);
        
        $currentPeriod = Order::where('created_at', '>=', $startDate)
            ->where('status', '!=', 'cancelled')
            ->selectRaw('SUM(total_amount) as revenue, COUNT(*) as orders')
            ->first();
            
        $previousPeriod = Order::whereBetween('created_at', [$previousPeriodStart, $startDate])
            ->where('status', '!=', 'cancelled')
            ->selectRaw('SUM(total_amount) as revenue, COUNT(*) as orders')
            ->first();
            
        $currentRevenue = $currentPeriod->revenue ?? 0;
        $previousRevenue = $previousPeriod->revenue ?? 0;
        $currentOrders = $currentPeriod->orders ?? 0;
        
        $revenueGrowth = $previousRevenue > 0 
            ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 
            : 0;
            
        return [
            'current_revenue' => $currentRevenue,
            'current_orders' => $currentOrders,
            'revenue_growth' => round($revenueGrowth, 2),
            'average_order_value' => $currentOrders > 0 ? $currentRevenue / $currentOrders : 0
        ];
    }

    private function getCategorySales()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();
    }

    private function getCustomerAcquisition($period)
    {
        return User::where('created_at', '>=', now()->subDays($period))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as new_customers')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getDetailedSalesReport($startDate, $endDate)
    {
        return [
            'summary' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', '!=', 'cancelled')
                ->selectRaw('SUM(total_amount) as total_revenue, COUNT(*) as total_orders, AVG(total_amount) as avg_order_value')
                ->first(),
            'daily_breakdown' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', '!=', 'cancelled')
                ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'top_products' => DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->where('orders.status', '!=', 'cancelled')
                ->select('products.name', DB::raw('SUM(order_items.quantity) as quantity_sold'), DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('revenue')
                ->limit(20)
                ->get()
        ];
    }

    private function getCustomerDemographics()
    {
        return [
            'total_customers' => User::count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'active_customers' => User::whereHas('orders')->count(),
            'repeat_customers' => User::has('orders', '>', 1)->count()
        ];
    }

    private function getCustomerBehavior()
    {
        return [
            'avg_orders_per_customer' => round(Order::count() / User::whereHas('orders')->count(), 2),
            'avg_time_between_orders' => $this->getAverageTimeBetweenOrders(),
            'most_active_hours' => Order::selectRaw('HOUR(created_at) as hour, COUNT(*) as orders')
                ->groupBy('hour')
                ->orderByDesc('orders')
                ->limit(5)
                ->get(),
            'cart_abandonment_rate' => 0 // Implement if you track cart sessions
        ];
    }

    private function getCustomerRetention()
    {
        $totalCustomers = User::whereHas('orders')->count();
        $repeatCustomers = User::has('orders', '>', 1)->count();
        
        return [
            'retention_rate' => $totalCustomers > 0 ? round(($repeatCustomers / $totalCustomers) * 100, 2) : 0,
            'repeat_purchase_rate' => round(($repeatCustomers / $totalCustomers) * 100, 2),
            'customer_segments' => [
                'one_time' => User::has('orders', '=', 1)->count(),
                'repeat' => User::has('orders', '>', 1)->count(),
                'vip' => User::has('orders', '>', 5)->count()
            ]
        ];
    }

    private function getCustomerLifetimeValue()
    {
        return DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.status', '!=', 'cancelled')
            ->selectRaw('AVG(total_spent) as avg_clv, MAX(total_spent) as max_clv')
            ->from(DB::raw('(SELECT user_id, SUM(total_amount) as total_spent FROM orders WHERE status != "cancelled" GROUP BY user_id) as customer_totals'))
            ->first();
    }

    private function getProductPerformance()
    {
        return [
            'best_sellers' => DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.name', 'products.price', DB::raw('SUM(order_items.quantity) as total_sold'), DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
                ->groupBy('products.id', 'products.name', 'products.price')
                ->orderByDesc('revenue')
                ->limit(20)
                ->get(),
            'worst_performers' => Product::leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->selectRaw('products.name, products.price, COALESCE(SUM(order_items.quantity), 0) as total_sold')
                ->groupBy('products.id', 'products.name', 'products.price')
                ->orderBy('total_sold')
                ->limit(20)
                ->get(),
            'profit_margins' => $this->calculateProfitMargins()
        ];
    }

    private function getInventoryAnalytics()
    {
        return [
            'low_stock' => Product::where('stock_quantity', '<', 10)->orderBy('stock_quantity')->get(),
            'out_of_stock' => Product::where('stock_quantity', '=', 0)->count(),
            'overstocked' => Product::where('stock_quantity', '>', 100)->count(),
            'inventory_value' => Product::selectRaw('SUM(stock_quantity * price) as total_value')->first()->total_value
        ];
    }

    private function getProductReviewAnalytics()
    {
        return [
            'avg_rating' => DB::table('reviews')->avg('rating'),
            'total_reviews' => DB::table('reviews')->count(),
            'pending_reviews' => DB::table('reviews')->where('is_approved', false)->count(),
            'products_without_reviews' => Product::doesntHave('reviews')->count(),
            'top_rated_products' => Product::withAvg('reviews', 'rating')
                ->having('reviews_avg_rating', '>', 4)
                ->orderByDesc('reviews_avg_rating')
                ->limit(10)
                ->get()
        ];
    }

    private function getCategoryPerformance()
    {
        return DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('categories.name', 
                DB::raw('COUNT(DISTINCT products.id) as product_count'),
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'),
                DB::raw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get();
    }

    private function getAverageTimeBetweenOrders()
    {
        // Simplified calculation - implement more sophisticated logic if needed
        return 30; // days
    }

    private function calculateProfitMargins()
    {
        // Simplified - implement actual cost calculation if you track product costs
        return Product::selectRaw('name, price, (price * 0.3) as estimated_profit, ((price * 0.3) / price * 100) as margin_percentage')
            ->limit(20)
            ->get();
    }
}