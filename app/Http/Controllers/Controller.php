<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
  public function index(){
    if (Auth::user()) {
      if (!\Request::cookie('usuario_creador')) {
        $var=route('admin.profiles');
        return $var;
        // https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/administrador/perfiles
        return redirect()->route('admin.profiles');
      }
    }else {
      return redirect()->route('logout');
    }
  }
}
