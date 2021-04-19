<?php

namespace App\Http\Controllers\InventarioVentas;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\inventario_dinamico;
use App\Models\publicacion_vin_fotos;
use App\Models\orden_compra_unidades;
use App\Models\check_list_expediente_original;
use App\Models\check_list_expediente_original_ordenado;
use App\Models\check_list_expediente_original_ordenamiento;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class InventarioVController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){

    $Inventario = inventario::select('marca',DB::raw('count(*) as Total'))->where(function ($query)  {
      $query->where('visible','SI');
    })->where(function ($query) {
      /*
      $query->where('estatus_unidad', '<>' , 'VENDIDO' )
      ->where('estatus_unidad', '<>' , 'Legal' )
      ->where('estatus_unidad', '<>' , 'Devolución' )
      ->where('estatus_unidad', '<>' , 'Traslados' )
      ->where('estatus_unidad', '<>' , 'Utilitaria' )
      ->where('estatus_unidad', '<>' , 'N/A' )
      ->where('estatus_unidad', '<>' , 'Devolución del VIN' )
      ->where('estatus_unidad', '<>' , 'Negociación del VIN' );*/
      $query->where('estatus_unidad', 'VIN Certificado' )
      ->orWhere('estatus_unidad', 'Puesto en venta' );
    })->where(function ($query) {
      $query->where('marca', '<>' , 'Pendiente' )
      ->where('marca', '<>' , 'Panamotors Premium, S.A. de C.V.' )
      ->where('marca', '<>' , 'Chicles' );
    })->groupBy('marca')->get();

    $InventarioTrucks = inventario_trucks::select('marca',DB::raw('count(*) as Total'))->where(function ($query)  {
      $query->where('visible','SI');
    })->where(function ($query) {
      /*
      $query->where('estatus_unidad', '<>' , 'VENDIDO' )
      ->where('estatus_unidad', '<>' , 'Legal' )
      ->where('estatus_unidad', '<>' , 'Devolución' )
      ->where('estatus_unidad', '<>' , 'Traslados' )
      ->where('estatus_unidad', '<>' , 'Utilitaria' )
      ->where('estatus_unidad', '<>' , 'N/A' )
      ->where('estatus_unidad', '<>' , 'Devolución del VIN' )
      ->where('estatus_unidad', '<>' , 'Negociación del VIN' );
      */
      $query->where('estatus_unidad', 'VIN Certificado' )
      ->orWhere('estatus_unidad', 'Puesto en venta' );
    })->where(function ($query) {
      $query->where('marca', '<>' , 'Pendiente' )
      ->where('marca', '<>' , 'Panamotors Premium, S.A. de C.V.' )
      ->where('marca', '<>' , 'Chicles' )
      ->where('marca', '<>' , 'sin asignar' )
      ->where('marca', '<>' , 'mata' );
    })->groupBy('marca')->get();

    return view('InventarioVentas.index',compact('Inventario','InventarioTrucks'));
  }


  public function Inventario($marca,$trucks){


    //DB::beginTransaction();
    try {

      if ($trucks == "1") {
        $Inventario = inventario_trucks::where(function ($query)  {
          $query->where('visible','SI');
        })->where(function ($query) {
          /*
          $query->where('estatus_unidad', '<>' , 'VENDIDO' )
          ->where('estatus_unidad', '<>' , 'Legal' )
          ->where('estatus_unidad', '<>' , 'Devolución' )
          ->where('estatus_unidad', '<>','N/A')
          ->where('estatus_unidad', '<>' , 'Traslados' )
          ->where('estatus_unidad', '<>' , 'Utilitaria' )
          ->where('estatus_unidad', '<>' , 'Devolución del VIN' )
          ->where('estatus_unidad', '<>' , 'Negociación del VIN' );
          */
          $query->where('estatus_unidad', 'VIN Certificado' )
          ->orWhere('estatus_unidad', 'Puesto en venta' );
        })->where(function ($query) use ($marca){
          if($marca == 'Todas'){
            $query->where('marca', '<>' , 'Pendiente' )
            ->where('marca', '<>' , 'Panamotors Premium, S.A. de C.V.' )
            ->where('marca', '<>' , 'Chicles' );;
          }else{
            $query->where('marca', '<>' , 'Pendiente' )
            ->where('marca', '<>' , 'Panamotors Premium, S.A. de C.V.' )
            ->where('marca', '<>' , 'Chicles' )
            ->where('marca', Crypt::decrypt($marca));
          }
        })->orderBy('idinventario_trucks','ASC')->get();
      }else{
        $Inventario = inventario::where(function ($query)  {
          $query->where('visible','SI');
        })->where(function ($query) {
          /*
          $query->where('estatus_unidad', '<>' , 'VENDIDO' )
          ->where('estatus_unidad', '<>' , 'Legal' )
          ->where('estatus_unidad', '<>' , 'Devolución' )
          ->where('estatus_unidad', '<>','N/A')
          ->where('estatus_unidad', '<>' , 'Traslados' )
          ->where('estatus_unidad', '<>' , 'Utilitaria' )
          ->where('estatus_unidad', '<>' , 'Devolución del VIN' )
          ->where('estatus_unidad', '<>' , 'Negociación del VIN' );
          */
          $query->where('estatus_unidad', 'VIN Certificado' )
          ->orWhere('estatus_unidad', 'Puesto en venta' );
        })->where(function ($query) use ($marca){
          if($marca == 'Todas'){
            $query->where('marca', '<>' , 'Pendiente' )
            ->where('marca', '<>' , 'Panamotors Premium, S.A. de C.V.' )
            ->where('marca', '<>' , 'Chicles' );
          }else{
            $query->where('marca', '<>' , 'Pendiente' )
            ->where('marca', '<>' , 'Panamotors Premium, S.A. de C.V.' )
            ->where('marca', '<>' , 'Chicles' )
            ->where('marca', Crypt::decrypt($marca));
          }
        })->orderBy('idinventario','ASC')->get();
      }



      $LastUpdate = $Inventario->last()->fecha_guardado;

      date_default_timezone_set('America/Mexico_City');
      $fecha_act = date("Y-m-d H:i:s");
      $date2 = new \DateTime($fecha_act);

      $Modelos = [];
      $Estatus_unidad = [];
      $Marcas = [];
      $Kilometraje = [];
      $suma_pis = 0;
      $suma_digi = 0;

      foreach ($Inventario as $key => $Vehiculo) {

        $Modelos[$key] = $Vehiculo->modelo;
        $Estatus_unidad[$key] = $Vehiculo->estatus_unidad;
        $Marcas[$key] = $Vehiculo->marca;
        $Kilometraje[$key] = number_format($Vehiculo->kilometraje,2);
        $suma_pis = round($Vehiculo->precio_piso + $suma_pis,2);
        $suma_digi = round($Vehiculo->precio_digital + $suma_pis,2);

        $Publicacion = publicacion_vin_fotos::where('visible', 'SI')
        ->where('vin', $Vehiculo->vin_numero_serie )
        ->where('tipo', 'Principal' )->get();

        if (sizeof($Publicacion) > 0) {
          $Vehiculo->se = "<a href='' target='_blank'><div class='tagverde'>Sesión</div></a>";
          $Vehiculo->pdf_detalle = "<a href='".route('Inv_Ventas.pdf',[Crypt::encrypt($Vehiculo->idinventario),Crypt::encrypt($Vehiculo->vin_numero_serie)])."' target='_blank'><i class='far fa-file-pdf fa-3x'></i></a>";
        }else{
          $Vehiculo->se = "<div class='tagrojo'>Sin Sesión</div>";
          $Vehiculo->pdf_detalle = "N/A";
        }


        $Orden = orden_compra_unidades::select('idorden_compra_unidades')->where('vin', $Vehiculo->vin_numero_serie)->where('visible', 'SI')->first();
        if ($Orden) {
          $ListaExO = check_list_expediente_original::select('tipo')->where('visible', 'SI')
          ->where('idorden_compra_unidades', $Orden->idorden_compra_unidades)
          ->where('tipo_check_list', 'Ingreso')->groupBy('tipo')->get();


          if (sizeof($ListaExO) == 0) {
            $Vehiculo->doc = "<div class='tagrojo'>Sin Expediente</div>";
            $Vehiculo->doc_p = "Sin Expediente";
          }else{
            $Vehiculo->doc = "<div class='tagverde'>Expediente</div>";
            $Vehiculo->doc_p = "Expediente";
          }


          $n_refe = 0;
          $n_fac = 0;

          foreach ($ListaExO as $keyList => $L) {

            $tipo_partes = explode(" " , $L->tipo);
            if ($tipo_partes[0] == "Refacturación") {
              $n_refe++;
            }else if ($tipo_partes[0] == "Factura") {
              $n_fac++;
            }
          }

          }else{
            $Vehiculo->doc = "<div class='tagrojo'>Sin Expediente</div>";
            $Vehiculo->doc_p = "Sin Expediente";

            $n_refe = 0;
            $n_fac = 0;
          }

          if ($n_fac > 0) {
            if ($n_refe > 0) {
              $Vehiculo->tipo_fa = "Refacturado";
              $Vehiculo->dueno = $n_refe +$n_fac;
            }else{
              $Vehiculo->tipo_fa = "Facturado";
              $Vehiculo->dueno = "1";
            }
          }else{

            if ($trucks == "1") {
              $Vehiculo->tipo_fa = "Refacturado";
              $Vehiculo->dueno = "Pendiente";
            }else{
              $Vehiculo->tipo_fa = "Pendiente";
              $Vehiculo->dueno = "Pendiente";
            }

          }


          $date1 = new \DateTime($Vehiculo->fecha_ingreso);
          $Vehiculo->dias = $this->get_format($date1->diff($date2));
          $Vehiculo->days = floor((strtotime($fecha_act) - strtotime($Vehiculo->fecha_ingreso)) / (60 * 60 * 24));
        }


        $Estatus_unidad = array_unique($Estatus_unidad);
        $Modelos = array_unique($Modelos);
        sort($Modelos);
        $Marcas = array_unique($Marcas);
        $Kilometraje = array_unique($Kilometraje);
        $Id_Empleado = \Auth::user()->idempleados;

        //DB::commit();
        return view('InventarioVentas.inventario_check',compact('LastUpdate','Inventario','Estatus_unidad','Modelos','Marcas','Id_Empleado','suma_pis','suma_digi','Kilometraje'));

      } catch (\Exception $e) {
        //DB::rollback();
        return $e;
        return back()->with('error','Lo sentimos, ha ocurrido un error')->withInput();
      }
    }


    public function get_format($df) {

      $str = '';
      $str .= ($df->invert == 1) ? ' - ' : '';
      if ($df->y > 0) {
        // years
        $str .= ($df->y > 1) ? $df->y . ' Años ' : $df->y . ' Año ';
      } if ($df->m > 0) {
        // month
        $str .= ($df->m > 1) ? $df->m . ' Meses ' : $df->m . ' Mes ';
      } if ($df->d > 0) {
        // days
        $str .= ($df->d > 1) ? $df->d . ' Dias ' : $df->d . ' dia ';
      }

      if (strlen($str) == 0) {
        $str = 'Hace un momento';
      }

      return $str;
    }


  }
