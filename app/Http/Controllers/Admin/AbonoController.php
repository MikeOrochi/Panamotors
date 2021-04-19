<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\documentos_pagar_abonos_unidades_proveedores;
use App\Models\abonos_unidades_proveedores;
use App\Models\abonos_pagares_proveedores;
use App\Models\estado_cuenta_proveedores;
use App\Models\beneficiarios_proveedores;
use App\Models\recibos_proveedores;
use App\Models\documentos_cobrar;
use App\Models\documentos_pagar;
use App\Models\abonos_unidades;
use App\Models\abonos_pagares;
use App\Models\estado_cuenta;
use App\Models\proveedores;
use App\Models\contactos;
use App\Models\recibos;

class AbonoController extends Controller{

  public function __construct(){
    $this->middleware('auth');
  }


  public static function abonar($id,$concepto,$tipo_movimiento,$efecto_movimiento,
  $fecha_movimiento,$metodo_pago,$tipo_moneda,$tipo_cambio,$saldo_anterior,$monto_abono,
  $saldo,$monto_precio,$saldo_anterior_pagare,$monto_abono_pagare,$marca,$modelo,
  $color,$version,$vin,$precio_u,$emisora_institucion,$emisora_agente,$depositante,
  $receptora_institucion,$receptora_agente,$tipo_comprobante,$referencia,$serie_general,
  $monto_general,$fecha_inicio,$cliente,$file,$movimiento_original){


    DB::beginTransaction();
    DB::connection()->enableQueryLog();
    try {
      $id = $id;
      $concepto = $concepto;//Abono";
      $tipo_movimiento = $tipo_movimiento;
      if ($concepto == 'Otros Cargos' && $tipo_movimiento == 'cargo') {
        $concepto = 'Otros Cargos-C';
      } else if ($concepto == 'Otros Cargos' && $tipo_movimiento == 'abono') {
        $concepto = 'Otros Cargos-A';
      }
      $efecto_movimiento = $efecto_movimiento;
      $fecha_movimiento = $fecha_movimiento;
      $metodo_pago = $metodo_pago;
      $tipo_moneda = $tipo_moneda;
      $tipo_cambio = $tipo_cambio;
      $saldo_anterior = $saldo_anterior;
      $monto_abono = $monto_abono;
      $saldo = $saldo;
      $monto_precio = $monto_precio;
      $tipo_cambio = $tipo_cambio;
      $saldo_anterior_pagare = $saldo_anterior_pagare;
      $monto_abono_pagare = $monto_abono_pagare;
      $saldo_pagare=$saldo-$monto_precio;

      $marca = $marca;
      $modelo = $modelo;
      $color = $color;
      $version = $version;
      $vin = $vin;
      $precio_u = $precio_u;

      $emisora_institucion = $emisora_institucion;
      $emisora_agente = $emisora_agente;
      $depositante = $depositante;
      $receptora_institucion = $receptora_institucion;

      $receptora_agente = $receptora_agente;
      $tipo_comprobante = $tipo_comprobante;
      $referencia = $referencia;

      $ValidarReferencia = abonos_pagares_proveedores::where('referencia', $referencia)->where('visible', 'SI')->where('referencia', '<>','S/N')->get();
      if(sizeof($ValidarReferencia) != 0){
        return back()->with('error', 'Error la referencia acaba de ser tomada intente con otra')->withInput();
      }

      // $actividad = request()->no_pagare;

      //echo $actividad;
      $comentarios = 'Abono otros cargos';

      $asesor11 = null;
      $enlace11 = null;
      $asesor22 = null;
      $enlace22 = null;

      $serie_general = $serie_general;
      $monto_general = $monto_general;
      $fecha_inicio = $fecha_inicio;


      if($tipo_moneda=="USD" || $tipo_moneda=="CAD"){
        $monto_general_recibo = $monto_precio;
        $monto_precio=$monto_precio*$tipo_cambio;
        $monto_pesos_recibo = $monto_precio;
      }

      if ($fecha_movimiento=="" || $fecha_movimiento=="0000-00-00") {
        return back()->with('error', 'No se tiene asignada una fecha para el movimiento,valide la información e intente nuevamente')->withInput();
      }else{
        // dd($tipo_movimiento);

        if ($tipo_movimiento=="cargo") {
          $cargo=$monto_abono;
          $abono="";
        }
        if ($tipo_movimiento=="abono") {
          $cargo="";
          $abono=$monto_abono;
        }

        $cliente = $cliente;
        $movimiento_original = $movimiento_original;
        date_default_timezone_set('America/Mexico_City');
        $actual= date("Y_m_d__H_i_s");
        $fecha_actual= date("Y-m-d H:i:s");
        $usuario_creador = \Request::cookie('usuario_creador');
        $estado_unidad="";
        //Copiar Archivo
        $file = $file;
        if ($file == "" || $file == null) {
          $archivo_cargado="#";
        }else{
          $nombre = $file->getClientOriginalName();
          $extension = pathinfo($nombre, PATHINFO_EXTENSION);
          $nombre = "P".$cliente."_".$actual."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
          $archivo_cargado = storage_path('app').'/movements/'.$nombre.'.'.$extension;
          Storage::disk('local')->put('/movements/'.$nombre.'.'.$extension,  \File::get($file));
        }
        if($concepto=="Abono" || strpos($concepto, 'Otros Cargos')===0 || $concepto=='Finiquito de VIN'){
          $monto_abonar_pagares=1;
          // return request();
          while ($monto_abonar_pagares>0) {
            if (strpos($concepto, 'Otros Cargos')===0 || $concepto=='Finiquito de VIN') {
              $monto_abonar_pagares=0;
            }
            $estado_unidad = "Pendiente";
            $monto_precio_temp = 0;
            if ($concepto=="Abono") {
              if (documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->count()==0) {
                $new_documentos_pagar = documentos_pagar::createDocumentosPagar('1/1', $movimiento_original, \Carbon\Carbon::now()->format('Y-m-d'), 'Virtual', 'Pendiente', 'N/A', '#', 'Abono prueva', $movimiento_original, $usuario_creador, \Carbon\Carbon::now(), 'SI');
                $estado_unidad = 'Pagada';
              }
              $documento_pagar_pendiente = documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->where('estatus', 'Pendiente')->get(['iddocumentos_pagar','idestado_cuenta','monto','estatus'])->first();
              $monto_alcanzado_pagare = documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado');
              if ($documento_pagar_pendiente->monto>$monto_precio) {
                $abono = $monto_precio;
              }else {
                $abono = $documento_pagar_pendiente->monto - $monto_alcanzado_pagare;
              }
              $saldo = $saldo_anterior-$abono;
              $monto_precio_temp=$monto_precio;
              $monto_precio = $abono;
              $gran_total = $abono/$tipo_cambio;
              $monto_general=$abono;
            }else {
              $gran_total = $monto_precio/$tipo_cambio;
            }
            // dd($cargo);
            $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
            $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio,$serie_general, $monto_general,$tipo_moneda,
            $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
            $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
            $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
            $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
            $fecha_actual, $referencia, $folio_anterior = "", $actividad, $depositante, $col5 = null, $col6 = null,
            $col7 = null, $col8 = null, $col9 = null, $col10 = null);
            $id_recx = $ins_edo_cta->idestado_cuenta_proveedores;
            // dd($ins_edo_cta);
            if (empty($movimiento_original)) {
              $movimiento_original = $ins_edo_cta->idestado_cuenta_proveedores;
            }else {

              if(estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $movimiento_original)->count()!=0){
                $compra_directa = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $movimiento_original)->first();
                $marca = $compra_directa->datos_marca;
                $modelo = $compra_directa->datos_modelo;
                $color = $compra_directa->datos_color;
                $version = $compra_directa->datos_version;
                $vin = $compra_directa->datos_vin;
              }
            }
            if ($concepto=="Abono") {
              $monto_precio = (float)$monto_precio;
              $monto_abonar_pagares = $monto_precio;
              if (!empty($documento_pagar_pendiente)) {
                // foreach ($documentos_pagar_pendientes as $documento_pagar_pendiente) {
                if (documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado')<$documento_pagar_pendiente->monto) {
                  $documento_pagar_pendiente_monto=(float)$documento_pagar_pendiente->monto;
                  if ($monto_abonar_pagares>$documento_pagar_pendiente->monto) {
                    // $monto_precio = $monto_abonar_pagares-$documento_pagar_pendiente_monto;
                    $monto_abonar_pagares = $documento_pagar_pendiente->monto;
                  }else {
                    $monto_abonar_pagares = $abono;
                  }
                  if ($monto_abonar_pagares>0) {
                    // dd($documento_pagar_pendiente->monto-$monto_abonar_pagares);
                    // $documento_pagar_pendiente_monto = $documento_pagar_pendiente_monto-$monto_abonar_pagares;
                    $abono_a_pagare = documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado');

                    $ins_abono_unidad = abonos_unidades_proveedores::createAbonosUnidadesProveedores( $concepto, $documento_pagar_pendiente->monto - $abono_a_pagare,
                    $monto_abonar_pagares, ($documento_pagar_pendiente->monto-$abono_a_pagare)-$monto_abonar_pagares, '', $monto_general, $emisora_institucion, $emisora_agente,
                    $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $metodo_pago, $fecha_movimiento,
                    $marca, $version, $color, $modelo, $precio_u, $vin, $archivo_cargado, $comentarios,
                    $movimiento_original, $usuario_creador, $fecha_inicio, $fecha_actual, $visible = 'SI', $ins_edo_cta->idestado_cuenta_proveedores,
                    $tipo_moneda, $tipo_cambio, $monto_precio/$tipo_cambio);
                    $documentos_pagar_abonos_unidades_proveedores = documentos_pagar_abonos_unidades_proveedores::createDocumentosPagarAbonosUnidadesProv($documento_pagar_pendiente->iddocumentos_pagar,
                    $ins_abono_unidad->idabonos_unidades_proveedores, $documento_pagar_pendiente->monto-$abono_a_pagare, $monto_abonar_pagares, \Carbon\Carbon::now());
                    // $monto_abonar_pagares=$monto_abonar_pagares-$monto_abonar_pagare;

                    $abonos_pagares_proveedores = abonos_pagares_proveedores::createAbonoPagaresProveedores($documento_pagar_pendiente->monto-$abono_a_pagare, $monto_abonar_pagares, (($documento_pagar_pendiente->monto-$abono_a_pagare) - $monto_abonar_pagares),
                    'N/A', $monto_abonar_pagares, $emisora_institucion,$emisora_agente,$receptora_institucion,$receptora_agente,$tipo_comprobante,$referencia,$metodo_pago,$fecha_movimiento,$archivo_cargado,$comentarios,
                    $documento_pagar_pendiente->iddocumentos_pagar,$usuario_creador,$fecha_inicio, $fecha_actual,'SI',$ins_edo_cta->idestado_cuenta_proveedores,$tipo_moneda,$tipo_cambio,$monto_abonar_pagares/$tipo_cambio);
                    // dd($abonos_pagares_proveedores);
                    // $monto_precio = $documento_pagar_pendiente->monto - $monto_abonar_pagare;
                    // $monto_abonar_pagares = $monto_precio;
                    if (documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado')>=$documento_pagar_pendiente->monto) {
                      $documento_pagar_pendiente->estatus='Pagado';
                      $documento_pagar_pendiente->saveOrFail();
                    }
                  }
                }
                // dd($monto_abonar_pagares);
                $saldo_anterior = $saldo;
                if ($monto_precio_temp>0) {
                  $monto_precio = $monto_precio_temp;
                }
                // dd($monto_precio);
                if (documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->where('estatus', 'Pendiente')->get(['iddocumentos_pagar','idestado_cuenta','monto','estatus'])->count()==0) {

                  $monto_precio = $saldo;
                }
                $monto_precio = $monto_precio - $monto_abonar_pagares;
                $saldo = $saldo_anterior-$monto_precio;
                $monto_abonar_pagares = $monto_precio;
                $monto_abono = $monto_abonar_pagares;
                $saldo_pagare=$saldo-$monto_precio;
                $monto_general = $monto_precio;
                $gran_total=$monto_precio;
                if ($tipo_movimiento=="cargo") {
                  $cargo=$monto_abono;
                  $abono="";
                }
                if ($tipo_movimiento=="abono") {
                  $cargo="";
                  $abono=$monto_abono;
                }
                // dd($monto_abonar_pagares);
                // }
                if (documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->where('estatus', 'Pendiente')->count()==0) {
                  estado_cuenta_proveedores::updatePayedStateAccountProviders($movimiento_original);
                }
              }
            }
          }
          if($metodo_pago==1){
            // return $ins_edo_cta;
            $recibos_proveedores = recibos_proveedores::createRecibosProveedores($fecha_movimiento, $monto_pesos_recibo, $emisora_institucion,
            $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, $metodo_pago, $referencia, $comentarios,
            $ins_edo_cta->idestado_cuenta_proveedores, null, $cliente, $usuario_creador, null, $fecha_actual, $tipo_moneda, $tipo_cambio, $monto_general_recibo);
            session(['recibos_proveedores' => $recibos_proveedores->id]);
            // return $recibos_proveedores;
            // dd($recibos_proveedores,$ins_edo_cta,$ins_abono_unidad,$abonos_pagares_proveedores);
          }
          DB::commit();
          return 'ok';
        }else{
          return 'no_ok';
        }// Validacion de fecha nula de movimiento
      }

      //DB::commit();
      //$queries = json_encode(DB::getQueryLog());

      // return back()->with('error','Algo no sucedio como debiera :(')->withInput();
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
      return $e->getMessage();
      return back()->with('error', $e->getMessage() )->withInput();
    }

  }

}
