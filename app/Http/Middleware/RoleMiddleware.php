<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }

        return redirect('/home')->with('error', 'You do not have access to this section.');
    }
}
