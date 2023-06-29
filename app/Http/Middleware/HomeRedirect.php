<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HomeRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!config('settings.system.main_site')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
