<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        if ($request->user()->role !== $role) {
            if ($request->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else if ($request->user()->role == 'vendor') {
                return redirect()->route('vendor.dashboard');
            }
            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
