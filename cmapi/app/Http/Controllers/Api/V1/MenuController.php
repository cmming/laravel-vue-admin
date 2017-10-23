<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Storage;
use App\Models\UserPremissionRole;
use App\Models\PremissionResources;

class MenuController extends BaseController
{
	private $userRole;

	public function __construct(UserPremissionRole $userPremissionRole,PremissionResources $premissionResources)
	{
		$this->userPremissionRole =$userPremissionRole;
		$this->premissionResources =$premissionResources;
	}

	//获取用户的所有信息
	public function index(){
		$menuArr = \File::getRequire(config('api.menuConfig'));
//		dd($menuArr);
		$menu = array_merge($menuArr);
		foreach($menu as $key=>$item){
			if(isset($item['childMenu'])){
				$menu[$key]['childMenu'] = array_merge($item['childMenu']);
			}
		}
		return $this->response->array(['indexMenu'=>$menuArr,'menu'=>$menu]);
	}

	public function destory($id){
		$validator = \Validator::make(['id'=>$id],[
			'id'=>'required',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$indexArr = explode(',',$id);
		$menuArr = \File::getRequire(config('api.menuConfig'));
		if(count($indexArr)>1){
			unset($menuArr[$indexArr[0]]['childMenu'][$indexArr[1]]);
		}else{
			unset($menuArr[$indexArr[0]]);
		}
		//数据缓存
		$content = '<?php return '. var_export($menuArr,true).' ?>';
		\File::put(config('api.menuConfig'), $content);
		return $this->response->noContent();
	}

	public function update(){
		//
		$validator = \Validator::make(request()->all(),[
			'id'=>'required',
			'title'=>'required',
			'path'=>'required',
			'childMenu'=>'json',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$indexArr = explode(',',request('id'));
		$menuArr = \File::getRequire(config('api.menuConfig'));
		$updateData = request(['id','title','path'])+['childMenu'=>json_decode(request('childMenu'),true)];
		if(count($indexArr)>1){
			$menuArr[$indexArr[0]]['childMenu'][$indexArr[1]] = $updateData;
		}else{
			$menuArr[$indexArr[0]]['title'] = request('title');
			$menuArr[$indexArr[0]]['path'] = request('path');
			$menuArr[$indexArr[0]]['iconFont'] = request('iconFont');
		}

		$content = '<?php return '. var_export($menuArr,true).' ?>';
		\File::put(config('api.menuConfig'), $content);
		return $this->response->noContent();
	}

	public function store(){
		$validator = \Validator::make(request()->all(),[
//			'parent_id'=>'required',
			'title'=>'required',
			'path'=>'required',
			'childMenu'=>'json',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$menuArr = \File::getRequire(config('api.menuConfig'));

		if(request()->exists('parent_id')){
			if(!empty($menuArr[request('parent_id')]['childMenu'])){
				$id = end($menuArr[request('parent_id')]['childMenu'])['id'];
				$indexArr = explode(',',$id);
				$idStr = request('parent_id') . ',' . ($indexArr[1]+1);
			}else{
				$idStr = request('parent_id') . ',' . (0);
			}

			$addData = request(['title','path'])+['childMenu'=>json_decode(request('childMenu'),true)]+['id'=>$idStr];
			$menuArr[request('parent_id')]['childMenu'][] = $addData;
		}else{
			$addData = ['id'=>(string)(count($menuArr))] + request(['title','path','iconFont'])+['childMenu'=>json_decode(request('childMenu'),true)];
			$menuArr[] = $addData;
		}
		$content = '<?php return '. var_export($menuArr,true).' ?>';
		\File::put(config('api.menuConfig'), $content);
		return $this->response->created();
	}

	//获取 应有的权限目录
	public function getMenu(){
		//当前 管理员的 角色
		$roles = \Auth::user()->roles->toArray();
		$premissions = [];
		foreach($roles as $role){
			$tmp = $this->userPremissionRole->where('role_id','=',$role['pivot']['role_id'])->get(['premission_id'])->toArray();
			$tmp = array_column($tmp,'premission_id');
			foreach($tmp as $t){
				if(!in_array($t,$premissions)){
					$premissions[]  = $t;
				}
			}
		}
		$resources_id_arr = [];
		$resources = $this->premissionResources->whereIn('premission_id',$premissions)->get(['resources_id'])->toArray();

		foreach($resources as $resource){
			$resources_id_arr = array_merge($resources_id_arr,json_decode($resource['resources_id'],true));
		}

		$result = [];
		$menuArr = \File::getRequire(config('api.menuConfig'));
		foreach($resources_id_arr as $item){
			$indexArr = explode(',',$item);
			if( count($indexArr)>1&&isset($menuArr[$indexArr[0]]['childMenu'][$indexArr[1]])&&isset($menuArr[$indexArr[0]])){
				if(!isset($result[$indexArr[0]])){
					$result[$indexArr[0]] = $menuArr[$indexArr[0]];
					$result[$indexArr[0]]['childMenu'] = [];
				}
				$result[$indexArr[0]]['childMenu'][$indexArr[1]] = $menuArr[$indexArr[0]]['childMenu'][$indexArr[1]];
			}else if(count($indexArr)==1&&isset($menuArr[$indexArr[0]])){
				$result[$indexArr[0]] = $menuArr[$indexArr[0]];
			}
		}
		$menu = array_merge($result);
		foreach($menu as $key=>$item){
			if(isset($item['childMenu'])){
				$menu[$key]['childMenu'] = array_merge($item['childMenu']);
			}
		}
//		dd($result,$menu);

		return $this->response->array(['indexMenu'=>$result,'menu'=>$menu]);

	}

}