<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 17:00
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\UserRole;
use App\Models\UserPremission;
use App\Transformers\UserRolesTransformer;

class UserRolesController extends BaseController
{

	protected $userRole;

	public function __construct(UserRole $userRole,UserPremission $userPremission)
	{
		$this->userRole = $userRole;
		$this->premissions = $userPremission;
	}

	public function index(){
		$userRoles = $this->userRole->paginate();
		\Log::info($userRoles->toArray());
		return $this->response->paginator($userRoles,new UserRolesTransformer());
	}

	public function store(){
		$validator =\Validator::make(request()->all(),[
			'name'=>'required|min:3|unique:user_roles,name',
			'desc'=>'required'
		]);
		//
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$premission = $this->userRole->create(request(['name','desc']));

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
		$isExist=$this->userRole->find($id);

		if($isExist){
			// item 是返回单个数据
			return $this->response->item($isExist, new UserRolesTransformer());
		}else{
			$result=array();
			$result['code']=201;
			$result['msg']='该资源不存在';
			return $this->response->array($result);
		}
	}

	public function update($id){
		$userRoles = $this->userRole->findOrFail($id);
		$validator = \Validator::make(request(['name','desc']),[
			'name'=>'required|string',
			'desc'=>'required|string',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}

		$userRoles->update(request(['name','desc']));
		return $this->response->noContent();
	}

	//返回当前角色拥有 的权限
	public function premissions($id){
		$premissions = [];
		$rolePremissions = $this->userRole->find($id)->premissions;
		foreach($rolePremissions as $rolePremission){
			$premissions[] = $rolePremission['id'];
		}
		return $this->response->array($premissions);
	}

	//
	public function premissionStore($id){
		$validator = \Validator::make(request(['premissions']),[
			'premissions'=>'required|array',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		//当前的 角色
		$userRole = $this->userRole->find($id);
		//已经拥有的权限
		$rolePremissions = $userRole->premissions;
		//选中的权限
		$checkRolePremissions = $this->premissions->findMany(request('premissions'));
		//获取添加的权限
		$addRolePremissions = $checkRolePremissions->diff($rolePremissions);
		foreach($addRolePremissions as $addRolePremission){
			$userRole->grantPremission($addRolePremission);
		}
		//获取减少的权限
		$deleteRolePremissions = $rolePremissions->diff($checkRolePremissions);
		foreach($deleteRolePremissions as $deleteRolePremission){
			$userRole->deletePremission($deleteRolePremission);
		}
//		dd($addRolePremissions,$deleteRolePremissions);
		return $this->response->noContent();
	}


}