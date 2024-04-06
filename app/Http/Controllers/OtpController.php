<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Notification;

class OtpController extends Controller
{
    //
    // public function sendOtp(Request $request)
    // {
    //     $otp = rand(1000, 9999);
    //     $request->session()->put('otp', $otp);

    //     $message = "Your OTP is: " . $otp;
    //     // send otp to email
    //     $email = $request->email;
    //     Notification::route('mail', $email)->notify(new OtpNotification($message));

    //     return redirect()->route('otp.verify');
    // }

    public function verifyOtp(Request $request)
    {
        if ($request->otp == $request->session()->get('otp')) {
            return redirect()->route('home')->with('otpVerificaton', '1');
        } else {
            return redirect()->route('otp.verify')->with('error', 'Invalid OTP');
        }
    }


}
