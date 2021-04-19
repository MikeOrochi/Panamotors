<?php

namespace App\Http\Controllers\VPMovimientoExitoso;
use App\Http\Controllers\GlobalFunctionsController;
use App\Http\Controllers\VPMovimientoExitoso\PDFSaveIntoServerController;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\vista_previa_movimiento_exitoso;
use App\Models\vpme_asesores;
use App\Models\vpme_clientes;
use App\Models\asesores;
use App\Models\usuarios;
use App\Models\empleados;
use App\Models\contactos;
use App\Models\vpme_informacion_clientes;
use App\Models\inventario_dinamico;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\estado_cuenta;
use App\Models\estado_cuenta_proveedores;
use App\Models\orden_compra_unidades;
use App\Models\inventario_cambios;
use App\Models\inventario_cambios_trucks;
use App\Models\check_list_expediente_original_ordenado;
use App\Models\check_list_expediente_original;
use App\Models\check_list_expediente_original_ordenamiento;



class DatosExtraController extends Controller {

  public function __construct(){
    $this->middleware('auth');
  }

  public function DatosExtra($id){
    $id = Crypt::decrypt($id);
    try {
      $VistaPrevia = vista_previa_movimiento_exitoso::where('id', $id)->first();
      $InfoExtra = vpme_informacion_clientes::where('id_vista_previa_movimiento_exitoso', $id)->get()->first();
      if(empty($InfoExtra)) {
        $tmp_vpme = vista_previa_movimiento_exitoso::where('idcontacto', $VistaPrevia->idcontacto)->orderBy('updated_at','DESC')->get();
        // dd($InfoExtra,$tmp_vpme);
        if(!$tmp_vpme->isEmpty()){
          foreach ($tmp_vpme as $key => $value) {
            $tmp_informacion = vpme_informacion_clientes::where('id_vista_previa_movimiento_exitoso', $value->id)->get();
            if(!$tmp_informacion->isEmpty() && empty($InfoExtra)){
              $InfoExtra = $tmp_informacion->first();
            }
          }
          // dd($InfoExtra, $tmp_vpme);
        }
      }
      return view('VPMovimientoExitoso.datos_extra',compact('VistaPrevia','InfoExtra'));
    } catch (\Exception $e) {
      return redirect()->back()->with('error','¡Información no encontrada!'.$e->getMessage());
    }

  }


  public function REPUVE(){
    $endpoint_sepomex = "http://wstransporte.col.gob.mx/index.php/apiV1/obtener/vehiculo/datos_extras/placa/FTA2979/num_serie/2HGEJ6576VH571881.json";
    $url = $endpoint_sepomex;
    $response = file_get_contents($url);

    if($response){
      return $response;
    }else{
      return false;
    }
  }

  public function GuardarDatos(){
    $validator = Validator::make(request()->all(),
    [
      'PaisNacimiento' => 'required',
      'PaisNacionalidad' => 'required',
      'Ocupacion' => 'required',
      'CURP' => 'required',
      'RFC' => 'required',
      'Facturar' => 'required',
      'TipoIdentificacion' => 'required',
      'NumeroIdentificacion' => 'required',
    ],
    [
      'PaisNacimiento.required' => 'El pais de nacimiento necesario',
      'PaisNacionalidad.required' => 'El pais de nacionalidad es necesario',
      'Ocupacion.required' => 'La ocupacion es necesaria',
      'CURP.required' => 'La CURP es necesario',
      'RFC.required' => 'El RFC es necesario',
      'Facturar.required' => 'Seleciona si desea facturar necesario',
      'TipoIdentificacion.required' => 'El tipo de identificacion es necesario',
      'NumeroIdentificacion.required' => 'El numero de identificacion es necesario',
      ] );
      if( $validator->fails() ) {
        return \Redirect::back()->with('error',$validator->errors()->first())->withInput();
      }

      DB::beginTransaction();
      try {

        $id_vpme = request('idVistaPrevia');

        $vpme = vista_previa_movimiento_exitoso::where('id',$id_vpme)->get()->first();

        $pais_nacimiento = request('PaisNacimiento');
        $pais_nacionalidad = request('PaisNacionalidad');
        $fecha_nacimiento = request('FechaNacimiento');
        $ocupacion = request('Ocupacion');
        $curp = request('CURP');
        $rfc = request('RFC');
        $Facturar = request('Facturar');
        $identificacion = request('TipoIdentificacion');
        $folio_identificacion = request('NumeroIdentificacion');
        $telefono = request('Telefono');
        $correo = request('Email') ;
        $beneficiario = request('NombreBeneficiario');
        if($beneficiario == "" && $beneficiario == null) $beneficiario = "No";

        $numero_motor = request('numMotor');

        if(empty($telefono)) $telefono = "N/A";
        if(empty($correo)) $correo = "N/A";


        //----------------------------------- VALIDAR MENSAJES --------------------------------
        $message_array = DatosExtraController::validarVIN($vpme);
        //---------------------------------- END VALIDAR MENSAJES -----------------------------


        //******************************** TABLA VPME INOFRMACION CLIENTES ********************************
        $verificar_informacion_cliente = vpme_informacion_clientes::where('id_vista_previa_movimiento_exitoso',$id_vpme)->get()->first();
        if(empty($verificar_informacion_cliente)){
          $vpme_informacion_cliente = vpme_informacion_clientes::createVPMEInformacionClientes(
            $id_vpme, $pais_nacimiento, $pais_nacionalidad, $fecha_nacimiento, $ocupacion, $curp, $rfc,$Facturar,
            $identificacion, $folio_identificacion, $telefono, $correo, $beneficiario );
            // dd($vpme_informacion_cliente);
          }else{

            $vpme_informacion_cliente = $verificar_informacion_cliente;
            $vpme_informacion_cliente->pais_nacimiento = $pais_nacimiento;
            $vpme_informacion_cliente->pais_nacionalidad = $pais_nacionalidad;
            $vpme_informacion_cliente->fecha_nacimiento = $fecha_nacimiento;
            $vpme_informacion_cliente->ocupacion = $ocupacion;
            $vpme_informacion_cliente->curp = $curp;
            $vpme_informacion_cliente->rfc = $rfc;
            $vpme_informacion_cliente->facturacion = $Facturar;
            $vpme_informacion_cliente->identificacion = $identificacion;
            $vpme_informacion_cliente->folio_identificacion = $folio_identificacion;
            $vpme_informacion_cliente->telefono = $telefono;
            if($correo != "N/A") $vpme_informacion_cliente->correo = $correo;
            $vpme_informacion_cliente->beneficiario = $beneficiario;
            $vpme_informacion_cliente->save();
          }

          if(!empty($numero_motor) && $numero_motor != "N/A"){
            $vpme->numero_motor = $numero_motor;
            $vpme->save();
          }
          // $message_array = "";/////**************************************************************
          DB::commit();
          if(!empty($message_array)){
            return redirect()->back()->with('error',"¡Información guardada temporalmente!. <br>".$message_array)->withInput();
          }else {
            return redirect()->back()->with('success',"¡Información guardada correctamente!. <br> Espera la aprobación.")->withInput();
          }
        } catch (\Exception $e) {
          DB::rollback();
          return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
          return $e->getMessage();

        }
      }

      public function verificarAprobarVenta($id,$activacion){


        DB::beginTransaction();
        try {

          // $id_vpme = request('idVistaPrevia');
          $id_vpme = Crypt::decrypt($id);
          $activacion = Crypt::decrypt($activacion);



          $vpme = vista_previa_movimiento_exitoso::where('id',$id_vpme)->get()->first();

          $pais_nacimiento = request('PaisNacimiento');
          $pais_nacionalidad = request('PaisNacionalidad');
          $fecha_nacimiento = request('FechaNacimiento');
          $ocupacion = request('Ocupacion');
          $curp = request('CURP');
          $rfc = request('RFC');
          $Facturar = request('Facturar');
          $identificacion = request('TipoIdentificacion');
          $folio_identificacion = request('NumeroIdentificacion');
          $telefono = request('Telefono');
          $correo = request('Email') ;
          $beneficiario = request('NombreBeneficiario');
          if($beneficiario == "" && $beneficiario == null) $beneficiario = "No";

          $numero_motor = request('numMotor');

          if(empty($telefono)) $telefono = "N/A";
          if(empty($correo)) $correo = "N/A";

          $message_array = "";
          if (!$activacion) {

            //----------------------------------- VALIDAR MENSAJES --------------------------------
            $message_array = DatosExtraController::validarVIN($vpme);
            //---------------------------------- END VALIDAR MENSAJES -----------------------------


            //******************************** TABLA VPME INOFRMACION CLIENTES ********************************
            $verificar_informacion_cliente = vpme_informacion_clientes::where('id_vista_previa_movimiento_exitoso',$id_vpme)->get()->first();
            if(empty($verificar_informacion_cliente)) $message_array = '- ¡Falta complementar la información del cliente (segundo formulario)!.<br>'.$message_array;


            // $message_array = "";/////**************************************************************
            if(!empty($message_array)){
              DB::commit();
              return redirect()->back()->with('error',"¡No se puede generar el contrato porque la información está incompleta!. <br>".$message_array)->withInput();
            }
          }

          if(empty($message_array)){
            session(['pdfs_aceptacion_contrato' => $vpme->id]);

            //******************************** TABLA CONTACTOS ********************************
            $receptora_institucion = $receptora_agente = "";
            $cliente = "";
            if($vpme->idcontacto == 0){
              $vpme_asesores = vpme_asesores::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get()->first();
              $asesor = asesores::where('nomeclatura',$vpme_asesores->nomenclatura)->get();
              //nomenclatura
              $cliente = vpme_clientes::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get()->first();
              $nombre_completo = $cliente->nombre.' '.$cliente->apellidos;
              $iniciales_cliente="";
              $porciones = explode(" ", $nombre_completo);
              foreach ($porciones as $parte) {
                $iniciales_cliente.=substr($parte,0,1);
              }
              //fin nomenclatura

              $nomeclatura = $iniciales_cliente;
              $nombre = $cliente->nombre;
              $apellidos = $cliente->apellidos;
              $sexo = "---";
              $rfc = "";
              if($vpme_informacion_cliente->rfc != "N/A")$rfc = $vpme_informacion_cliente->rfc;
              $alias = "N/A";
              $trato = "N/A";
              $telefono_otro = "";
              $telefono_celular = $cliente->telefono;
              $email = "";
              if($vpme_informacion_cliente->correo != "N/A")$email = $vpme_informacion_cliente->correo;
              $referencia_nombre = "";
              $referencia_celular = "";
              $referencia_fijo = "";
              $referencia_nombre2 = "";
              $referencia_celular2 = "";
              $referencia_fijo2 = "";
              $referencia_nombre3 = "";
              $referencia_celular3 = "";
              $referencia_fijo3 = "";
              //Tabla vpme referencias
              if($vpme->tipo_venta == "Directa a Crédito"){
                $referencias = vpme_referencias::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get();
                if(!$referencias->isEmpty()){
                  foreach ($referencias as $key => $value) {
                    if($key == 0){
                      $referencia_nombre = $value->nombre." ".$value->apellidos;
                      $referencia_celular = $value->telefono;
                    }
                    if($key == 1){
                      $referencia_nombre2 = $value->nombre." ".$value->apellidos;
                      $referencia_celular2 = $value->telefono;
                    }
                    if($key == 2){
                      $referencia_nombre3 = $value->nombre." ".$value->apellidos;
                      $referencia_celular3 = $value->telefono;
                    }
                  }
                }
              }

              $tipo_registro = "Cliente";
              $recomendado = "0";
              $entrada = "";
              if(!$asesor->isEmpty())$asesor = $asesor->first()->idasesores; else $asesor = 0;
              $tipo_cliente = "0";
              $tipo_credito = "0";
              $linea_credito = "0";
              $codigo_postal = "0";
              if($cliente->cp != "N/A") $codigo_postal = $cliente->cp;
              $estado = $cliente->estado;
              $delmuni = $cliente->municipio;
              $colonia = "";
              if($cliente->colonia != "N/A")$colonia = $cliente->colonia;
              $calle = "";
              if($cliente->direccion != "N/A")$calle = $cliente->direccion;
              $foto_perfil = "NO";
              $usuario_creador = request()->cookie('usuario_creador');//usuario clave;
              $fecha_creacion = new \DateTime(now());

              $cliente = contactos::createContactos($nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular,
              $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2,
              $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente,
              $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $usuario_creador, $fecha_creacion);

              $iniciales_cliente = $cliente->idcontacto.'.'.$iniciales_cliente;
              $receptora_institucion = $receptora_agente = $iniciales_cliente;

              $vpme->idcontacto = $cliente->idcontacto;
              $vpme->save();

            }else {
              $cliente = contactos::where('idcontacto',$vpme->idcontacto)->get()->first();
              $nombre_completo = $cliente->nombre.' '.$cliente->apellidos;
              $iniciales_cliente="";
              $porciones = explode(" ", $nombre_completo);
              foreach ($porciones as $parte) {
                $iniciales_cliente.=substr($parte,0,1);
              }
              $iniciales_cliente = $cliente->idcontacto.'.'.$iniciales_cliente;
              $receptora_institucion = $receptora_agente = $iniciales_cliente;
            }

            //******************************** TABLA ESTADO DE CUENTA ********************************
            $inventario = "";
            if($vpme->tipo_unidad == "Unidad"){
              $inventario = inventario::where('vin_numero_serie',$vpme->vin_numero_serie)->where('idinventario',$vpme->idinventario)->get()->first();
            }
            if($vpme->tipo_unidad == "Trucks"){
              $inventario = inventario_trucks::where('vin_numero_serie',$vpme->vin_numero_serie)->where('idinventario_trucks',$vpme->idinventario)->get()->first();
            }
            $concepto="Venta Directa";
            $apartado_usado="N/A";
            $tipo_movimiento="cargo";
            $efecto_movimiento="V2";
            $fecha_movimiento=(new \DateTime(now()))->format('Y-m-d');

            $metodo_pago="1";
            $saldo_anterior="N/A";
            $saldo="N/A";
            $monto_precio=$vpme->monto_unidad;
            $serie_monto="1/1";
            $monto_total=$vpme->monto_unidad;
            $tipo_moneda="MXN";
            $tipo_cambio="1";
            $gran_total=$vpme->monto_unidad;
            $cargo=$vpme->monto_unidad;
            $abono="N/A";
            $emisora_institucion="Panamotors Center, S.A. de C.V.";
            $emisora_agente="INV";
            // $receptora_institucion=;
            // $receptora_agente="";
            $tipo_comprobante="Contrato de Compra y Venta";
            $referencia="N/A";
            $datos_marca=$inventario->marca;
            $datos_version=$inventario->version;
            $datos_color=$inventario->color;
            $datos_modelo=$inventario->modelo;
            $datos_vin=$inventario->vin_numero_serie;
            $datos_precio=$vpme->monto_unidad;
            $datos_estatus="Pendiente";

            $asesor1="";
            $enlace1="";
            $asesor2="";
            $enlace2="";
            if(!empty($vpme)){
              $vpme_asesores = vpme_asesores::where('id_vista_previa_movimiento_exitoso',$vpme->id)->get();
              if(!$vpme_asesores->isEmpty()){
                foreach ($vpme_asesores as $key => $value) {
                  if($value->tipo == "Asesor 1") $asesor1 = $value->nomenclatura;
                  if($value->tipo == "Asesor 2") $asesor2 = $value->nomenclatura;
                  if($value->tipo == "Enlace 1") $enlace1 = $value->nomenclatura;
                  if($value->tipo == "Enlace 2") $enlace2 = $value->nomenclatura;
                }
              }
              if(empty($asesor2)) $asesor2 = "N/A";
              if(empty($enlace1)) $enlace1 = "N/A";
              if(empty($enlace2)) $enlace2 = "N/A";
            }

            $coach="N/A";
            $archivo="";
            $comentarios=$vpme->comentarios_venta;
            $idcontacto=$cliente->idcontacto;
            $comision="N/A";
            $visible="SI";
            $comentarios_eliminacion="N/A";
            $usuario_elimino="0";
            $fecha_eliminacion=null;
            $usuario_creador=request()->cookie('usuario_creador');//usuario clave
            $fecha_creacion=new \DateTime(now());
            $fecha_guardado=new \DateTime(now());

            if($vpme->estatus != "Aceptado"){
              $estado_cuenta = estado_cuenta::createEstadoCuenta($concepto, $apartado_usado, $tipo_movimiento, $efecto_movimiento, $fecha_movimiento, $metodo_pago,
              $saldo_anterior, $saldo, $monto_precio, $serie_monto, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $abono,
              $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_marca,
              $datos_version, $datos_color, $datos_modelo, $datos_vin, $datos_precio, $datos_estatus, $asesor1, $enlace1, $asesor2, $enlace2,
              $coach, $archivo, $comentarios, $idcontacto, $comision, $visible, $comentarios_eliminacion, $usuario_elimino, $fecha_eliminacion,
              $usuario_creador, $fecha_creacion, $fecha_guardado);


              //****************************** Actualizar estatus_unidad en inventario - inventario_trucks ******************************
              if(!empty($inventario)){
                $inventario->estatus_unidad = "Vendido";
                $inventario->save();

                $cambio = 'El estatus de la unidad con VIN <b>'.$vpme->vin_numero_serie.'</b> fue actualizado de: <b>'.$inventario->estatus_unidad.'</b> a: <b>Vendido</b>
                con fecha:<b>'.$fecha_creacion->format('d-m-Y h:m:s').'</b>.<br>';

                if($vpme->tipo_unidad == "Unidad") inventario_cambios::createInventarioCambios($cambio, $vpme->usuario_creador, $fecha_creacion, $vpme->idinventario);
                if($vpme->tipo_unidad == "Trucks") inventario_cambios_trucks::createInventarioCambiosTrucks($cambio, $vpme->usuario_creador, $fecha_creacion, $vpme->idinventario);
              }

              $vpme->estatus = "Aceptado";
              $vpme->save();

              ///********************** GENERAR PDF SIN VISTA PREVIA - SOLO ALMACENAR PARA VISUALIZAR EN OTRO MODULO *************************
              $fecha = (new \DateTime(now()))->format('d_m_Y_h_m_s');
              $info_extra = (object)['fecha'=>$fecha];
              $view = (object)[];
              $view = PDFSaveIntoServerController::contratoDirectaContado(Crypt::encrypt($vpme->id));
              $name_file = GlobalFunctionsController::savePdfIntoServer($view->view, $view->nombre, $view->apellidos, $view->id_contacto_completo, "vpme", "venta_directa_contado","",$info_extra);

              $name_file = url('/').'/'.$name_file;
              $estado_cuenta->archivo = $name_file;
              $estado_cuenta->save();
            }
          }

          DB::commit();

          return redirect()->route('VPMovimientoExitoso.listaVentas')->with('success','Guardado correctamente');
        } catch (\Exception $e) {
          DB::rollback();
          return $e->getMessage();
          return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();

        }
      }



      public static function validarVIN($vpme){
        /****************************************** VALIDACION VIN 17 DIGITOS *************************************************/
        $inventario_dinamico = inventario_dinamico::where('idinventario',$vpme->idinventario)->where('columna','vin_numero_serie_completo')->get();

        $message_array = "";
        if($inventario_dinamico->isEmpty()) $message_array .= '- El VIN debe ser de 17 digitos y no se encuentra en sistema, solicitalo.<br>';

        /****************************************** VALIDACION INCONSISTENCIA *************************************************/
        $Inventario = "";
        if($vpme->tipo_unidad == "Unidad"){
          $Inventario = inventario::where('vin_numero_serie',$vpme->vin_numero_serie)->get();
        }
        if($vpme->tipo_unidad == "Trucks"){
          $Inventario = inventario_trucks::where('vin_numero_serie',$vpme->vin_numero_serie)->get();
        }

        if (sizeof($Inventario) > 0) {
          foreach ($Inventario as $Unidad) {

            $Unidad->img = '';
            $Directa_o_Permuta = estado_cuenta::select('idcontacto','fecha_movimiento','datos_estatus')->where('datos_vin', $Unidad->vin_numero_serie)->where('visible', 'SI')
            ->where(function ($query) {
              $query->where('concepto', 'Venta Directa' )
              ->orWhere('concepto', 'Venta Permuta' );
            })->first();

            if ($Directa_o_Permuta) {
              $CompraPermuta = estado_cuenta::where('datos_vin', $Unidad->vin_numero_serie)
              ->where('concepto', 'Compra Permuta')->where('visible', 'SI')
              ->where('fecha_movimiento', '>' , $Directa_o_Permuta->fecha_movimiento)->limit(1)->count();

              if ($CompraPermuta > 0) {
                $Unidad->pasa_compra_permuta = 'SI';
              }else{
                $Unidad->pasa_compra_permuta = 'NO';
                $message_array .= '- ¡El VIN '.$Unidad->vin_numero_serie.' contiene inconsistencia de ingreso!.<br>';

                $Directa_Deuda_Devolucion = estado_cuenta_proveedores::where('datos_vin', $Unidad->vin_numero_serie)->where('visible', 'SI')
                ->where('fecha_movimiento', $Directa_o_Permuta->fecha_movimiento)
                ->where(function ($query) {
                  $query->where('concepto', 'Compra Directa')
                  ->orWhere('concepto', 'Cuenta de Deuda')
                  ->orWhere('concepto', 'Devolución del VIN');
                })->limit(1)->count();

                if ($Directa_Deuda_Devolucion > 0) {
                  $Unidad->pasa_compra_permuta = 'SI';
                }else{
                  $Unidad->pasa_compra_permuta = 'NO';
                  $message_array .= '- ¡El VIN '.$Unidad->vin_numero_serie.' contiene inconsistencia de ingreso!.<br>';
                }
              }
            }else{
              $Unidad->pasa_compra_permuta = 'NO';
              $message_array .= '- ¡El VIN '.$Unidad->vin_numero_serie.' contiene inconsistencia de ingreso!.<br>';
            }

            if($Unidad->precio_piso == "0" || $Unidad->precio_digital == "0") $message_array .= '- ¡El VIN '.$Unidad->vin_numero_serie.' tiene un costo de $ 0.00 !.<br>';

          }
          // $ordenados = $Inventario->sortByDesc('pasa_compra_permuta');
          // return $ordenados->values()->all();
        }

        /************************** COMPROBAR DOCUMENTOS 2DA HOJA ************************************/
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
          if(empty($tabla_documentos)) $message_array .= '- ¡La unidad con VIN '.$vpme->vin_numero_serie.', no tiene documentos !.<br>';

          return $message_array;

        }



      }
