<?php

namespace App\Transformers;

use App\Models\UserOriTmp;
use League\Fractal\TransformerAbstract;

class UserOriTmpTransformer extends TransformerAbstract
{
	public function transform(UserOriTmp $userOriTmp)
	{
		return $userOriTmp->attributesToArray();
//		return [
//			'id' => $user->id,
//			'name' => $user->name,
//			'email' => $user->email,
//			'phone' => $user->phone,
//		];
	}
}
