<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckloginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isLogin()) {
            //return redirect(route('home'));
        }
        return $next($request);
    }
    // if ($request->is('admin/*') || $request->is('admin)){
        //echo '<h3>Khu vuc quan tri</h3>';
    //}

    public function isLogin(){
        return auth()->check();
    }
}