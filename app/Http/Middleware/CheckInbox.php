<?php

namespace App\Http\Middleware;

use Closure;
use App\Solicitud;

class CheckInbox
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
        $unread = Solicitud::query()->where('destinatario_id',auth()->id())->where('estado',1)->get();
        //dd($unread);
        return $next($request);
    }
}
