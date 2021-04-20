<?php
namespace App\Http\Controllers\Caja_Chica;

use App\Http\Controllers\GlobalFunctionsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\account_status;
use App\Models\usuarios;
use App\Models\perfiles;
use App\Models\proveedores;
use App\Models\auxiliares;
use App\Models\contactos;
use App\Models\estado_cuenta_requisicion;
use App\Models\auxiliar_principales;
use App\Models\catalogo_departamento;
use App\Models\catalago_conceptos_estado_cuenta_requisicion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf; #Php 7.0
class ResumenAbonosEstadoController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}


	public function inicio($idecr,$aux)
	{

		return view('Caja_Chica.resumen_abonos_estado_cuenta_requisicion',compact('idecr','aux'));
	}

	public function agregar_abono_especifico($idecr,$aux)
	{
		// return $idecr;
		dd($idecr,$aux);
		return view('Caja_Chica.agregar_requisicion_abono',compact('idecr','aux'));
	}


}
