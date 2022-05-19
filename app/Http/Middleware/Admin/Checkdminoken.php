<?php

namespace App\Http\Middleware\admin;

use Closure;
//use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class Checkdminoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   $admin = null;
        try {
            $admin = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['message'=>'Invalide token']);
            }
        }
        return $next($request);
    }
}
