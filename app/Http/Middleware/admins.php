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
//        if (session('adminuser')==''){
//            return redirect('/admin/login');
//        }

        return $next($request);
    }
}
