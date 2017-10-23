<?php

namespace App\Models;

//用户权限

class PremissionResources extends BaseModel
{
    protected $connection = 'mysql';
    protected $table = "premisison_resources";

	protected $fillable = [
		'premission_id',
		'resources_id'
	];

	//获取 资源




}
