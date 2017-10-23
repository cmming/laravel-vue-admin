<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 17:00
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\UserPremission;
use App\Transformers\userPremissionsTransformer;

class userPremissionsController extends BaseController
{

	protected $userPremission;

	public function __construct(UserPremission $userPremission)
	{
		$this->userPremission = $userPremission;
	}

	public function index(){
		$premissions = $this->userPremission->paginate();

		return $this->response->paginator($premissions,new userPremissionsTransformer());
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
			return $this->response->item($isExist, new userPremissionsTransformer());
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

}