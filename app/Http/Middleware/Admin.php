<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && (Auth::user()->role !== 'Admin' && Auth::user()->role !== 'Master Admin')) {
            // Log::info('middleware Role: ' . Auth::user()->role);
            // return redirect()->route('agent.dashboard');
            // Auth::logout();
            // return redirect()->route('login')->with('error', 'You are not authorized to access this page');
            abort(401, 'Unauthorized');
        }


        return $next($request);
    }
}
