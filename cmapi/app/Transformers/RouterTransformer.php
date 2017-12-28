<?php

namespace App\Transformers;

use App\Models\Router;
use League\Fractal\TransformerAbstract;

class RouterTransformer extends TransformerAbstract
{
    public function transform(Router $router)
    {
//        return $router->attributesToArray(
//
//		);
		return [

		];
    }
}
