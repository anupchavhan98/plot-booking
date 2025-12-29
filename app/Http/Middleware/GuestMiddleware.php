<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Redirect based on role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->hasRole('agent')) {
                return redirect()->route('agent.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        }

        return $next($request);
    }
}