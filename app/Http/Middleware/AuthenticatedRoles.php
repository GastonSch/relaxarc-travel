<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticatedRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if ($request->routeIs('users.generate-username')) return $next($request);

        $userRoles = is_array($request->user()->roles) ? $request->user()->roles : json_decode($request->user()->roles, true) ?? [];
        return (checkRoles($roles, $userRoles)) ? $next($request) : abort(403);
    }
}
