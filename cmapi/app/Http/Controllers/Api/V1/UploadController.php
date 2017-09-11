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
		}else{
			return ['id'=>$chunk,'msg'=>'error','code'=>201];
		}

		if($chunk==$chunks-1){

			$fileTypes = explode('/',$request->get('type'));
			$fileType = $fileTypes[1];
			$filespath = storage_path('app\/uploads\/videoTemp'). DIRECTORY_SEPARATOR .$fileMd5;
			$save_file = $fileMd5.'.'.$fileType;
			return $this->file_combine($filespath,$chunks,$save_file);
		}else{
			return ['id'=>$chunk,'msg'=>'ok'];
		}
	}
	//合并文件
	public function file_combine1($file,$chunks, $save_file)
	{
		@set_time_limit(5 * 60);
		if(!\Storage::disk('uploadsVideo')->exists($save_file)){
			//创建最终的文件
			// $isCreate = \Storage::disk('uploadsVideo')->put($save_file,'');
			$outPath = storage_path('app\/uploads\/video'). DIRECTORY_SEPARATOR .$save_file;
			// if($isCreate){
				for ($i = 0; $i<$chunks; $i++) {
					$fileItemPath = $file . '_' . $i . '.part';
					if (\File::exists($fileItemPath) && \File::size($fileItemPath) > 0) {
						  $temp = file_get_contents($fileItemPath);
						  $bool = \Storage::disk('uploadsVideo')->append($save_file, $temp);
						//   $content = \File::getRequire($fileItemPath);
						//   dd($fileItemPath);
						//   while(!(\File::append($outPath, $content))){
						//   	return ['all'=>'文件拼接失败！','msg'=>'error'];
						//   }
					} 
				} 
			// }
			// else
			// {
			// 	return ['all'=>'文件创建失败！','msg'=>'error'];
			// }
		}
		return ['all'=>'之前有'.$chunks,'msg'=>'ok'];
	}
	public function file_combine($file,$chunks, $save_file)
	{
		@set_time_limit(5 * 60);
		if(!\Storage::disk('uploadsVideo')->exists($save_file)){
			//创建最终的文件
			$isCreate = \Storage::disk('uploadsVideo')->put($save_file,'');
			$outPath = storage_path('app\/uploads\/video'). DIRECTORY_SEPARATOR .$save_file;
			 if (!$out = @fopen($outPath, "wb")) {
			  $result ='{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
			 }
			if($isCreate){
				 if ( flock($out, LOCK_EX) ) {
				  for( $index = 0; $index < $chunks; $index++ ) {
				   if (!$in = @fopen("{$file}_{$index}.part", "rb")) {
				    break;
				   }
				   while ($buff = fread($in, 4096)) {
				    fwrite($out, $buff);
				   }
				   @fclose($in);
				   @unlink("{$file}_{$index}.part");
				  }
				  flock($out, LOCK_UN);
				 }
				 @fclose($out);
				  $response = [
				  'success'=>true,
				  'file_id'=>$chunks,
				  ];
			}
			else
			{
				$result = ['all'=>'文件创建失败！','msg'=>'error'];
			}
		}
		 $result =['all'=>'之前有'.$chunks,'msg'=>'ok'];

		 return $result;
	}
	//检测文件是否支持秒传
	public function uploadCheck(Request $request){

		$validator = \Validator::make($request->all(),[
			'fileMd5'=>'required',
			'chunk'=>'required|numeric',
			'chunkSize'=>'required|numeric'
		]);

		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}


		$fileMd5  = $request->get('fileMd5');
		$chunk  = $request->get('chunk');
		$chunkSize  = $request->get('chunkSize');


		$fileItemPath = storage_path('app\/uploads\/videoTemp'). DIRECTORY_SEPARATOR .$fileMd5.'_'.$chunk.'.part';

		if(\File::exists($fileItemPath) && \File::size($fileItemPath) ==$chunkSize){

			$result = ['code'=>200,'msg'=>'存在','ifExist'=>true];
		}else{
			$result = ['code'=>201,'msg'=>'不存在','ifExist'=>false];
		}
		
		return $result;
	}

	public function mergeChunks(Request $request){
		$validator = \Validator::make($request->all(),[
			'fileMd5'=>'required',
			'chunks'=>'required|numeric',
			'ext'=>'required',
		]);

		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}


		$fileMd5  = $request->get('fileMd5');
		$chunks  = $request->get('chunks');
		$ext  = $request->get('ext');


		$filespath = storage_path('app\/uploads\/videoTemp'). DIRECTORY_SEPARATOR .$fileMd5;
		$save_file = $fileMd5.'.'.$ext;
		
		return $this->file_combine($filespath,$chunks,$save_file);
	}

}