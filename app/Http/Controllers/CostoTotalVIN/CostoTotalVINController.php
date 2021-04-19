<?php

namespace App\Http\Controllers\CostoTotalVIN;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\estado_cuenta_proveedores;
use App\Models\estado_cuenta;
use App\Models\inventario_cortes_trucks;
use App\Models\autenticacion_pdf_costo_total;

/*
use App\Models\inventario_dinamico;
use App\Models\publicacion_vin_fotos;
use App\Models\orden_compra_unidades;
use App\Models\check_list_expediente_original;
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CostoTotalVINController extends Controller{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){
    return view('CostoTotalVIN.index');
  }

  public function searh(){
    DB::beginTransaction();
    try {
      $vin = request()->vin;
      $Inventario = inventario::select('vin_numero_serie', 'marca', 'modelo', 'version', 'color', 'fecha_apertura')
      ->where('visible', 'SI')->where('idinventario', '<>',0)->where(function ($query) use ($vin){
        $query->where('vin_numero_serie', 'like' , '%'.$vin.'%' )
        ->orWhere('marca', 'like' , '%'.$vin.'%' )
        ->orWhere('version', 'like' , '%'.$vin.'%' )
        ->orWhere('modelo', 'like' , '%'.$vin.'%' )
        ->orWhere('color', 'like' , '%'.$vin.'%' );
      })->unionAll(inventario_trucks::select('vin_numero_serie', 'marca', 'modelo', 'version', 'color', 'fecha_apertura')
      ->where('visible', 'SI')->where(function ($query) use ($vin){
        $query->where('vin_numero_serie', 'like' , '%'.$vin.'%' )
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
      return $e->getMessage();
    }
  }


  public function CostoTotal($vin){

    $Id_Empleado = \Auth::user()->idempleados;

    $Resultado =  estado_cuenta_proveedores::select(
      'estado_cuenta_proveedores.fecha_movimiento','estado_cuenta_proveedores.datos_vin',
      'estado_cuenta_proveedores.datos_marca','estado_cuenta_proveedores.datos_modelo',
      'estado_cuenta_proveedores.datos_version','estado_cuenta_proveedores.datos_color',
      DB::raw(' "Compras" as departamento'),
      'estado_cuenta_proveedores.concepto',
      DB::raw('CONCAT(estado_cuenta_proveedores.col1 , "(",  estado_cuenta_proveedores.col2 ,")" ) as folio'),
      'estado_cuenta_proveedores.referencia',
      DB::raw('CONCAT("IDP",estado_cuenta_proveedores.idcontacto," ",proveedores.nombre," ",proveedores.apellidos) as proveedor'),
      'estado_cuenta_proveedores.monto_precio'
      )->join('proveedores','estado_cuenta_proveedores.idcontacto','=','proveedores.idproveedores')
      ->where('estado_cuenta_proveedores.visible', 'SI')
      ->where('estado_cuenta_proveedores.datos_vin', $vin)
      ->where(function ($query) {
        $query->where('estado_cuenta_proveedores.concepto', 'Compra Directa' )
        ->orWhere('estado_cuenta_proveedores.concepto', 'Compra Permuta' )
        ->orWhere('estado_cuenta_proveedores.concepto', 'Cuenta de Deuda' )
        ->orWhere('estado_cuenta_proveedores.concepto', 'Consignacion' );
      })->unionAll(estado_cuenta::select(
        'estado_cuenta.fecha_movimiento','estado_cuenta.datos_vin',
        'estado_cuenta.datos_marca','estado_cuenta.datos_modelo',
        'estado_cuenta.datos_version','estado_cuenta.datos_color',
        DB::raw(' "Ventas" as departamento'),
        'estado_cuenta.concepto',
        DB::raw(' "S/F" as folio'),
        'estado_cuenta.referencia',
        DB::raw('CONCAT("ID",estado_cuenta.idcontacto," ",contactos.nombre," ",contactos.apellidos) as proveedor'),
        'estado_cuenta.monto_precio'
        )->join('contactos','estado_cuenta.idcontacto','=','contactos.idcontacto')
        ->where('estado_cuenta.visible', 'SI')
        ->where('estado_cuenta.datos_vin', $vin)
        ->where(function ($query) {
          $query->where('estado_cuenta.concepto', 'Compra Directa' )
          ->orWhere('estado_cuenta.concepto', 'Compra Permuta' )
          ->orWhere('estado_cuenta.concepto', 'Cuenta de Deuda' )
          ->orWhere('estado_cuenta.concepto', 'Consignacion' )
          ->orWhere('estado_cuenta.concepto', 'Venta Directa' )
          ->orWhere('estado_cuenta.concepto', 'Venta Permuta' );
        }))->orderBy('fecha_movimiento','DESC')->get();

        foreach ($Resultado as $key_A => $R) {

          $Inventario_B = inventario::where('vin_numero_serie', $vin)->get();
          if (sizeof($Inventario_B) == 0) {
            $Inventario_T = inventario_trucks::where('vin_numero_serie', $vin)->get();
            if (sizeof($Inventario_T) == 0) {
              $InventarioCortesTrucks = inventario_cortes_trucks::where('vin_numero_serie', $vin)->get();
              if (sizeof($InventarioCortesTrucks) == 0) {
                $R->tipo_inventario = "Desconocido";
              }else{
                $R->tipo_inventario = "Tractocamion Cortes";
              }
            }else{
              $R->tipo_inventario = "Tractocamion";
            }
          }else{
            $R->tipo_inventario = "Unidad";
          }

          if($R->concepto=="Compra Directa" ||$R->concepto=="Compra Permuta" ||
          $R->concepto=="Cuenta de Deuda" ||$R->concepto=="Consignacion" ||$R->concepto=="Devolucion del VIN"){

            if ($R->tipo_inventario == "Tractocamion") {
              if ($Id_Empleado == 88 || $Id_Empleado == 91 || $Id_Empleado == 257 || $Id_Empleado == 258 || $Id_Empleado == 259) {
                $R->link = route('CostoTotalVIN.pdfV2',[$vin,\Carbon\Carbon::parse($R->fecha_movimiento)->format('d-m-Y'),'']);
              }else{
                $R->link = route('CostoTotalVIN.pdf',[$vin,\Carbon\Carbon::parse($R->fecha_movimiento)->format('d-m-Y'),'']);
              }
            }else{
              $R->link = route('CostoTotalVIN.pdf',[$vin,\Carbon\Carbon::parse($R->fecha_movimiento)->format('d-m-Y'),'']);
            }
          }
        }
        
        $usuario_creador = \Request::cookie('usuario_creador');

        return view('CostoTotalVIN.costo_total',compact('Resultado','Id_Empleado','usuario_creador'));
      }

      public function ValidatePassword(){
        $Autentificaion_PDF =  autenticacion_pdf_costo_total::where('idusuario', request()->password_access)
        ->where('contrasenia_apertura', request()->usuario_view)
        ->where('visible', 'SI')->get();

        if (sizeof($Autentificaion_PDF) == 1) {
          return json_encode('SI');
        }
        return json_encode('NO');
      }

    }
