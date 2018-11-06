<?php
namespace App\Http\Middleware;

use Closure;

//  在应用处理之后执行
class AfterMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //  执行操作

        return $response;
    }
}