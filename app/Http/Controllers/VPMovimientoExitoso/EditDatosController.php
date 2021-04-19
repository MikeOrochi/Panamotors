<?php

namespace App\Http\Controllers\VPMovimientoExitoso;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\vista_previa_movimiento_exitoso;
use App\Models\vpme_informacion_clientes;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\vpme_pagares;
use App\Models\contactos;
use App\Models\vpme_clientes;
use App\Models\publicacion_vin_fotos;
use App\Models\vpme_pagos;






class EditDatosController extends Controller {

  public function __construct(){
    $this->middleware('auth');
  }

  public function CambioUnidad(){

    DB::beginTransaction();
    try {

      $idVistaPrevia = request()->idVistaPrevia;
      $tipoUnidad = request()->tipoUnidad;
      $idUnidad = request()->idUnidad;
      $MontoUnidad = request()->MontoConDescuento;
      $usuario_creador = \Request::cookie('usuario_creador');

      if($tipoUnidad == "Unidad"){
        $Unidad = inventario::where('idinventario', $idUnidad)->first();
      }else{
        $Unidad = inventario_trucks::where('idinventario_trucks', $idUnidad)->first();
      }

      $temp_vpme = vista_previa_movimiento_exitoso::where('id', $idVistaPrevia)->get()->first();
      $anticipo = 0;
      if(request('tipo_venta') == "Directa a Crédito"){
          $anticipo = request('Anticipo');
      }
      $saldo = $MontoUnidad - $anticipo;
      vista_previa_movimiento_exitoso::where('id', $idVistaPrevia)->update([
        'idinventario' => ($tipoUnidad == "Unidad" ? $Unidad->idinventario : $Unidad->idinventario_trucks),
        'vin_numero_serie' => $Unidad->vin_numero_serie,
        'tipo_unidad' => $tipoUnidad,
        'usuario_creador' => $usuario_creador,
        'descuento' => 0,
        'monto_unidad' => $MontoUnidad,
        'saldo' => $saldo,
        'anticipo' => $anticipo,
        'procedencia' => $Unidad->procedencia,
      ]);

      $NumPagares = 0;
      if($temp_vpme->tipo_venta == "Directa a Crédito"){
          //Eliminar pagares en caso de existir
          $vpme_pagares = vpme_pagares::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->where('visible','SI')->get();
          $NumPagares = $vpme_pagares->count();
          $calculate_monto_pagare = $saldo/$NumPagares;
          $calculate_monto_pagare = round($calculate_monto_pagare,2);
          if ($NumPagares > 1) {
              $sumatoria_pagares = 0;
              $last_pagare = 0;
              foreach ($vpme_pagares as $key => $value) {
                  if($key == $NumPagares-1){
                      $last_pagare = $saldo - $sumatoria_pagares;
                      $value->monto = round($last_pagare,2);
                      $value->save();
                  }else {
                      $value->monto = $calculate_monto_pagare;
                      $value->save();
                      $sumatoria_pagares += $calculate_monto_pagare;
                  }
              }
          }else {
              if($NumPagares == 1){
                  vpme_pagares::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->where('visible','SI')->update([
                      'monto' => $saldo,
                  ]);
              }
          }
      }


      if($temp_vpme->tipo_venta == "Directa de Contado"){
          $vpme_pagos = vpme_pagos::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->where('visible','SI')->get();
          $NumPagos = $vpme_pagos->count();
          $calculate_monto_pago = $saldo/$NumPagos;
          $calculate_monto_pago = round($calculate_monto_pago,2);
          if ($NumPagos > 1) {
              $sumatoria_pagos = 0;
              $last_pago = 0;
              foreach ($vpme_pagos as $key => $value) {
                  if($key == $NumPagos-1){
                      $last_pago = $saldo - $sumatoria_pagos;
                      $value->monto = round($last_pago,2);
                      $value->save();
                  }else {
                      $value->monto = $calculate_monto_pago;
                      $value->save();
                      $sumatoria_pagos += $calculate_monto_pago;
                  }
              }
          }else {
              if($NumPagos == 1){
                  vpme_pagos::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->where('visible','SI')->update([
                      'monto' => $saldo,
                  ]);
              }
          }
      }



      DB::commit();

      if ($NumPagares > 0) {
        return redirect()->route('vpMovimientoExitoso.VistaPagares',$idVistaPrevia)->with('success','Datos actualizados pero requiere volver a generar los pagares');
      }
      return back()->with('success','Datos actualizados');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error','Error, intente de nuevo')->withInput();
    }
  }


  public function cambioTipoVenta(){
      DB::beginTransaction();
      try {

        $idVistaPrevia = request()->idVistaPrevia;
        $tipo_venta = request()->tipoVenta;

        $temp_vpme = vista_previa_movimiento_exitoso::where('id', $idVistaPrevia)->get()->first();

        if(request('tipo_venta') == "Directa a Crédito" && $temp_vpme->tipo_venta != "Directa a Crédito"){
            $vpme_pagos = vpme_pagos::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->get();
            if(!$vpme_pagos->isEmpty()){
                vpme_pagos::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->update([
                    'visible' => 'NO'
                ]);
            }
            $num_pagare = '1/1';
            $monto = $saldo;
            $fecha_vencimiento = ((new \DateTime(now()))->modify('+1 month'));
            $tipo = "Físico";
            $estatus = 'Pendiente';
            $archivo_original = "N/A";
            $comentarios = "Pagare #1";
            $id_vista_previa_movimiento_exitoso = $temp_vpme->id;
            $fecha_guardado = new \DateTime(now());
            $visible = 'SI';

            vpme_pagares::createVPMEPagares( $id_vista_previa_movimiento_exitoso, $num_pagare, $monto, $fecha_vencimiento,
            $estatus, $tipo, $archivo_original, $comentarios, $fecha_guardado, $visible );

        }


        if(request('tipo_venta') == "Directa de Contado" && $temp_vpme->tipo_venta != "Directa de Contado"){
            //Eliminar pagares en caso de existir
            $NumPagares = vpme_pagares::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->count();
            if ($NumPagares > 0) {
                vpme_pagares::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->update([
                    'visible' => 'NO'
                ]);
            }
            //crear pago
            $tipo_comprobante = "Contrato de Compra y Venta";
            $estatus = "Pendiente";
            $archivo_comprobante = "N/A";////archivo
            $fecha_pago = (new \DateTime(now()))->format('Y-m-d');
            $comentarios = "NA";

            vpme_pagos::createVPMEPagos( $temp_vpme->id, $MontoUnidad, 0, 'Por definir', 'Contrato de Compra y Venta',
            $estatus, $archivo_comprobante, $fecha_pago, $comentarios, 'SI' );
        }



        DB::commit();

        if ($NumPagares > 0) {
          return redirect()->route('vpMovimientoExitoso.VistaPagares',$idVistaPrevia)->with('success','Datos actualizados pero requiere volver a generar los pagares');
        }
        return back()->with('success','Datos actualizados');
      } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error','Error, intente de nuevo')->withInput();
      }





  }

  public function CambioDatos(){

    DB::beginTransaction();
    try {

      $idVistaPrevia = request()->idVistaPrevia;

      $Fecha = request()->Fecha;
      $usuario_creador = \Request::cookie('usuario_creador');
      $Comentarios = request()->comentarios;

      if (empty(request()->Anticipo)) {
        vista_previa_movimiento_exitoso::where('id', $idVistaPrevia)->update([
          'usuario_creador' => $usuario_creador,
          'comentarios_venta' => $Comentarios
        ]);
      }else{
        $Anticipo = request()->Anticipo;
        $MetodoPago = request()->m_pago_anticipo;
        $Comprobante = request()->comprobante_anticipo;

        vista_previa_movimiento_exitoso::where('id', $idVistaPrevia)->update([
          'anticipo' => $Anticipo,
          'usuario_creador' => $usuario_creador,
          'comentarios_venta' => $Comentarios,
          'metodo_pago_anticipo' => $MetodoPago,
          'tipo_comprobante_anticipo' => $Comprobante
        ]);
      }

      DB::commit();
      return back()->with('success','Datos actualizados');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error','Error, intente de nuevo')->withInput();
    }
  }


  public function CambioContacto(){

    DB::beginTransaction();
    try {

      $idVistaPrevia = request()->idVistaPrevia;
      $usuario_creador = \Request::cookie('usuario_creador');

      $Cliente = request()->Cliente;
      vista_previa_movimiento_exitoso::where('id', $idVistaPrevia)->update([
        'idcontacto' => $Cliente,
        'usuario_creador' => $usuario_creador,
      ]);

      DB::commit();
      return back()->with('success','Datos actualizados');
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
      return back()->with('error','Error, intente de nuevo')->withInput();
    }

  }

  public function CambioNuevoContacto(){

    DB::beginTransaction();
    try {

      $idVistaPrevia = request()->idVistaPrevia;
      $usuario_creador = \Request::cookie('usuario_creador');
      $Cliente = request()->Cliente;

      $VistaPrevia = vista_previa_movimiento_exitoso::where('id', $idVistaPrevia)->first();
      if ($VistaPrevia->idcontacto == 0) {
        $Clientes = vpme_clientes::where('id_vista_previa_movimiento_exitoso', $idVistaPrevia)->first();
        $Clientes->nombre = request()->nombre;
        $Clientes->apellidos = request()->apellidos;
        $Clientes->telefono = request()->telefono;
        $Clientes->estado = request()->estado;
        $Clientes->municipio = request()->municipio;
        $Clientes->cp = request()->cp;
        $Clientes->colonia = request()->colonia;
        $Clientes->direccion = request()->calle;
        $Clientes->save();
      }else{
        vpme_clientes::createVPMEClientes( $idVistaPrevia, request()->nombre, request()->apellidos,
        request()->telefono, request()->estado, request()->municipio, request()->cp, request()->colonia,
        request()->calle );

        $VistaPrevia->idcontacto = 0;
        $VistaPrevia->save();
      }


      DB::commit();
      return back()->with('success','Datos actualizados');
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
      return back()->with('error','Error, intente de nuevo')->withInput();
    }
  }


  public function editMovement($idVP){

    try {

      $idVP = Crypt::decrypt($idVP);

      $vpme = vista_previa_movimiento_exitoso::where('id',$idVP)->get()->first();
      $inventario = "";
      if($vpme->tipo_unidad == "Unidad"){
        $inventario = inventario::where('vin_numero_serie',$vpme->vin_numero_serie)->first();
        $idinventario = $inventario->idinventario;
      }
      if($vpme->tipo_unidad == "Trucks"){
        $inventario = inventario_trucks::where('vin_numero_serie',$vpme->vin_numero_serie)->get()->first();
        $idinventario = $inventario->idinventario_trucks;
      }
      $publicacion_vin_fotos = publicacion_vin_fotos::where('vin',$vpme->vin_numero_serie)->where('tipo','Principal')->get();
      $img = "";
      if(!$publicacion_vin_fotos->isEmpty()){
        // $img = "https://www.panamotorscenter.com/Des/CCP/Sesion_VIN/CLBP4140_1382/Principal/USR100725_EM213_2020_11_13_16_23_33principal.jpg";
        $x = $publicacion_vin_fotos->first()->ruta_foto;
        $img_route = str_replace(array('../..'),array(''),$x );;
        $img = "https://www.panamotorscenter.com/Des/CCP".$img_route;
      }

      $NumPagares = vpme_pagares::where('id_vista_previa_movimiento_exitoso',$idVP)->count();


      if($vpme->idcontacto == 0){
        $Contacto = vpme_clientes::where('id_vista_previa_movimiento_exitoso', $idVP)->first();
        $ContactoNuevo = true;
      }else{
        $Contacto = contactos::where('idcontacto', $vpme->idcontacto)->first();
        $ContactoNuevo = false;
      }

      return view('VPMovimientoExitoso.edit',compact('inventario','vpme','img','NumPagares','Contacto','ContactoNuevo'));
    } catch (\Exception $e) {
      return $e->getMessage();
      return back()->with('error','Error, intente de nuevo')->withInput();
    }

  }

}
