<?php
/**
 * Created by PhpStorm.
 * UserOriFiles: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;

use App\Models\UserOriFiles;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\UserOriFilesTransformer;
use JWTAuth;

class UserOriFilesController extends BaseController
{
	//获取用户的所有信息
	public function index(){
		//添加搜索条件
		$search_arr = [];
//		if(request('file_name')){
//			$search_arr['file_name'] = request('file_name');
//		}
//		if(request('btime')){
//			$search_arr['btime'] = request('btime');
//		}
//		if(request('etime')){
//			$search_arr['etime'] = request('etime');
//		}

		$token = JWTAuth::getToken();
		$id = JWTAuth::getPayload($token)->get('sub');
		$search_arr['author_id'] = $id;
		//多条件模糊查询
		$UserOriTmp = UserOriFiles::where(function($query)use($id){
			$query->where('file_name','like','%'.request('file_name').'%')->where('author_id','=',$id);
		})->paginate();
//		$UserOriTmp = UserOriFiles::where($search_arr)->paginate();
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

		//获取用户的名字
		$user_info = User::find($id)->toArray();

		$attributes = ['author_id' => $id,'author'=>$user_info['nick']] + $resArr;

		$user = UserOriFiles::create($attributes);
		return $this->response->created();
	}

	public function update($id){
		//侧路模式的权限判断

//		$userOriFile = UserOriFiles::find($id)->author_id;
//		$isok = $this->authorizeForUser(\Auth::user(),'update',$userOriFile);
//		dd($isok);
		$validator = \Validator::make(request(['file_name']),[
			'file_name'=>'required|string',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$userOriFiles =UserOriFiles::findOrFail($id);
		$isUpdate = $userOriFiles->update(request(['file_name']));
		if($isUpdate){
			return $this->response->item($userOriFiles, new UserOriFilesTransformer());
		}else{
			return $this->response->errorNotFound();
		}
	}
}