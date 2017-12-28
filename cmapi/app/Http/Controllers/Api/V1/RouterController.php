<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;

use App\Models\Router;
use App\Transformers\RouterTransformer;

class RouterController extends BaseController
{
	private $userRole;

	public function __construct(Router $router)
	{
		$this->router =$router;
	}

	public function index(){
		$user_roles_info = \Auth::user()->roles->toArray();
		$user_roles = array();
		foreach($user_roles_info as $user_role_info){
			$user_roles[] = $user_role_info['id'];
		}
		$routerConfig = \File::getRequire(config('api.routerConfig'));

		foreach($user_roles as $user_role){
			$routerConfig = $this->hasPremission($user_role,$routerConfig);
		}
		return $routerConfig;
	}

	public function all(){
		return \File::getRequire(config('api.routerConfig'));
	}

	public function hasPremission($role,$baseRouter){
		foreach($baseRouter as $key=>$value){
			$role_arr = $value['meta']['role'];
			if(empty($role_arr)||!in_array($role,$role_arr)){
				unset($baseRouter[$key]);
			}else{
				foreach($value['children'] as $k=>$val){
					$role_arr = $val['meta']['role'];
					if(empty($role_arr)||!in_array($role,$role_arr)){
						unset($baseRouter[$key]['children'][$k]);
					}
				}
//				$this->hasPremission($role,$value['children']);
			}
		}
		return $baseRouter;
	}

	//保存一个路由
	public function store(){
		$canEmptyPam = $this->noMustHas(
			array(
				array('parent_id'=>'numeric'),
			)
		);
		$parent_id = isset($canEmptyPam['parent_id'])?$canEmptyPam['parent_id']:'';
		$validator = \Validator::make(request(['title','path','componentPath','type','sort']),[
			'title'=>'required|string',
			'path'=>'required|string',
			'componentPath'=>'required|string',
			'type'=>'required|string',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}

		if($parent_id!=''){
			$router = $this->router->create(request(['title','path','componentPath','type','sort']));
			//插入一条关系表  找到 父路由的模型，进行 模型保存
			$res = $this->router->find($parent_id)->add_son_router($router);

		}else{
			$router = $this->router->create(request(['title','path','iconFont','componentPath','type','sort']+['has_son'=>1]));

		}
		if($this->createRouterMap()){
			return $this->response->created();
		}else{
			return $this->response->array(array('code'=>201,'msg'=>'创建失败'));
		}
	}

	//根据路由表生成 前端想要的路由
	public function createRouterMap(){
		//所有的路由
		$routers = $this->router->all()->toArray();
		foreach($routers as $key=>$router){
			$router_roles = $this->router->find($router['id'])->roles();
//			dd($router['id'],$router_roles);
			$routers[$key]['meta'] = [
				'auth'=>true,
				'title'=>$routers[$key]['title'],
				'role'=>$router_roles,
			];
			$routers[$key]['component'] = "resolve => require(['".config('api.ansycViewMap').$routers[$key]['componentPath']."'], resolve)";
			unset($routers[$key]['created_at']);
			unset($routers[$key]['updated_at']);
//			unset($routers[$key]['title']);
			unset($routers[$key]['pivot']);

			$son_routers = $this->router->find($router['id'])->son_routers->toArray();
			foreach($son_routers as $k=>$son_router){
				$router_roles = $this->router->find($son_router['id'])->roles();
				$son_routers[$k]['parent_id'] = $router['id'];
				$son_routers[$k]['meta'] = [
					'auth'=>true,
					'title'=>$son_routers[$k]['title'],
					'role'=>$router_roles,
				];
				$son_routers[$k]['component'] = "resolve => require(['".config('api.ansycViewMap').$son_routers[$k]['componentPath']."'], resolve)";
				unset($son_routers[$k]['created_at']);
				unset($son_routers[$k]['updated_at']);
//				unset($son_routers[$k]['title']);
				unset($son_routers[$k]['pivot']);
			}

			//为 子路由 进行格式化
			if($router['has_son']){
					$routers[$key]['children'] = array_values($son_routers);
			}else{
				unset($routers[$key]);
			}

		}
		//将 数组 进行 保存
		$routers = array_values($routers);
		$content = '<?php return '. var_export($routers,true).' ?>';
		if($res = \File::put(config('api.routerConfig'), $content)){
			//同时生成一个 动态路由 的文件 ansycRouterMap.js
			$content = 'export const ansycRouterMap1 ='. json_encode($routers);
			//处理content 中作为 view 引入的双引号
			$content = str_replace('resolve)"','resolve)',$content);
			$content = str_replace('"resolve','resolve',$content);
			$res = \File::put(config('api.ansycRouterMap'), $content);
		}
		return $res;

	}

	public function update(){
		$canEmptyPam = $this->noMustHas(
			array(
				array('parent_id'=>'numeric'),
			)
		);
		$parent_id = isset($canEmptyPam['parent_id'])?$canEmptyPam['parent_id']:'';
		$validator = \Validator::make(request(['id','title','path','componentPath','type','sort']),[
			'id'=>'required|numeric|exists:routers,id',
			'title'=>'required|string',
			'path'=>'required|string',
			'componentPath'=>'required|string',
			'type'=>'required|string',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$update_router = $this->router->find(request('id'));
		if($parent_id!=''){
			$router = $update_router->update(request(['title','path','componentPath','type','sort']));

		}else{
			$router = $update_router->update(request(['title','path','iconFont','componentPath','type','sort']));

		}
		if($this->createRouterMap()){
			return $this->response->noContent();
		}else{
			return $this->response->array(array('code'=>201,'msg'=>'修改创建文件失败'));
		}
	}

}