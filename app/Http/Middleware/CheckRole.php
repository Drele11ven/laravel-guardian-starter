<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated and has the required role
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            // If not, redirect them to a 403 page or the homepage
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}