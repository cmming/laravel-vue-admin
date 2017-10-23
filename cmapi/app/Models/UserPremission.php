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

}
