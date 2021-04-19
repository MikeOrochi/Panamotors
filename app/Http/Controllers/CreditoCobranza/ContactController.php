<?php

namespace App\Http\Controllers\CreditoCobranza;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\catalogo_documentos_contacto;
use App\Models\documentos_contacto_cambios;
use App\Models\contactos_documentos;
use App\Models\documentos_cobrar;
use App\Models\contactos_cambios;
use App\Models\clientes_tipos;
use App\Models\abonos_pagares;
use App\Models\credito_tipos;
use App\Models\estado_cuenta;
use App\Models\contactos;
use App\Models\asesores;
use Carbon\Carbon;
class ContactController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function index(){
    $asesores = asesores::get(['idasesores','nomeclatura']);
    $clientes_tipos = clientes_tipos::get(['idclientes_tipos','nombre']);
    $credito_tipos = credito_tipos::get(['idcredito_tipos','nombre']);
    $contactos = contactos::where('tipo_registro', 'Cliente')->where('idcontacto', '>', 5000)
    ->orderBy('idcontacto','asc')
    ->get(['idcontacto','nombre','apellidos','alias','telefono_celular','asesor','tipo_cliente','tipo_credito','delmuni','estado']);
    return view('CreditoCobranza.contacts.index',compact(
      'asesores', 'clientes_tipos', 'credito_tipos','contactos'
    ));
  }
  public function new(){
    $asesores = asesores::get(['idasesores','nombre','nomeclatura']);
    $clientes_tipos = clientes_tipos::get(['idclientes_tipos','nombre','nomeclatura']);
    $credito_tipos = credito_tipos::get(['idcredito_tipos','nombre','nomeclatura']);
    return view('CreditoCobranza.contacts.new',compact('asesores','clientes_tipos','credito_tipos'));
  }
  public function store(Request $request){
    // return $request;
    $nombre= $request->nombre;
    $sexo= $request->sexo;
    $apellidos= $request->apellidos;
    $alias= $request->alias;
    $rfc= $request->rfc;
    $telefono_fijo= $request->telefono_fijo;
    $telefono_celular= $request->telefono_celular;
    $correo= $request->correo;
    $file = $request->uploadedfile;

    $referencia_nombre= $request->ref_nombre;
    $referencia_celular= $request->ref_celular;
    $referencia_fijo= $request->ref_fijo;

    $referencia_nombre2 = $request->ref_nombre2;
    $referencia_celular2 = $request->ref_celular2;
    $referencia_fijo2 = $request->ref_fijo2;

    $referencia_nombre3 = $request->ref_nombre3;
    $referencia_celular3 = $request->ref_celular3;
    $referencia_fijo3 = $request->ref_fijo3;

    $asesor= $request->asesor;
    $tipo_cliente= $request->tipo_cliente;
    $tipo= $request->tipo_cliente;
    $credito= $request->credito;
    $linea_credito= $request->lim_credito;

    $codigo_postal= $request->codigo_postal;
    $estado= $request->estado;
    $municipio= $request->municipio;
    $colonia= $request->colonia;
    $colonia_select= $request->colonia_otra;
    $calle= $request->calle;
    $trato= "";
    // return $request;
    $usuario_creador = \Request::cookie('usuario_creador');

    date_default_timezone_set('America/Mexico_City');
    $fechaactual= date("Y-m-d H:i:s");
    $fecha_guardado= date("Y-m-d H:i:s");
    $actual= date("Y_m_d_H_i_s");

    $check_phone_email = $this->verifyContactInfo($telefono_fijo,$telefono_celular,$correo);
    if($check_phone_email['total']==0 || $telefono_celular == "0000000000"){
      DB::beginTransaction();
      try {
        if ($colonia=="" && $colonia_select!="") { $colonia=$colonia_select; }
        if (is_null($calle)) { $calle=''; }
        if (is_null($rfc)) { $rfc=''; };
        if (is_null($correo)) { $correo=''; }
        $nomenclatura = $this->getNomenclatura($nombre, $apellidos);
        $contacto = contactos::createContactos($nomenclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato,
        $telefono_fijo, $telefono_celular, $correo, $referencia_nombre, $referencia_celular, $referencia_fijo,
        $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3,
        $referencia_fijo3, 'Cliente', 0, '', $asesor, $tipo_cliente, $credito, $linea_credito, $codigo_postal,
        $estado, $municipio, $colonia, $calle, 'NO', $usuario_creador, $fechaactual);
        if ($file == "" || $file == null) {
          $archivo_cargado="#";
        }else{
          $nombre = $file->getClientOriginalName();
          $extension = pathinfo($nombre, PATHINFO_EXTENSION);
          $nombre = "DC_".$contacto->idcontacto."_".$actual."_Usr_".$usuario_creador."_INE".$extension;
          $archivo_cargado = '/Documentos_Contactos/'.$nombre;
          Storage::disk('local')->put('/Documentos_Contactos/'.$nombre,  \File::get($file));
          $contactos_documentos = contactos_documentos::createContactosDocumentos($archivo_cargado, 'IFE/INE', 'SI',
          'Identificacion Oficial', $fecha_guardado, $fecha_guardado, $contacto->idcontacto, 'N/A', $usuario_creador, 'N/A');
          $contacto->foto_perfil = $archivo_cargado;
          $contacto->saveOrFail();
          $descripcion_cambio = "Se guardo el documento: <b> IFE/INE </b>-<b>".$archivo_cargado."</b>";
          $documentos_contacto_cambios = documentos_contacto_cambios::createContactosDocumentosCambios($descripcion_cambio, $usuario_creador, $actual, $contacto->idcontacto);
        }
        DB::commit();
        return redirect()->route('CreditoCobranza.contact.show',Crypt::encrypt($contacto->idcontacto))->with('success', 'Contacto creado con exito' );
        // return back()->with('success', 'Contacto creado con exito' );
      } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
        return back()->with('error', 'Error al crear contacto' )->withInput();
      }


    }else{

      echo "
      <script language='javascript' type='text/javascript'>
      alert('Los datos proporcionadados ya se encuentran registrados en CCP, valide la información e intente nuevamente');
      history.go(-1);
      </script>
      ";
    }//Fin de Busqueda de Contactos
  }
  public function show($idcontacto){
    $idcontacto = Crypt::decrypt($idcontacto);
    $contacto = contactos::findOrFail($idcontacto);
    // return $contacto;
    // return $idcontacto;
    /*
    session_start();
    include_once "../../config.php";
    require_once ('../../bdd.php');
    include_once "../../recuperar_usuario.php";
    date_default_timezone_set('America/Mexico_City');
    $fecha_guardado = date("Y-m-d H:i:s");
    $usuario_creador = $_SESSION['usuario_clave'];
    $empleados=$_SESSION['empleados'];
    header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT");
    header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    $random = rand(5, 15);
    $idc_get = $_REQUEST["idc"];
    $idcontacto_decode = base64_decode($idc_get);
    $n1 = strlen($idcontacto_decode);
    $n1_aux = 6-$n1;
    $mat = "";
    for ($i = 0; $i < $n1_aux; $i++) {
    $mat .= "0";
  }
  $id_contacto_completo = $mat.$idcontacto_decode;
  $sql0 = "SELECT *FROM contactos WHERE idcontacto = '$idcontacto_decode'";
  $result0 = mysql_query($sql0);
  while ($fila0 = mysql_fetch_array($result0)) {
  $idcontacto_db = $fila0['idcontacto'];
  $nomeclatura_db = $fila0['nomeclatura'];
  $nombre_db = $fila0['nombre'];
  $apellidos_db = $fila0['apellidos'];
  $sexo_db = $fila0['sexo'];
  $rfc_db = $fila0['rfc'];
  $alias_db = $fila0['alias'];
  $trato_db = $fila0['trato'];
  $telefono_otro_db = $fila0['telefono_otro'];
  $telefono_celular_db = $fila0['telefono_celular'];
  $email_db = $fila0['email'];
  $referencia_nombre_db = $fila0['referencia_nombre'];
  $referencia_celular_db = $fila0['referencia_celular'];
  $referencia_fijo_db = $fila0['referencia_fijo'];
  $referencia_nombre2_db = $fila0['referencia_nombre2'];
  $referencia_celular2_db = $fila0['referencia_celular2'];
  $referencia_fijo2_db = $fila0['referencia_fijo2'];
  $referencia_nombre3_db = $fila0['referencia_nombre3'];
  $referencia_celular3_db = $fila0['referencia_celular3'];
  $referencia_fijo3_db = $fila0['referencia_fijo3'];
  $tipo_registro_db = $fila0['tipo_registro'];
  $entrada_db = $fila0['entrada'];
  $asesor_db = $fila0['asesor'];
  $tipo_cliente_db = $fila0['tipo_cliente'];
  $tipo_credito_db = $fila0['tipo_credito'];
  $linea_credito_db = $fila0['linea_credito'];
  $codigo_postal_db = $fila0['codigo_postal'];
  $estado_db = $fila0['estado'];
  $delmuni_db = $fila0['delmuni'];
  $colonia_db = $fila0['colonia'];
  $calle_db = $fila0['calle'];
  $foto_perfil_db = $fila0['foto_perfil'];
  $fecha_nacimiento_db = $fila0['fecha_nacimiento'];
}
$nomeclatura = "";
$porciones = explode(" ", $nombre_db.' '.$apellidos_db);
foreach ($porciones as $parte) {
$nomeclatura .= $parte[0];
}
$nomeclatura = mb_strtoupper($nomeclatura);
$sql0x = "UPDATE contactos SET nomeclatura = '$nomeclatura' WHERE idcontacto = '$idcontacto_decode'";
$result0x = mysql_query($sql0x);

$fecha_creacion_carta = base64_encode(date("Y-m-d H:i:s"));
*/
/*
$idestado_cuenta_general = "";
$COUNT = 0;
$bandera = false;
$contador = 0;
$count_verifica_mov = 0;
$ref = "";
$contador = 0;
$sql100 = "SELECT * FROM estado_cuenta WHERE idcontacto = '$idcontacto_decode' and visible = 'SI'";
$result100 = mysql_query($sql100);
while ($fila100 = mysql_fetch_array($result100)) {
$contador++;
$f_mov = date_create("$fila100[fecha_movimiento]");
$f_mov = date_format($f_mov, 'd-m-Y');
$saldo_total = imprimir("$fila100[idestado_cuenta]", "$fila100[monto_precio]", $idcontacto_decode, $contador, $f_mov);
$saldo_total = $saldo_total;
}
$ultimo_mov_fecha = 'N/A';
$sql100 = "SELECT * FROM estado_cuenta WHERE idcontacto = '$idcontacto_decode' and visible = 'SI' and tipo_movimiento = 'abono' and concepto <> 'Otros Cargos' and concepto <> 'Compra Permuta' and concepto <> 'Devolucion'  ORDER BY fecha_movimiento asc";
$result100 = mysql_query($sql100);
while ($fila100 = mysql_fetch_array($result100)) {
$ultimo_mov_fecha = "$fila100[fecha_movimiento]";
$ultimo_mov_fecha = date_create($ultimo_mov_fecha);
$ultimo_mov_fecha = date_format($ultimo_mov_fecha, 'd-m-Y');
$ultimo_mov = 0;
$sql200x = "SELECT * FROM estado_cuenta WHERE idcontacto = '$idcontacto_decode' and visible = 'SI' and tipo_movimiento = 'abono' and concepto <> 'Otros Cargos' and referencia = '$fila100[referencia]' and concepto <> 'Compra Permuta' and concepto <> 'Devolucion'  ORDER BY fecha_movimiento asc";
$result200x = mysql_query($sql200x);
while ($fila200x = mysql_fetch_array($result200x)) {
$ultimo_mov = $ultimo_mov + "$fila200x[abono]";
}
}
function imprimir($idec, $mt_total, $idcontacto_decode, $contador, $fechas_mv){
global $saldo_total;
global $saldos;
$sql6 = "SELECT * FROM estado_cuenta WHERE idcontacto = '$idcontacto_decode' and visible = 'SI' and idestado_cuenta = '$idec'";
$result6 = mysql_query($sql6);
while ($fila6 = mysql_fetch_array($result6)) {
$tipo_mon = "";
$cambio = "";
$cantidad = "";
if ($fila6['abono'] != "") {
$abono = number_format($mt_total, 2);
} else { $abono = ""; }
if ($fila6['cargo'] != "") {
$cargo = number_format($mt_total, 2);
} else { $cargo = ""; }
if ($fila6['tipo_movimiento'] == "abono") {
$saldo_total = $saldos - $mt_total;
$saldos = $saldo_total;
$saldo_total = number_format($saldo_total, 2);
}
if ($fila6['tipo_movimiento'] == "cargo") {
$saldo_total = $saldos + $mt_total;
$saldos = $saldo_total;
$saldo_total = number_format($saldo_total, 2);
}
}
return $saldo_total;
}
*/
// dd(estado_cuenta::get()->last());
// return estado_cuenta::get(['monto_precio','fecha_movimiento'])->last()->monto_precio;
$abonos = estado_cuenta::where('idcontacto', $contacto->idcontacto)->where('visible', 'SI')->sum('abono');
$cargos = estado_cuenta::where('idcontacto', $contacto->idcontacto)->where('visible', 'SI')->sum('cargo');
$ultimo_abono = estado_cuenta::where('idcontacto', $contacto->idcontacto)->where('visible', 'SI')->get(['idestado_cuenta','monto_precio','fecha_movimiento'])->last();
if (is_null($ultimo_abono)) {
  $ultimo_mov = 0.00;
  $ultimo_mov_fecha = 'N/A';
}else {
  $ultimo_mov = $ultimo_abono->monto_precio;
  $ultimo_mov_fecha = 'N/A';
}
$saldo_total = $cargos-$abonos;
date_default_timezone_set('America/Mexico_City');
$date_actual = date("Y-m-d");
$pagares = DB::table('estado_cuenta')
->join('documentos_cobrar', 'documentos_cobrar.idestado_cuenta', '=', 'estado_cuenta.idestado_cuenta')
->select('estado_cuenta.idestado_cuenta','estado_cuenta.datos_marca','estado_cuenta.datos_version','estado_cuenta.datos_modelo','estado_cuenta.datos_color','estado_cuenta.datos_vin',
'documentos_cobrar.iddocumentos_cobrar','documentos_cobrar.fecha_vencimiento','documentos_cobrar.num_pagare','documentos_cobrar.monto')
->where('estado_cuenta.idcontacto', '=', $contacto->idcontacto)
->where('estado_cuenta.visible', '=', 'SI')
->where('documentos_cobrar.estatus', '=', 'Pendiente')
->whereDate('documentos_cobrar.fecha_vencimiento', '<=', $date_actual)
->get();
$saldos_vencidos = 0;
$saldo_abonos_pagares = 0;
foreach ($pagares as $pagare) {
  $documentos_pagar_saldo_vencido = documentos_cobrar::whereDate('fecha_vencimiento', '<=', $date_actual)->where('estatus', '=', 'Pendiente')->where('idestado_cuenta', $pagare->idestado_cuenta)->sum('monto');
  $saldos_vencidos += $documentos_pagar_saldo_vencido;
  $saldo_abonos_pagares += abonos_pagares::where('iddocumentos_cobrar', $pagare->iddocumentos_cobrar)->where('visible', 'SI')->sum('cantidad_pago');
}
$saldo_vencido = $saldos_vencidos-$saldo_abonos_pagares;
$estados_cuenta = estado_cuenta::where('idcontacto', $contacto->idcontacto)
->whereIn('concepto', ['Venta Directa','Venta Permuta','Compra Permuta','Cuenta de Deuda'])
->where('visible', 'SI')
->get(['idestado_cuenta','concepto','datos_marca','datos_version','datos_color','datos_modelo','datos_precio','fecha_guardado']);

$estados_cuenta_resumen = estado_cuenta::where('idcontacto', $contacto->idcontacto)
->select(
  'idestado_cuenta','concepto','fecha_movimiento','datos_estatus','datos_vin',
  'datos_marca','datos_version','datos_color','datos_modelo','monto_precio',
  'efecto_movimiento','tipo_movimiento','metodo_pago','referencia'
  ,DB::raw('CONCAT(YEAR(fecha_movimiento),"-",MONTH(fecha_movimiento)) AS fecha')
)
->where('visible','SI')
->whereIn('concepto', ['Venta Directa','Venta Permuta','Abono','Finiquito','Enganche','Compra Permuta','Devolución del VIN','Apartado','Otros Cargos','Movimiento Post-Venta','Devolucion','Documentos por Pagar','Interés'])
->orderBy('fecha','asc')
->get()
->groupBy('fecha');
$pagares_vencidos = DB::table('estado_cuenta')
->join('documentos_cobrar', 'documentos_cobrar.idestado_cuenta', '=', 'estado_cuenta.idestado_cuenta')
->select('estado_cuenta.idestado_cuenta','estado_cuenta.datos_marca','estado_cuenta.datos_version','estado_cuenta.datos_modelo','estado_cuenta.datos_color','estado_cuenta.datos_vin',
'documentos_cobrar.iddocumentos_cobrar','documentos_cobrar.fecha_vencimiento','documentos_cobrar.num_pagare','documentos_cobrar.monto','documentos_cobrar.tipo','documentos_cobrar.estatus','archivo_original')
->where('estado_cuenta.idcontacto', '=', $contacto->idcontacto)
->where('estado_cuenta.visible', '=', 'SI')
->where('documentos_cobrar.estatus', '=', 'Pendiente')
->whereDate('documentos_cobrar.fecha_vencimiento', '<=', $date_actual)
->orderBy('documentos_cobrar.iddocumentos_cobrar','asc')
->get();
$catalogo_documentos_contacto = catalogo_documentos_contacto::get();
$contactos_documentos = contactos_documentos::where('visible', 'SI')->where('idcontacto', $contacto->idcontacto)->get();
$contactos_cambios = contactos_cambios::where('idcontacto', $contacto->idcontacto)->get();
return view('CreditoCobranza.contacts.show',compact(
  'contacto','ultimo_mov','ultimo_mov_fecha','saldo_total',
  'pagares','saldo_vencido','estados_cuenta','estados_cuenta_resumen',
  'pagares_vencidos','catalogo_documentos_contacto','contactos_documentos',
  'contactos_cambios'
));
}
public function verifyMobilePhone(Request $request){
  if (strlen($request->telefono_celular)<10) {
    return '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>';
  }
  $check_phone = contactos::where('telefono_celular', $request->telefono_celular)->count();
  if ($check_phone==0) {
    return '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>';
  }else {
    return '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>';
  }
  // return $request;
}
public function verifyContactInfo($telefono_fijo,$telefono_celular,$correo){
  $exist_telefono_celular = contactos::where('telefono_celular', $telefono_celular)->count();
  $exist_telefono_otro = contactos::where('telefono_otro', $telefono_fijo)->count();
  $exist_email = contactos::where('email', $correo)->count();
  $contact_info = collect([
    'total'=>$exist_telefono_celular+$exist_telefono_otro+$exist_email,
    'exist_telefono_celular'=>$exist_telefono_celular,
    'exist_telefono_otro'=>$exist_telefono_otro,
    'exist_email'=>$exist_email
  ]);
  return $contact_info->all();
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
  return $nomenclatura;
  $date = Carbon::now()->format('dmY');
  return ['nomenclatura' => $nomenclatura];
}
public static function get_date_format($date) {
  $difference = \Carbon\Carbon::parse($date)->diff(\Carbon\Carbon::now());
  $date_difference = '';
  if ($difference->y > 0) {
    $date_difference .= ($difference->y > 1) ? $difference->y . ' Años, ' : $difference->y . ' Año, ';
  } if ($difference->m > 0) {
    $date_difference .= ($difference->m > 1) ? $difference->m . ' Meses, ' : $difference->m . ' Mes, ';
  } if ($difference->d > 0) {
    $date_difference .= ($difference->d > 1) ? $difference->d . ' Dias, ' : $difference->d . ' Dia, ';
  } if ($difference->h > 0) {
    $date_difference .= ($difference->h > 1) ? $difference->h . ' Horas, ' : $difference->h . ' Hora, ';
  } if ($difference->i > 0) {
    $date_difference .= ($difference->i > 1) ? $difference->i . ' Minutos, ' : $difference->i . ' Minuto, ';
  } if ($difference->s > 0) {
    $date_difference .= ($difference->s > 1) ? $difference->s . ' Segundos ' : $difference->s . ' Segundo ';
  }
  return $date_difference;
}
public static function getPagareSaldo($id_pagare){
  $abonos_pagares = abonos_pagares::where('iddocumentos_cobrar', $id_pagare)->where('visible', 'SI')->sum('cantidad_pago');
  return $abonos_pagares;
}
public static function saldoDocumentosCobrar($id_documentos_cobrar, $monto){
  $abonos = abonos_pagares::where('iddocumentos_cobrar', $id_documentos_cobrar)->where('visible', 'SI')->sum('cantidad_pago');
  return number_format(($monto - $abonos),2,'.',',');
}
}
