<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 17:00
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\UserPremission;
use App\Transformers\UserPremissionsTransformer;
use App\Models\Router;

class UserPremissionsController extends BaseController
{

	protected $userPremission;
	protected $router;

	public function __construct(UserPremission $userPremission,Router $router)
	{
		$this->userPremission = $userPremission;
		$this->router = $router;
	}

	public function index(){
		$premissions = $this->userPremission->paginate();

		return $this->response->paginator($premissions,new UserPremissionsTransformer());
	}

	public function store(){
		$validator =\Validator::make(request()->all(),[
			'name'=>'required|min:3|unique:user_premissions,name',
			'desc'=>'required'
		]);
		//
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$premission = $this->userPremission->create(request(['name','desc']));

		return $this->response->created();
	}

	public function show($id)
	{
		$validator = \Validator::make(['id'=>$id],[
			'id'=>'required|numeric'
		]);

		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		//findOrFail 根据主键取出一条数据或抛出异常
		$isExist=$this->userPremission->find($id);

		if($isExist){
			// item 是返回单个数据
			return $this->response->item($isExist, new UserPremissionsTransformer());
		}else{
			$result=array();
			$result['code']=201;
			$result['msg']='该资源不存在';
			return $this->response->array($result);
		}
	}

	public function update($id){
		$userPremission = $this->userPremission->findOrFail($id);
		$validator = \Validator::make(request(['desc']),[
			'desc'=>'required|string',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}

		$userPremission->update(request(['desc']));
		return $this->response->noContent();
	}

	//获取 一个权限拥有的所有路由
	public function routers($id){
		$validator =\Validator::make(['id'=>$id],[
			'id'=>'required|numeric',
		]);
		//
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$userPremission = $this->userPremission->find($id);
		if(!is_null($userPremission)){
			$routers = $userPremission->routers->toArray();
		}else{
			$routers = [];
		}
		$result = array();
		foreach($routers as $router){
			$result[] = $router['id'];
		}

		return $this->response->array($result);
	}

	//为用户权限添加 路由权限
	public function storeRouter($id){
		//
		$validator = \Validator::make(['id'=>$id]+request(['routers_id']),[
			'id'=>'required|numeric',
			'routers_id'=>'required',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$userPremission = $this->userPremission->find($id);
		//当前 权限拥有的路由
		$premissionRouters = $userPremission->routers;
		//获取 选中路由
		$routers_id = json_decode(request('routers_id'),true);
		$checkRouter = $this->router->findMany($routers_id);
		//添加的路由权限
		$add_routers = $checkRouter->diff($premissionRouters);
		foreach($add_routers as $add_router){
			$userPremission->add_routers($add_router);
		}
		//删除的路由
		$delete_routers = $premissionRouters->diff($checkRouter);
		foreach($delete_routers as $delete_router){
			$userPremission->delete_routers($delete_router);
		}
//		(new RouterController('App\Models\Router'))->createRouterMap();
		return $this->response->created();
	}

}