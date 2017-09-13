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

class UserOriTmpController extends BaseController
{
	//获取用户的所有信息
	public function index(){
		$token = JWTAuth::getToken();
		$id = JWTAuth::getPayload($token)->get('sub');
		$UserOriTmp = UserOriTmp::where('authorid','=',$id)->paginate();
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
		$user = UserOriTmp::findOrFail($id);

		return $this->response->item($user, new UserOriTmpTransformer());
	}
	//获取 添加
	public function store(Request $request){
		$validator = \Validator::make($request->all(),[
			'name'=>'required|string',
			'email'=>'required|email|unique:users',
			'password' => 'required',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}

		$email = request('email');
		$password = request('password');

		$attributes = [
				'email' => $email,
				'name' => request('name'),
				'password' => app('hash')->make($password),
		];
		$user = UserOriTmp::create($attributes);

		return $this->response->created();
	}
	//更新
	public function update($id){
		$validator = \Validator::make(request(['name','email']),[
				'name'=>'required|string',
//				'email'=>'required|email|unique:users',
				'email'=>'required|email',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$user =UserOriTmp::findOrFail($id);
		$user->update(request(['name','email']));

		return $this->response->item($user, new UserOriTmpTransformer());
	}
	//删除
	public function destroy($id){

		$validator = \Validator::make(['id'=>$id],[
				'id'=>'numeric',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$isExists = UserOriTmp::where('id','=',$id)->exists();
		if($isExists){
			UserOriTmp::destroy($id);
		}

		return $this->response->noContent();

	}
}