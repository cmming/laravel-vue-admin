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

		$sear_arr = $this->noMustHas(
			array(
				array('limit'=>'numeric'),
				array('btime'=>'date_format:Y-m-d'),
				array('etime'=>'date_format:Y-m-d'),
				array('isExcel'=>'string'),
			)
		);
		//处理 搜索 参数
		$limit = isset($sear_arr['limit'])?$sear_arr['limit']:15;
		$btime = isset($sear_arr['btime'])?$sear_arr['btime']:'';
		$etime =  isset($sear_arr['etime'])?$sear_arr['etime']:'';
		$isExcel =  isset($sear_arr['isExcel'])?$sear_arr['isExcel']:'false';

		$users = $this->user->where(function($query)use($btime,$etime){
			if($etime!=''){
				$query->where('ctime','>=',$btime.(' 00:00:00'))->where('ctime','<=',$etime.(' 23:59:59'));
			}else{
				$query->where('ctime','>=',$btime.(' 00:00:00'));
			}
		});
		if($isExcel!='false'){
			return $this->response->array(['data'=>$users->get()->toArray()]);
		}else{
			$users = $users->paginate($limit);
		}
//		$users = $this->user->paginate();

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