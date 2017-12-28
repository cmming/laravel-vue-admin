<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\UserPremission;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
		//将定义的的策略模式注册到模型中 去
//		'\App\Models\UserOriFiles' =>'\App\Policies\UserOriResPolicy'
		\App\Models\UserOriFiles::class =>\App\Policies\UserOriResPolicy::class,
        \App\Models\Blog\Post::class =>\App\Policies\Blog\PostPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

		//为 用户角色 进行门卫注册 定义
		$UserPremissions = UserPremission::all();
		foreach($UserPremissions as $userPremission){
			Gate::define($userPremission->name, function ($user)use($userPremission){
//				return $user->hasPremission($userPremission);
				return true;
			});
		}
        //
    }
}
