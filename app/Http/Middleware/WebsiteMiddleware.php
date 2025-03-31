<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LDAP\Result;

class WebsiteMiddleware
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
        if (auth()->user()->role_id == Role::ADMIN) {
            return $next($request);
        } else if (Auth::check() && auth()->user()->website_id == User::WEBSITE_ID) {
            return $next($request);
        }
        Auth::logout();
        abort(403, 'Unauthorized request');
    }
}
