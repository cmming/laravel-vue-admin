<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Carbon\Carbon;

class AuthenticateController extends BaseController
{
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            // 错误批量处理
            return $this->errorBadRequest($validator);
        }
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => '登录失败！'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'token 生成失败'], 500);
        }

        // all good so return the token
        //return response()->json(compact('token'));
        $tokenInfo = [
            'token' => $token,
			//过期时间默认使用 的缓存文件 中的配置
            'expired_at' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
			//刷新时间的作用是在这个刷新时间以内 自动刷新 token
            'refresh_expired_at' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->toDateTimeString(),
        ];
        $user = User::where('email', $credentials['email'])->first();
        return ['user'=>$user,'data'=>$tokenInfo];
    }
    //退出登录
    public function logout(){
        //$token = JWTAuth::getToken();
        //将这个token失效即可
        return $this->response->noContent();
    }

    public function logins(){
        return [
            'code'=>401,
            'msg'=>'用户未登录'
        ];
    }
    //注册
    public function store(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $email = $request->get('email');
        $password = $request->get('password');

        $attributes = [
            'email' => $email,
            'name' => $request->get('name'),
            'password' => app('hash')->make($password),
        ];
        $user = User::create($attributes);

        return ['msg'=>'注册成功！','code'=>200];
    }
	public function refreshToken(){
		$old_token = JWTAuth::getToken();
		$newToken = JWTAuth::refresh($old_token);
		return response(['刷新token'], 401)->header('Authorization', 'Bearer '.$newToken);
	}
}