<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 15:53
 */

namespace App\Models\Wechat;



class UserWxInfo extends BaseModel
{
    protected $connection = 'mysql_air';

    protected $table = 'user_wx_info';

    protected $fillable = ['openid', 'nickname', 'headimgurl','user_id'];



}