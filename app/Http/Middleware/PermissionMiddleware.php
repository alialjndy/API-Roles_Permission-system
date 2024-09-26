<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class PermissionMiddleware
{
    /**
     * To make sure that the current user is authorized to access
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::parseToken()->authenticate();
        if($user && ($user->HasRole('admin') || $user->HasRole('manager'))){
            return $next($request);
        }else{
            return response()->json([
                'statsus'=>'failed',
                'message'=>'UnAuthorized'
            ],403);
        }
    }
}
