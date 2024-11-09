<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next , ...$roles)
    {
        // Redirect to login if the user is not authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Redirect if the authenticated user is not an admin
        if (!in_array(Auth::user()->type , $roles)) {
            Auth::guard('web')->logout();

            return redirect()->route('login');
            // abort(403);
        }

        return $next($request);
    }
}
