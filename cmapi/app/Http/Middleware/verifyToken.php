<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use \Tymon\JWTAuth\Middleware\GetUserFromToken;

class VerifyToken
{
	/**
	 * 请求前置中间件
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// 后期 根据这两个进行主动刷新token
		//$old_token = JWTAuth::getToken();
		//$token = JWTAuth::refresh($old_token);
//		dd($this->auth->setRequest($request)->getToken());
//		var_dump($this->auth->setRequest($request)->getToken());
//		$token = $this->auth->setRequest($request)->getToken();
//		//这一步有误
//		$this->auth->authenticate($token);
//		dd($this->auth->authenticate($token));
		try {
			if (!JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (TokenExpiredException $e) {
			//toke失效，response code可自定义
			return response()->json(['token 过期'], 401);
		} catch (TokenInvalidException $e) {
			return response()->json(['token 非法'], $e->getStatusCode());
		} catch (JWTException $e) {
//            return response()->json(['token_absent'], $e->getStatusCode());
			return response()->json(['token 错误'], $e->getStatusCode());
		}
		//见识该 token 是否需要刷新

		return $next($request);
	}
}

