<?php

namespace App\Http\Middleware;

use Closure;

class admins
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
        if (session('adminuser')==null||session('adminuser')==''){
            if ($request->cookie('adminuser')==''||$request->cookie('adminuser')==null){
                return redirect('/admin/login');
            }
        }

        return $next($request);
    }
}
