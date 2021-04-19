<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\documentos_pagar;
use App\Models\abonos_unidades_proveedores;
use App\Models\abonos_pagares_proveedores;
use App\Models\estado_cuenta_proveedores;


use Illuminate\Support\Facades\Auth;

class DemonV2PagareController extends Controller
{


  public function createPromissoryNotes(){
    // return 'xD';
    DB::beginTransaction();
    try {

              $Faltantes = [];

              date_default_timezone_set('America/Mexico_City');
              $fecha_actual = date("Y-m-d H:i:s");

              $EstadosCuentaP = estado_cuenta_proveedores::
              select('idestado_cuenta_proveedores','concepto','datos_estatus','monto_precio','monto_total','gran_total')
              ->where('visible', 'SI')
              ->where('datos_estatus', '!=', 'Pagada')
              ->where('monto_precio', '!=','1N093251')
              ->where('concepto', 'Compra Directa')
              ->count();
              return $EstadosCuentaP;
              foreach ($EstadosCuentaP as $key => $ECP) {

                $Pagares = documentos_pagar::where('idestado_cuenta', $ECP->idestado_cuenta_proveedores)->get();
                $EstadosCuentaP[$key]['Pagares'] = $Pagares;
                $Total_AbonosUP = floatval(abonos_unidades_proveedores::where('idestado_cuenta', $ECP->idestado_cuenta_proveedores)->sum('cantidad_pago'));
                $EstadosCuentaP[$key]['AbonosUnidadesP'] = $Total_AbonosUP;
                $Total_AbonosPP  = floatval(abonos_pagares_proveedores::where('idestado_cuenta_movimiento', $ECP->idestado_cuenta_proveedores)->sum('cantidad_pago'));
                $EstadosCuentaP[$key]['AbonosPagaresP']   = $Total_AbonosPP;

                $MontoPrecioECP = floatval($ECP->monto_precio);

                //-*-
                if(sizeof($Pagares) == 0 && $Total_AbonosUP == 0 && $Total_AbonosPP == 0){ //Si no tiene Pagares y nada abonado se le asigna  un pagare con toda la deuda

                  $this->CrearPagare('1/1',$MontoPrecioECP,'Pendiente',$ECP);

                }else if(sizeof($Pagares) >= 1  && $Total_AbonosUP == 0 && $Total_AbonosPP == 0){ //-------> Si tiene pagares pero ningun Abono

                  $SumaMontoPagares =  0;
                  foreach ($Pagares as $B => $v) {
                    $SumaMontoPagares += $v->monto;
                  }
                  $SumaMontoPagares =  floatval(round($SumaMontoPagares));
                  //$MontoPendiente =  $Pagares->where('estatus','Pendiente')->sum('monto');
                  //$MontoPagado =  $Pagares->where('estatus','Pagado')->sum('monto');

                  if ($SumaMontoPagares < $MontoPrecioECP) {//Se genera un nuevo pagare con la deuda restante
                    $this->CrearPagare((sizeof($Pagares)+1).'/'.(sizeof($Pagares)+1),($MontoPrecioECP - $SumaMontoPagares),'Pendiente',$ECP);
                  }else if($SumaMontoPagares == $MontoPrecioECP){
                    //Ya ha pagare creado con la cantidad exacta
                  }else if ($SumaMontoPagares > $MontoPrecioECP){
                    //Ya ha pagares creado con la cantidad >= , hay que actualizar el ECP a Pagada
                  }else{
                    $EstadosCuentaP[$key]['Estado de Cuenta'] = $ECP->idestado_cuenta_proveedores;
                    $EstadosCuentaP[$key]['Metodo 1'] = '*********** Suma Pagares '.$SumaMontoPagares.' != '.$MontoPrecioECP.'-----'.($SumaMontoPagares - $MontoPrecioECP).'-----';
                    $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
                  }
                }else if(sizeof($Pagares) >= 1 && $Total_AbonosUP != 0 && $Total_AbonosPP != 0){ //------->Si tiene pagares y hay Abonos
                  $SumaMontoPagares =  0;
                  foreach ($Pagares as $B => $v) {
                    $SumaMontoPagares += $v->monto;
                  }
                  if($SumaMontoPagares == $MontoPrecioECP){
                    //Ya ha pagare creado con la cantidad exacta
                  }else if($SumaMontoPagares < $MontoPrecioECP){
                    $this->CrearPagare((sizeof($Pagares)+1).'/'.(sizeof($Pagares)+1),($MontoPrecioECP - $SumaMontoPagares),'Pendiente',$ECP);
                  }else{
                    $EstadosCuentaP[$key]['Estado de Cuenta'] = $ECP->idestado_cuenta_proveedores;
                    $EstadosCuentaP[$key]['Metodo 2'] = '*********** Suma Pagares '.$SumaMontoPagares.' != '.$MontoPrecioECP.'-----'.($SumaMontoPagares - $MontoPrecioECP).'-----';
                    $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
                  }

                }else{ //No tiene pagares

                  //Tiene Abonos Unidades Proveedores pero no tiene Abonos Pagares Proveedores
                  if($Total_AbonosUP >= 0 && $Total_AbonosPP == 0){
                    if($Total_AbonosUP < $MontoPrecioECP){
                      $this->CrearPagare('1/1',($MontoPrecioECP - $Total_AbonosUP),'Pendiente',$ECP);
                    }else if($Total_AbonosUP == $MontoPrecioECP){
                      //Ya esta pagada solo hay que actualizar a pagada el estado de cuenta
                    }else if($Total_AbonosUP > $MontoPrecioECP){
                      $this->CrearPagare('1/1',$MontoPrecioECP,'Pagado',$ECP);
                    }else{
                      $EstadosCuentaP[$key]['Estado de Cuenta'] = $ECP->idestado_cuenta_proveedores;
                      $EstadosCuentaP[$key]['Metodo 3'] = '***********';
                      $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
                    }
                  }
                  //Tiene Abonos Pagares Proveedores sin tener registro en Documentos por cobrar :)
                  //y sin tener registro en Abonos Unidades Proveedores
                  else if($Total_AbonosPP >= 0 && $Total_AbonosUP == 0){
                    if($Total_AbonosPP < $MontoPrecioECP){
                      $this->CrearPagare('1/1',($MontoPrecioECP - $Total_AbonosPP),'Pendiente',$ECP);
                    }else if($Total_AbonosPP == $MontoPrecioECP){
                      //Ya esta pagada solo hay que actualizar a pagada el estado de cuenta
                    }else{
                      $EstadosCuentaP[$key]['Estado de Cuenta'] = $ECP->idestado_cuenta_proveedores;
                      $EstadosCuentaP[$key]['Metodo 4'] = '***********';
                      $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
                    }
                  }else{
                    $EstadosCuentaP[$key]['Estado de Cuenta'] = $ECP->idestado_cuenta_proveedores;
                    $EstadosCuentaP[$key]['Metodo 5'] = '***********';
                    $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
                  }

                }
              }
      return $EstadosCuentaP->count();
      foreach ($EstadosCuentaP as $EC) {
        if (empty($EC['Pagares'])) {
          return $EC;
        }
      }
      DB::commit();
      return $Faltantes;

      return back()->with('success','Cita confirmada');
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
      return $e->getMessage();
    }
  }

  public function CrearPagare($Serie,$Monto,$Estatus,$Estado_Cuenta){

      date_default_timezone_set('America/Mexico_City');
      $fecha_actual = date("Y-m-d H:i:s");

      $NuevoPagare = documentos_pagar::createDocumentosPagar(
        $Serie,
        $Monto,
        $Estado_Cuenta->fecha_creacion == null ? $fecha_actual:$Estado_Cuenta->fecha_creacion,
        'Virtual',
        $Estatus,
        $archivo_anticipo = 'N/A',
        $archivo_entregado = '#',
        'Generado por el sistema',
        $Estado_Cuenta->idestado_cuenta_proveedores,
        '',
        $fecha_actual,
        $visible = 'SI'
      );

  }

}
