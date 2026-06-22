<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsCashier
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
        
        // Hanya cashier yang bisa akses
        if ($user->role !== 'cashier') {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
