<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,string $role)
    {

        if ($role == 'super_admin' && auth()->user()->role != 'super_admin' ) {
            abort(403);
        }
        if ($role == 'project_manager' && auth()->user()->role != 'project_manager' ) {
            abort(403);
        }
        if ($role == 'employee' && auth()->user()->role != 'employee' ) {
            abort(403);
        }

        return $next($request);
    }
}
