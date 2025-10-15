<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = AdminUser::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password) && $admin->is_active) {
            Auth::guard('admin')->login($admin);
            $admin->update(['last_login_at' => now()]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials or account inactive']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_products' => \App\Models\Product::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_revenue' => \App\Models\Order::where('status', 'completed')->sum('total_amount'),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'low_stock_products' => \App\Models\Product::where('stock_quantity', '<', 10)->count(),
        ];

        $recent_orders = \App\Models\Order::with('user')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}