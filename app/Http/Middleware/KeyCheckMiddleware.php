<?php

namespace App\Http\Middleware;

use App\Custom\KeyCheck;
use Closure;

class KeyCheckMiddleware
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
        $key = new KeyCheck();
        $remain = $key->day_remain();

        if ($remain < 0) {
            return redirect()->route('key');
        }
        return $next($request);
    }
}
