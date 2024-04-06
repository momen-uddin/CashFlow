<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if ($request->session()->get('otpVerificaton') !== '1') {
            if (Auth::check() && (Auth::user()->role !== 'Customer')) {

                abort(401, 'Unauthorized');
            }
        } else {
            $otp = rand(1000, 9999);
            $request->session()->put('otp', $otp);

            $message = "Your OTP is: " . $otp;
            // send otp to email
            $email = $request->session()->get('email');
            Notification::route('mail', $email)->notify(new OtpNotification($message));

            return redirect()->route('otp.verify')->with('error', 'Verify your OTP first');
        }

        return $next($request);
    }
}
