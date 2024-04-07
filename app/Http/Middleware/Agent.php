<?php

namespace App\Http\Middleware;

use Closure;
use App\Jobs\SendOtpEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class Agent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if ($request->session()->get('otpVerificaton') == '1') {
            if (Auth::user()->role != 'Agent') {
                // Auth::logout();
                // return redirect()->route('login')->with('error', 'You are not authorized to access this page');
                abort(401, 'Unauthorized');
            }
        } else {
            $otp = rand(1000, 9999);
            $request->session()->put('otp', $otp);

            // send otp to email
            $email = $request->session()->get('email');
            SendOtpEmail::dispatch($email, $otp);

            return redirect()->route('otp.verify')->with('error', 'Verify your OTP first');
        }
        return $next($request);
    }
}
