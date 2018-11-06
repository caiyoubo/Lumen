<?php
namespace App\Http\Middleware;

use Closure;

class OldMiddlerware
{
    public function handle($request, Closure $next)
    {
        if ($request->input('age') <= 18)
        {
            return redirect('home');
        }

        return $next($request);
    }
}