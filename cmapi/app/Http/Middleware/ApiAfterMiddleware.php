<?php

namespace App\Http\Middleware;

use Closure;

class ApiAfterMiddleware
{
    /**
     * 请求前置中间件
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        $response->headers->set('lastmodified',time());

        return $response;
    }
}

