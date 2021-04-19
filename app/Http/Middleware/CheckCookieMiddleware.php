<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\usuarios;
use Illuminate\Support\Facades\Route;
use Closure;

class CheckCookieMiddleware
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
    try {
      if (Auth::user()) {
        if (!\Request::cookie('usuario_creador')) {
          $user_maker = usuarios::get()->where('visible', 'SI')->where('idempleados', \Auth::user()->idempleados)->where('rol', 17)->last()->idusuario;
          return redirect()->route('admin.profiles');
          // $route = Route::currentRouteName();
          // return redirect()->route($route)->withCookie(cookie('usuario_creador',$user_maker,720));
        }
      }else {
        return redirect()->route('logout');
      }
    } catch (\Exception $e) {
      return redirect()->route('logout');
    }

    return $next($request);
  }
}
