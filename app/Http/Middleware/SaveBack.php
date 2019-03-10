<?php

namespace App\Http\Middleware;

use Closure;

class SaveBack
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
        session(["back-btn"=>url()->previous()]);
        return $next($request);
    }
}
