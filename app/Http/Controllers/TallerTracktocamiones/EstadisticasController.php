<?php

namespace App\Http\Controllers\TallerTracktocamiones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventario_trucks;
use App\Models\inventario;
use App\Models\empleados;
use App\Models\SolicitudTallerTrucks;

class EstadisticasController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function index(){

    return view('TallerTracktocamiones.stadistics.index');
  }
  public function store(Request $request){
    // return request();
    try {
      $inventario_trucks = inventario_trucks::where('vin_numero_serie', $request->vin_venta)->get(['idinventario_trucks','vin_numero_serie'])->last();
      // return $inventario_trucks;
      return SolicitudTallerTrucks::createSolicitudTallerTrucks($inventario_trucks->idinventario_trucks, $request->description, $request->stetic_range,
      $request->description_stetic, $request->description_other, $request->petrol_range, $request->comments, $request->date_entry, $request->date_estimated, $request->employee,
      'taller', '100923', $request->date_start, \Carbon\Carbon::now());
      return $inventario_trucks;
    } catch (\Exception $e) {
      return $e->getMessage();
    }

  }
  public function BusquedaVIN(){

    $Busqueda = '%'.request()->valorBusqueda.'%';

    $Inventario = inventario_trucks::select('idinventario_trucks','marca','version','color','modelo','vin_numero_serie')->where(function ($query)  {
      $query->where('visible','SI');
    })->where(function ($query) use ($Busqueda) {
      $query->where('vin_numero_serie', 'like' , $Busqueda )
      ->orWhere('marca', 'like' , $Busqueda )
      ->orWhere('version', 'like' , $Busqueda )
      ->orWhere('color', 'like' , $Busqueda )
      ->orWhere('modelo', 'like' , $Busqueda );
    })->limit(5)->get();


    if(sizeof($Inventario) == 0){
        return json_encode(null);
    }else{
      return $Inventario;
    }
  }
}
