<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user() && (auth()->user()->role == 'super-admin' || auth()->user()->role == 'admin')) {
            return $next($request);
        }
        return redirect()->back()->with('message', 'You donot have admin access');
    }
}
