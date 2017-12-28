<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 17:50
 */

namespace App\Http\Middleware;

use Closure;

class BlogUserChangeMidleware
{
    public function handle($request, Closure $next)
    {
        config(['auth.guards.web.provider' => 'blogUser']);    //修改门卫
        return $next($request);
    }

}