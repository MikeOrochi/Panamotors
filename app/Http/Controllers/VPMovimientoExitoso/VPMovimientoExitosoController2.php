<?php

namespace App\Http\Controllers\VPMovimientoExitoso;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\catalogo_cobranza;
use App\Models\catalogo_metodos_pago;
use App\Models\bancos_emisores;
use App\Models\catalogo_tesorerias;
use App\Models\beneficiarios_proveedores;
use App\Models\catalogo_comprobantes;
use App\Models\estado_cuenta_proveedores;
use App\Models\saldo_compras;
use App\Models\vista_previa_movimiento_exitoso;

use App\Models\proveedores;
use App\Models\contactos;
use App\Models\vpme_clientes;
use App\Models\vpme_pagares;
use App\Models\vpme_referencias;
use App\Models\vpme_asesores;
use App\Models\vpme_pagos;
use App\Models\empleados;
use App\Models\publicacion_vin_fotos;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class VPMovimientoExitosoController2 extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }


  public function storeNewMovement(){
    DB::beginTransaction();
    try {
      $cliente_existente = request('idContact');
      $usuario_creador = request()->cookie('usuario_creador');//usuario clave
      /*************************************** Tabla vista_previa_movimiento_exitoso ******************************************************/
      $validate_descuento = request('RangeDescuento');
      if(!empty($validate_descuento)) $descuento = request('RangeDescuento');///
      else $descuento = 0;

      $tipo_venta = request("tipoVenta");
      $saldo = request('saldo_nuevo_venta');
      $tipo_cambio = request('tipo_cambio_principal');
      $tipo_moneda = "MXN";

      /******************* Nombre compuesto emmisor **************************/
      $institucion_emisora = "";
      $agente_emisor = "";
      $institucion_receptora = request("receptor_venta");
      $agente_receptor = request("agente_receptor_venta");


      $vpme_clientes = vpme_clientes::select('id')->orderBy('id','DESC')->limit(1)->first();
      $id_last = 1;
      if($vpme_clientes){
        $id_last = $vpme_clientes->id;
        $id_last+=1;
      }
      if($cliente_existente == "N/A"){
        $nombre_completo = request('nombre').' '.request('apellidos');
        $iniciales_cliente="";
        $porciones = explode(" ", $nombre_completo);
        foreach ($porciones as $parte) {
          $iniciales_cliente.=substr($parte,0,1);
        }
        $iniciales_cliente = $id_last.'.'.$iniciales_cliente;
        $institucion_emisora = $agente_emisor = $iniciales_cliente;
      }else{
        $cliente = contactos::where('idcontacto',$cliente_existente)->get()->first();
        $nombre_completo = $cliente->nombre.' '.$cliente->apellidos;
        $iniciales_cliente="";
        $porciones = explode(" ", $nombre_completo);
        foreach ($porciones as $parte) {
          $iniciales_cliente.=substr($parte,0,1);
        }
        $iniciales_cliente = $cliente_existente.'.'.$iniciales_cliente;
        $institucion_emisora = $agente_emisor = $iniciales_cliente;
      }

      /********************* Anticipo ************************/
      $anticipo = 0;
      if($tipo_moneda == 'USD' && !is_Null(request('CantidadAnticipoUSD')) ) $anticipo = request('CantidadAnticipoUSD');
      if($tipo_moneda == 'MXN' && !is_Null(request('CantidadAnticipoMXN'))) $anticipo = request('CantidadAnticipoMXN');
      $saldo = $saldo - $anticipo;

      $metodo_pago_anticipo = $tipo_comprobante_anticipo = $referencia_anticipo = $archivo_anticipo = $comentarios_anticipo = "N/A";
      if($anticipo > 0){
        $metodo_pago_anticipo = request('m_pago_anticipo');
        $tipo_comprobante_anticipo = request('comprobante_anticipo');
        // $referencia_anticipo = request('n_referencia_anticipo');
        $referencia_anticipo = "N/A";
        // $temp_file_anticipo = request()->file('uploadedfile_anticipo');////archivo
        $comentarios_anticipo = request('ComentariosAnticipo');

        // $nombre = $temp_file_anticipo->getClientOriginalName();
        // $nombre = "anticipo_".$id_last."_".(date('Y_m_d_h_m_s'))."_Usr_".$usuario_creador."_".$temp_file_anticipo->getClientOriginalName();
        // $archivo_anticipo = 'storage/app/VPMovimientoExitoso/evidencias_ventas/'.$nombre;
        $archivo_anticipo = 'N/A';
        // Storage::disk('local')->put('/VPMovimientoExitoso/evidencias_ventas/'.$nombre,  \File::get($temp_file_anticipo));
      }

      /****************** Datos de la venta ******************/
      $vin_numero_serie = request('vin_venta');
      $tipo_unidad = request('tipo_unidad');
      // $referencia_venta = request('n_referencia_venta');
      $referencia_venta = "N/A";
      $tipo_comprobante_venta = request('tipo_comprobante_compra');
      $comentarios_venta = request('descripcion_venta');

      // $temp_comprobante_venta = request()->file('comprobante_compra');////archivo
      // $nombre_cv = "comprobante_venta_".$id_last."_".(date('Y_m_d_h_m_s'))."_Usr_".$usuario_creador."_".$temp_comprobante_venta->getClientOriginalName();
      // $archivo_comprobante_venta = 'storage/app/VPMovimientoExitoso/evidencias_ventas/'.$nombre_cv;
      // Storage::disk('local')->put('/VPMovimientoExitoso/evidencias_ventas/'.$nombre_cv,  \File::get($temp_comprobante_venta));
      $archivo_comprobante_venta = 'N/A';




      $inventario = "";
      $idinventario = "";
      $numero_motor = "";
      if($tipo_unidad == "Unidad"){
        $inventario = inventario::where('vin_numero_serie',$vin_numero_serie)->first();
        $idinventario = $inventario->idinventario;
        $numero_motor = "N/A";
      }
      if($tipo_unidad == "Trucks"){
        $inventario = inventario_trucks::where('vin_numero_serie',$vin_numero_serie)->get()->first();
        $idinventario = $inventario->idinventario_trucks;
        $numero_motor = "Pendiente";
      }
      $estatus = "Pendiente";
      $area = "VPME";
      $estatus_orden = "Pendiente";

      // $monto_unidad = $inventario->precio_piso;
      $monto_unidad = request('saldo_nuevo_venta');
      $procedencia = $inventario->procedencia;
      $fecha_guardado =  new \DateTime(request('fechapago_venta1'));

      $temp_carta_autorizacion = request()->file("uploadedfile_Contado");////archivo
      $carta_autorizacion = "";
      if(!empty($temp_carta_autorizacion)) {
        $nombre_ca = "carta_autorizacion_".$id_last."_".(date('Y_m_d_h_m_s'))."_Usr_".$usuario_creador."_".$temp_carta_autorizacion->getClientOriginalName();
        $carta_autorizacion = 'storage/app/VPMovimientoExitoso/evidencias_ventas/'.$nombre_ca;
        Storage::disk('local')->put('/VPMovimientoExitoso/evidencias_ventas/'.$nombre_ca,  \File::get($temp_carta_autorizacion));
      }else $carta_autorizacion = "N/A";

      $idcontacto = 0;
      if($cliente_existente != "N/A")$idcontacto = $cliente_existente;

      $visible = "SI";

      $vpme = vista_previa_movimiento_exitoso::createVistaPreviaMovimientoExitoso(
        $idinventario, $vin_numero_serie, $numero_motor,$tipo_unidad, $estatus, $usuario_creador, $tipo_venta, $descuento, $area, $idcontacto, $estatus_orden,
        $tipo_moneda, $tipo_cambio, $monto_unidad, $saldo, $anticipo, $metodo_pago_anticipo, $tipo_comprobante_anticipo, $referencia_anticipo,
        $archivo_anticipo, $comentarios_anticipo, $institucion_emisora, $agente_emisor, $institucion_receptora, $agente_receptor, $referencia_venta,
        $tipo_comprobante_venta, $archivo_comprobante_venta, $comentarios_venta, $procedencia, $carta_autorizacion,$fecha_guardado, $visible
      );

      /*************************************** Tabla vpme_clientes ******************************************************/
      if($cliente_existente == "N/A"){
        $nombre=request("nombre");
        $apellidos=request("apellidos");
        $telefono=request("telefono");
        $estado=request("estado");
        $municipio=request("municipio");
        $cp = request("cp");
        if(is_Null($cp)) $cp = "N/A";
        $colonia = request("colonia");
        if(is_Null($colonia))$colonia = "N/A";
        $direccion=request("calle");
        if(is_Null($direccion)) $direccion = "N/A";
        $vpme_clientes = vpme_clientes::createVPMEClientes( $vpme->id, $nombre, $apellidos, $telefono, $estado, $municipio, $cp, $colonia, $direccion );
      }else{
        $cliente = contactos::where('idcontacto',$idcontacto)->get()->first();
      }

      /*####################################################### CONTADO #######################################################*/
      if($tipo_venta == "Contado" || $tipo_venta == "Directa de Contado"){
        $monto = $saldo;
        $cantidad_pendiente = 0;
        $metodo_pago = request('metodo_pago');
        $num_pagos = request('NumPagos');


        if($metodo_pago == "Definir" && $num_pagos > 0){
          for ($i=0; $i < $num_pagos ; $i++) {
            $monto_pago = request('monto_pago_mixto_'.$i);
            $cantidad_pendiente = $monto - $monto_pago;
            $tipo_comprobante = $tipo_comprobante_venta;
            $metodo_pago = request("metodo_pago_mixto_".$i);
            $estatus = "Pendiente";
            $archivo_comprobante = $archivo_comprobante_venta;////archivo
            $fecha_pago = (new \DateTime(now()))->format('Y-m-d');
            $comentarios = "NA";

            vpme_pagos::createVPMEPagos( $vpme->id, $monto_pago, $cantidad_pendiente, $metodo_pago, $tipo_comprobante,
            $estatus, $archivo_comprobante, $fecha_pago, $comentarios, "SI" );
          }
        }else {
          $tipo_comprobante = $tipo_comprobante_venta;
          $estatus = "Pendiente";
          $archivo_comprobante = $archivo_comprobante_venta;////archivo
          $fecha_pago = (new \DateTime(now()))->format('Y-m-d');
          $comentarios = "NA";

          vpme_pagos::createVPMEPagos( $vpme->id, $monto, $cantidad_pendiente, $metodo_pago, $tipo_comprobante,
          $estatus, $archivo_comprobante, $fecha_pago, $comentarios, 'SI' );
        }
      }
      /*####################################################### CREDITO #######################################################*/
      if($tipo_venta == "Crédito" || $tipo_venta == "Directa a Crédito"){
        /********************* Referencias ***************************/
        if(request()->NumReferencias > 0){
          for ($i=1; $i <= request()->NumReferencias ; $i++) {
            $nombre = request('nombre_ref_'.$i);
            $apellidos = request('apellidos_ref_'.$i);
            $telefono = request('tel_ref_'.$i);

            vpme_referencias::createVPMEReferencias( $vpme->id, $nombre, $apellidos, $telefono);
          }
        }
        /********************* PAGARES *****************************/
        if(request()->NumeroPagares > 0){
          for ($i=0; $i < request()->NumeroPagares ; $i++) {

            $num_pagare = ($i+1).'/'.request()->NumeroPagares;
            $monto = request('CantidadPagare_'.$i);
            $fecha_vencimiento = request('FechaPagare_'.$i);
            $tipo = request('TipoPagare_'.$i);
            $estatus = 'Pendiente';
            $archivo_original = "N/A";
            $comentarios = request('ComentariosPagare_'.$i);
            $id_vista_previa_movimiento_exitoso = $vpme->id;
            $fecha_guardado = new \DateTime(now());
            $visible = 'SI';

            vpme_pagares::createVPMEPagares( $id_vista_previa_movimiento_exitoso, $num_pagare, $monto, $fecha_vencimiento,
            $estatus, $tipo, $archivo_original, $comentarios, $fecha_guardado, $visible );
          }
        }
      }
      /*************************************** Tabla vpme_asesores ******************************************************/
      $asesor_1 = request('Asesor_uno');
      $asesor_2 = request('Asesor_dos');
      $enlace_1 = request('Enlace_uno');
      $enlace_2 = request('Enlace_dos');

      if($asesor_1 != "No Aplica" && $asesor_1 != "N/A"){
        $empleado = empleados::where('idempleados',$asesor_1)->get()->first();
        $nomenclatura = $empleado->columna_b;
        vpme_asesores::createVPMEAsesores($vpme->id, $empleado->idempleados,'Asesor 1',$nomenclatura );
      }
      if($asesor_2 != "No Aplica" && $asesor_2 != "N/A"){
        $empleado = empleados::where('idempleados',$asesor_2)->get()->first();
        $nomenclatura = $empleado->columna_b;
        vpme_asesores::createVPMEAsesores($vpme->id, $empleado->idempleados,'Asesor 2',$nomenclatura );
      }
      if($enlace_1 != "No Aplica" && $enlace_1 != "N/A"){
        $empleado = empleados::where('idempleados',$enlace_1)->get()->first();
        $nomenclatura = $empleado->columna_b;
        vpme_asesores::createVPMEAsesores($vpme->id, $empleado->idempleados,'Enlace 1',$nomenclatura );
      }
      if($enlace_2 != "No Aplica" && $enlace_2 != "N/A" &&  !empty($enlace_2)){
        $empleado = empleados::where('idempleados',$enlace_2)->get()->first();
        $nomenclatura = $empleado->columna_b;
        vpme_asesores::createVPMEAsesores($vpme->id, $empleado->idempleados,'Enlace 2',$nomenclatura );
      }


      /*************************************** Tabla vpme_asesores ******************************************************/



      DB::commit();
      session(['pdf_vpme' => $vpme->id]);
      return redirect()->back()->with('success','Guradado correctamente');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
      return $e->getMessage();
    }
  }


  public function updateMovement($id,$estatus){
      $id = Crypt::decrypt($id);
    DB::beginTransaction();
    try {
      vista_previa_movimiento_exitoso::where('id', $id)->update(['estatus' => $estatus]);
      DB::commit();
      return back()->with('success','Vista Previa Actualizada');
    } catch (\Exception $e) {
      DB::rollback();
      return back()->with('error','Error intente de nuevo')->withInput();
      return $e->getMessage();
    }
  }

}
