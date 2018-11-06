<?php
namespace App\Http\Middleware;

use Closure;

//  在应用处理请求之前执行一些任务
class BeforeMiddleware
{
    public function handle($request, Closure $next)
    {
        //执行操作

        return $next($request);
    }
}