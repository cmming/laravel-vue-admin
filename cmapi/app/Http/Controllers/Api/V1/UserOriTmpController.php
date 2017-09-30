<?php
/**
 * Created by PhpStorm.
 * UserOriTmp: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;

use App\Models\UserOriTmp;
use Illuminate\Http\Request;
use App\Transformers\UserOriTmpTransformer;
use JWTAuth;
use App\Models\UserOriFiles;
use App\Models\UserOriRel;


class UserOriTmpController extends BaseController
{
	private $userOriFiles;
	private $userOriTmp;
	private $userOriRel;

	public function __construct(UserOriFiles $userOriFiles,UserOriTmp $userOriTmp,UserOriRel $userOriRel)
	{
		$this->userOriFiles = $userOriFiles;
		$this->userOriTmp = $userOriTmp;
		$this->userOriRel = $userOriRel;
	}

	//获取用户的所有信息
	public function index(){
//		$token = JWTAuth::getToken();
//		$id = JWTAuth::getPayload($token)->get('sub');
		$id = \Auth::id();
		//添加搜索 条件
		$UserOriTmp = $this->userOriTmp->where(function($query)use($id){
			$query->where('title','like','%'.request('title').'%')->where('authorid','=',$id);
		})->paginate();
//		$UserOriTmp = UserOriTmp::where(function($query)use($id){
//			$query->where('title','like','%'.request('title').'%')->where('authorid','=',$id);
//		})->paginate();
//		$UserOriTmp = UserOriTmp::where('authorid','=',$id)->paginate();
		return $this->response->paginator($UserOriTmp, new UserOriTmpTransformer());
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
		$userOriTmp = $this->userOriTmp->findOrFail($id);

		return $this->response->item($userOriTmp, new UserOriTmpTransformer());
	}
	//获取 添加
	public function store(Request $request){
		//获取管理员的id
		$validator = \Validator::make($request->all(),[
			'vid'=>'required|numeric',
			'tid'=>'required|numeric',
			'title'=>'required',
			'des' => 'required',
			'att' => 'required|json',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}

		$attributesUser = request(['tid','title','des','att']);
		//根据vid 查询相应的不可变参数
		$attributesVideo = $this->userOriFiles->find(request('vid'))->toArray();
		$attributesVideos = [];
		foreach($attributesVideo as $key=>$item){
			$attributesVideos['down_url']= $attributesVideo['file_url'];
			$attributesVideos['fsize']= $attributesVideo['file_size'];
			$attributesVideos['ftype']=$attributesVideo['file_type'];
			$attributesVideos['authorid']=$attributesVideo['author_id'];
			$attributesVideos['author']=$attributesVideo['author'];
			$attributesVideos['fname']=$attributesVideo['file_name'];
		}
		$attributes = $attributesUser + $attributesVideos;
//		dd($attributes);
		$userOriTmp = $this->userOriTmp->create($attributes)->toArray();
		if($userOriTmp['mid']){
			//写入关系表
			$temp = ['uid'=>$attributesVideos['authorid'],'mid'=>$userOriTmp['mid']];
			$rel = UserOriRel::create($temp)->toArray();
			if($rel['id']){
				return $this->response->created();
			}
		}else{
			//回滚之前的插入数据
			UserOriTmp::destroy($userOriTmp['mid']);
			return $this->response->errorInternal('数据库执行失败');
		}
	}
	//更新
	public function update($id){

		$validator = \Validator::make(request()->all(),[
			'vid'=>'required|numeric',
			'tid'=>'required|numeric',
			'title'=>'required',
			'des' => 'required',
			'att' => 'required|json',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
//		$userOriTmp =UserOriTmp::findOrFail($id);
		//看参数是否合法
		$is_exists = UserOriTmp::where('mid','=',request('vid'))->exists();
		if($is_exists){
			$userOriTmp = UserOriTmp::where('mid','=',request('vid'))->update(request(['tid','title','des','att']));
			if($userOriTmp){
				return $this->response->noContent();
			}else{
				return $this->response->errorInternal('数据库操作失败');
			}
		}else{
			//资源不存在
			return $this->response->errorNotFound();
		}

	}
	//删除
	public function destroy($id){

		$validator = \Validator::make(['id'=>$id],[
				'id'=>'numeric',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$isExists = UserOriTmp::where('mid','=',$id)->exists();
		if($isExists){
			$is_destory = UserOriTmp::destroy($id);
			$token = JWTAuth::getToken();
			$user_id = JWTAuth::getPayload($token)->get('sub');
			$rel_arr = ['uid'=>$user_id,'mid'=>$id];
			if($is_destory){
				$id_del = UserOriRel::where($rel_arr)->delete();
				if($id_del){
					return ['code'=>200,'msg'=>'删除成功'];
				}else{
					return ['code'=>201,'msg'=>'删除失败'];
				}
			}
		}else{
			return ['code'=>201,'msg'=>'删除失败'];
		}
	}
}