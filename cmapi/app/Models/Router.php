<?php

namespace App\Models;

use App\Models\UserPremission;

//用户权限

class Router extends BaseModel
{
    protected $connection = 'mysql';
    protected $table = "routers";

	//可以被集体赋值
	protected $fillable = [
		'title', 'path','componentPath','type','iconFont','sort','path'
	];
	//不被允许集体赋值
	protected $guarded = array('id');

	// 子路由
	public function son_routers(){
		return $this->belongsToMany('App\Models\Router','routers_rel','parent_id','son_id')->withPivot(['parent_id','son_id']);
	}

	//保存一个子路有
	public function add_son_router($router){
		return $this->son_routers()->save($router);
	}
	//删除一条 关联关系
	public function delete_son_router($router){
		return $this->son_routers()->detach($router);
	}

	//获取一个路由拥有的 角色
	public function premissions(){
		return $this->belongsToMany('App\Models\UserPremission','router_premission_rel','router_id','premission_id')->withPivot('router_id','premission_id');
	}

	//获取 一个 路由拥有的所有 角色

	public function roles(){
		$roles = [];$result = [];
//		dd($this->premissions()->get(['router_premission_rel.router_id as router_id'])->toArray());
		$premissions = $this->premissions()->get(['user_premissions.id'])->toArray();
//		$premissions = $this->premissions();
		foreach($premissions as $premission){
			$premission_item = UserPremission::find($premission['id']);
			$user_roles_id = $premission_item->roles()->get(['user_roles.id'])->toArray();
			$roles[] = $user_roles_id;
		}
//		dd($roles);
		foreach($roles as $role){
			foreach($role as $item){
				$result[]=$item['id'];
			}
		}
		return $result;
	}







}
