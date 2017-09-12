<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/6
 * Time: 14:58
 */
namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;

class UserController extends BaseController
{
	//获取用户的所有信息
	public function index(){
//		$users = User::orderBy('created_at','desc')->paginate(10);
//		return $users;
		$users = User::paginate();

		return $this->response->paginator($users, new UserTransformer());
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
		$user = User::findOrFail($id);

		return $this->response->item($user, new UserTransformer());
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
		$user = User::create($attributes);

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
		$user =User::findOrFail($id);
		$user->update(request(['name','email']));

		return $this->response->item($user, new UserTransformer());
	}
	//删除
	public function destroy($id){

		$validator = \Validator::make(['id'=>$id],[
				'id'=>'numeric',
		]);
		if($validator->fails()){
			return $this->errorBadRequest($validator);
		}
		$isExists = User::where('id','=',$id)->exists();
		if($isExists){
			User::destroy($id);
		}

		return $this->response->noContent();

	}
}