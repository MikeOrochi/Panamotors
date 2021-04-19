<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\proveedores;
use App\Models\contactos;
use App\Models\contactos_provedores;
use App\Models\usuarios;
use App\Models\segmentacion;
use App\Models\estado_cuenta_proveedores;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// use App\proveedores;
class ProviderController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){
    $segmentations = segmentacion::all();
    $user_maker = \Request::cookie('usuario_creador');
    $user =\Request::cookie('user');
    // dd(usuarios::where('idusuario', $user_maker)->get(['idusuario','rol'])->first());
    // dd($user_maker,$user);
    return view('admin.providers.index', compact('segmentations'));
  }
  public function edit($id){
    // return estado_cuenta_::get('idestado_cuenta')->first();
    // return DB::table('estado_cuenta')->get('idestado_cuenta');
    $segmentations = segmentacion::all();
    $user_maker = \Request::cookie('usuario_creador');
    $user =\Request::cookie('user');
    $provider = proveedores::where('idproveedores', $id)
    ->get(['idproveedores','nombre','apellidos','sexo','rfc','alias','telefono_otro','telefono_celular','email',
    'codigo_postal','estado','delmuni','colonia','calle','col1',
    'referencia_nombre','referencia_celular','referencia_fijo',
    'referencia_nombre2','referencia_celular2','referencia_fijo2',
    'referencia_nombre3','referencia_celular3','referencia_fijo3',
    'col2','col6','col7','col8',
    'col9'
    ])->first();

    if($provider->codigo_postal == ""){
      $direction = [];
    }else {
      $direction = ZipController::show($provider->codigo_postal)['colony'];
    }

    return view('admin.providers.edit', compact('segmentations','provider','id','direction'));
  }
  public function store(Request $request){
    // return $request;
    DB::beginTransaction();
    try {
      $user_maker = usuarios::get()->where('visible', 'SI')->where('idempleados', \Auth::user()->idempleados)->where('rol', 17)->last()->idusuario;
      // $user_maker = \Request::cookie('usuario_creador');
      // $user =\Request::cookie('user');
      if ($request->other_colony == null) {  $colony = $request->colony;
      }else { $colony = $request->other_colony;}
      if ($request->product === '1') { $product = 'Producto'; } else { $product = null; }
      if ($request->service === '1') { $service = 'Servicio'; } else { $service = null; }
      if ($request->others === '1') { $others = 'Otro'; } else { $others = null; }
      $today = Carbon::now();
      $nomenclatura = $this->getNomenclatura($request->name, $request->lastname);
      if ($request->type_person=='fisica') {  $sex = $request->sex;
      }else { $sex= null; }
      if ($request->social_phisic_reason != null) {
        $reason = $request->social_phisic_reason;
      }else {
        $reason = $request->name.' '.$request->lastname;
      }
      if ($request->exist_user === 'no') {
        // return \Request::cookie('usuario_creador');
        // return \Auth::user();
        $provider = proveedores::createProveedores($nomenclatura['id_provider_comp'], $nomenclatura['nomenclatura'], $request->name,
        $request->lastname, $sex, $request->rfc, $request->alias, null, $request->other_phone, $request->phone, $request->email,
        $request->first_personal_name, $request->first_personal_mobile, $request->first_personal_phone, $request->second_personal_name,
        $request->second_personal_mobile, $request->second_personal_phone, $request->third_personal_name, $request->third_personal_mobile,
        $request->third_personal_phone, null, null, null, 'N/A', 'N/A', 'N/A', 'N/A', $request->zip, $request->state_hid, $request->township_hid,
        $colony, $request->street, 'N/A', 'SI', $user_maker, $request->date_created, $today, null, $reason, $request->money, null, null, null, $others,
        $service, $product, $request->segmentation, 8, 'N/A', 'N/A');
        DB::commit();
        return redirect()->route('wallet.showProvider',$provider->idproveedores);
      }elseif ($request->exist_user === 'si') {
        if ($request->type_person_input === 'provider') {
          $provider = proveedores::updateNewProvider($request->id_person,$request->first_personal_name, $request->first_personal_mobile,
          $request->first_personal_phone, $request->second_personal_name, $request->second_personal_mobile, $request->second_personal_phone,
          $request->third_personal_name, $request->third_personal_mobile, $request->third_personal_phone,$request->zip, $request->state_hid,
          $request->township_hid, $colony, $request->calle,$user_maker,$today, $others, $service, $product, $request->segmentation, 8,
          $request->alias,$request->money);
          // return $provider;
          DB::commit();
          return redirect()->route('wallet.showProvider',$provider->idproveedores);
        }elseif ($request->type_person_input === 'contact') {
          if (contactos_provedores::where('idcontacto',$request->id_person)->count()!=0) {
            $contact_provider =contactos_provedores::where('idcontacto',$request->id_person)->get()->last();
            // return $contact_provider;
            $provider = proveedores::updateNewProvider($contact_provider->idprovedor,$request->first_personal_name,
            $request->first_personal_mobile, $request->first_personal_phone, $request->second_personal_name,
            $request->second_personal_mobile, $request->second_personal_phone, $request->third_personal_name,
            $request->third_personal_mobile, $request->third_personal_phone,$request->zip, $request->state_hid,
            $request->township_hid, $colony, $request->calle,$user_maker,$today, $others, $service,
            $product, $request->segmentation, 8,$request->alias,$request->money);
            DB::commit();
            return redirect()->route('wallet.showProvider',$provider->idproveedores);
          }else {
            $contact = contactos::get()->where('idcontacto', $request->id_person)->last();
            // return $contact;
            $nomenclatura = $this->getNomenclatura($contact->nombre, $contact->apellidos);
            $provider = proveedores::createProveedores($nomenclatura['id_provider_comp'], $nomenclatura['nomenclatura'], $contact->nombre,
            $contact->apellidos, $contact->sexo, $contact->rfc, $contact->alias, null, $contact->telefono_otro, $contact->telefono_celular,
            $contact->email, $request->first_personal_name, $request->first_personal_mobile, $request->first_personal_phone, $request->second_personal_name,
            $request->second_personal_mobile, $request->second_personal_phone, $request->third_personal_name, $request->third_personal_mobile,
            $request->third_personal_phone, null, null, null, 'N/A', 'N/A', 'N/A', 'N/A', $request->zip, $request->state_hid, $request->township_hid, $colony,
            $request->street, 'N/A', 'SI', $user_maker, $request->date_created, $today, null, $request->name.' '.$request->lastname, $request->money, null, null, null,
            $others, $service, $product, $request->segmentation, 8, 'N/A', 'N/A');
            contactos_provedores::createContactosProvedores($contact->idcontacto, $provider->idproveedores);
            DB::commit();
            return redirect()->route('wallet.showProvider',$provider->idproveedores);
          }
        }else {
          return back()->with('error', 'Error al guardar');
        }
      }else {
        return back()->with('error', 'Error al guardar');
      }
    } catch (\Exception $e) {
      DB::rollback();
      return 'Error al guardar'.$e->getMessage();
    }
  }
  public function update(Request $request){


    DB::beginTransaction();
    try {
      $today = Carbon::now();
      $user_maker = usuarios::get()->where('visible', 'SI')->where('idempleados', \Auth::user()->idempleados)->where('rol', 17)->last()->idusuario;
      if ($request->type_person=='fisica') {  $sex = $request->sex;
      }else { $sex= null; }
      if ($request->social_phisic_reason != null) {
        $reason = $request->social_phisic_reason;
      }else {
        $reason = $request->name.' '.$request->lastname;
      }
      if ($request->product === '1') { $product = 'Producto'; } else { $product = null; }
      if ($request->service === '1') { $service = 'Servicio'; } else { $service = null; }
      if ($request->others === '1') { $others = 'Otro'; } else { $others = null; }
      if ($request->other_colony == null) {  $colony = $request->colony;
      }else { $colony = $request->other_colony;}
      // return $request;
      $proveedores = proveedores::updateProvider($request->id_provider,$request->name,$request->lastname,$sex,$request->rfc,$request->alias,$request->other_phone,$request->phone,$request->email,
      $request->first_personal_name, $request->first_personal_mobile, $request->first_personal_phone,
      $request->second_personal_name, $request->second_personal_mobile, $request->second_personal_phone,
      $request->third_personal_name, $request->third_personal_mobile, $request->third_personal_phone,
      $request->zip, $request->state_hid, $request->township_hid, $colony, $request->calle,$user_maker,
      $today, $others, $service, $product, $request->segmentation, $request->social_phisic_reason, $request->money);
      DB::commit();
      return back()->with('success', 'Usuario '.$proveedores->nombre.' '.$proveedores->apellidos.' actualizado correctamente');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error', 'Error al crear -> '.$e->getMessage());
    }

  }
  public function search($search){
    $contacts = DB::select("select * from contactos where idcontacto > 5000 and (idcontacto like '%".$search."%' || concat_ws(' ', trim(nombre), trim(apellidos)) LIKE '%".$search."%' || nombre LIKE '%".$search."%' || apellidos LIKE '%".$search."%' || alias LIKE '%".$search."%' || email LIKE '%".$search."%' || telefono_otro LIKE '%".$search."%' || telefono_celular LIKE '%".$search."%') LIMIT 50");
    $providers = DB::select("select * from proveedores where idproveedores like '%".$search."%' || concat_ws(' ', trim(nombre), trim(apellidos)) LIKE '%".$search."%' || nombre LIKE '%".$search."%' || apellidos LIKE '%".$search."%' || alias LIKE '%".$search."%' || email LIKE '%".$search."%' || telefono_otro LIKE '%".$search."%' || telefono_celular LIKE '%".$search."%' LIMIT 50");
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
  public function checkMoneda(){
    $providers = proveedores::get(['idproveedores','nombre','apellidos','visible','col2']);
    $no_accept = 0;
    $provider_count = 0;
    $provider_ok = 0;
    foreach ($providers as $provider) {
      // $compras_directas = estado_cuenta_proveedores::where('idcontacto', $provider->idproveedores)->whereIn('concepto', 'Compra Directa')->get(['idestado_cuenta_proveedores','concepto','tipo_moneda','tipo_cambio','idcontacto','visible']);
      $compras_directas = estado_cuenta_proveedores::where('idcontacto', $provider->idproveedores)->whereIn('concepto', ['Compra Directa','Traspaso','Devolución del VIN'])->get(['idestado_cuenta_proveedores','concepto','tipo_moneda','tipo_cambio','idcontacto','visible']);
      // return $compras_directas;
      $abonos = estado_cuenta_proveedores::where('idcontacto', $provider->idproveedores)->where('concepto', 'Abono')->get(['idestado_cuenta_proveedores','concepto','tipo_moneda','tipo_cambio','idcontacto','visible']);
      if ($compras_directas->count()!=0) {
        $usd = $compras_directas->where('tipo_moneda', 'USD')->count();
        $mxn = $compras_directas->where('tipo_moneda', 'MXN')->count();
        $cad = $compras_directas->where('tipo_moneda', 'CAD')->count();
        $undefined = $compras_directas->where('tipo_moneda', '')->count();
        $nulls = $compras_directas->where('tipo_moneda', null)->count();
        $tipo_cambio_blank = $compras_directas->where('tipo_cambio', null)->count();
        $tipo_cambio_null = $compras_directas->where('tipo_cambio', '')->count();
        $abono_usd = $abonos->where('tipo_moneda', 'USD')->count();
        $abono_mxn = $abonos->where('tipo_moneda', 'MXN')->count();
        $abono_cad = $abonos->where('tipo_moneda', 'CAD')->count();
        $abono_undefined = $abonos->where('tipo_moneda', '')->count();
        $abono_nulls = $abonos->where('tipo_moneda', null)->count();
        $abono_tipo_cambio_blank = $abonos->where('tipo_cambio', null)->count();
        $abono_tipo_cambio_null = $abonos->where('tipo_cambio', '')->count();

        if ((($usd>$mxn && $usd>$cad)&&($mxn>0||$cad>0||$undefined>0||$nulls>0))||(($abono_usd>$abono_mxn && $abono_usd>$abono_cad)&&($abono_mxn>0||$abono_cad>0||$abono_undefined>0||$abono_nulls>0))) {
          $providers_no_ok[$provider_count]=[
            'provider'=>$provider->idproveedores,
            'nombre'=>$provider->nombre,
            'apellidos'=>$provider->apellidos,
            'usd'=>$usd,
            'cad'=>$cad,
            'mxn'=>$mxn,
            'undefined'=>$undefined,
            'nulls'=>$nulls,
            'tipo_cambio_blank'=>$tipo_cambio_blank,
            'tipo_cambio_null'=>$tipo_cambio_null,
            'abono_usd'=>$abono_usd,
            'abono_mxn'=>$abono_mxn,
            'abono_cad'=>$abono_cad,
            'abono_undefined'=>$abono_undefined,
            'abono_nulls'=>$abono_nulls,
            'abono_tipo_cambio_blank'=>$abono_tipo_cambio_blank,
            'abono_tipo_cambio_null'=>$abono_tipo_cambio_null
          ];
        }elseif ((($mxn>$usd && $mxn>$cad)&&($usd>0||$cad>0||$undefined>0||$nulls>0))||(($abono_mxn>$abono_usd && $abono_mxn>$abono_cad)&&($abono_usd>0||$abono_cad>0||$abono_undefined>0||$abono_nulls>0))) {
          $providers_no_ok[$provider_count]=[
            'provider'=>$provider->idproveedores,
            'nombre'=>$provider->nombre,
            'apellidos'=>$provider->apellidos,
            'usd'=>$usd,
            'cad'=>$cad,
            'mxn'=>$mxn,
            'undefined'=>$undefined,
            'nulls'=>$nulls,
            'tipo_cambio_blank'=>$tipo_cambio_blank,
            'tipo_cambio_null'=>$tipo_cambio_null,
            'abono_usd'=>$abono_usd,
            'abono_mxn'=>$abono_mxn,
            'abono_cad'=>$abono_cad,
            'abono_undefined'=>$abono_undefined,
            'abono_nulls'=>$abono_nulls,
            'abono_tipo_cambio_blank'=>$abono_tipo_cambio_blank,
            'abono_tipo_cambio_null'=>$abono_tipo_cambio_null
          ];
        }elseif ((($cad>$usd && $cad>$mxn)&&($usd>0||$mxn>0||$undefined>0||$nulls>0))||(($abono_mxn>$abono_usd && $abono_mxn>$abono_cad)&&($abono_usd>0||$abono_cad>0||$abono_undefined>0||$abono_nulls>0))) {
          $providers_no_ok[$provider_count]=[
            'provider'=>$provider->idproveedores,
            'nombre'=>$provider->nombre,
            'apellidos'=>$provider->apellidos,
            'usd'=>$usd,
            'cad'=>$cad,
            'mxn'=>$mxn,
            'undefined'=>$undefined,
            'nulls'=>$nulls,
            'tipo_cambio_blank'=>$tipo_cambio_blank,
            'tipo_cambio_null'=>$tipo_cambio_null,
            'abono_usd'=>$abono_usd,
            'abono_mxn'=>$abono_mxn,
            'abono_cad'=>$abono_cad,
            'abono_undefined'=>$abono_undefined,
            'abono_nulls'=>$abono_nulls,
            'abono_tipo_cambio_blank'=>$abono_tipo_cambio_blank,
            'abono_tipo_cambio_null'=>$abono_tipo_cambio_null
          ];
        }else {
          $provider_ok++;
        }
        $provider_count++;
        if ($usd>$mxn && $usd>$cad) {
          $provider->col2 = 'USD';
          $provider->saveOrFail();
        }elseif ($mxn>$usd && $mxn>$cad) {
          $provider->col2 = 'MXN';
          $provider->saveOrFail();
        }elseif ($cad>$usd && $cad>$mxn) {
          $provider->col2 = 'CAD';
          $provider->saveOrFail();
        }else {
          $no_accept++;
        }
        // dd($usd,$mxn,$cad);
        // return $compras_directas;
      }else {
        $no_accept++;
      }
      // return $no_accept;
    }
    // return 'xD';
    dd([
      'no_accept'=>$no_accept,
      'provider_ok'=>$provider_ok,
      'providers_no_ok'=>$providers_no_ok
    ]);
    return view('admin.providers.check',compact('providers_no_ok'));
  }
}
