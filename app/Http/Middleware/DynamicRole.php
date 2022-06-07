<?php

namespace App\Http\Middleware;

use Closure;

class DynamicRole
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
        if (count($request->user()->roles) > 0) {
            $listRoles = explode(',', $request->user()->roles[0]->pivot->permissions);
        } else {
            Auth::logout();
            return redirect()->to('/login')->with('warning', 'Your session has expired because your account is deactivated.');
        }

        $url = explode('/', $request->route()->uri);
        $path = $url[0];
        
        if (in_array($path, $listRoles)) return $next($request);
        else return redirect('/dashboard');
    }
}
