<?php

namespace App\Http\Middleware;

use Closure;

class AdminChangeMidleware
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
        config(['jwt.user' => '\App\user']);    //用于指定特定model
        config(['auth.providers.users.model' => \App\Models\AdminUser::class]);//就是他们了
        return $next($request);
    }
}
