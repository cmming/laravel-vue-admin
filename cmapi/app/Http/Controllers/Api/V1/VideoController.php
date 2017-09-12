<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Transformers\VideoTransformer;

class VideoController extends BaseController
{
    //获取所有的视屏列表
	public function index(){
		$videos = Video::paginate();
		return $this->response->paginator($videos, new VideoTransformer());
	}
	//添加一个
//	public function store(Request $request){
//		$vali
//	}
}
