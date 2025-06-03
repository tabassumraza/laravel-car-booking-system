<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin privileges
        if (!auth()->check() || !$this->isAdmin()) {
            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }

    /**
     * Determine if the user is admin
     */
    protected function isAdmin(): bool
    {
        // Use either the property or method consistently
        return auth()->user()->is_admin; // If using boolean property
        // OR
        // return auth()->user()->isAdmin(); // If using method
    }
}