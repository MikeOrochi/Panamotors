<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\proveedores;
use App\Models\contactos;
use App\Models\contactos_provedores;
use App\Models\usuarios;
use App\Models\segmentacion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// use App\proveedores;
class ContactController extends Controller
{

    public function __construct(){
      $this->middleware('auth');
    }


    public function search($search){
      $contacts = DB::select("select * from contactos where idcontacto='".$search."' || concat_ws(' ', nombre, apellidos) LIKE '".$search."%' || nombre LIKE '".$search."%' || apellidos LIKE '".$search."%' || alias LIKE '%".$search."%' || email LIKE '".$search."%' || telefono_otro LIKE '".$search."%' || telefono_celular LIKE '".$search."%' LIMIT 5");
      return ['contacts'=>$contacts];
    }
    public function show($id){
      $contacts = contactos::where('idcontacto', $id)->get()->last();
      return ['contacts'=>$contacts];
    }
}
