<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\GlobalFunctionsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\proveedores;
use App\Models\bancos_emisores;
use App\Models\catalogo_cobranza;
use App\Models\estado_cuenta;
use App\Models\estado_cuenta_proveedores;
use App\Models\estado_cuenta_orden_fechas_proveedores;
use App\Models\asesores;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\documentos_pagar;
use App\Models\credito_tipos;
use App\Models\catalogo_tesorerias;
use App\Models\abonos_pagares_proveedores;
use App\Models\contactos;
use App\Models\catalogo_metodos_pago;
use App\Models\catalogo_comprobantes;
use App\Models\abonos_unidades_proveedores;
use App\Models\usuarios;
use Mpdf\Mpdf; #Php 7.0
use App\Models\inventario_orden_proveedores_clientes;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AccountStatusController extends Controller
{

      public function __construct(){
        $this->middleware('auth');
      }

      public function showAccountStatus($id_proveedor){
          $proveedor=proveedores::where('idproveedores',$id_proveedor)->get()->first();
          $bancos_emisores=bancos_emisores::all();
          $usuario_creador = request()->cookie('usuario_creador');//usuario clave
          $id_empleado = request()->cookie('user');//id_empleado
          $catalogo_cobranza = catalogo_cobranza::where('idcatalogo_cobranza','!=','6')->where('idcatalogo_cobranza','!=','8')->get();
          $estado_cuenta_proveedores = estado_cuenta_proveedores::where('idcontacto',$proveedor->idproveedores)->where('visible','SI')->get()->groupBy('referencia');


          $saldo_nuevo = 0; $saldo_ant = 0;

          foreach ($estado_cuenta_proveedores as $Referencia => $EstadosCuenta) {

              $PrecioTotal = array('USD' => 0,'MXN' => 0,'CAD' => 0);


              foreach ($EstadosCuenta as $NumEstadoC => $ECP) {

                  $PrecioTotal[$ECP->tipo_moneda] += floatval($ECP->monto_precio);

                  $usuario = usuarios::where('idusuario',$ECP->usuario_creador)->get()->first();
                  $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->Nombre_UsuarioC = empty($usuario->nombre_usuario) ? 'N/A':$usuario->nombre_usuario;


                  $texto_doc_cobrar="";
                  if($ECP->searchDocumentosPagar() != null || !empty($ECP->searchDocumentosPagar())){
                      $texto_doc_cobrar="<hr><a href='#'><i class='fa fa-archive' aria-hidden='true'></i></a>";
                  }

                  if ($ECP->concepto=="Compra Directa" || $ECP->concepto=="Compra Permuta" || $ECP->concepto=="Cuenta de Deuda" || $ECP->concepto=="Consignacion" || $ECP->concepto=="Devolución del VIN" || $ECP->concepto=="Gastos Diversos de Financiamiento" || $ECP->concepto=="Traspaso-C") {
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->concepto="<a href='".route('account.summary.index',['id'=>$ECP->idestado_cuenta_proveedores])."' style='text-shadow: 5px 5px 5px ".( $ECP->datos_estatus == "Pagada" ?  '#52ef90': '#ef5353'  ).";'>$ECP->concepto</a>";
                  }else if($ECP->concepto=="Anticipo de Comision"){
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->concepto="<a href='#'\" style=\"text-shadow: 5px 5px 5px ".( $ECP->datos_estatus =="Pendiente" ? '#ef5353':'#52ef90' ).";\">$ECP->concepto</a>";
                  }



                  $saldo_letras = GlobalFunctionsController::convertir($ECP->monto_precio, $ECP->tipo_moneda);
                  $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->monto_precio = '$'.number_format(floatval($ECP->monto_precio),2).'('.$saldo_letras.')';

                  if ($ECP->monto_total != "") {
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->monto_total = number_format(floatval($ECP->monto_total),2);
                  }else if($ECP->concepto == "Compra Directa" || $ECP->concepto == "Compra Permuta" || $ECP->concepto == "Cuenta de Deuda"){
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->monto_total = $ECP->datos_precio;
                  }else{
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->monto_total = "N/A";
                  }

                  if ($ECP->tipo_comprobante=="Recibo Automático") {
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->tipo_comprobante=" <a href='#' title='Ver Recibo' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                  }

                  if ($ECP->archivo == "#") {
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->archivo = "<a href='#' title='Subir Recibo Firmado' target=''<i class='fa fa-upload'></i></a>";
                  }else{
                      $estado_cuenta_proveedores[$Referencia][$NumEstadoC]->archivo="<a href='".url('/').'/'.$ECP->archivo."' target='_blank'><i class='fa fa-file'></i></a>";
                  }

              }

              $Temp = (object)[];
              $Temp->Empalme = sizeof($EstadosCuenta) > 1 ? $PrecioTotal:null;
              $Temp->EstadosC = (object)$estado_cuenta_proveedores[$Referencia];

              unset($estado_cuenta_proveedores[$Referencia]);

              $estado_cuenta_proveedores[$Referencia] = $Temp;
          }

          //return $estado_cuenta_proveedores;
          return view('admin.account_status.show',compact('proveedor','id_proveedor','usuario_creador','id_empleado','catalogo_cobranza','estado_cuenta_proveedores'));
      }

      public function pdfAccountStatusProviderInternal($id_proveedor){
          $usuario_creador = request()->cookie('usuario_creador');
          $id_empleado = request()->cookie('user');
          $proveedor=proveedores::where('idproveedores',$id_proveedor)->get();
          $asesor = asesores::where('idasesores',$proveedor->first->asesor)->get()->first();
          $credito_tipos = credito_tipos::where('idcredito_tipos',$proveedor->first->tipo_credito);

          /*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
          $saldo_total = 0;
          $saldos = 0;
          $count_principal_general=0;
          $count_principal_general_x=0;
          $fin = "";
          $fin = "antes finiquito";
          $reci=$id_proveedor;
          $id_contacto=$id_proveedor;
          $n1=strlen($id_contacto);
          $n1_aux=6-$n1;
          $mat="";
          for ($i=0; $i <$n1_aux ; $i++) {
              $mat.="0";
          }
          $id_contacto_completo=$mat.$id_contacto;

          $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

          date_default_timezone_set('America/Mexico_City');
          $date = date_create();
          $dia = date_format($date, 'd');
          $mes_aux = date_format($date, 'm');
          $mes = ucfirst($meses[$mes_aux-1]);
          $ano = date_format($date, 'Y');
          $hora = date_format($date, 'H:i:s');
          $calle = "";
          $colonia = "";
          $municipio = ""; $estado = ""; $nombre = ""; $apellidos = ""; $tipo_cliente = "";
          /*Start Contactos*/
          foreach ($proveedor as $key => $value) {
              $nombre = GlobalFunctionsController::convertirTildesCaracteres($value->nombre);
              $apellidos = GlobalFunctionsController::convertirTildesCaracteres($value->apellidos);
              $alias = GlobalFunctionsController::convertirTildesCaracteres($value->alias);
              $correo = GlobalFunctionsController::convertirTildesCaracteres($value->email);
              $telefono1 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_celular);
              $telefono2 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_otro);
              $calle = GlobalFunctionsController::convertirTildesCaracteres($value->calle);
              $colonia = GlobalFunctionsController::convertirTildesCaracteres($value->colonia);
              $municipio = GlobalFunctionsController::convertirTildesCaracteres($value->delmuni);
              $estado = GlobalFunctionsController::convertirTildesCaracteres($value->estado);

              $linea_credito = $value->linea_credito;
              if($value->linea_credito != "N/A") $linea_credito = "$ ".number_format($value->linea_credito,2);
              /*Start Converción de telefonos*/
              if ($telefono1 == "0000000000") {
                  $telefono1 = "N/A";
              }
              if ($telefono2 == "0000000000") {
                  $telefono2 = "N/A";
              }
              /*End Conversión telefonos*/
              /*Start conversión dirección*/
              if ($calle != "") {
                  $calle_v = $calle.", ";
              }

              if ($colonia != "") {
                  $colonia_v = $colonia.", ";
              }
              /*End conversión dirección*/
              /*Start nomenclaturas*/

              $tipo_cliente="P";
              $tipo_credito = "";
              /*End nomenclaturas*/
          }
          /*End Contactos*/

          //*************************************************************************************************************************************************************************************************************************************************************
          /*End Contactos*/
          estado_cuenta_orden_fechas_proveedores::truncate();
          $domicilio_completo="";
          if(!empty($calle)) $domicilio_completo.=ucfirst($calle).", ";
          if(!empty($colonia)) $domicilio_completo.=ucfirst($colonia).", ";
          if(!empty($municipio))$domicilio_completo.=ucfirst($municipio).", ";
          $domicilio_completo.=ucfirst($estado);

          $count_orden = estado_cuenta_orden_fechas_proveedores::fillReportAccountStatusProviderInternal($id_proveedor);
          //*************************************************************************************************************************************************************************************************************************************************************


          $idestado_cuenta_general = "";
          $COUNT=0;
          $bandera = false;
          $contador =0;
          $count_verifica_mov = 0;
          $ref = "";
          $contador=0;
          $tabla_movimientos = (object)['tabla'=>null,'cargos'=>0, 'abonos'=>0];
          $estado_cuenta_proveedores = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->get();
          $num_unidades = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->get()->groupBy('datos_vin')->count();
          foreach($estado_cuenta_proveedores as $estado) {
              $contador++;
              $date = date_create($estado->fecha_movimiento);
              $fecha_bien=date_format($date, 'd-m-Y');
              $this->imprimir($estado->idestado_cuenta_proveedores, $estado->monto_precio, $id_contacto, $contador, $fecha_bien, $tabla_movimientos);
          }

          $pdf_type="estado_cuenta_interno";
          $view=View::make('admin.account_status.account_state_providers_pdf',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesor','tabla_movimientos','pdf_type','num_unidades'));
          GlobalFunctionsController::createPdf($view, $nombre, $apellidos, $id_contacto_completo, "admon_compras", "estado_cuenta_compras","","");
          return view('admin.account_status.account_state_providers_pdf',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesor','tabla_movimientos','pdf_type','num_unidades'));
      }

      public function pdfAccountStatusProviders($id_proveedor){
          $usuario_creador = request()->cookie('usuario_creador');
          $id_empleado = request()->cookie('user');
          $proveedor=proveedores::where('idproveedores',$id_proveedor)->get();
          $asesor = asesores::where('idasesores',$proveedor->first->asesor)->get()->first();
          $credito_tipos = credito_tipos::where('idcredito_tipos',$proveedor->first->tipo_credito);
          $estado_cuenta_proveedores = estado_cuenta_proveedores::where('idcontacto',$id_proveedor)->where('visible','SI')->orderBy('fecha_movimiento','ASC')->get();

          /***********************************************************************************************************************************************/
          /***********************************************************************************************************************************************/
          $saldo_total = 0;
          $saldos = 0;

          $count_principal_general=0;
          $count_principal_general_x=0;
          $fin = "";
          $fin = "antes finiquito";
          $reci=$id_proveedor;
          $id_contacto=$id_proveedor;
          $n1=strlen($id_contacto);
          $n1_aux=6-$n1;
          $mat="";
          for ($i=0; $i <$n1_aux ; $i++) {
              $mat.="0";
          }
          $id_contacto_completo=$mat.$id_contacto;

          $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

          date_default_timezone_set('America/Mexico_City');
          $date = date_create();
          $dia = date_format($date, 'd');
          $mes_aux = date_format($date, 'm');
          $mes = ucfirst($meses[$mes_aux-1]);
          $ano = date_format($date, 'Y');
          $hora = date_format($date, 'H:i:s');
          /*Start Contactos*/
          $proveedor = proveedores::where('idproveedores',$id_contacto)->get()->first();
          // dd($proveedor);
          if(!empty($proveedor->nombre))$nombre = GlobalFunctionsController::convertirTildesCaracteres($proveedor->nombre);else $nombre = "";
          if(!empty($proveedor->apellidos))$apellidos = GlobalFunctionsController::convertirTildesCaracteres($proveedor->apellidos);else $apellidos = "";
          if(!empty($proveedor->alias))$alias = GlobalFunctionsController::convertirTildesCaracteres($proveedor->alias);else $alias="";
          if(!empty($proveedor->email))$correo = $proveedor->email;else $correo ="";
          if(!empty($proveedor->telefono_celular))$telefono1 = $proveedor->telefono_celular;else $telefono1 = "";
          if(!empty($proveedor->telefono_otro))$telefono2 = $proveedor->telefono_otro;else $telefono2 = "";
          if(!empty($calle))$calle = GlobalFunctionsController::convertirTildesCaracteres($proveedor->calle);else $calle ="";
          if(!empty($proveedor->colonia))$colonia = GlobalFunctionsController::convertirTildesCaracteres($proveedor->colonia);else $colonia ="";
          if(!empty($proveedor->delmuni))$municipio = GlobalFunctionsController::convertirTildesCaracteres($proveedor->delmuni);else $municipio = "";
          if(!empty($proveedor->estado))$estado = GlobalFunctionsController::convertirTildesCaracteres($proveedor->estado);else $estado = "";
          // if(!empty($proveedor->procedencia))$procedencia_proveedor = GlobalFunctionsController::convertirTildesCaracteres($proveedor->procedencia);else $procedencia_proveedor = "";
          // if(!empty($proveedor->tipo_unidad))$tipo_unidades = GlobalFunctionsController::convertirTildesCaracteres($proveedor->tipo_unidad);else $tipo_unidades = "";
          if(!empty($proveedor->linea_credito))$linea_credito = "$ ".number_format((float)$proveedor->linea_credito,2);else $linea_credito ="";

          /*Start Converción de telefonos*/
          if ($telefono1 == "0000000000") {$telefono1 = "N/A";}
          if ($telefono2 == "0000000000") {$telefono2 = "N/A";}
          /*End Conversión telefonos*/
          /*Start conversión dirección*/
          if ($calle != "") {$calle_v = $calle.", ";}
          if ($colonia != "") {$colonia_v = $colonia.", ";}
          /*End conversión dirección*/
          /*Start nomenclaturas*/
          if(!empty($proveedor->asesor))$result1 = asesores::where('idasesores',$proveedor->asesor)->get()->first();
          if(!empty($result1->nomeclatura))$asesor = $result1->nomeclatura;

          $tipo_cliente="P";
          if(!empty($proveedor->tipo_credito))$result3 = credito_tipos::where('idcredito_tipos',$proveedor->tipo_credito)->get()->first();
          $tipo_credito = "";
          if(!empty($result3))$tipo_credito = $result3->nombre;
          /*End nomenclaturas*/

          /*End Contactos*/
          estado_cuenta_orden_fechas_proveedores::truncate();
          /*Datos complementarios de dirección*/
          $domicilio_completo="";
          if(!empty($calle)) $domicilio_completo.=ucfirst($calle).", ";
          if(!empty($colonia)) $domicilio_completo.=ucfirst($colonia).", ";
          if(!empty($municipio))$domicilio_completo.=ucfirst($municipio).", ";
          $domicilio_completo.=ucfirst($estado);
          // dd($calle,$colonia, $estado, $municipio, $domicilio_completo);
          $count_orden = estado_cuenta_orden_fechas_proveedores::fillReportAccountStatusProvider($id_contacto);
          //*************************************************************************************************************************************************************************************************************************************************************
          $idestado_cuenta_general = "";
          $COUNT=0;
          $bandera = false;
          $contador =0;
          $count_verifica_mov = 0;
          $ref = ""; $ref_band = ""; $ref_empalmar ="";

          $verificar_array = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('referencia','!=','S/N')->where('referencia','!=','N/A')->get();
          $message_array = collect();
          foreach ($verificar_array as $key => $value_verify_1) {
              foreach ($verificar_array as $key => $value_verify_2) {
                  if($value_verify_1->referencia == $value_verify_2->referencia && $value_verify_1->idestado_cuenta_orden_fechas_proveedores != $value_verify_2->idestado_cuenta_orden_fechas_proveedores){
                      if($value_verify_1->metodo_pago == $value_verify_2->metodo_pago){
                          if($value_verify_1->emisora_institucion == $value_verify_2->emisora_institucion){
                              if($value_verify_1->tipo_movimiento == $value_verify_2->tipo_movimiento){
                                  if($value_verify_1->receptora_institucion != $value_verify_2->receptora_institucion){
                                      // return redirect()->back()->with('error','Los datos de la referencia '.$value_verify_1->referencia.' NO coincide la institucion receptora para crear el reporte.');
                                      $message_array->push('Los movimientos con la misma referencia '.$value_verify_1->referencia.' NO coincide la institucion receptora.<br>Receptora 1: '.$value_verify_1->receptora_institucion.' Receptora 2: '.$value_verify_2->receptora_institucion);
                                  }
                              } else{
                                  // return redirect()->back()->with('error','Los datos de la referencia '.$value_verify_1->referencia.' NO coincide el tipo de movimiento para crear el reporte.');
                                  $message_array->push('Los movimientos con la misma referencia '.$value_verify_1->referencia.' NO coincide el tipo de movimiento.<br>Movimiento 1: '.$value_verify_1->tipo_movimiento.' Movimiento 2: '.$value_verify_2->tipo_movimiento);
                              }
                          } else {
                              // return redirect()->back()->with('error','Los datos de la referencia '.$value_verify_1->referencia.' NO coincide la institucion emisora para crear el reporte.');
                              $message_array->push('Los movimientos con la misma referencia '.$value_verify_1->referencia.' NO coincide la institucion emisora.<br>Emisora 1: '.$value_verify_1->emisora_institucion.' Emisora 2: '.$value_verify_2->emisora_institucion);
                          }
                      }else{
                          // return redirect()->back()->with('error','Los datos de la referencia '.$value_verify_1->referencia.' NO coincide el metodo de pago para crear el reporte.');
                          $message_array->push('Los movimientos con la misma referencia '.$value_verify_1->referencia.' NO coincide el metodo de pago.<br>Metodo de pago 1:'.$value_verify_1->metodo_pago.' Metodo de pago 2:'.$value_verify_2->metodo_pago);
                      }
                  }
              }
              if($value_verify_1->metodo_pago == 1) {
                  if($value_verify_1->emisora_agente != "TP1" && $value_verify_1->emisora_agente != "PDP") {
                      // return redirect()->back()->with('error','El metodo de pago 1 de la referencia '.$value_verify_1->referencia.' NO coincide con la institución emisora TP1.');
                      $message_array->push('El metodo de pago 1 de la referencia '.$value_verify_1->referencia.' NO coincide con la institución emisora TP1 o PDP.<br>Emisora almacenada '.$value_verify_1->emisora_agente.'.<br>');
                  }
              }
              if($value_verify_1->metodo_pago == 3){
                  if($value_verify_1->emisora_agente != "B1" && $value_verify_1->emisora_agente != "B2" && $value_verify_1->emisora_agente != "B3" && $value_verify_1->emisora_agente != "B4" &&
                  $value_verify_1->emisora_agente != "PDP"){
                      // return redirect()->back()->with('error','El metodo de pago 3 de la referencia '.$value_verify_1->referencia.' NO coincide con la institución emisora B1,B2,B3,B4.');
                      $message_array->push('El metodo de pago 3 de la referencia '.$value_verify_1->referencia.' NO coincide con la institución emisora B1,B2,B3,B4 o PDP.<br>Emisora almacenada '.$value_verify_1->emisora_agente.'.');
                  }
              }
          }
          if(!$message_array->isEmpty()) {
              return redirect()->back()->with('error_array',$message_array);
          }


          $num_unidades = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->get()->groupBy('datos_vin')->count();
          $result101 =  estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('referencia','!=','S/N')->where('referencia','!=','N/A')->get();
          foreach($result101->groupBy('referencia') as $key => $value_concat1) {
              $ref .= $value_concat1[0]->referencia.",";
              $ref_band .= "NO".","; $flag = "";
              foreach ($result101 as $key => $value_concat2) {
                  if($value_concat1[0]->referencia == $value_concat2->referencia && $value_concat1[0]->idestado_cuenta_orden_fechas_proveedores != $value_concat2->idestado_cuenta_orden_fechas_proveedores){
                      if($value_concat1[0]->metodo_pago != $value_concat2->metodo_pago){
                          $ref .= $value_concat2->referencia.",";
                          $ref_band .= "NO".","; $flag = "entro_if";
                          $id = $value_concat1[0]->idestado_cuenta_orden_fechas_proveedores;
                          $ref_empalmar .= "$id".","; $ref_empalmar .= "$value_concat2->idestado_cuenta_orden_fechas_proveedores".",";
                      }
                  }
              }
              if($flag != "entro_if") $ref_empalmar .= "SI".",";
          }
          // $result101 =  estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('referencia','!=','S/N')->where('referencia','!=','N/A')->get()->groupBy('referencia');
          // foreach($result101 as $value_concat1) {
          //     $ref .= $value_concat1[0]->referencia.",";
          //     $ref_band .= "NO".",";
          // }
          $ref_total = rtrim($ref,',');
          $ref_bandera = rtrim($ref_band,',');
          $ref_emp = rtrim($ref_empalmar,',');
          $referencia_array = explode(",", $ref_total);
          $referencia_bandera = explode(",", $ref_bandera);
          $referencia_empalmar = explode(",", $ref_emp);
          // dd($referencia_array, $referencia_bandera, $referencia_empalmar);
          $result100 = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->orderBy('orden','ASC')->get();
          $tabla_movimientos = (object)['tabla'=>null, 'cargos'=>0, 'abonos'=>0];
          foreach($result100 as $fila100) {
              $mov_anulados = "";
              $referencia	= $fila100->referencia;
              $count_verifica_mov++;
              if ($fila100->referencia != "N/A" && $bandera == false || $fila100->referencia != "S/N" && $bandera == false || $fila100->referencia != "N/A" && $bandera != false || $fila100->referencia != "S/N" && $bandera != false) {
                  for ($i=0; $i < sizeof($referencia_array) ; $i++) {
                      if ($referencia_array[$i]=== $referencia && $referencia_bandera[$i] === "NO") {
                          $referencia_bandera[$i] = "SI";
                          if($referencia_empalmar[$i] == "SI"){
                              $result5 = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('referencia',$referencia)->where('referencia','!=','S/N')->orderBy('referencia','ASC')->get();
                              $count5 = count($result5);
                              $result5 = $result5->sum("monto_precio");
                          }else{
                              $result5 = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('idestado_cuenta_orden_fechas_proveedores',$referencia_empalmar[$i])->where('referencia','!=','S/N')->orderBy('referencia','ASC')->get();
                              $count5 = count($result5);
                              $result5 = $result5->sum("monto_precio");
                          }
                          // echo $count5."---".$result5."<br><br>";
                          $bandera = true;
                          $contador++;
                          $mov_anulados = $count5;
                          $count_verifica_mov = 1;

                          // if ($procedencia_proveedor == 'USA') {
                          // $mnt_total=$fila100->gran_total;
                          // }else{
                          $mnt_total=$result5;
                          // }
                          $this->imprimirEstadoCuentaProveedores($fila100->idestado_cuenta_orden_fechas_proveedores, $mnt_total, $id_contacto, $contador, "", $tabla_movimientos);
                      }else{

                          $bandera = true;
                      }
                  }

              }
              if ($fila100->referencia === "N/A" || $fila100->referencia === "S/N") {
                  $fv = date_create($fila100->fecha_movimiento);
                  $fv = date_format($fv, "d-m-Y");
                  $bandera = false;
                  $contador++;
                  // if ($procedencia_proveedor == 'USA') {
                  //    $mnt_total=$fila100->gran_total;
                  // }else{
                  $mnt_total=$fila100->monto_precio;
                  // }
                  $this->imprimirEstadoCuentaProveedores($fila100->idestado_cuenta_orden_fechas_proveedores, $mnt_total, $id_contacto, $contador, $fv, $tabla_movimientos);
              }

              $mov_anulados = $mov_anulados;
              if ($mov_anulados == $count_verifica_mov) {
                  $bandera = false;
              }
          }

          $pdf_type="estado_cuenta";
          $view=View::make('admin.account_status.account_state_providers_pdf',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesor','tabla_movimientos','pdf_type','num_unidades'));
          GlobalFunctionsController::createPdf($view, $nombre, $apellidos, $id_contacto_completo,"admon_compras", "estado_cuenta_compras","");
          return view('admin.account_status.account_state_providers_pdf',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesor','tabla_movimientos','pdf_type','num_unidades'));
      }

      public function promisoryNotesProvider($id_proveedor){
          $id_contacto = $c1 = $reci = $id_proveedor;
          $proveedor= proveedores::where('idproveedores',$id_contacto)->get()->last();
          // $sql20= "SELECT *FROM documentos_pagar WHERE idestado_cuenta IN (SELECT idestado_cuenta_proveedores FROM estado_cuenta_proveedores WHERE idcontacto='$id_contacto')";
          $estado_cuenta_proveedores = estado_cuenta_proveedores::select('idestado_cuenta_proveedores')->where('idcontacto',$id_contacto)->get();
          $documentos_pagar = documentos_pagar::whereIn('idestado_cuenta',$estado_cuenta_proveedores)->get();
          // $documentos_pagar = documentos_pagar::all();



          /***********************************************************************************************************************************/
          $contenido = "";$unico=0;
          foreach($documentos_pagar as $fila1) {
              $monto_precio_formato=number_format($fila1->monto,2);
              $saldo_letras= GlobalFunctionsController::convertir($fila1->monto,$fila1->tipo_moneda);
              $result101=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$fila1->idestado_cuenta)->get();
              foreach($result101 as $fila101) {
                  $vin=$fila101->datos_vin;
                  $nombre_unidad_interno="$fila101->datos_marca $fila101->datos_version $fila101->datos_modelo $fila101->datos_color";
              }
              $url_archivo="$fila1->archivo_original";
              $url_archivo_evidencia="$fila1->archivo_entregado";
              $public_path = public_path()."/documentos_por_pagar/";
              if ($url_archivo=="") {
                  $c10=base64_encode($fila1->iddocumentos_cobrar_proveedores);
                  // $link_archivos="<a href='pagare_original_proveedores.php?idp=$c10&idm=$reci' title='Subir Pagare' target='_blank'><i class='fa fa-upload'></i></a>";
                  $link_archivos="<a href='#' title='Subir Pagare' target='_blank'><i class='fa fa-upload'></i></a>";
              }elseif ($url_archivo=="N/A") {
                  $link_archivos="<i class='fa fa-ban'></i>";
              }else{
                  $link_archivos="<a href='$url_archivo' target='_blank'><i class='fa fa-file'></i></a>";
              }
              if ($fila1->estatus=="Pendiente") {
                  $link_archivos_evidencia="<i class='fa fa-clock-o'></i>";
              }elseif ($url_archivo_evidencia=="" && $fila1->estatus=="Pagado") {
                  $c11=base64_encode($fila1->iddocumentos_pagar);
                  // $link_archivos_evidencia="<a href='pagare_evidencia_proveedores.php?idp=$c11&idm=$reci' title='Subir Evidencia Pagare' target='_blank'><i class='fa fa-upload'></i></a>";
                  $link_archivos_evidencia="<a href='#' title='Subir Evidencia Pagare' target='_blank'><i class='fa fa-upload'></i></a>";
              }else{
                  $link_archivos_evidencia="<a href='$url_archivo' target='_blank'><i class='fa fa-file'></i></a>";
              }
              if ($fila1->estatus=="Pagado") {
                  $link_abono="<a><i class='fa fa-check-circle' aria-hidden='true'></i></a>";
              }else{
                  $unico++;
                  if ($unico==1) {
                      $c2=base64_encode($fila1->iddocumentos_pagar);
                      date_default_timezone_set('America/Mexico_City');
                      $actual= date("Y_m_d__H_i_s");
                      $fecha_actual= date("Y-m-d H:i:s");
                      $fecha=base64_encode($fecha_actual);
                      $link_abono="<a href='".route('account_status.paymentsPromisoryNotesProviders',['id_proveedor'=>$c1,'iddocumentos_pagar'=>$c2])."'><i class='fa fa-money' aria-hidden='true'></i></a>";
                  }else{
                      $link_abono="<i class='fa fa-list' aria-hidden='true'></i>";
                  }
              }
              $result102=abonos_pagares_proveedores::select('cantidad_pendiente','iddocumentos_pagar')->where('iddocumentos_pagar',$fila1->iddocumentos_pagar)->get();;
              if(count($result102)==0){
                  $saldo=$monto_precio_formato;
                  $link_historial="<i class='fa fa-clock-o'></i>";
              }else{
                  foreach($result102 as $fila102) {
                      $c12=base64_encode($fila1->iddocumentos_pagar);
                      $saldo=number_format("$fila102->cantidad_pendiente",2);
                      $link_historial="<a href='".route('account_status.pagaresPagosProveedores',$fila1->iddocumentos_pagar)."'><i class='fa fa-bar-chart' aria-hidden='true'></i></a>";
                  }
              }
              $contenido .= "<tr class='odd gradeX'>
              <td>$link_abono</td>
              <td>$fila1->iddocumentos_pagar | $fila1->num_pagare</td>
              <td>$ $monto_precio_formato<br> ($saldo_letras)</td>
              <td>$fila1->fecha_vencimiento</td>
              <td>$fila1->tipo</td>
              <td>$fila1->estatus</td>
              <td>$ $saldo</td>
              <td>$nombre_unidad_interno</td>
              <td>$vin</td>
              <td>$fila1->comentarios</td>
              <td>$link_archivos</td>
              <td>$link_archivos_evidencia</td>
              <td>$link_historial</td></tr>";
          }
          /***********************************************************************************************************************************/
          return view('admin.account_status.promisory_notes_provider',compact('proveedor','id_contacto','contenido'));
      }

      public function paymentsPromisoryNotesProviders($id_contacto,$iddocumentos_pagar){
          // $recibido2= $_REQUEST["f"];
          date_default_timezone_set('America/Mexico_City');
          $actual= date("Y_m_d__H_i_s");
          $fecha_actual= date("Y-m-d H:i:s");
          $fecha_inicio=base64_encode($fecha_actual);
          $recibido= $id_contacto;
          $idconta=$id_contacto;
          $recibido2= $iddocumentos_pagar;
          $id_reg_pagare=$recibido2;
          //echo "<br>$id_reg_pagare";
          // $sql= "SELECT *FROM proveedores WHERE idproveedores='$idconta'";
          $result=proveedores::where('idproveedores',$idconta)->get();
          foreach( $result as $fila1) {
              $nombre=ucwords("$fila1->nombre");
              $apellidos=ucwords("$fila1->apellidos");
              $nombre_completo="$fila1->nombre $fila1->apellidos";
          }

          // $sql21= "SELECT idestado_cuenta FROM documentos_pagar WHERE iddocumentos_pagar='$id_reg_pagare' and visible = 'SI'";
          $result21=documentos_pagar::where('iddocumentos_pagar',$id_reg_pagare)->where('visible','SI')->get();
          foreach($result21 as $fila21) {
              $id_movimiento="$fila21->idestado_cuenta";
          }

          // $sql10= "SELECT *FROM estado_cuenta_proveedores WHERE idestado_cuenta_proveedores='$id_movimiento' and visible = 'SI'";
          $result10=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$id_movimiento)->where('visible','SI')->get();
          foreach($result10 as $fila10) {
              $id_contacto="$fila10->idcontacto";
              $c10=base64_encode($fila10->idcontacto);
              $nombre_unidad="$fila10->datos_marca $fila10->datos_version $fila10->datos_modelo $fila10->datos_color ";
              $vin_unidad="$fila10->datos_vin";
              $concepto_general="$fila10->concepto";
              $precio_general=number_format("$fila10->datos_precio",2);
              $precio_unidad="$fila10->datos_precio";
              $estatus_unidad="$fila10->datos_estatus";
          }

          $iniciales_cliente="";
          $porciones = explode(" ", $nombre_completo);
          foreach ($porciones as $parte) {
              $iniciales_cliente.=$parte[0];
          }
          $iniciales_cliente=mb_strtoupper($iniciales_cliente);

          // $sql12= "SELECT saldo FROM estado_cuenta_proveedores WHERE idcontacto='$idconta' AND visible = 'SI'";
          $result12=estado_cuenta_proveedores::where('idcontacto',$idconta)->where('visible','SI')->get();
          if(count($result12)==0){
              $saldo_anterior=0;
          }else{
              foreach( $result12 as $fila12) {
                  $saldo_anterior="$fila12->saldo";
              }
          }

          // $sql13= "SELECT cantidad_pendiente FROM abonos_pagares_proveedores WHERE iddocumentos_pagar='$id_reg_pagare' and visible = 'SI'";
          $result13=abonos_pagares_proveedores::where('iddocumentos_pagar',$id_reg_pagare)->where('visible','SI')->get();
          if(count($result13)==0){
              // $sql14= "SELECT monto FROM documentos_pagar WHERE iddocumentos_pagar='$id_reg_pagare' and visible = 'SI'";
              $result14=documentos_pagar::where('iddocumentos_pagar',$id_reg_pagare)->where('visible','SI')->get();
              foreach( $result14 as $fila14) {
                  $saldo_anterior_pagare="$fila14->monto";
              }
          }else{
              foreach( $result13 as $fila13) {
                  $saldo_anterior_pagare="$fila13->cantidad_pendiente";
              }
          }

          // $sql15= "SELECT cantidad_pendiente FROM abonos_unidades_proveedores WHERE idestado_cuenta='$id_movimiento' AND visible = 'SI'";
          //echo "<br>$sql15";
          $result15=abonos_unidades_proveedores::where('idestado_cuenta',$id_movimiento)->where('visible','SI')->get();
          if(count($result15)==0){
              $saldo_anterior_unidad=$precio_unidad;
          }else{
              foreach( $result15 as $fila15) {
                  $saldo_anterior_unidad="$fila15->cantidad_pendiente";
              }
          }

          // $consulta2=mysql_query("SELECT nomeclatura, nombre FROM catalogo_cobranza WHERE idcatalogo_cobranza='3' || idcatalogo_cobranza='24'");
          $catalogo_cobranza=catalogo_cobranza::select('nomeclatura','nombre')->where('idcatalogo_cobranza','3')->orWhere('idcatalogo_cobranza','24')->get();
          // while($registro2=mysql_fetch_row($consulta2)){
          //    echo "<option value='".$registro2[1]."'>".$registro2[0]." ".$registro2[1]."</option>";
          // }
          $catalogo_metodos_pago=catalogo_metodos_pago::select('nomeclatura', 'nombre')->get();
          $bancos_emisores=bancos_emisores::select('nombre')->get();
          $catalogo_tesorerias=catalogo_tesorerias::select('nombre','nomeclatura')->get();
          $bancos_emisores=bancos_emisores::select('nombre')->get();
          $catalogo_comprobantes = catalogo_comprobantes::select('nombre')->get();

          return view('admin.account_status.payments_promisory_notes_providers',
          compact('nombre','apellidos','nombre_unidad','vin_unidad','recibido','catalogo_cobranza','catalogo_metodos_pago',
          'saldo_anterior_pagare','saldo_anterior_unidad','saldo_anterior','idconta','iniciales_cliente','bancos_emisores','catalogo_tesorerias',
          'bancos_emisores','catalogo_comprobantes','id_reg_pagare','fecha_inicio'));
      }

      public function savePaymentsPromisoryNotesProviders(){
        $concepto=request()->concepto_general;                $tipo_movimiento=request()->tipo_general;
        $efecto_movimiento=request()->efecto;                 $fecha_movimiento=request()->fechapago1;
        $metodo_pago=request()->m_pago;                       $saldo_anterior=request()->saldo;
        $monto_abono=request()->monto_abono;                  $saldo=request()->saldo_nuevo;
        $monto_precio=request()->monto_abono;                 $emisora_institucion=request()->emisor;
        $emisora_agente=request()->agente_emisor;             $receptora_institucion=request()->receptor;
        $receptora_agente=request()->agente_receptor;         $tipo_comprobante=request()->comprobante;
        $referencia=request()->n_referencia;                  $comentarios=request()->descripcion;
        $fecha_inicio=request()->fecha_inicio;                $serie_general=request()->serie_general;
        $monto_general=request()->monto_general;              $saldo_anterior_pagare=request()->saldo_pagare;
        $monto_abono_pagare=request()->monto_abono_pagare;    $saldo_pagare=request()->saldo_nuevo_pagare;
        $id_num_pagare=request()->movimiento_general;         $saldo_anterior_unidad=request()->saldo_unidad;
        $monto_abono_unidad=request()->monto_abono_unidad;    $saldo_unidad=request()->saldo_nuevo_unidad;
        $tipo_moneda1=request()->tipo_moneda1;                $tipo_cambio2=request()->tipo_cambio2;
        $monto_abono_pagare=request()->monto_abono_pagare;

        if ($tipo_movimiento=="cargo") {
          $cargo=$monto_abono;
          $abono="";
        }
        if ($tipo_movimiento=="abono") {
          $cargo="";
          $abono=$monto_abono;
        }
        $cliente=request()->contacto_original;
        date_default_timezone_set('America/Mexico_City');
        $actual= date("Y_m_d__H_i_s");
        $fecha_actual= date("Y-m-d H:i:s");
        $usuario_creador = request()->cookie('usuario_creador');//usuario clave
        $id_empleado = request()->cookie('user');//id_empleado
        // dd($usuario_creador, $id_empleado, request()->cookie('usuario_clave'),Auth::user(), request()->cookie());
        // $usuario_creador=$_SESSION['usuario_clave'];
        $usuario_creador=$usuario_creador;
        $target_path = "../../Cobranza_Comprobantes/";
        DB::beginTransaction();
        try {

          if ($tipo_comprobante=="Recibo Automático") {
            echo "AAAAA";
            // $sql10="INSERT INTO estado_cuenta_proveedores (concepto,apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, serie_monto, monto_total, cargo, abono, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, archivo, comentarios, idcontacto, usuario_creador, fecha_creacion, fecha_guardado, tipo_moneda, tipo_cambio, gran_total) VALUES ('$concepto', 'N/A', '$tipo_movimiento', '$efecto_movimiento', '$fecha_movimiento', '$metodo_pago', '$saldo_anterior', '$saldo', '$monto_precio', '$serie_general','$monto_general','$cargo', '$abono', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia','#', '$comentarios','$cliente', '$usuario_creador', '$fecha_inicio','$fecha_actual', '$tipo_moneda1', '$tipo_cambio2', '$monto_abono_pagare');";
            $result5=estado_cuenta_proveedores::create([
              'concepto'=>$concepto,
              'apartado_usado'=>'N/A',
              'tipo_movimiento'=>$tipo_movimiento,
              'efecto_movimiento'=>$efecto_movimiento,
              'fecha_movimiento'=>$fecha_movimiento,
              'metodo_pago'=>$metodo_pago,
              'saldo_anterior'=>$saldo_anterior,
              'saldo'=>$saldo,
              'monto_precio'=>$monto_precio,
              'serie_monto'=>$serie_general,
              'monto_total'=>$monto_general,
              'cargo'=>$cargo,
              'abono'=>$abono,
              'emisora_institucion'=>$emisora_institucion,
              'emisora_agente'=>$emisora_agente,
              'receptora_institucion'=>$receptora_institucion,
              'receptora_agente'=>$receptora_agente,
              'tipo_comprobante'=>$tipo_comprobante,
              'referencia'=>$referencia,
              'archivo'=>'#',
              'comentarios'=>$comentarios,
              'idcontacto'=>$cliente,
              'usuario_creador'=>$usuario_creador,
              'fecha_creacion'=>$fecha_inicio,
              'fecha_guardado'=>$fecha_actual,
              'tipo_moneda'=>$tipo_moneda1,
              'tipo_cambio'=>$tipo_cambio2,
              'gran_total'=>$monto_abono_pagare]);
              // $result5=mysql_query($sql10);
              if (!empty($result5)) {
                $c1=base64_encode($cliente);
                // $query3= mysql_query("SELECT @@identity AS id");
                // if ($row = mysql_fetch_row($query3)){
                // $id2 = trim($row[0]);
                $id2 = $result5->idestado_cuenta_proveedores;
                //Inicio de abono a unidad
                // $sql11="INSERT INTO abonos_pagares_proveedores (
                //    cantidad_inicial, cantidad_pago, cantidad_pendiente, serie_monto, monto_total, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, metodo_pago, fecha_pago, archivo, comentarios, iddocumentos_pagar, usuario_guardo, fecha_creacion, fecha_guardado,visible,idestado_cuenta_movimiento, tipo_moneda, tipo_cambio, gran_total) VALUES ('$saldo_anterior_pagare', '$monto_precio', '$saldo_pagare', '$serie_general', '$monto_general', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia', '$metodo_pago', '$fecha_movimiento', '$archivo_cargado', '$comentarios', '$id_num_pagare', '$usuario_creador', '$fecha_inicio', '$fecha_actual','SI','$id2', '$tipo_moneda1', '$tipo_cambio2', '$monto_abono_pagare')";
                // $result51=mysql_query($sql11);
                $result51=abonos_pagares_proveedores::create([
                  'cantidad_inicial'=>$saldo_anterior_pagare,
                  'cantidad_pago'=>$monto_precio,
                  'cantidad_pendiente'=>$saldo_pagare,
                  'serie_monto'=>$serie_general,
                  'monto_total'=>$monto_general,
                  'emisora_institucion'=>$emisora_institucion,
                  'emisora_agente'=>$emisora_agente,
                  'receptora_institucion'=>$receptora_institucion,
                  'receptora_agente'=>$receptora_agente,
                  'tipo_comprobante'=>$tipo_comprobante,
                  'referencia'=>$referencia,
                  'metodo_pago'=>$metodo_pago,
                  'fecha_pago'=>$fecha_movimiento,
                  'archivo'=>$archivo_cargado,
                  'comentarios'=>$comentarios,
                  'iddocumentos_pagar'=>$id_num_pagare,
                  'usuario_guardo'=>$usuario_creador,
                  'fecha_creacion'=>$fecha_inicio,
                  'fecha_guardado'=>$fecha_actual,
                  'visible'=>'SI',
                  'idestado_cuenta_movimiento'=>$id2,
                  'tipo_moneda'=>$tipo_moneda1,
                  'tipo_cambio'=>$tipo_cambio2,
                  'gran_total'=>$monto_abono_pagare]);

                  if (!empty($result51)) {
                    if ($saldo_pagare==0 || $saldo_pagare=="0" || $saldo_pagare=="0.00") {
                      // $sql12="UPDATE documentos_pagar SET estatus = 'Pagado' WHERE iddocumentos_pagar = '$id_num_pagare'";
                      $result52=documentos_pagar::where('iddocumentos_pagar',$id_num_pagare)->get();
                      $result52->status = 'Pagado';
                      $result52->save();
                    }
                    // Descuento ae unidad
                    // $sql21= "SELECT idestado_cuenta FROM documentos_pagar WHERE iddocumentos_pagar='$id_num_pagare'";
                    $result21=documentos_pagar::where('iddocumentos_pagar',$id_num_pagare)->get();
                    foreach( $result21 as $fila21) {
                      $id_movimiento="$fila21->idestado_cuenta";
                    }
                    //*********************
                    // $sql19="INSERT INTO abonos_unidades_proveedores (concepto,cantidad_inicial, cantidad_pago, cantidad_pendiente, serie_monto, monto_total ,emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, metodo_pago, fecha_pago, archivo, comentarios, idestado_cuenta, usuario_guardo, fecha_creacion, fecha_guardado,visible,idestado_cuenta_movimiento, tipo_moneda, tipo_cambio, gran_total) VALUES ('$concepto','$saldo_anterior_unidad', '$monto_abono_unidad', '$saldo_unidad', '$serie_general', '$monto_general', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia', '$metodo_pago', '$fecha_movimiento', '$archivo_cargado', '$comentarios', '$id_movimiento', '$usuario_creador', '$fecha_inicio', '$fecha_actual','SI','$id2', '$tipo_moneda1', '$tipo_cambio2', '$monto_abono_pagare')";
                    $result19=abonos_unidades_proveedores::create([
                      'concepto'=>$concepto,
                      'cantidad_inicial'=>$saldo_anterior_unidad,
                      'cantidad_pago'=>$monto_abono_unidad,
                      'cantidad_pendiente'=>$saldo_unidad,
                      'serie_monto'=>$serie_general,
                      'monto_total '=>$monto_general,
                      'emisora_institucion'=>$emisora_institucion,
                      'emisora_agente'=>$emisora_agente,
                      'receptora_institucion'=>$receptora_institucion,
                      'receptora_agente'=>$receptora_agente,
                      'tipo_comprobante'=>$tipo_comprobante,
                      'referencia'=>$referencia,
                      'metodo_pago'=>$metodo_pago,
                      'fecha_pago'=>$fecha_movimiento,
                      'archivo'=>$archivo_cargado,
                      'comentarios'=>$comentarios,
                      'idestado_cuenta'=>$id_movimiento,
                      'usuario_guardo'=>$usuario_creador,
                      'fecha_creacion'=>$fecha_inicio,
                      'fecha_guardado'=>$fecha_actual,
                      'visible'=>'SI',
                      'idestado_cuenta_movimiento'=>$id2,
                      'tipo_moneda'=>$tipo_moneda1,
                      'tipo_cambio'=>$tipo_cambio2,
                      'gran_total'=>$monto_abono_pagare]);

                      if (!empty($result19)) {
                        if ($saldo_unidad==0 || $saldo_unidad=="0.00" || $saldo_unidad=="0") {
                          // $sql14="UPDATE estado_cuenta_proveedores SET datos_estatus='Pagada' WHERE idestado_cuenta_proveedores='$id_movimiento'";
                          $result14=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$id_movimiento)->get()->first();
                          $result14->datos_estatus = "Pagada";
                          $result14->save();
                        }
                        // $sql19="INSERT INTO recibos_proveedores (fecha, monto, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, concepto, metodo_pago, referencia, comentarios, id_estado_cuenta, idcontacto, usuario_creador, fecha_guardado, tipo_moneda, tipo_cambio, gran_total) VALUES ('$fecha_movimiento', '$monto_precio', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$concepto', '$metodo_pago', '$referencia', '$comentarios', '$id2', '$cliente', '$usuario_creador', '$fecha_actual' , '$tipo_moneda1', '$tipo_cambio2', '$monto_abono_pagare')";
                        $result19=recibos_proveedores::create([
                          'fecha'=>$fecha_movimiento,
                          'monto'=>$monto_precio,
                          'emisora_institucion'=>$emisora_institucion,
                          'emisora_agente'=>$emisora_agente,
                          'receptora_institucion'=>$receptora_institucion,
                          'receptora_agente'=>$receptora_agente,
                          'concepto'=>$concepto,
                          'metodo_pago'=>$metodo_pago,
                          'referencia'=>$referencia,
                          'comentarios'=>$comentarios,
                          'id_estado_cuenta'=>$id2,
                          'idcontacto'=>$cliente,
                          'usuario_creador'=>$usuario_creador,
                          'fecha_guardado'=>'$fecha_actul',
                          'tipo_moneda'=>$tipo_moneda1,
                          'tipo_cambio'=>$tipo_cambio2,
                          'gran_total'=>$monto_abono_pagare]);
                          if (!empty($result19)) {
                            // $query31= mysql_query("SELECT @@identity AS id");
                            $query31= $result19->idrecibos_proveedores;
                            // if ($row1 = mysql_fetch_row($query31)) {
                            // $id_rec = trim($row1[0]);
                            $id_rec2=$query31->idrecibos_proveedores;
                            echo "<script language='javascript' type='text/javascript'>
                            alert('Movimiento Guardado Exitosamente');
                            window.open('recibo_pdf.php?idrb=$id_rec2','_blank');
                            document.location.replace('estado_cuenta.php?idc=$c1');
                            </script>";
                            // }
                          }else{
                            /*echo "<script language='javascript' type='text/javascript'>
                            alert('Se presento un error al guardar el recibo, valide la información e intente nuevamente');
                            history.go(-1);
                            </script>
                            "; */
                          }
                        }else{
                          /*echo " <script language='javascript' type='text/javascript'>
                          alert('Se presento un error al guardar el abono, valide la información e intente nuevamente');
                          history.go(-1);
                          </script>"; */
                        }
                        // Fin de descuento a unidad
                      }else{
                        echo "<script language='javascript' type='text/javascript'>
                        alert('Se presento un error al guardar el abono de pagare, valide la información e intente nuevamente');
                        history.go(-1);
                        </script>";
                      }
                      //Fin de evento de abono a unidad
                    } //Fin de consulta de ultimo movimiento en estado de cuenta
                    // }else{
                    /*echo "<script language='javascript' type='text/javascript'>
                    alert('Se presento un error al guardar el movimiento, valide la información e intente nuevamente');
                    history.go(-1);</script>";*/
                    // }
                    //Fin Insertar
                  }else{
                    //Proceso con archivo de pormedio..........
                    $target_path = $target_path."C".$cliente."_".$actual."_Usr_".$usuario_creador."_".basename( $_FILES['uploadedfile']['name']);
                    if ($target_path!="../../Cobranza_Comprobantes/") {
                      if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) || $tipo_comprobante=="Recibo Automático") {
                        $archivo_cargado=$target_path;
                        //Inicio de Insertar
                        // $sql10="INSERT INTO estado_cuenta_proveedores (concepto,apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, serie_monto, monto_total, cargo, abono, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, archivo, comentarios, idcontacto, usuario_creador, fecha_creacion, fecha_guardado, tipo_moneda, tipo_cambio, gran_total) VALUES ('$concepto', 'N/A', '$tipo_movimiento', '$efecto_movimiento', '$fecha_movimiento', '$metodo_pago', '$saldo_anterior', '$saldo', '$monto_precio', '$serie_general','$monto_general','$cargo', '$abono', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia','$archivo_cargado', '$comentarios','$cliente', '$usuario_creador', '$fecha_inicio','$fecha_actual', '$tipo_moneda1', '$tipo_cambio2', '$monto_abono_pagare');";


                        // echo "<br>$sql10";
                        $result5=estado_cuenta_proveedores::create([
                          'concepto'=>$concepto,
                          'apartado_usado'=>'N/A',
                          'tipo_movimiento'=>$tipo_movimiento,
                          'efecto_movimiento'=>$efecto_movimiento,
                          'fecha_movimiento'=>$fecha_movimiento,
                          'metodo_pago'=>$metodo_pago,
                          'saldo_anterior'=>$saldo_anterior,
                          'saldo'=>$saldo,
                          'monto_precio'=>$monto_precio,
                          'serie_monto'=>$serie_general,
                          'monto_total'=>$monto_general,
                          'cargo'=>$cargo,
                          'abono'=>$abono,
                          'emisora_institucion'=>$emisora_institucion,
                          'emisora_agente'=>$emisora_agente,
                          'receptora_institucion'=>$receptora_institucion,
                          'receptora_agente'=>$receptora_agente,
                          'tipo_comprobante'=>$tipo_comprobante,
                          'referencia'=>$referencia,
                          'archivo'=>$archivo_cargado,
                          'comentarios'=>$comentarios,
                          'idcontacto'=>$cliente,
                          'usuario_creador'=>$usuario_creador,
                          'fecha_creacion'=>$fecha_inicio,
                          'fecha_guardado'=>$fecha_actual,
                          'tipo_moneda'=>$tipo_moneda1,
                          'tipo_cambio'=>$tipo_cambio2,
                          'gran_total'=>$monto_abono_pagare]);
                          echo "<br>$result5";
                          if (!empty($result5)) {
                            // $query3= mysql_query("SELECT @@identity AS id");
                            $query3 = $result5->idestado_cuenta_proveedores;
                            // if ($row = mysql_fetch_row($query3)){
                            $id2 = $result5->idestado_cuenta_proveedores;
                            // }
                            // $sql11="INSERT INTO abonos_pagares_proveedores (cantidad_inicial, cantidad_pago, cantidad_pendiente, serie_monto, monto_total, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, metodo_pago, fecha_pago, archivo, comentarios, iddocumentos_pagar, usuario_guardo, fecha_creacion, fecha_guardado,visible,idestado_cuenta_movimiento, tipo_moneda, tipo_cambio, gran_total) VALUES ('$saldo_anterior_pagare', '$monto_precio', '$saldo_pagare', '$serie_general', '$monto_general', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia', '$metodo_pago', '$fecha_movimiento', '$archivo_cargado', '$comentarios', '$id_num_pagare', '$usuario_creador', '$fecha_inicio', '$fecha_actual','SI','$id2', '$tipo_moneda1', '$tipo_cambio2', '$monto_abono_pagare')";
                            // $result51=mysql_query($sql11) or die ("Error in query: $query. ".mysql_error());
                            $result51=abonos_pagares_proveedores::create([
                              'cantidad_inicial'=>$saldo_anterior_pagare,
                              'cantidad_pago'=>$monto_precio,
                              'cantidad_pendiente'=>$saldo_pagare,
                              'serie_monto'=>$serie_general,
                              'monto_total'=>$monto_general,
                              'emisora_institucion'=>$emisora_institucion,
                              'emisora_agente'=>$emisora_agente,
                              'receptora_institucion'=>$receptora_institucion,
                              'receptora_agente'=>$receptora_agente,
                              'tipo_comprobante'=>$tipo_comprobante,
                              'referencia'=>$referencia,
                              'metodo_pago'=>$metodo_pago,
                              'fecha_pago'=>$fecha_movimiento,
                              'archivo'=>$archivo_cargado,
                              'comentarios'=>$comentarios,
                              'iddocumentos_pagar'=>$id_num_pagare,
                              'usuario_guardo'=>$usuario_creador,
                              'fecha_creacion'=>$fecha_inicio,
                              'fecha_guardado'=>$fecha_actual,
                              'visible'=>'SI',
                              'idestado_cuenta_movimiento'=>$id2,
                              'tipo_moneda'=>$tipo_moneda1,
                              'tipo_cambio'=>$tipo_cambio2,
                              'gran_total'=>$monto_abono_pagare]);

                              if (!empty($result51)) {
                                if ($saldo_pagare==0 || $saldo_pagare=="0" || $saldo_pagare=="0.00") {
                                  // $sql12="UPDATE documentos_pagar SET estatus = 'Pagado' WHERE iddocumentos_pagar = '$id_num_pagare'";
                                  $result52=documentos_pagar::where('iddocumentos_pagar',$id_num_pagare)->get()->first();
                                  $result52->estatus='Pagado';
                                  $result52->save();
                                }
                                // Descuento ae unidad
                                // $sql21= "SELECT idestado_cuenta FROM documentos_pagar WHERE iddocumentos_pagar='$id_num_pagare'";
                                $result21=documentos_pagar::where('iddocumentos_pagar',$id_num_pagare)->get();
                                foreach( $result21 as $fila21) {
                                  $id_movimiento="$fila21->idestado_cuenta";
                                }
                                // $sql19="INSERT INTO abonos_unidades_proveedores (concepto,cantidad_inicial, cantidad_pago, cantidad_pendiente, serie_monto, monto_total ,emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, metodo_pago, fecha_pago, archivo, comentarios, idestado_cuenta, usuario_guardo, fecha_creacion, fecha_guardado,visible,idestado_cuenta_movimiento, tipo_moneda, tipo_cambio, gran_total) VALUES ('$concepto','$saldo_anterior_unidad', '$monto_abono_unidad', '$saldo_unidad', '$serie_general', '$monto_general', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia', '$metodo_pago', '$fecha_movimiento', '$archivo_cargado', '$comentarios', '$id_movimiento', '$usuario_creador', '$fecha_inicio', '$fecha_actual','SI','$id2', '$tipo_moneda1', '$tipo_cambio2', '$monto_abono_pagare')";
                                $result19=abonos_unidades_proveedores::create([
                                  'concepto'=>$concepto,
                                  'cantidad_inicial'=>$saldo_anterior_unidad,
                                  'cantidad_pago'=>$monto_abono_unidad,
                                  'cantidad_pendiente'=>$saldo_unidad,
                                  'serie_monto'=>$serie_general,
                                  'monto_total' =>$monto_general,
                                  'emisora_institucion'=>$emisora_institucion,
                                  'emisora_agente'=>$emisora_agente,
                                  'receptora_institucion'=>$receptora_institucion,
                                  'receptora_agente'=>$receptora_agente,
                                  'tipo_comprobante'=>$tipo_comprobante,
                                  'referencia'=>$referencia,
                                  'metodo_pago'=>$metodo_pago,
                                  'fecha_pago'=>$fecha_movimiento,
                                  'archivo'=>$archivo_cargado,
                                  'comentarios'=>$comentarios,
                                  'idestado_cuenta'=>$id_movimiento,
                                  'usuario_guardo'=>$usuario_creador,
                                  'fecha_creacion'=>$fecha_inicio,
                                  'fecha_guardado'=>$fecha_actual,
                                  'visible'=>'SI',
                                  'idestado_cuenta_movimiento'=>$id2,
                                  'tipo_moneda'=>$tipo_moneda1,
                                  'tipo_cambio'=>$tipo_cambio2,
                                  'gran_total'=>$monto_abono_pagare]);

                                  if (!empty($result19)) {
                                    if ($saldo_unidad==0 || $saldo_unidad=="0.00" || $saldo_unidad=="0") {
                                      // $sql14="UPDATE estado_cuenta_proveedores SET datos_estatus='Pagada' WHERE idestado_cuenta_proveedores='$id_movimiento'";
                                      $result14=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$id_movimiento)->get();
                                      $result14->datos_estatus='Pagada';
                                      $result14->save();
                                    }
                                    $c1=base64_encode($cliente);
                                    echo "<script language='javascript' type='text/javascript'>
                                    alert('Movimiento Guardado Exitosamente');
                                    document.location.replace('estado_cuenta.php?idc=$c1');
                                    </script>";
                                  }else{
                                    echo "<script language='javascript' type='text/javascript'>
                                    alert('Se presento un error al guardar el abono, valide la información e intente nuevamente');
                                    history.go(-1);
                                    </script>";
                                  }
                                  // Fin de descuento a unidad
                                }else{
                                  echo "<script language='javascript' type='text/javascript'>
                                  alert('Se presento un error al guardar el abono de pagare, valide la información e intente nuevamente');
                                  history.go(-1);
                                  </script>";
                                }
                              }else{
                                /*echo "<script language='javascript' type='text/javascript'>
                                alert('Se presento un error al guardar el movimiento, valide la información e intente nuevamente');
                                history.go(-1);
                                </script>"; */
                              }
                              //Fin Insertar

                            } else{

                              echo "
                              <script language='javascript' type='text/javascript'>
                              alert('Se presentó un error al cargar el comprobante (archivo), Intente nuevamente.');
                              </script>
                              ";

                            }

                          }

                        } //Fin de validacion de tipo de comprobante
                        DB::commit();
                        // return redirect()->route('wallet.index')->with('success','Mensaje');
                        return back()->with('success','Mensaje')->withInput();
                      } catch (\Exception $e) {
                        DB::rollback();
                        return back()->with('error','Mensaje:'.$e)->withInput();
                      }





      }

      function imprimir($idec, $mt_total, $idc, $contador, $fechas_mv, $tabla_movimientos){
          global $saldo_total;
          global $saldos;
          $consulta = estado_cuenta_proveedores::where('idcontacto',$idc)->where('visible','SI')->where('idestado_cuenta_proveedores',$idec)->get();
          foreach ($consulta as $value_estado_cuenta) {
              //--------------- INICIO Conversión de ATC a Atención a Clientes
              if ($value_estado_cuenta->emisora_institucion=="ATC") {
                  $emisora_institucion = "Atención a Clientes";
              }else{
                  $emisora_institucion = $value_estado_cuenta->emisora_institucion;
              }
              if ($value_estado_cuenta->emisora_agente=="ATC") {
                  $emisora_agente = "Atención a Clientes";
              }else{
                  $emisora_agente = $value_estado_cuenta->emisora_agente;
              }
              if ($value_estado_cuenta->receptora_institucion=="ATC") {
                  $receptora_institucion = "Atención a Clientes";
              }else{
                  $receptora_institucion = $value_estado_cuenta->receptora_institucion;
              }
              if ($value_estado_cuenta->receptora_agente=="ATC") {
                  $receptora_agente = "Atención a Clientes";
              }else{
                  $receptora_agente = $value_estado_cuenta->receptora_agente;
              }
              //---------------    FIN Conversión de ATC a Atención a Clientes
              $tipo_mon = "";
              $cambio = "";
              $cantidad = "";
              if ($value_estado_cuenta->tipo_moneda == "MXN" || $value_estado_cuenta->tipo_moneda == "USD" || $value_estado_cuenta->tipo_moneda == "CAD") {
                  $cambio = number_format($value_estado_cuenta->tipo_cambio,2);
                  $tipo_mon = "<p>Moneda: $value_estado_cuenta->tipo_moneda</p> <p>T. Cambio: $cambio</p>";
                  $cantidad = "Cantidad: ".number_format((float)$value_estado_cuenta->gran_total, 2)."";
              }else{
                  $tipo_mon = "";
                  $cantidad = "";
              }

              /*Start apartado*/
              $folio=$value_estado_cuenta->col1;
              if ($value_estado_cuenta->concepto=="Abono" || $value_estado_cuenta->concepto=="Otros Abonos" || $value_estado_cuenta->concepto=="Enganche" ||
              $value_estado_cuenta->concepto=="Finiquito" || $value_estado_cuenta->concepto=="Apartado" || $value_estado_cuenta->concepto=="Anticipo de Compra" ||
              $value_estado_cuenta->concepto=="Movimiento Post-Venta" || $value_estado_cuenta->concepto=="Descuento por Pago Anticipado" ||
              $value_estado_cuenta->concepto=="Aclaración"  || $value_estado_cuenta->concepto=="Intereses" || $value_estado_cuenta->concepto=="Interés"  ||
              $value_estado_cuenta->concepto=="Finiquito de VIN" || $value_estado_cuenta->concepto=="Finiquito de Deuda" || $value_estado_cuenta->concepto=="Aclaración de Cuentas" ||
              $value_estado_cuenta->concepto=="Traspaso"|| $value_estado_cuenta->concepto=="Legalizacion" || $value_estado_cuenta->concepto=="Comision de Compra"  ||
              $value_estado_cuenta->concepto=="Anticipo de Comision" || $value_estado_cuenta->concepto=="Devolución Monetaria" || $value_estado_cuenta->concepto=="Crédito" ||
              $value_estado_cuenta->concepto=="Traslado" || $value_estado_cuenta->concepto=="Gastos Diversos de Financiamiento" ||
              $value_estado_cuenta->concepto=="Comisión por Mediación Mercantil"|| $value_estado_cuenta->concepto=="Devolución de Comisión por Mediación Mercantil") {

                  /*Start definición cargo abono*/
                  if ($value_estado_cuenta->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos += (float)$mt_total;
                  } else {
                      $abono="";
                  }
                  if ($value_estado_cuenta->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos += (float)$mt_total;
                  } else {
                      $cargo="";
                  }
                  if ($value_estado_cuenta->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td><td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                      $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$value_estado_cuenta->tipo_moneda);
                      $montos_abono_cargo = "Monto: $ $abono ($monto_precio_formato_letras)";
                      $total = "";
                  }
                  if ($value_estado_cuenta->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td><td><span></span></td>";
                      $saldo_total = $saldos + $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                      $monto_precio_formato_letras= GlobalFunctionsController::convertir($cargo,$value_estado_cuenta->tipo_moneda);
                      $montos_abono_cargo = "Monto: $ $cargo ($monto_precio_formato_letras)";
                      $total = "<p>Total: $ $cargo</p>";
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($value_estado_cuenta->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$value_estado_cuenta->tipo_moneda);
                  $folio_aplicado = "N/A";
                  if(!empty($value_estado_cuenta->col1) && !empty($value_estado_cuenta->col2)) $folio_aplicado=$value_estado_cuenta->col1." (".$value_estado_cuenta->col2.")";
                  else{
                      if(!empty($value_estado_cuenta->col1))$folio_aplicado=$value_estado_cuenta->col1;
                      if(!empty($value_estado_cuenta->col2))$folio_aplicado=" (".$value_estado_cuenta->col2.")";
                  }
                  /*End definición cargo abono*/

                  $texto_informacion="<p>Método de pago: $value_estado_cuenta->metodo_pago</p>
                  <p>$montos_abono_cargo</p>
                  $tipo_mon
                  <p>$cantidad</p>
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $value_estado_cuenta->tipo_comprobante</p>
                  <p>No. de Referencia: $value_estado_cuenta->referencia</p>
                  <p>Folio: $folio_aplicado</p>";

                  if($value_estado_cuenta->concepto=="Legalizacion" || $value_estado_cuenta->concepto=="Comision de Compra"){
                  }else{
                      $texto_informacion.="<p>No. de Actividad: $value_estado_cuenta->col3</p>
                      <p>Depositante: $value_estado_cuenta->col4</p>";
                  }
                  $fechas_mv = str_replace(",", "<br>", $fechas_mv);

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fechas_mv</span></td>
                  <td><span>$value_estado_cuenta->concepto</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /*End apartado, enganche*/
              /*Start apartado*/
              else if ($value_estado_cuenta->concepto=="Devolucion" || $value_estado_cuenta->concepto=="Interés") {
                  /*Start definición cargo abono*/
                  if ($value_estado_cuenta->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos += (float)$mt_total;
                  } else {
                      $abono="";
                  }
                  if ($value_estado_cuenta->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos += (float)$mt_total;
                  } else {
                      $cargo="";
                  }
                  if ($value_estado_cuenta->tipo_movimiento!="abono") {
                      $cargo_abono_texto="<td><span></span></td><td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  if ($value_estado_cuenta->tipo_movimiento!="cargo") {
                      $cargo_abono_texto="<td><span>$ $abono</span></td><td><span></span></td>";
                      $saldo_total = $saldos + $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($value_estado_cuenta->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$value_estado_cuenta->tipo_moneda);
                  /*End definición cargo abono*/
                  $texto_informacion="<p>Método de pago: $value_estado_cuenta->metodo_pago</p>
                  <p>Monto: $ $abono ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $value_estado_cuenta->tipo_comprobante</p>
                  <p>No. de Referencia: $value_estado_cuenta->referencia</p>";

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$value_estado_cuenta->concepto<br>$folio</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /*End apartado, enganche*/
              /*Start venta directa*/
              else if ($value_estado_cuenta->concepto=="Venta Directa" || $value_estado_cuenta->concepto=="Venta Permuta" || $value_estado_cuenta->concepto=="Compra Directa" || $value_estado_cuenta->concepto=="Compra Permuta" || $value_estado_cuenta->concepto=="Cuenta de Deuda" || $value_estado_cuenta->concepto=="Consignacion" || $value_estado_cuenta->concepto=="Devolución del VIN") {
                  // $tipo_mon = "";
                  // $cambio = "";
                  // $cantidad = "";
                  // if ($value_estado_cuenta->tipo_moneda == "MXN" || $value_estado_cuenta->tipo_moneda == "USD" || $value_estado_cuenta->tipo_moneda == "CAD") {
                  // 	$cambio = number_format($value_estado_cuenta->tipo_cambio,2);
                  // 	$tipo_mon = "Moneda: $value_estado_cuenta->tipo_moneda<br> T. Cambio: $cambio<br>";
                  // 	$cantidad = "Cantidad: ".number_format($value_estado_cuenta->gran_total, 2)."<br>";
                  // }else{
                  // 	$tipo_mon = "";
                  // 	$cantidad = "";
                  // }

                  if ($value_estado_cuenta->datos_estatus == "Pagada") {
                      $estatus_unidad="Estatus:  <span  style='color:#00b248;'><b>$value_estado_cuenta->datos_estatus</b></span>";
                  }else{
                      $estatus_unidad="Estatus:  <span  style='color:red;'><b>$value_estado_cuenta->datos_estatus</b></span>";
                  }
                  /*Start fecha formato*/
                  $fecha_movimiento_bien="";
                  $date = date_create($value_estado_cuenta->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  /*End fecha formato*/
                  /*Start color estatus*/
                  if ($value_estado_cuenta->datos_estatus=="Pagada" && $value_estado_cuenta->concepto=="Venta Directa" || $value_estado_cuenta->datos_estatus=="Pagada" && $value_estado_cuenta->concepto=="Venta Permuta" ) {
                      $color_cuenta="class='estatus-abono-positivo'";
                  }else if ($value_estado_cuenta->datos_estatus=="Pendiente" && $value_estado_cuenta->concepto=="Venta Directa" || $value_estado_cuenta->datos_estatus=="Pendiente" && $value_estado_cuenta->concepto=="Venta Permuta") {
                      $color_cuenta="class='estatus-abono-negativo'";
                  }else{
                      $color_cuenta="class='estatus-abono-neutro'";
                  }
                  /*End color estatus*/
                  /*Start number format precio unidad*/
                  if ($value_estado_cuenta->datos_precio!="") {
                      $precio_unidad=number_format("$value_estado_cuenta->datos_precio",2);
                  }else{
                      $precio_unidad="";
                  }

                  $saldo_unidad = 0;
                  $sql85= abonos_unidades_proveedores::where('idestado_cuenta',$value_estado_cuenta->idestado_cuenta_orden_fechas_proveedores)->where('visible','SI')->get();
                  if(!empty($sql85->cantidad_pago))$saldo_unidad = $saldo_unidad + $sql85->cantidad_pago;
                  $saldo_unidad = $value_estado_cuenta->datos_precio - $saldo_unidad;
                  $saldo_unidad = "Saldo: $ ".number_format($saldo_unidad, 2);
                  /*End number format precio unidad*/
                  /*Start datos*/

                  if ($value_estado_cuenta->concepto=="Comisión por Mediación Mercantil") {
                      $datos_pe= "<p>$estatus_unidad</p>";
                  }else{
                      $datos_pe="<p>Precio: $ $precio_unidad</p>
                      <p>$saldo_unidad</p>
                      <p>$estatus_unidad</p>";
                  }

                  $consulta_inventario = inventario::where('vin_numero_serie',$value_estado_cuenta->datos_vin)->get()->last();
                  $consulta_inventario_trucks = inventario_trucks::where('vin_numero_serie',$value_estado_cuenta->datos_vin)->get()->last();
                  if(!empty($consulta_inventario)) $inventario = $consulta_inventario;
                  if(!empty($consulta_inventario_trucks)) $inventario = $consulta_inventario_trucks;
                  $texto_disponibilidad_inventario = "
                  <p><br>Inventario:</p>
                  <p><b>No disponible</b></p>";
                  if(!empty($inventario)) {
                      $texto_disponibilidad_inventario = "
                      <p><br>Inventario:</p>
                      <p>Fecha ingreso: $inventario->fecha_ingreso</p>
                      <p>Ubicaci&oacute;n: $inventario->ubicacion</p>
                      <p>Estatus: $inventario->estatus_unidad</p>";
                  }



                  $texto_datos="
                  <p>Marca: $value_estado_cuenta->datos_marca</p>
                  <p>Versión: $value_estado_cuenta->datos_version</p>
                  <p>Modelo: $value_estado_cuenta->datos_modelo</p>
                  <p>Color: $value_estado_cuenta->datos_color</p>
                  <p>VIN: $value_estado_cuenta->datos_vin</p>
                  $datos_pe
                  $texto_disponibilidad_inventario
                  ";
                  /*End datos*/
                  /*Start conversion de numeros a letras*/
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($value_estado_cuenta->monto_precio,$value_estado_cuenta->tipo_moneda);
                  // $monto_precio_formato_letras_m_pago= GlobalFunctionsController::convertir($m_pago);/////----------------------------------Pendiente
                  /*End conversion de numeros a letras*/
                  /*Start definición cargo abono*/
                  $abono=0;
                  $cargo=0;
                  if ($value_estado_cuenta->abono!="") {
                      $abono=number_format("$value_estado_cuenta->abono",2);
                      $tabla_movimientos->abonos += (float)$value_estado_cuenta->abono;
                  } else {
                      $abono="";
                  }

                  if ($value_estado_cuenta->cargo!="") {
                      $cargo=number_format("$value_estado_cuenta->cargo",2);
                      $tabla_movimientos->cargos += (float)$value_estado_cuenta->cargo;
                  } else {
                      $cargo="";
                  }

                  if ($value_estado_cuenta->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td><td><span>$ $abono</span></td>";
                  }
                  if ($value_estado_cuenta->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td><td><span></span></td>";
                      $saldo_total = $saldos + "$value_estado_cuenta->cargo";
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  if ($value_estado_cuenta->monto_total!="") {
                      $monto_total_general=number_format($value_estado_cuenta->monto_total,2);
                  }else{
                      $monto_total_general="";
                  }
                  /*Start información*/
                  $general_monto="";
                  $general_monto="<p>Serie: "."$value_estado_cuenta->serie_monto</p>";
                  /*Start number format precio unidad*/
                  if ($value_estado_cuenta->datos_precio!="") {
                      $precio_unidad=number_format("$value_estado_cuenta->datos_precio",2);
                  }else{
                      $precio_unidad="";
                  }
                  $monto_total_general=$precio_unidad;
                  /*End number format precio unidad*/
                  ///Pagares
                  $lista_pagares_titulo="";
                  $lista_pagares="";
                  $result20=documentos_pagar::where('idestado_cuenta',$value_estado_cuenta->idestado_cuenta_proveedores)->where('visible','SI')->get();

                  foreach ($result20 as $fila1) {
                      $monto_precio_formato=number_format($fila1->monto,2);
                      $saldo_letras= GlobalFunctionsController::convertir($fila1->monto,$value_estado_cuenta->tipo_moneda);
                      $result201=abonos_pagares_proveedores::where('iddocumentos_pagar',$fila1->iddocumentos_pagar)->get();
                      if(count($result201)==0){
                          $saldo_actual=$monto_precio_formato;
                      }else{
                          foreach ($result201 as $fila11) {
                              $saldo_actual=number_format($fila11->cantidad_pendiente,2);
                          }
                      }

                      if ($fila1->estatus == "Pendiente" && $saldo_actual != "0.00" ) {
                          date_default_timezone_set('America/Mexico_City');
                          $fechaactual1= date("Y-m-d H:i:s");
                          $time_difference1 = strtotime($fechaactual1) - strtotime($fila1->fecha_vencimiento) ;
                          $dias=floor($time_difference1/86400);
                          $aux31=$dias*86400;
                          $aux41=$time_difference1-$aux31;
                          $hours1 = floor($aux41 / 3600);
                          $aux1=$hours1*3600;
                          $aux11=$aux41-$aux1;
                          $minutes1 = floor( $aux11 / 60);
                          $aux21=$minutes1*60;
                          $seconds1 = $aux11-$aux21 ;
                          if ($dias<0) {
                              $dias=0;
                          }
                          if ($hours1=="0") {
                              $hours1="00";
                          }
                          if ($hours1>"0" && $hours1<"10") {
                              $hours1="0".$hours1;
                          }
                          if ($minutes1=="0") {
                              $minutes1="00";
                          }
                          if ($minutes1>"0" && $minutes1<"10") {
                              $minutes1="0".$minutes1;
                          }
                          if ($seconds1=="0") {
                              $seconds1="00";
                          }
                          if ($seconds1>"0" && $seconds1<"10") {
                              $seconds1="0".$seconds1;
                          }
                          $tiempo_solucion="Días Trascurridos: ".$dias;
                      }else{
                          $tiempo_solucion = "";
                      }
                      $estatus_pagare = "";
                      if ($fila1->estatus == "Pagada") $estatus_pagare="Estatus:  <span  style='color:#00b248;'><b>$fila1->estatus</b></span>";
                      else $estatus_pagare="Estatus:  <span  style='color:red;'><b>$fila1->estatus</b></span>";

                      $vencimientof = date_create($fila1->fecha_vencimiento);
                      $vencimientof = date_format($vencimientof, "d-m-Y");
                      $lista_pagares_titulo="<br><p>Documentos por Pagar:</p>";
                      $lista_pagares.="<p>Serie: $fila1->num_pagare</p>
                      <p>Monto: $ $monto_precio_formato</p> <p>($saldo_letras)</p>
                      <p>Vencimiento: $vencimientof</p>
                      <p>$tiempo_solucion</p>
                      <p>Saldo: $ $saldo_actual</p>
                      <p>$estatus_pagare</p><br>
                      ";
                  }//Fin de consulta pagares
                  if($value_estado_cuenta->concepto=="Cuenta de Deuda")
                  $conc="A ".$value_estado_cuenta->concepto;
                  else  $conc=$value_estado_cuenta->concepto;
                  if ($value_estado_cuenta->referencia == "N/A" || $value_estado_cuenta->referencia == "S/N") {
                      $ref_nueva = "";
                  }else{
                      $ref_nueva = "No. de Referencia: $value_estado_cuenta->referencia";
                  }

                  $resultado=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$value_estado_cuenta->idestado_cuenta_proveedores)->get()->first();
                  $folio_nuevo=$resultado->col1;
                  $folio_anterior=$resultado->col2;
                  $actividad=$resultado->col3;
                  $depositante=$resultado->col4;
                  $texto_informacion="
                  <p>Precio: $ $precio_unidad ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $value_estado_cuenta->tipo_comprobante</p>
                  <p>".$ref_nueva."</p>
                  "." ".$lista_pagares_titulo." ".$lista_pagares."";
                  // <p>Folio: ".$folio_nuevo." (".$folio_anterior.")</p>";
                  /*End información*/

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$conc<br>$folio_nuevo</span></td>
                  <td $color_cuenta><span>$texto_datos</span></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /*End venta directa*/
              /*Start apartado*/
              else if ($value_estado_cuenta->concepto=="Otros Cargos") {
                  /*Start definición cargo abono*/
                  if ($value_estado_cuenta->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos += (float)$mt_total;
                  }
                  else {
                      $abono="";
                  }
                  if ($value_estado_cuenta->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos += (float)$mt_total;
                  }else {
                      $cargo="";
                  }
                  if ($value_estado_cuenta->tipo_movimiento!="abono") {
                      $cargo_abono_texto="<td><span></span></td><td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  if ($value_estado_cuenta->tipo_movimiento!="cargo") {
                      $cargo_abono_texto="<td><span>$ $abono</span></td><td><span></span></td>";
                      $saldo_total = $saldos + $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($value_estado_cuenta->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$value_estado_cuenta->tipo_moneda);
                  /*End definición cargo abono*/
                  $texto_informacion="<p>Método de pago: $value_estado_cuenta->metodo_pago</p>
                  <p>Monto: $ $abono ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $value_estado_cuenta->tipo_comprobante</p>
                  <p>No. de Referencia: $value_estado_cuenta->referencia</p>";

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$value_estado_cuenta->concepto</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }else if ($value_estado_cuenta->concepto=="Devolución Prestamo") {
                  // $tipo_mon = "";
                  // $cambio = "";
                  // $cantidad = "";
                  // if ($value_estado_cuenta->tipo_moneda == "MXN" || $value_estado_cuenta->tipo_moneda == "USD" || $value_estado_cuenta->tipo_moneda == "CAN") {
                  // 	$cambio = number_format($value_estado_cuenta->tipo_cambio,2);
                  // 	$tipo_mon = "Moneda: $value_estado_cuenta->tipo_moneda<br> T. Cambio: $cambio<br>";
                  // 	$cantidad = "Cantidad: ".number_format($value_estado_cuenta->gran_total, 2)."<br>";
                  // }else{
                  // 	$tipo_mon = ""; $cantidad = "";
                  // }

                  /*Start definición cargo abono*/
                  if ($value_estado_cuenta->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos += (float)$mt_total;
                  } else { $abono=""; }
                  if ($value_estado_cuenta->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos += (float)$mt_total;
                  } else { $cargo=""; }

                  if ($value_estado_cuenta->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td><td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  if ($value_estado_cuenta->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td><td><span></span></td>";
                      $saldo_total = $saldos + 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($value_estado_cuenta->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$value_estado_cuenta->tipo_moneda);
                  /*End definición cargo abono*/

                  $texto_informacion="<p>Método de pago: $value_estado_cuenta->metodo_pago</p>
                  <p>Monto: $ $abono ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $value_estado_cuenta->tipo_comprobante</p>
                  <p>No. de Referencia: $value_estado_cuenta->referencia</p>";

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$value_estado_cuenta->concepto</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              else if ($value_estado_cuenta->concepto=="Préstamo") {
                  // $tipo_mon = ""; $cambio = ""; $cantidad = "";
                  // if ($value_estado_cuenta->tipo_moneda == "MXN" || $value_estado_cuenta->tipo_moneda == "USD" || $value_estado_cuenta->tipo_moneda == "CAN") {
                  // 	$cambio = number_format($value_estado_cuenta->tipo_cambio,2);
                  // 	$tipo_mon = "Moneda: $value_estado_cuenta->tipo_moneda<br> T. Cambio: $cambio<br>";
                  // 	$cantidad = "Cantidad: ".number_format($value_estado_cuenta->gran_total, 2)."<br>";
                  // }else{
                  // 	$tipo_mon = ""; $cantidad = "";
                  // }
                  /*Start definición cargo abono*/
                  if ($value_estado_cuenta->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos += (float)$mt_total;
                  } else { $abono=""; }

                  if ($value_estado_cuenta->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos += (float)$mt_total;
                  } else { $cargo=""; }

                  if ($value_estado_cuenta->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td><td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  if ($value_estado_cuenta->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td><td><span></span></td>";
                      $saldo_total = $saldos + 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($value_estado_cuenta->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$value_estado_cuenta->tipo_moneda);
                  /*End definición cargo abono*/

                  $texto_informacion="<p>Método de pago: $value_estado_cuenta->metodo_pago</p>
                  <p>Monto: $ $abono ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $value_estado_cuenta->tipo_comprobante</p>
                  <p>No. de Referencia: $value_estado_cuenta->referencia</p>";

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$value_estado_cuenta->concepto</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /*End apartado, enganche*/
          }
          return $tabla_movimientos;

      }

      function imprimirEstadoCuentaProveedores($idec, $mt_total, $idc, $contador, $fechas_mv , $tabla_movimientos){
          global $saldo_total;
          global $saldos;
          $folio_nuevo = "";
          $result6 = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$idc)->where('visible','SI')->where('idestado_cuenta_orden_fechas_proveedores',$idec)->get();
          foreach($result6 as $fila6) {
              if(!empty($fila6->metodo_pago)){
                  if($fila6->metodo_pago == 1) $fila6->metodo_pago = "Efectivo";
                  if($fila6->metodo_pago == 3) $fila6->metodo_pago = "Transferencia";
              }



              //--------------- INICIO Conversión de ATC a Atención a Clientes
              if ($fila6->emisora_institucion=="ATC") {  $emisora_institucion = "Atención a Clientes";
              }else{ $emisora_institucion = $fila6->emisora_institucion; }
              if ($fila6->emisora_agente=="ATC") { $emisora_agente = "Atención a Clientes";
              }else{ $emisora_agente = $fila6->emisora_agente; }
              if ($fila6->receptora_institucion=="ATC") {  $receptora_institucion = "Atención a Clientes";
              }else{ $receptora_institucion = $fila6->receptora_institucion;}
              if ($fila6->receptora_agente=="ATC") { $receptora_agente = "Atención a Clientes";
              }else{ $receptora_agente = $fila6->receptora_agente; }

              $tipo_mon = "";
              $cambio = "";
              $cantidad = "";
              if ($fila6->tipo_moneda == "MXN" || $fila6->tipo_moneda == "USD" || $fila6->tipo_moneda == "CAD") {
                  $cambio = number_format($fila6->tipo_cambio,2);
                  $tipo_mon = "<p>Moneda: $fila6->tipo_moneda<br> T. Cambio: $cambio</p>";
                  $cantidad = "<p>Cantidad: ".number_format((float)$mt_total, 2)."</p>";
              }else{
                  $tipo_mon = "";
                  $cantidad = "";
              }

              if($fila6->concepto=="Compra Directa" || $fila6->concepto=="Cuenta de Deuda" || $fila6->concepto=="Consignacion" || $fila6->concepto=="Devolución del VIN"){
                  $resultz=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
                  foreach($resultz as $filaz){
                      $folio_nuevo=$filaz->col1;
                      $folio_anterior=$filaz->col2;
                      if($fila6->concepto=="Cuenta de Deuda")
                      $contador.".- "." ".$fila6->idestado_cuenta_orden_fechas_proveedores."=>"."A ".$fila6->concepto."<br>Folio: ".$filaz->col1." ".$fila6->fecha_movimiento."<br>";
                      else
                      $contador.".- "." "."$fila6->idestado_cuenta_orden_fechas_proveedores"."=>"."A $fila6->concepto<br>Folio: $filaz->col1"." "."$fila6->fecha_movimiento"."<br>";
                  }
              }
              else
              $contador.".- "." "."$fila6->idestado_cuenta_orden_fechas_proveedores"."=>"."A $fila6->concepto"." "."$fila6->fecha_movimiento"."<br>";

              /***********************************************************Start apartado***********************************************************/
              if ($fila6->concepto=="Abono" || $fila6->concepto=="Otros Abonos" || $fila6->concepto=="Enganche" || $fila6->concepto=="Finiquito" ||
              $fila6->concepto=="Apartado" || $fila6->concepto=="Anticipo de Compra" || $fila6->concepto=="Movimiento Post-Venta" ||
              $fila6->concepto=="Descuento por Pago Anticipado" || $fila6->concepto=="Aclaración" || $fila6->concepto=="Intereses" ||
              $fila6->concepto=="Interés" || $fila6->concepto=="Finiquito de VIN" || $fila6->concepto=="Finiquito de Deuda" || $fila6->concepto=="Aclaración de Cuentas" ||
              $fila6->concepto=="Traspaso"|| $fila6->concepto=="Legalizacion" || $fila6->concepto=="Comision de Compra"  || $fila6->concepto=="Anticipo de Comision" ||
              $fila6->concepto=="Devolución Monetaria" || $fila6->concepto=="Crédito" || $fila6->concepto=="Traslado" ||
              $fila6->concepto=="Comisión por Mediación Mercantil" || $fila6->concepto=="Devolución de Comisión por Mediación Mercantil" ||
              $fila6->concepto=="Gastos de Importación" || $fila6->concepto=="Honorarios de Importación" || $fila6->concepto=="Otros Cargos-C" ||
              $fila6->concepto=="Otros Cargos-A" || $fila6->concepto=="Otros Cargos" || $fila6->concepto=="Otros Abonos" || $fila6->concepto=="Traspaso-C" ||
              $fila6->concepto=="Traspaso-A" || $fila6->concepto=="Penalización por pago tardío" || $fila6->concepto=="Gastos de operación por recepción de divisas" ||
              $fila6->concepto=="Comisión por transferencia"|| $fila6->concepto=="Interes"){

                  /*Start definición cargo abono*/
                  if ($fila6->abono!="") {
                      $abono=number_format((float)$mt_total,2);
                      $tabla_movimientos->abonos+=(float)$mt_total;
                  } else { $abono=""; }
                  if ($fila6->cargo!="") { $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos+=(float)$mt_total;
                  } else { $cargo=""; }

                  if ($fila6->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td>
                      <td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);

                      // if ($procedencia_proveedor == 'USA') {
                      //    $cant_precio_abono = $fila6->gran_total;
                      //    $abono = number_format($fila6->gran_total, 2);
                      //    $tipo_moneda_con = '';
                      // }else{
                      $cant_precio_abono = $mt_total;
                      $abono = number_format($mt_total, 2);
                      $tipo_moneda_con = 'MXN';
                      // }
                      $monto_precio_formato_letras= GlobalFunctionsController::convertir($cant_precio_abono, $fila6->tipo_moneda);
                      $montos_abono_cargo = "Monto: $ $abono ($monto_precio_formato_letras)";
                      $total = "Total: $ $abono";
                  }
                  if ($fila6->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td>
                      <td><span></span></td>";
                      $saldo_total = $saldos + $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                      $monto_precio_formato_letras= GlobalFunctionsController::convertir($cargo,$fila6->tipo_moneda);
                      $montos_abono_cargo = "Monto: $ $cargo ($monto_precio_formato_letras)";
                      $total = "Total: $ $cargo";
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($fila6->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $resulty=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
                  foreach($resulty as $filay){
                      $folio=$filay->col1;
                      $folio_anterior=$filay->col2;
                      $actividad=$filay->col3;
                      $depositante=$filay->col4;
                  }

                  /*Concatencacion texto*/
                  if($fila6->concepto=="Legalizacion"){
                      $texto_informacion="<p>Método de pago: $fila6->metodo_pago</p>
                      <p>$montos_abono_cargo</p>
                      $tipo_mon
                      $cantidad
                      <p>I. Emisora: $emisora_institucion</p>
                      <p>A. Emisor: $emisora_agente</p>
                      <p>I. Receptora: $receptora_institucion</p>
                      <p>A. Receptor: $receptora_agente</p>
                      <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                      <p>No. de Referencia: $fila6->referencia</p>
                      <p>Folio: $folio ($folio_anterior)</p>";
                  }else{
                      if ($fila6->concepto=="Comision de Compra") {
                          $texto_informacion="
                          <p>$montos_abono_cargo</p>
                          $tipo_mon
                          $cantidad
                          <p>I. Emisora: $emisora_institucion</p>
                          <p>A. Emisor: $emisora_agente</p>
                          <p>I. Receptora: $receptora_institucion</p>
                          <p>A. Receptor: $receptora_agente</p>
                          <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                          <p>No. de Referencia: $fila6->referencia</p>
                          <p>Folio: $folio ($folio_anterior)</p>

                          ";
                      } else {
                          $texto_informacion="Método de pago: $fila6->metodo_pago<br>
                          <p>$montos_abono_cargo</p>
                          $tipo_mon
                          $cantidad
                          <p>I. Emisora: $emisora_institucion</p>
                          <p>A. Emisor: $emisora_agente</p>
                          <p>I. Receptora: $receptora_institucion</p>
                          <p>A. Receptor: $receptora_agente</p>
                          <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                          <p>No. de Referencia: $fila6->referencia</p> ";
                          /*Folio: $folio ($folio_anterior)<br>
                          No. de Actividad: $actividad<br>
                          Depositante: $depositante<br>*/
                      }
                  }
                  if($fila6->concepto=="Cuenta de Deuda")  $conc="A ".$fila6->concpeto;
                  else
                  $conc=$fila6->concepto;
                  $fechas_mv = date_create("$fila6->fecha_movimiento");
                  $fechas_mv = date_format($fechas_mv, "d-m-Y");

                  if ($fila6->tipo_movimiento === 'abono' && $fila6->concepto != 'Comisión por Mediación Mercantil') {
                      $new_concept = 'Abono';
                  }else{
                      if ($fila6->concepto === 'Traspaso-C') {
                          $new_concept = 'Traspaso';
                      } else if ($fila6->concepto === 'Otros Cargos-C') {
                          $new_concept = 'Otros Cargos';
                      }else if($fila6->concepto=="Cuenta de Deuda"){
                          $new_concept="A ".$fila6->concpeto;
                      }else{
                          $new_concept = $fila6->concepto;
                      }
                  }

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fechas_mv</span></td>
                  <td><span>$new_concept</span><br>$folio_nuevo</td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /**************************************************************Start apartado**************************************************************/
              else if ($fila6->concepto=="Devolucion" || $fila6->concepto=="Interés") {
                  /*Start definición cargo abono*/
                  if ($fila6->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos+=(float)$mt_total;
                  } else { $abono=""; }

                  if ($fila6->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos+=(float)$mt_total;
                  } else { $cargo=""; }

                  if ($fila6->tipo_movimiento!="abono") {
                      $cargo_abono_texto="<td><span></span></td>
                      <td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  if ($fila6->tipo_movimiento!="cargo") {
                      $cargo_abono_texto="<td><span>$ $abono</span></td>
                      <td><span></span></td>";
                      $saldo_total = $saldos + $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($fila6->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$fila6->tipo_moneda);

                  /*Generacion de texto*/
                  $texto_informacion="<p>Método de pago: $fila6->metodo_pago</p>
                  <p>Monto: $ $abono ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                  <p>No. de Referencia: $fila6->referencia</p>";

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$fila6->concepto</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /******************************************************Start venta directa******************************************************/
              else if ($fila6->concepto=="Venta Directa" || $fila6->concepto=="Venta Permuta" || $fila6->concepto=="Compra Directa" ||
              $fila6->concepto=="Compra Permuta" || $fila6->concepto=="Cuenta de Deuda" || $fila6->concepto=="Consignacion" ||
              $fila6->concepto=="Devolución del VIN" || $fila6->concepto=="Gastos Diversos de Financiamiento") {
                  if ($fila6->datos_estatus == "Pagada") {
                      $estatus_unidad="<p style=''>Estatus:  <span  style='color:#00b248;'><b>$fila6->datos_estatus</b></span></p>";
                  }else{
                      $estatus_unidad="<p style=''>Estatus:  <span  style='color:red;'><b>$fila6->datos_estatus</b></span></p>";
                  }
                  /*Start fecha formato*/
                  $fecha_movimiento_bien="";
                  $date = date_create($fila6->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');

                  /*Start color estatus*/
                  if ($fila6->datos_estatus=="Pagada" && $fila6->concepto=="Venta Directa" || $fila6->datos_estatus=="Pagada" && $fila6->concepto=="Venta Permuta" ) {
                      $color_cuenta="class='estatus-abono-positivo'";
                  }else if ($fila6->datos_estatus=="Pendiente" && $fila6->concepto=="Venta Directa" || $fila6->datos_estatus=="Pendiente" && $fila6->concepto=="Venta Permuta") {
                      $color_cuenta="class='estatus-abono-negativo'";
                  }else{
                      $color_cuenta="class='estatus-abono-neutro'";
                  }

                  /*Start number format precio unidad*/
                  if ($fila6->datos_precio!="") {
                      // if ($procedencia_proveedor === 'USA') { $precio_unidad=number_format("$fila6->gran_total",2);
                      // }else{
                      $precio_unidad=number_format("$fila6->datos_precio",2);
                      // }
                  }else{ $precio_unidad=""; }

                  $saldo_unidad = 0;
                  $result85=abonos_unidades_proveedores::where('idestado_cuenta',$fila6->idestado_cuenta_orden_fechas_proveedores)->where('visible','SI')->get();
                  foreach( $result85 as $fila85) {
                      $saldo_unidad = $saldo_unidad + $fila85->cantidad_pago;
                  }
                  $saldo_unidad = $fila6->datos_precio-$saldo_unidad;

                  /*Start datos*/
                  if ($fila6->concepto=="Comisión por Mediación Mercantil") {  $datos_pe= "<p>$estatus_unidad</p>";
                  }else{
                      // if ($procedencia_proveedor === 'USA') { $saldo_unidad = '';
                      // }else{
                      $saldo_unidad = "Saldo: $ ".number_format($saldo_unidad, 2);
                      // }
                      $estatus_unidad_inventario = '';
                      $fecha_ingreso = '';
                      $expediente_cmp = '';
                      if ($fila6->concepto === 'Compra Directa') {
                          $result850=inventario_orden_proveedores_clientes::where('vin',$fila6->datos_vin)->where('visible','SI')->where('idestado_cuenta',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
                          foreach($result850 as $fila850) {
                              $estatus_unidad_inventario = 'SI';
                              $fecha_ingreso = date_create($fila850->fecha_ingreso);
                              $fecha_ingreso = date_format($fecha_ingreso, 'd-m-Y');
                              $numero_check = 0;
                              $resultado3 = check_list_expediente_original::where('idorden_compra_unidades',$fila850->idorden_compra)->where('visible','SI')->where('tipo_check_list','Ingreso')->where('entrega','!=','NO')->get();
                              $numero_check = count($resultado3);
                              $pendientes = 0;
                              $cargados = 0;
                              foreach($resultado3 as $fila3) {
                                  $entrega = "$fila3->entrega";
                                  $archivo = "$fila3->archivo";
                                  if ($entrega == "Pendiente" || $entrega == "Pendiente2") { $pendientes++;  }
                                  if ($entrega == "SI") {
                                      if($archivo != ""){ $cargados++;
                                      }else{  $pendientes++;}
                                  }
                              }
                              if ($numero_check == $cargados) { $expediente_cmp = 'Completo';
                              } else {  $expediente_cmp = 'Incompleto';}
                          }
                          $result850x = inventario::where('vin_numero_serie',$fila6->datos_vin)->get();
                          foreach($result850x as $fila850x) {
                              $fecha_ingreso = $fila850x->fecha_ingreso;
                          }
                          if (count($result850x) == 0) {
                              $result851x = inventario_trucks::where('vin_numero_serie',$fila6->datos_vin)->get();
                              foreach($result851x as $fila851x) {
                                  $fecha_ingreso = $fila851x->fecha_ingreso;
                              }
                              if (count($result851x) == 0) {
                                  $estatus_unidad_inventario = '<b style="color: red;">Sin Ingreso</b>';
                                  $fecha_ingreso = 'N/A';
                                  $expediente_cmp = 'Sin información';
                              } else {
                                  $estatus_unidad_inventario = 'SI';
                                  $fecha_ingreso = date_create($fecha_ingreso);
                                  $fecha_ingreso = date_format($fecha_ingreso, 'd-m-Y');
                                  $expediente_cmp = 'Sin información';
                              }
                          } else {
                              $estatus_unidad_inventario = 'SI';
                              $fecha_ingreso = date_create($fecha_ingreso);
                              $fecha_ingreso = date_format($fecha_ingreso, 'd-m-Y');
                              $expediente_cmp = 'Sin información';
                          }
                      }

                      $resulty=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
                      $datos_venta = "";
                      foreach($resulty as $filay){
                          $folio_nuevo=$filay->col1;
                          $folio_anterior=$filay->col2;
                          $actividad=$filay->col3;
                          $depositante=$filay->col4;
                          $datos_vin_dcc=$filay->datos_vin;
                          $resulty11=estado_cuenta::where('datos_vin',$filay->datos_vin)->where('visible','SI')->where('concepto','Venta Directa')->orWhere('datos_vin',$filay->datos_vin)->where('visible','SI')->where('concepto','Venta Permuta')->get()->take(1);
                          foreach($resulty11 as $filay11){
                              $fecha_movimiento_venta = '';
                              $fecha_movimiento_venta = date_create($filay11->fecha_movimiento);
                              $fecha_movimiento_venta = date_format($fecha_movimiento_venta, 'd-m-Y');
                              $resulty12=contactos::where('idcontacto',$filay11->idcontacto)->get();
                              foreach($resulty12 as $filay12){
                                  $datos_venta .= '<b>ID: </b>'.$filay11->idcontacto.'.'.$filay12->nombre.' '.$filay12->apellidos.'<br>Fecha de mov.: '.$fecha_movimiento_venta.'<br>';
                              }
                          }
                      }
                      if ($datos_venta == '') {
                          $datos_venta = 'N/A';
                      } else {
                          $datos_venta = $datos_venta;
                      }
                      $texto_informacion="
                      <p style='font-size: 6px;'>Inventario:  $estatus_unidad_inventario</p>
                      <p style='font-size: 6px;'>Fecha de ingreso: $fecha_ingreso </p>
                      <p style='font-size: 6px;'>Expediente:  $expediente_cmp</p>
                      <p style='font-size: 6px;'><b>Venta</b> $datos_venta</p>";
                      $datos_pe="<p>Precio: $ $precio_unidad</p>
                      <p>$saldo_unidad</p>
                      $estatus_unidad
                      $texto_informacion";
                  }
                  if ($fila6->concepto=="Gastos Diversos de Financiamiento") {
                      $folio_nuevo = '';
                      $texto_datos="
                      <p>Marca: $fila6->datos_marca</p>
                      <p>Versión: $fila6->datos_version</p>
                      <p>Modelo: $fila6->datos_modelo</p>
                      <p>Color: $fila6->datos_color</p>
                      <p>VIN: $fila6->datos_vin</p>";
                  }else{
                      $folio_nuevo = $folio_nuevo;
                      $texto_datos="
                      <p>Marca: $fila6->datos_marca</p>
                      <p>Versión: $fila6->datos_version</p>
                      <p>Modelo: $fila6->datos_modelo</p>
                      <p>Color: $fila6->datos_color</p>
                      <p>VIN: $fila6->datos_vin</p>
                      $datos_pe";
                  }

                  /*Start conversion de numeros a letras*/
                  // if ($procedencia_proveedor == 'USA') {
                  //    $cant_precio = $fila6->gran_total;
                  //    $tipo_moneda_con = '';
                  // }else{
                  $cant_precio = $fila6->monto_precio;
                  $tipo_moneda_con = 'MXN';
                  // }
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($cant_precio, $fila6->tipo_moneda);

                  /*Start definición cargo abono*/
                  $abono=0;
                  $cargo=0;
                  if ($fila6->abono!="") {
                      $abono=number_format("$fila6->abono",2);
                      $tabla_movimientos->abonos+=(float)$fila6->abono;
                  } else { $abono=""; }
                  if ($fila6->cargo!="") {
                      $cargo=number_format("$fila6->cargo",2);
                      $tabla_movimientos->cargos+=(float)$fila6->cargo;
                  } else { $cargo=""; }
                  if ($fila6->tipo_movimiento=="abono") {
                      // if ($procedencia_proveedor === 'USA') {
                      // $abono=number_format("$fila6->gran_total",2);
                      // }else{
                      $abono=number_format("$fila6->abono",2);
                      // }
                      $cargo_abono_texto="<td><span></span></td>
                      <td><span>$ $abono</span></td>";
                  }
                  if ($fila6->tipo_movimiento=="cargo") {
                      // if ($procedencia_proveedor === 'USA') {
                      // $cargo=number_format("$fila6->gran_total",2);
                      // $cargo_moneda="$fila6->gran_total";
                      // }else{
                      $cargo=number_format("$fila6->cargo",2);
                      $cargo_moneda="$fila6->cargo";
                      // }
                      $cargo_abono_texto="<td><span>$ $cargo</span></td>
                      <td><span></span></td>";
                      $saldo_total = $saldos + $cargo_moneda;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  if ($fila6->monto_total!="") {$monto_total_general=number_format($fila6->monto_total,2);
                  }else{ $monto_total_general="";}
                  /*Start información*/
                  $general_monto="";
                  $general_monto="Serie: "."$fila6->serie_monto";

                  /*Start number format precio unidad*/
                  if ($fila6->datos_precio!="") {
                      // if ($procedencia_proveedor === 'USA') {$precio_unidad=number_format("$fila6->gran_total",2);
                      // }else{
                      $precio_unidad=number_format("$fila6->cargo",2);
                      // }
                  }else{ $precio_unidad=""; }
                  $monto_total_general=$precio_unidad;

                  ///Pagares
                  $lista_pagares_titulo="";
                  $lista_pagares="";
                  $result20=documentos_pagar::where('idestado_cuenta',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();

                  foreach($result20 as $fila1) {
                      $monto_precio_formato=number_format($fila1->monto,2);
                      $saldo_letras= GlobalFunctionsController::convertir($fila1->monto,$fila6->tipo_moneda);
                      $result201=abonos_pagares_proveedores::where('iddocumentos_pagar',$fila1->iddocumentos_pagar)->get();
                      if(count($result201)==0){
                          $saldo_actual=$monto_precio_formato;
                      }else{
                          foreach($result201 as $fila11) {
                              $saldo_actual=number_format($fila11->cantidad_pendiente,2);
                          }
                      }
                      if ($fila1->estatus == "Pendiente" && $saldo_actual != "0.00" ) {
                          date_default_timezone_set('America/Mexico_City');
                          $fechaactual1= date("Y-m-d H:i:s");
                          $time_difference1 = strtotime($fechaactual1) - strtotime($fila1->fecha_vencimiento) ;
                          $dias=floor($time_difference1/86400);
                          $aux31=$dias*86400;
                          $aux41=$time_difference1-$aux31;
                          $hours1 = floor($aux41 / 3600);
                          $aux1=$hours1*3600;
                          $aux11=$aux41-$aux1;
                          $minutes1 = floor( $aux11 / 60);
                          $aux21=$minutes1*60;
                          $seconds1 = $aux11-$aux21 ;
                          if ($dias<0) {$dias=0;}
                          if ($hours1=="0") {$hours1="00";}
                          if ($hours1>"0" && $hours1<"10") {$hours1="0".$hours1;}
                          if ($minutes1=="0") {$minutes1="00";}
                          if ($minutes1>"0" && $minutes1<"10") {$minutes1="0".$minutes1;}
                          if ($seconds1=="0") {$seconds1="00";}
                          if ($seconds1>"0" && $seconds1<"10") {$seconds1="0".$seconds1;}
                          $tiempo_solucion="Días Trascurridos: ".$dias."";
                      }else{$tiempo_solucion = "";}
                      $vencimientof = date_create($fila1->fecha_vencimiento);
                      $vencimientof = date_format($vencimientof, "d-m-Y");
                      $lista_pagares_titulo="<br><p>Documentos por Pagar:</p>";
                      $lista_pagares.="<p>Serie: ".GlobalFunctionsController::eliminarCaracteresSeriePagare($fila1->num_pagare)."</p>
                      <p>Monto: $ $monto_precio_formato<br> ($saldo_letras)</p>
                      <p>Vencimiento: $vencimientof</p>
                      <p>$tiempo_solucion</p>
                      <p>Saldo: $ $saldo_actual</p>
                      <p>Estatus: $fila1->estatus</p><br>";
                  }//Fin de consulta pagares
                  if($fila6->concepto=="Cuenta de Deuda")  $conc="A ".$fila6->concepto;
                  else   $conc=$fila6->concepto;
                  if ($fila6->referencia == "N/A" || $fila6->referencia == "S/N") {  $ref_nueva = "";
                  }else{ $ref_nueva = "<p>No. de Referencia: $fila6->referencia</p>"; }

                  $resulty=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
                  foreach($resulty as $filay){
                      $folio_nuevo=$filay->col1;
                      $folio_anterior=$filay->col2;
                      $actividad=$filay->col3;
                      $depositante=$filay->col4;
                  }
                  /// Fin de Pagares
                  $texto_informacion="
                  <p>Precio: $ $precio_unidad ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                  $ref_nueva
                  "." ".$lista_pagares_titulo." ".$lista_pagares."";
                  // <p>Folio: ".$folio_nuevo." (".$folio_anterior.")</p>
                  /*End información*/
                  if ($fila6->concepto=="Gastos Diversos de Financiamiento") { $folio_nuevo = '';
                  }else{ $folio_nuevo = $folio_nuevo;}

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$conc<br>$folio_nuevo</span></td>
                  <td $color_cuenta><span>$texto_datos</span></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }/************************************************************************************************************************/
              else if ($fila6->concepto=="Compra Permuta" || $fila6->concepto=="Devolución del VIN" || $fila6->concepto=="Cuenta de Deuda") {
                  /*Start fecha formato*/
                  $fecha_movimiento_bien="";
                  $date = date_create($fila6->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');

                  /*Start color estatus*/
                  if ($fila6->datos_estatus=="Pagada") { $color_cuenta="class='estatus-abono-positivo'";
                  }else if ($fila6->datos_estatus=="Pendiente") {  $color_cuenta="class='estatus-abono-negativo'";
                  }else{ $color_cuenta="class='estatus-abono-neutro'"; }

                  /*Start number format precio unidad*/
                  if ($fila6->datos_precio!="") {  $precio_unidad=number_format($mt_total,2);
                  }else{ $precio_unidad=""; }

                  /*Start datos*/
                  $texto_datos="
                  <p>Marca: $fila6->datos_marca</p>
                  <p>Versión: $fila6->datos_version</p>
                  <p>Modelo: $fila6->datos_modelo</p>
                  <p>Color: $fila6->datos_color</p>
                  <p>VIN: $fila6->datos_vin</p>
                  <p>Precio: $ $precio_unidad</p>
                  <p>$fila6->datos_estatus</p>";

                  /*Start conversion de numeros a letras*/
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($precio_unidad,$fila6->tipo_moneda);
                  /*End conversion de numeros a letras*/
                  /*Start definición cargo abono*/
                  $abono=0;
                  $cargo=0;
                  if ($fila6->abono!="") {
                      $abono=$precio_unidad;
                      $tabla_movimientos->abonos+=(float)$precio_unidad;
                  } else { $abono=""; }
                  if ($fila6->cargo!="") {
                      $cargo=$precio_unidad;
                      $tabla_movimientos->cargos+=(float)$precio_unidad;
                  } else { $cargo=""; }

                  if ($fila6->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td>
                      <td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  if ($fila6->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td>
                      <td><span></span></td>";
                      $saldo_total = $saldos + $mt_total;
                      $saldos = $saldo_total;
                      $saldo_total = number_format($saldo_total,2);
                  }
                  if ($fila6->monto_total!="") {
                      $monto_total_general =number_format($mt_total,2);
                  }else{ $monto_total_general="";}
                  /*Start información*/
                  $general_monto="";
                  if ($fila6->concepto!="Venta Permuta"){
                      $general_monto="<br>Serie: "."$fila6->serie_monto";
                  }
                  /*Start number format precio unidad*/
                  if ($fila6->datos_precio!="") {
                      $precio_unidad=number_format($mt_total,2);
                  }else{ $precio_unidad=""; }
                  $monto_total_general =number_format($mt_total,2);
                  /*End number format precio unidad*/
                  if ($fila6->referencia == "N/A" || $fila6->referencia == "S/N") {  $ref_nueva = "";
                  }else{ $ref_nueva = "<p>No. de Referencia: $fila6->referencia</p>"; }
                  $texto_informacion="
                  <p>Precio: $ $precio_unidad ($monto_precio_formato_letras)</p>
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                  ".$ref_nueva."
                  "." ".$lista_pagares_titulo." ".$lista_pagares."";
                  /*End información*/
                  $cncpt = "";
                  if ($fila6->concepto=="Cuenta de Deuda") { $cncpt = "A Cuenta de Deuda";
                  }else{$cncpt = $fila6->concepto;}
                  /*End definición cargo abono*/
                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$cncpt</span></td>
                  <td $color_cuenta><span>$texto_datos</span></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /*End venta directa*/
              /******************************************************Start apartado******************************************************/
              else if ($fila6->concepto=="Devolución Prestamo") {
                  /*Start definición cargo abono*/
                  if ($fila6->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos+=(float)$mt_total;
                  } else { $abono=""; }

                  if ($fila6->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos+=(float)$mt_total;
                  } else { $cargo=""; }

                  if ($fila6->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td>
                      <td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  if ($fila6->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td>
                      <td><span></span></td>";
                      $saldo_total = $saldos + 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($fila6->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$fila6->tipo_moneda);
                  /*End definición cargo abono*/
                  $texto_informacion="<p>Método de pago: $fila6->metodo_pago</p>
                  <p>Monto: $ $abono ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                  <p>No. de Referencia: $fila6->referencia</p>
                  <p>Serie: 1/1</p>
                  <p>Total: $ $abono</p>";

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$fila6->concepto<br>$folio_nuevo</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }/***************************************************************************************************************************/
              else if ($fila6->concepto=="Préstamo") {
                  /*Start definición cargo abono*/
                  if ($fila6->abono!="") {
                      $abono=number_format($mt_total,2);
                      $tabla_movimientos->abonos+=(float)$mt_total;
                  } else { $abono=""; }

                  if ($fila6->cargo!="") {
                      $cargo=number_format($mt_total,2);
                      $tabla_movimientos->cargos+=(float)$mt_total;
                  } else { $cargo=""; }

                  if ($fila6->tipo_movimiento=="abono") {
                      $cargo_abono_texto="<td><span></span></td>
                      <td><span>$ $abono</span></td>";
                      $saldo_total = $saldos - 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  if ($fila6->tipo_movimiento=="cargo") {
                      $cargo_abono_texto="<td><span>$ $cargo</span></td>
                      <td><span></span></td>";
                      $saldo_total = $saldos + 0;
                      $saldos = $saldo_total;
                      $saldo_total = number_format(0,2);
                  }
                  $fecha_movimiento_bien="";
                  $date = date_create($fila6->fecha_movimiento);
                  $fecha_movimiento_bien=date_format($date, 'd-m-Y');
                  $monto_precio_formato_letras= GlobalFunctionsController::convertir($abono,$fila6->tipo_moneda);
                  /*End definición cargo abono*/
                  $texto_informacion="<p>Método de pago: $fila6->metodo_pago</p>
                  <p>Monto: $ $abono ($monto_precio_formato_letras)</p>
                  $tipo_mon
                  $cantidad
                  <p>I. Emisora: $emisora_institucion</p>
                  <p>A. Emisor: $emisora_agente</p>
                  <p>I. Receptora: $receptora_institucion</p>
                  <p>A. Receptor: $receptora_agente</p>
                  <p>Tipo de Comprobante: $fila6->tipo_comprobante</p>
                  <p>No. de Referencia: $fila6->referencia</p>
                  <p>Serie: 1/1</p>
                  <p>Total: $ $abono</p>";

                  $tabla_movimientos->tabla.="<tr>
                  <td><span>$contador</span></td>
                  <td><span>$fecha_movimiento_bien</span></td>
                  <td><span>$fila6->concepto<br>$folio_nuevo</span></td>
                  <td></td>
                  <td><span>$texto_informacion</span></td>
                  $cargo_abono_texto
                  <td><span>$ $saldo_total</span></td>
                  </tr>";
              }
              /*End apartado, enganche*/

          }
          return $tabla_movimientos;
      }

      public function pagaresPagosProveedores($id_pagare){
          $proveedor = DB::select("select proveedores.idproveedores, proveedores.nombre, proveedores.apellidos, proveedores.col2 as moneda, estado_cuenta_proveedores.datos_vin, estado_cuenta_proveedores.datos_modelo, estado_cuenta_proveedores.datos_color, estado_cuenta_proveedores.datos_version, estado_cuenta_proveedores.datos_marca, estado_cuenta_proveedores.datos_precio, estado_cuenta_proveedores.col1, estado_cuenta_proveedores.col2 FROM proveedores, estado_cuenta_proveedores WHERE proveedores.idproveedores=estado_cuenta_proveedores.idcontacto AND estado_cuenta_proveedores.idestado_cuenta_proveedores IN (SELECT idestado_cuenta FROM documentos_pagar WHERE iddocumentos_pagar='$id_pagare')");
          $perfil=$proveedor[0]->idproveedores;
          $nombre=$proveedor[0]->nombre;
          $apellidos=$proveedor[0]->apellidos;
          $nombre_unidad=$proveedor[0]->datos_marca." ".$proveedor[0]->datos_version." ".$proveedor[0]->datos_modelo." ".$proveedor[0]->datos_color;
          $precio_unidad=$proveedor[0]->datos_precio;
          $vin_unidad=$proveedor[0]->datos_vin;
          $folio=$proveedor[0]->col1;
          $moneda=$proveedor[0]->moneda;
          if ($proveedor[0]->col2==null || $proveedor[0]->col2=='') {
              $folio_anterior='N/A';
          }else {
              $folio_anterior=$proveedor[0]->col2;
          }
          // $usuario_creador = request()->cookie('usuario_creador');//usuario clave
          // $usuario_creador= usuarios::where('idusuario','$fila1[usuario_guardo]')->get('nombre')->first();

          // return $usuario_creador;
          // dd($perfil,$nombre,$apellidos,$nombre_unidad,$precio_unidad,$vin_unidad,$folio,$folio_anterior);
          // dd($id_pagare);
          $abonos_pagares_proveedores = abonos_pagares_proveedores::where('iddocumentos_pagar', $id_pagare)->get();
          // dd($abonos_pagares_proveedores);
          // return $abonos_pagares_proveedores;
          // $sql="SELECT proveedores.idproveedores, proveedores.nombre, proveedores.apellidos, estado_cuenta_proveedores.datos_vin, estado_cuenta_proveedores.datos_modelo, estado_cuenta_proveedores.datos_color, estado_cuenta_proveedores.datos_version, estado_cuenta_proveedores.datos_marca, estado_cuenta_proveedores.datos_precio, estado_cuenta_proveedores.col1, estado_cuenta_proveedores.col2 FROM proveedores, estado_cuenta_proveedores WHERE proveedores.idproveedores=estado_cuenta_proveedores.idcontacto AND estado_cuenta_proveedores.idestado_cuenta_proveedores IN (SELECT idestado_cuenta FROM documentos_pagar WHERE iddocumentos_pagar='$id_pagare');";

          return view('admin.account_status.pagares_pagos_proveedores',compact(
              'perfil', 'nombre', 'apellidos', 'nombre_unidad', 'precio_unidad',
              'vin_unidad', 'folio', 'folio_anterior', 'abonos_pagares_proveedores',
              'moneda'
          ));
      }


}
