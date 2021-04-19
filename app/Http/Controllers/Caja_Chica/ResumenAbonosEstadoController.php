<?php
namespace App\Http\Controllers\Caja_Chica;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\account_status;
use Illuminate\Support\Facades\Auth;

class ResumenAbonosEstadoController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}


	public function index()
	{
		return view('Caja_Chica.resumen_abonos_estado_cuenta_requisicion',compact('idecr','aux'));
	}


}
