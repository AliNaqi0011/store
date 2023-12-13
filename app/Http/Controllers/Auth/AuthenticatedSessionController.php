<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        if(Auth::user()->email_status == 'verified') {
            $currentDateTime = now();
            $formattedDateTime = now()->format('Y-m-d H:i:s');
            $loggedInUser = Auth::user();
            $loggedInUser->last_login = $formattedDateTime;
            $loggedInUser->save();
            return redirect()->route('dashboard')->with('success', 'Login Sucessfully');
            // return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            Session::put('user_email', Auth::user()->email);
            Session::put('user_phone', Auth::user()->phone_number);
            Auth::logout();
            return redirect()->route('verification')->with('error', 'Your Email and Phone number are not verified. Please verify your number and email');
            // return redirect()->back()->with('error', 'Your email is not verified');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
