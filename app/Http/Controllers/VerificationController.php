<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            $user->save();
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Login Sucessfully');
            // dd($user);
        } else {
            return redirect()->back()->with('error', 'Invalid Otp');
        }
    // dd($request->all());
        // if()
        // dd($request->all());
    }
}
