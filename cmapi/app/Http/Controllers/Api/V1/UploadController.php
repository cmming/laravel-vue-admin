<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;

class UploadController extends BaseController
{
	//获取用户的所有信息
	public function index(Request $request)
	{
		$file = $request->file('file');
		$chunk = $request->get('chunk');
		$chunks = $request->get('chunks');
		$fileMd5 = $request->get('md5');
		if ($file->isValid()) {
			$originalName = $file->getClientOriginalName();
			$ext = $file->getClientOriginalExtension();
			//临时绝对路径
			$realpath = $file->getRealPath();
			$filename = $fileMd5 . '_' . $chunk . '.part';

			$bool = \Storage::disk('uploadsVideoTemp')->put($filename, file_get_contents($realpath));
		}

		if($chunk==$chunks-1){

			$fileTypes = explode('/',$request->get('type'));
			$fileType = $fileTypes[1];
			$filespath = storage_path('app\/uploads\/videoTemp'). DIRECTORY_SEPARATOR .$fileMd5;
			$save_file = $fileMd5.'.'.$fileType;
			$this->file_combine($filespath,$chunks,$save_file);
		}else{
			return ['id'=>$chunk,'msg'=>'ok'];
		}
	}
	//合并文件
	public function file_combine($file,$chunks, $save_file)
	{
		if(!\Storage::disk('uploadsVideo')->exists($save_file)){
			for ($i = 0; $i<$chunks; $i++) {
				$fileItemPath = $file . '_' . $i . '.part';
				if (\File::exists($fileItemPath) && \File::size($fileItemPath) > 0) {
					$bool = \Storage::disk('uploadsVideo')->append($save_file, file_get_contents($fileItemPath));
				} else {
					return false;
				}
			}
			return ['all'=>$chunks,'msg'=>'ok'];
		}
		return ['all'=>$chunks,'msg'=>'ok'];
	}
	//检测文件是否支持秒传
	public function chunkNum(Request $request){
		$fileMd5  = $request->get('md5');
		$fileTypes = explode('/',$request->get('type'));
		$fileType = $fileTypes[1];
		$file_name = $fileMd5.'.'.$fileType;
		if(!\Storage::disk('uploadsVideo')->exists($file_name)){
			return ['code'=>200,'msg'=>'ok'];
		}else{
			//是否支持分片
			return ['code'=>202,'msg'=>'支持断点','id'=>'chunkNum'];
		}
		return ['code'=>203,'msg'=>'不存在'];
	}

}