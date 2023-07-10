<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
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
        if (Auth::guard('seller')->check()) {
            return $next($request);
        }

        if (Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        if (!Auth::guard('seller')->check() && !Auth::check()) {
            return redirect('/seller/login');
        }

        return $this->redirectTo($request);
    }
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('seller.login');
    }
}
