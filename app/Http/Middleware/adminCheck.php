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
     */
    public function handle($request, Closure $next)
    {   
        if(Auth::user()){
            $user = DB::table('users as u')
                    ->Join('user_role as ur','u.id','=','ur.user_id')
                    ->Where('u.id',Auth::user()->id)
                    ->select('ur.type as type')->first();
            if($user->type !== "user"){
                return $next($request);
            }else{
               dd("kamu user tidak boleh akses page ini");
            }
        }else{
            dd("belum login");
        }
    }
}
