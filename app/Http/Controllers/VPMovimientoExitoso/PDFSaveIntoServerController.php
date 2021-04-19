<?php

namespace App\Http\Controllers\VPMovimientoExitoso;
use App\Http\Controllers\GlobalFunctionsController;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\estado_cuenta;
use App\Models\proveedores;
use App\Models\asesores;
use App\Models\usuarios;
use App\Models\empleados;
use App\Models\contactos;
use App\Models\inventario;
use App\Models\vista_previa_movimiento_exitoso;
use App\Models\vpme_pagares;
use App\Models\vpme_clientes;
use App\Models\vpme_asesores;
use App\Models\vpme_pagos;
use App\Models\inventario_trucks;
use App\Models\publicacion_vin_fotos;
use App\Models\inventario_dinamico;
use App\Models\vpme_informacion_clientes;
use App\Models\orden_compra_unidades;
use App\Models\check_list_expediente_original_ordenado;
use App\Models\check_list_expediente_original;
use App\Models\check_list_expediente_original_ordenamiento;
use App\Models\check_list_expediente_original_datos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;

class PDFSaveIntoServerController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function VentaCredito(){
        try {

            $mpdf = new \Mpdf\Mpdf([
                'tempDir' => storage_path('mpdf/temp/'),
                'format' => 'Letter'
            ]);
            $mpdf->defaultheaderfontsize = 10;
            $mpdf->defaultheaderfontstyle = 'B';
            $mpdf->defaultheaderline = 0;
            $mpdf->defaultfooterfontsize = 10;
            $mpdf->defaultfooterfontstyle = 'BI';
            $mpdf->defaultfooterline = 0;

            $html_content = view('VPMovimientoExitoso.PDF_venta_credito')->render();
            $mpdf->WriteHTML($html_content);

            $mpdf->Output('Prueba', 'I');
        } catch (\Exception $e) {
            return $e;
        }

    }


    public static function vistaPrevia($id){
        $id = Crypt::decrypt($id);

        try {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            date_default_timezone_set('America/Mexico_City');
            $date = date_create();
            $dia = date_format($date, 'd');
            $mes_aux = date_format($date, 'm');
            $mes = ucfirst($meses[$mes_aux-1]);
            $ano = date_format($date, 'Y');
            $hora = date_format($date, 'H:i:s');

            $vpme = vista_previa_movimiento_exitoso::where('id',$id)->get()->first();
            $vpme_pagos = vpme_pagos::where('id_vista_previa_movimiento_exitoso',$vpme->id)->where('visible','SI')->get();

            $id_contacto = $vpme->idcontacto;
            $asesores_nomenclatura = (object)["asesor_1"=>"", "asesor_2"=>"", "enlace_1"=>"", "enlace_2"=>""];
            if(!empty($vpme)){
                $vpme_asesores = vpme_asesores::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get();
                if(!$vpme_asesores->isEmpty()){
                    foreach ($vpme_asesores as $key => $value) {
                        if($value->tipo == "Asesor 1") $asesores_nomenclatura->asesor_1 = $value->nomenclatura;
                        if($value->tipo == "Asesor 2") $asesores_nomenclatura->asesor_2 = $value->nomenclatura;
                        if($value->tipo == "Enlace 1") $asesores_nomenclatura->enlace_1 = $value->nomenclatura;
                        if($value->tipo == "Enlace 2") $asesores_nomenclatura->enlace_2 = $value->nomenclatura;
                    }
                }
            }

            $id_inventario = $vpme->idinventario;

            $temp_contacto = "";
            if($id_contacto != 0){
                $cliente=contactos::where('idcontacto',$id_contacto)->get();
                $temp_contacto = $cliente->first()->idcontacto;
            }
            else{
                $cliente = vpme_clientes::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get();
                $temp_contacto = $cliente->first()->id;
            }
            /** ID CONTACTO **/

            $n1=strlen($temp_contacto);
            $n1_aux=6-$n1;
            $mat="";
            for ($i=0; $i <$n1_aux ; $i++) {
                $mat.="0";
            }

            $id_contacto_completo=$mat.$temp_contacto;
            /** ID MOVIMIENTO **/
            $n2=strlen($vpme->id);
            $n2_aux=9-$n2;
            $mat2="";
            for ($i=0; $i <$n2_aux ; $i++) {
                $mat2.="0";
            }
            $id_movimiento_completo=$mat2.$vpme->id;
            /**END*/

            if($vpme->tipo_unidad == "Unidad"){
                $inventario = inventario::where('vin_numero_serie',$vpme->vin_numero_serie)->get()->first();
            }
            if($vpme->tipo_unidad == "Trucks"){
                $inventario = inventario_trucks::where('vin_numero_serie',$vpme->vin_numero_serie)->get()->first();
            }

            $tipo_cliente = "";
            if($id_contacto == 0) $tipo_cliente = "Nuevo";
            else $tipo_cliente = "Cliente";
            $tabla_movimientos = "";
            $calle = "";
            $colonia = "";
            $municipio = ""; $estado = ""; $nombre = ""; $apellidos = "";
            /*Start Contactos*/
            $tabla_movimientos = (object)['tabla'=>null,'cargos'=>0, 'abonos'=>0];
            $num_unidades = 0;
            foreach ($cliente as $key => $value) {
                $nombre = GlobalFunctionsController::convertirTildesCaracteres($value->nombre);
                $apellidos = GlobalFunctionsController::convertirTildesCaracteres($value->apellidos);
                if($tipo_cliente == "Cliente"){
                    $telefono1 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_celular);
                    $calle = GlobalFunctionsController::convertirTildesCaracteres($value->calle);
                    $municipio = GlobalFunctionsController::convertirTildesCaracteres($value->delmuni);
                }
                if($tipo_cliente == "Nuevo"){
                    $telefono1 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono);
                    $calle = GlobalFunctionsController::convertirTildesCaracteres($value->direccion);
                    $municipio = GlobalFunctionsController::convertirTildesCaracteres($value->municipio);
                }
                $telefono2 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_otro);
                $colonia = GlobalFunctionsController::convertirTildesCaracteres($value->colonia);
                $estado = GlobalFunctionsController::convertirTildesCaracteres($value->estado);

                $linea_credito = $value->linea_credito;
                if($value->linea_credito != "N/A" && !empty($value->linea_credito)) $linea_credito = "$ ".number_format($value->linea_credito,2);

                if ($telefono1 == "0000000000") {
                    $telefono1 = "N/A";
                }
                if ($telefono2 == "0000000000") {
                    $telefono2 = "N/A";
                }
                if ($calle != "") {
                    $calle_v = $calle.", ";
                }
                if ($colonia != "") {
                    $colonia_v = $colonia.", ";
                }
                $id_contacto_completo="C".$id_contacto_completo;
                $tipo_credito = "";
            }

            $domicilio_completo="";
            if(!empty($calle) && $calle != "N/A") $domicilio_completo.=ucfirst($calle).", ";
            if(!empty($colonia) && $colonia != "N/A") $domicilio_completo.=ucfirst($colonia).", ";
            if(!empty($municipio) && $municipio != "N/A")$domicilio_completo.=ucfirst($municipio).", ";
            $domicilio_completo.=ucfirst($estado);

            /*-------------------Calcular tabla de amortizacion-------------------*/
            $vpme_pagares = vpme_pagares::where('id_vista_previa_movimiento_exitoso',$vpme->id)->where('visible','SI')->get();
            $disbursement_date = (new \DateTime($vpme->created_at))->format('d/m/Y');
            $calculate_balance = $vpme->saldo;

            $publicacion_vin_fotos = publicacion_vin_fotos::where('vin',$vpme->vin_numero_serie)->where('tipo','Principal')->get();
            $img = "";
            if(!$publicacion_vin_fotos->isEmpty()){
                $x = $publicacion_vin_fotos->first()->ruta_foto;
                $img_route = str_replace(array('../..'),array(''),$x );;
                $img = "https://www.panamotorscenter.com/Des/CCP".$img_route;
            }

            $calculate_amortization_table = (object)[
                'table'=>collect([]), 'disbursement_date'=>$disbursement_date, 'disbursement_amount'=>$calculate_balance, 'amount_promisory_note'=>$vpme_pagares->first(),
                'img'=>$img
            ];

            foreach ($vpme_pagares as $key => $value) {
                $disbursement_date_modify = $value->fecha_vencimiento;
                $payment = $value->monto;
                $calculate_balance = $calculate_balance - $payment;
                $calculate_balance = round($calculate_balance,2);
                $date_payment = (new \DateTime($value->fecha_vencimiento))->format('d/m/Y');

                $collection = [
                    'period'=>$key+1,
                    'date' => $date_payment ,
                    'balance' => $calculate_balance,
                    'payment' => $payment];
                    $calculate_amortization_table->table->push($collection);
                }

                $usuario_creador = usuarios::where('idusuario',$vpme->usuario_creador)->get();
                $usuario = (object)["usuario"=>"", "fecha"=>""];
                if(!empty($usuario_creador)){
                    $empleado = empleados::where('idempleados',$usuario_creador->first()->idempleados)->get()->first();
                    if(!empty($empleado->nombre)) $usuario->usuario .= $empleado->nombre." ";
                    if(!empty($empleado->apellido_paterno)) $usuario->usuario .= $empleado->apellido_paterno." ";
                    if(!empty($empleado->apellido_materno)) $usuario->usuario .= $empleado->apellido_materno;

                    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                    $fecha_recibo = new \DateTime($vpme->created_at);
                    $mes = $meses[($fecha_recibo->format('n')) - 1];
                    $usuario->fecha = $fecha_recibo->format('d') . ' de ' . $mes . ' de ' . $fecha_recibo->format('Y');
                }
                /*Fin Tabla de amortizacion*/

                // return view('VPMovimientoExitoso.pdf_vpme',compact('id_contacto_completo','nombre','apellidos','tipo_cliente',
                // 'dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesores_nomenclatura','tabla_movimientos',
                // 'num_unidades','inventario','calculate_amortization_table','vpme','vpme_pagares','id_movimiento_completo','vpme_pagos'));

                $view=View::make('VPMovimientoExitoso.pdf.pdf_vpme',compact('id_contacto_completo','nombre','apellidos','tipo_cliente',
                'dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','tipo_credito','linea_credito','asesores_nomenclatura','tabla_movimientos',
                'num_unidades','inventario','calculate_amortization_table','vpme','vpme_pagares','id_movimiento_completo','vpme_pagos'));

                return $collect = (object)['view'=>$view, 'nombre'=>$nombre, 'apellidos'=>$apellidos, 'usuario'=>$usuario, 'id_contacto_completo'=>$id_contacto_completo];
                // GlobalFunctionsController::createPdf($view, $nombre, $apellidos, $id_contacto_completo, "vpme", "vista_previa_movimiento_exitoso","",$usuario);
            } catch (\Exception $e) {
                return redirect()->back()->with('error','No se pudo crear el pdf');
                return $e;
            }
    }

    public static function contratoDirectaContado($id){
        $id = Crypt::decrypt($id);
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        date_default_timezone_set('America/Mexico_City');
        $date = date_create();
        $dia = date_format($date, 'd');
        $mes_aux = date_format($date, 'm');
        $mes = ucfirst($meses[$mes_aux-1]);
        $ano = date_format($date, 'Y');
        $hora = date_format($date, 'H:i:s');

        $vpme = vista_previa_movimiento_exitoso::where('id',$id)->get()->first();
        $informacion_cliente = vpme_informacion_clientes::where('id_vista_previa_movimiento_exitoso',$id)->get()->first();

        $identificacion = "";
        if(!empty($informacion_cliente->identificacion)) $identificacion = ($informacion_cliente->identificacion);

        $folio_identificacion = "";
        if(!empty($informacion_cliente->folio_identificacion)) $folio_identificacion = ($informacion_cliente->folio_identificacion);

        $asesor = vpme_asesores::where('id_vista_previa_movimiento_exitoso',$vpme->id)->where('tipo','Asesor 1')->get()->first();
        $empleado_asesor = empleados::where('idempleados',$asesor->id_empleados)->get();
        $telefono_asesor = "";
        if(!$empleado_asesor->isEmpty()){
            $telefono_asesor = $empleado_asesor->first()->telefono_empresa;
        }

        /** ID MOVIMIENTO **/
        $n2=strlen($vpme->id);
        $n2_aux=9-$n2;
        $mat2="";
        for ($i=0; $i <$n2_aux ; $i++) {
            $mat2.="0";
        }
        $id_movimiento_completo=$mat2.$vpme->id;
        /**END*/

        $id_contacto = $vpme->idcontacto;
        $temp_contacto = "";
        if($id_contacto != 0){
            $cliente=contactos::where('idcontacto',$id_contacto)->get();
            $temp_contacto = $cliente->first()->idcontacto;
        }
        else{
            $cliente = vpme_clientes::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get();
            $temp_contacto = $cliente->first()->id;
        }
        /** ID CONTACTO **/
        $n1=strlen($temp_contacto);
        $n1_aux=6-$n1;
        $mat="";
        for ($i=0; $i <$n1_aux ; $i++) {
            $mat.="0";
        }
        $id_contacto_completo=$mat.$temp_contacto;
        /**END*/
        $inventario ="";
        if($vpme->tipo_unidad == "Unidad"){
            $inventario = inventario::where('vin_numero_serie',$vpme->vin_numero_serie)->get()->first();
        }
        if($vpme->tipo_unidad == "Trucks"){
            $inventario = inventario_trucks::where('vin_numero_serie',$vpme->vin_numero_serie)->get()->first();
        }

        $tipo_cliente = "";
        if($id_contacto == 0) $tipo_cliente = "Nuevo";
        else $tipo_cliente = "Cliente";

        $calle = "";
        $colonia = "";
        $municipio = ""; $estado = ""; $nombre = ""; $apellidos = "";
        foreach ($cliente as $key => $value) {
            $nombre = GlobalFunctionsController::convertirTildesCaracteres($value->nombre);
            $apellidos = GlobalFunctionsController::convertirTildesCaracteres($value->apellidos);
            if($tipo_cliente == "Cliente"){
                $telefono1 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_celular);
                $calle = GlobalFunctionsController::convertirTildesCaracteres($value->calle);
                $municipio = GlobalFunctionsController::convertirTildesCaracteres($value->delmuni);
            }
            if($tipo_cliente == "Nuevo"){
                $telefono1 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono);
                $calle = GlobalFunctionsController::convertirTildesCaracteres($value->direccion);
                $municipio = GlobalFunctionsController::convertirTildesCaracteres($value->municipio);
            }
            $calle = strtoupper($calle);
            $telefono2 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_otro);
            $colonia = GlobalFunctionsController::convertirTildesCaracteres($value->colonia);
            $estado = GlobalFunctionsController::convertirTildesCaracteres($value->estado);

            $linea_credito = $value->linea_credito;
            if($value->linea_credito != "N/A" && !empty($value->linea_credito)) $linea_credito = "$ ".number_format($value->linea_credito,2);

            if(!empty($informacion_cliente->telefono) && $informacion_cliente->telefono != "N/A"){
                $telefono1 = $informacion_cliente->telefono;
                $telefono2 = "";
            }else {
                if ($telefono1 == "0000000000") {
                    $telefono1 = "N/A";
                }
                if ($telefono2 == "0000000000") {
                    $telefono2 = "N/A";
                }
            }
            if ($calle != "") {
                $calle_v = $calle.", ";
            }
            if ($colonia != "") {
                $colonia_v = $colonia.", ";
            }
            $id_contacto_completo="C".$id_contacto_completo;
            $tipo_credito = "";
        }

        $domicilio_completo="";
        // if(!empty($calle) && $calle != "N/A") $domicilio_completo.=ucfirst($calle).", ";
        if(!empty($colonia) && $colonia != "N/A") $domicilio_completo.=ucfirst($colonia).", ";
        if(!empty($municipio) && $municipio != "N/A")$domicilio_completo.=ucfirst($municipio).", ";
        $domicilio_completo.=ucfirst($estado);

        $monto_letra ="";
        if(!empty($vpme->monto_unidad) ){
            $monto_letra = GlobalFunctionsController::convertir($vpme->monto_unidad, "MXN");

        }

        /************************** DOCUMENTOS 2DA HOJA ************************************/
          $vin = $vpme->vin_numero_serie;
          $OrdenCU = orden_compra_unidades::select('idorden_compra_unidades')->where('vin',$vin)->where('visible', 'SI')->get();

          $tabla_documentos = "";
          if (sizeof($OrdenCU) > 0) {
            $tam_tabla = 1;
            foreach ($OrdenCU as $key_Orden => $OCU) {
              check_list_expediente_original_ordenado::truncate();
              $CheckList = check_list_expediente_original::where('visible', 'SI')->where('idorden_compra_unidades', $OCU->idorden_compra_unidades)->where('tipo_check_list', 'Ingreso')->get();

              foreach ($CheckList as $key => $CLEO) {
                $tipo = $CLEO->tipo;
                $descripcion = $CLEO->descripcion;

                $i = 0;
                $tipo2 = $tipo;
                while ($i < 10) {
                  $tipo = str_replace("$i","",$tipo);
                  $i++;
                }

                $tipo = trim($tipo);

                $CLEO_Ordenamiento = check_list_expediente_original_ordenamiento::select('orden','orden_nombre')->
                where(function ($query) use($tipo){
                  $query->where('visible' , 'SI' )->where('nombre' , $tipo );
                })->orWhere(function ($query) use($descripcion){
                  $query->where('visible' , 'SI' )->where('tipo' , $descripcion );
                })->first();

                if ($CLEO_Ordenamiento) {
                  $CLEO_Ordenado = check_list_expediente_original_ordenado::createCLEOO($CLEO->idcheck_list_expediente_original ,$CLEO->tipo,
                  $CLEO->tipo_check_list,$CLEO->entrega,$CLEO->descripcion ,
                  $CLEO_Ordenamiento->orden,$CLEO_Ordenamiento->orden_nombre,$CLEO->fecha_guardado,$CLEO->idorden_compra_unidades);
                }else{
                  $CLEO_Ordenado = check_list_expediente_original_ordenado::createCLEOO($CLEO->idcheck_list_expediente_original ,$CLEO->tipo,
                  $CLEO->tipo_check_list,$CLEO->entrega,$CLEO->descripcion ,
                  0,0,$CLEO->fecha_guardado,$CLEO->idorden_compra_unidades);
                }
              }//fIN FOR check_list_expediente_original


              $ListExpedienteOrdenado = DB::select('SELECT * FROM check_list_expediente_original_ordenado WHERE idorden_compra_unidades= ? ORDER BY orden ASC ,orden_nombre ASC,idcheck_list_expediente_original ASC', [$OCU->idorden_compra_unidades]);

              $search = collect([
                  'acta constitutiva', 'alta', 'baja', 'cancelacion', 'reporte', 'Carta', 'liberacion', 'factura', 'comprobante', 'factura',
                  'constancia', 'fiscalia', 'contrato', 'compra-venta', 'copia certificada', 'pedimento', 'dictamen', 'verificación', 'endoso',
                  'tramite', 'ficha tecnica', 'recuperacion', 'certificada', 'manual', 'orden', 'poliza', 'garantia', 'pedimento', 'permiso', 'tarjeta',
                  'poder notarial', 'poliza de garantia', 'poliza de seguro', 'refactura', 'registro publico vehicular', 'repuve', 'tarjeta de circulacion',
                  'tarjeton', 'tarjeton de circulacion', 'tenencia', 'titulo', 'tramite vehicular', 'tramites', 'verificacion vehicular']);
                  $contador=1;
              foreach ($ListExpedienteOrdenado as $key_List => $Expediente) {
                $ListExpedienteOriginal = check_list_expediente_original::select('columna_2')->where('visible', 'SI')->where('idcheck_list_expediente_original', $Expediente->idcheck_list_expediente_original)->where('tipo_check_list', 'Ingreso')->first();

                $columna_2= $ListExpedienteOriginal->columna_2;

                if ($columna_2 == "Original" || $columna_2 == "Copia" || $columna_2 == "Original-Copia") {
                    $string = $Expediente->tipo;
                    $string_format = GlobalFunctionsController::convertirTildesCaracteres(strtolower($string));
                    $encontrado = "no";
                    foreach ($search as $key => $value) {
                        if(str_contains($string_format,$value) && $encontrado == "no"){
                            $tabla_documentos.=$contador.") ".$string."<br>";
                            $contador++;
                            $encontrado ="si";
                         }
                    }
                }
              }

            }
          }else{//Si no hya Orden de Compra Unidades
            $tam_tabla = 0;
          }
        /************************** VIN 17 DIGITOS ************************************/
        $inventario_dinamico = inventario_dinamico::where('idinventario',$vpme->idinventario)->where('columna','vin_numero_serie_completo')->get();

        // return view('VPMovimientoExitoso.pdf.venta_directa_contado',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','monto_letra',
        // 'dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','calle','tipo_credito','linea_credito',
        // 'inventario','vpme','id_movimiento_completo'));

        $view = View::make('VPMovimientoExitoso.pdf.venta_directa_contado',compact('id_contacto_completo','nombre','apellidos','tipo_cliente','monto_letra',
        'dia','mes','ano','hora','alias','telefono1','telefono2','domicilio_completo','calle','tipo_credito','linea_credito',
        'inventario','vpme','id_movimiento_completo','tabla_documentos','inventario_dinamico','identificacion','folio_identificacion','telefono_asesor'));

        return $collect = (object)['view'=>$view, 'nombre'=>$nombre, 'apellidos'=>$apellidos, 'usuario'=>'', 'id_contacto_completo'=>$id_contacto_completo];
        // GlobalFunctionsController::createPdf($view, $nombre, $apellidos, $id_contacto_completo, "vpme", "venta_directa_contado","","");
    }

    public static function personasFisicas($id){
        $id = Crypt::decrypt($id);
        $vpme = vista_previa_movimiento_exitoso::where('id',$id)->get()->first();
        $informacion_cliente = vpme_informacion_clientes::where('id_vista_previa_movimiento_exitoso',$id)->get()->first();
        $id_contacto = $vpme->idcontacto;
        $fecha_nacimiento = "";
        if(!empty($informacion_cliente->fecha_nacimiento)) $fecha_nacimiento = (new \DateTime($informacion_cliente->fecha_nacimiento))->format('d/m/Y');

        if($id_contacto != 0){
            $cliente=contactos::where('idcontacto',$id_contacto)->get();
        }
        else{
            $cliente = vpme_clientes::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get();
        }

        $tipo_cliente = "";
        if($id_contacto == 0) $tipo_cliente = "Nuevo";
        else $tipo_cliente = "Cliente";
        $tabla_movimientos = "";
        $calle = "";
        $colonia = "";
        $municipio = ""; $estado = ""; $nombre = ""; $apellidos = "";
        /*Start Contactos*/
        $tabla_movimientos = (object)['tabla'=>null,'cargos'=>0, 'abonos'=>0];
        $num_unidades = 0;
        foreach ($cliente as $key => $value) {
            $nombre = GlobalFunctionsController::convertirTildesCaracteres($value->nombre);
            if(!empty($nombre)) $nombre = strtoupper(strtolower($nombre));
            $apellidos = GlobalFunctionsController::convertirTildesCaracteres($value->apellidos);
            if(!empty($apellidos)) $apellidos = strtoupper(strtolower($apellidos));
            if($tipo_cliente == "Cliente"){
                $telefono1 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_celular);
                $calle = GlobalFunctionsController::convertirTildesCaracteres($value->calle);
                $municipio = GlobalFunctionsController::convertirTildesCaracteres($value->delmuni);
            }
            if($tipo_cliente == "Nuevo"){
                $telefono1 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono);
                $calle = GlobalFunctionsController::convertirTildesCaracteres($value->direccion);
                $municipio = GlobalFunctionsController::convertirTildesCaracteres($value->municipio);
            }
            $telefono2 = GlobalFunctionsController::convertirTildesCaracteres($value->telefono_otro);
            $colonia = GlobalFunctionsController::convertirTildesCaracteres($value->colonia);
            $estado = GlobalFunctionsController::convertirTildesCaracteres($value->estado);

            $linea_credito = $value->linea_credito;
            if($value->linea_credito != "N/A" && !empty($value->linea_credito)) $linea_credito = "$ ".number_format($value->linea_credito,2);

            if(!empty($informacion_cliente->telefono) && $informacion_cliente->telefono != "N/A"){
                $telefono1 = $informacion_cliente->telefono;
                $telefono2 = "";
            }else {
                if ($telefono1 == "0000000000") {
                    $telefono1 = "N/A";
                }
                if ($telefono2 == "0000000000") {
                    $telefono2 = "N/A";
                }
            }
            if ($calle != "") {
                $calle_v = $calle.", ";
            }
            if ($colonia != "") {
                $colonia_v = $colonia.", ";
            }
        }

        $domicilio_completo="";
        if(!empty($calle) && $calle != "N/A") $domicilio_completo.=strtoupper($calle).", ";
        if(!empty($colonia) && $colonia != "N/A") $domicilio_completo.=strtoupper($colonia).", ";
        if(!empty($municipio) && $municipio != "N/A")$domicilio_completo.=strtoupper($municipio).", ";
        $domicilio_completo.=strtoupper($estado);

        return $view = View::make('VPMovimientoExitoso.pdf.personas_fisicas',compact('nombre','apellidos',
        'telefono1','telefono2','domicilio_completo',
        'vpme','fecha_nacimiento','informacion_cliente'));

        // GlobalFunctionsController::createPdf($view, $nombre, $apellidos, 0, "vpme", "personas_fisicas","","");
    }

    public function AvisoPrivacidad($id){
      $nombre = "a";
      $apellidos = "b";
      $PDF_vista = view('VPMovimientoExitoso.pdf.aviso_privacidad');
      GlobalFunctionsController::createPdf($PDF_vista, $nombre, $apellidos, 0, "vpme", "aviso_privacidad","","");
    }


}
