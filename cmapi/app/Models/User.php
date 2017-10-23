<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'mysql_vr';
    protected $table = "t_user_list";
	protected $primaryKey = 'uid';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'uname','nick'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pwd'
    ];

	//一个用户的所有 角色
	public function roles(){
		return $this->belongsToMany('App\Models\UserRole','users_roles','user_id','role_id')->withPivot('user_id','role_id');
	}

	//添加一个角色
	public function addRoles($role){
		return $this->roles()->save($role);
	}
	//删除一个角色
	Public function deleteRole($role){
		return $this->roles()->detach($role);
	}
	public function isInRoles($roles){
		//intersect 将两个 集合进行做交集
		return $roles->intersect($this->roles)->count();
	}
	//用户 是否有权限
	public function hasPremission($premission){
		// 判断用户的角色 和  这个权限所属有的角色是否 拥有重叠 即可
		return $this->isInRoles($premission->roles);
	}

	//获取一个用户拥有的所有的权限
	public function premissions(){
		$roles = $this->roles->toArray();
		foreach($roles as $role){

		}
		dd($roles);
	}


}
