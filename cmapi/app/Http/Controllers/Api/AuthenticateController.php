<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Carbon\Carbon;

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => '登录失败！'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'token 生成失败'], 500);
        }

        // all good so return the token
        //return response()->json(compact('token'));
        $result['data'] = [
            'token' => $token,
            'expired_at' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
            'refresh_expired_at' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->toDateTimeString(),
        ];
        $user = User::where('email', $credentials['email'])->first();
        return ['user'=>$user,'data'=>$result['data']];
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
        // 用户注册成功后发送邮件
//        dispatch(new SendRegisterEmail($user));

        // 201 with location
//        $location = dingo_route('v1', 'users.show', $user->id);

        // 让user默认返回token数据
    }
}