<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Jobs\SendOtpEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Notifications\OtpNotification;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Notification;

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

        if ($request->has('otp_verification')) {
            $otp = rand(1000, 9999);
            $request->session()->put('otp', $otp);

            // $message = "Your OTP is: " . $otp;
            // send otp to email
            $email = $request->email;
            $request->session()->put('email', $email);

            SendOtpEmail::dispatch($request->email, $otp);

            return redirect()->route('otp.verify');
        }

        // return redirect()->intended(route('dashboard', absolute: false));
        return redirect('/');
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
