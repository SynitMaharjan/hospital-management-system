<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip if not authenticated
        if (!auth()->check()) {
            return $next($request);
        }

        // Skip if user doesn't need to change password
        if (!auth()->user()->must_change_password) {
            return $next($request);
        }

        // Allow access to password change, update, and logout routes
        $currentRoute = $request->route()?->getName();
        $allowedRoutes = ['password.change', 'password.update', 'logout'];
        
        if ($currentRoute && in_array($currentRoute, $allowedRoutes, true)) {
            return $next($request);
        }

        // Redirect to password change page
        return redirect()->route('password.change');
    }
}
