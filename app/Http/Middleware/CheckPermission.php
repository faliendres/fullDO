<?php

namespace App\Http\Middleware;

use Closure;
use App\Menu;

class CheckPermission
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
        if (!$request->ajax()) {
            $user = auth()->user();
            if(isset($user->perfil)){
                $uri = $request->route()->uri();
                $resource = explode("/", $uri)[0];
                $menuItem = Menu::query()->where('title',ucwords($resource))->first();
                if($user->perfil > $menuItem->permissions && $menuItem->title != "Usuarios"){
                    return redirect('home');
                }
            }
        }
        return $next($request);
    }
}
