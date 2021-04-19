<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use Illuminate\Support\Facades\Validator;
use App\Models\abonos_unidades_proveedores;
use App\Models\abonos_pagares_proveedores;
use App\Models\estado_cuenta_proveedores;
use App\Models\catalogo_comprobantes;
use App\Models\catalogo_metodos_pago;
use App\Models\catalogo_tesorerias;
use App\Models\recibos_proveedores;
use App\Models\documentos_cobrar;
use App\Models\documentos_pagar;
use App\Models\abonos_unidades;
use App\Models\bancos_emisores;
use App\Models\abonos_pagares;
use App\Models\estado_cuenta;
use App\Models\usuarios;
use App\Models\recibos;
class TransferController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function show($id){
    $banks_emisor = bancos_emisores::get();
    $treasuries_catalog = catalogo_tesorerias::get();
    $types_payment = catalogo_metodos_pago::get();
    $type_tickets = catalogo_comprobantes::get();
    $saldo = estado_cuenta_proveedores::getSaldo($id);
    return view('admin.transfer.show', compact('banks_emisor', 'treasuries_catalog', 'types_payment', 'type_tickets','saldo','id'));
  }
  public function store(Request $request){
    // return $request;
    // return $request;
    $validator = Validator::make($request->all(), [
      'quantity' => 'required|numeric|min:1',
      // 'price' => 'required|min:0',
    ]);
    if ($validator->fails()) {
      // return dd($validator);
      return back()->with('error', $validator);
      // return redirect('product/create')
      //             ->withErrors($validator)
      //             ->withInput();
    }
    // return dd($validator);
    $user_maker = usuarios::get()->where('idempleados', \Auth::user()->idempleados)->where('rol', 17)->last()->idusuario;
    $asesor1 = 'N/A';
    $enlace1 = 'N/A';
    $asesor2 = 'N/A';
    $enlace2 = 'N/A';
    $coach = 'N/A';
    $total_pesos = $this->changeToMexicanPeso($request->quantity,$request->tipo_moneda);
    $state_account_provider = estado_cuenta_proveedores::getStateAccountPendient($request->provider,$total_pesos);
    $state_of_devolution = estado_cuenta_proveedores::stateOfDevolution($request->provider,$total_pesos);
    $account_state_sub = estado_cuenta::where('idcontacto', $request->institution_receptor)->where('visible', 'SI')->where('efecto_movimiento', 'resta')->sum('monto_precio');
    $account_state_add = estado_cuenta::where('idcontacto', $request->institution_receptor)->where('visible', 'SI')->where('efecto_movimiento', 'suma')->sum('monto_precio');
    $client_saldo = $account_state_add-$account_state_sub;
    $today = Carbon::now()->format('Y-m-d_H:i:s');
    $now = Carbon::now()->format('Y-m-d H:i:s');
    DB::beginTransaction();
    try {
      $file = $request->file('evidence');
      $nombre = $file->getClientOriginalName();
      $extension = pathinfo($nombre, PATHINFO_EXTENSION);
      $nombre = 'C_'.$request->institution_receptor.'_'.$today.'_Usr_'.$user_maker;
      $file_route = storage_path('app').'/evidences/'.$nombre.'.'.$extension;
      Storage::disk('local')->put('/evidences/'.$nombre.'.'.$extension,  \File::get($file));
      if($request->type_movement=="cargo"){
        $cargo=$total_pesos;
        $abono="";
      }else{
        $cargo="";
        $abono=$total_pesos;
      }
      $state_account = estado_cuenta::createEstadoCuenta($state_account_provider['concepto'], 'N/A', $request->type_movement,
      $request->efect, $request->date, 6, $request->earnings_hid, $request->new_earnings_hid, $request->quantity, '1/1',
      $request->quantity, $request->tipo_moneda, $request->type_change_hid, $request->quantity, $cargo, $abono, $request->bank_emisor,
      $request->agent_receptor.'.'.$request->treasury_catalog, $request->institution_receptor.'.'.$request->agent_nomenclatura,
      $request->agent_receptor.'.'.$request->agent_nomenclatura, $request->type_ticket, $request->reference, $state_account_provider['datos_marca'],
      $state_account_provider['datos_version'], $state_account_provider['datos_color'], $state_account_provider['datos_modelo'],
      $state_account_provider['datos_vin'], $state_account_provider['datos_precio'], $state_account_provider['datos_estatus'], $asesor1, $enlace1,
      $asesor2, $enlace2, $coach, $file_route, $request->comments, $request->search_provider_client, 'N/A', 'SI', 'N/A', 0, '0001-01-01 00:00:00', $user_maker, $request->date_created, $now);
      if ($request->type_ticket==='Recibo Automático') {
        $automatic_ticket = recibos::createRecibos($request->date, $total_pesos, $request->bank_emisor, $request->treasury_catalog,
        $request->institution_receptor.'.'.$request->agent_nomenclatura, $request->agent_receptor.'.'.$request->agent_nomenclatura,
        $state_account_provider['concepto'], $request->type_payment, $request->reference, $request->comments, $state_account->id, null,
        $request->search_provider_client, $user_maker, null, $now, $request->tipo_moneda, $request->type_change_hid, $total_pesos);
      }
      $quantity_abono = $request->search_provider_client;
      $quantity_abono = $total_pesos;
      while($quantity_abono>0) {
        $no_abonos = estado_cuenta::where('idcontacto', $request->search_provider_client)->where('visible', 'SI')->where('datos_estatus','Pendiente')->count();
        // return $no_abonos;
        if ($no_abonos==0) { $quantity_abono = 0;
        }else {
          $state_account_original = estado_cuenta::where('idcontacto', $request->search_provider_client)
          ->where('visible', 'SI')
          ->where('datos_estatus','Pendiente')
          ->orderBy('fecha_movimiento','ASC')
          ->get(['idestado_cuenta','datos_precio','fecha_movimiento'])
          ->first();
          $unity_abonos = abonos_unidades::where('idestado_cuenta', $state_account_original->idestado_cuenta)->where('visible', 'SI')->sum('cantidad_pago');
          if ($unity_abonos==0) {
            if (!is_numeric($state_account_original->datos_precio)) { $state_account_original->datos_precio = 0; }
            $quantity_unity_pendient=$state_account_original->datos_precio;
          }else {
            if (!is_numeric($state_account_original->datos_precio)) { $state_account_original->datos_precio = 0; }
            $quantity_unity_pendient=$state_account_original->datos_precio - $unity_abonos;
          }
          if($quantity_abono<=$quantity_unity_pendient){
            $monto_abonar=$quantity_abono;
            $restante=$quantity_unity_pendient-$monto_abonar;
            $quantity_abono=0;
          }else{
            $monto_abonar=$quantity_unity_pendient;
            $restante=0;
            $quantity_abono=$quantity_abono-$monto_abonar;
          }
          $unit_abono = abonos_unidades::createAbonosUnidades($state_account_provider['concepto'], $quantity_unity_pendient, $monto_abonar, $restante, '',
          $total_pesos, $request->bank_emisor, $request->treasury_catalog, $request->institution_receptor.'.'.$request->agent_nomenclatura,
          $request->agent_receptor.'.'.$request->agent_nomenclatura, $request->type_ticket, $request->reference, $request->type_payment, $request->date, $state_account_provider['datos_marca'],
          $state_account_provider['datos_version'], $state_account_provider['datos_color'], $state_account_provider['datos_modelo'], $state_account_provider['datos_precio'],
          $state_account_provider['datos_vin'], $file_route, $request->comments, $state_account_original->idestado_cuenta, $user_maker, $request->date_created,
          $now, 'SI', $state_account->idestado_cuenta, $request->tipo_moneda, $request->type_change_hid,$total_pesos);
          $acount_updated = estado_cuenta::updateStatusAsPayed($state_account_original->idestado_cuenta);
          $cantidad_abono_pagare=$monto_abonar;
          // $cantidad_abono_pagare=80001;// <--- Borrar, es temporal para pruebas
          while ($cantidad_abono_pagare>0) {
            // $state_account_original->idestado_cuenta = 35604; //<--- Borrar esto solo es por prueba xD
            $documents_to_pay_count = documentos_cobrar::where('idestado_cuenta', $state_account_original->idestado_cuenta)->where('visible', 'SI')->where('estatus', 'Pendiente')->count();
            if ($documents_to_pay_count==0) {
              $cantidad_abono_pagare=0;
            }else {
              $document_to_pay = documentos_cobrar::where('idestado_cuenta', $state_account_original->idestado_cuenta)->where('visible', 'SI')->where('estatus', 'Pendiente')->get(['iddocumentos_cobrar', 'monto', 'estatus'])->first();
              $sum_abonos_pagares = abonos_pagares::where('iddocumentos_cobrar', $document_to_pay->iddocumentos_cobrar)->where('visible', 'SI')->sum('cantidad_pago');
              if ($sum_abonos_pagares==0) {
                $cantidad_pendiente_pagare = $document_to_pay->monto;
              }else {
                $cantidad_pendiente_pagare = $document_to_pay->monto-$sum_abonos_pagares;
              }
              if($cantidad_abono_pagare<=$cantidad_pendiente_pagare){
                $monto_abonar_pagare=$cantidad_abono_pagare;
                $restante_pagare=$cantidad_pendiente_pagare-$monto_abonar_pagare;
                $cantidad_abono_pagare=0;
              }else{
                $monto_abonar_pagare=$cantidad_pendiente_pagare;
                $restante_pagare=0;
                $cantidad_abono_pagare=$cantidad_abono_pagare-$monto_abonar_pagare;
              }
              $abonos_pagares = abonos_pagares::createAbonoPagaresProveedores($cantidad_pendiente_pagare,$monto_abonar_pagare,$restante_pagare,"N/A",
              $total_pesos,$request->bank_emisor, $request->treasury_catalog,$request->institution_receptor.'.'.$request->agent_nomenclatura,
              $request->agent_receptor.'.'.$request->agent_nomenclatura,$request->type_ticket,$request->reference,$request->type_payment,
              $request->date,$file_route,$request->comments,$document_to_pay->iddocumentos_cobrar,$user_maker,$request->date_created,$now,'SI',$state_account->idestado_cuenta,
              $request->tipo_moneda,$request->type_change_hid,$total_pesos);
              documentos_cobrar::updateSetPagadoDocumentoCobrar($document_to_pay->iddocumentos_cobrar);
            }
          }
        }
      }
      $saldo_anterior_proveedor=$request->earnings_hid;
      $saldo_proveedor=$request->new_earnings_hid;
      $state_account_provider_store = estado_cuenta_proveedores::createEstadoCuentaProveedores($state_account_provider['concepto'], 'N/A', $request->type_movement, $request->efect,
      $request->date, $request->type_payment, $saldo_anterior_proveedor, $saldo_proveedor, $total_pesos, null, $total_pesos, $request->tipo_moneda,
      $request->type_change_hid, $request->quantity, $cargo, $abono, $request->bank_emisor, $request->treasury_catalog, $request->institution_receptor.'.'.$request->agent_nomenclatura,
      $request->agent_receptor.'.'.$request->agent_nomenclatura, $request->type_ticket, $request->reference, $state_account_provider['datos_marca'],
      $state_account_provider['datos_version'], $state_account_provider['datos_color'], $state_account_provider['datos_modelo'], $state_account_provider['datos_vin'],
      $state_account_provider['datos_precio'], $state_account_provider['datos_estatus'], $asesor1, $enlace1, $asesor2, $enlace2, $coach, $file_route, $request->comments,
      $request->provider, 'NO', 'SI', null, null, null, $user_maker, $request->date_created, $now, null, null, 'N/A', 'N/A', null, null, null, null, null, null);
      if ($request->type_ticket=='Recibo Automático') {
        $recibos_proveedores_store = recibos_proveedores::createRecibosProveedores($request->date, $total_pesos, $request->bank_emisor, $request->treasury_catalog, $request->institution_receptor.'.'.$request->agent_nomenclatura,
        $request->agent_receptor.'.'.$request->agent_nomenclatura, $state_account_provider['concepto'], $request->type_payment, $request->reference, $request->comments, $state_account_provider_store->idestado_cuenta_proveedores,
        null, $request->provider, $user_maker, null, $now, $request->tipo_moneda, $request->type_change_hid, $total_pesos);
        // return $recibos_proveedores_store;
      }
      $cantidad_abono_compras=$total_pesos;
      while($cantidad_abono_compras>0){
        if($state_of_devolution!=0){
          $state_account_provider_search = estado_cuenta_proveedores::where('idcontacto',$request->provider)->where('visible','SI')->where('datos_estatus','Pendiente')->where('idestado_cuenta_proveedores', $state_account_provider['idestado_cuenta_proveedores'])->get(['idestado_cuenta_proveedores', 'datos_precio', 'col1', 'col2'])->first();
        }else{
          $state_account_provider_search = estado_cuenta_proveedores::where('idcontacto',$request->provider)->where('visible','SI')->where('datos_estatus','Pendiente')->orderBy('fecha_movimiento','ASC')->get(['idestado_cuenta_proveedores', 'datos_precio', 'col1', 'col2'])->first();
        }
        if(empty($state_account_provider_search)){//No hay unidades pendientes, no se inserta nada mas
          $cantidad_abono_compras=0;
        }else{//Hay unidades Pendientes
          $estado_cuenta_proveedores_update = estado_cuenta_proveedores::updateStateAccountProviders($request->provider, $state_account_provider_store->idestado_cuenta_proveedores,$state_account_provider_search->col1,$state_account_provider_search->col2);
          $abonos_unidades_proveedores_sum = abonos_unidades_proveedores::where('idestado_cuenta', $state_account_provider_search->idestado_cuenta_proveedores)->where('visible', 'SI')->sum('cantidad_pago');
          if($abonos_unidades_proveedores_sum==0){//No se ha abonado nada a la unidad
            $cantidad_pendiente_unidad_compras=$state_account_provider_search->datos_precio;
          }else{
            $cantidad_pendiente_unidad_compras=$state_account_provider_search->datos_precio-$abonos_unidades_proveedores_sum;
          }
          if($cantidad_abono_compras<=$cantidad_pendiente_unidad_compras){
            $monto_abonar_compras=$cantidad_abono_compras;
            $restante_compras=$cantidad_pendiente_unidad_compras-$monto_abonar_compras;
            $cantidad_abono_compras=0;
          }else{
            $monto_abonar_compras=$cantidad_pendiente_unidad_compras;
            $restante_compras=0;
            $cantidad_abono_compras=$cantidad_abono_compras-$monto_abonar_compras;
          }
          $abonos_unidades_proveedores_store = abonos_unidades_proveedores::createAbonosUnidadesProveedores($state_account_provider['concepto'], $cantidad_pendiente_unidad_compras, $monto_abonar_compras,
          $restante_compras, '', $total_pesos, $request->bank_emisor, $request->treasury_catalog, $request->institution_receptor.'.'.$request->agent_nomenclatura,
          $request->agent_receptor.'.'.$request->agent_nomenclatura, $request->type_ticket, $request->reference, $request->type_payment, $request->date, $state_account_provider['datos_marca'],
          $state_account_provider['datos_version'], $state_account_provider['datos_color'], $state_account_provider['datos_modelo'], null, null, $file_route, $request->comments,
          $state_account_provider_search->idestado_cuenta_proveedores, $user_maker, $request->date, $now, 'SI', $state_account_provider_store->idestado_cuenta_proveedores,
          $request->tipo_moneda, $request->type_change_hid, $total_pesos);
          if($restante_compras==0){
            estado_cuenta_proveedores::updatePayedStateAccountProviders($state_account_provider_search->idestado_cuenta_proveedores);
          }
          //**************************************************************************************************************************************************************************************************************************************************************
          $cantidad_abono_pagare_compras=$monto_abonar_compras;
          // return $cantidad_abono_pagare_compras;
          while($cantidad_abono_pagare_compras>0){
            $documentos_pagar_get = documentos_pagar::where('idestado_cuenta', $state_account_provider_search->idestado_cuenta_proveedores)->where('visible', 'SI')->where('estatus', 'Pendiente')->orderBy('fecha_vencimiento','ASC')->get(['iddocumentos_pagar', 'monto'])->first();
            // return $documentos_pagar_get;
            // if(1!=1){// <-- Borrar esta parte
            if(empty($documentos_pagar_get)){// Descomentar esta parte
              $cantidad_abono_pagare_compras=0;
              // return 'xD';
            }else{
              // En su lugar $documentos_pagar_get->iddocumentos_pagar
              // $idPagarePendiente_compras=$filazz[iddocumentos_pagar];
              // $precio_pagare_compras=$filazz[monto];
              try { $abonos_pagares_proveedores_sum = abonos_pagares_proveedores::where('visible', 'SI')->where('iddocumentos_pagar', $documentos_pagar_get->iddocumentos_pagar)->sum('cantidad_pago');
              } catch (\Exception $e) { $abonos_pagares_proveedores_sum = 0; }
              // $abonos_pagares_proveedores_sum = abonos_pagares_proveedores::where('visible', 'SI')->where('iddocumentos_pagar', $documentos_pagar_get->iddocumentos_pagar)->sum('cantidad_pago');
              if($abonos_pagares_proveedores_sum==0){//No se han hecho abonos al pagare
                $cantidad_pendiente_pagare_compras=$precio_pagare_compras;
              }else{
                $cantidad_pendiente_pagare_compras=$documentos_pagar_get->monto_total-$abonos_pagares_proveedores_sum;
              }
              if($cantidad_abono_pagare_compras<=$cantidad_pendiente_pagare_compras){
                $monto_abonar_pagare_compras=$cantidad_abono_pagare_compras;
                $restante_pagare_compras=$cantidad_pendiente_pagare_compras-$monto_abonar_pagare_compras;
                $cantidad_abono_pagare_compras=0;
              }else{
                $monto_abonar_pagare_compras=$cantidad_pendiente_pagare_compras;
                $restante_pagare_compras=0;
                $cantidad_abono_pagare_compras=$cantidad_abono_pagare_compras-$monto_abonar_pagare_compras;
              }
              $ins_abono_pagare_compras = abonos_pagares_proveedores::createAbonoPagaresProveedores($cantidad_pendiente_pagare_compras,$monto_abonar_pagare_compras,$restante_pagare_compras,
              "N/A",$total_pesos,$request->bank_emisor, $request->treasury_catalog,$request->institution_receptor.'.'.$request->agent_nomenclatura,
              $request->agent_receptor.'.'.$request->agent_nomenclatura,$request->type_ticket,$request->reference,$request->type_payment,$request->date,$file_route,
              $request->comments,$documentos_pagar_get->iddocumentos_pagar,$user_maker,$request->date_created,$now,'SI',$state_account_provider_store->idestado_cuenta_proveedores,
              $request->tipo_moneda,$request->type_change_hid,$total_pesos);
              return documentos_pagar::updatePayedDocumentosPagat($documentos_pagar_get->iddocumentos_pagar,$state_account_provider_store->idestado_cuenta_proveedores);
              // $sqlcc="UPDATE documentos_pagar SET estatus='Pagado' WHERE iddocumentos_pagar='$idPagarePendiente_compras' AND idestado_cuenta='$idUnidadPendiente_compras' AND visible='SI';";
            }
          }//end while; abonos a pagares
        }
      }//end while; $cantidad_abono>0; Ciclo de abono a unidades
      DB::commit();
      return redirect()->route('account_status.showAccountStatus',$request->provider)->with('success', 'Traspaso creado correctamente');
      return $automatic_ticket;
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }
    return $request;
  }
  public static function getNumberToLetters($number,$type_change){
    $formatter = new NumeroALetras();
    return ['info'=>$formatter->toInvoice($number, 2, $type_change)];
  }
  public function changeToMexicanPeso($quantity,$type_change){
    if ($type_change=='MXN') {
      return $quantity;
    }elseif ($type_change=='USD') {
      return $quantity*19.50;
    }elseif ($type_change=='CAD') {
      return $quantity*15.20;
    }
  }
  public function validateReference(){
    try {
      $no_estado_cuenta_proveedores = estado_cuenta_proveedores::where('referencia', $request->referencia)->where('idcontacto', $request->idprovedor)->where('visible', 'SI')->count();
      if ($no_estado_cuenta_proveedores==0) { return ['info' => 'ok'];
      }else{ return ['info' => 'no_ok']; }
    } catch (\Exception $e) {
      return ['info' => 'no_ok'];
    }

  }
}
