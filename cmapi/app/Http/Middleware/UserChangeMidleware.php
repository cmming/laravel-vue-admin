<?php

namespace App\Http\Middleware;

use Closure;

class UserChangeMidleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//		dd(config());
        config(['jwt.user' => '\App\Models\User']);    //用于指定特定model
        config(['jwt.identifier' => 'uid']);    //用于指定特定model
        config(['auth.providers.users.model' => \App\Models\User::class]);//就是他们了
//        config(['jwt.providers.user' => \App\Models\AdminUser::class]);//就是他们了
		return $next($request);
	}
}
