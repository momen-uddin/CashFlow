<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

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


        if (Auth::user()->role === 'Agent') {
            return redirect()->intended(route('agent.dashboard'));
        }
        if((Auth::user()->role === 'Admin') || (Auth::user()->role === 'Master Admin')) {
            // Log::info('Role: ' . Auth::user()->role);
            return redirect()->intended(route('admin.dashboard'));
        }

        if(Auth::user()->role === 'Customer') {
            // Log::info('Role: ' . Auth::user()->role);
            return redirect()->intended(route('customer.dashboard'));
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
