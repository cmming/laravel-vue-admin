<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

class UserOriRel extends BaseModel
{
    //
	protected $connection = 'mysql_vr';
	protected $table = "t_user_ori_relation";
	public $timestamps = false;
}
