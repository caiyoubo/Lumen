<?php
namespace App\Http\Middleware;

use Closure;

class OldMiddleware
{
    /**
     * 进行请求过滤
     *
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Laravel\Lumen\Http\Redirector|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('age') <= 18)
        {
            return redirect('home');
        }

        return $next($request);
    }
}