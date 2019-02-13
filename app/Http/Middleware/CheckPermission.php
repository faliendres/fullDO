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
        $user = auth()->user();
        if(isset($user->perfil)){
            $row = Menu::query()->where('route',$request->route()->getName())->first();
            //dd($row->id);
            $menuItem = Menu::query()->find($row->parent_id);
            if($user->perfil > $menuItem->permissions){
                return redirect('home');
            }
        }
        return $next($request);
    }
}
