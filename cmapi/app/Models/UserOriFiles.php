<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

class UserOriFiles extends BaseModel
{
    //
	protected $connection = 'mysql_vr';
	protected $table = "t_vr_user_ori_resources";
	public $timestamps = false;

	//一个资源所属的用户 反向关联
	public function user(){
		return $this->belongsTo('App\Models\User','author_id','uid');
	}
}
