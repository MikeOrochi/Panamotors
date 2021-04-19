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
use App\Models\nivel_permisos_ordenes;
use App\Models\catalogo_departamento;
use App\Models\catalogo_colaborador;
use App\Models\catalogo_tipo_orden;
use App\Models\atencion_clientes;



class FacturacionController extends Controller {

  public function __construct(){
    $this->middleware('auth');
  }


  public function facturacion($id){
    $id = Crypt::decrypt($id);
    $vpme = vista_previa_movimiento_exitoso::where('id', $id)->first();

    $inventario = "";
    if($vpme->tipo_unidad == "Unidad"){
      $inventario = inventario::where('vin_numero_serie',$vpme->vin_numero_serie)->get()->first();
    }
    if($vpme->tipo_unidad == "Trucks"){
      $inventario = inventario_trucks::where('vin_numero_serie',$vpme->vin_numero_serie)->get()->first();
    }

    // $empleados = request()->cookie('user');//id_empleado
    $empleados = 58;//id_empleado

    $nivel_permisos_ordenes = nivel_permisos_ordenes::select('idcatalogo_departamento')->where('idempleado',$empleados)->get();
    $departamentos=catalogo_departamento::select('idcatalogo_departamento','nombre', 'nomenclatura')->where('visible','SI')->whereIn('idcatalogo_departamento', $nivel_permisos_ordenes)
                ->where('idcatalogo_departamento','1')->get();

    $ids_empleados = ['53','118','116','148','55','4','52'];
    $masters=empleados::whereIn('idempleados',$ids_empleados)->orWhere('departamento','Fuerza de Ventas')->orderBY('nombre','ASC')->get();



    $orden_compra_unidades =orden_compra_unidades::where('estatus','!=','Finalizado')->where('estatus','!=','Cancelado')->where('visible','SI')->where('procedencia','!=','')->where('estatus_orden','!=','No Negociable')->get();


    return view('VPMovimientoExitoso.facturacion', compact('vpme','inventario','empleados','departamentos','masters','orden_compra_unidades'));
  }

  public function busquedaFacturacion(){
      // $usuario_creador=request()->cookie('usuario_clave');//id_empleado
      $empleados=58;//id_empleado
      $id_category = request('id_category');
      $colaborador = "";

      //-----------------colaborador.php
      $consulta2=catalogo_colaborador::where('idcatalogo_departamento',$id_category)->get();
      $first = $consulta2->first();
      foreach($consulta2 as $registro2){
          if($first->idcatalogo_colaborador == $registro2->idcatalogo_colaborador){
              $colaborador .= "<option value='".$registro2->idcatalogo_colaborador."' selected>".$registro2->nomenclatura." - ".$registro2->nombre."</option>";
          }else {
              $colaborador .= "<option value='".$registro2->idcatalogo_colaborador."'>".$registro2->nomenclatura." - ".$registro2->nombre."</option>";
          }
      }

      // --------------------tipo_orden.php
      if ($id_category == 3) {
      	$catalogo_tipo_orden=catalogo_tipo_orden::where('idcatalogo_tipo_orden','38')->get();
      } else {
      	$catalogo_tipo_orden=catalogo_tipo_orden::where('idcatalogo_departamento',$id_category)
        ->where('idcatalogo_tipo_orden','12')->get();
      }
      $option_tipo_orden = "";
      foreach($catalogo_tipo_orden as $value){
      	$asignacion_empleado = $value->asignacion_empleado;
      	$asignacion_empleado = explode(';', $asignacion_empleado);
      	for ($i=0; $i < sizeof($asignacion_empleado); $i++) {
      		if ($empleados == $asignacion_empleado[$i]) {
      			$option_tipo_orden .= "<option value='".$value->idcatalogo_tipo_orden."'>".$value->nomenclatura." - ".$value->nombre."</option>";
      		}
      	}
      }

      // ------------------ niveles_permiso.php
      $result0=nivel_permisos_ordenes::where('idcatalogo_departamento',$id_category)->where('idempleado',$empleados)->get();
      foreach($result0 as $fila0) {

      	$nivel1="$fila0->nivel1";
      	$nivel2="$fila0->nivel2";
      	$nivel3="$fila0->nivel3";

      	if ($nivel1 === 'SI') {
      		$nivel_out = 'Cargo;Abono';
      	}

      	if ($nivel2 === 'SI') {
      		$nivel_out = 'Cargo';
      	}

      	if ($nivel3 === 'SI') {
      		$nivel_out = 'Generacion';
      	}

      	if ($nivel2 === 'SI' && $nivel3 === 'SI') {
      		$nivel_out = 'Cargo;N/A';
      	}

      }



      return json_encode(["colaborador"=>$colaborador, "catalogo_tipo_orden"=>$option_tipo_orden, "niveles_permiso"=>$nivel_out]);
  }


  public function busquedaInformacion(){
      try {
          $search = request('valorBusqueda');

          $contacts = DB::select("select * from contactos where idcontacto > 5000 and (idcontacto like '%".$search."%' ||
          concat_ws(' ', trim(nombre), trim(apellidos)) LIKE '%".$search."%' || nombre LIKE '%".$search."%' ||
          apellidos LIKE '%".$search."%' || alias LIKE '%".$search."%' || email LIKE '%".$search."%' ||
          telefono_otro LIKE '%".$search."%' || telefono_celular LIKE '%".$search."%') LIMIT 50");
          $contenido_contactos = "";
          $contenido_cliente = "";
          if(!empty($contacts)){
              foreach ($contacts as $key => $fila) {
                  $apelld = "";
                  if(!empty($fila->apellidos))$apelld = "$fila->apellidos";
                  $q = trim("$fila->nombre")." ".trim($apelld);
                  $iniciales_cliente="";
                  $porciones = explode(" ", $q);
                  foreach ($porciones as $parte) {
                      $iniciales_cliente.=$parte[0];
                  }
                  $iniciales_cliente=mb_strtoupper($iniciales_cliente);


                  $contenido_contactos.=" <option class='sugerencias_informacion_' value='$iniciales_cliente'>$fila->nombre $apelld </option> ";
                  $contenido_cliente.=" <option class='sugerencias_informacion_' value='$fila->idcontacto'>$fila->nombre $apelld </option> ";
              }

          }


          $empleados = DB::select("select * from empleados where idempleados like '%".$search."%' ||
          concat_ws(' ', trim(nombre), trim(apellido_paterno), trim(apellido_materno)) LIKE '%".$search."%' ||
          nombre LIKE '%".$search."%' || apellido_paterno LIKE '%".$search."%' || apellido_materno LIKE '%".$search."%' ||
          columna_b LIKE '%".$search."%' LIMIT 50");
          $contenido_empleados = "";
          if(!empty($empleados)){
              foreach ($empleados as $key => $fila) {
                  $apellidos = "$fila->apellido_paterno"." "."$fila->apellido_materno";
                  $q = trim("$fila->nombre")." ".trim($apellidos);
                  $iniciales_cliente="";
                  $porciones = explode(" ", $q);
                  foreach ($porciones as $parte) {
                      $iniciales_cliente.=$parte[0];
                  }
                  $iniciales_cliente=mb_strtoupper($iniciales_cliente);


                  $contenido_empleados.=" <option class='sugerencias_informacion_' value='$iniciales_cliente'>$fila->nombre $apellidos</option> ";
              }
          }
          return ['contacts'=>$contenido_contactos,'empleados'=>$contenido_empleados, 'cliente'=>$contenido_cliente];

      } catch (\Exception $e) {
          return ['contacts'=>$e->getMessage()];
      }

  }






    function guardar_orden(){
        $id_vpme = Crypt::decrypt(request('idVistaPrevia'));

        $vpme = vista_previa_movimiento_exitoso::where('id',$id_vpme)->get()->first();
        $estado_cuenta = estado_cuenta::where('datos_vin',$vpme->vin_numero_serie)->get()->last();



        $usuario_creador=request()->cookie('usuario_clave');//id_empleado
        $fecha_movimiento= date("Y-m-d");
        $fecha_guardado= date("Y-m-d H:i:s");
        $estatus = request('estatus');
        $asignacion = request('asignacion');
        $responsable = request('responsable');
        $fuente_informacion = request('fuente_informacion');
        $master = request('master');
        $comentarios = request('comentarios');
        $caso = request('caso');
        $idcontacto = request('idcontacto');
        // $idestado_cuenta = request('idestado_cuenta');
        $idestado_cuenta = $vpme->vin_numero_serie;
        // $idusuario = request('idusuario');
        $idusuario = request()->cookie('usuario_creador');
        $cerro = '0';
        $fecha_estimada_solucion = "0001-01-01 00:00:00";
        $fecha_real_solucion = "0001-01-01 00:00:00";
        $fecha_creacion = request('fecha_creacion');
        $idtipo_orden = request('tipo_orden');
        // $accion = request('accion');
        $accion = "1";
        $metodo_pago = request('m_pago');
        $monto_precio = request('precio_orden');
        $emisora_institucion = request('emisor_venta');
        $emisora_agente = request('agente_emisor_venta');
        $receptora_institucion = request('receptor_venta');
        $receptora_agente = request('agente_receptor_venta');
        $tipo_comprobante = request('tipo_comprobante');
        $comentarios_cotizacion = request('comentarios_cotizacion');
        $no_comprobante = request('no_comprobante');
        $auxiliar = request('auxiliar');
        $paga_cliente_v3 = request('pago_c');
        $paga_panamotors_v3 = request('pago_p');
        $paga_ambos_v3 = request('pago_ambos');
        $paga_terceros_v3 = request('pago_terceros');
        $monto_precio_cliente_v3 = request('paga_cliente');
        $monto_precio_panamotors_v3 = request('paga_panamotors');
        $monto_precio_terceros_v3 = request('precio_orden');
        $idcontacto_estado_cuenta_v3 = request('idc');
        $fecha_estimada_solucion = request('fecha_estimada_solucion');
        $proveedor_cliente = request('proveedor_cliente');
        if ($paga_cliente_v3 == 'Cliente') {
            $monto_precio_terceros_v3 = 'N/A';
        }
        if ($paga_panamotors_v3 == 'Panamotors') {
            $monto_precio_terceros_v3 = 'N/A';
            $idcontacto_estado_cuenta_v3 = 'N/A';
        }
        if ($paga_ambos_v3 == 'Ambos') {
            $monto_precio_cliente_v3 = request('paga_cliente');
            $monto_precio_panamotors_v3 = request('paga_panamotors');
            $idcontacto_estado_cuenta_v3 = request('idc');
            $monto_precio_terceros_v3 = request('precio_orden');
        }
        if ($paga_terceros_v3 == 'Terceros') {
            $monto_precio_cliente_v3 = '';
            $monto_precio_panamotors_v3 = '';
            $idcontacto_estado_cuenta_v3 = request('idc');
            $monto_precio_terceros_v3 = request('precio_orden');
        }
        $result211=catalogo_departamento::where('idcatalogo_departamento',$asignacion)->get();
        foreach( $result211 as $fila211) {
            $asignacion1 = $fila211->nomenclatura;
            $idcatalogo=$fila211->idcatalogo_departamento;
            $nombre_departamento=$fila211->nombre;
        }
        $result23=catalogo_colaborador::where('idcatalogo_departamento', $idcatalogo)->where('idcatalogo_colaborador',$responsable)->get();
        foreach ( $result23 as $fila23) {
            $responsable2 = $fila23->nomenclatura;
        }
        $idtipo_ordenx = request('tipo_orden');
        $result77x1=catalogo_tipo_orden::where('idcatalogo_tipo_orden',$idtipo_ordenx)->get();
        foreach( $result77x1 as $fila77x1) {
            $tipo_orden = "$fila77x1->nombre";
        }

        $result2=atencion_clientes::createAtencionClientes(
            $tipo_orden, 'Solicitud', $idcatalogo, $responsable2, $fuente_informacion, $master, $comentarios, $caso, $accion, $idcontacto,
            $idestado_cuenta, $idusuario, $idtipo_orden, '0', $fecha_estimada_solucion, $fecha_real_solucion, 'SI', $fecha_creacion, $fecha_guardado,
            '0', 'N/A', 'N/A', 'N/A', $fecha_movimiento, 'N/A', 'N/A', 'N/A', 'N/A', $emisora_institucion, $emisora_agente, $receptora_institucion,
            $receptora_agente, 'N/A', 'N/A', $idestado_cuenta, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', $proveedor_cliente );

            $row_ordenX = $result2;
            if ($row_ordenX) {
                $noUltimo1X = trim($row_ordenX->idatencion_clientes);
                $noUltimo1X_aux = $noUltimo1X;
                $noUltimo1X = base64_encode($noUltimo1X);
            }
            $orden_compra = request('orden_compra');
            $refacturacion = request('refacturacion');
            $array_checklist = array("Refacturación $refacturacion","PDF (R$refacturacion)","XML (R$refacturacion)","Comprobante De identificación (R$refacturacion)","Acta constitutiva (R$refacturacion)");
            if ($idtipo_orden == "12") {
                if ($orden_compra != "N/A" && $refacturacion != "N/A") {

                    $resultado201 = orden_compra_unidades::where('visible','SI')->where('idorden_compra_unidades',$orden_compra)->where('vin',$idestado_cuenta)->get();
                    dd($resultado201, $idestado_cuenta, $refacturacion, $orden_compra);
                    if (count($resultado201) > 0) {
                        foreach ($resultado201 as $fila201) {
                            $vin_oc = "$fila201->vin";
                        }

                        $resultado200 = at_oc::reateAtencionClientes($noUltimo1X_aux, $orden_compra, 'SI', $idusuario, $fecha_creacion, $fecha_guardado, $tipo_orden);
                        $con = 0;
                        $var = count($array_checklist);
                        $tipo_chec = "";
                        while ($con < $var) {
                            $tipo_chec = $array_checklist[$con];

                            $resultado202 = check_list_expediente_original::createCheckListExpedienteOriginal(
                                $tipo_chec, 'Refacturación Origen - Destino', '', '', '0', $vin_oc, '', '', '', '', '', '', '', '', '', '', '', '',
                                '', '', '', '', '', '0', '', '', '', '', '0', '0', 'SI', $idusuario, $fecha_creacion, '0001-01-01 00:00:00', $fecha_guardado,
                                '', '', '', '', '', $orden_compra, '', '', '', '', '', '', '', '', '', '', '', 'Ingreso', 'Pendiente', '', '1');
                                $con++;
                        }
                    }
                }
            }

            return redirect()->back()->with('success','Información guardada correctamente');

    }















}
