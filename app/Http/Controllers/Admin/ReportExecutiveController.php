<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\GlobalFunctionsController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\estado_cuenta_proveedores;
use App\Models\abonos_unidades_proveedores;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\documentos_pagar;
use App\Models\proveedores;
use App\Models\abonos_pagares_proveedores;
use Mpdf\Mpdf; #Php 7.0

class ReportExecutiveController extends Controller
{
   public function reportExecutive(){
      /*Compra Directa - Cuenta de Deuda - Devolución del VIN -
      Venta Directa - Venta Permuta -  Compra Permuta  - Consignacion  */
      // DB::beginTransaction();
      // try {
        $values_prueba = "";
         $tabla_movimientos = (object)['tabla'=>collect([]),'cargos'=>0, 'abonos'=>0,
         'monto_documentos_pagados'=>0, 'num_documentos_pagados'=>0,
         'num_documentos_pendientes'=>0, 'monto_documentos_pendientes'=>0,
         'num_virtuales_pendientes'=>0, 'monto_virtuales_pendientes'=>0,
         'num_fisicos_pendientes'=>0, 'monto_fisicos_pendientes'=>0];

         $fecha_impresion = new \DateTime(now());
         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         $mes = $meses[($fecha_impresion->format('n')) - 1];
         $fecha_i = request('fecha_inicial');
         $fecha_f = request('fecha_final');
         $fecha_inicial = (new \DateTime($fecha_i))->format('Y-m-d');
         $fecha_final = (new \DateTime($fecha_f))->format('Y-m-d');

         $estado_cuenta_proveedores_vin = estado_cuenta_proveedores::whereIn("concepto",
            ["Venta Directa","Venta Permuta","Compra Directa","Compra Permuta","Cuenta de Deuda","Consignacion","Devolución del VIN"]
            )->where('visible','SI')->where('fecha_creacion','<=',$fecha_final)->where('fecha_creacion','>=',$fecha_inicial)->get();

        /********************************* ANALISIS GLOBAL UNIDADES **************************************************************/
        $estatus = ['Pagada','Pendiente'];
        $tipo_moneda = ['MXN','USD','CAD'];
        $concepto = ['Compra Directa', 'Cuenta de Deuda', 'Devolución del VIN'];
        $tabla_unidades = (object)[
            'MXN' =>(object)[
                'pagadas'=>collect([]),'total_unidades_pagadas'=>0, 'total_monto_pagadas'=>0,
                'pendientes'=>collect([]), 'total_unidades_pendientes'=>0, 'total_monto_pendientes'=>0,
                'total_pagado_pendientes'=>(object)['directas'=>0,'cuenta_deuda'=>0,'devolucion_vin'=>0],
                'total_pagado_pendientes_global'=>0,
                'total_restante_pendientes'=>(object)['directas'=>0,'cuenta_deuda'=>0,'devolucion_vin'=>0],
                'total_restante_pendientes_global'=>0],
            'USD'=>(object)[
                'pagadas'=>collect([]), 'total_unidades_pagadas'=>0, 'total_monto_pagadas'=>0,
                'pendientes'=>collect([]), 'total_unidades_pendientes'=>0, 'total_monto_pendientes'=>0,
                'total_pagado_pendientes'=>(object)['directas'=>0,'cuenta_deuda'=>0,'devolucion_vin'=>0],
                'total_pagado_pendientes_global'=>0,
                'total_restante_pendientes'=>(object)['directas'=>0,'cuenta_deuda'=>0,'devolucion_vin'=>0],
                'total_restante_pendientes_global'=>0],
            'CAD'=>(object)[
                'pagadas'=>collect([]), 'total_unidades_pagadas'=>0, 'total_monto_pagadas'=>0,
                'pendientes'=>collect([]), 'total_unidades_pendientes'=>0, 'total_monto_pendientes'=>0,
                'total_pagado_pendientes'=>(object)['directas'=>0,'cuenta_deuda'=>0,'devolucion_vin'=>0],
                'total_pagado_pendientes_global'=>0,
                'total_restante_pendientes'=>(object)['directas'=>0,'cuenta_deuda'=>0,'devolucion_vin'=>0],
                'total_restante_pendientes_global'=>0]
        ];

        foreach ($tipo_moneda as $value_tipo_moneda) {
            foreach ($estatus as $value_estatus) {

                $row_unidades = ['directas'=>0,'monto_directas'=>0,'cuenta_deuda'=>0,'monto_cuenta_deuda'=>0,'devolucion_vin'=>0,'monto_devolucion_vin'=>0];
                $num_compras = count($estado_cuenta_proveedores_vin->where('datos_estatus',$value_estatus)->where('tipo_moneda',$value_tipo_moneda)->groupBy('datos_vin'));
                $monto_compras = $estado_cuenta_proveedores_vin->where('datos_estatus',$value_estatus)->where('tipo_moneda',$value_tipo_moneda)->sum('monto_precio');
                if($value_estatus == "Pendiente"){
                    $tabla_unidades->$value_tipo_moneda->total_unidades_pendientes = $num_compras;
                    $tabla_unidades->$value_tipo_moneda->total_monto_pendientes = $monto_compras;
                }
                if($value_estatus == "Pagada"){
                    $tabla_unidades->$value_tipo_moneda->total_unidades_pagadas = $num_compras;
                    $tabla_unidades->$value_tipo_moneda->total_monto_pagadas = $monto_compras;
                }
                $flag_push = "no";
                foreach ($concepto as $key => $value_concepto) {
                    $compras = $estado_cuenta_proveedores_vin->where('concepto',$value_concepto)->where('datos_estatus',$value_estatus)->where('tipo_moneda',$value_tipo_moneda);
                    $num_compras = $compras->groupBy('datos_vin')->count();
                    $monto = $compras->sum('datos_precio');
                    if($value_concepto == "Compra Directa" && count($compras) != 0){ $row_unidades['directas'] = $num_compras; $row_unidades['monto_directas'] = $monto; $flag_push = "si";}
                    if($value_concepto == "Cuenta de Deuda" && count($compras) != 0){ $row_unidades['cuenta_deuda'] = $num_compras; $row_unidades['monto_cuenta_deuda'] = $monto; $flag_push = "si";}
                    if($value_concepto == "Devolución del VIN" && count($compras) != 0){ $row_unidades['devolucion_vin'] = $num_compras; $row_unidades['monto_devolucion_vin'] = $monto; $flag_push = "si";}

                }
                if($value_estatus == "Pagada" && $flag_push = "si") $tabla_unidades->$value_tipo_moneda->pagadas->push($row_unidades);
                if($value_estatus == "Pendiente" && $flag_push = "si") $tabla_unidades->$value_tipo_moneda->pendientes->push($row_unidades);
            }
        }
        /********************************* GENERACION DE TABLA DETALLADA **************************************************************/
         foreach ($estado_cuenta_proveedores_vin->groupBy('datos_vin') as $key => $value_array) {
            $contacto = collect([]);
            foreach ($value_array as $key => $value) {
               $proveedor = proveedores::where('idproveedores',$value->idcontacto)->get()->first();
               if(!empty($proveedor)){
                  $contacto->push($proveedor->nombre." ".$proveedor->apellidos);
               }
            }
            foreach ($value_array as $key => $value_estado_cuenta_proveedor) {
               $idec = $value_estado_cuenta_proveedor->idestado_cuenta_proveedores; $mt_total = $value_estado_cuenta_proveedor->monto_precio;
               $contador = 0;
               $saldos = 0;

               $row = ['fecha'=>'','proveedor'=>'','datos'=>'','informacion'=>'','cargos'=>'','abonos'=>'','saldo'=>'', 'proveedor' => $contacto];
               $tipo_mon = "";
         		$cambio = "";
         		$cantidad = "";
         		if ($value_estado_cuenta_proveedor->tipo_moneda == "MXN" || $value_estado_cuenta_proveedor->tipo_moneda == "USD" || $value_estado_cuenta_proveedor->tipo_moneda == "CAD") {
         			$cambio = number_format($value_estado_cuenta_proveedor->tipo_cambio,2);
         			$tipo_mon = "<p>Moneda: $value_estado_cuenta_proveedor->tipo_moneda</p> <p>T. Cambio: $cambio</p>";
         			$cantidad = "Cantidad: ".number_format((float)$value_estado_cuenta_proveedor->gran_total, 2)."";
         		}else{
         			$tipo_mon = "";
         			$cantidad = "";
         		}

               if ($value_estado_cuenta_proveedor->datos_estatus == "Pagada") {
      				$estatus_unidad="Estatus:  <span  style='color:#00b248;'><b>$value_estado_cuenta_proveedor->datos_estatus</b></span>";
      			}else{
      				$estatus_unidad="Estatus:  <span  style='color:red;'><b>$value_estado_cuenta_proveedor->datos_estatus</b></span>";
      			}
      			/*Start fecha formato*/
      			$fecha_movimiento_bien="";
      			$date = date_create($value_estado_cuenta_proveedor->fecha_movimiento);
      			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
      			/*End fecha formato*/

      			/*Start number format precio unidad*/
               $precio_unidad = "";
      			if ($value_estado_cuenta_proveedor->datos_precio!="") {
      				$precio_unidad=number_format("$value_estado_cuenta_proveedor->datos_precio",2);
                  $row['costo'] = $precio_unidad;
      			}else{
      				$precio_unidad="";
      			}

      			$saldo_unidad = 0;
      			$abonos_unidades_proveedores= abonos_unidades_proveedores::where('idestado_cuenta',$value_estado_cuenta_proveedor->idestado_cuenta_proveedores)->where('visible','SI')->get();
               foreach ($abonos_unidades_proveedores as $key => $value) {
                  if(!empty($value->cantidad_pago))$saldo_unidad = $saldo_unidad + $value->cantidad_pago;
               }
               $saldo_abonos = $saldo_unidad;
      			$saldo_unidad = $value_estado_cuenta_proveedor->datos_precio - $saldo_unidad;
                $saldo_abonos_cargos = $saldo_unidad;
      			$saldo_unidad = "Saldo: $ ".number_format($saldo_unidad, 2);

                /********************************* SELECCIONAR ANTICIPOS*********************************/
                if($value_estado_cuenta_proveedor->datos_estatus == "Pendiente"){
                    $abonos_anticipos = abonos_unidades_proveedores::where('idestado_cuenta',$value_estado_cuenta_proveedor->idestado_cuenta_proveedores)->get();
                    foreach ($abonos_anticipos as $key => $value_abono) {
                        $documento_pagar_temp = abonos_pagares_proveedores::where('idestado_cuenta_movimiento',$value_abono->idestado_cuenta_movimiento)->get()->first();
                        $temp_moneda = $value_estado_cuenta_proveedor->tipo_moneda;
                        if(empty($documento_pagar_temp)){
                            $tabla_unidades->$temp_moneda->total_pagado_pendientes_global += $value_abono->monto_total;
                            if($value_estado_cuenta_proveedor->concepto == "Compra Directa"){
                                $tabla_unidades->$temp_moneda->total_pagado_pendientes->directas += $value_abono->monto_total;
                            }
                            if($value_estado_cuenta_proveedor->concepto == "Cuenta de Deuda"){
                                $tabla_unidades->$temp_moneda->total_pagado_pendientes->cuenta_deuda += $value_abono->monto_total;
                            }
                            if($value_estado_cuenta_proveedor->concepto == "Devolución del VIN"){
                                $tabla_unidades->$temp_moneda->total_pagado_pendientes->devolucion_vin += $value_abono->monto_total;
                            }
                        }
                    }

                }
                /********************************* SELECCIONAR ANTICIPOS*********************************/

      			/*End number format precio unidad*/
      			/*Start datos*/
               $texto_datos_collect = collect([
               "Marca: $value_estado_cuenta_proveedor->datos_marca",
      			"Versión: $value_estado_cuenta_proveedor->datos_version",
      			"Modelo: $value_estado_cuenta_proveedor->datos_modelo",
      			"Color: $value_estado_cuenta_proveedor->datos_color",
      			"VIN: $value_estado_cuenta_proveedor->datos_vin"]);

      			if ($value_estado_cuenta_proveedor->concepto=="Comisión por Mediación Mercantil") {
                  $texto_datos_collect->push($estatus_unidad);
      			}else{
                  // $texto_datos_collect->push($saldo_unidad);
                  $texto_datos_collect->push($estatus_unidad);
      			}

               $consulta_inventario = inventario::where('vin_numero_serie',$value_estado_cuenta_proveedor->datos_vin)->get()->last();
               $consulta_inventario_trucks = inventario_trucks::where('vin_numero_serie',$value_estado_cuenta_proveedor->datos_vin)->get()->last();
               if(!empty($consulta_inventario)) $inventario = $consulta_inventario;
               if(!empty($consulta_inventario_trucks)) $inventario = $consulta_inventario_trucks;
               $texto_datos_collect->push("<br>Inventario:");
               if(!empty($inventario)) {
                  $texto_datos_collect->push("Fecha ingreso: $inventario->fecha_ingreso");
                  $texto_datos_collect->push("Ubicaci&oacute;n: $inventario->ubicacion");
                  $texto_datos_collect->push("Estatus: $inventario->estatus_unidad");
               }else{
                  $texto_datos_collect->push("No disponible");
               }


      			/*End datos*/
      			/*Start conversion de numeros a letras*/
      			$monto_precio_formato_letras= GlobalFunctionsController::convertir($value_estado_cuenta_proveedor->monto_precio,$value_estado_cuenta_proveedor->tipo_moneda);
      			/*End conversion de numeros a letras*/
      			/*Start definición cargo abono*/
      			$abono=0;
      			$cargo=0;

      			if ($value_estado_cuenta_proveedor->abono!="") {
      				$abono=number_format("$value_estado_cuenta_proveedor->abono",2);
      				$tabla_movimientos->abonos += (float)$value_estado_cuenta_proveedor->abono;
      			} else {
      				$abono="";
      			}

      			if ($value_estado_cuenta_proveedor->cargo!="") {
      				$cargo=number_format("$value_estado_cuenta_proveedor->cargo",2);
      				$tabla_movimientos->cargos += (float)$value_estado_cuenta_proveedor->cargo;
      			} else {
      				$cargo="";
      			}

      			if ($value_estado_cuenta_proveedor->tipo_movimiento=="abono") {
                  $row['abonos'] = $abono;
      			}
      			if ($value_estado_cuenta_proveedor->tipo_movimiento=="cargo") {
      				$saldo_total = $saldos + "$value_estado_cuenta_proveedor->cargo";
      				$saldos = $saldo_total;
      				$saldo_total = number_format($saldo_total,2);
                  $row['cargos']=$cargo;
      			}
      			if ($value_estado_cuenta_proveedor->monto_total!="") {
      				$monto_total_general=number_format($value_estado_cuenta_proveedor->monto_total,2);
      			}else{
      				$monto_total_general="";
      			}
      			/*Start información*/
      			/*Start number format precio unidad*/
      			if ($value_estado_cuenta_proveedor->datos_precio!="") {
      				$precio_unidad=number_format("$value_estado_cuenta_proveedor->datos_precio",2);
      			}else{
      				$precio_unidad="";
      			}
      			$monto_total_general=$precio_unidad;
      			/*End number format precio unidad*/

      			if($value_estado_cuenta_proveedor->concepto=="Cuenta de Deuda")
      				$conc="A ".$value_estado_cuenta_proveedor->concepto;
      			else  $conc=$value_estado_cuenta_proveedor->concepto;
      			if ($value_estado_cuenta_proveedor->referencia == "N/A" || $value_estado_cuenta_proveedor->referencia == "S/N") {
      				$ref_nueva = "";
      			}else{
      				$ref_nueva = "No. de Referencia: $value_estado_cuenta_proveedor->referencia";
      			}

      			$resultado=estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$value_estado_cuenta_proveedor->idestado_cuenta_proveedores)->get()->first();
      			$folio_nuevo=$resultado->col1;
      			$folio_anterior=$resultado->col2;
      			$actividad=$resultado->col3;
      			$depositante=$resultado->col4;

      			$texto_informacion_collect=collect([
      			// "Precio: $ $precio_unidad ",//($monto_precio_formato_letras)
      			"$tipo_mon",
      			"$cantidad",
      			"Tipo de Comprobante: $value_estado_cuenta_proveedor->tipo_comprobante",
      			"$ref_nueva"]);

               /*******************Pagares*********************/
               $texto_documentos_collect = collect([]);
               $texto_documentos_pendientes_collect = collect([]);
               $lista_pagares="";
               $documentos_pagar=documentos_pagar::where('idestado_cuenta',$value_estado_cuenta_proveedor->idestado_cuenta_proveedores)->get();

               foreach ($documentos_pagar as $documento_pagar) {
                  $monto_precio_formato=number_format($documento_pagar->monto,2);
                  $saldo_letras= GlobalFunctionsController::convertir($documento_pagar->monto,$value_estado_cuenta_proveedor->tipo_moneda);
                  $abonos_pagares_proveedores=abonos_pagares_proveedores::where('iddocumentos_pagar',$documento_pagar->iddocumentos_pagar)->get();
                  $monto_pagare_temp = 0;

                  $monto_por_pagar_temp=$documento_pagar->monto;
                  if(count($abonos_pagares_proveedores)==0){
                     $saldo_actual=$monto_precio_formato;
                     $monto_pagare_temp = $documento_pagar->monto;
                  }else{
                     foreach ($abonos_pagares_proveedores as $value_documento_pagar) {
                        $saldo_actual=number_format($value_documento_pagar->cantidad_pendiente,2);
                        $monto_pagare_temp = $value_documento_pagar->cantidad_pendiente;
                     }
                  }

                  if ($documento_pagar->estatus == "Pendiente" && $saldo_actual != "0.00" ) {
                     date_default_timezone_set('America/Mexico_City');
                     $fechaactual1= date("Y-m-d H:i:s");
                     $time_difference1 = strtotime($fechaactual1) - strtotime($documento_pagar->fecha_vencimiento) ;
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
                  $vencimientof = date_create($documento_pagar->fecha_vencimiento);
                  $vencimientof = date_format($vencimientof, "d-m-Y");


                  if ($documento_pagar->estatus == "Pagado"){
                     $estatus_pagare="Estatus:  <span  style='color:#00b248;'><b>$documento_pagar->estatus</b></span>";
                     $num_pagare_temp = GlobalFunctionsController::eliminarCaracteresSeriePagare($documento_pagar->num_pagare);
                     $texto_documentos_collect->push("<br>Serie: $num_pagare_temp");
                     $texto_documentos_collect->push("Monto: $ $monto_precio_formato");
                     // $texto_documentos_collect->push("($saldo_letras)");
                     $texto_documentos_collect->push("Vencimiento: $vencimientof");
                     $texto_documentos_collect->push("$tiempo_solucion");
                     // $texto_documentos_collect->push("Saldo: $ $saldo_actual");
                     $texto_documentos_collect->push("$estatus_pagare");
                     $tabla_movimientos->num_documentos_pagados +=1;
                     $tabla_movimientos->monto_documentos_pagados += $monto_pagare_temp;


                     if(!empty($value_estado_cuenta_proveedor->tipo_moneda) && !empty($value_estado_cuenta_proveedor->datos_estatus)
                     && !empty($value_estado_cuenta_proveedor->concepto) && $value_estado_cuenta_proveedor->datos_estatus == "Pendiente"){
                         $temp_moneda = $value_estado_cuenta_proveedor->tipo_moneda;
                         $tabla_unidades->$temp_moneda->total_pagado_pendientes_global += $monto_por_pagar_temp;
                         // dd($tabla_unidades->$temp_moneda->total_pagado_pendientes_global, $monto_pagare_temp);
                         // $values_prueba .=" -|-".$monto_pagare_temp."-|- ";
                         if($value_estado_cuenta_proveedor->concepto == "Compra Directa"){
                             $tabla_unidades->$temp_moneda->total_pagado_pendientes->directas += $monto_por_pagar_temp;
                         }
                         if($value_estado_cuenta_proveedor->concepto == "Cuenta de Deuda"){
                             $tabla_unidades->$temp_moneda->total_pagado_pendientes->cuenta_deuda += $monto_por_pagar_temp;
                         }
                         if($value_estado_cuenta_proveedor->concepto == "Devolución del VIN"){
                             $tabla_unidades->$temp_moneda->total_pagado_pendientes->devolucion_vin += $monto_por_pagar_temp;
                         }
                     }
                  }
                  else{
                     $estatus_pagare="Estatus:  <span  style='color:red;'><b>$documento_pagar->estatus</b></span>";
                     $num_pagare_temp = $num_pagare_temp = GlobalFunctionsController::eliminarCaracteresSeriePagare($documento_pagar->num_pagare);
                     $texto_documentos_pendientes_collect->push("<br>Serie: $num_pagare_temp");
                     $texto_documentos_pendientes_collect->push("Monto: $ $monto_precio_formato");
                     // $texto_documentos_pendientes_collect->push("($saldo_letras)");
                     $texto_documentos_pendientes_collect->push("Vencimiento: $vencimientof");
                     $texto_documentos_pendientes_collect->push("$tiempo_solucion");
                     $texto_documentos_pendientes_collect->push("Saldo: $ $saldo_actual");
                     $texto_documentos_pendientes_collect->push("$estatus_pagare");
                     $tabla_movimientos->num_documentos_pendientes +=1;
                     $tabla_movimientos->monto_documentos_pendientes += $monto_pagare_temp;

                     if(!empty($value_estado_cuenta_proveedor->tipo_moneda) && !empty($value_estado_cuenta_proveedor->datos_estatus) &&
                     !empty($value_estado_cuenta_proveedor->concepto) && $value_estado_cuenta_proveedor->datos_estatus == "Pendiente"){
                         $temp_moneda = $value_estado_cuenta_proveedor->tipo_moneda;
                         $tabla_unidades->$temp_moneda->total_restante_pendientes_global += $monto_por_pagar_temp;
                         if($value_estado_cuenta_proveedor->concepto == "Compra Directa"){ $tabla_unidades->$temp_moneda->total_restante_pendientes->directas += $monto_por_pagar_temp; }
                         if($value_estado_cuenta_proveedor->concepto == "Cuenta de Deuda"){ $tabla_unidades->$temp_moneda->total_restante_pendientes->cuenta_deuda += $monto_por_pagar_temp; }
                         if($value_estado_cuenta_proveedor->concepto == "Devolución del VIN"){ $tabla_unidades->$temp_moneda->total_restante_pendientes->devolucion_vin += $monto_por_pagar_temp; }
                     }

                     if($documento_pagar->tipo == 'Virtual'){
                        $tabla_movimientos->num_virtuales_pendientes+=1;
                        if(!empty($documento_pagar->monto))$tabla_movimientos->monto_virtuales_pendientes+=$monto_pagare_temp;
                     }

                     if($documento_pagar->tipo == 'Físico'){
                        $tabla_movimientos->num_fisicos_pendientes+=1;
                        if(!empty($documento_pagar->monto))$tabla_movimientos->monto_fisicos_pendientes+=$monto_pagare_temp;
                     }
                  }
               }//Fin de consulta pagares

      			$row['contador'] = $contador;
      			$row['fecha'] = $fecha_movimiento_bien;
      			$row['concepto'] = collect("$conc","$folio_nuevo");
      			$row['datos'] = $texto_datos_collect;
      			$row['informacion'] = $texto_informacion_collect;
      			$row['documentos'] = $texto_documentos_collect;
      			$row['documentos_pendientes'] = $texto_documentos_pendientes_collect;
      			// $row['saldo'] = "$ $saldo_total";
      			$row['saldo'] = "$ ".number_format((float)$saldo_abonos_cargos, 2);
                $row['abonos'] = "$ ".number_format((float)$saldo_abonos, 2);
               $tabla_movimientos->tabla->push($row);
            }/*Segundo foreach*/

         }/*Primer foreach*/


            /********************************************************************************************************/

            // dd($values_prueba);



        // DB::commit();
        $view=View::make('admin.reports.report_executive',compact(
        'tabla_movimientos','fecha_i','fecha_f', 'fecha_impresion','mes','num_compras_pagadas',
        'tabla_unidades'));

        $nombre = "PDdsafdfsdfsdF"; $apellidos = "fdsfs dfPDF"; $id_contacto_completo = "949343294";

        GlobalFunctionsController::createPdf($view, $nombre, $apellidos, $id_contacto_completo,"admon_compras", "reporte_ejecutivo_compras","","");
        return view('admin.reports.report_executive',compact(
            'tabla_movimientos','fecha_i','fecha_f', 'fecha_impresion','mes','num_compras_pagadas',
            'tabla_unidades'));
      // } catch (\Exception $e) {
      //    dd($e->getMessage());
      //   DB::rollback();
      //   return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
      // }





    }
  }
