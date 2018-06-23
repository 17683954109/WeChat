<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class login
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
        $httpss=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']: $request->path();
        if (empty(session('user'))){
            return redirect('/login?return_url='.urlencode($httpss));
        }
        return $next($request);
    }
}
