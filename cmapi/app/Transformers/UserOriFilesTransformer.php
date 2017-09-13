<?php

namespace App\Transformers;

use App\Models\UserOriFiles;
use League\Fractal\TransformerAbstract;

class UserOriFilesTransformer extends TransformerAbstract
{
	public function transform(UserOriFiles $userOriFiles)
	{
		return $userOriFiles->attributesToArray();
	}
}
