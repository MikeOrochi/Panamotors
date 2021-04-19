<?php

namespace App\Http\Controllers\VPMovimientoExitoso;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventario;
use App\Models\inventario_trucks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\catalogo_metodos_pago;
use App\Models\catalogo_comprobantes;
use App\Models\catalogo_tesorerias;
use App\Models\bancos_emisores;
use App\Models\vista_previa_movimiento_exitoso;
use App\Models\solicitud_descuento_vista_previa;
use App\Models\estado_cuenta_proveedores;
use App\Models\estado_cuenta;
use App\Models\contactos;
use App\Models\empleados;
use App\Models\vpme_clientes;
use App\Models\publicacion_vin_fotos;
use App\Models\vpme_pagares;







class VPMovimientoExitosoController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){

    $Asesores = empleados::select('idempleados','columna_b', 'nombre', 'apellido_paterno', 'apellido_materno')
    ->where(function ($query) {
      $query->where('idempleados', '53' )
      ->orWhere('idempleados', '118' )
      ->orWhere('idempleados', '116' )
      ->orWhere('idempleados', '148' )
      ->orWhere('idempleados', '55' )
      ->orWhere('idempleados', '4' )
      ->orWhere('idempleados', '52' )
      ->orWhere('departamento', 'Fuerza de Ventas' );
    })->orderBy('nombre','ASC')->get();

    $MetodosPago = catalogo_metodos_pago::select('nomeclatura', 'nombre')->get()->whereIn('nomeclatura', [1,3]);
    $CatalogoComprobante = catalogo_comprobantes::select('nombre')->where('nombre', 'Contrato de Compra y Venta')->get();
    $CatalogoTesorerias = catalogo_tesorerias::select('nombre','nomeclatura')->where('nomeclatura', 'INV')->get();
    $BancosEmisores = bancos_emisores::select('nombre')->where('nombre', 'Panamotors Center, S.A. de C.V.')->get();
    return view('VPMovimientoExitoso.index',compact('MetodosPago','CatalogoComprobante','CatalogoTesorerias','BancosEmisores','Asesores'));
  }

  public function ListaVentas(){
    $Ventas = vista_previa_movimiento_exitoso::select('vista_previa_movimiento_exitoso.*','vpme_codigo_autorizacion.codigo')
    ->where('estatus', '!=','Rechazado')
    ->leftJoin('vpme_codigo_autorizacion', 'vpme_codigo_autorizacion.id_vista_previa_movimiento_exitoso', '=', 'vista_previa_movimiento_exitoso.id')
    ->orderBy('vista_previa_movimiento_exitoso.created_at','DESC')->get();
        
    foreach ($Ventas as $key => $V) {
      if ($V->tipo_unidad == "Unidad") {
        $V->Unidad = inventario::where('idinventario',$V->idinventario)->first();
      }else{
        $V->Unidad = inventario_trucks::where('idinventario_trucks',$V->idinventario)->first();
      }

      if($V->idcontacto == 0){
        $V->Contacto = vpme_clientes::select('nombre','apellidos')->where('id_vista_previa_movimiento_exitoso', $V->id)->first();
      }else{
        $V->Contacto = contactos::select('nombre','apellidos')->where('idcontacto', $V->idcontacto)->first();
      }
    }
    $usuario_creador = request()->cookie('usuario_creador');//usuario clave;
    $FechaActual = \Carbon\Carbon::now();

    return view('VPMovimientoExitoso.list',compact('Ventas','FechaActual','usuario_creador'));
  }

  public function searh(){

    DB::beginTransaction();
    try {
      $vin = request()->valorBusqueda;

      $Inventario = inventario::select(
        DB::raw('"Unidad" as tipo'),
        'idinventario','marca','version','color','modelo','vin_numero_serie','precio_piso','precio_digital','fecha_apertura'
        )
        ->where('visible', 'SI')->where('idinventario', '<>',0)
        ->where('estatus_unidad', '<>' , 'Vendido')
        ->where(function ($query) use ($vin){
          $query->where('vin_numero_serie', 'like' , '%'.$vin.'%' )
          ->orWhere('marca', 'like' , '%'.$vin.'%' )
          ->orWhere('version', 'like' , '%'.$vin.'%' )
          ->orWhere('modelo', 'like' , '%'.$vin.'%' )
          ->orWhere('color', 'like' , '%'.$vin.'%' );
        })->unionAll(inventario_trucks::select(
          DB::raw('"Trucks" as tipo'),
          'idinventario_trucks','marca','version','color','modelo','vin_numero_serie','precio_piso','precio_digital','fecha_apertura'
          )
          ->where('visible', 'SI')->where(function ($query) use ($vin){
            $query->where('vin_numero_serie', 'like' , '%'.$vin.'%' )
            ->where('estatus_unidad', '<>' , 'Vendido')
            ->orWhere('marca', 'like' , '%'.$vin.'%' )
            ->orWhere('version', 'like' , '%'.$vin.'%' )
            ->orWhere('modelo', 'like' , '%'.$vin.'%' )
            ->orWhere('color', 'like' , '%'.$vin.'%' );
          })
          )->orderBy('fecha_apertura','DESC')->get();

          DB::commit();
          return $Inventario;
        } catch (\Exception $e) {
          DB::rollback();
          return json_encode($e->getMessage());
        }
      }

      public function SolicitarDescuento(){
        DB::beginTransaction();
        try {
          date_default_timezone_set('America/Mexico_City');
          $id_inventario = request()->id;
          $tipo_unidad = request()->tipo;
          $vin = request()->vin;
          if ($tipo_unidad ==  "UNIDAD") {
            $Inventario = inventario::select('precio_digital','precio_piso')->where('idinventario', $id_inventario)->first();
          }else{
            $Inventario = inventario_trucks::select('precio_digital','precio_piso')->where('idinventario_trucks', $id_inventario)->first();
          }
          $precio = $Inventario->precio_piso;
          $descuento = request()->descuento;
          $CantidadDescuento = round(($precio/100)*$descuento);
          $precioFinal = round($precio-$CantidadDescuento,2);
          $status = 'Pendiente';
          $usuario_creador = \Request::cookie('usuario_creador');
          $usuario_creador_admin = null;
          $fecha_creacion = date("Y-m-d H:i:s");
          $fecha_guardado = date("Y-m-d H:i:s");

          solicitud_descuento_vista_previa::createSolicitudVistaPrevia($id_inventario,$tipo_unidad,$vin,$precio,$descuento,$precioFinal,$status,$usuario_creador,$usuario_creador_admin,$fecha_creacion,$fecha_guardado);
          DB::commit();
          return json_encode('Ok');
        } catch (\Exception $e) {
          DB::rollback();
          return json_encode($e->getMessage());
        }
      }

      public function MisDescuentosSolicitados(){
        $usuario_creador = \Request::cookie('usuario_creador');
        $vin = request()->vin;
        $Solicitud = solicitud_descuento_vista_previa::where('usuario_creador', $usuario_creador)->where('vin', $vin)
        ->orderBy('id_solicitud_descuento_vista_previa','DESC')->limit(1)->first();

        if ($Solicitud) {
          if ($Solicitud->status == "Pendiente") {
            $Solicitud->status = '<button type="button" class="btn btn-warning">Pendiente</button>';
          }else if ($Solicitud->status == "Aceptado") {
            $Solicitud->status = '<button type="button" class="btn btn-success" onclick="ModificarDescuento('.$Solicitud->descuento.')" data-dismiss="modal">Aceptado</button>';
          }

          return $Solicitud;
        }else{
          return json_encode([]);
        }
      }

      public function ValidarDeuda(){

        $vin = request()->vin_validacion;
        $tipo_mov = request()->tipo_mov;
        $tipo_contactos = request()->tipo_contactos;
        $idcontactos = request()->idcontactos;

        $Mensaje = "";

        if ($tipo_contactos == "Proveedor" ||$tipo_contactos == "Proveedor Nuevo" ||
        $tipo_contactos == "Agencia" ||$tipo_contactos == "Prospecto Nuevo") {

          $EstadoCuenta = estado_cuenta::where('visible','SI')->where('datos_vin',$vin)->where('datos_estatus','Pendiente')
          ->where(function ($query) {
            $query->where('concepto', 'Venta Permuta' )
            ->orWhere('concepto', 'Venta Directa' );
          })->get();

          if (sizeof($EstadoCuenta) == 0) {
            $Mensaje.= "libre_pro*libre_pro";
          }else{
            $Contacto = contactos::where('idcontacto', $idcontacto)->get();
            if ($Contacto->alias == "") {
              $Mensaje .= "- ".$Contacto->idcontacto." ".$Contacto->nombre." ".$Contacto->apellidos."<br>";
            }else{
              $Mensaje .="- ".$Contacto->idcontacto." ".$Contacto->nombre." ".$Contacto->apellidos." - ".$Contacto->alias."<br>";
            }

            $OrdenCompraU = orden_compra_unidades_excepcion::where('visible', 'SI')->where('vin', $vin)->first();
            if (!$OrdenCompraU) {
              $Mensaje .= "*no_libre";
            }else if($OrdenCompraU->estatus == "Pendiente"){
              $Mensaje .=  "*libre_comper";
            }else {
              $Mensaje .= "*no_libre";
            }
          }
        }else if ($tipo_contactos == "Contacto") {

          $EstadoCuenta = estado_cuenta::where('visible', 'SI')
          ->where('datos_vin', $vin)
          ->where('datos_estatus', 'Pendiente')
          ->where('idcontacto', '<>' , $idcontactos)
          ->where(function ($query) {
            $query->where('concepto' , 'Venta Permuta' )
            ->orWhere('concepto', 'Venta Directa' );
          })->get();

          if (sizeof($EstadoCuenta) >= 1) {

            $Contacto = contactos::where('idcontacto', $idcontacto)->get();
            if ($Contacto->alias == "") {
              $Mensaje .= "- ".$Contacto->idcontacto." ".$Contacto->nombre." ".$Contacto->apellidos."<br>";
            }else{
              $Mensaje .="- ".$Contacto->idcontacto." ".$Contacto->nombre." ".$Contacto->apellidos." - ".$Contacto->alias."<br>";
            }

            $OrdenCompraU = orden_compra_unidades_excepcion::where('visible', 'SI')->where('vin', $vin)->first();
            if (!$OrdenCompraU) {
              $Mensaje .= "*no_libre";
            }else if($OrdenCompraU->estatus == "Pendiente"){
              $Mensaje .=  "*libre_comper";
            }else {
              $Mensaje .= "*no_libre";
            }

          }else{
            $EstadoCuenta = estado_cuenta::where('visible', 'SI')
            ->where('datos_vin', $vin)
            ->where('datos_estatus', 'Pendiente')
            ->where('idcontacto' , $idcontactos)
            ->where(function ($query) {
              $query->where('concepto' , 'Venta Permuta' )
              ->orWhere('concepto', 'Venta Directa' );
            })->get();

            if (sizeof($EstadoCuenta) == 0) {
              $Mensaje .=  "libre_acu_deu*libre_acu_deu";
            }else{
              $Contacto = contactos::where('idcontacto', $idcontacto)->get();
              if ($Contacto->alias == "") {
                $Mensaje .= "- ".$Contacto->idcontacto." ".$Contacto->nombre." ".$Contacto->apellidos."<br>";
              }else{
                $Mensaje .="- ".$Contacto->idcontacto." ".$Contacto->nombre." ".$Contacto->apellidos." - ".$Contacto->alias."<br>";
              }
            }

          }
        }

        return $Mensaje;
      }


      public function BuscarVIN(){

        $Busqueda = '%'.request()->valorBusqueda.'%';

        $Inventario = inventario::select(
          DB::raw('"Unidad" as tipo'),
          'idinventario','marca','version','color','modelo','vin_numero_serie','precio_digital','fecha_apertura')
          ->where('estatus_unidad', '<>' , 'Vendido')
          ->where('visible','SI')
          ->where(function ($query) use ($Busqueda) {
            $query->where('vin_numero_serie', 'like' , $Busqueda )
            ->orWhere('marca', 'like' , $Busqueda )
            ->orWhere('version', 'like' , $Busqueda )
            ->orWhere('color', 'like' , $Busqueda )
            ->orWhere('modelo', 'like' , $Busqueda );
          })->unionAll(
            $Inventario = inventario_trucks::select(
              DB::raw('"Trucks" as tipo'),
              'idinventario_trucks','marca','version','color','modelo','vin_numero_serie','precio_digital','fecha_apertura')
              ->where('estatus_unidad', '<>' , 'Vendido')
              ->where('visible','SI')
              ->where(function ($query) use ($Busqueda) {
                $query->where('vin_numero_serie', 'like' , $Busqueda )
                ->orWhere('marca', 'like' , $Busqueda )
                ->orWhere('version', 'like' , $Busqueda )
                ->orWhere('color', 'like' , $Busqueda )
                ->orWhere('modelo', 'like' , $Busqueda );
              }))->orderBy('fecha_apertura','DESC')->get();


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
                      }
                    }
                  }else{
                    $Unidad->pasa_compra_permuta = 'NO';
                  }

                }
                $ordenados = $Inventario->sortByDesc('pasa_compra_permuta');
                return $ordenados->values()->all();
              }else{
                return json_encode([]);
              }
            }


            public function BuscarImagen(){
              $publicacion_vin_fotos = publicacion_vin_fotos::where('vin',request()->vin)->where('tipo','Principal')->first();

              if($publicacion_vin_fotos){
                $x = $publicacion_vin_fotos->ruta_foto;
                $img_route = str_replace(array('../..'),array(''),$x );
                return json_encode("https://www.panamotorscenter.com/Des/CCP".$img_route);
              }
              return json_encode("");
            }

            public function BuscarFechaApartado(){

              $idcontacto_venta = request()->idContacto;
              $vin_venta = request()->vin;
              $fecha_venta = request()->fecha;
              $EstadoC = estado_cuenta::where('idcontacto', $idcontacto_venta)->where('visible', 'SI')->where('concepto', 'Apartado')
              ->where('datos_vin', $vin_venta)->where('fecha_movimiento', $fecha_venta)->count();

              if ($EstadoC == 0) {
                return json_encode('SI');
              }else{
                return json_encode('NO');
              }
            }

            public function VistaPagares($id){
              $VistaPrevia = vista_previa_movimiento_exitoso::where('id', $id)->first();
              $Pagares = vpme_pagares::select('monto','fecha_vencimiento')->where('id_vista_previa_movimiento_exitoso',$id)->where('visible', 'SI')->get();

              return view('VPMovimientoExitoso.pagares',compact('id','VistaPrevia','Pagares'));
            }

            public function GuardarPagares(){


              DB::beginTransaction();
              try {

                $Pagares = [];
                date_default_timezone_set('America/Mexico_City');
                $fecha_actual = date("Y-m-d H:i:s");

                if(request()->NumeroPagares > 0){

                  vpme_pagares::where('id_vista_previa_movimiento_exitoso',request()->idVistaPrevia)->update([
                    'visible' => 'NO'
                  ]);

                  for ($i=0; $i < request()->NumeroPagares ; $i++) {

                    if (request('TipoPagare_'.$i)!= "Virtual") {

                      $file = request()->file('Evidencia_'.$i);

                      if ($file != "" || $file != null) {
                        $nombrePagare = $file->getClientOriginalName();
                        $extension = pathinfo($nombrePagare, PATHINFO_EXTENSION);
                        $nombrePagare = "P".$ins_EdoCta->idcontacto."_".(date('Y-m-d'))."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
                        $archivo_original = 'storage/app/Pagares_Limpios/'.$nombrePagare;
                        Storage::disk('local')->put('/Pagares_Limpios/'.$nombrePagare,  \File::get($file));
                      }else{
                        $archivo_original = 'N/A';
                      }
                      $tipoPagare = 'Físico';
                    }else{
                      $tipoPagare = 'Virtual';
                      $archivo_original = 'N/A';
                    }


                    $Pagares[$i] = vpme_pagares::createVPMEPagares(
                      request()->idVistaPrevia,
                      ($i+1).'/'.request()->NumeroPagares,
                      request('CantidadPagare_'.$i),
                      request('FechaPagare_'.$i),
                      $estatus = 'Pendiente',
                      $tipoPagare,
                      $archivo_original,
                      request('ComentariosPagare_'.$i),
                      $fecha_actual,
                      $visible = 'SI'
                    );

                  }
                }

                DB::commit();
                return redirect()->route('vpMovimientoExitoso.edit_Movement',Crypt::encrypt(request()->idVistaPrevia))->with('success','Pagares Generados');
              } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
                return back()->with('error','Error intente de nuevo')->withInput();
              }

            }


          }
