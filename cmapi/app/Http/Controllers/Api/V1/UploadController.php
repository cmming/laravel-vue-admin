<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\UserOriFilesController;
use Illuminate\Support\Facades\Storage;

class UploadController extends BaseController
{
	//获取用户的所有信息
	public function index(Request $request)
	{
		$file = $request->file('file');
		$chunk = $request->get('chunk');
		$chunks = $request->get('chunks');
		$fileMd5 = $request->get('md5');
		//创建缓存文件
		$uploadsVideoTemp = config('filesystems.disks.uploadsVideoTemp.root');
		$file_path_exist = \File::exists($uploadsVideoTemp);
		if(!$file_path_exist){
			\File::makeDirectory($uploadsVideoTemp,0777, true);
		}
		if ($file->isValid()) {
			$originalName = $file->getClientOriginalName();
			$ext = $file->getClientOriginalExtension();
			//临时绝对路径
			$realpath = $file->getRealPath();
			$filename = $fileMd5 . '_' . $chunk . '.part';

			$bool = Storage::disk('uploadsVideoTemp')->put($filename, file_get_contents($realpath));
			return ['id' => $chunk, 'msg' => '文件接受成功', 'code' => 200];
		} else {
			return ['id' => $chunk, 'msg' => '文件接受失败', 'code' => 201];
		}
	}


	public function file_combine($file, $chunks, $save_file,$fileParams)
	{
		@set_time_limit(5 * 60);
		//缓存文件
		$uploadsVideo = config('filesystems.disks.uploadsVideo.root');
		$file_path_exist = \File::exists($uploadsVideo);
		if(!$file_path_exist){
			\File::makeDirectory($uploadsVideo,0777, true);
		}

		if (!\Storage::disk('uploadsVideo')->exists($save_file)) {
			//创建最终的文件
			$isCreate = \Storage::disk('uploadsVideo')->put($save_file, '');
			$outPath = $uploadsVideo . DIRECTORY_SEPARATOR . $save_file;
			if (!$out = @fopen($outPath, "wb")) {
				$result = ['all' => '文件打开失败！', 'msg' => 'error'];
			}
			if ($isCreate) {
				if (flock($out, LOCK_EX)) {
					for ($index = 0; $index < $chunks; $index++) {
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
				//向用户资源表中写入一条数据
				$UserOriFilesController = new UserOriFilesController();
				$file_url = str_replace(config('uploadFile.USER_ORI_FILE_SERVICE_DEFAULT_PATH'),config('uploadFile.USER_ORI_FILE_CACHE_URL'),$outPath);
				$fileParams = $fileParams + ['file_url'=>$file_url];
				$UserOriFilesController->staticStore($fileParams);
				$response = [
					'success' => true,
					'file_id' => $chunks
				];
			} else {
				$result = ['all' => '文件创建失败！', 'msg' => 'error'];
			}
		}
		$result = ['all' => '之前有' . $chunks, 'msg' => 'ok','code'=>'202'];

		return $result;
	}

	//检测文件是否支持秒传
	public function uploadCheck(Request $request)
	{

		$validator = \Validator::make($request->all(), [
			'fileMd5' => 'required',
			'chunk' => 'required|numeric',
			'chunkSize' => 'required|numeric'
		]);

		if ($validator->fails()) {
			return $this->errorBadRequest($validator);
		}


		$fileMd5 = $request->get('fileMd5');
		$chunk = $request->get('chunk');
		$chunkSize = $request->get('chunkSize');


		$fileItemPath = config('filesystems.disks.uploadsVideoTemp.root') . DIRECTORY_SEPARATOR . $fileMd5 . '_' . $chunk . '.part';

		if (\File::exists($fileItemPath) && \File::size($fileItemPath) == $chunkSize) {

			$result = ['code' => 200, 'msg' => '存在', 'ifExist' => true,'chunk'=>$chunk];
		} else {
			$result = ['code' => 201, 'msg' => '不存在', 'ifExist' => false,'chunk'=>$chunk];
		}

		return $result;
	}
	//请求让后台开始拼接碎片
	public function mergeChunks(Request $request)
	{
		//清空3天之前的分片碎片
		$this->del_video_tmp();
		$validator = \Validator::make($request->all(), [
			'fileMd5' => 'required',
			'chunks' => 'required|numeric',
			'ext' => 'required',
			'fileParams'=>'required|array'
		]);
		if ($validator->fails()) {
			return $this->errorBadRequest($validator);
		}
		$fileMd5 = $request->get('fileMd5');
		$chunks = $request->get('chunks');
		$ext = $request->get('ext');


		$filespath = config('filesystems.disks.uploadsVideoTemp.root') . DIRECTORY_SEPARATOR . $fileMd5;
		$save_file = $fileMd5 . '.' . $ext;

		return $this->file_combine($filespath, $chunks, $save_file,$request->get('fileParams'));
	}
	//检测是否上传过
	public function checkIsUploaded(Request $request)
	{
		$result = [];
		$validator = \Validator::make($request->all(), [
			'fileMd5' => 'required',
			'file_size' => 'required',
			'md5'=>'required',
		]);
		$fileItemPath = config('filesystems.disks.uploadsVideo.root') . DIRECTORY_SEPARATOR . $request->get('fileMd5');
		if (\Storage::disk('uploadsVideo')->exists($request->get('fileMd5'))&&(\File::size($fileItemPath)==$request->get('file_size'))) {
			$result = ['all' => '文件已经存在', 'msg' => 'ok','code'=>'202'];
		}else{
			$result = $this->get_tmp_part($request->get('md5'));
		}
		return $result;
	}

	/**
	 * 清空3天之前的碎片文件
	 */
	public function del_video_tmp(){
		$files = Storage::disk('uploadsVideoTemp')->allFiles();
		$now = time();
		foreach($files as $file){
			$d1 = Storage::disk('uploadsVideoTemp')->lastModified($file);
			if($now-$d1>config('uploadFile.USER_ORI_FILE_CACHE_TIME')){
				//删除文件
				Storage::disk('uploadsVideoTemp')->delete($file);
			}
		}
	}
	/**
	 * 获取断点续传的 片数
	 */
	public function get_tmp_part($md5){
		$files = Storage::disk('uploadsVideoTemp')->allFiles();
//		dd($files,$md5);
		foreach($files as $key=>$item){
			$files[$key] = intval(str_replace(array($md5.'_','.part'),'',$item));
		}
		asort($files);
		$chunk = end($files)-3;
		if($chunk>1){
			return ['code'=>203,'msg'=>'断点续传','chunk'=>end($files)];
		}else{
			return ['code'=>204,'msg'=>'不能断点续传'];
		}
	}

}