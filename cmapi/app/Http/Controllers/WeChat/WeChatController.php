<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17
 * Time: 15:01
 */

namespace App\Http\Controllers\WeChat;


use App\Models\Wechat\User;
use App\Models\Wechat\UserWxInfo;

use EasyWeChat\Message\Text;


class WeChatController extends BaseController
{
    protected $user;

    public function __construct(User $user, UserWxInfo $userWxInfo)
    {
        $this->user = $user;
        $this->userwxinfo = $userWxInfo;
    }

    public function serve()
    {
        \Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function ($message) {
            //发送数据的时候 会自动 发给用户的
            return "欢迎关注 overtrue！";
        });

        //\Log::info('return response.');

        return $wechat->server->serve();
    }

    public function user()
    {
        $userinfo = session('wechat.oauth_user')->original; // 拿到授权用户资料

        $user = session('wechat.oauth_user');
//        \Log::info($user);
        dd($userinfo, $user);
    }

    public function bindApp()
    {

        return view('/wechat/bindApp');
    }

    public function bindAppStore()
    {
        //验证用户信息
        $this->validate(request(), [
            'name' => 'required',
            'password' => 'required'
        ]);
//        if($validator->fails()){
//            return $this->errorBadRequest($validator);
//        }
        $user_is_exist = $this->user->where('uname', '=', request('name'))->exists();
        if ($user_is_exist) {
            $pass_word_ok = $this->user->where(['uname' => request('name'), 'pwd' => md5(request('password'))])->exists();
            if ($pass_word_ok) {
                //
                $user = $this->user->where('uname', '=', request('name'))->first();
//                将数据进行绑定
                $userinfo = session('wechat.oauth_user')->original;
//                $userinfo  = [
//                    'openid'=>'132132',
//                    'nickname'=>'陈明',
//                    'headimgurl'=>'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo_top_ca79a146.png'
//                ];
                $user_wx_is_exist = $this->userwxinfo->where('openid', '=', $userinfo['openid'])->exists();
                if(!$user_wx_is_exist){
                    $saveParams = ['user_id' => $user->id,
                        'openid' => $userinfo['openid'],
                        'nickname' => $userinfo['nickname'],
                        'headimgurl' => $userinfo['headimgurl']
                    ];
                    $this->userwxinfo->create($saveParams);
                }else{
                    return \Redirect::back()->withErrors("已经绑定过了app 帐号！");
                }

            } else {
                return \Redirect::back()->withErrors("用户密码错误！");
            }
        } else {
            return \Redirect::back()->withErrors("用户不存在！");
        }

    }

    //用户消息
    public function userMsgs(){
//        $userinfo = session('wechat.oauth_user')->original;

//        $text = new Text(['content' => '您好！overtrue。']);
//        $text = new Text(['content' => '您好！overtrue。'.$userinfo['nickname']]);
// or

        return '你好！！';


    }

}