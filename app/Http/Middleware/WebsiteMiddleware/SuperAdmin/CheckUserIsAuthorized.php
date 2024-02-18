<?php

namespace App\Http\Middleware\WebsiteMiddleware\SuperAdmin;

use Closure;
use Illuminate\Http\Request;

class CheckUserIsAuthorized
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
        if (!(session('user'))) {
            return redirect()->route('login');
        }
        
        return $next($request);
    }
}
