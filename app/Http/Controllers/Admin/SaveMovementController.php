<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\documentos_pagar_abonos_unidades_proveedores;
use App\Models\abonos_unidades_proveedores;
use App\Models\abonos_pagares_proveedores;
use App\Models\comprobantes_transferencia;
use App\Models\estado_cuenta_proveedores;
use App\Models\beneficiarios_proveedores;
use App\Models\recibos_proveedores;
use App\Models\documentos_cobrar;
use App\Models\documentos_pagar;
use App\Models\abonos_unidades;
use App\Models\abonos_pagares;
use App\Models\estado_cuenta;
use App\Models\saldo_compras;
use App\Models\proveedores;
use App\Models\inventario;
use App\Models\contactos;
use App\Models\recibos;

class SaveMovementController extends Controller{

  public function __construct(){
    $this->middleware('auth');
  }


  public function store(){


    DB::beginTransaction();
    DB::connection()->enableQueryLog();
    try {
      $id = request()->contacto_original;
      $concepto = request()->muestra;//Abono";
      $tipo_movimiento = request()->tipo_general;
      // dd(request()->tipo_general);
      if ($concepto == 'Otros Cargos' && $tipo_movimiento == 'cargo') {
        $concepto = 'Otros Cargos-C';
      } else if ($concepto == 'Otros Cargos' && $tipo_movimiento == 'abono') {
        $concepto = 'Otros Cargos-A';
      }
      // if (strpos($concepto, 'Otros Cargos')===0) {
      //   dd($concepto);
      // } else {
      //   dd(strpos($concepto, '2Otros Cargos'));
      // }
      // $posicion_coincidencia = strpos($concepto, 'Otros Cargos');
      // return json_encode($posicion_coincidencia);
      $efecto_movimiento = request()->efecto;
      $fecha_movimiento = request()->fechapago1;
      $metodo_pago = request()->m_pago;
      $tipo_moneda = request()->tipo_moneda1;
      $tipo_cambio = request()->tipo_cambio1;
      $saldo_anterior = request()->saldo_prov;
      $monto_abono = request()->monto_abono;
      $saldo = request()->saldo_nuevo;
      $monto_precio = request()->monto_entrada;
      $tipo_cambio = request()->tipo_cambio2;
      $saldo_anterior_pagare = request()->saldo_general;
      $monto_abono_pagare = request()->monto_general;
      $saldo_pagare=$saldo-$monto_precio;

      $marca = request()->marca_venta;
      $modelo = request()->modelo_venta;
      $color = request()->color_venta;
      $version = request()->version_venta;
      $vin = request()->vin_venta;
      $precio_u = request()->monto_abono_venta;

      $emisora_institucion = request()->emisor;
      $emisora_agente = request()->agente_emisor;
      $depositante = request()->depositante;
      $receptora_institucion = request()->receptor;

      $receptora_agente = request()->agente_receptor;
      $tipo_comprobante = request()->comprobante;
      $referencia = request()->n_referencia;

      $ValidarReferencia = abonos_pagares_proveedores::where('referencia', $referencia)->where('visible', 'SI')->where('referencia', '<>','S/N')->get();
      if(sizeof($ValidarReferencia) != 0){
        return back()->with('error', 'Error la referencia acaba de ser tomada intente con otra')->withInput();
      }

      $actividad = request()->no_pagare;

      //echo $actividad;
      $comentarios = request()->descripcion;

      $asesor11 = request()->asesor11;
      $enlace11 = request()->enlace11;
      $asesor22 = request()->asesor22;
      $enlace22 = request()->enlace22;

      $serie_general = request()->serie_general_venta;
      $monto_general = request()->monto_general;
      $fecha_inicio = request()->fecha_inicio;


      if($tipo_moneda == "USD" || $tipo_moneda == "CAD" || $tipo_moneda == "MXN"){
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

        $cliente = request()->contacto_original;
        $movimiento_original = request()->movimiento_general;
        date_default_timezone_set('America/Mexico_City');
        $actual= date("Y_m_d__H_i_s");
        $fecha_actual= date("Y-m-d H:i:s");
        $usuario_creador = \Request::cookie('usuario_creador');
        $estado_unidad="";
        //Copiar Archivo
        $file = request()->file('uploadedfile');
        if ($file == "" || $file == null) {
          $archivo_cargado="#";
        }else{
          $nombre = $file->getClientOriginalName();
          $extension = pathinfo($nombre, PATHINFO_EXTENSION);
          $nombre = "P".$cliente."_".$actual."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
          $archivo_cargado = storage_path('app').'/movements/'.$nombre.'.'.$extension;
          Storage::disk('local')->put('/movements/'.$nombre.'.'.$extension,  \File::get($file));
        }
        // return request();

        if($concepto=="Traspaso"){



          $Estado_Cuenta_Proveedores_A = estado_cuenta_proveedores::where(function ($query) use ($id,$monto_precio){
            $query->where('idcontacto', $id )
            ->where('datos_precio', $monto_precio)
            ->where('datos_estatus', 'Pendiente');
          })->where(function ($query) {
            $query->where('concepto', 'Devolución del VIN' )
            ->orWhere('concepto', 'Devolucion del VIN' );
          })->where(function ($query) {
            $query->where('visible', 'SI' );
          })->orderBy('fecha_movimiento', 'ASC')->limit(1)->get();


          if(sizeof($Estado_Cuenta_Proveedores_A)!=0){

            foreach ($Estado_Cuenta_Proveedores_A as $key => $ECP_A) {
              $concepto_cobranza = $ECP_A->concepto;
              $vin_cobranza = $ECP_A->datos_vin;
              $marca_cobranza = $ECP_A->datos_marca;
              $modelo_cobranza = $ECP_A->datos_modelo;
              $color_cobranza = $ECP_A->datos_color;
              $version_cobranza = $ECP_A->datos_version;
              $precio_cobranza = $ECP_A->datos_precio;
              $id_devolucion = $ECP_A->idestado_cuenta_proveedores;
            }

          }else{
            $concepto_cobranza=$concepto;
            $vin_cobranza="";
            $marca_cobranza="";
            $modelo_cobranza="";
            $color_cobranza="";
            $version_cobranza="";
            $precio_cobranza="";
          }
          $cantidad_abono=$monto_precio;
          $bandera=0;
          if($depositante==""){
            $depositante="N/A";
          }

          $Estado_Cuenta_Proveedores_B = estado_cuenta_proveedores::select(DB::raw("SUM(cargo) - SUM(abono) AS TOTAL "))->where('idcontacto', $id)->first()->TOTAL;

          if($Estado_Cuenta_Proveedores_B != null && $Estado_Cuenta_Proveedores_B != ""){
            if($cantidad_abono > $Estado_Cuenta_Proveedores_B ){
              return back()->with('error', 'No se puede realizar el Traspaso, el saldo disponible a traspasar es '.$Estado_Cuenta_Proveedores_B.' Revisa los datos y vuelve a intentar')->withInput();
            }else{
              while($cantidad_abono > 0){

                if($id_devolucion!=""){
                  $Estado_Cuenta_Proveedores_C = estado_cuenta_proveedores::where('idcontacto', $id)->where('visible', 'SI')->where('datos_estatus', 'Pendiente')->where('idestado_cuenta_proveedores', $id_devolucion)->get();
                }else{
                  $Estado_Cuenta_Proveedores_C = estado_cuenta_proveedores::where('idcontacto', $id)->where('datos_estatus', 'Pendiente')->where('visible', 'SI')->orderBy('fecha_movimiento', 'ASC')->limit(1)->get();
                }

                foreach ($Estado_Cuenta_Proveedores_C as $key => $ECP_C) {
                  $edo_cta_prov = $ECP_C->idestado_cuenta_proveedores;
                  $precio_unidad = $ECP_C->datos_precio;
                  $folio = $ECP_C->col1;
                  $folio_anterior = $ECP_C->col2;
                }

                $Unidades = sizeof($Estado_Cuenta_Proveedores_C);

                if($Unidades==0){//No hay unidades pendientes
                  if($bandera!=1){
                    $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
                    $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio,$serie_general, $monto_general,$tipo_moneda,
                    $tipo_cambio, $monto_general, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
                    $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
                    $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
                    $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
                    $fecha_actual, $col1 = '', $col2 = '', $col3 = $actividad, $col4 = $depositante, $col5 = null, $col6 = null,
                    $col7 = null, $col8 = null, $col9 = null, $col10 = null);
                  }

                  $cantidad_abono=0;
                  $bandera=1;

                  if ($ins_edo_cta){
                    $id_movimiento_estado_cuenta = $ins_edo_cta->idestado_cuenta_proveedores;
                  }

                  //**************************************************************************************************************************************************************************************************************************************************************
                  if($tipo_comprobante=='Recibo Automático'){
                    $result19 = recibos_proveedores::createRecibosProveedores($fecha_movimiento, $monto_precio, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, '6', $folio, $comentarios, $id_movimiento_estado_cuenta, null, $cliente, $usuario_creador, null, $fecha_actual, 'MXN', '1', $monto_general);
                    if ($result19) {
                      $id_rec2=base64_encode($result19->idrecibos_proveedores);
                      //ESE ECHO ESTABA COMENTADO
                      /*
                      echo "<script language='javascript' type='text/javascript'>
                      alert('Movimiento Guardado Exitosamente Apartado');
                      window.open('recibo_pdf.php?idrb=$id_rec2','_blank');
                      document.location.replace('estado_cuenta.php?idc=$c1');
                      </script>";
                      */
                    }
                  }

                  //echo "<br>Sin Unidades: $ins_edo_cta<br>";
                }else{


                  if($bandera!=1){

                    $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
                    $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio,$serie_general, $monto_general,$tipo_moneda,
                    $tipo_cambio, $monto_general, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
                    $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
                    $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
                    $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
                    $fecha_actual, $col1 = $folio, $col2 = $folio_anterior, $col3 = $actividad, $col4 = $depositante, $col5 = null, $col6 = null,
                    $col7 = null, $col8 = null, $col9 = null, $col10 = null);

                    if($ins_edo_cta){
                      $bandera=1;
                      $id_movimiento_estado_cuenta = $ins_edo_cta->idestado_cuenta_proveedores;

                      //**************************************************************************************************************************************************************************************************************************************************************
                      if($tipo_comprobante=='Recibo Automático'){
                        $result19 = recibos_proveedores::createRecibosProveedores($fecha_movimiento, $monto_precio, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, '6', $folio, $comentarios, $id_movimiento_estado_cuenta, null, $cliente, $usuario_creador, null, $fecha_actual, 'MXN', '1', $monto_general);
                        if ($result19) {
                          $id_rec2=base64_encode($result19->idrecibos_proveedores);
                          //Ese echo estaba comentado
                          /*
                          echo "<script language='javascript' type='text/javascript'>
                          alert('Movimiento Guardado Exitosamente Apartado');
                          window.open('recibo_pdf.php?idrb=$id_rec2','_blank');
                          document.location.replace('estado_cuenta.php?idc=$c1');
                          </script>";
                          */

                        }
                      }
                      //**************************************************************************************************************************************************************************************************************************************************************
                    }
                  }//end if; $bandera!=1
                  $Abonos_UP = abonos_unidades_proveedores::select('cantidad_pendiente')->where('idestado_cuenta', $edo_cta_prov)->where('visible', 'SI')->get();
                  if(sizeof($Abonos_UP) == 0)
                  $pendiente_unidad=$precio_unidad;
                  else{
                    foreach ($Abonos_UP as $key => $AUP) {
                      $pendiente_unidad = $AUP->cantidad_pendiente;
                    }
                  }//end else; $num==0
                  // dd($pendiente_unidad);
                  if($cantidad_abono <= $pendiente_unidad){
                    $monto_abonar = $cantidad_abono;
                    $cantidad_abono = 0;
                    $restante = $pendiente_unidad - $monto_abonar;
                  }//end if; $cantidad_abono<=$pendiente_unidad
                  else{
                    $monto_abonar = $pendiente_unidad;
                    $cantidad_abono = $cantidad_abono - $pendiente_unidad;
                    $restante = 0;
                    $bandera = 1;
                  }//end else; $cantidad_abono<=$pendiente_unidad

                  $ins_abono_unidad = abonos_unidades_proveedores::createAbonosUnidadesProveedores( $concepto, $pendiente_unidad,
                  $monto_abonar, $restante, $serie_general, $monto_general, $emisora_institucion, $emisora_agente,
                  $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $metodo_pago, $fecha_movimiento,
                  $marca, $version, $color, $modelo, $precio_u, $vin, $archivo_cargado, $comentarios,
                  $edo_cta_prov, $usuario_creador, $fecha_inicio, $fecha_actual, $visible = 'SI', $id_movimiento_estado_cuenta,
                  $tipo_moneda, $tipo_cambio, $monto_precio);

                  if($ins_abono_unidad){
                    if($restante==0){
                      $result5 = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $edo_cta_prov)->update(['datos_estatus' => 'Pagada']);
                    }//end if; $restante==0
                  }//end if; $ins_abono_unidad==1
                }//end else; $Unidades==0
              }//end while; $cantidad_abono>0
              //**************************************************************************************************************************************************************************************************************************************************************
              $cantidad_abono_pagare_proveedor = $monto_abonar;

              while( $cantidad_abono_pagare_proveedor > 0 ){
                $DocumentosPagar= documentos_pagar::where('idestado_cuenta', $edo_cta_prov)->where('estatus', 'Pendiente')->where('visible', 'SI')->orderBy('fecha_vencimiento', 'ASC')->limit(1)->get();
                if(sizeof($DocumentosPagar)==0){
                  //echo "No hay pagares pendientes";
                  $cantidad_abono_pagare_proveedor = 0;
                }else{
                  foreach ($DocumentosPagar as $key => $DP) {

                    $id_pagare_proveedor = $DP->iddocumentos_pagar;
                    $monto_pagare_proveedor = $DP->monto;

                    $AbonosPaP = abonos_pagares_proveedores::select('cantidad_pendiente')->where('iddocumentos_pagar', $id_pagare_proveedor)->where('visible', 'SI')->orderBy('fecha_pago', 'DESC')->limit(1)->get();

                    if(sizeof($AbonosPaP)==0){
                      $pendiente_pagare_proveedor = $monto_pagare_proveedor;
                    }else{
                      foreach ($AbonosPaP as $key => $APP) {
                        $pendiente_pagare_proveedor = $APP->cantidad_pendiente;
                      }
                    }

                  }

                  if($cantidad_abono_pagare_proveedor <= $pendiente_pagare_proveedor){
                    $monto_abonar_pagare_proveedor   = $cantidad_abono_pagare_proveedor;
                    $restante_pagare_proveedor       = $pendiente_pagare_proveedor - $cantidad_abono_pagare_proveedor;
                    $cantidad_abono_pagare_proveedor = 0;
                  }else{
                    $monto_abonar_pagare_proveedor   = $pendiente_pagare_proveedor;
                    $restante_pagare_proveedor       = 0;
                    $cantidad_abono_pagare_proveedor = $cantidad_abono_pagare_proveedor - $monto_abonar_pagare_proveedor;
                  }

                  $AbonosPP = abonos_pagares_proveedores::createAbonoPagaresProveedores($pendiente_pagare_proveedor, $monto_abonar_pagare_proveedor,
                  $restante_pagare_proveedor,$serie_general, $monto_general, $emisora_institucion, $emisora_agente, $receptora_institucion,
                  $receptora_agente, $tipo_comprobante, $folio, $metodo_pago = '6', $fecha_movimiento, $archivo_cargado, $comentarios,
                  $id_pagare_proveedor, $usuario_creador, $fecha_inicio, $fecha_actual, $visible = 'SI', $id_movimiento_estado_cuenta,
                  $tipo_moneda = 'MXN',$tipo_cambio = '1', $monto_general);
                  // return $AbonosPP;

                  if($AbonosPP){
                    if($restante_pagare_proveedor==0){
                      $consulta4 = documentos_pagar::where('iddocumentos_pagar', $id_pagare_proveedor)->update(['estatus' => 'Pagado']);
                    }//end if; $restante_pagare==0
                  }//end if; $consulta3==1
                }//end else; mysql_num_rows($consulta)==0
              }//end while; $cantidad_abono_pagare>0
              //**************************************************************************************************************************************************************************************************************************************************************
              //Se abono la cantidad en el estado de cuenta de proveedores, proceder a abonarlo al estado de cuenta de clientes
              $cantidad_abono_cobranza = $monto_precio;
              $bandera1 = 0;
              while($cantidad_abono_cobranza > 0){
                $NombreP = proveedores::select('nombre','apellidos')->where('idproveedores', $cliente)->first();
                $Contacto = contactos::select('idcontacto')->where('nombre', $NombreP->nombre)->where('apellidos', $NombreP->apellidos)->first();
                $idcliente=$Contacto->idcontacto;

                $saldo_general_cte = estado_cuenta::select(DB::raw("SUM(cargo) - SUM(abono) AS TOTAL "))->where('idcontacto', $idcliente)->where('visible', 'SI')->first()->TOTAL;
                $saldo_general_nuevo_cte = $saldo_general_cte - $monto_precio;

                $EC_A = estado_cuenta::where('idcontacto', $idcliente)->where('datos_estatus', 'Pendiente')->where('visible', 'SI')->orderBy('fecha_movimiento', 'ASC')->limit(1)->get();
                $Unidades = sizeof($EC_A);
                if($Unidades == 0){
                  if($bandera1 != 1){
                    $ins_edo_cta = estado_cuenta::createEstadoCuenta($concepto_cobranza, $apartado_usado = 'N/A', $tipo_movimiento, $efecto_movimiento,
                    $fecha_movimiento, $metodo_pago = '6', $saldo_general_cte, $saldo_general_nuevo_cte, $monto_precio, $serie_general, $monto_general,
                    $tipo_moneda, $tipo_cambio, $monto_general, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion,
                    $receptora_agente, $tipo_comprobante, $folio, $marca_cobranza, $version_cobranza, $color_cobranza, $modelo_cobranza, $vin_cobranza,
                    $precio_cobranza, $estado_unidad, $asesor11, $enlace11, $asesor22, $enlace22, $coach = null, $archivo_cargado, $comentarios,
                    $idcliente, $comision = 'NO', $visible = 'SI',$comentarios_eliminacion = null, $usuario_elimino = null, $fecha_eliminacion = null,
                    $usuario_creador, $fecha_inicio, $fecha_actual);
                  }
                  $cantidad_abono_cobranza = 0;
                  $bandera1=1;

                  $id_movimiento_estado_cuenta = $ins_edo_cta->idestado_cuenta;
                  //end if; fetch row $query
                  //**************************************************************************************************************************************************************************************************************************************************************
                  if($tipo_comprobante == 'Recibo Automático'){

                    $Recibos = recibos::createRecibos($fecha_movimiento, $monto_precio, $emisora_institucion, $emisora_agente, $receptora_institucion,
                    $receptora_agente, $concepto, $metodo_pago = '6', $folio, $comentarios, $id_movimiento_estado_cuenta, $id_tesoreria = null,
                    $idcliente, $usuario_creador, $departamento = null, $fecha_actual, $tipo_moneda = 'MXN', $tipo_cambio = '1', $monto_general);

                    if ($Recibos) {
                      $id_rec2=base64_encode($Recibos->idrecibos);
                      //ESE ECHO ESTABA COMENTADO
                      /*echo "<script language='javascript' type='text/javascript'>
                      alert('Movimiento Guardado Exitosamente Apartado');
                      window.open('recibo_pdf.php?idrb=$id_rec2','_blank');
                      document.location.replace('estado_cuenta.php?idc=$c1');
                      </script>";*/
                    }
                  }
                  //**************************************************************************************************************************************************************************************************************************************************************
                  //echo "<br>Sin Unidades: $ins_edo_cta<br>";
                }else{

                  foreach ($EC_A as $key => $estadoC) {
                    $edo_cta_cte = $estadoC->idestado_cuenta;
                    $precio_unidad = $estadoC->datos_precio;
                  }

                  if($bandera1!=1){

                    $ins_edo_cta = estado_cuenta::createEstadoCuenta($concepto_cobranza, $apartado_usado = 'N/A', $tipo_movimiento, $efecto_movimiento,
                    $fecha_movimiento, $metodo_pago = '6', $saldo_general_cte, $saldo_general_nuevo_cte, $monto_precio, $serie_general, $monto_general,
                    $tipo_moneda, $tipo_cambio, $monto_general, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion,
                    $receptora_agente, $tipo_comprobante, $folio, $marca_cobranza, $version_cobranza, $color_cobranza, $modelo_cobranza, $vin_cobranza,
                    $precio_cobranza, $estado_unidad, $asesor11, $enlace11, $asesor22, $enlace22, $coach = null, $archivo_cargado, $comentarios,
                    $idcliente, $comision = 'NO', $visible = 'SI',$comentarios_eliminacion = null, $usuario_elimino = null, $fecha_eliminacion = null,
                    $usuario_creador, $fecha_inicio, $fecha_actual);

                    if($ins_edo_cta == 1){
                      $bandera1 = 1;
                      $id_movimiento_estado_cuenta = $ins_edo_cta->idestado_cuenta;
                      //**************************************************************************************************************************************************************************************************************************************************************
                      if($tipo_comprobante == 'Recibo Automático'){

                        $Recibos = recibos::createRecibos($fecha_movimiento, $monto_precio, $emisora_institucion, $emisora_agente, $receptora_institucion,
                        $receptora_agente, $concepto, $metodo_pago = '6', $folio, $comentarios, $id_movimiento_estado_cuenta, $id_tesoreria = null,
                        $idcliente, $usuario_creador, $departamento = null, $fecha_actual, $tipo_moneda = 'MXN', $tipo_cambio = '1', $monto_general);

                        if ($Recibos) {
                          $id_rec2=base64_encode($Recibos->idrecibos);
                          //ESE ECHO ESTABA COMENTADO
                          /*echo "<script language='javascript' type='text/javascript'>
                          alert('Movimiento Guardado Exitosamente Apartado');
                          window.open('recibo_pdf.php?idrb=$id_rec2','_blank');
                          document.location.replace('estado_cuenta.php?idc=$c1');
                          </script>";
                          */
                        }
                      }
                      //**************************************************************************************************************************************************************************************************************************************************************
                    }
                  }//end if; $bandera!=1

                  $Suma_ECP = abonos_unidades::where('idestado_cuenta', $edo_cta_cte)->where('visible', 'SI')->sum('cantidad_pago');

                  if($Suma_ECP == null || $Suma_ECP == "")
                  $pendiente_unidad = $precio_unidad;
                  else{
                    $pendiente_unidad = $precio_unidad - $Suma_ECP;
                  }//end else; $num==0
                  if($cantidad_abono_cobranza <= $pendiente_unidad){
                    $monto_abonar = $cantidad_abono_cobranza;
                    $cantidad_abono_cobranza = 0;
                    $restante = $pendiente_unidad - $monto_abonar;
                  }//end if; $cantidad_abono<=$pendiente_unidad
                  else{
                    $monto_abonar = $pendiente_unidad;
                    $cantidad_abono_cobranza = $cantidad_abono_cobranza - $pendiente_unidad;
                    $restante = 0;
                    $bandera1 = 1;
                  }//end else; $cantidad_abono<=$pendiente_unidad

                  $ins_abono_unidad = abonos_unidades::createAbonosUnidades($concepto, $pendiente_unidad, $monto_abonar, $restante,
                  $serie_general, $monto_general, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante,
                  $folio, $metodo_pago = '6', $fecha_movimiento, $marca, $version, $color, $modelo, $precio_u, $vin,
                  $archivo_cargado, $comentarios, $edo_cta_cte, $usuario_creador, $fecha_inicio, $fecha_actual, $visible = 'SI', $id_movimiento_estado_cuenta,
                  $tipo_moneda = 'MXN', $tipo_cambio = '1' ,$monto_precio);

                  if($ins_abono_unidad){
                    if($restante==0){
                      $UpdateEC = estado_cuenta::where('idestado_cuenta', $edo_cta_cte)->where('visible', 'SI')->update(['datos_estatus' => 'Pagada']);
                    }//end if; $restante==0
                    //**************************************************************************************************************************************************************************************************************************************************************
                    $cantidad_abono_pagare = $monto_abonar;

                    while($cantidad_abono_pagare > 0){

                      $Docs_Cobrar = documentos_cobrar::where('idestado_cuenta', $edo_cta_cte)->where('estatus', 'Pendiente')->where('visible', 'SI')->orderBy('fecha_vencimiento', 'ASC')->limit(1)->get();
                      if(sizeof($Docs_Cobrar)==0){
                        //echo "No hay pagares pendientes";
                        $cantidad_abono_pagare = 0;
                      }
                      else{
                        foreach ($Docs_Cobrar as $key => $DC) {

                          $id_pagare = $DC->iddocumentos_cobrar;
                          $monto_pagare = $DC->monto;

                          $Suma_AP = abonos_pagares::where('iddocumentos_cobrar', $id_pagare)->where('visible', 'SI')->sum('cantidad_pago');

                          if($Suma_AP == null || $Suma_AP == ""){
                            $pendiente_pagare = $monto_pagare;
                          }
                          else{
                            $pendiente_pagare = $monto_pagare - $Suma_AP;
                          }
                        }
                        if($cantidad_abono_pagare <= $pendiente_pagare){
                          $monto_abonar_pagare = $cantidad_abono_pagare;
                          $restante_pagare = $pendiente_pagare - $cantidad_abono_pagare;
                          $cantidad_abono_pagare = 0;
                        }else{
                          $monto_abonar_pagare = $pendiente_pagare;
                          $restante_pagare = 0;
                          $cantidad_abono_pagare = $cantidad_abono_pagare - $monto_abonar_pagare;
                        }

                        $AbonosPagares = abonos_pagares::createAbonoPagaresProveedores($pendiente_pagare,$monto_abonar_pagare,$restante_pagare,$serie_general,
                        $monto_general,$emisora_institucion,$emisora_agente,$receptora_institucion,$receptora_agente,$tipo_comprobante,
                        $folio,$metodo_pago = '6',$fecha_movimiento,$archivo_cargado,$comentarios,$id_pagare,$usuario_creador,
                        $fecha_inicio,$fecha_actual,$visible = 'SI',$id_movimiento_estado_cuenta,$tipo_moneda = 'MXN' ,$tipo_cambio = '1',$monto_general);

                        if($AbonosPagares){
                          if($restante_pagare==0){
                            $UpdateDC = documentos_cobrar::where('iddocumentos_cobrar', $id_pagare)->where('visible', 'SI')->update(['estatus' => 'Pagado']);
                          }//end if; $restante_pagare==0

                        }//end if; $consulta3==1
                      }//end else; mysql_num_rows($consulta)==0
                    }//end while; $cantidad_abono_pagare>0
                    //**************************************************************************************************************************************************************************************************************************************************************
                  }//end if; $ins_abono_unidad==1
                  //echo "Hay Unidades<br>";
                }
                //$cantidad_abono_cobranza-=1000;
              }//end while; $cantidad_abono_cobranza>0
            }//end else; $cantidad_abono>$fila[0]
          }//end if; $fila=mysql_fetch_row($consulta)
          DB::commit();

          return back()->with('success','Movimiento Guardado Exitosamente')->withInput();

        }else if($concepto == "Anticipo de Comision"){


          $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
          $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio,$serie_general, $monto_general,$tipo_moneda,
          $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
          $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
          $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
          $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
          $fecha_actual, $folio, $folio_anterior, $actividad, $depositante, $col5 = null, $col6 = null,
          $col7 = null, $col8 = null, $col9 = null, $col10 = null);

          $id_recx = $ins_edo_cta->idestado_cuenta_proveedores;


          if ($tipo_comprobante == 'Recibo Automático') {


            $result19 = recibos_proveedores::createRecibosProveedores($fecha_movimiento, $monto_precio, $emisora_institucion,
            $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, '6', $folio, $comentarios, $id_recx, null, $cliente,
            $usuario_creador, null, $fecha_actual, 'MXN', '1', $monto_general);
          }

          $c1=base64_encode($cliente);
          DB::commit();
          return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ])->withInput();

        }else if($concepto == "Apartado"){

          $estado_unidad="Pendiente";
          $marca = request()->marca_venta_apartado;
          $modelo = request()->modelo_venta_apartado;
          $color = request()->color_venta_apartado;
          $version = request()->version_venta_apartado;
          $vin = request()->vin_venta_apartado;


          $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
          $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio,$serie_general, $monto_general,$tipo_moneda,
          $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
          $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
          $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
          $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
          $fecha_actual, $folio, $folio_anterior, $actividad, $depositante, $col5 = null, $col6 = null,
          $col7 = null, $col8 = null, $col9 = null, $col10 = null);
          // dd($ins_edo_cta);
          $id_recx = $ins_edo_cta->idestado_cuenta_proveedores;

          if ($tipo_comprobante == 'Recibo Automático') {

            $result19 = recibos_proveedores::createRecibosProveedores($fecha_movimiento, $monto_precio, $emisora_institucion,
            $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, '6', $folio, $comentarios, $id_recx, null,
            $cliente, $usuario_creador, null, $fecha_actual, 'MXN', '1', $monto_general);
          }

          $c1=base64_encode($cliente);
          DB::commit();
          return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ])->withInput();

        }else if($concepto=="Abono" || strpos($concepto, 'Otros Cargos')===0 || $concepto=='Finiquito de VIN'){
          $monto_abonar_pagares=1;
          $saldo_compra = request()->saldo_prov;
          $saldo_val = request()->saldo;
          $resto_abono = 1;
          // return request();
          $monto_precio1=$monto_precio;
          if (request()->validar_abono_sobrante==1) {
            // dd('Sacar cargo');
            // $ins_edo_cta1 = estado_cuenta_proveedores::createEstadoCuentaProveedores('Cargo no asignado', 'N/A','cargo', 'suma',
            // $fecha_movimiento, '', $saldo_anterior, $saldo_anterior+$monto_precio1, $monto_precio1,$serie_general, $monto_general,$tipo_moneda,
            // $tipo_cambio, $saldo, $monto_precio1, $cargo, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
            // $tipo_comprobante, 'CAS-'.$referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
            // $asesor22, $enlace22, null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
            // null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
            // $fecha_actual, 'CAS-'.$referencia, $folio_anterior = "", $actividad, $depositante, $col5 = null, $col6 = null,
            // $col7 = null, $col8 = null, $col9 = null, $col10 = null);
            $saldos = saldo_compras::where('idproveedores', $cliente)->where('visible', 'SI')->where('concepto', 'Abono')->get();
            $saldo_abonos = $monto_precio1;
            foreach ($saldos as $saldo) {
              if ($saldo_abonos>0) {
                if ($saldo->cantidad>=$saldo_abonos) {
                  $estado_cuenta_provedores_al_aire = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $saldo->idestado_cuenta_proveedores)->get(['idestado_cuenta_proveedores','abono','visible','monto_precio'])->first();
                  $estado_cuenta_provedores_al_aire->abono = $estado_cuenta_provedores_al_aire->abono - $saldo_abonos;
                  $estado_cuenta_provedores_al_aire->monto_precio = $estado_cuenta_provedores_al_aire->monto_precio - $saldo_abonos;
                  if ($estado_cuenta_provedores_al_aire->abono<=0) {
                    $estado_cuenta_provedores_al_aire->visible = 'NO';
                  }
                  $estado_cuenta_provedores_al_aire->saveOrFail();
                  $saldo->cantidad = $saldo->cantidad-$saldo_abonos;
                  if ($saldo->cantidad<=0) {
                    $saldo->visible = 'NO';
                  }
                  $saldo->saveOrFail();
                  $saldo_abonos = 0;
                  // dd($estado_cuenta_provedores_al_aire,$saldo,$saldo_abonos,$monto_precio1);
                }else {
                  $saldo_abonos = $saldo_abonos - $saldo->cantidad;
                  $estado_cuenta_provedores_al_aire = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $saldo->idestado_cuenta_proveedores)->get(['idestado_cuenta_proveedores','abono','visible','monto_precio'])->first();
                  $estado_cuenta_provedores_al_aire->abono = 0;
                  $estado_cuenta_provedores_al_aire->monto_precio = 0;
                  if ($estado_cuenta_provedores_al_aire->abono<=0) {
                    $estado_cuenta_provedores_al_aire->visible = 'NO';
                  }
                  $estado_cuenta_provedores_al_aire->saveOrFail();
                  $saldo->cantidad = 0;
                  if ($saldo->cantidad<=0) {
                    $saldo->visible = 'NO';
                  }
                  $saldo->saveOrFail();
                  // dd($estado_cuenta_provedores_al_aire,$saldo,$saldo_abonos,$monto_precio1);
                }
              }
            }
            // return $saldos;
            // dd('Buscar abonos');

            // $saldo_compras = saldo_compras::createCostoImportacion($ins_edo_cta1->idestado_cuenta_proveedores, $cliente,'Cargo',
            // $monto_precio1,'N/A', 'SI', $fecha_inicio, $fecha_actual);
            // dd($saldo_anterior,$monto_precio1);
            $saldo_anterior = $monto_precio1+$saldo_anterior;
            // dd($ins_edo_cta1,$saldo_anterior, $saldo, $monto_precio1);
          }
          $nuevo_saldo_anterior = $saldo_anterior-$saldo_compra;
          // dd($abono);
          if ($abono!='' && $abono>$saldo_compra && $saldo_val<=$saldo_compra) {
            $abono_al_aire = $abono-$saldo_compra;
          }elseif ($abono!='' && $abono>$saldo_compra && $abono>$saldo_val) {
            $abono_al_aire = $abono-$saldo_val;
          }else {
            $abono_al_aire = 0;
          }
          if ($abono!='') { $save_abono = $abono;
          }else { $save_abono=0; }
          // dd($abono_al_aire, $save_abono);
          // dd($saldo_anterior,$saldo_compra,$abono,$nuevo_saldo_anterior,$abono_al_aire);
          // while ($resto_abono>0) {
          // dd($save_abono);
          // return request();

          while ($monto_abonar_pagares>0) {
            if (strpos($concepto, 'Otros Cargos')===0 || $concepto=='Finiquito de VIN') {
              $monto_abonar_pagares=0;
            }
            $estado_unidad = "Pendiente";
            $marca = request()->marca_venta_apartado;
            $modelo = request()->modelo_venta_apartado;
            $color = request()->color_venta_apartado;
            $version = request()->version_venta_apartado;
            $vin = request()->vin_venta_apartado;
            // return request();
            if($receptora_agente == "NEW"){
              $nombre_beneficiario = request()->nombre_beneficiario;
              $cuenta_beneficiario = request()->cuenta_beneficiario;
              $clabe_beneficiario = request()->clabe_beneficiario;
              $BeneficiarioP = beneficiarios_proveedores::createBeneficiariosProveedores($nombre_beneficiario, $cuenta_beneficiario, $clabe_beneficiario,
              $cliente, $visible = 'SI', $fecha_inicio, $fecha_actual);
              if (!empty($BeneficiarioP)) {
                $receptora_agente=$nombre_beneficiario;
              }else {
                DB::rollback();
                return back()->with('error', 'Error al crear Beneficiario' )->withInput();
              }
            }
            $monto_precio_temp = 0;
            if ($concepto=="Abono") {

              if (documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->count()==0) {
                $new_documentos_pagar = documentos_pagar::createDocumentosPagar('1/1', $movimiento_original, \Carbon\Carbon::now()->format('Y-m-d'), 'Virtual', 'Pendiente', 'N/A', '#', 'Abono prueva', $movimiento_original, $usuario_creador, \Carbon\Carbon::now(), 'SI');
                $estado_unidad = 'Pagada';
              }
              $documento_pagar_pendiente = documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->where('estatus', 'Pendiente')->get(['iddocumentos_pagar','idestado_cuenta','monto','estatus'])->first();
              if (empty($documento_pagar_pendiente)) {
                $original = estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$movimiento_original)->get(['idestado_cuenta_proveedores','idcontacto'])->first();
                // dd($saldo_anterior);
                if (estado_cuenta_proveedores::where('idcontacto',$original->idcontacto)->where('visible', 'SI')->where('concepto', 'Compra Directa')->where('datos_estatus', 'Pendiente')->count()==0) {
                  if ($abono_al_aire>0) {
                    $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
                    $fecha_movimiento, $metodo_pago, 0, number_format($abono_al_aire*-1, 2, '.', ''), number_format($abono_al_aire, 2, '.', ''),$serie_general, number_format($monto_general, 2, '.', ''),$tipo_moneda,
                    $tipo_cambio, number_format($abono_al_aire, 2, '.', ''), $cargo, number_format($abono_al_aire, 2, '.', ''), $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
                    $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
                    $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
                    $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
                    $fecha_actual, $referencia, $folio_anterior = "", $actividad, $depositante, $col5 = 'Pendiente abonar', $col6 = null,
                    $col7 = null, $col8 = null, $col9 = null, $col10 = null);
                    $abono_positivo =abs($abono_al_aire);
                    $saldo_compras = saldo_compras::createCostoImportacion($ins_edo_cta->idestado_cuenta_proveedores, $cliente,$concepto,
                    number_format($abono_positivo, 2, '.', ''),'N/A', 'SI', $fecha_inicio, $fecha_actual);
                  }

                  if($metodo_pago==1){
                    // return $ins_edo_cta;
                    $recibos_proveedores = recibos_proveedores::createRecibosProveedores($fecha_movimiento, $monto_pesos_recibo, $emisora_institucion,
                    $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, $metodo_pago, $referencia, $comentarios,
                    $ins_edo_cta->idestado_cuenta_proveedores, null, $cliente, $usuario_creador, null, $fecha_actual, $tipo_moneda, $tipo_cambio, $monto_general_recibo);
                    /*
                    Continuar aqui
                    */
                    // dd(InfoConectionController::getIp());
                    // return $monto_general_recibo;
                    $comprobante_transferencias = comprobantes_transferencia::createComprobantesTransferencia(
                      $concepto, $fecha_movimiento, \Carbon\Carbon::now()->format('Ymd').'/'.$movimiento_original.'/'.$usuario_creador.'/'.\Auth::user()->idempleados, 'Aplicado', $cliente, 'Proveedor', $vin,
                      $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia,
                      $monto_general_recibo, $tipo_moneda, $tipo_cambio, $monto_general_recibo*$tipo_cambio, '', 'Administracion de Compras', '', $ins_edo_cta->idestado_cuenta_proveedores, 'estado_cuenta_proveedores',
                      'SI', 'Abono a proveedor', InfoConectionController::getIp(), request()->coordenadas, \Auth::user()->idempleados, $usuario_creador, $fecha_actual, $fecha_movimiento,
                      $metodo_pago, 'Abono'
                    );
                    // $recibo = recibos_proveedores::where('idrecibos_proveedores',$id_recibo)->get()->first();
                    // $proveedor = proveedores::where('idproveedores',$recibo->idcontacto)->get()->first();
                    /*Fecha recibo encabezado*/
                    $fecha_recibo = new \DateTime($recibos_proveedores->fecha_guardado);
                    /*Usuario*/
                    // $usuario = usuarios::where('idusuario',$recibo->usuario_creador)->get()->first();
                    // if(!empty($usuario)) $nombre_usuario = $usuario->nombre_usuario;
                    $num_random = rand(1,10000);
                    /*id-proveedor / fecha / id-usuario / id-empleado / id-movimiento / random*/
                    $id_generic_voucher = $cliente."/".$fecha_recibo->format('Ymdhms')."/".$usuario_creador."/".\Auth::user()->idempleados."/".$recibos_proveedores->idrecibos_proveedores."/".$num_random;
                    $route = route('vouchers.viewVoucher',['','']).'/view/'.$comprobante_transferencias->idcomprabantes_transferencia;
                    $comprobante_transferencias->url =$route;
                    $comprobante_transferencias->referencia=$id_generic_voucher;
                    $comprobante_transferencias->saveOrFail();
                    $recibos_proveedores->referencia = $id_generic_voucher;
                    $recibos_proveedores->saveOrFail();
                    // $referencia_estado_cuenta_proveedores = $ins_edo_cta->referencia;
                    $estados_cuenta_creados = estado_cuenta_proveedores::where('referencia', $referencia)->get(['idestado_cuenta_proveedores','referencia']);
                    foreach ($estados_cuenta_creados as $estado_cuenta_creado) {
                      $estado_cuenta_creado->referencia=$id_generic_voucher;
                      $estado_cuenta_creado->saveOrFail();
                    }
                    $abonos_unidades_proveedores_creados = abonos_unidades_proveedores::where('referencia', $referencia)->get(['idabonos_unidades_proveedores','referencia']);
                    foreach ($abonos_unidades_proveedores_creados as $abono_unidad_proveedor_creado) {
                      $abono_unidad_proveedor_creado->referencia=$id_generic_voucher;
                      $abono_unidad_proveedor_creado->saveOrFail();
                    }
                    // $ins_abono_unidad->referencia=$id_generic_voucher;
                    // $ins_abono_unidad->saveOrFail();
                    $abonos_pagares_proveedores_creados = abonos_pagares_proveedores::where('referencia', $referencia)->get(['idabonos_pagares_proveedores','referencia']);
                    foreach ($abonos_pagares_proveedores_creados as $abono_pagare_proveedor_creado) {
                      $abono_pagare_proveedor_creado->referencia=$id_generic_voucher;
                      $abono_pagare_proveedor_creado->saveOrFail();
                    }
                    // return $abonos_pagares_proveedores_creados;
                    // $abonos_pagares_proveedores->referencia=$id_generic_voucher;
                    // $abonos_pagares_proveedores->saveOrFail();
                    // dd($recibos_proveedores->referencia,$comprobante_transferencias->referencia,
                    // $ins_edo_cta->referencia,$ins_abono_unidad->referencia,$abonos_pagares_proveedores->referencia);
                    session(['recibos_proveedores' => $recibos_proveedores->idrecibos_proveedores]);
                    session(['comprobantes_transferencia' => $comprobante_transferencias->idcomprabantes_transferencia]);
                    // return session('comprobantes_transferencia');

                    // return $recibos_proveedores;
                    // dd($recibos_proveedores,$ins_edo_cta,$ins_abono_unidad,$abonos_pagares_proveedores);
                  }

                  DB::commit();
                  return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ]);
                }else {
                  // return estado_cuenta_proveedores::where('idcontacto',$original->idcontacto)->where('visible', 'SI')->where('concepto', 'Compra Directa')->where('datos_estatus', 'Pendiente')->count();
                  $new_original = estado_cuenta_proveedores::where('idcontacto',$original->idcontacto)->where('visible', 'SI')->where('concepto', 'Compra Directa')->where('datos_estatus', 'Pendiente')->first();
                  $movimiento_original = $new_original->idestado_cuenta_proveedores;
                  $documento_pagar_pendiente = documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->where('estatus', 'Pendiente')->get(['iddocumentos_pagar','idestado_cuenta','monto','estatus'])->first();
                  if ($save_abono>0) {
                    $nuevo_saldo_anterior=$save_abono;
                  }
                  // dd($nuevo_saldo_anterior);
                  $monto_precio=$nuevo_saldo_anterior;
                  $nuevo_saldo_anterior=$nuevo_saldo_anterior-$monto_precio;
                  $cnnn = 0;
                  // dd($abono);
                  // dd($nuevo_saldo_anterior);
                  if ($monto_precio<1) {
                    // dd($monto_precio);

                    DB::commit();
                    return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ]);
                  }
                  // dd($monto_precio);
                  // dd($documento_pagar_pendiente);
                }
              }
              $monto_alcanzado_pagare = documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado');
              $resto = $documento_pagar_pendiente->monto-$monto_alcanzado_pagare;
              if ($resto>$monto_precio) {
                $abono = $monto_precio;
                $save_abono=$save_abono-$abono;
                // if (isset($nuevo_saldo_anterior)) {
                //   $nuevo_saldo_anterior=$nuevo_saldo_anterior-$monto_precio;
                // }
              }else {
                $abono = $resto;
                $save_abono=$save_abono-$abono;

                // if (isset($nuevo_saldo_anterior)) {
                //   $nuevo_saldo_anterior=0;
                // }
              }

              // dd($abono,$save_abono);
              // if ($documento_pagar_pendiente->monto>$monto_precio) {
              //   $abono = $monto_precio;
              // }else {
              //   $abono = $documento_pagar_pendiente->monto - $monto_alcanzado_pagare;
              // }
              $saldo = $saldo_anterior-$abono;
              $monto_precio_temp=$monto_precio;
              $monto_precio = $abono;
              $gran_total = $abono/$tipo_cambio;
              $monto_general=$abono;
            }else {
              $gran_total = $monto_precio/$tipo_cambio;
            }
            // dd($cargo);
            // dd($saldo_anterior);
            $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
            $fecha_movimiento, $metodo_pago, number_format($saldo_anterior, 2, '.', ''), number_format($saldo, 2, '.', ''), number_format($monto_precio, 2, '.', ''),$serie_general, number_format($monto_general, 2, '.', ''),$tipo_moneda,
            $tipo_cambio, number_format($gran_total, 2, '.', ''), $cargo, number_format($abono, 2, '.', ''), $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
            $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
            $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
            $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
            $fecha_actual, $referencia, $folio_anterior = "", $actividad, $depositante, $col5 = null, $col6 = null,
            $col7 = null, $col8 = null, $col9 = null, $col10 = null);
            $id_recx = $ins_edo_cta->idestado_cuenta_proveedores;
            // dd($ins_edo_cta);
            if (isset($cnnn)) {
              // dd($ins_edo_cta);
            }
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
                $resto_pagare = $documento_pagar_pendiente->monto-documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado');
                if (documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado')<$documento_pagar_pendiente->monto) {
                  $documento_pagar_pendiente_monto=(float)$documento_pagar_pendiente->monto;
                  if ($monto_abonar_pagares>$resto_pagare) {
                    // dd($resto_pagare);
                    // $monto_precio = $monto_abonar_pagares-$documento_pagar_pendiente_monto;
                    $monto_abonar_pagares = $resto_pagare;
                  }else {
                    $monto_abonar_pagares = $abono;
                  }
                  if ($monto_abonar_pagares>0) {
                    // dd($documento_pagar_pendiente->monto-$monto_abonar_pagares);
                    // $documento_pagar_pendiente_monto = $documento_pagar_pendiente_monto-$monto_abonar_pagares;
                    $abono_a_pagare = documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $documento_pagar_pendiente->iddocumentos_pagar)->sum('monto_alcanzado');

                    $ins_abono_unidad = abonos_unidades_proveedores::createAbonosUnidadesProveedores( $concepto, number_format($documento_pagar_pendiente->monto - $abono_a_pagare, 2, '.', ''),
                    number_format($monto_abonar_pagares, 2, '.', ''), number_format(($documento_pagar_pendiente->monto-$abono_a_pagare)-$monto_abonar_pagares, 2, '.', ''), '', number_format($monto_general, 2, '.', ''), $emisora_institucion, $emisora_agente,
                    $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $metodo_pago, $fecha_movimiento,
                    $marca, $version, $color, $modelo, $precio_u, $vin, $archivo_cargado, $comentarios,
                    $movimiento_original, $usuario_creador, $fecha_inicio, $fecha_actual, $visible = 'SI', $ins_edo_cta->idestado_cuenta_proveedores,
                    $tipo_moneda, $tipo_cambio, number_format($monto_precio/$tipo_cambio, 2, '.', ''));
                    if (abonos_unidades_proveedores::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->count()==1) {
                      // $inventario = inventario::createInventario('N/A', $marca, $modelo, $version, $color, $modelo, 0, 0, '',
                      // $vin, '', 'N/A', '', $fecha_actual, '0001-01-01', '0001-01-01', '0001-01-01',
                      // 'Panamotors Center, S.A. de C.V.', 'N/A', 'N/A', 0, 'N/A', 'En Camino', 'P1', 'Agregado por primer abono',
                      // 'No Publicado', 'NO', 'NO', 'SI', $usuario_creador, $fecha_actual, $fecha_movimiento, 'N/A', 'N/A');
                    }
                    $documentos_pagar_abonos_unidades_proveedores = documentos_pagar_abonos_unidades_proveedores::createDocumentosPagarAbonosUnidadesProv($documento_pagar_pendiente->iddocumentos_pagar,
                    $ins_abono_unidad->idabonos_unidades_proveedores, number_format($documento_pagar_pendiente->monto-$abono_a_pagare, 2, '.', ''), number_format($monto_abonar_pagares, 2, '.', ''), \Carbon\Carbon::now());
                    // $monto_abonar_pagares=$monto_abonar_pagares-$monto_abonar_pagare;

                    $abonos_pagares_proveedores = abonos_pagares_proveedores::createAbonoPagaresProveedores(number_format($documento_pagar_pendiente->monto-$abono_a_pagare, 2, '.', ''), number_format($monto_abonar_pagares, 2, '.', ''), number_format((($documento_pagar_pendiente->monto-$abono_a_pagare) - $monto_abonar_pagares), 2, '.', ''),
                    'N/A', number_format($monto_abonar_pagares, 2, '.', ''), $emisora_institucion,$emisora_agente,$receptora_institucion,$receptora_agente,$tipo_comprobante,$referencia,$metodo_pago,$fecha_movimiento,$archivo_cargado,$comentarios,
                    $documento_pagar_pendiente->iddocumentos_pagar,$usuario_creador,$fecha_inicio, $fecha_actual,'SI',$ins_edo_cta->idestado_cuenta_proveedores,$tipo_moneda,$tipo_cambio,number_format($monto_abonar_pagares/$tipo_cambio, 2, '.', ''));
                    // dd($abonos_pagares_proveedores);
                    // return $abonos_pagares_proveedores;
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
                $saldo_anterior = $saldo_anterior-$monto_precio;
                if ($monto_precio_temp>0) {
                  $monto_precio = $monto_precio_temp;
                }
                // dd($monto_precio);
                if (documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->where('estatus', 'Pendiente')->get(['iddocumentos_pagar','idestado_cuenta','monto','estatus'])->count()==0) {

                  $monto_precio = $saldo;
                }
                // dd($monto_abonar_pagares);
                $monto_precio = $monto_precio - $monto_abonar_pagares;
                // dd($saldo_anterior);
                $saldo = $saldo_anterior-$monto_precio;
                $monto_abonar_pagares = $monto_precio;

                $monto_abono = $monto_abonar_pagares;
                $saldo_pagare=$saldo-$monto_precio;
                $monto_general = $monto_precio;
                $gran_total=$monto_precio;
                // dd($monto_precio);
                if ($tipo_movimiento=="cargo") {
                  $cargo=$monto_abono;
                  $abono="";
                }
                // dd($monto_precio);
                if ($tipo_movimiento=="abono") {
                  $cargo="";
                  $abono=$save_abono;
                  $monto_abonar_pagares=$save_abono;
                }
                if (request()->validar_abono_sobrante==1) {
                  // $monto_abonar_pagares=0;
                  // dd($monto_abonar_pagares);
                }
                // dd($monto_abonar_pagares);
                // dd($save_abono,$monto_precio,$saldo,$monto_abonar_pagares);
                // dd($abono);
                // dd($monto_abonar_pagares);
                // }
                if (documentos_pagar::where('idestado_cuenta', $movimiento_original)->where('visible', 'SI')->where('estatus', 'Pendiente')->count()==0) {
                  estado_cuenta_proveedores::updatePayedStateAccountProviders($movimiento_original);
                }
              }
            }
          }
          // }
          if ($abono_al_aire>0) {
            $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
            $fecha_movimiento, $metodo_pago, 0, number_format($abono_al_aire*-1, 2, '.', ''), number_format($abono_al_aire, 2, '.', ''),$serie_general, number_format($monto_general, 2, '.', ''),$tipo_moneda,
            $tipo_cambio, number_format($abono_al_aire, 2, '.', ''), $cargo, number_format($abono_al_aire, 2, '.', ''), $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
            $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
            $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
            $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
            $fecha_actual, $referencia, $folio_anterior = "", $actividad, $depositante, $col5 = 'Pendiente abonar', $col6 = null,
            $col7 = null, $col8 = null, $col9 = null, $col10 = null);
            $id_recx = $ins_edo_cta->idestado_cuenta_proveedores;
            $abono_positivo =abs($abono_al_aire);
            $saldo_compras = saldo_compras::createCostoImportacion($ins_edo_cta->idestado_cuenta_proveedores, $cliente,$concepto,
            number_format($abono_positivo, 2, '.', ''),'N/A', 'SI', $fecha_inicio, $fecha_actual);
          }

          if($metodo_pago==1){
            // return $ins_edo_cta;
            $recibos_proveedores = recibos_proveedores::createRecibosProveedores($fecha_movimiento, $monto_pesos_recibo, $emisora_institucion,
            $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, $metodo_pago, $referencia, $comentarios,
            $ins_edo_cta->idestado_cuenta_proveedores, null, $cliente, $usuario_creador, null, $fecha_actual, $tipo_moneda, $tipo_cambio, $monto_general_recibo);
            /*
            Continuar aqui
            */
            // dd(InfoConectionController::getIp());
            // return $monto_general_recibo;
            $comprobante_transferencias = comprobantes_transferencia::createComprobantesTransferencia(
              $concepto, $fecha_movimiento, \Carbon\Carbon::now()->format('Ymd').'/'.$movimiento_original.'/'.$usuario_creador.'/'.\Auth::user()->idempleados, 'Aplicado', $cliente, 'Proveedor', $vin,
              $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia,
              $monto_general_recibo, $tipo_moneda, $tipo_cambio, $monto_general_recibo*$tipo_cambio, '', 'Administracion de Compras', '', $ins_edo_cta->idestado_cuenta_proveedores, 'estado_cuenta_proveedores',
              'SI', 'Abono a proveedor', InfoConectionController::getIp(), request()->coordenadas, \Auth::user()->idempleados, $usuario_creador, $fecha_actual, $fecha_movimiento,
              $metodo_pago, 'Abono'
            );
            // $recibo = recibos_proveedores::where('idrecibos_proveedores',$id_recibo)->get()->first();
            // $proveedor = proveedores::where('idproveedores',$recibo->idcontacto)->get()->first();
            /*Fecha recibo encabezado*/
            $fecha_recibo = new \DateTime($recibos_proveedores->fecha_guardado);
            /*Usuario*/
            // $usuario = usuarios::where('idusuario',$recibo->usuario_creador)->get()->first();
            // if(!empty($usuario)) $nombre_usuario = $usuario->nombre_usuario;
            $num_random = rand(1,10000);
            /*id-proveedor / fecha / id-usuario / id-empleado / id-movimiento / random*/
            $id_generic_voucher = $cliente."/".$fecha_recibo->format('Ymdhms')."/".$usuario_creador."/".\Auth::user()->idempleados."/".$recibos_proveedores->idrecibos_proveedores."/".$num_random;
            $route = route('vouchers.viewVoucher',['','']).'/view/'.$comprobante_transferencias->idcomprabantes_transferencia;
            $comprobante_transferencias->url =$route;
            $comprobante_transferencias->referencia=$id_generic_voucher;
            $comprobante_transferencias->saveOrFail();
            $recibos_proveedores->referencia = $id_generic_voucher;
            $recibos_proveedores->saveOrFail();
            // $referencia_estado_cuenta_proveedores = $ins_edo_cta->referencia;
            $estados_cuenta_creados = estado_cuenta_proveedores::where('referencia', $referencia)->get(['idestado_cuenta_proveedores','referencia']);
            foreach ($estados_cuenta_creados as $estado_cuenta_creado) {
              $estado_cuenta_creado->referencia=$id_generic_voucher;
              $estado_cuenta_creado->saveOrFail();
            }
            $abonos_unidades_proveedores_creados = abonos_unidades_proveedores::where('referencia', $referencia)->get(['idabonos_unidades_proveedores','referencia']);
            foreach ($abonos_unidades_proveedores_creados as $abono_unidad_proveedor_creado) {
              $abono_unidad_proveedor_creado->referencia=$id_generic_voucher;
              $abono_unidad_proveedor_creado->saveOrFail();
            }
            // dd($estados_cuenta_creados);
            // $ins_abono_unidad->referencia=$id_generic_voucher;
            // $ins_abono_unidad->saveOrFail();
            $abonos_pagares_proveedores_creados = abonos_pagares_proveedores::where('referencia', $referencia)->get(['idabonos_pagares_proveedores','referencia']);
            foreach ($abonos_pagares_proveedores_creados as $abono_pagare_proveedor_creado) {
              $abono_pagare_proveedor_creado->referencia=$id_generic_voucher;
              $abono_pagare_proveedor_creado->saveOrFail();
            }
            // return $abonos_pagares_proveedores_creados;
            // $abonos_pagares_proveedores->referencia=$id_generic_voucher;
            // $abonos_pagares_proveedores->saveOrFail();
            // dd($recibos_proveedores->referencia,$comprobante_transferencias->referencia,
            // $ins_edo_cta->referencia,$ins_abono_unidad->referencia,$abonos_pagares_proveedores->referencia);
            session(['recibos_proveedores' => $recibos_proveedores->idrecibos_proveedores]);
            session(['comprobantes_transferencia' => $comprobante_transferencias->idcomprabantes_transferencia]);
            // return session('comprobantes_transferencia');

            // return $recibos_proveedores;
            // dd($recibos_proveedores,$ins_edo_cta,$ins_abono_unidad,$abonos_pagares_proveedores);
          }

          DB::commit();
          return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ]);
        }else{

          // dd('Ultimo else');
          $depositante = request()->depositante;

          if($concepto == "Apartado"){
            $vin = request()->vin_venta_apartado;
            $marca = request()->marca_venta_apartado;
            $modelo = request()->modelo_venta_apartado;
            $color = request()->color_venta_apartado;
            $version = request()->version_venta_apartado;
          }else if($concepto == "Anticipo de Compra"){
            $folio_anterior_ac = request()->folio_anterior_ac;
          }else{
            $folio_anterior_ac="";
          }

          if($receptora_agente == "NEW"){
            $nombre_beneficiario = request()->nombre_beneficiario;
            $cuenta_beneficiario = request()->cuenta_beneficiario;
            $clabe_beneficiario = request()->clabe_beneficiario;

            // $sqla="INSERT INTO beneficiarios_proveedores (nombre, numero_cuenta, clabe, idproveedor, visible, fecha_creacion, fecha_guardado) VALUES (
            // '$nombre_beneficiario','$cuenta_beneficiario', '$clabe_beneficiario', '$cliente', 'SI','$fecha_inicio', '$fecha_actual');";

            $BeneficiarioP = beneficiarios_proveedores::createBeneficiariosProveedores($nombre_beneficiario, $cuenta_beneficiario, $clabe_beneficiario,
            $cliente, $visible = 'SI', $fecha_inicio, $fecha_actual);

            if($BeneficiarioP){
              $receptora_agente=$nombre_beneficiario;
            }else{
              return back()->with('error', 'Error al crear Beneficiario' )->withInput();
            }

            $cantidad_abono = $monto_precio;
            while($cantidad_abono > 0){

              $Estado_Cuenta_Proveedores_D = estado_cuenta_proveedores::where('idcontacto', $id)->where('datos_estatus', 'Pendiente')->orderBy('fecha_movimiento', 'ASC')->limit(1)->get();
              $Unidades = sizeof($Estado_Cuenta_Proveedores_D);
              if($Unidades == 0){//No hay unidades pendientes
                if($bandera != 1){
                  $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
                  $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio,$serie_general, $monto_general,$tipo_moneda,
                  $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
                  $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
                  $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
                  $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
                  $fecha_actual, $col1 = '', $col2 = $folio_anterior_ac, $col3 = $actividad, $col4 = $depositante, $col5 = null, $col6 = null,
                  $col7 = null, $col8 = null, $col9 = null, $col10 = null);
                }

                $cantidad_abono=0;
                if ($ins_edo_cta) {
                  $id_movimiento_estado_cuenta = $ins_edo_cta->idestado_cuenta_proveedores;
                }

                if($concepto == "Anticipo de Compra"){
                  $folio_ac = "F".$cliente."-".$id_movimiento_estado_cuenta;
                  $result5 = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $id_movimiento_estado_cuenta)->update(['col1' => $folio_ac]);
                }

                //echo "<br>Sin Unidades: $ins_edo_cta<br>";
                $c1=base64_encode($cliente);
                DB::commit();
                return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ])->withInput();
              }else{
                foreach ($Estado_Cuenta_Proveedores_D as $key => $EDP_D) {
                  $edo_cta_prov = $EDP_D->idestado_cuenta_proveedores;
                  $precio_unidad = $EDP_D->datos_precio;
                  $folio = $EDP_D->col1;
                  $folio_anterior = $EDP_D->col2;
                  //$movimiento_original=$fila[idestado_cuenta_proveedores];
                }
                //echo "PENDIENTE";
                if($bandera != 1)
                if($concepto == "Anticipo de Compra"){
                  $folio_anterior=$folio_anterior_ac;
                }

                $ins_edo_cta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
                $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio,$serie_general, $monto_general,$tipo_moneda,
                $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente,
                $tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_general, $estado_unidad, $asesor11,$enlace11,
                $asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = 'NO', $visible = 'SI',
                $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
                $fecha_actual, $col1 = $folio, $col2 = $folio_anterior, $col3 = $actividad, $col4 = $depositante, $col5 = null, $col6 = null,
                $col7 = null, $col8 = null, $col9 = null, $col10 = null);
                // dd();
                if($ins_edo_cta==1){
                  $bandera=1;
                  if ($ins_edo_cta){
                    $id_movimiento_estado_cuenta = $ins_edo_cta->idestado_cuenta_proveedores;
                  }//end if; fetch row $query
                  if($concepto == "Anticipo de Compra"){
                    $folio_ac="F".$cliente."-".$id_movimiento_estado_cuenta;
                    $result5 = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $id_movimiento_estado_cuenta)->update(['col1' => $folio_ac]);
                    $cantidad_abono=0;
                    $c1=base64_encode($cliente);
                    DB::commit();
                    return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => ''])->withInput();
                  }else{
                    $AbonosUnidadesP = abonos_unidades_proveedores::select('cantidad_pendiente')->where('idestado_cuenta', $edo_cta_prov)->get();
                    $num = sizeof($AbonosUnidadesP);
                    //echo $num."<br>";
                    if($num == 0)
                    $pendiente_unidad = $precio_unidad;
                    else{
                      foreach ($AbonosUnidadesP as $key => $AUP) {
                        $pendiente_unidad = $AUP->cantidad_pendiente;
                      }
                    }//end else; $num==0
                    if($cantidad_abono <= $pendiente_unidad){
                      $monto_abonar = $cantidad_abono;
                      $cantidad_abono = 0;
                      $restante = $pendiente_unidad - $monto_abonar;
                    }//end if; $cantidad_abono<=$pendiente_unidad
                    else{
                      $monto_abonar = $pendiente_unidad;
                      $cantidad_abono = $cantidad_abono - $pendiente_unidad;
                      $restante = 0;
                      $bandera = 1;
                    }//end else; $cantidad_abono<=$pendiente_unidad

                    $ins_abono_unidad = abonos_unidades_proveedores::createAbonosUnidadesProveedores( $concepto, $pendiente_unidad,
                    $monto_abonar, $restante, $serie_general, $monto_general, $emisora_institucion, $emisora_agente,
                    $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $metodo_pago, $fecha_movimiento,
                    $marca, $version, $color, $modelo, $precio_u, $vin, $archivo_cargado, $comentarios,
                    $edo_cta_prov, $usuario_creador, $fecha_inicio, $fecha_actual, $visible = 'SI', $id_movimiento_estado_cuenta,
                    $tipo_moneda = 'MXN', $tipo_cambio = '1', $monto_precio);

                    if($ins_abono_unidad){
                      if($restante == 0){

                        $result5 = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $edo_cta_prov)->update(['datos_estatus' => 'Pagada']);
                        if($result5){
                          $c1=base64_encode($cliente);
                          DB::commit();
                          return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ])->withInput();
                        }//end if; $result5==1
                        else{
                          $c1=base64_encode($cliente);
                          return back()->with('error', 'Error al actualizar la unidad a Pagada')->withInput();
                        }
                      }//end if; $restante==0
                      else{
                        $c1=base64_encode($cliente);
                        DB::commit();
                        return back()->with(['success' => 'Movimiento Guardado Exitosamente', ''   => '' ])->withInput();
                      }//end else; $restante==0
                      //echo $edo_cta_prov."<br>Abonar a Unidad: ".$monto_abonar."<br>Saldo Anterior: ".$pendiente_unidad."<br>Saldo Nuevo: ".$restante;
                    }//end if; $ins_abono_unidad==0
                    else{
                      $c1=base64_encode($cliente);
                      return back()->with('error', 'Error al Aplicar el abono a la Unidad')->withInput();
                    }//end else; $ins_abono_unidad==0
                    //$cantidad_abono=0;
                  }
                }//end if; $ins_edo_cta==1
                else{
                  $cantidad_abono=0;
                  return back()->with('error', 'Se presento un error al guardar el movimiento, valide la información e intente nuevamente' )->withInput();
                }//end else; $ins_edo_cta==1
              }//end else; $Unidades==0
            }//end while; $cantidad_abono>0



          }
        }
      }// Validacion de fecha nula de movimiento


      //DB::commit();
      //$queries = json_encode(DB::getQueryLog());

      return back()->with('error','Algo no sucedio como debiera :(')->withInput();
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
      return $e->getMessage();
      return back()->with('error', $e->getMessage() )->withInput();
    }

  }
  public function getSaldo(Request $request){
    try {
      $state_account_provider = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $request->id_estado_cuenta_proveedores)->get(['datos_precio','datos_vin','datos_marca','datos_version','datos_color','datos_modelo'])->first();
      // return json_encode(abonos_unidades_proveedores::where('idestado_cuenta', $request->id_estado_cuenta_proveedores)->count());
      $first_pagare_to_pay = documentos_pagar::where('visible', 'SI')->where('estatus', 'Pendiente')->where('idestado_cuenta', $request->id_estado_cuenta_proveedores)->get(['iddocumentos_pagar','num_pagare','monto'])->first();
      if (!empty($first_pagare_to_pay)) {
        $monto_abonado = documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $first_pagare_to_pay->iddocumentos_pagar)->sum('monto_alcanzado');
        $no_pagare = $first_pagare_to_pay->num_pagare;
        $monto_restante = $first_pagare_to_pay->monto-$monto_abonado;
      }else {
        $no_pagare = '1/1';
        $monto_restante = $state_account_provider->datos_precio;
      }
      // return json_encode($monto_restante);
      if (abonos_unidades_proveedores::where('idestado_cuenta', $request->id_estado_cuenta_proveedores)->count()!=0) {
        // return json_encode('xS');
        $abonos_unidades_proveedores = abonos_unidades_proveedores::where('idestado_cuenta', $request->id_estado_cuenta_proveedores)->sum('cantidad_pago');
        return json_encode([
          'deuda_unidad'=>$state_account_provider->datos_precio-$abonos_unidades_proveedores,
          'no_pagare'=>$no_pagare,
          'monto_restante'=>$monto_restante,
          'vin'=>$state_account_provider->datos_vin,
          'estado_cuenta_proveedor'=>$state_account_provider

        ]);
      }else {
        return json_encode([
          'deuda_unidad'=>$state_account_provider->datos_precio,
          'no_pagare'=>$no_pagare,
          'monto_restante'=>$monto_restante,
          'vin'=>$state_account_provider->datos_vin,
          'estado_cuenta_proveedor'=>$state_account_provider

        ]);
      }
    } catch (\Exception $e) {
      return json_encode('N/A');
    }
  }
  public static function getSaldoStatic($id_estado_cuenta){
    try {
      $state_account_provider = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $id_estado_cuenta)->get(['datos_precio','datos_vin'])->first();
      // return json_encode(abonos_unidades_proveedores::where('idestado_cuenta', $request->id_estado_cuenta_proveedores)->count());
      $first_pagare_to_pay = documentos_pagar::where('visible', 'SI')->where('estatus', 'Pendiente')->where('idestado_cuenta', $id_estado_cuenta)->get(['iddocumentos_pagar','num_pagare','monto'])->first();
      if (!empty($first_pagare_to_pay)) {
        $monto_abonado = documentos_pagar_abonos_unidades_proveedores::where('iddocumentos_pagar', $first_pagare_to_pay->iddocumentos_pagar)->sum('monto_alcanzado');
        $no_pagare = $first_pagare_to_pay->num_pagare;
        $monto_restante = $first_pagare_to_pay->monto-$monto_abonado;
      }else {
        $no_pagare = '1/1';
        $monto_restante = $state_account_provider->datos_precio;
      }
      // return $monto_abonado;
      // return json_encode($monto_restante);
      if (abonos_unidades_proveedores::where('idestado_cuenta', $id_estado_cuenta)->count()!=0) {
        // return json_encode('xS');
        $abonos_unidades_proveedores = abonos_unidades_proveedores::where('idestado_cuenta', $id_estado_cuenta)->sum('cantidad_pago');
        return [
          'deuda_unidad'=>$state_account_provider->datos_precio-$abonos_unidades_proveedores,
          'no_pagare'=>$no_pagare,
          'monto_restante'=>$monto_restante,
          'vin'=>$state_account_provider->datos_vin
        ];
      }else {
        return [
          'deuda_unidad'=>$state_account_provider->datos_precio,
          'no_pagare'=>$no_pagare,
          'monto_restante'=>$monto_restante,
          'vin'=>$state_account_provider->datos_vin

        ];
      }
    } catch (\Exception $e) {
      return 'N/A';
    }
  }
  public function guardarSaldoOtrosCargos(Request $request){
    try {
      $estados_cuenta = explode(",", $request->values);
      $estados_cuenta_abonos = explode(",", $request->compr_money);
      $estado_cuenta_provedores = collect();
      foreach ($estados_cuenta as $estado_cuenta => $value) {
        $estado_cuenta_provedores->push(['estado_cuenta_provedor' => $value, 'abono' => $estados_cuenta_abonos[$estado_cuenta]]);
      }
      $estado_cuenta_first = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $estado_cuenta_provedores->first()['estado_cuenta_provedor'])->get(['saldo','idcontacto'])->first();
      $proveedor = proveedores::where('idproveedores', $estado_cuenta_first->idcontacto)->get(['idproveedores', 'col2'])->first();
      foreach ($estado_cuenta_provedores as $estado_cuenta_provedor) {
        // return $estado_cuenta_provedor;
        $estado_cuenta_abonar = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $estado_cuenta_provedor['estado_cuenta_provedor'])->get(['idestado_cuenta_proveedores','saldo','idcontacto'])->first();
        $abono = $estado_cuenta_provedor['abono']*$request->tipo_cambio;
        return $estado_cuenta_provedor;
        $abonar = AbonoController::abonar($proveedor->idproveedores,'Otros Cargos-A','Abono','Resta',
        \Carbon\Carbon::now()->format('Y-m-d'),'Abono por otros cargos',$proveedor->col2,$request->tipo_cambio,$estado_cuenta_abonar->saldo,$estado_cuenta_abonar->saldo,
        $estado_cuenta_abonar->saldo-$abono,$monto_precio,$saldo_anterior_pagare,$monto_abono_pagare,$marca,$modelo,
        $color,$version,$vin,$precio_u,$emisora_institucion,$emisora_agente,$depositante,
        $receptora_institucion,$receptora_agente,$tipo_comprobante,$referencia,$serie_general,
        $monto_general,$fecha_inicio,$cliente,$file,$movimiento_original);
        return $abono;
      }
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
      return back()->with('error', 'Error al crear Abonos' )->withInput();
    }
  }

}
