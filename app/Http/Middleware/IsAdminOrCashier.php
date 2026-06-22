<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminOrCashier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $user = Auth::user();
        
        // Admin atau Cashier bisa akses
        if (!in_array($user->role, ['admin', 'cashier'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
