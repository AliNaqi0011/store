<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserSettingsController extends Controller
{
    public function index() {
        $userSetting = UserSetting::where('user_id', Auth::user()->id)->first();
        $user = Auth::user();
        return view('admin.setting.index', compact('user', 'userSetting'));
    }

    public function create() {
        return view('admin.setting.create');
    }

    public function store(Request $request) {
        $userSetting = new UserSetting();
        $userSetting->user_id = Auth::user()->id;
        $userSetting->twillio_sid = $request->twillio_sid;
        $userSetting->twillio_phone = $request->twillio_phone;
        $userSetting->twillio_auth_token = $request->twillio_auth_token;
        $userSetting->two_fa_type = $request->two_fa_type;
        if($request->stripe_publishable_key && $request->stripe_secret_key) {
            $userSetting->stripe_payment_method = 'stripe';
            $userSetting->stripe_publishable_key = $request->stripe_publishable_key;
            $userSetting->stripe_secret_key = $request->stripe_secret_key;
        }
        $userSetting->save();
        return redirect()->route('user.settings')->with('success', 'User settings saved successfully.');
    }

    public function edit($id) {
        $userSetting = UserSetting::find($id);
        return view('admin.setting.edit', compact('userSetting'));
    }

    public function update(Request $request, $id) {
        $userSetting = UserSetting::find($id);
        $userSetting->user_id = Auth::user()->id;
        $userSetting->twillio_sid = $request->twillio_sid;
        $userSetting->twillio_phone = $request->twillio_phone;
        $userSetting->twillio_auth_token = $request->twillio_auth_token;
        $userSetting->two_fa_type = $request->two_fa_type;
        if($request->stripe_publishable_key && $request->stripe_secret_key) {
            $userSetting->stripe_payment_method = 'stripe';
            $userSetting->stripe_publishable_key = $request->stripe_publishable_key;
            $userSetting->stripe_secret_key = $request->stripe_secret_key;
        }
        $userSetting->save();
        return redirect()->route('user.settings')->with('success', 'User settings updated successfully.');
    }
}
