<?php

namespace App\Http\Middleware;

use Closure;
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
        if(auth()->user()->subjects->count() == 0){
            return redirect()->route('student.subject.create')->with('warning','kindly select a subject to continue!');
        }
        return $next($request);
    }
}
