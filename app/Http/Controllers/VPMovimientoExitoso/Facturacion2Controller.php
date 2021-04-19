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
use App\Models\auxiliares;
use App\Models\auxiliar_principales;
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
use App\Models\catalogo_departamento;
use App\Models\atencion_clientes;
use App\Models\detalle_seguimiento;
use App\Models\estado_cuenta_requisicion;
use App\Models\estado_cuenta_requesicion_sobrantes;
use App\Models\abonos_estado_cuenta_requisicion;









class Facturacion2Controller extends Controller {

  public function __construct(){
    $this->middleware('auth');
  }




  public function guardar_orden(){

    DB::beginTransaction();
    try {
      $usuario_creador = \Request::cookie('usuario_creador');
      $tipo_mov_name = request()->tipo_mov_name;

      if ($tipo_mov_name === 'N/A') {
        guardar_orden_n_a();
      }else if ($tipo_mov_name === 'abono' || $tipo_mov_name == 'cargo') {

        //Copiar Archivo---------------------------------------------------------------------------------------------------------
        $file = request()->file('uploadedfile');
        $usuario_creador = \Request::cookie('usuario_creador');
        date_default_timezone_set('America/Mexico_City');
        $nombre = "COT_".date("Y_m_d__H_i_s")."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
        $archivo_cargado = 'storage/app/Comprobantes_Ordenes_Talleres/'.$nombre;
        \Storage::disk('local')->put('/Comprobantes_Ordenes_Talleres/'.$nombre,  \File::get($file));
        //------------------------------------------------------------------------------------------------------------------------
        if ($tipo_mov_name === 'abono' ) {
          //guardar_orden_abono($archivo_cargado);
        }else{
          //guardar_orden_cargo($archivo_cargado);
        }
      }

      //DB::commit();
      //return back()->with('success','Cita confirmada');
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
      return back()->with('error','Error, intente de nuevo')->withInput();
    }
  }

  public function guardar_orden_cargo($archivo_cargado){
    DB::beginTransaction();
    try {
      $proveedor_cliente = request()->proveedor_cliente;
      $usuario_creador = \Request::cookie('usuario_creador');
      $fecha_movimiento= date("Y-m-d");
      $fecha_guardado= date("Y-m-d H:i:s");
      $estatus = request()->estatus;
      $asignacion = request()->asignacion;
      $responsable = request()->responsable;
      $fuente_informacion = request()->fuente_informacion;
      $master = request()->master;
      $comentarios = request()->comentarios;
      $caso = request()->caso;
      $idcontacto = request()->idcontacto;
      $idestado_cuenta = request()->idestado_cuenta;
      $idusuario = request()->idusuario;
      $cerro = '0';
      $fecha_estimada_solucion = "0001-01-01 00:00:00";
      $fecha_real_solucion = "0001-01-01 00:00:00";
      $fecha_creacion = request()->fecha_creacion;
      $idtipo_orden = request()->tipo_orden;
      $accion = 'Solicitar';
      $metodo_pago = request()->m_pago;
      $monto_precio = request()->precio_orden;
      $emisora_institucion = request()->emisor_venta;
      $emisora_agente = request()->agente_emisor_venta;
      $receptora_institucion = request()->receptor_venta;
      $receptora_agente = request()->agente_receptor_venta;
      $tipo_comprobante = request()->tipo_comprobante;
      $comentarios_cotizacion = request()->comentarios_cotizacion;
      $no_comprobante = request()->no_comprobante;
      $auxiliar = request()->auxiliar;
      $fecha_estimada_solucion = request()->fecha_estimada_solucion;
      $paga_cliente_v3 = request()->pago_c;
      $paga_panamotors_v3 = request()->pago_p;
      $paga_ambos_v3 = request()->pago_ambos;
      $paga_terceros_v3 = request()->pago_terceros;
      $monto_precio_cliente_v3 = request()->paga_cliente;
      $monto_precio_panamotors_v3 = request()->paga_panamotors;
      $monto_precio_terceros_v3 = request()->precio_orden;
      $idcontacto_estado_cuenta_v3 = request()->idc;

      if ($paga_cliente_v3 == 'Cliente') {
        $monto_precio_terceros_v3 = 'N/A';
      }
      if ($paga_panamotors_v3 == 'Panamotors') {
        $monto_precio_terceros_v3 = 'N/A';
        $idcontacto_estado_cuenta_v3 = 'N/A';
      }
      if ($paga_ambos_v3 == 'Ambos') {
        $monto_precio_cliente_v3 = request()->paga_cliente;
        $monto_precio_panamotors_v3 = request()->paga_panamotors;
        $idcontacto_estado_cuenta_v3 = request()->idc;
        $monto_precio_terceros_v3 = request()->precio_orden;
      }
      if ($paga_terceros_v3 == 'Terceros') {
        $monto_precio_cliente_v3 = '';
        $monto_precio_panamotors_v3 = '';
        $idcontacto_estado_cuenta_v3 = request()->idc;
        $monto_precio_terceros_v3 = request()->precio_orden;
      }

      $CatalogoDepartamento = catalogo_departamento::select('idcatalogo_departamento', 'nombre', 'nomenclatura')->where('idcatalogo_departamento', $asignacion)->first();
      $asignacion1 = $Catalogo->nomenclatura;
      $idcatalogo = $Catalogo->idcatalogo_departamento;
      $nombre_departamento = $Catalogo->nommbre;

      $CatalogoColaborador = catalogo_colaborador::select('nomenclatura')->where('idcatalogo_departamento', $idcatalogo)
      ->where('idcatalogo_colaborador', $responsable)->get();
      $responsable2 = $CatalogoColaborador->nomenclatura;

      $idtipo_ordenx = request()->tipo_orden;
      $CatalogoOrden =  catalogo_tipo_orden::select('nombre')->where('idcatalogo_tipo_orden', $idtipo_ordenx)->first();
      $tipo_orden = $CatalogoOrden->nombre;

      $NuevoAC = atencion_clientes::createAtencionClientes($tipo_orden, 'Solicitud', $idcatalogo, $responsable2, $fuente_informacion,
      $master, $comentarios, $caso, $accion, $idcontacto, $idestado_cuenta, $idusuario,
      $idtipo_orden, '0', $fecha_estimada_solucion,$fecha_real_solucion,'SI',
      $fecha_creacion, $fecha_guardado, '0', 'N/A', 'cargo', 'suma', $fecha_movimiento,
      $metodo_pago, $monto_precio, 'MXN', '1', $emisora_institucion, $emisora_agente, $receptora_institucion,
      $receptora_agente, $tipo_comprobante, $no_comprobante,
      $idestado_cuenta, $archivo_cargado, $comentarios_cotizacion, $auxiliar, $paga_cliente_v3,
      $idcontacto_estado_cuenta_v3, $paga_panamotors_v3, $paga_ambos_v3, $paga_terceros_v3,
      $monto_precio_cliente_v3, $monto_precio_panamotors_v3,
      $monto_precio_terceros_v3, $proveedor_cliente);

      $no_comprobante = request()->no_comprobante;
      $no_comprobantex = request()->no_comprobante;

      $AtencionCliente = atencion_clientes::select('idtipo_orden')->where('idatencion_clientes', $no_comprobante)->first();
      if ($no_comprobante >= 512 && $no_comprobante <= 517 ) {

        $CatalogoTO = catalogo_tipo_orden::select('nombre')->where('idcatalogo_tipo_orden', $no_comprobante)->first();
        $nombre_orden = str_replace('/de/', ' de ', $CatalogoTO->nombre);

        detalle_seguimiento::createDetalleSeguimiento(
          'Seguimiento derivado de la orden: <b>'.$nombre_orden.'</b>, con folio asignado No.: <b>'.$no_comprobantex.'</b>'
          ,'Estatus','01-01-01 00:00:00','01-01-01 00:00:00','',$NuevoAC->idatencion_clientes,
          $usuario_creador,$fecha_creacion,$fecha_creacion,'N/A', 'N/A', 'SI'
        );
      }

      if ($paga_cliente_v3 === 'Cliente' && $paga_ambos_v3 == '') {
        $idtipo_orden_nombre = request()->tipo_orden;

        $CatalogoTipoO = catalogo_tipo_orden::select('nombre')->where('idcatalogo_tipo_orden', $idtipo_orden_nombre)->first();
        $idtipo_orden_nombre = $CatalogoTipoO->nombre;

        $idcontacto_estado_cuenta_v3 = request()->idc;
        $Contac = contactos::select('nombre','apellidos')->where('idcontacto', $idcontacto_estado_cuenta_v3)->first();
        $nombre_completo = $Contac->nombre.' '.$Contac->apellidos;
        $iniciales_cliente="";
        $porciones = explode(" ", $nombre_completo);
        foreach ($porciones as $parte) {
          $iniciales_cliente.=substr($parte,0,1);
        }

        $iniciales_cliente=mb_strtoupper($iniciales_cliente);
        $iniciales_cliente=$idcontacto_estado_cuenta_v3.'.'.$iniciales_cliente;
        $usuario_creador = request()->usuario_clave;
        $marca_aplica = request()->marca;
        $modelo_aplica = request()->modelo;
        $color_aplica = request()->color;
        $version_aplica = request()->version;
        $vin_aplica = request()->vin;

        $noUltimo1 = $NuevoAC->idatencion_clientes;
        estado_cuenta::createEstadoCuenta('Otros Cargos-C', 'N/A', 'cargo', '',
        $fecha_movimiento, $metodo_pago, '', '', $monto_precio_cliente_v3, '1/1', $monto_precio_cliente_v3,
        'MXN', '1', $monto_precio_cliente_v3, $monto_precio_cliente_v3, '', 'Panamotors Center, S.A. de C.V.',
        'Orden de atención a clientes',$iniciales_cliente, $iniciales_cliente,
        $idtipo_orden_nombre, $noUltimo1, $marca_aplica, $version_aplica,
        $color_aplica, $modelo_aplica, $vin_aplica, $monto_precio_cliente_v3, '', '', '', '',
        '', '', '#', $comentarios, $idcontacto_estado_cuenta_v3, '', 'SI', '',
        '0', '0001-01-01', $usuario_creador, $fecha_creacion, $fecha_guardado);

        if ($receptora_agente === "CCH") {
          $idauxiliar_principales = 6;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "TP1") {
          $idauxiliar_principales = 1;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "TP3") {
          $idauxiliar_principales = 3;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "TEDFM") {
          $idauxiliar_principales = 4;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "TJFR") {
          $idauxiliar_principales = 2;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "TMAFM") {
          $idauxiliar_principales = 5;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "B2") {
          $idauxiliar_principales = 7;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "EDFM") {
          $idauxiliar_principales = 0;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "Detallado") {
          $idauxiliar_principales = 0;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else if ($receptora_agente === "Citibanamex") {
          $idauxiliar_principales = 0;
          aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado);
        }else{
          eliminando_orden_atencion_clientes($noUltimo1);
        }

        //DB::commit();
        return back()->with('success','Orden Guardada');

      }
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error','Código: Inv-Lea-40 Lo sentimos, no se han podido confirmar la cita, intente de nuevo')->withInput();
    }

  }


  function aniadiendo_auxiliares_estado_cuenta_requisicion($idauxiliar_principales, $noUltimo1, $archivo_cargado) {
    DB::beginTransaction();
    try {
      $proveedor_cliente = request()->proveedor_cliente;
      $fecha_movimiento= request()->fecha;
      $fecha_guardado= date("Y-m-d H:i:s");
      $estatus = request()->estatus;
      $asignacion = request()->asignacion;
      $responsable = request()->responsable;
      $fuente_informacion = request()->fuente_informacion;
      $master = request()->master;
      $comentarios = request()->comentarios;
      $caso = request()->caso;
      $idcontacto = request()->idcontacto;
      $idestado_cuenta = request()->idestado_cuenta;
      $idusuario = request()->idusuario;
      $cerro = '0';
      $fecha_estimada_solucion = "0001-01-01 00:00:00";
      $fecha_real_solucion = "0001-01-01 00:00:00";
      $fecha_creacion = request()->fecha_creacion;
      $idtipo_orden = request()->tipo_orden;
      $accion = request()->accion;
      $metodo_pago = request()->m_pago;
      $monto_precio = request()->precio_orden;
      $emisora_institucion = request()->emisor_venta;
      $emisora_agente = request()->agente_emisor_venta;
      $receptora_institucion = request()->receptor_venta;
      $receptora_agente = request()->agente_receptor_venta;
      $tipo_comprobante = request()->tipo_comprobante;
      $comentarios_cotizacion = request()->comentarios_cotizacion;
      $no_comprobante = request()->no_comprobante;
      $auxiliar = request()->auxiliar;
      $aux_secundarios = request()->aux_secundarios;

      $aux_sec = array();
    	foreach (request()->aux_secundarios as $aux_S ) {
    		$aux_sec = $aux_S;
    	}
    	$array_aux_sec = explode(",", $aux_sec);
    	for ($i=0; $i < sizeof($array_aux_sec); $i++) {
    		$segundo_aux_sec[$i] = trim($array_aux_sec[$i]);
    		$tercer_aux_sec .= trim($array_aux_sec[$i]).",";
    	}

      $CatalogoDepa =catalogo_departamento::select('idcatalogo_departamento', 'nombre', 'nomenclatura')->where('idcatalogo_departamento', $asignacion)->first();
      $asignacion1 = $CatalogoDepa->nomenclatura;
  		$idcatalogo = $CatalogoDepa->idcatalogo_departamento;
  		$nombre_departamento = $CatalogoDepa->nombre;

      $CatalogoColab = catalogo_colaborador::select('nomenclatura')->where('idcatalogo_departamento', $idcatalogo)->where('idcatalogo_colaborador', $responsable)->first();
      $responsable2 = $CatalogoColab->nomencla::tura;

      estado_cuenta_requisicion::createEC_Requisicion($auxiliar,$idcontacto,$fuente_informacion,$idcatalogo,'Aprobado',
      'N/A',$tercer_aux_sec,'cargo','suma',$fecha_movimiento,$metodo_pago,0,$monto_precio,$monto_precio,
      '1/1',$monto_precio,'MXN','1',$monto_precio,$monto_precio,'',$emisora_institucion,$emisora_agente,$receptora_institucion,
      $receptora_agente,$tipo_comprobante,$noUltimo1,$idestado_cuenta,$archivo_cargado,$comentarios,$idauxiliar_principales,'','',
      '','','','','','','','',$no_comprobante,'Pendiente','','0001-01-01',
      'SI','','','0001-01-01 00:00:00',$idusuario,$fecha_creacion,$fecha_guardado);

      $asignacionX = request()->asignacion;
      $CatalogoDeparta = catalogo_departamento::select('nombre')->where('idcatalogo_departamento', $asignacionX)->first();
      $nombre = $CatalogoDeparta->nombre;

      $Auxiliares_One = auxiliares::createAuxiliares($nombre,$asignacion1,$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');
      $Auxiliares_Two = auxiliares::createAuxiliares('Costo Total','dep',$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');

      date_default_timezone_set('America/Mexico_City');
      $fecha_curso = date("Y");

      if ($metodo_pago == 1 || $metodo_pago == 3) {
        auxiliares::createAuxiliares(($metodo_pago == 1 ? 'Caja ':'Bancos ').$fecha_curso,'detV4',$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');
      }

      auxiliares::createAuxiliares('Tesorería General '.$fecha_curso,'detV4',$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');
      auxiliares::createAuxiliares($emisora_institucion.' '.$fecha_curso,$emisora_institucion,$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');
      auxiliares::createAuxiliares($idestado_cuenta,$idestado_cuenta,$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');
      auxiliares::createAuxiliares($emisora_institucion,$emisora_institucion,$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');
      auxiliares::createAuxiliares($responsable2,$responsable2,$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');

      $AuxiliarPrincipal = auxiliar_principales::select('concepto')->where('idauxiliar_principales', $idauxiliar_principales)->first();
      $idauxiliar_principales1 = $AuxiliarPrincipal->concepto;

      auxiliares::createAuxiliares($idauxiliar_principales1,$idauxiliar_principales1,$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');

      foreach ($segundo_aux_sec as $key => $SegundoAux) {
        auxiliares::createAuxiliares($SegundoAux,'AUXSEC',$direccion,$idauxiliar_principales,'N/A',$idestado_cuenta_requisicion,'SI',$idusuario,$fecha_creacion,$fecha_guardado,$fecha_movimiento,'','','');
      }

      $monto_global = $monto_precio;
      while ($monto_global > 0) {
        $nombre_aux = $emisora_institucion;
        $Sobrantes = estado_cuenta_requesicion_sobrantes::where('nombre_auxiliar', $nombre_aux)->where('visible', 'SI')->get();

        foreach ($Sobrantes as $keyS => $ECRS) {
          $monto_abono= $ECRS->monto_abono;
  				$idestado_cuenta_requisicion_abono_movimiento = $ECRS->idestado_cuenta_requisicion_abono_movimiento;
  				$referencia2 = $ECRS->referencia;
  				$total ="";

          if ($monto_abono  >= $monto_global) {
            $total = $monto_abono - $monto_global;
            $Requisicion = estado_cuenta_requisicion::where('idestado_cuenta_requisicion', $idestado_cuenta_requisicion_abono_movimiento)
            ->where('visible', 'SI')->first();

            $concepto2 = $Requisicion->concepto;
						$responsable2 = $Requisicion->responsable;
						$tipo_movimiento2 = $Requisicion->tipo_movimiento;
						$efecto_movimiento2 = $Requisicion->efecto_movimiento;
						$fecha_movimiento2 = $Requisicion->fecha_movimiento;
						$metodo_pago2 = $Requisicion->metodo_pago;
						$tipo_moneda2 = $Requisicion->tipo_moneda;
						$tipo_cambio2 = $Requisicion->tipo_cambio;
						$emisora_institucion2 = $Requisicion->emisora_institucion;
						$emisora_agente2 = $Requisicion->emisora_agente;
						$receptora_institucion2 = $Requisicion->receptora_institucion;
						$receptora_agente2 = $Requisicion->receptora_agente;
						$tipo_comprobante2 = "N/A";
						$comentarios2 = $Requisicion->comentarios;
						$factura2 = $Requisicion->factura;

  					return back()->with('success','(Desarrollo)');
          }else{
            return back()->with('success','(Desarrollo)');
          }
        }
      }

      //DB::commit();
      //return back()->with('success','Cita confirmada');

    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error','Código: Inv-Lea-40 Lo sentimos, no se han podido confirmar la cita, intente de nuevo')->withInput();
    }

  }


  public function guardar_abono($nombre_aux,$concepto,$tipo_movimiento,$efecto_venta,$fecha_movimiento,$responsables,$metodo_pago,$monto_abono,$tipo_moneda1,$tipo_cambio2,$monto_entrada,$emisor_venta,$agente_emisor_venta ,$receptor_venta,$agente_receptor_venta,$comprobante_venta,$n_referencia_venta,$factura,$descripcion_venta,$fecha_inicio){

    $idauxiliar_principal ="";
  	if ($agente_emisor_venta == "TP1") {
  		$idauxiliar_principal =1;
  	}else if ($agente_emisor_venta == "TP3") {
  		$idauxiliar_principal = 3;
  	}else if ($agente_emisor_venta == "TJFR") {
  		$idauxiliar_principal = 2;
  	}else if ($agente_emisor_venta == "TEDFM") {
  		$idauxiliar_principal = 4;
  	}else if ($agente_emisor_venta == "TMAFM") {
  		$idauxiliar_principal = 5;
  	}else if ($agente_emisor_venta == "CCH") {
  		$idauxiliar_principal = 6;
  	}else if ($agente_emisor_venta == "B2") {
  		$idauxiliar_principal = 7;
  	}

    $saldo_anterior = 0;
  	$saldo =0;
  	$monto2 =0;
  	$monto = $monto_abono;
  	$nontito =0;
  	$nombre_auxiliar =$nombre_aux;
  	$concepto_abono = $concepto;
  	$responsable = $responsables;
  	$fecha_creacion = $fecha_inicio;
  	$fecha_movimiento = $fecha_movimiento;
  	$tipo_movimientos =  $tipo_movimiento;
  	$efecto_ventas = $efecto_venta;
  	$metodo_pagos = $metodo_pago;
  	$tipo_moneda = $tipo_moneda1;
  	$tipo_cambio = $tipo_cambio2;

  	$emisora_institucion = $emisor_venta;
  	$emisora_agente = $agente_emisor_venta;
  	$receptora_institucion = $receptor_venta;
  	$receptora_agente = $agente_receptor_venta;

  	$tipo_comprobante =$comprobante_venta;
  	$referencia = $n_referencia_venta;
  	$num_factura = $factura;
  	$comentarios = $descripcion_venta;
  	date_default_timezone_set('America/Mexico_City');
  	$fecha_guardado=date("Y-m-d H:i:s");
  	$usuario_creador=$_SESSION['usuario_clave'];
  	$cc =0;

    if ($tipo_comprobante  == "Recibo Automático") {
      $RecibosReqAux = recibos_requesicion_auxiliar::createRecibosReqAuxiliar(
        $fecha_movimiento, $monto,$emisora_institucion,$emisora_agente,$receptora_institucion,
        $receptora_agente,$concepto,$metodo_pagos,$n_referencia_venta,$comentarios,$responsables,$nombre_auxiliar,
        $idauxiliar_principales,$usuario_creador,$factura,$fecha_guardado,$tipo_moneda,$tipo_cambio,$monto
      );

      $idrecibo = $RecibosReqAux->idrecibos_requesicion_auxiliar;

      $id_rec2 = base64_encode($idrecibo);

  		$n1=strlen($idrecibo);
  		$n1_aux=10-$n1;
  		$mat="";

  		for ($i=0; $i <$n1_aux ; $i++) {
  			$mat.="0";
  		}

  		$id_recibo_completos= "R".$mat.$idrecibo;

      recibos_requesicion_auxiliar::where('idrecibos_requesicion_auxiliar', $idrecibo)
      ->update(['referencia' => $id_recibo_completos]);

      $idr = base64_encode($idrecibo);

      return back()->with('success','recibo_por_axuliar_pdf, (Desarrollo)');

      /*
  		echo "
  		<script language='javascript' type='text/javascript'>
  		  window.open('recibo_por_axuliar_pdf.php?idrb=$idr','_blank');
  		</script>";*/

    }else{
  		$id_recibo_completos = $n_referencia_venta;
      $Auxiliares_Three = auxiliares::select('idestado_cuenta_requisicion')
      ->where('nombre', $nombre_auxiliar)->where('visible', 'SI')
      ->orderBy('fecha_movimiento_estado_cuenta_requisicion','ASC')->get();

      $numumeros = 0;
  		$cantidad_pendiente ="";

      foreach ($Auxiliares_Three as $key_Aux => $Aux_T) {
        $idestado_cuenta_requesi= "$fila[idestado_cuenta_requisicion]";
  			$bandera =1;

        while ($monto > 0 && $bandera != 0) {

          $EstadosCuentaRequsiscion =  estado_cuenta_requisicion::select('datos_estatus','monto_precio')->
          where('idestado_cuenta_requisicion', $idestado_cuenta_requesi)->where('visible', 'SI')
          ->where('receptora_agente', '<>', 'EFECTIVALE SA DE CV')
          ->where('tipo_movimiento', '<>' ,'abono')
          ->where('estatus', 'Aprobado')
          ->where('monto_precio', '<>', '0')
          ->where(function ($query) {
            $query->where('receptora_agente', '<>' , 'EFECTICARD SA DE CV' )
            ->where('receptora_agente', '<>' , 'SI VALE SA DE CV' )
            ->where('receptora_agente', '<>' , 'SI VALE SA DE CV DESPENSA' )
            ->where('receptora_agente', '<>' , 'TAG ID DE MEXICO SA DE CV' );
          })->get();

          if (sizeof($EstadosCuentaRequsiscion) > 0 ) {

            foreach ($EstadosCuentaRequsiscion as $key_ECR => $ECR) {
              $datos_estatus = $ECR->datos_estatus;
              if ($datos_estatus != "Pagado") {
                $monto_precio = $ECR->monto_precio;

                $AbonosEstadoCuentaR = abonos_estado_cuenta_requisicion::select('cantidad_pendiente')->where('idestado_cuenta_requisicion_movimineto', $idestado_cuenta_requesi)
                ->where('visible', 'SI')
                ->orderBy('fecha_pago','ASC')->first();

                if ($AbonosEstadoCuentaR) {
  									$cantidad_pendiente = $AbonosEstadoCuentaR->cantidad_pendiente;
  							}else{
  								$cantidad_pendiente = $monto_precio;

                  if ($monto >= $cantidad_pendiente) {
                    $saldo_anterior = $monto-$cantidad_pendiente;
    								$monto = $saldo_anterior;
    								$saldo =$cantidad_pendiente-$cantidad_pendiente;

                    $EstadoCuentaRe = estado_cuenta_requisicion::where('idestado_cuenta_requisicion', $idestado_cuenta_requesi)
                    ->where('visible', 'SI')->first();
                    $EstadoCuentaRe->datos_estatus = 'Pagado';
                    $EstadoCuentaRe->save();

                    $idcatalogo_provedores = $EstadoCuentaRe->idcatalogo_provedores;
  									$idauxiliar_principales = $EstadoCuentaRe->idauxiliar_principales;
  									$idcatalogo_departamento = $EstadoCuentaRe->idcatalogo_departamento;
  									$datos_vin = $EstadoCuentaRe->datos_vin;
  									$referencia_cargo = $EstadoCuentaRe->referencia;
  									$apartado_usado = $EstadoCuentaRe->apartado_usado;
  									$apartado_uasado_todo .=$apartado_usado ;

  									$emisora_institucion2 = $EstadoCuentaRe->emisora_institucion;
  									$emisora_agente2 = $EstadoCuentaRe->emisora_agente;

                    estado_cuenta_requisicion::createEC_Requisicion($concepto_abono,$idcatalogo_provedores,$responsable,$idcatalogo_departamento,'Aprobado',
                    '',$apartado_uasado_todo,$tipo_movimientos,$efecto_ventas,$fecha_movimiento,$metodo_pagos,$cantidad_pendiente,$saldo,$cantidad_pendiente,
                    '',$cantidad_pendiente,$tipo_moneda,$tipo_cambio,$cantidad_pendiente,'',$cantidad_pendiente,
                    $emisora_institucion,$emisora_agente,$emisora_institucion2,$emisora_agente2,$tipo_comprobante,$referencia,
                    $datos_vin,'Pendiente',$comentarios,$idauxiliar_principales,'N/A',
                    '','',$referencia_cargo,'','','','','','',$num_factura,'','','',
                    'SI','','','',$usuario_creador,$fecha_creacion,$fecha_guardado);
                  }
  							}
              }else{
                $bandera = 0;
              }
            }

          }else{
  					$bandera =0;
  				}

        }
      }
  	}

  }




}
