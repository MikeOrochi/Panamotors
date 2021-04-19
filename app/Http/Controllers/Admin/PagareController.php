<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\documentos_pagar;
use App\Models\estado_cuenta_proveedores;
use App\Models\abonos_unidades_proveedores;
use App\Models\proveedores;
use Illuminate\Support\Facades\Auth;

class PagareController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){

    DB::beginTransaction();
    try {
      $Hoy = \Carbon\Carbon::now()->format('Y-m-d');

      //------------------------------------------------------------- Por Vencer
      $PagaresPorVencer = documentos_pagar::
      select('documentos_pagar.num_pagare','documentos_pagar.monto','documentos_pagar.fecha_vencimiento','documentos_pagar.tipo','documentos_pagar.archivo_original','documentos_pagar.comentarios','documentos_pagar.estatus','documentos_pagar.idestado_cuenta','abonos_unidades_proveedores.cantidad_pago as AbonoUP')
      ->leftJoin('abonos_pagares_proveedores', 'abonos_pagares_proveedores.iddocumentos_pagar' ,'=','documentos_pagar.iddocumentos_pagar')
      ->leftJoin('abonos_unidades_proveedores', 'abonos_unidades_proveedores.idestado_cuenta_movimiento' ,'=','abonos_pagares_proveedores.idestado_cuenta_movimiento')
      ->where('documentos_pagar.visible', 'SI')->where('documentos_pagar.estatus', 'Pendiente')->where('documentos_pagar.fecha_vencimiento','>=',$Hoy)
      ->orderBy('documentos_pagar.fecha_vencimiento', 'ASC')->get();
      $TotalPagaresPorVencer  = sizeof($PagaresPorVencer);
      $PagaresPorVencer = $PagaresPorVencer->groupBy('idestado_cuenta');
      $UnidadesPorVencer = sizeof($PagaresPorVencer);



      $FechasPorVencer = documentos_pagar::select(DB::raw('MAX(fecha_vencimiento) as Maxima'),DB::raw('MIN(fecha_vencimiento) as Minima'))
      ->where('visible', 'SI')->where('estatus', 'Pendiente')->where('fecha_vencimiento','>=',$Hoy)
      ->first();

      //------------------------------------------------------------- Ya vencidos

      $PagaresVencidos = documentos_pagar::
      select('documentos_pagar.num_pagare','documentos_pagar.monto','documentos_pagar.fecha_vencimiento','documentos_pagar.tipo','documentos_pagar.archivo_original','documentos_pagar.comentarios','documentos_pagar.estatus','documentos_pagar.idestado_cuenta','abonos_unidades_proveedores.cantidad_pago as AbonoUP')
      ->leftJoin('abonos_pagares_proveedores', 'abonos_pagares_proveedores.iddocumentos_pagar' ,'=','documentos_pagar.iddocumentos_pagar')
      ->leftJoin('abonos_unidades_proveedores', 'abonos_unidades_proveedores.idestado_cuenta_movimiento' ,'=','abonos_pagares_proveedores.idestado_cuenta_movimiento')
      ->where('documentos_pagar.visible', 'SI')->where('documentos_pagar.estatus', 'Pendiente')->where('documentos_pagar.fecha_vencimiento','<',$Hoy)
      ->orderBy('documentos_pagar.fecha_vencimiento', 'ASC')->get();
      $TotalPagaresVencidos  = sizeof($PagaresVencidos);
      $PagaresVencidos = $PagaresVencidos->groupBy('idestado_cuenta');
      $UnidadesVencidas = sizeof($PagaresVencidos);

      $FechasVencidas = documentos_pagar::select(DB::raw('MAX(fecha_vencimiento) as Maxima'),DB::raw('MIN(fecha_vencimiento) as Minima'))
      ->where('visible', 'SI')->where('estatus', 'Pendiente')->where('fecha_vencimiento','<',$Hoy)
      ->first();
      //-------------------------------------------------------------




      $ArregloPagares = [];

      foreach ($PagaresVencidos as $PV => $PagaVen) {
        $ArregloPagares[$PV]['Vecidos'] = $PagaVen;
      }
      foreach ($PagaresPorVencer as $PPV => $PagaPorVen) {
        $ArregloPagares[$PPV]['PorVencer'] = $PagaPorVen;
      }


      $NombresProveedores = [];

      $DineroVenc = array('MXN' => 0, 'USD' => 0, 'CAD' => 0);
      $DineroPorVenc = array('MXN' => 0,'USD' => 0,'CAD' => 0);

      foreach ($ArregloPagares as $EDC => $BuscarPagados) {
        $Id_EstadoC = isset($BuscarPagados['Vecidos']) ? $BuscarPagados['Vecidos']->first()->idestado_cuenta : $BuscarPagados['PorVencer']->first()->idestado_cuenta;

        $ArregloPagares[$EDC]['Pagados'] = documentos_pagar::
        select('documentos_pagar.num_pagare','documentos_pagar.monto','documentos_pagar.fecha_vencimiento',
        'documentos_pagar.tipo','documentos_pagar.archivo_original','documentos_pagar.comentarios',
        'documentos_pagar.estatus','documentos_pagar.idestado_cuenta',
        'abonos_pagares_proveedores.cantidad_pago','abonos_pagares_proveedores.tipo_moneda'
        )
        ->rightJoin('abonos_pagares_proveedores', 'documentos_pagar.iddocumentos_pagar', '=', 'abonos_pagares_proveedores.iddocumentos_pagar')
        ->where('documentos_pagar.visible', 'SI')->where('documentos_pagar.estatus', 'Pagado')
        ->where('documentos_pagar.idestado_cuenta', $Id_EstadoC)
        ->orderBy('documentos_pagar.fecha_vencimiento', 'ASC')->get();




        $DatosEC = estado_cuenta_proveedores::select('datos_vin','tipo_moneda','monto_precio','idproveedores','tipo_cambio',
        'nombre','apellidos','proveedores.col2')
        ->leftJoin('proveedores', 'estado_cuenta_proveedores.idcontacto', '=', 'proveedores.idproveedores')
        ->where('idestado_cuenta_proveedores', $Id_EstadoC)->first();
        $ArregloPagares[$EDC]['ECP'] = $DatosEC;

        if(isset($ArregloPagares[$EDC]['Vecidos'])){
          $DineroVenc[$DatosEC->tipo_moneda]+= $ArregloPagares[$EDC]['Vecidos']->sum('monto');
        }
        if(isset($ArregloPagares[$EDC]['PorVencer'])){
          $DineroPorVenc[$DatosEC->tipo_moneda]+= $ArregloPagares[$EDC]['PorVencer']->sum('monto');
        }

        $AbonosUP =abonos_unidades_proveedores::select('cantidad_pago','tipo_moneda')
        ->where('idestado_cuenta', $Id_EstadoC)
        ->where('visible', 'SI')->get();


        $TotalAbonosUP = [];
        if(sizeof($AbonosUP) > 0){

          $TotalAbonosUP[$DatosEC->tipo_moneda] = 0;

          foreach ($AbonosUP as $A_U_P) {
            if($A_U_P->tipo_moneda == 'MXN' && ($DatosEC->tipo_moneda == 'USD' || $DatosEC->tipo_moneda == 'CAD') ){
              $TotalAbonosUP[$DatosEC->tipo_moneda]+= floatval($A_U_P->cantidad_pago/$DatosEC->tipo_cambio);
            }else if($A_U_P->tipo_moneda == $DatosEC->tipo_moneda){
              $TotalAbonosUP[$DatosEC->tipo_moneda]+= floatval($A_U_P->cantidad_pago);
            }
          }
          $TotalAbonosUP[$DatosEC->tipo_moneda] = round($TotalAbonosUP[$DatosEC->tipo_moneda],2);
        }



        $ArregloPagares[$EDC]['SumaAbonos']  = $TotalAbonosUP;

        $NombresProveedores[$DatosEC->idproveedores] = $DatosEC->nombre.' '.$DatosEC->apellidos;
      }

      ksort($ArregloPagares);

      DB::commit();

      //return $ArregloPagares;

      return view('admin.pagares.index',compact('ArregloPagares',
      'FechasPorVencer','FechasVencidas','UnidadesPorVencer','UnidadesVencidas',
      'TotalPagaresVencidos','TotalPagaresPorVencer','NombresProveedores',
      'DineroVenc','DineroPorVenc'
    ));
  } catch (\Exception $e) {
    DB::rollback();
    return $e->getMessage();
    return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
  }
}

public function Pagares_Semana(){
  DB::beginTransaction();
  try {
    $Hoy = \Carbon\Carbon::now()->format('Y-m-d');
    $Dentro_una_Semana = \Carbon\Carbon::now()->addWeek(1)->format('Y-m-d');


    $PagaresPorVencer = documentos_pagar::
    select('documentos_pagar.num_pagare','documentos_pagar.monto','documentos_pagar.fecha_vencimiento',
    'documentos_pagar.tipo','documentos_pagar.archivo_original','documentos_pagar.comentarios',
    'documentos_pagar.idestado_cuenta','estado_cuenta_proveedores.datos_vin','estado_cuenta_proveedores.tipo_moneda','estado_cuenta_proveedores.monto_precio',
    'proveedores.idproveedores','proveedores.nombre','proveedores.apellidos','proveedores.col2')
    ->leftJoin('estado_cuenta_proveedores', 'documentos_pagar.idestado_cuenta', '=', 'estado_cuenta_proveedores.idestado_cuenta_proveedores')
    ->leftJoin('proveedores', 'estado_cuenta_proveedores.idcontacto', '=', 'proveedores.idproveedores')
    ->where('documentos_pagar.visible', 'SI')->where('documentos_pagar.estatus', 'Pendiente')->whereBetween('fecha_vencimiento', [$Hoy, $Dentro_una_Semana])
    ->orderBy('documentos_pagar.fecha_vencimiento', 'ASC')->get();

    $NombresProvedoresPV = [];
    foreach ($PagaresPorVencer->groupBy('idproveedores') as $key => $p) {
      $NombresProvedoresPV[$key] = $p->first()->nombre.' '.$p->first()->apellidos;
    }

    $DolaresPVenc = number_format($PagaresPorVencer->where('tipo_moneda', 'USD')->sum('monto'));
    $DolaresCPVenc = number_format($PagaresPorVencer->where('tipo_moneda', 'CAD')->sum('monto'));
    $PesosPVenc = number_format($PagaresPorVencer->where('tipo_moneda', 'MXN')->sum('monto'));

    $PagaresPorVencer = $PagaresPorVencer->groupBy('idestado_cuenta');

    $FechasPorVencer = documentos_pagar::select(DB::raw('MAX(fecha_vencimiento) as Maxima'),DB::raw('MIN(fecha_vencimiento) as Minima'))
    ->where('visible', 'SI')->where('estatus', 'Pendiente')->whereBetween('fecha_vencimiento', [$Hoy, $Dentro_una_Semana])
    ->first();


    $TotalPagaresPorVencer  = documentos_pagar::where('visible', 'SI')->where('estatus', 'Pendiente')
    ->whereBetween('fecha_vencimiento', [$Hoy, $Dentro_una_Semana])->count();

    //return $PagaresPorVencer;
    return view('admin.pagares.week',compact('PagaresPorVencer','NombresProvedoresPV',
    'FechasPorVencer','TotalPagaresPorVencer','DolaresPVenc','DolaresCPVenc','PesosPVenc'
  ));
  //-------------------------------------------------------------
} catch (\Exception $e) {
  DB::rollback();
  return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
}
}


public function BuscarEstadoCuenta(){
  DB::beginTransaction();
  try {
    $EstadoCuenta = estado_cuenta_proveedores::where('idestado_cuenta_proveedores',request()->idEC)->first();
    DB::commit();
    return json_encode($EstadoCuenta);
  } catch (\Exception $e) {
    DB::rollback();
    return json_encode($e->getMessage());
  }
}

public function BuscarAbonosUnidadesP(){

  DB::beginTransaction();
  try {
    $Abonos = abonos_unidades_proveedores::where('idestado_cuenta',request()->id)->where('visible', 'SI')->get();
    DB::commit();
    return $Abonos;
  } catch (\Exception $e) {
    DB::rollback();
    return json_encode($e->getMessage());
  }
}

public function ContarPagares(){

  DB::beginTransaction();
  try {
    $Hoy = \Carbon\Carbon::now()->format('Y-m-d');
    $Dentro_una_Semana = \Carbon\Carbon::now()->addWeek(1)->format('Y-m-d');

    $PagaresPorVencer = documentos_pagar::select('num_pagare','monto','fecha_vencimiento','tipo','archivo_original','comentarios','idestado_cuenta')
    ->where('visible', 'SI')->where('estatus', 'Pendiente')
    ->whereBetween('fecha_vencimiento', [$Hoy, $Dentro_una_Semana])->count();

    $PagaresVencidos  = documentos_pagar::select('num_pagare','monto','fecha_vencimiento','tipo','archivo_original','comentarios','idestado_cuenta')
    ->where('visible', 'SI')->where('estatus', 'Pendiente')->where('fecha_vencimiento', '<',$Hoy)->count();

    DB::commit();
    return ['Proximos' => $PagaresPorVencer , 'Vencidos' => $PagaresVencidos ];

  } catch (\Exception $e) {
    DB::rollback();
    return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
  }
}


}
