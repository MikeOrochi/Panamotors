<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\documentos_pagar_abonos_unidades_proveedores;
use App\Models\fechas_compromiso_pagrares_proveedores;
use App\Models\abonos_unidades_proveedores;
use App\Models\orden_logistica_inventario;
use App\Models\abonos_pagares_proveedores;
use App\Models\comprobantes_transferencia;
use App\Models\estado_cuenta_proveedores;
use App\Models\beneficiarios_proveedores;
use App\Models\catalogo_comprobantes;
use App\Models\catalogo_metodos_pago;
use App\Models\catalogo_tesorerias;
use App\Models\recibos_proveedores;
use App\Models\catalogo_cobranza;
use App\Models\inventario_trucks;
use App\Models\costo_importacion;
use App\Models\documentos_pagar;
use App\Models\bancos_emisores;
use App\Models\estado_cuenta;
use App\Models\proveedores;
use App\Models\inventario;
use App\Models\contactos;
// use App\proveedores;
class CompraVentaController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function store(){


    $concepto = request()->concepto_general_venta;
    $tipo_movimiento = request()->tipo_general_venta;
    $efecto_movimiento = request()->efecto_venta;
    $fecha_movimiento = request()->fechapago_venta1;
    //$metodo_pago = request()->m_pago;
    $saldo_anterior = request()->saldo_venta;
    $monto_abono = request()->monto_abono_venta;
    $saldo = request()->saldo_nuevo_venta;
    $monto_precio = request()->monto_abono_venta;
    $marca = request()->marca_venta;
    $modelo = request()->modelo_venta;
    $color = request()->color_venta;
    $version = request()->version_venta;
    $vin = request()->vin_venta;
    $precio_u = request()->monto_abono_venta;
    $tipo_moneda1 = request()->tipo_moneda_principal;
    //$tipo_cambio1 = request()->tipo_cambio_principal;
    $tipo_cambio1 = 1;
    $gran_total1 = request()->monto_abono_venta;
    $tipo_moneda2 = request()->tipo_moneda2;
    $tipo_cambio2 = request()->tipo_cambio2;
    $gran_total2 = request()->gran_total2;

    if(request()->emisor_venta == null){
      $emisora_institucion = "";
    }else{
      $emisora_institucion = request()->emisor_venta;
    }

    if(request()->agente_emisor_venta == null){
      $emisora_agente = "";
    }else{
      $emisora_agente = request()->agente_emisor_venta;
    }

    $receptora_institucion = request()->receptor_venta;
    $receptora_agente = request()->agente_receptor_venta;
    $tipo_comprobante = request()->tipo_comprobante_compra;
    $referencia = request()->n_referencia_venta;


    $ValidarReferencia = estado_cuenta_proveedores::where('referencia', $referencia)->where('visible', 'SI')->where('referencia', '<>','S/N')->get();
    if(sizeof($ValidarReferencia) != 0){
      return back()->with('error', 'Error la referencia acaba de ser tomada intente con otra')->withInput();
    }

    if(request('CantidadAnticipoMXN')){
      $ValidarReferenciaAbono = abonos_pagares_proveedores::where('referencia', request('n_referencia_anticipo'))->where('visible', 'SI')->where('referencia', '<>','S/N')->get();
      if(sizeof($ValidarReferenciaAbono) != 0){
        return back()->with('error', 'Error la referencia del abono ya fue ocupada intente con otra')->withInput();
      }
    }

    $comentarios = request()->descripcion_venta;
    $asesor11 = request()->asesor11;
    $enlace11 = request()->enlace11;
    $asesor22 = request()->asesor22;
    $enlace22 = request()->enlace22;
    $fecha_inicio = request()->fecha_inicio_venta;
    $cliente = request()->contacto_original_venta;
    $estado_unidad = "Pendiente";
    $cargo = request()->monto_abono_venta;
    $orden_logistica = request()->orden_logistica;
    $tipo_unidad = request()->tipo_unidad;
    $folio_anterior = request()->folio_anterior;
    $Folio = "F".$cliente."-";
    if($tipo_moneda1=="USD" || $tipo_moneda1=="CAD"){
      $monto_precio=$monto_precio*$tipo_cambio1;
      $cargo=$monto_precio;
    }
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date("Y-m-d H:i:s");
    $EstadoCuentaP = estado_cuenta_proveedores::where('idcontacto', $cliente)->where('visible', 'SI')->get();
    $usuario_creador = \Request::cookie('usuario_creador');
    $ref = sizeof($EstadoCuentaP);
    DB::beginTransaction();
    try {

      if ($concepto == "Compra Directa" || $concepto=="Compra Permuta" || $concepto=="Cuenta de Deuda"  || $concepto=="Consignacion" || $concepto=="Devolución del VIN" || $concepto=="Gastos Diversos de Financiamiento" || $concepto=="Comisión por Mediación Mercantil") {//El concepto del movimiento es una compra

        //Copiar Archivo
        $file = request()->file('comprobante_compra');
        if ($file == "" || $file == null) {
          $archivo_cargado="#";
        }else{
          $Fecha_A = date("Y-m-d");
          $nombre = $file->getClientOriginalName();
          $extension = pathinfo($nombre, PATHINFO_EXTENSION);
          $nombre = "P".$cliente."_".$Fecha_A."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
          $archivo_cargado = 'storage/app/movements/'.$nombre;
          Storage::disk('local')->put('/movements/'.$nombre,  \File::get($file));
        }


        if ($saldo_anterior == "") {//Validar si el saldo anterior esta vacio
          $saldo_anterior = 0;
        }//end if; Validar si el saldo anterior esta vacio
        else{// El saldo anterior no esta vacio
          $saldo_anterior = $saldo_anterior;
        }//end else; El saldo anterior no esta vacio
        //echo $folio_anterior;

        if ($tipo_movimiento=="cargo") {
          $cargo=$monto_abono*$tipo_cambio1;
          $abono="";
        }
        if ($tipo_movimiento=="abono") {
          $cargo="";
          $abono=$monto_abono;
        }
        //Aqui
        $ins_EdoCta = estado_cuenta_proveedores::createEstadoCuentaProveedores($concepto, 'N/A',$tipo_movimiento, $efecto_movimiento,
        $fecha_movimiento, $metodo_pago = null, $saldo_anterior, $saldo, $monto_precio,$serie_general = null, $monto_general = $monto_precio,
        $tipo_moneda1,$tipo_cambio1, $gran_total1, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion,
        $receptora_agente,$tipo_comprobante, $referencia, $marca, $version, $color, $modelo, $vin, $monto_precio, $estado_unidad,
        $asesor11,$enlace11,$asesor22, $enlace22, $coach = null , $archivo_cargado, $comentarios, $cliente, $comision = null,
        $visible = 'SI',$comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
        $fecha_actual, $col1 = null, $col2 = $folio_anterior, $col3 = null, $col4 = null, $col5 = null, $col6 = null,$col7 = null,
        $col8 = null, $col9 = null, $col10 = null);
        /*  Codigo importacion   */
        if (request()->importacion>0 && request()->importacion!='' && request()->importacion!=null) {
          // dd('xD');
          $importacion = costo_importacion::createCostoImportacion($ins_EdoCta->idestado_cuenta_proveedores, $cliente,
          request()->importacion, 'SI', $fecha_inicio, $fecha_actual);
        }

        //Codigo Anticipo----------------------------------------------------------------Inicio
        if(request('CantidadAnticipoMXN')){


          $fileAnticipo = request()->file('uploadedfile_anticipo');

          if ($fileAnticipo != "" || $fileAnticipo != null) {

            $nombreAnticipo = $fileAnticipo->getClientOriginalName();
            //$extension = pathinfo($nombreAnticipo, PATHINFO_EXTENSION);
            $nombreAnticipo = "P".$ins_EdoCta->idcontacto."_".(date('Y-m-d'))."_Usr_".$usuario_creador."_".$fileAnticipo->getClientOriginalName();
            $archivo_anticipo = 'storage/app/movements/'.$nombreAnticipo;
            Storage::disk('local')->put('/movements/'.$nombreAnticipo,  \File::get($fileAnticipo));
          }else{
            $archivo_anticipo = 'N/A';
          }
          if (request('m_pago_anticipo')==1) { $receptora_agente = 'TP1'; }
          elseif (request('m_pago_anticipo')==3) { $receptora_agente = 'B2'; }
          $edo_cuenta_anticipo = estado_cuenta_proveedores::createEstadoCuentaProveedores('Abono', 'N/A','abono', 'resta',
          $fecha_movimiento, request('m_pago_anticipo'), $ins_EdoCta->saldo,$ins_EdoCta->saldo-request('CantidadAnticipoMXN'), request('CantidadAnticipoMXN'),$serie_general, request('CantidadAnticipoMXN'),$tipo_moneda1,
          $tipo_cambio1, request('CantidadAnticipoMXN'), '', request('CantidadAnticipoMXN'), $receptora_institucion, $receptora_agente, $emisora_institucion, $emisora_agente,
          $tipo_comprobante, request()->n_referencia_anticipo, $marca, $version, $color, $modelo, $vin, $cargo, $estado_unidad, $asesor11,$enlace11,
          $asesor22, $enlace22, $coach = null ,   $archivo_entregado = $archivo_anticipo, request('ComentariosAnticipo'), $cliente, $comision = 'NO', $visible = 'SI',
          $comentarios_eliminacion = null, $usuario_elimino = null,$fecha_eliminacion = null, $usuario_creador, $fecha_inicio,
          $fecha_actual, $referencia, $folio_anterior = "", $col3 = null, $col4 = null, $col5 = null, $col6 = null,
          $col7 = null, $col8 = null, $col9 = null, $col10 = null);

          /*$Anticipo = documentos_pagar::createDocumentosPagar(
            'Abono',
            request('CantidadAnticipoMXN'),
            request('fechapago_venta1'),
            'Virtual',
            $estatus = 'Pagado',
            $archivo_anticipo,
            $archivo_entregado = '#',
            request('ComentariosAnticipo'),
            $ins_EdoCta->idestado_cuenta_proveedores,
            $usuario_creador,
            $fecha_actual,
            $visible = 'SI'
          );*/

          $ins_abono_unidad = abonos_unidades_proveedores::createAbonosUnidadesProveedores(
            'Abono', request('CantidadAnticipoMXN'),request('CantidadAnticipoMXN'),0, '', request('CantidadAnticipoMXN'),
            $receptora_institucion, $receptora_agente,$emisora_institucion, $emisora_agente, request('comprobante_anticipo'), request('n_referencia_anticipo'),
            request('m_pago_anticipo'), $fecha_movimiento,$marca, $version, $color, $modelo, $precio_u, $vin, $archivo_anticipo,
            request('ComentariosAnticipo'),$ins_EdoCta->idestado_cuenta_proveedores, $usuario_creador, $fecha_inicio, $fecha_actual, $visible = 'SI',
            $edo_cuenta_anticipo->idestado_cuenta_proveedores,$tipo_moneda1, $tipo_cambio1, request('CantidadAnticipoMXN')/$tipo_cambio1);

              /*$documentos_pagar_abonos_unidades_proveedores = documentos_pagar_abonos_unidades_proveedores::createDocumentosPagarAbonosUnidadesProv(
              $Anticipo->iddocumentos_pagar,$ins_abono_unidad->idabonos_unidades_proveedores, request('CantidadAnticipoMXN'),
              request('CantidadAnticipoMXN'), \Carbon\Carbon::now());

              $abonos_pagares_proveedores = abonos_pagares_proveedores::createAbonoPagaresProveedores(request('CantidadAnticipoMXN'),
              request('CantidadAnticipoMXN'), 0,'N/A', request('CantidadAnticipoMXN'),
              $receptora_institucion,$receptora_agente,$emisora_institucion,$emisora_agente,request('comprobante_anticipo'),request('n_referencia_anticipo'),request('m_pago_anticipo'),$fecha_movimiento,$archivo_anticipo,
              request('ComentariosAnticipo'),$Anticipo->iddocumentos_pagar,$usuario_creador,$fecha_inicio, $fecha_actual,'SI',$edo_cuenta_anticipo->idestado_cuenta_proveedores,
              $tipo_moneda1,$tipo_cambio1,request('CantidadAnticipoMXN')/$tipo_cambio1);*/
              // dd($abonos_pagares_proveedores);
              // return $abonos_pagares_proveedores;

              if(request('m_pago_anticipo') == 1){
                $recibos_proveedores = recibos_proveedores::createRecibosProveedores($fecha_movimiento, request('CantidadAnticipoMXN'), $emisora_institucion,
                $emisora_agente, $receptora_institucion, $receptora_agente, 'Abono', request('m_pago_anticipo'), request('n_referencia_anticipo'),
                request('ComentariosAnticipo'),$ins_EdoCta->idestado_cuenta_proveedores, null, $cliente, $usuario_creador, null, $fecha_actual,
                $tipo_moneda1, $tipo_cambio1,request('CantidadAnticipoMXN')/$tipo_cambio1);

                $comprobante_transferencias = comprobantes_transferencia::createComprobantesTransferencia(
                  $concepto, $fecha_movimiento, \Carbon\Carbon::now()->format('Ymd').'/'.$ins_EdoCta->idestado_cuenta_proveedores.'/'.$usuario_creador.'/'.\Auth::user()->idempleados, 'Aplicado', $cliente, 'Proveedor', $vin,
                  $receptora_institucion, $receptora_agente, $emisora_institucion, $emisora_agente, $tipo_comprobante, $referencia,
                  request('m_pago_anticipo'), $tipo_moneda1, $tipo_cambio1, request('m_pago_anticipo')*$tipo_cambio1, '', 'Administracion de Compras', '', $ins_EdoCta->idestado_cuenta_proveedores, 'estado_cuenta_proveedores',
                  'SI', 'Anticipo a proveedor', InfoConectionController::getIp(), request()->coordenadas, \Auth::user()->idempleados, $usuario_creador, $fecha_actual, $fecha_movimiento,
                  request('m_pago_anticipo'), 'Abono'
                );
                $fecha_recibo = new \DateTime($recibos_proveedores->fecha_guardado);
                $num_random = rand(1,10000);
                $id_generic_voucher = $cliente."/".$fecha_recibo->format('Ymdhms')."/".$usuario_creador."/".\Auth::user()->idempleados."/".$recibos_proveedores->idrecibos_proveedores."/".$num_random;
                $route = route('vouchers.viewVoucher',['','']).'/view/'.$comprobante_transferencias->idcomprabantes_transferencia;
                $comprobante_transferencias->url =$route;
                $comprobante_transferencias->referencia=$id_generic_voucher;
                $comprobante_transferencias->saveOrFail();
                $recibos_proveedores->referencia = $id_generic_voucher;
                $recibos_proveedores->saveOrFail();
                $edo_cuenta_anticipo->referencia = $id_generic_voucher;
                $edo_cuenta_anticipo->saveOrFail();
                $ins_abono_unidad->referencia = $id_generic_voucher;
                $ins_abono_unidad->saveOrFail();
                // dd($edo_cuenta_anticipo,$ins_abono_unidad,$recibos_proveedores,$comprobante_transferencias);
                // return $comprobante_transferencias;
              }
              // dd($ins_abono_unidad,$Anticipo,$documentos_pagar_abonos_unidades_proveedores,$abonos_pagares_proveedores,$recibos_proveedores);

            }
            //Codigo Anticipo----------------------------------------------------------------Fin

            $Pagares = [];

            if(request()->NumeroPagares > 0){
              for ($i=0; $i < request()->NumeroPagares ; $i++) {


                $file = request()->file('Evidencia_'.$i);

                if ($file != "" || $file != null) {

                  $nombrePagare = $file->getClientOriginalName();
                  $extension = pathinfo($nombrePagare, PATHINFO_EXTENSION);
                  $nombrePagare = "P".$ins_EdoCta->idcontacto."_".(date('Y-m-d'))."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
                  $archivo_original = 'storage/app/Pagares_Limpios/'.$nombrePagare;
                  Storage::disk('local')->put('/Pagares_Limpios/'.$nombrePagare,  \File::get($file));
                  $tipoPagare = 'Físico';
                }else{
                  $tipoPagare = 'Virtual';
                  $archivo_original = 'N/A';
                }


                $Pagares[$i] = documentos_pagar::createDocumentosPagar(
                  ($i+1).'/'.request()->NumeroPagares,
                  request('CantidadPagare_'.$i),
                  request('FechaPagare_'.$i),
                  $tipoPagare,
                  $estatus = 'Pendiente',
                  $archivo_original,
                  $archivo_entregado = '#',
                  request('ComentariosPagare_'.$i),
                  $ins_EdoCta->idestado_cuenta_proveedores,
                  $usuario_creador,
                  $fecha_actual,
                  $visible = 'SI'
                );

                $VerificarFecha = fechas_compromiso_pagrares_proveedores::where('start', 'like', request('FechaPagare_'.$i).'%')->where('tipo', 'pattern')->get();
                if(sizeof($VerificarFecha) == 0){
                  $aux = 0;
                }else{
                  $aux = 20 * sizeof($VerificarFecha);
                }

                $fecha_ini =  new \DateTime(request('FechaPagare_'.$i)." 09:05:00");
                $fecha_ini->add(new \DateInterval('PT' . $aux . 'M'));

                $fecha_fin =  new \DateTime(request('FechaPagare_'.$i)." 09:05:00");
                $fecha_fin->add(new \DateInterval('PT' . 20 . 'M'));

                $monto1 = number_format((float)request('CantidadPagare_'.$i), 2, '.', ',');



                $Proveedores = proveedores::where('idproveedores', $ins_EdoCta->idcontacto)->first();
                $nombre = ucwords($Proveedores->nombre);
                $apellidos = ucwords($Proveedores->apellidos);
                $nombre_completo = $Proveedores->nombre.' '.$Proveedores->apellidos;



                $Vencimiento = fechas_compromiso_pagrares_proveedores::createFechaCompromisoPP(
                  request('ComentariosPagare_'.$i),'',
                  $fecha_ini->format('Y-m-d H:i:s'),$fecha_fin->format('Y-m-d H:i:s'),
                  $ejecutivo = '',$color = 'blue',$Pagares[$i]->iddocumentos_pagar,
                  $usuario_creador,$fecha_actual,$fecha_actual,$archivo = '',
                  $cumplimiento = '',$fecha_real_archivo = '0001-01-01 00:00:00',
                  $fecha_carga_archivo = '0001-01-01 00:00:00',
                  'Vencimiento: $'.$monto1.', '.$ins_EdoCta->idcontacto.'.'.$this->get_initial_chars($nombre_completo).' '.$nombre_completo,
                  $visible = 'SI');

                  $Recordatorio = fechas_compromiso_pagrares_proveedores::createFechaCompromisoPP(
                    $comentarios,'',
                    $fecha_ini->format('Y-m-d H:i:s'),$fecha_fin->format('Y-m-d H:i:s'),
                    $ejecutivo = '',$color = 'green',$Pagares[$i]->iddocumentos_pagar,
                    $usuario_creador,$fecha_actual,$fecha_actual,$archivo = '',
                    $cumplimiento = '',$fecha_real_archivo = '0001-01-01 00:00:00',
                    $fecha_carga_archivo = '0001-01-01 00:00:00',
                    'Recordatorio: $'.$monto1.', '.$ins_EdoCta->idcontacto.'.'.$this->get_initial_chars($nombre_completo).' '.$nombre_completo,
                    $visible = 'SI');
                  }
                }


                //$ins_EdoCta=1;
                if(!$ins_EdoCta){//No se inserto el registro de estado de cuenta
                  return back()->with('error', 'Error al insertar registro en el Estado de cuenta')->withInput();
                }

                $ins_EdoCta = $ins_EdoCta->idestado_cuenta_proveedores;
                $Folio.= $ins_EdoCta;

                $actualizacion = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $ins_EdoCta)->update(['col1' => $Folio]);
                //*************************************************************************************************************************************************************************************************
                //Insertar registro en tabla de orden logistica
                if($orden_logistica == "SI"){//Se debe generar orden logistica
                  $ins_OrdLog = orden_logistica_inventario::createOrdenLogisticaInventario($tipo_unidad, $vin, $marca, $version, $color, $modelo,
                  $ins_EdoCta, $estatus_unidad = 'NO', $tipo = 'Folio', $visible = 'SI', $fecha_inicio, $fecha_actual,
                  $columna_a = null, $columna_b = null, $columna_c = null, $columna_d = null, $columna_e = null);
                }//end if; Se debe generar orden logistica

                $validar_ab = $this->validar_abono($cliente, $vin);

                if ($validar_ab == True) { #Si el Vin No estA COMO Apartado

                  $ECP = estado_cuenta_proveedores::where('datos_vin', $vin)->where('concepto', 'Apartado')->where('visible', 'SI')->where('col1', '')->first();

                  $concepto_a = $ECP->concepto;
                  $cantidad_a = $ECP->monto_precio;
                  $cantidad_pendiente_a = $monto_precio - $cantidad_a;
                  $metodo_pago = $ECP->metodo_pago;
                  $emisora_institucion_ap = $ECP->emisora_institucion;
                  $emisora_agente_ap = $ECP->emisora_agente;
                  $receptora_institucion_ap = $ECP->receptora_institucion;
                  $receptora_agente_ap = $ECP->receptora_agente;
                  $tipo_comprobante_ap = $ECP->tipo_comprobante;
                  $referencia_ap = $ECP->referencia;
                  $fecha_pago = $ECP->fecha_movimiento;
                  $archivo_ap = $ECP->archivo;
                  $comentarios_ap = $ECP->comentarios;
                  $idestado_cuenta_movimiento = $ECP->idestado_cuenta_proveedores;
                  $tipo_moneda_ap = $ECP->tipo_moneda;
                  $tipo_cambio_ap = $ECP->tipo_cambio;


                  $AbonoUP = abonos_unidades_proveedores::createAbonosUnidadesProveedores( $concepto_a, $monto_precio, $cantidad_a, $cantidad_pendiente_a,
                  $serie_monto = 'N/A', $cantidad_a, $emisora_institucion_ap, $emisora_agente_ap, $receptora_institucion_ap, $receptora_agente_ap,
                  $tipo_comprobante_ap, $referencia_ap, $metodo_pago, $fecha_pago, $datos_marca = '', $datos_version= '', $datos_color= '',
                  $datos_modelo= '', $datos_precio= '', $datos_vin= '', $archivo_ap, $comentarios_ap, $ins_EdoCta, $usuario_creador, $fecha_inicio,
                  $fecha_actual, $visible = 'SI', $idestado_cuenta_movimiento, $tipo_moneda_ap, $tipo_cambio_ap, $cantidad_a);

                  $resulty2 = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $idestado_cuenta_movimiento)->update(['col1' => $Folio , 'col2' => $folio_anterior ]);
                }//end if; Si el Vin No estA COMO Apartado

                $c1=base64_encode($cliente);

                DB::commit();
                return back()->with('success','Movimiento Guardado Exitosamente');
                // dd($c1);
                /*echo "<script language='javascript' type='text/javascript'>
                alert('Movimiento Guardado Exitosamente');
                document.location.replace('estado_cuenta.php?idc=$c1');
                </script>";*/
                //echo "<br>$sql<br>$ins_OrdLog";
                //echo $sql10;
              }//end if; El concepto del movimiento es una compra

              return back()->with('error','Sucedio algo inesperado '.$concepto)->withInput();

            } catch (\Exception $e) {
              DB::rollback();
              return $e;
              return back()->with('error',$e->getMessage())->withInput();
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

          public function show($id_contacto,$id_movimiento){

            $id_contacto = base64_decode($id_contacto);
            $id_movimiento = base64_decode($id_movimiento);

            return redirect()->route('shopping_entrance.index',[
              'idconta' => $id_contacto,
              'fecha_inicio' => 'eyJpdiI6ImwyY3FaVmxzeU5HdzE0OGp6QjVrYWc9PSIsInZhbHVlIjoiTmxsS1ArZldjVjZSZkx3aEhWMTl6akhEZkJ5ZGpTeHRUcFwvMWZ2Z01MY2s9IiwibWFjIjoiZjJmMjNkMmU2ZmU1NTZmYzA5YmZkMjI2NGZlMjY3Y2ViN2U3MGQzNzNlODM1NTdhMjEyOTAxMTgxNzlmOWIwMyJ9'
              ])->with(['Anticipo' => $id_movimiento]);


            }

            public function validar_abono($cliente,$vin){
              $EstadoCp = estado_cuenta_proveedores::where('idcontacto', $cliente)->where('concepto', 'Apartado')->where('visible', 'SI')->where('datos_vin', $vin)->get();
              return sizeof($EstadoCp) != 0;
            }

            public function BuscarVinRepetido(){

              $EstadoCp = estado_cuenta_proveedores::where('datos_vin', request()->VIN)->first();
              if($EstadoCp){
                return json_encode('NO');
              }else{
                return json_encode('SI');
              }

            }


          }
