<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->bearerToken();
        if($token) {
            if(Auth::guard('api')->check() && Auth::guard('api')->user()) {
                // $user = Auth::guard('api')->user();
                return $next($request);
            } else {
                return response([
                    'message' => 'unauthorised'
                ], 403);
            }
        }
        else {
            return response([
                'message' => 'User is unauthenticated, Please login and try again'
            ], 401);
        }
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }
}
