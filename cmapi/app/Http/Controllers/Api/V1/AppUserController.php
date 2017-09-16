<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Carbon\Carbon;

class AppUserController extends BaseController
{
    //
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            // 错误批量处理
            return $this->errorBadRequest($validator);
        }
        // grab credentials from the request

        //进行用户的验证（不使用封装的方式）
        //判断用户是否存在
        $user_is_exist = User::where('uname','=',$request->get('name'))->exists();
        if($user_is_exist){
            $pass_word_ok = User::where(['uname'=>$request->get('name'),'pwd'=>md5($request->get('password'))])->exists();
            if($pass_word_ok){
                $user = User::where('uname','=',$request->get('name'))->first();
                $token = JWTAuth::fromUser($user);
            }else{
                return response()->json(['error' => '用户密码错误！'], 401);
            }
        }else{
            return response()->json(['error' => '用户不存在！'], 401);
        }
        $tokenInfo = [
            'token' => $token,
            'expired_at' => Carbon::now()->addMinutes(config('jwt.ttl'))->toDateTimeString(),
            'refresh_expired_at' => Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->toDateTimeString(),
        ];
        return ['user'=>$user,'data'=>$tokenInfo];
    }

	public function logout(){
		return ['code'=>200,'msg'=>'退出登录'];
	}
}
