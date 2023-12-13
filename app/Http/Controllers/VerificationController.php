<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class VerificationController extends Controller
{
    public function verification() {
        $userEmail = Session::get('user_email');
        $userPhone = Session::get('user_phone');
        // Session::forget(['user_phone', 'user_email']);
        return view('admin.email-verify', compact('userPhone', 'userEmail'));
    }

    public function VerifyEmaiLPhoneOtp(Request $request) {
        $userEmail = Session::get('user_email');
        $userPhone = Session::get('user_phone');

        $userCodeData = UserCode::where('email', $userEmail)->where('phone', $userPhone)->latest()->first();
        if($userCodeData->otp == $request->email_otp && $userCodeData->code == $request->phone_otp) {
            $user = User::where('email', $userEmail)->latest()->first();
            $user->email_status = 'verified';

            $formattedDateTime = now()->format('Y-m-d H:i:s');
            $user->last_login = $formattedDateTime;
            $user->save();
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Login Sucessfully');
            // dd($user);
        } else {
            return redirect()->back()->with('error', 'Invalid Otp');
        }
    }

    public function two_fa_verification(Request $request) {
        return view('admin.two_fa_verification');
    }

    public function verify_two_fa_email_otp(Request $request) {
        if($request->email_otp) {
            $userEmail = Session::get('user_email');
            $user = User::where('email', $userEmail)->latest()->first();
            dd($user);
            // if()
        } else {
            return redirect()->back()->with('error', 'Please enter Otp');
        }
    }
}
