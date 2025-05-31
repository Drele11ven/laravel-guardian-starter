<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // فقط هر 1 دقیقه یک بار آپدیت بشه
            if ($user->last_seen === null || now()->diffInMinutes($user->last_seen) > 1) {
                $user->update(['last_seen' => now()]);
            }
        }

        return $next($request);
    }
}
