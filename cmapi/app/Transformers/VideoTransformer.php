<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 17:38
 */

namespace App\Transformers;


use App\Models\Video;
use League\Fractal\TransformerAbstract;

class VideoTransformer extends TransformerAbstract
{
	public function transform(Video $video)
	{
		return $video->attributesToArray();
	}
}