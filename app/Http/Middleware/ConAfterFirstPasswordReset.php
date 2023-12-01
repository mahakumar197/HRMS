<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConAfterFirstPasswordReset
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {        
        if (Auth::guard('consultancy')->user()->password_change_at == null ) {
            return redirect('consultancy/password_change');
        }
        return $next($request);

    }
}
