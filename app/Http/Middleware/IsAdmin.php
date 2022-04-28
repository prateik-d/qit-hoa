<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!is_null($token)) {
            if (Auth::guard('api')->check()) {
                $role = Auth::guard('api')->user()->role->role_type;
                if ($role == "admin") {
                    return $next($request);
                }
                else {
                    $message = ["message" => "Permission Denied"];
                    return response($message, 401);
                }
            } else {
                return response([
                    'message' => 'User is unauthenticated, Please login and try again'
                ], 401);
            }
        }
        else {
            return response([
                'message' => 'User is unauthenticated, Please login and try again'
            ], 401);
        }
    }
}
