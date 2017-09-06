<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
	//获取用户的所有信息
	public function index(){
		$users = User::orderBy('created_at','desc')->paginate(10);
		return $users;
	}
}