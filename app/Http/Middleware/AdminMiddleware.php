<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        return $next($request);

                //

        // Exclude login routes from redirect
    // if (!$request->is('login') && !Auth::guard('admin')->check()) {
    //     return redirect()->route('login');
    // }

    // // Prevent dashboard redirect for other routes
    // if (Auth::guard('admin')->check() && $request->is('admin/dashboard')) {
    //     return $next($request);
    // }

    // return $next($request);

             //

    //     if (!Auth::guard('admin')->check()) {
    //     return redirect()->route('login')->with('error', 'Please login first');
    // }

    // return $next($request);

        // return $next($request);
    }
}
