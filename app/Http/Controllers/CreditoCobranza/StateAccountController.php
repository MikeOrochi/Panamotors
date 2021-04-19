<?php

namespace App\Http\Controllers\CreditoCobranza;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\estado_cuenta_bitacora_cambio_estatus;
use App\Models\catalogo_documentos_contacto;
use App\Models\documentos_contacto_cambios;
use App\Models\contactos_documentos;
use App\Models\documentos_cobrar;
use App\Models\contactos_cambios;
use App\Models\abonos_unidades;
use App\Models\clientes_tipos;
use App\Models\abonos_pagares;
use App\Models\credito_tipos;
use App\Models\estado_cuenta;
use App\Models\contactos;
use App\Models\asesores;
use Carbon\Carbon;
class StateAccountController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function show($idcontacto){
    $usuario_creador = \Request::cookie('usuario_creador');
    $idcontacto = Crypt::decrypt($idcontacto);
    $contacto = contactos::where('idcontacto', $idcontacto)->get(['idcontacto','nombre','apellidos'])->first();
    $estados_cuenta = estado_cuenta::where('idcontacto', $idcontacto)->where('visible', 'SI')
    ->whereIn('concepto', ['Venta Directa','Venta Permuta','Otros Cargos-C'])->get(['idcontacto','concepto','monto_precio']);
    foreach ($estados_cuenta as $estado_cuenta) {
      $suma_abonos_unidades = abonos_unidades::where('idestado_cuenta', $estado_cuenta->idestado_cuenta)->where('visible', 'SI')->sum('cantidad_pago');
      if ($estado_cuenta->monto_precio==$suma_abonos_unidades) {
        DB::beginTransaction();
        try {
          $estado_cuenta->datos_estatus = 'Pagada';
          $estado_cuenta->saveOrFail();
          estado_cuenta_bitacora_cambio_estatus::createEstadoCuentaBitacoraCambioEstatus($estado_cuenta->idestado_cuenta,$usuario_creador,\Carbon\Carbon::now());
          DB::commit();
        } catch (\Exception $e) { DB::rollback(); }
      }
    }
    $estados_cuenta = estado_cuenta::where('idcontacto', $contacto->idcontacto)->where('visible', 'SI')
    ->get(['idestado_cuenta','concepto','tipo_movimiento','monto_precio','fecha_movimiento','metodo_pago']);
    // return $estados_cuenta;
    // return \Auth::user();
    return view('CreditoCobranza.state_account.index',compact(
      'contacto','estados_cuenta'
    ));
  }
}
