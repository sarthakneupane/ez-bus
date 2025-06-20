<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->role == 0){
                return $next($request);
            }else{
                abort(404);
            }
        }
    }
}
