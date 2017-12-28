<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10
 * Time: 16:42
 */

namespace App\Http\Controllers\Blog;

use App\Models\Blog\User;


class UserController extends BaseController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function signIn()
    {
        return view('blog.sign.signIn');
    }

    public function signUp()
    {
        return view('blog.sign.singnUp');
    }

    //注册 保存
    public function signUpStore()
    {
        //数据验证
//        dd(request()->all());
        $this->validate(request(), [
            'name' => 'required|unique:mysql_blog.users,name',
            'email' => 'required|min:3|unique:mysql_blog.users,email|email',
            'password' => 'required|min:5|confirmed'
        ]);

        $password = bcrypt(request('password'));
        $name = request('name');
        $email = request('email');
        $this->user->create(compact('name', 'email', 'password'));
        return redirect('/blog/posts');
    }

    //登录验证
    public function signInStore()
    {
        $this->validate(request(), [
            'email' => 'required|email|exists:mysql_blog.users,email',
            'password' => 'required|min:5'
        ]);

        $user = request(['email', 'password']);

        $remember = boolval(request('is_remember'));
        if (true == \Auth::guard('blog')->attempt($user, $remember)) {
            return redirect('/blog/posts');
        }
        return \Redirect::back()->withErrors("用户名密码错误");
//        return \Redirect::back()->withErrors("用户名密码错误");
    }


    public function logout()
    {
        \Auth::guard('blog')->logout();

        return redirect('/blog/signIn');
    }
    public function setting(){
        $me = \Auth::guard('blog')->user();
        return view('/blog/user/setting', compact('me'));
    }
    public function show(){
        $user = \Auth::guard('blog')->user();
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(6);
        $user = $this->user->withCount(['posts'])->find($user->id);
        return view('/blog/user/show', compact('posts','user'));
    }
    public function settingSore(){
        $user = \Auth::guard('blog')->user();
        $this->validate(request(),[
            'name' => 'required|unique:mysql_blog.users,name,'.$user->name,
            'email' => 'required|min:3|unique:mysql_blog.users,email,'.$user->email.'|email',
        ]);

        $user = $this->user->withCount(['posts'])->find($user->id);
        $user->update(request(['name','email']));
        return back();
    }
}