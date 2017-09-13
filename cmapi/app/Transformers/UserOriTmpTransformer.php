<?php

namespace App\Transformers;

use App\Models\UserOriTmp;
use League\Fractal\TransformerAbstract;

class UserOriTmpTransformer extends TransformerAbstract
{
	public function transform(UserOriTmp $userOriTmp)
	{
		return $userOriTmp->attributesToArray();
	}
}
