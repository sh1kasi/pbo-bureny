<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        $role = strtolower(request()->user()->role);
        $allowed_roles = array_slice(func_get_args(), 2);
        if (in_array($role, $allowed_roles)) {
            return $next($request);
        }
        return redirect()->route('login_index');

    }
}
