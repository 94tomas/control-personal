<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        $ifAuthorization = $request->user()->authorizeRoles($roles);
        if ($ifAuthorization) {
            return $next($request);
        }
        // \Auth::logout();
        return redirect('/');
        // return $next($request);
    }
}
