<?php
namespace App\Http\Controllers\Middleware;

use Closure;

//  在应用处理请求之前执行一些任务
class BeforeMidddleware
{
    public function handle($request, Closure $next)
    {
        //执行操作

        return $next($request);
    }
}