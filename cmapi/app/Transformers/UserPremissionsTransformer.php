<?php

namespace App\Transformers;

use App\Models\UserPremission;
use League\Fractal\TransformerAbstract;

class userPremissionsTransformer extends TransformerAbstract
{
    public function transform(UserPremission $userPremission)
    {
		return [
			'id'=>$userPremission['id'],
			'name'=>$userPremission['name'],
			'desc'=>$userPremission['desc'],
		];
//        return $userPremission->attributesToArray();
    }
}
