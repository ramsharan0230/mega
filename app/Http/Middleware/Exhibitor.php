<?php

namespace App\Http\Middleware;

use App\Models\Exhibitor as ModelsExhibitor;
use Closure;
use Request;

class Exhibitor
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
        $userRole = auth()->user()->role ?? null;
        if (!$userRole) {
            return redirect()->route('exhibitorLogin')->with('message', 'Please login');
        }
        if ($userRole == 'super-admin' || $userRole == 'admin') {
            return $next($request);
        }
        $segment =  Request::segment(2);

        $access_levels_string = auth()->user()->access_level;
        $access_levels = explode(',', $access_levels_string);
        if (in_array($segment, $access_levels)) {
            return $next($request);
        }
        return redirect()->route('exhibitorLogin')->with('message', 'You dont have required permission');
    }
}
