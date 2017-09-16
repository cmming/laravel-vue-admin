<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends BaseController
{
    //测试删除超时文件
	public function tes1t(){
		$files = Storage::disk('uploadsVideoTemp')->allFiles();
		$now = time();
		foreach($files as $file){
			$d1 = Storage::disk('uploadsVideoTemp')->lastModified($file);

			if($now-$d1>config('uploadFile.USER_ORI_FILE_CACHE_TIME')){
				//删除文件
//				Storage::disk('uploadsVideoTemp')->delete($file);
			}
		}
	}

	//创建文件夹测试
	public function test2(){
		$file_path_exist = \File::exists(config('filesystems.disks.uploadsVideo.root'));
		if(!$file_path_exist){
			\File::makeDirectory(config('filesystems.disks.uploadsVideo.root'),0777, true);
		}
	}

	//测试获取 临时文件文件后缀
	public function test()
	{
		return $this->get_tmp_part();
	}
	public function get_tmp_part(){
		$files = Storage::disk('uploadsVideoTemp')->allFiles();
		$md5 = request('md5');
		foreach($files as $key=>$item){
			$files[$key] = intval(str_replace(array($md5.'_','.part'),'',$item));
		}
		asort($files);
		return ['code'=>203,'msg'=>'断点续传','chunk'=>end($files)];
	}
}
