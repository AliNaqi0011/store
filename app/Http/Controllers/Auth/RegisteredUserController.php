<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Models\UserCode;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use App\Http\Controllers\MailController;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */





    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'phone_number' => ['required', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'verification_code' => sha1(time()),
            'password' => Hash::make($request->password),
        ]);

        if($user != null){
            MailController::sendSignupEmail($user->name, $user->email, $user->verification_code);
            Auth::login($user);
            return redirect()->route('email.verification.notice')->with('error', 'Please verify your email');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function storeWithEmailAndPhoneVerification(Request $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->email_status === 'verified') {
                return redirect()->route('login')->with('error', 'Already registered with this email');
            } else {
                Session::put('user_email', $request->email);
                Session::put('user_phone', $request->phone_number);
                return redirect()->route('verification')->with('error', 'Please verify your number and email');
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);
        $otp_code = random_int(100000, 999999);
        $otp = [
            'email_otpCode'=>$otp_code,
        ];


        // Send Email Verification OTP
        Mail::to($user->email)->send(new EmailVerification($otp));


        // Send Phone Number Verification OTP
        $otpmobilecode = mt_rand(1000, 9999); // Generate a random 4-digit OTP
        $to = $request->input('phone_number'); // The recipient's phone number

        // Use Twilio to send the OTP
        $twilio = new Client(config('services.twilio.account_sid'), config('services.twilio.auth_token'));
        $twilio->messages->create(
            '+'.$to,
            [
                'from' => config('services.twilio.from'),
                'body' => "Your OTP is: $otpmobilecode",
            ]
        );

        $userCode = UserCode::create([
            'phone' => $user->phone_number,
            'email' => $user->email,
            'otp' => $otp_code,
            'code' => $otpmobilecode,
        ]);
        // Store email and phone in the session
        Session::put('user_email', $user->email);
        Session::put('user_phone', $user->phone_number);

        Auth::logout();
        return redirect()->route('verification');
        // return redirect(RouteServiceProvider::HOME);
    }
}
