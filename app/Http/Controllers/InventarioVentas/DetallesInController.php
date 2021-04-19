<?php

namespace App\Http\Controllers\InventarioVentas;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventario;
use App\Models\publicacion_vin_fotos;
use App\Models\orden_compra_unidades;
use App\Models\orden_compra_unidades_dinamico;
use App\Models\tipos_especificaciones_vin;
use App\Models\inventario_dinamico;
use App\Models\estado_cuenta;
use App\Models\estado_cuenta_proveedores;
use App\Models\check_list_expediente_original;
use App\Models\check_list_expediente_original_ordenamiento;
use App\Models\check_list_expediente_original_ordenado;
use App\Models\check_list_expediente_original_datos;
use App\Models\cheklist_expediente_original_tools;
use App\Models\inventario_trucks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DetallesInController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function details($vin){

    //DB::beginTransaction();
    try {

      $vin = Crypt::decrypt($vin);
      $TipoUnidadTruck = false;

      $Vehiculo = inventario::where('vin_numero_serie',$vin)->first();
      if(!$Vehiculo){
        $Vehiculo = inventario_trucks::where('vin_numero_serie',$vin)->first();
        $TipoUnidadTruck = true;
      }

      $Publicacion = publicacion_vin_fotos::select('ruta_foto')->where('vin', $vin)->where('visible', 'SI')->get();

      $OrdenC = orden_compra_unidades::where('visible', 'SI')->where('vin', $vin)->orderBy('fecha_guardado')->limit(1)->first();

      $OrdenCDinamicoFacturable = [];
      $OrdenCDinamicoTipoFac = [];
      if ($OrdenC) {
        $OrdenCDinamicoFacturable = orden_compra_unidades_dinamico::select('contenido')->where('columna', 'facturable')->where('visible', 'SI')
        ->where('idorden_compra_unidades', $OrdenC->idorden_compra_unidades)->first();

        $OrdenCDinamicoTipoFac = orden_compra_unidades_dinamico::select('contenido')->where('columna', 'tipo_facturable')->where('visible', 'SI')
        ->where('idorden_compra_unidades', $OrdenC->idorden_compra_unidades)->first();
      }

      $TiEspeci = tipos_especificaciones_vin::where('visible', 'SI')->orderBy('idtipos_especificaciones_vin')->first();//asc

      if ($TipoUnidadTruck) {

        $InvDinamico_B = inventario_dinamico::select('columna','contenido')->where('visible', 'SI')->where('tipo_unidad', 'Trucks')->where('idinventario', $Vehiculo->idinventario_trucks)
        ->where(function ($query) {
          $query->where('columna' , 'motor')
          ->orWhere('columna' , 'eje delantero')
          ->orWhere('columna' , 'eje trasero')
          ->orWhere('columna' , 'rodado')
          ->orWhere('columna' , 'potencia')
          ->orWhere('columna' , 'velocidades')
          ->orWhere('columna' , 'camarote')
          ->orWhere('columna' , 'tipo_tracto');
        })->get();

      }else{

        $InvDinamico = inventario_dinamico::join('inventario_d_tipos_especificaciones','inventario_dinamico.idinventario_dinamico','=','inventario_d_tipos_especificaciones.idinventario_dinamico')
        ->where('inventario_dinamico.idinventario', $Vehiculo->idinventario)->where('inventario_dinamico.visible', 'SI')
        ->where('inventario_d_tipos_especificaciones.visible', 'SI')
        ->where('inventario_d_tipos_especificaciones.idtipos_especificaciones_vin', $TiEspeci->idtipos_especificaciones_vin)->get();

        $InvDinamico_B = [];
        if (sizeof($InvDinamico)>0) {
          /*tipos_sub_especificaciones_vin::where('visible', 'SI')->where('idtipos_especificaciones_vin', $TiEspeci->idtipos_especificaciones_vin)
          ->orderBy('idtipos_sub_especificaciones_vin','ASC')->get();*/

          $InvDinamico_B = inventario_dinamico::select('columna','contenido')->join('inventario_d_tipos_especificaciones','inventario_dinamico.idinventario_dinamico',
          '=','inventario_d_tipos_especificaciones.idinventario_dinamico')
          ->where('inventario_dinamico.idinventario', $Vehiculo->idinventario)
          ->where('inventario_dinamico.visible', 'SI')->where('inventario_d_tipos_especificaciones.visible', 'SI')
          ->where('inventario_d_tipos_especificaciones.idtipos_especificaciones_vin', $TiEspeci->idtipos_especificaciones_vin)
          ->where('inventario_d_tipos_especificaciones.idtipos_sub_especificaciones_vin', $idtipos_sub_especificaciones_vin)->get();
        }
      }

      $Estado = estado_cuenta::select('idcontacto','fecha_movimiento','datos_vin')->where('visible', 'SI')
      ->where('datos_vin', $Vehiculo->vin_numero_serie)->where(function ($query) {
        $query->where('concepto' , 'Compra Directa' )
        ->orWhere('concepto' , 'Compra Permuta' )
        ->orWhere('concepto' , 'Cuenta de Deuda' )
        ->orWhere('concepto' , 'Devolucion del VIN' )
        ->orWhere('concepto' , 'Consignacion' );
      })->unionAll(
        estado_cuenta_proveedores::select('idcontacto','fecha_movimiento','datos_vin')
        ->where('visible', 'SI')->where('datos_vin', $Vehiculo->vin_numero_serie)
        ->where(function ($query) {
          $query->where('concepto' , 'Compra Directa' )
          ->orWhere('concepto' , 'Compra Permuta' )
          ->orWhere('concepto' , 'Cuenta de Deuda' )
          ->orWhere('concepto' , 'Devolucion del VIN' )
          ->orWhere('concepto' , 'Consignacion' );
        })
        )->orderBy('fecha_movimiento','ASC')->limit(1)->first();

        if ($Estado) {

          $vin = $this->vin_corto($Estado->datos_vin);
          $idcontacto = $Estado->idcontacto;


          $OrdenCU = orden_compra_unidades::select('idorden_compra_unidades')->where('vin',$vin)->where('visible', 'SI')->get();

          $tabla = '';
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

              foreach ($ListExpedienteOrdenado as $key_List => $Expediente) {
                $ListExpedienteOriginal = check_list_expediente_original::select('columna_2')->where('visible', 'SI')->where('idcheck_list_expediente_original', $Expediente->idcheck_list_expediente_original)->where('tipo_check_list', 'Ingreso')->first();

                $columna_2= $ListExpedienteOriginal->columna_2;
                if ($columna_2 == "Original") {
                  $documen = "<td><i class=\"fa\" style=\"font-size: 2em; color:green; font-style: normal;\">&#xf00c;</i></td><td></td>";
                }else if ($columna_2 == "Copia") {
                  $documen = "<td></td><td><i class=\"fa\" style=\"font-size: 2em; color:green; font-style: normal;\">&#xf00c;</i></td>";
                }else if ($columna_2 == "Original-Copia") {
                  $documen = "<td><i class=\"fa\" style=\"font-size: 2em; color:green; font-style: normal;\">&#xf00c;</i></td><td><i class=\"fa\" style=\"font-size: 2em; color:green; font-style: normal;\">&#xf00c;</i></td>";
                }else{
                  $documen = "<td><i class=\"fa\" style=\"font-size: 2em; color:orange; font-style: normal;\">&#xf071;</i></td><td><i class=\"fa\" style=\"font-size: 2em; color:orange; font-style: normal;\">&#xf071;</i></td>";
                }
                $ListExpedienteOrigDatos = check_list_expediente_original_datos::where('idcheck_list_expediente_original', $Expediente->idcheck_list_expediente_original)->where('visible', 'SI')->first();

                $datos_complementarios ="";
                if ($ListExpedienteOrigDatos) {
                  $datos_complementarios = "<span style='font-size:10px;'>Origen: <b>$ListExpedienteOrigDatos->origen</b> <br>
                  Destino: <b>$ListExpedienteOrigDatos->destino</b></span> <br>";
                }

                $tabla .= "
                <tr>
                <td>$Expediente->tipo<br>$datos_complementarios </td> $documen
                </tr>";
              }

            }
          }else{//Si no hya Orden de Compra Unidades
            $tam_tabla = 0;
          }
        }//Si hay Estado


        //DB::commit();
        return view('InventarioVentas.product-detail',compact('Vehiculo','Publicacion','OrdenC','TiEspeci',
        'OrdenCDinamicoFacturable','OrdenCDinamicoTipoFac','InvDinamico_B','tabla','tam_tabla','TipoUnidadTruck'
      ));

    } catch (\Exception $e) {
      return $e;
      //DB::rollback();
      return back()->with('error','Ocurrio un error')->withInput();
    }
  }

  public function vin_corto($vin_completo){
    $tamano_vin = strlen($vin_completo)-8;
    if(strlen($vin_completo)>8){
      $vin_cortos=substr($vin_completo, strlen($vin_completo)-$tamaño_vin);
    }else{
      $vin_cortos = $vin_completo;
    }

    return $vin_cortos;
  }


}
