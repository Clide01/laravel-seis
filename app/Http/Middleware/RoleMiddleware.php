<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // If not logged in, send to login
        if (!Auth::check()) {
            return redirect('login');
        }

        // If the user's role doesn't match the required role, show a 403 error
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        return $next($request);
    }
}