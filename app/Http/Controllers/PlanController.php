<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PlanController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $plans = Plan::get();

        return view("admin.plans", compact("plans"));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function show(Plan $plan, Request $request)
    {
        $user = auth()->user();

        $intent = $user->createSetupIntent();

        return view("admin.subscription", compact("plan", "intent"));
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function subscription(Request $request)
    {
        $plan = Plan::find($request->plan);

        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
            ->create($request->token);

        return redirect()->route('blog.listing')->with('success', 'Subscription Done!');
    }
}
