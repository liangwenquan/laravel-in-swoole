<?php
/**
 * Created by PhpStorm.
 * User: liangwenquan
 * Date: 2018/12/23
 * Time: 下午6:31
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle($request, Closure $next)
    {

        try {
            $user = auth()->guard('admin')->userOrFail();
            if(!$user) {
                return response()->json(['message' => 'jwt 无效'], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['message' => 'jwt 无效'], 401);
        }
        return $next($request);
    }
}