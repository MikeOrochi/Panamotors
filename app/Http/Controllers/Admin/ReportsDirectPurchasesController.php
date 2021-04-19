<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalFunctionsController;
use App\Models\proveedores;
use App\Models\asesores;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\credito_tipos;
use App\Models\estado_cuenta;
use App\Models\contactos;
use App\Models\estado_cuenta_proveedores;
use App\Models\abonos_unidades_proveedores;
use App\Models\inventario_orden_proveedores_clientes;
use App\Models\estado_cuenta_orden_fechas_proveedores;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ReportsDirectPurchasesController extends Controller
{
   public function reportDirectPurchasesProviders($type_report_direct_purchases, $id_proveedor){
     $proveedor=proveedores::where('idproveedores',$id_proveedor)->get()->first();

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
     // $sql = "SELECT *FROM proveedores WHERE idproveedores='$id_contacto'";
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
     if(!empty($calle)) $domicilio_completo.=ucfirst($calle);
     if(!empty($colonia)) $domicilio_completo.=ucfirst($colonia).", ";
     if(!empty($municipio))$domicilio_completo.=ucfirst($municipio).", ";
     $domicilio_completo.=ucfirst($estado);

     $count_orden = 0;
     $result101x = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('concepto','Compra Directa')->orderBy('fecha_movimiento','ASC')->get();
     foreach($result101x as $value) {
        $count_orden++;
        if ($value->concepto == 'Compra Permuta' && $count_orden == 1) {
           $result101x1 = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('concepto','Venta Permuta')->orderBy('fecha_movimiento','ASC')->take(1);
           foreach($result101x1 as $value_account) {
           estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
             $value_account->idestado_cuenta_proveedores, $value_account->concepto,  $value_account->apartado_usado,  $value_account->tipo_movimiento,  $value_account->efecto_movimiento,
             $value_account->fecha_movimiento,  $value_account->metodo_pago,  $value_account->saldo_anterior,  $value_account->saldo,  $value_account->monto_precio,
             $value_account->serie_monto,  $value_account->monto_total,  $value_account->tipo_moneda,  $value_account->tipo_cambio,  $value_account->gran_total,
             $value_account->cargo,  $value_account->abono,  $value_account->emisora_institucion,  $value_account->emisora_agente,  $value_account->receptora_institucion,
             $value_account->receptora_agente,  $value_account->tipo_comprobante,  $value_account->referencia,  $value_account->datos_marca,  $value_account->datos_version,
             $value_account->datos_color,  $value_account->datos_modelo,  $value_account->datos_vin,  $value_account->datos_precio,  $value_account->datos_estatus,
             $value_account->asesor1,  $value_account->enlace1,  $value_account->asesor2,  $value_account->enlace2,  $value_account->coach,
             $value_account->archivo,  $value_account->comentarios,  $value_account->idcontacto,  $value_account->comision,  $value_account->visible,
             $value_account->comentarios_eliminacion,  $value_account->usuario_elimino,  '0001-01-01 00:00:00',  $value_account->usuario_creador,  $value_account->fecha_creacion,
             $value_account->fecha_guardado, $count_orden );
           }
           $count_orden++;
         estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
           $value->idestado_cuenta_proveedores, $value->concepto,  $value->apartado_usado,  $value->tipo_movimiento,  $value->efecto_movimiento,
           $value->fecha_movimiento,  $value->metodo_pago,  $value->saldo_anterior,  $value->saldo,  $value->monto_precio,
           $value->serie_monto,  $value->monto_total,  $value->tipo_moneda,  $value->tipo_cambio,  $value->gran_total,
           $value->cargo,  $value->abono,  $value->emisora_institucion,  $value->emisora_agente,  $value->receptora_institucion,
           $value->receptora_agente,  $value->tipo_comprobante,  $value->referencia,  $value->datos_marca,  $value->datos_version,
           $value->datos_color,  $value->datos_modelo,  $value->datos_vin,  $value->datos_precio,  $value->datos_estatus,
           $value->asesor1,  $value->enlace1,  $value->asesor2,  $value->enlace2,  $value->coach,
           $value->archivo,  $value->comentarios,  $value->idcontacto,  $value->comision,  $value->visible,
           $value->comentarios_eliminacion,  $value->usuario_elimino,  '0001-01-01 00:00:00',  $value->usuario_creador,  $value->fecha_creacion,
           $value->fecha_guardado, $count_orden );
        }else{
         estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
           $value->idestado_cuenta_proveedores, $value->concepto,  $value->apartado_usado,  $value->tipo_movimiento,  $value->efecto_movimiento,
           $value->fecha_movimiento,  $value->metodo_pago,  $value->saldo_anterior,  $value->saldo,  $value->monto_precio,
           $value->serie_monto,  $value->monto_total,  $value->tipo_moneda,  $value->tipo_cambio,  $value->gran_total,
           $value->cargo,  $value->abono,  $value->emisora_institucion,  $value->emisora_agente,  $value->receptora_institucion,
           $value->receptora_agente,  $value->tipo_comprobante,  $value->referencia,  $value->datos_marca,  $value->datos_version,
           $value->datos_color,  $value->datos_modelo,  $value->datos_vin,  $value->datos_precio,  $value->datos_estatus,
           $value->asesor1,  $value->enlace1,  $value->asesor2,  $value->enlace2,  $value->coach,
           $value->archivo,  $value->comentarios,  $value->idcontacto,  $value->comision,  $value->visible,
           $value->comentarios_eliminacion,  $value->usuario_elimino,  '0001-01-01 00:00:00',  $value->usuario_creador,  $value->fecha_creacion,
           $value->fecha_guardado, $count_orden );
        }



     }

     $idestado_cuenta_general = "";
     $COUNT=0;
     $bandera = false;
     $contador =0;
     $count_verifica_mov = 0;

     $ref = ""; $ref_band = "";
     $num_unidades = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->get()->groupBy('datos_vin')->count();
     $result101 =  estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('referencia','!=','S/N')->where('referencia','!=','N/A')->get()->groupBy('referencia');
     foreach($result101 as $fila101) {
        $ref .= $fila101[0]->referencia.",";
        $ref_band .= "NO".",";
     }
     $ref_total = rtrim($ref,',');
     $ref_bandera = rtrim($ref_band,',');
     $referencia_array = explode(",", $ref_total);
     $referencia_bandera = explode(",", $ref_bandera);

     $tabla_movimientos = (object)['tabla'=>null, 'cargos'=>0, 'abonos'=>0];
     $result100 = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->orderBy('orden','ASC')->get();
     $bandera_cont = "";
     foreach ($result100 as $fila100) {
        $mov_anulados="";
        $referencia	= "$fila100->referencia";
        $count_verifica_mov++;
        /***********************************************************************************************************************************************************/
        if($type_report_direct_purchases == "compras_directas_proveedores" || $type_report_direct_purchases == "compras_directas_comisiones"){
            if ("$fila100->referencia" != "N/A" && $bandera == false || "$fila100->referencia" != "S/N" && $bandera == false || "$fila100->referencia" != "N/A" && $bandera != false || "$fila100->referencia" != "S/N" && $bandera != false) {
               for ($i=0; $i < sizeof($referencia_array) ; $i++) {
                  if ($referencia_array[$i]==$referencia && $referencia_bandera[$i] === "NO") {
                  }
                  if ($referencia_array[$i]=== $referencia && $referencia_bandera[$i] === "NO") {
                     $referencia_bandera[$i] = "SI";
                     $result5 = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('referencia',$referencia)->where('referencia','!=','S/N')->orderBy('referencia','ASC')->get();
                    $count5 = count($result5);
                    $result5 = $result5->sum("monto_precio");
                      $bandera = true;
                      $contador++;
                      $mov_anulados = $count5;
                      $count_verifica_mov = 1;

                      // if ($procedencia_proveedor == 'USA') {
                      //   $mnt_total=$fila100->gran_total;
                      // }else{
                        $mnt_total=$result5;
                      // }
                      $this->imprimirComprasDirectasProveedores($fila100->idestado_cuenta_orden_fechas_proveedores, $mnt_total, $id_contacto, $contador, "",$type_report_direct_purchases,$tabla_movimientos);

                  }else{
                     $bandera = true;
                  }
               }

            }
            if ("$fila100->referencia" === "N/A" || "$fila100->referencia" === "S/N") {
               $fv = date_create("$fila100->fecha_movimiento");
               $fv = date_format($fv, "d-m-Y");
               $bandera = false;
               $contador++;
              //  if ($procedencia_proveedor == 'USA') {
              //   $mnt_total=$fila100->gran_total;
              // }else{
                $mnt_total=$fila100->monto_precio;
              // }
               $this->imprimirComprasDirectasProveedores("$fila100->idestado_cuenta_orden_fechas_proveedores", $mnt_total, $id_contacto, $contador, $fv, $type_report_direct_purchases, $tabla_movimientos);
            }

            $mov_anulados = $mov_anulados;
            if ($mov_anulados == $count_verifica_mov) {
               $bandera = false;
            }
        }
        /*********************************************************************************************************************************************************************/
        if($type_report_direct_purchases == "compras_directas_proveedores_deuda_sin_inventario" || $type_report_direct_purchases == "compras_directas_proveedores_pagado_sin_inventario" || $type_report_direct_purchases == "compras_directas_proveedores_deuda"){
            if ("$fila100->referencia" != "N/A" && $bandera == false || "$fila100->referencia" != "S/N" && $bandera == false || "$fila100->referencia" != "N/A" && $bandera != false || "$fila100->referencia" != "S/N" && $bandera != false) {
           		for ($i=0; $i < sizeof($referencia_array) ; $i++) {
           			if ($referencia_array[$i]==$referencia && $referencia_bandera[$i] === "NO") {
           			//echo "<b>2525 tendra que pasar</b>";
           			}

           		}

           	}
           	if ("$fila100->referencia" === "N/A" || "$fila100->referencia" === "S/N") {
           		$fv = date_create("$fila100->fecha_movimiento");
           		$fv = date_format($fv, "d-m-Y");
           		$bandera = false;

           		if ($bandera_cont === true) {
           			$contador++;
           		}


           		// if ($procedencia_proveedor == 'USA') {
           			// $mnt_total="$fila100->gran_total";
           		// }else{
           			$mnt_total="$fila100->monto_precio";

           		// }


                $this->imprimirComprasDirectasProveedores("$fila100->idestado_cuenta_orden_fechas_proveedores", $mnt_total, $id_contacto, $contador, $fv, $type_report_direct_purchases, $tabla_movimientos);
           	}

           	//echo "<b>$count_verifica_mov</b><br>";
           	$mov_anulados = $mov_anulados;
           	if ($mov_anulados == $count_verifica_mov) {
           		$bandera = false;
           	}
           	//$count_verifica_mov = 0;
        }
        /*********************************************************************************************************************************************************************/

     }
     if($type_report_direct_purchases != "compras_directas_comisiones") $pdf_type="reporte_compras_directas_proveedores";
     else $pdf_type="compras_directas_comisiones";
     $view=View::make('admin.reports.direct_purchases',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesor','tabla_movimientos','pdf_type','num_unidades'));
     GlobalFunctionsController::createPdf($view, $nombre, $apellidos, $id_contacto_completo, "admon_compras", $type_report_direct_purchases,"","");
     return view('admin.reports.direct_purchases',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesor','tabla_movimientos','pdf_type'));
   }

  function imprimirComprasDirectasProveedores($idec, $mt_total, $idc, $contador, $fechas_mv ,$type_report_direct_purchases, $tabla_movimientos){
      global $saldo_total;
      global $saldos;
      $datos_venta = "";
      $color_cuenta = "";
      $bandera_cont = "";

      $result6 = estado_cuenta_orden_fechas_proveedores::where('idcontacto',$idc)->where('visible','SI')->where('idestado_cuenta_orden_fechas_proveedores',$idec)->get();
      foreach ($result6 as $fila6) {
         if($fila6->concepto=="Compra Directa" || $fila6->concepto=="Cuenta de Deuda" || $fila6->concepto=="Consignacion" || $fila6->concepto=="Devolución del VIN"){
            $resultz=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
            foreach($resultz as $filaz){
               $folio_nuevo=$filaz->col1;
               $folio_anterior=$filaz->col2;
               if($fila6->concepto=="Cuenta de Deuda")
                  $contador.".- "." "."$fila6->idestado_cuenta_orden_fechas_proveedores"."=>"."A $fila6->concepto<br>Folio: $filaz->col1"." "."$fila6->fecha_movimiento"."<br>";
               else
                  $contador.".- "." "."$fila6->idestado_cuenta_orden_fechas_proveedores"."=>"."A $fila6->concepto<br>Folio: $filaz->col1"." "."$fila6->fecha_movimiento"."<br>";
            }
         }
         else
            $contador.".- "." "."$fila6->idestado_cuenta_orden_fechas_proveedores"."=>"."A $fila6->concepto"." "."$fila6->fecha_movimiento"."<br>";
         /*Start COMPRA DIRECTA*/
         if ($fila6->concepto=="Compra Directa") {
            if ($fila6->datos_estatus == "Pagada") {
               $estatus_unidad="Estatus:  <span  style='color:#00b248;'><b>$fila6->datos_estatus</b></span><br>";
            }else{
               $estatus_unidad="Estatus:  <span  style='color:red;'><b>$fila6->datos_estatus</b></span><br>";
            }
            $saldo_unidad = 0;
            $result85=abonos_unidades_proveedores::where('idestado_cuenta',$fila6->idestado_cuenta_orden_fechas_proveedores)->where('visible','SI')->get();
            foreach($result85 as $fila85) {
               if(!empty($fila85->cantidad_pago))$saldo_unidad = $saldo_unidad + $fila85->cantidad_pago;
            }
            if(!empty($fila6->datos_precio))$saldo_unidad = $fila6->datos_precio - $saldo_unidad;
            $saldo_total = $saldo_total+$saldo_unidad;
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
                  $resultado3 = check_list_expediente_original::where('idorden_compra_unidades',$fila850->idorden_compra)>where('visible','SI')->where('tipo_check_list','Ingreso')->where('entrega','!=','NO')->get();
                  $numero_check = count($resultado3);
                  $pendientes = 0;
                  $cargados = 0;
                  foreach ($resultado3 as $fila3) {
                     $entrega = "$fila3->entrega";
                     $archivo = "$fila3->archivo";
                     if ($entrega == "Pendiente" || $entrega == "Pendiente2") {
                        $pendientes++;
                     }
                     if ($entrega == "SI") {
                        if($archivo != ""){
                           $cargados++;
                        }else{
                           $pendientes++;
                        }
                     }
                  }
                  if ($numero_check == $cargados) {
                     $expediente_cmp = 'Completo';
                  } else {
                     $expediente_cmp = 'Incompleto';
                  }
               }
               $result850x = inventario::where('vin_numero_serie',$fila6->datos_vin)->get();
               foreach($result850x as $fila850x) {
                  $fecha_ingreso = $fila850x->fecha_ingreso;
               }
               /******************************************************************************************************************/
               if($type_report_direct_purchases == "compras_directas_proveedores"){
                   if (count($result850x) == 0) {
                       $result851x = inventario_trucks::where('vin_numero_serie',$fila6->datos_vin)->get();
                       foreach($result851x as $fila851x) {
                           $fecha_ingreso = $fila851x->fecha_ingreso;
                       }
                       if (count($result851x) == 0) {
                           $estatus_unidad_inventario = '<b style="color: red;">Sin Ingreso</b>';
                           $fecha_ingreso = 'N/A';
                           $expediente_cmp = 'N/A';
                       } else {
                           $estatus_unidad_inventario = 'SI';
                           $fecha_ingreso = date_create($fecha_ingreso);
                           $fecha_ingreso = date_format($fecha_ingreso, 'd-m-Y');
                           $expediente_cmp = 'N/A';
                       }
                   } else {
                       $estatus_unidad_inventario = 'SI';
                       $fecha_ingreso = date_create($fecha_ingreso);
                       $fecha_ingreso = date_format($fecha_ingreso, 'd-m-Y');
                       $expediente_cmp = 'N/A';
                   }
               }
               /*******************************************************************************************************************/
               if($type_report_direct_purchases == "compras_directas_proveedores_deuda_sin_inventario" || $type_report_direct_purchases == "compras_directas_proveedores_pagado_sin_inventario" || $type_report_direct_purchases == "compras_directas_proveedores_deuda" || $type_report_direct_purchases == "compras_directas_comisiones"){
                   if (count($result850x) == 0) {
                       $estatus_unidad_inventario = '<b style="color: red;">Sin Ingreso</b>';
                       $fecha_ingreso = 'N/A';
                       $expediente_cmp = 'N/A';
                   } else {
                       $estatus_unidad_inventario = 'SI';
                       $fecha_ingreso = date_create($fecha_ingreso);
                       $fecha_ingreso = date_format($fecha_ingreso, 'd-m-Y');
                       $expediente_cmp = 'N/A';
                   }
               }

               /*******************************************************************************************************************/
            }
            $precio_unidadx1 = $fila6->datos_precio;
            $precio_unidadx1 = number_format($precio_unidadx1, 2);
            $datos_pe="Precio: $ $precio_unidadx1<br>
            $estatus_unidad ";

            $texto_datos="
            Marca: $fila6->datos_marca<br>
            Versión: $fila6->datos_version<br>
            Modelo: $fila6->datos_modelo<br>
            Color: $fila6->datos_color<br>
            VIN: $fila6->datos_vin<br>
            $datos_pe ";
            /*End datos*/
            /*Start conversion de numeros a letras*/
            // if ($procedencia_proveedor == 'USA') {
            //    $cant_precio = $fila6->gran_total;
            //    $tipo_moneda_con = '';
            // }else{
               $cant_precio = $fila6->monto_precio;
               // $tipo_moneda_con = 'MXN';
            // }
            $monto_precio_formato_letras= GlobalFunctionsController::convertir($cant_precio, $fila6->tipo_moneda);
            // $monto_precio_formato_letras_m_pago= FunctionsController::convertir($m_pago);
            /*End conversion de numeros a letras*/
            /*Start definición cargo abono*/

            if ($fila6->monto_total!="") {
               $monto_total_general=number_format($fila6->monto_total,2);
            }else{ $monto_total_general="";}
            /*Start información*/
            $general_monto="";
            $general_monto="Serie: "."$fila6->serie_monto";
            /*Start number format precio unidad*/
            if ($fila6->datos_precio!="") {
               // if ($procedencia_proveedor === 'USA') {
                  // $precio_unidad=number_format("$fila6->gran_total",2);
               // }else{
                  $precio_unidad=number_format("$fila6->cargo",2);
               // }
            }else{ $precio_unidad=""; }
            $monto_total_general=$precio_unidad;
            /*End number format precio unidad*/
            $resulty=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
            foreach($resulty as $filay){
               $folio_nuevo=$filay->col1;
               $folio_anterior=$filay->col2;
               $actividad=$filay->col3;
               $depositante=$filay->col4;

               /*************************************************************************************************************************************************************/
               if($type_report_direct_purchases == "compras_directas_proveedores"){
                   $datos_vin_dcc=$filay->datos_vin;
                   $resulty11=estado_cuenta::where('datos_vin',$filay->datos_vin)->where('visible','SI')->where('concepto','Venta Directa')->orWhere('datos_vin',$filay->datos_vin)->where('visible','SI')->where('concepto','Venta Permuta')->get();
                   foreach($resulty11 as $filay11){
                       $fecha_movimiento_venta = '';
                       $fecha_movimiento_venta = date_create($filay11->fecha_movimiento);
                       $fecha_movimiento_venta = date_format($fecha_movimiento_venta, 'd-m-Y');

                       $resulty12=contactos::where('idcontacto',$filay11->idcontacto)->get();
                       foreach($resulty12 as $filay12){
                           $datos_venta .= '<b>Cliente/ID: </b>'.$filay11->idcontacto.'.'.$filay11->nombre.' '.$filay11->apellidos.'<br>Fecha de mov.: '.$fecha_movimiento_venta.'<br>';
                       }
                   }
               }
               /***********************************************************************************************************************************************************/
            }
            /// Fin de Pagares
            /*************************************************************************************************************************************************************/
            if($type_report_direct_purchases == "compras_directas_proveedores"){
                $texto_informacion="
                Inventario:  $estatus_unidad_inventario<br>
                Fecha de ingreso: $fecha_ingreso  <br>

                Expediente:  $expediente_cmp
                <br><h4>Venta</h4> $datos_venta ";
                /*End información*/
                if ($fila6->concepto=="Gastos Diversos de Financiamiento") {
                    $folio_nuevo = '';
                }else{
                    $folio_nuevo = $folio_nuevo;
                }
                $saldo_unidad = number_format($saldo_unidad, 2);
                $saldo_totalx = number_format($saldo_total, 2);
                $fecha_movimiento_bien="";
                $date = date_create($fila6->fecha_movimiento);
                $fecha_movimiento_bien=date_format($date, 'd-m-Y');

                $tabla_movimientos->tabla.="<tr>
                <td><span>$contador</span></td>
                <td><span>$fecha_movimiento_bien</span></td>
                <td><span>$fila6->concepto<br>$folio_nuevo</span></td>
                <td $color_cuenta><span>$texto_datos</span></td>
                <td><span>$texto_informacion</span></td>
                <td><span>$ $saldo_unidad</span></td>
                <td><span>$ $saldo_totalx</span></td>
                </tr>";
            }
         }
         /*******************************************************************************************************************************************************/

         if($type_report_direct_purchases == "compras_directas_proveedores_deuda_sin_inventario" || $type_report_direct_purchases == "compras_directas_proveedores_pagado_sin_inventario" || $type_report_direct_purchases == "compras_directas_proveedores_deuda"){
             $texto_informacion="Ingreso: $fecha_ingreso  <br>
             Inventario:  $estatus_unidad_inventario<br>
             Expediente:  $expediente_cmp";
             /*End información*/
             if ($fila6->concepto=="Gastos Diversos de Financiamiento") {
                 $folio_nuevo = '';
             }else{
                 $folio_nuevo = $folio_nuevo;
             }

             if ($saldo_unidad > 0 && $estatus_unidad_inventario === '<b style="color: red;">Sin Ingreso</b>') {
                 $bandera_cont = true;
                 $saldo_unidad = number_format($saldo_unidad, 2);
                 $saldo_totalx = number_format($saldo_total, 2);
                 $fecha_movimiento_bien="";
                 $date = date_create($fila6->fecha_movimiento);
                 $fecha_movimiento_bien=date_format($date, 'd-m-Y');

                 $tabla_movimientos->tabla.="<tr>
                 <td><span>$contador</span></td>
                 <td><span>$fecha_movimiento_bien</span></td>
                 <td><span>$fila6->concepto<br>$folio_nuevo</span></td>
                 <td $color_cuenta><span>$texto_datos</span></td>
                 <td><span>$texto_informacion</span></td>
                 <td><span>$ $saldo_unidad</span></td>
                 <td><span>$ $saldo_totalx</span></td>
                 </tr>";
             }else{
                 $bandera_cont = false;
             }
         }
         /***************************************************************************************************************************************************/
         if($type_report_direct_purchases == "compras_directas_comisiones"){
             $texto_informacion="Ingreso: $fecha_ingreso  <br>
 			Inventario:  $estatus_unidad_inventario<br>
 			Expediente:  $expediente_cmp";
 			/*End información*/
 			if ($fila6['concepto']=="Gastos Diversos de Financiamiento") {
 				$folio_nuevo = '';
 			}else{
 				$folio_nuevo = $folio_nuevo;
 			}

 			$concepto_adelante='';
 			// $resulty1=SELECT col1 FROM estado_cuenta_proveedores where idestado_cuenta_proveedores IN
            // (SELECT idestado_cuenta_orden_fechas_proveedores FROM estado_cuenta_orden_fechas_proveedores where idestado_cuenta_orden_fechas_proveedores = '$fila6[idestado_cuenta_orden_fechas_proveedores]')";;
            $query_result =  estado_cuenta_orden_fechas_proveedores::select('idestado_cuenta_orden_fechas_proveedores')->where('idestado_cuenta_orden_fechas_proveedores',$fila6->idestado_cuenta_orden_fechas_proveedores)->get();
 			$resulty1=estado_cuenta_proveedores::whereIn('idestado_cuenta_proveedores',$query_result)->get();
 			foreach($resulty1 as $filay1){
 				// $sqly2="SELECT * FROM estado_cuenta_proveedores where col1 = '$filay1[0]' and concepto = 'Comisión por Mediación Mercantil' || col1 = '$filay2[0]' and concepto = 'Comision de Compra'";
 				$resulty2=estado_cuenta_proveedores::where('col1',$filay1->idestado_cuenta_proveedores)->where('concepto','Comisión por Mediación Mercantil')->orWhere('col1',$filay1->idestado_cuenta_proveedores)->where('concepto','Comision de Compra')->get();
 				foreach($resulty2 as $filay2){
 					$concepto_adelante=$filay2->concepto;
 					$no_referencia_fac=$filay2->referencia;
 					$monto_precio_fac=$filay2->monto_precio;
 					$monto_precio_fac_validar=$filay2->monto_precio;
 				}

 				// $sqly3="SELECT * FROM estado_cuenta_proveedores where col1 = '$filay1[0]' and concepto = 'Devolución de Comisión por Mediación Mercantil'";
 				$resulty3=estado_cuenta_proveedores::where('col1',$filay1->idestado_cuenta_proveedores)->where('concepto','Devolución de Comisión por Mediación Mercantil')->get();


 			}

 			if (count($resulty2) == 0) {
 				$concepto_adelante='UNIDAD DEMO';
 				$no_referencia_fac='N/A';
 				$monto_precio_fac='N/A';
 				if (count($resulty3) == 1) {
 					$estatus_comision='N/A';

 				}else{
 					$estatus_comision='N/A';
 				}
 			}else{
 				$monto_precio_fac = '$ '.number_format($monto_precio_fac, 2);
 				if (count($resulty3) == 1) {
 					foreach($resulty3 as $filay3){
 						$precio_dev = $filay3->monto_precio;
 						if ($precio_dev < $monto_precio_fac_validar) {
 							$estatus_comision='Pendiente<br>Saldo: $ '.number_format(($monto_precio_fac_validar-$precio_dev), 2);
 						}else if ($precio_dev === $monto_precio_fac_validar){
 							$estatus_comision='Pagada';

 						}else{
 							$estatus_comision='N/A';

 						}
 					}


 				}else{
 					$estatus_comision='Pendiente';
 				}
 			}
 			$saldo_unidad = number_format($saldo_unidad, 2);
 			$saldo_totalx = number_format($saldo_total, 2);
 			$fecha_movimiento_bien="";
 			$date = date_create($fila6->fecha_movimiento);
 			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
 			$tabla_movimientos->tabla.="<tr>
 			<td><span>$contador</span></td>
 			<td><span>$fecha_movimiento_bien</span></td>
 			<td><span>$fila6->concepto<br>$folio_nuevo</span></td>
 			<td $color_cuenta><span>$texto_datos</span></td>
 			<td><span>$texto_informacion</span></td>
 			<td><span>$concepto_adelante</span></td>
 			<td><span>$no_referencia_fac</span></td>
 			<td><span>$monto_precio_fac</span></td>
 			<td><span>$estatus_comision</span></td>
 			</tr>";
         }



         /***************************************************************************************************************************************************/
         /*End venta directa*/
      }
      return $tabla_movimientos;
  }


}
