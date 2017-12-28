<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 14:52
 */
namespace App\Models\Wechat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    //设置数据库连接
    protected $connection = 'mysql_air';
    //设置 关联表

    protected $table = 't_user';
    //白名单

    protected $fillable = ['name','email'];



}