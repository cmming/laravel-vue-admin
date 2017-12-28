<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 17:00
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\PremissionResources;

class UserPremissionsResourcesController extends BaseController
{

	protected $premissonResources;

	public function __construct(PremissionResources $premissionResources)
	{
		$this->premissonResources = $premissionResources;
	}

	public function premissonResources($id){
		$validator =\Validator::make(['id'=>$id],[
			'id'=>'required|numeric',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$premissonResources = $this->premissonResources->where('premission_id','=',$id)->first();

		return $this->response->array($premissonResources);
	}

	public function store(){
		$validator =\Validator::make(request()->all(),[
			'premission_id'=>'required|numeric',
			'resources_id'=>'required',
		]);
		//
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		if($this->premissonResources->where('premission_id','=',request('premission_id'))->exists()){
			$this->premissonResources->where('premission_id','=',request('premission_id'))->update(['resources_id' => request('resources_id')]);
			return $this->response->noContent();
		}else{
			$premission = $this->premissonResources->create(request(['premission_id','resources_id']));
			return $this->response->created();
		}
	}

}