<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class adminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 
     */

    public function handle($request, Closure $next)
    {   
        if(Auth::user()){
            if(Auth::user()->user_role !== "user"){
                return $next($request);
            }else{
               dd("kamu user tidak boleh akses page ini");
            }
        }else{
            dd("belum login");
        }
    }
}
