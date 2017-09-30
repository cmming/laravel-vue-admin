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
	private $userOriFiles;

	public function __construct(UserOriFiles $userOriFiles)
	{
		$this->userOriFiles = $userOriFiles;
	}


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

		$id = \Auth::id();

		//多条件模糊查询
		$UserOriTmp = $this->userOriFiles->where(function($query)use($id){
			$query->where('file_name','like','%'.request('file_name').'%')->where('author_id','=',$id);
		})->paginate();

		return $this->response->paginator($UserOriTmp, new UserOriFilesTransformer());
	}
	//获取一个用户资源的详情
	public function show($id)
	{
		$validator = \Validator::make(['id'=>$id],[
			'id'=>'required|numeric'
		]);

		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		//findOrFail 根据主键取出一条数据或抛出异常
		$isExist=$this->userOriFiles->find($id);

		if($isExist){
			// item 是返回单个数据
			return $this->response->item($isExist, new UserOriFilesTransformer());
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
		$userOriFile = $this->userOriFiles->create($attributes);
		$location = dingo_route('v1', 'userOriFiles.show', $userOriFile->id);
		// 协议里是这么返回，把资源位置放在header里面
		return $this->response->created($location);
	}
	//删除
	public function destroy($id){
		$validator = \Validator::make(['id'=>$id],[
				'id'=>'numeric|unique:t_vr_user_ori_resources',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$userOriFile = UserOriFiles::find($id);
		//权限验证
		if (\Gate::denies('delete', $userOriFile)){
			// 禁止访问
			return $this->response->errorForbidden('禁止访问');
		}
		$isExists = UserOriFiles::where('id','=',$id)->exists();
		if($isExists){
			UserOriFiles::destroy($id);
		}

		return $this->response->noContent();

	}

	public function update($id){
		//侧路模式的权限判断
		$userOriFile = $this->userOriFiles->findOrFail($id);
		//策略模式 认证用户权限  （不会自定义控制异常，所以不用之中）
		//$this->authorize('update',$userOriFile);
		if (\Gate::denies('update', $userOriFile)){
			// 禁止访问
			return $this->response->errorForbidden('禁止访问');
		}
		$validator = \Validator::make(request(['file_name']),[
			'file_name'=>'required|string',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}

		$userOriFile->update(request(['file_name']));

		return $this->response->noContent();

	}
}