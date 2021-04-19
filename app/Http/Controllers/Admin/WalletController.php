<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\contactos;
use App\Models\inventario;
use App\Models\proveedores;
use App\Models\estado_cuenta_proveedores;
use App\Models\asesores;
use App\Models\clientes_tipos;
use App\Models\credito_tipos;
use App\Models\catalogo_departamento;
use App\Models\catalogo_segmentacion_proveedores;
use App\Models\proveedores_cambios;
use App\Models\usuarios;
use App\Models\segmentacion;



class WalletController extends Controller
{

    public function __construct(){
      $this->middleware('auth');
    }

    public function template(){
      return view('prueba');
    }
    public function index(){
      // $idcliente = base64_decode(request("idcn"));
      // $idcliente = 4000;
      // $vin = base64_decode(request("v"));
      // $fecha_creacion = base64_decode(request("f"));
      //
      // $contacto = contactos::where('idcontacto',$idcliente)->get()->first();
      //
      // $inventario= inventario::where('vin_numero_serie',$vin)->get()->first();
      //
      // if($inventario->count()==0){
      //     $inventario_trucks= inventario_trucks::where('vin_numero_serie',$vin)->get();
      // }

      $proveedores = proveedores::where('visible','SI')->where('col10','8')->orderBy('idproveedores','ASC')->get();

      return view('admin.wallet.index',compact('proveedores'));
    }


    public function showProvider($id){

      $idc=$id;

      $n1=strlen($idc);
      $n1_aux=6-$n1;
      $mat="";

      for ($i=0; $i <$n1_aux ; $i++) {
      	$mat.="0";
      }

      $id_contacto_completo=$mat.$idc;
      $proveedor=proveedores::where('idproveedores',$idc)->get()->first();

      if(!empty($proveedor)){
        if(!empty($proveedor->asesor) && $proveedor->asesor != "N/A"){
           $asesor=asesores::where('idasesores',$proveedor->asesor)->get()->first();
           $nom_asesor=$asesor->nomeclatura - $asesor21->nombre;

        }

         if($proveedor->tipo_cliente != 'N/A'){
           $clientes_tipos=clientes_tipos::where('idclientes_tipos',$proveedor->tipo_cliente)->get()->first();
           $nom_cliente=$clientes_tipos->nomeclatura - $clientes_tipos->nombre;
         }

         if(!empty($proveedor->tipo_credito) && $proveedor->tipo_credito != "N/A"){
           $credito_tipos=credito_tipos::where('idcredito_tipos',$proveedor->tipo_credito)->get()->first();
           $nom_credito=$credito_tipos->nombre;
         }

         $catalogo_segmentacion_proveedores = "";
         if($proveedor->col9 != ""){
           try {
             $catalogo_segmentacion_proveedores=catalogo_segmentacion_proveedores::where('idcatalogo_segmentacion_proveedores',$proveedor->col9)->get()->first();
             $segmentacion=$catalogo_segmentacion_proveedores->nombre;
           } catch (\Exception $e) {
             $catalogo_segmentacion_proveedores=segmentacion::where('idsegmentacion',$proveedor->col9)->get()->first();
             $segmentacion=$catalogo_segmentacion_proveedores->nombre;
           }
         }
         try {
            $catalogo_departamento=catalogo_departamento::where('idcatalogo_departamento',$proveedor->col10)->get()->first();
            $departamento=$catalogo_departamento->nombre;
         } catch (\Exception $e) {
            $departamento = new catalogo_departamento;
            $departamento->nombre='';

         }
         // $saldo_anterior=0;
         // $ultimo_abono=0;
         // $fecha_ultimo_abono="N/A";
         // $result1=estado_cuenta_proveedores::where('idcontacto',$idc)->where('visible','SI')->get();//Crear tabla estado_cuenta_proveedores  revisar variable $idc ***************************************
         // if(count($result1)==0){
         //   $saldo_anterior=0;
         //   $ultimo_abono=0;
         //   $fecha_ultimo_abono="N/A";
         // }else{
         //   foreach ($result1 as $key => $fila1) {
         //     if ($fila1->tipo_movimiento == "abono") {
         //       if ($fila1->efecto_movimiento == "resta") {
         //         $saldo_anterior = $saldo_anterior-$fila1->abono;//resta
         //       }
         //       if ($fila1->efecto_movimiento == "suma") {
         //         $saldo_anterior = $saldo_anterior+$fila1->abono;//resta
         //       }
         //     }
         //     if ($fila1->tipo_movimiento == "cargo") {
         //       if ($fila1->efecto_movimiento == "resta") {
         //         $saldo_anterior = $saldo_anterior-$fila1->cargo;//resta
         //       }
         //       if ($fila1->efecto_movimiento == "suma") {
         //         $saldo_anterior = $saldo_anterior+$fila1->cargo;//resta
         //       }
         //     }
         //     if ($fila1->concepto=="Abono" && $fila1->tipo_movimiento=="abono" && $fila1->efecto_movimiento=="resta") {
         //       $ultimo_abono=$fila1->monto_precio;
         //       $fecha_ultimo_abono=$fila1->fecha_movimiento;
         //     }
         //   }
         // }
         // $saldo_anterior=$this->calcular_saldo_general($idc);

         $result5=proveedores_cambios::where('idproveedores',$idc)->get()->take(15);
         $proveedores_cambios = collect([]);
         foreach ( $result5 as $fila5) {
            $row = ['descripcion' =>'', 'usuario'=>'', 'fecha'=>''];
            if(!empty($fila5->descripcion_cambio))$row['descripcion'] = $fila5->descripcion_cambio;
            if(!empty($fila5->fecha))$row['fecha'] =$fila5->fecha;
            $result21=usuarios::where('idusuario',$fila5->usuario)->get();
            if(!empty(!$result21)){
               foreach($result21 as $fila21) {
                  $row['usuario'] = $fila21->nombre_usuario;
               }
            }
            $proveedores_cambios->push($row);
         }
         // dd($proveedores_cambios);
      }else return redirect()->back()->with('error','Estado de cuenta no disponible');










      return view('admin.wallet.show_provider', compact('proveedor','idc','id_contacto_completo','catalogo_departamento','catalogo_segmentacion_proveedores','saldo_anterior','ultimo_abono','fecha_ultimo_abono','proveedores_cambios','usuario'));
    }

    public function calcular_saldo_general($id_contacto){
    	// $sql2="SELECT monto_precio,concepto FROM estado_cuenta_proveedores WHERE idcontacto='$id_contacto' AND visible='SI' ORDER BY fecha_movimiento ASC";
    	$estado_cuenta_proveedores=estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->orderBy('fecha_movimiento','ASC')->get();
    	$saldo=0;
      foreach ($estado_cuenta_proveedores as $key => $value) {
        $concepto=$value->concepto;
    		if($concepto=="Compra Directa"||$concepto=="Compra Permuta"||$concepto=="Cuenta de Deuda"||$concepto=="Consignacion"||$concepto=="Devolucion del VIN"||$concepto=="Devolución del VIN"||$concepto=="Legalizacion"||$concepto=="Comision de Compra"||$concepto=="Traslado"||$concepto=="Otros Cargos"||$concepto=="Devolución Monetaria"){
    			$saldo+=$value->monto_precio;
    		}
    		else{
    			$saldo-=$value->monto_precio;
    		}
      }
    	return $saldo;
    }



}
