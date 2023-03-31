<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Closure;

/**
 * Class CheckAdminAccess
 * @package App\Http\Middleware
 */
class CheckAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $guard
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $guard = 'admin'): Response|RedirectResponse|JsonResponse
    {
        if (!Auth::guard($guard)->check()) {
            return redirect(route('admin.auth.login'));
        }

        return $next($request);
    }
}
