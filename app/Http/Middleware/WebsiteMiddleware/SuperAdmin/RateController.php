<?php

namespace App\Http\Middleware\WebsiteMiddleware\SuperAdmin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RateController
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
        RateLimiter::for('rate_control', function (Request $request, $k = 1000) {
            return Limit::perMinute($k)->by($request->ip())->response(function (Request $request, array $headers) {
                return
                    back()
                    ->withErrors(
                        [
                            'issue' => 'Too Many Requests try after ' . $headers['X-RateLimit-Reset'] - time() . ' second'
                        ]
                    )
                    ->withInput();
            });
        });
        return $next($request);
    }
}
