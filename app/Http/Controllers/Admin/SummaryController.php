<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\estado_cuenta_proveedores;
use App\Models\abonos_unidades_proveedores;
use App\Models\recibos_proveedores;
use App\Models\proveedores;
use App\Models\usuarios;
use App\Models\fechas_compromiso_pagrares_proveedores;
use App\Models\documentos_pagar;
use App\Http\Controllers\Admin\TransferController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class SummaryController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public static function ResumenUnidadPagos($idEC){

    DB::beginTransaction();
    try {

    $EstadoCP = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $idEC)->where('visible', 'SI')->get();
    foreach ($EstadoCP as $key => $ECP) {
      $id_contacto = $ECP->idcontacto;
      $c10 = base64_encode($ECP->idcontacto);
      $nombre_unidad = $ECP->datos_marca.' '.$ECP->datos_version.' '.$ECP->datos_modelo.' '.$ECP->datos_color;
      $vin_unidad = $ECP->datos_vin;
      $concepto_general = $ECP->concepto;
      $precio_general = number_format($ECP->datos_precio,2);
      $estatus_unidad = $ECP->datos_estatus;
      $folio = $ECP->col1;
      $folio_anterior = $ECP->col2;
    }

    $Proveedor = proveedores::where('idproveedores', $id_contacto)->get();
    foreach ($Proveedor as $key => $P) {
      $nombre=ucwords($P->nombre);
      $apellidos=ucwords($P->apellidos);
      $nombre_completo= $P->nombre.' '.$P->apellidos;
    }


    $AbonosUP = abonos_unidades_proveedores::where('idestado_cuenta', $idEC)->where('visible', 'SI')->get();

    foreach ($AbonosUP as $key => $AUP) {

      $AbonosUP[$key]->monto_precio_formato=number_format($AUP->cantidad_pago,2);
      $AbonosUP[$key]->saldo_letras= TransferController::getNumberToLetters($AUP->cantidad_pago,'')['info'];
      $AbonosUP[$key]->saldo_anterior=number_format($AUP->cantidad_inicial == "" ? 0 : $AUP->cantidad_inicial,2);
      $AbonosUP[$key]->saldo_actual=number_format($AUP->cantidad_pendiente == "" ? 0 : $AUP->cantidad_pendiente,2);

      if ($AUP->monto_total != "") {
        $AbonosUP[$key]->monto_total_general=number_format($AUP->monto_total,2);
      }else{
        $AbonosUP[$key]->monto_total_general="N/A";
      }


      if ($AUP->usuario_guardo == "" || $AUP->usuario_guardo == null) {
        $AbonosUP[$key]->usuario_creador = "";
      }else{
        $Usuario = usuarios::select('nombre_usuario')->where('idusuario', $AUP->usuario_guardo)->first();
        $AbonosUP[$key]->usuario_creador = $Usuario->nombre_usuario;
      }


      $url_archivo = $AUP->archivo;
      if ($url_archivo=="" || $url_archivo=="#") {
        $c1=base64_encode($AUP->idabonos_unidades_proveedores);
        $AbonosUP[$key]->link_archivos="<a href='comprobante_abono_unidad.php?idau=$c1&idm=$idEC' title='Subir comprobante' target='_blank'><i class='fa fa-upload'></i></a>";
      }else{
        $AbonosUP[$key]->link_archivos="<a href='$url_archivo' target='_blank'><i class='fa fa-file'></i></a>";
      }


      if ($AUP->tipo_comprobante == "Recibo Automático") {
        $recibo = recibos_proveedores::select('idrecibos_proveedores')->where('fecha_guardado', $AUP->fecha_guardado )->first();
        if($recibo){
          $recibo = base64_encode($recibo->idrecibos_proveedores);
        }
        $AbonosUP[$key]->link_recibo_automatico="<a href='recibo_pdf.php?idrb=$recibo' title='Ver Recibo' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
      }else{
        $AbonosUP[$key]->link_recibo_automatico="";
      }
    }


    	DB::commit();

    return view('admin.summary.index',compact(
      'nombre_completo',
      'folio',
      'folio_anterior',
      'nombre_unidad',
      'precio_general',
      'vin_unidad',
      'estatus_unidad',
      'concepto_general',
      'c10',
      'idEC',
      'estatus_unidad',
      'AbonosUP'
    ));

    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error','Error al procesar la solicitud, intente de nuevo');
    }
  }


  public function Pagares($idcontacto,$idmovmiento){
    $idconta = base64_decode(base64_decode($idcontacto));
    $id_movimiento = base64_decode($idmovmiento);


    $Proveedores = proveedores::where('idproveedores', $idconta)->first();
    $nombre=ucwords($Proveedores->nombre);
    $apellidos=ucwords($Proveedores->apellidos);
    $nombre_completo = $Proveedores->nombre.' '.$Proveedores->apellidos;


    $EstadoCP = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $id_movimiento)->first();
    $id_contacto = $EstadoCP->idcontacto;
    $c10=base64_encode($EstadoCP->idcontacto);
    $nombre_unidad = $EstadoCP->datos_marca.' '. $EstadoCP->datos_version.' '.$EstadoCP->datos_modelo.' '.$EstadoCP->datos_color;
    $vin_unidad = $EstadoCP->datos_vin;
    $concepto_general = $EstadoCP->concepto;
    $precio_general = number_format($EstadoCP->datos_precio,2);
    $estatus_unidad = $EstadoCP->datos_estatus;
    $folio = $EstadoCP->col1;
    $folio_anterior = $EstadoCP->col2;

    $iniciales_cliente = "";
    $porciones = explode(" ", $nombre_completo);
    foreach ($porciones as $parte) {
      $iniciales_cliente.=substr($parte,0,1);
    }
    $iniciales_cliente = mb_strtoupper($iniciales_cliente);


    return view('admin.summary.pagares',compact(
      'nombre_completo',
      'folio',
      'folio_anterior',
      'nombre_unidad',
      'precio_general',
      'vin_unidad',
      'idconta',
      'id_movimiento'
    ));
  }

  public function GuardarPagare(){
    $serie_pagare = request()->n_serie;
    $monto_pagare = request()->monto_pagare;
    $tipo = request()->tipo;
    $fecha_movimiento = request()->fechapago1;
    $comentarios = request()->descripcion;
    $id_movimiento = request()->movimiento_general;
    $usuario_creador = \Request::cookie('usuario_creador');
    $nombre = request()->nombre_com;
    $idcontacto = request()->idcontacto;

    if ($fecha_movimiento=="" || $fecha_movimiento=="0000-00-00") {
      return back()->with('error', 'No se tiene asignada una fecha para el movimiento,valide la información e intente nuevamente')->withInput();
    }else{

      date_default_timezone_set('America/Mexico_City');
      $actual = date("Y_m_d__H_i_s");
      $fecha_actual = date("Y-m-d H:i:s");
      $usuario_creador = \Request::cookie('usuario_creador');
      $target_path = "../../Pagares_Limpios/";


      if ($tipo == "Físico" || $tipo == "Virtual") {

        $archivo_original = "N/A";

        if ($tipo == "Físico") {
          //Copiar Archivo
          $file = request()->file('uploadedfile');
          if ($file != "" || $file != null) {
            $nombre = $file->getClientOriginalName();
            $extension = pathinfo($nombre, PATHINFO_EXTENSION);
            $nombre = "P".$idcontacto."_".(date('Y-m-d'))."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
            $archivo_original = 'storage/app/Pagares_Limpios/'.$nombre;
            Storage::disk('local')->put('/Pagares_Limpios/'.$nombre,  \File::get($file));
          }
        }

        $Pagare = documentos_pagar::createDocumentosPagar(
          $serie_pagare,$monto_pagare,$fecha_movimiento,
          $tipo = 'Virtual',$estatus = 'Pendiente',$archivo_original,
          $archivo_entregado = '#',$comentarios,$id_movimiento,
          $usuario_creador,$fecha_actual,$visible = 'SI'
        );

        $VerificarFecha = fechas_compromiso_pagrares_proveedores::where('start', 'like', $fecha_movimiento.'%')->where('tipo', 'pattern')->get();
        if(sizeof($VerificarFecha) == 0){
          $aux = 0;
        }else{
          $aux = 20 * sizeof($VerificarFecha);
        }


       $fecha_ini =  new \DateTime($fecha_movimiento." 09:05:00");
       $fecha_ini->add(new \DateInterval('PT' . $aux . 'M'));

       $fecha_fin =  new \DateTime($fecha_movimiento." 09:05:00");
       $fecha_fin->add(new \DateInterval('PT' . 20 . 'M'));

       $monto1 = number_format((float)$monto_pagare, 2, '.', ',');

        $Vencimiento = fechas_compromiso_pagrares_proveedores::createFechaCompromisoPP(
          $comentarios,'',
          $fecha_ini->format('Y-m-d H:i:s'),$fecha_fin->format('Y-m-d H:i:s'),
          $ejecutivo = '',$color = 'blue',$Pagare->iddocumentos_pagar,
          $usuario_creador,$fecha_actual,$fecha_actual,$archivo = '',
          $cumplimiento = '',$fecha_real_archivo = '0001-01-01 00:00:00',
          $fecha_carga_archivo = '0001-01-01 00:00:00',
          'Vencimiento: $'.$monto1.', '.$idcontacto.'.'.$this->get_initial_chars($nombre).' '.$nombre,
          $visible = 'SI');

          $Recordatorio = fechas_compromiso_pagrares_proveedores::createFechaCompromisoPP(
            $comentarios,'',
            $fecha_ini->format('Y-m-d H:i:s'),$fecha_fin->format('Y-m-d H:i:s'),
            $ejecutivo = '',$color = 'green',$Pagare->iddocumentos_pagar,
            $usuario_creador,$fecha_actual,$fecha_actual,$archivo = '',
            $cumplimiento = '',$fecha_real_archivo = '0001-01-01 00:00:00',
            $fecha_carga_archivo = '0001-01-01 00:00:00',
            'Recordatorio: $'.$monto1.', '.$idcontacto.'.'.$this->get_initial_chars($nombre).' '.$nombre,
            $visible = 'SI');

            return back()->with('success', 'Pagare '.$tipo.' creado correctamente');

      }else {
          return back()->with('error', 'El tipo asignado no es valido')->withInput();
      }


    }
  }

  public function get_initial_chars($w){
    $words = explode(" ", $w);
    $acronym = "";

    foreach ($words as $w) {
      $acronym .= strtoupper(substr($w,0,1));
    }
    return $acronym;
  }

}
