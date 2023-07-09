<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class AuthenticateSeller extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, \Closure $next, ...$guards)
    {
        if (!Auth::guard('seller')->check()) {
            return $this->redirectTo($request);
        }

        return $next($request);
    }
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('seller.login');
    }
}
