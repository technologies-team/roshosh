<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            throw new \Exception("unauthenticated");
        }
        if (!$request->user()->hasRole($role)) {
            throw new \Exception("Unauthorized action.");
        }
        return $next($request);
    }
}
