<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\GlobalFunctionsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\proveedores;
use App\Models\contactos;
use App\Models\contactos_provedores;
use App\Models\usuarios;
use App\Models\segmentacion;
use QrCode;
use Illuminate\Support\Facades\View;
// use App\Models\estado_cuenta_;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// use App\proveedores;
class PruebaController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){
    // return estado_cuenta_::get('idestado_cuenta')->first();
    // return DB::table('estado_cuenta')->get('idestado_cuenta');
    $segmentations = segmentacion::all();
    $user_maker = \Request::cookie('usuario_creador');
    $user =\Request::cookie('user');
    return view('admin.providers.index', compact('segmentations'));
  }
  public function store(){
    return $request;
  }
  public function search($search){
    $contacts = DB::select("select * from contactos where idcontacto='".$search."' || concat_ws(' ', nombre, apellidos) LIKE '".$search."%' || nombre LIKE '".$search."%' || apellidos LIKE '".$search."%' || alias LIKE '%".$search."%' || email LIKE '".$search."%' || telefono_otro LIKE '".$search."%' || telefono_celular LIKE '".$search."%' LIMIT 5");
    $providers = DB::select("select * from proveedores where idproveedores='".$search."' || concat_ws(' ', nombre, apellidos) LIKE '".$search."%' || nombre LIKE '".$search."%' || apellidos LIKE '".$search."%' || alias LIKE '%".$search."%' || email LIKE '".$search."%' || telefono_otro LIKE '".$search."%' || telefono_celular LIKE '".$search."%' LIMIT 5");
    return ['contacts'=>$contacts,'providers'=>$providers];
  }
  public function searchById($id){
    try {
      if (strrpos($id, 'C') === 0) {
        $id_to_search = str_replace("C", "", $id);
        if (contactos::get('idcontacto')->where('idcontacto', $id_to_search)->count()!=0) {
          return ['type'=>'contact','info'=>contactos::get()->where('idcontacto', $id_to_search)->first()];
        }else { return 'no_ok'; }
      }elseif (strrpos($id, 'P') === 0) {
        $id_to_search = str_replace("P", "", $id);
        if (proveedores::get('idproveedores')->where('idproveedores', $id_to_search)->count()!=0) {
          return ['type'=>'provider', 'info'=>proveedores::get()->where('idproveedores', $id_to_search)->first()];
        }else { return 'no_ok'; }
      }else {
        return 'no_ok';
      }
    } catch (\Exception $e) { return 'no_ok'; }
  }
  public function searchByName($name, $lastname){
    if ($name=='null' && $lastname=='null') {
      $no_providers = 0;
      return response()->json(['providers'=>$no_providers]);
    }
    if ($name=='null') { $name = ''; }
    if ($lastname=='null') { $lastname = ''; }
    if ($name != '' && $lastname != ''){
      $no_providers = proveedores::where('nombre','like',$name.'%')->where('apellidos','like',$lastname.'%')->count();
    }elseif ($name == '') {
      $no_providers = proveedores::where('apellidos','like',$lastname.'%')->count();
    }elseif ($lastname == '') {
      $no_providers = proveedores::where('nombre','like',$name.'%')->count();
    }else {
      $no_providers = 0;
    }
    return response()->json(['providers'=>$no_providers]);
  }
  public function searchRfc($rfc){
    try {
      $rfc = proveedores::where('rfc',$rfc)->count();
      return response()->json(['rfc'=>$rfc]);
    } catch (\Exception $e) {
      return response()->json(['rfc'=>0]);

    }
  }
  public function searchAlias($alias){
    try {
      $alias = proveedores::where('alias',$alias)->count();
      return response()->json(['alias'=>$alias]);
    } catch (\Exception $e) {
      return response()->json(['alias'=>0]);
    }
  }
  public function searchPhone($phone){
    try {
      $phone_mainly = proveedores::where('telefono_celular',$phone)->count();
      $other_phone = proveedores::where('telefono_otro',$phone)->count();
      $phone = $phone_mainly+$other_phone;
      return response()->json(['phone'=>$phone]);
    } catch (\Exception $e) {
      return response()->json(['phone'=>0]);
    }
  }
  public function searchEmail($email){
    try {
      $email = proveedores::where('email',$email)->count();
      return response()->json(['email'=>$email]);
    } catch (\Exception $e) {
      return response()->json(['email'=>0]);
    }
  }
  public function getNomenclatura($name, $lastname){
    $names_array = explode(" ", $name);
    $lastnames_array = explode(" ", $lastname);
    $nomenclatura = '';
    foreach ($names_array as $name_array) {
      $nomenclatura = $nomenclatura.substr($name_array, 0, 1);
    }
    foreach ($lastnames_array as $lastname_array) {
      $nomenclatura = $nomenclatura.substr($lastname_array, 0, 1);
    }
    $date = Carbon::now()->format('dmY');
    return ['nomenclatura' => $nomenclatura,
    'id_provider_comp' =>(proveedores::get()->last()->idproveedores+1).'-'.$nomenclatura.'-'.$date];
  }
  public function pdfQr(){
     $url = "https://www.panamotorscenter.com";
     $filename = "../../Codigos_qr_recibos/codigoqr2.png";
     $level = 'H';
     $tamaniopixel = 100;
     $tamaniomargen = 100;
     $proveedores = proveedores::get()->first()->nombre;
     // dd($proveedores);
     $newqrcode = QrCode::size(200)->generate($url.$proveedores);
     $newqrcode_explode = explode("?>", $newqrcode);
     // dd($newqrcode);
     $view=View::make('admin.pdfQr');
     GlobalFunctionsController::createPdf($view, 'Recibo', '1', 0000001,"admon_compras","recibo",$newqrcode_explode[1]);
     return view('admin.pdfQr');
 }


 public function viewPdf(){
    $url = "https://www.panamotorscenter.com";
    $proveedores = proveedores::get()->first()->nombre;
    $newqrcode = QrCode::size(130)->backgroundColor(255,255,255)->generate($url.$proveedores);
    $newqrcode_explode = explode("?>", $newqrcode);
    return view('admin.recibo_tesoreria',compact('newqrcode_explode'));
 }

 public function pdfComprobante(){

}

}
