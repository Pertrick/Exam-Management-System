<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;

class SubjectMiddleware
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
        if ($request->routeIs('pay') || $request->routeIs('student.payment.index')){
            return $next($request);
        }

        
        if (auth()->user()->role_id == Role::ADMIN) {
            return $next($request);
        } else if (auth()->user()->subjects->count() == 0) {
            return redirect()->route('student.subject.create')->with('info', 'select a material to continue!');
        }
        return $next($request);
    }
}
