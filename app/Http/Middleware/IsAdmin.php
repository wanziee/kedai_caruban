<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }

        $user = auth()->user();
        
        // Allow if user is owner, admin, or cashier
        if (!in_array($user->role, ['owner', 'admin', 'cashier'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
