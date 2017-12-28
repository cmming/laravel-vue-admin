<?php

namespace App\Models;

//用户权限

class UserPremission extends BaseModel
{
    protected $connection = 'mysql';
    protected $table = "user_premissions";
	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'desc'
	];
	//权限属于 那些角色
	public function roles(){
		return $this->belongsToMany('App\Models\UserRole','user_premission_role','premission_id','role_id')->withPivot(['premission_id','role_id']);
	}
	//一个权限拥有的所有路由
	public function routers(){
		return $this->belongsToMany('App\Models\Router','router_premission_rel','premission_id','router_id');
	}
	//保存 一条路由关系
	public function add_routers($router){
		return $this->routers()->save($router);
	}
	//删除条路由管理
	public function delete_routers($router){
		return $this->routers()->detach($router);
	}

}
