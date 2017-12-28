<?php

namespace App\Transformers;

use App\Models\UserRole;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;

class UserRolesTransformer extends TransformerAbstract
{
	//默认  可以包含的 资源 这里 针对的是 model 中的数据 根据不同的资源 返回不同的数据
	protected $availableIncludes = ['premissions'];

    public function transform(UserRole $userRole,ParamBag $params = null)
    {
//		return [
//			'id'=>$userRole['id'],
//			'name'=>$userRole['name'],
//			'desc'=>$userRole['desc'],
//		];
        return $userRole->attributesToArray();
    }

	//包含 权限的转换器
	public function includePremission(UserRole $userRole){
		return $this->item($userRole->premissions(),new userPremissionsTransformer());
	}
}
