<?php
/**
 * Created by PhpStorm.
 * User: liangwenquan
 * Date: 2018/12/27
 * Time: 下午3:37
 */

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CustomJwtAuth
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
//        Config::set('jwt.user' , "App\Models\User");
//        Config::set('auth.providers.users.model', \App\Models\User::class);
        try {
            if (!$user = JWTAuth::toUser(JWTAuth::getToken())){
                return response()->json([
                    'errcode' => 400004,
                    'errmsg' => '无此用户'
                ], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json([
                'errcode' => 400001,
                'errmsg' => 'token 过期'
            ], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json([
                'errcode' => 400003,
                'errmsg' => 'token 失效'
            ], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json([
                'errcode' => 400002,
                'errmsg' => 'token 参数错误'
            ], $e->getStatusCode());

        }
        return $next($request);
    }
}