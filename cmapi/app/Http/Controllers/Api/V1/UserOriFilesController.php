<?php
/**
 * Created by PhpStorm.
 * UserOriFiles: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;

use App\Models\UserOriFiles;
use Illuminate\Http\Request;
use App\Transformers\UserOriFilesTransformer;
use JWTAuth;

class UserOriFilesController extends BaseController
{
	//获取用户的所有信息
	public function index(){
		$token = JWTAuth::getToken();
		$id = JWTAuth::getPayload($token)->get('sub');
		$UserOriTmp = UserOriFiles::where('author_id','=',$id)->paginate();
		return $this->response->paginator($UserOriTmp, new UserOriFilesTransformer());
	}
	//获取一个用户的详情
	public function show($id)
	{
		$validator = \Validator::make(['id'=>$id],[
			'id'=>'required|numeric'
		]);

		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$isExist=UserOriFiles::where('id','=',$id)->exists();
		if($isExist){
			// item 是返回单个数据
			return $this->response->item(UserOriFiles::find($id), new UserOriFilesTransformer());
		}else{
			$result=array();
			$result['code']=201;
			$result['msg']='该资源不存在';
			return $this->response->array($result);
		}
	}
	//获取 添加
	public function store(Request $request){
		$validator = \Validator::make($request->all(),[
			'file_name'=>'required',
			'file_size'=>'required|numeric',
			'file_type' => 'required',
			'file_url' => 'required',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}

		$token = JWTAuth::getToken();
		$id = JWTAuth::getPayload($token)->get('sub');
		$file_name = $request->get('file_name');
		$file_size = $request->get('file_size');
		$file_type = $request->get('file_type');
		$file_url = $request->get('file_url');
		$attributes = [
				'author_id' => $id,
				'file_name' => $file_name,
				'file_size' => $file_size,
				'file_type' => $file_type,
				'file_url' => $file_url,
		];
		$user = UserOriFiles::create($attributes);

		return $this->response->created();
	}
	//删除
	public function destroy($id){

		$validator = \Validator::make(['id'=>$id],[
				'id'=>'numeric|unique:t_vr_user_ori_resources',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$isExists = UserOriFiles::where('id','=',$id)->exists();
		if($isExists){
			UserOriFiles::destroy($id);
		}

		return $this->response->noContent();

	}

	public function staticStore($resArr){

		$validator = \Validator::make($resArr,[
			'file_name'=>'required',
			'file_size'=>'required|numeric',
			'file_type' => 'required',
			'file_url' => 'required',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$token = JWTAuth::getToken();
		$id = JWTAuth::getPayload($token)->get('sub');

		$attributes = ['author_id' => $id] + $resArr;
		$user = UserOriFiles::create($attributes);
		return $this->response->created();
	}
}