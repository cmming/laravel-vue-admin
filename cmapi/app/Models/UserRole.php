<?php

namespace App\Models;

//用户权限

class UserRole extends BaseModel
{
    protected $connection = 'mysql';
    protected $table = "user_roles";

	protected $fillable = ['name','desc'];

	//该角色拥有的所有 权限
	public function premissions(){
		//多对多关联 1.关联的 模型 2.产生关联的关系表 3.当前表对应关系表中的字段 4. 关联模型的索引对应的关系表字段
		return $this->belongsToMany('App\Models\UserPremission','user_premission_role','role_id','premission_id')->withPivot(['role_id','premission_id']);
	}

	//给角色赋予权限
	public function grantPremission($premission){
		return $this->premissions()->save($premission);
	}
	//删除角色中的一个权限
	public function deletePremission($premission){
		return $this->premissions()->detach($premission);
	}
	//判断一个权限是否被角色拥有
	public function hasPremission($premission)
	{
		return $this->premissions()->contains($premission->roles);
	}

}
