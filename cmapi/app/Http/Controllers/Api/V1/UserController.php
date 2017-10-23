<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;

class UserController extends BaseController
{
	protected $user;
	protected $userRole;

	public function __construct(User $user,UserRole $userRole)
	{
		$this->user = $user;
		$this->userRole = $userRole;
	}

	//获取用户的所有信息
	public function index(){
		$users = $this->user->paginate();

		return $this->response->paginator($users, new UserTransformer());
	}
	public function roles($id){
		$roles = [];
		$userRoles = $this->user->find($id)->roles;
		foreach($userRoles as $userRole){
			$roles[] = $userRole['id'];
		}
		return $this->response->array($roles);
	}
	public function storeRoles($id){
		$validator = \Validator::make(request(['roles']),[
			'roles'=>'required|array',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		//当前user 集合
		$user = $this->user->find($id);
		$userRoles = $user->roles;
		//接受的参数
		$checkUserRoles = $this->userRole->findMany(request('roles'));

		//添加的 角色
		$addRoles = $checkUserRoles->diff($userRoles);

		foreach($addRoles as $addRole){
			$user->addRoles($addRole);
		}
		//减少的角色
		$deleteRoles  = $userRoles->diff($checkUserRoles);
		foreach ($deleteRoles as $deleteRole) {
			$user->deleteRole($deleteRole);
		}

		return $this->response->noContent();
	}
}