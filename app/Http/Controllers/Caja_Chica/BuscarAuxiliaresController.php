<?php

namespace App\Http\Controllers\Caja_Chica;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\account_status;
use App\Models\usuarios;
use App\Models\empleados;
use App\Models\perfiles;
use App\Models\proveedores;
use App\Models\auxiliares;
use App\Models\estado_cuenta_requisicion;
use App\Models\auxiliar_principales;
use App\Models\catalogo_departamento;
use App\Models\catalago_conceptos_estado_cuenta_requisicion;
use App\Models\abonos_estado_cuenta_requisicion;
use App\Models\empleados_pass_auxliares_pagos;
use App\Models\empleados_pass_auxiliares_cambios;
use App\Models\atencion_clientes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
class BuscarAuxiliaresController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}


	public function index(){
		return view('Caja_Chica.auxiliares');
	}

	public function movimiento_balance($aux){
		$departamentos = catalago_conceptos_estado_cuenta_requisicion::where('visible','SI')->groupby('departamento')->get('departamento');
		$empleados =empleados::where('visible','SI')->where('idempleados','>','1')->get();
		$auxiliares = auxiliares::where('visible','SI')->groupby('nombre')->get('nombre');
		return view('Caja_Chica.agregar_cargo_auxiliar_secundario',compact('aux','departamentos','empleados','auxiliares'));
	}



	public function detalle_auxiliar($aux){
		$datos = Crypt::decrypt($aux);
		$auxiliares = auxiliares::join('estado_cuenta_requisicion','estado_cuenta_requisicion.idestado_cuenta_requisicion','=','auxiliares.idestado_cuenta_requisicion')
		->
		select("estado_cuenta_requisicion.idestado_cuenta_requisicion","estado_cuenta_requisicion.concepto","estado_cuenta_requisicion.referencia","estado_cuenta_requisicion.comentarios","estado_cuenta_requisicion.monto_precio","estado_cuenta_requisicion.tipo_movimiento","estado_cuenta_requisicion.fecha_guardado","estado_cuenta_requisicion.fecha_movimiento","estado_cuenta_requisicion.datos_estatus","estado_cuenta_requisicion.emisora_institucion","estado_cuenta_requisicion.emisora_agente","estado_cuenta_requisicion.receptora_institucion","estado_cuenta_requisicion.receptora_agente","estado_cuenta_requisicion.usuario_creador")->where('estado_cuenta_requisicion.visible','SI')->where('auxiliares.visible','SI')->where('auxiliares.nombre',$datos)
		->orderBy('estado_cuenta_requisicion.fecha_movimiento', 'desc')
		->orderBy('estado_cuenta_requisicion.fecha_guardado', 'desc')
		->get();
		foreach ($auxiliares as $auxiliar) {
			$date = date_create($auxiliar->fecha_movimiento);
			$auxiliar ->fecha_mov_for   =date_format($date,"d-m-Y");
			$auxiliar ->monto_precio_formato   =number_format($auxiliar->monto_precio,2);
			$empleados =empleados::join('usuarios','usuarios.idempleados','=','empleados.idempleados')
			->select('empleados.nombre','empleados.apellido_paterno','empleados.apellido_materno')
			->where('usuarios.idusuario',$auxiliar ->usuario_creador)
			->get();
			foreach ($empleados as $empleado) {
				$auxiliar ->usuario_creador_mov = $empleado->nombre." ".$empleado->apellido_paterno." ".$empleado->apellido_materno;
			}

			$abonos_estado_cuenta_requisicion = abonos_estado_cuenta_requisicion::select('cantidad_pago')
			->where('visible','SI')
			->where('idestado_cuenta_requisicion_movimineto',$auxiliar ->idestado_cuenta_requisicion_movimineto)
			->sum('cantidad_pago');
			if (Empty($abonos_estado_cuenta_requisicion)) {
				if ($auxiliar->tipo_movimiento == "abono") {
					$auxiliar->monto_pendiente = "N/A";
				}else{
					$auxiliar->monto_pendiente = "$".number_format($auxiliar->monto_precio,2);
					$auxiliar->monto_abono = "$".number_format(0,2);
				}
			}else{
				$auxiliar->monto_pendiente = "$".number_format($auxiliar->monto_precio-$abonos_estado_cuenta_requisicion->cantidad_pago,2);
				$auxiliar->monto_abono = "$".number_format($abonos_estado_cuenta_requisicion->cantidad_pago,2);
			}
			$atencion_clientes=atencion_clientes::where('visible','SI')
			->where('idatencion_clientes',(INT)$auxiliar->referencia)
			->first();
			$empleados_pass_auxliares_pagos = empleados_pass_auxliares_pagos::where('visible','SI')
			->where('referencia',$auxiliar->referencia)
			->where('estatus','Pendiente')->first();
			if (Empty($atencion_clientes)) {
				$auxiliar->at="NO";
				$auxiliar->estatus_orden="NO";
				if (\Auth::user()->idempleados == 88 || \Auth::user()->idempleados == 78 || \Auth::user()->idempleados == 91) {
					$auxiliar->estatus_password_modal="Admin";
				}else{
					if (Empty($empleados_pass_auxliares_pagos)) {
						$auxiliar->estatus_password_modal="NO";
					}else{
						$auxiliar->estatus_password_modal="SI";
					}
				}

			}else{
				$auxiliar->at="SI";
				$auxiliar->estatus_orden=$atencion_clientes->estatus;
				$auxiliar->id_orden_at=$atencion_clientes->idatencion_clientes;
				if (\Auth::user()->idempleados == 88 || \Auth::user()->idempleados == 78 || \Auth::user()->idempleados == 91) {
					$auxiliar->estatus_password_modal="Admin";
				}else{
					if (Empty($empleados_pass_auxliares_pagos)) {
						if ($atencion_clientes->estatus == "Cancelado") {
							$auxiliar->estatus_password_modal="NO";
						}else if ($atencion_clientes->estatus == "Resuelto") {
							$auxiliar->estatus_password_modal="SI";
						}else{
							$auxiliar->estatus_password_modal="NO";
						}
					}else{
						if ($atencion_clientes->estatus == "Cancelado") {
							$auxiliar->estatus_password_modal="NO";
						}else if ($atencion_clientes->estatus == "Resuelto") {
							$auxiliar->estatus_password_modal="SI";
						}else{
							$auxiliar->estatus_password_modal="SI";
						}
					}
				}
			}
			// ///////////////Atnecion
		}

		return view('Caja_Chica.detalle_auxiliares',compact('aux','auxiliares'));
	}

	public function find_acceso_pago(){
		DB::beginTransaction();
		try {
			$idestado = request()->id;
			$usuario_creador = \Request::cookie('usuario_creador');
			$estado_cuenta_requisicion = estado_cuenta_requisicion::where('visible','SI')
			->where('idestado_cuenta_requisicion',$idestado)->first();
			if (Empty($estado_cuenta_requisicion)) {
				$estado_cuenta_requisicion->estatus_acceso = "denegado";
			}else{
				// DB::connection()->enableQueryLog();
				$empleados_pass_auxliares_pagos = empleados_pass_auxliares_pagos::where('visible','SI')
				->where('idempleados',\Auth::user()->idempleados)
				->where('referencia',	$estado_cuenta_requisicion->referencia)
				->where('estatus','Pendiente')
				->where('password',request()->password)->first();
				// return DB::getQueryLog();
				if (Empty($empleados_pass_auxliares_pagos)) {
					$estado_cuenta_requisicion->estatus_acceso = "denegado";
				}else{
					$empleados_pass_auxliares_pagos = empleados_pass_auxliares_pagos::updateAccesPassEmployedPay($empleados_pass_auxliares_pagos->idempleados_pass_auxliares_pagos);
					$estado_cuenta_requisicion->estatus_acceso = "Entra";
				}
				$fecha_guardado= date("Y-m-d H:i:s");
				$empleados_pass_auxiliares_cambios = empleados_pass_auxiliares_cambios::createEmpleadosPassAuxliaresPagosCambios(\Auth::user()->idempleados,request()->password,$estado_cuenta_requisicion->estatus_acceso,'','Pago de auxiliares contabilidad',$estado_cuenta_requisicion->referencia,$idestado,$usuario_creador,'SI',$fecha_guardado,$fecha_guardado,request()->ruta);
			}
			DB::commit();
			return  $estado_cuenta_requisicion;
		} catch (\Exception $e) {
			DB::rollback();
			return json_encode($e->getMessage());
		}

	}

	public function interno_pdf($aux_request){
		return view('Caja_Chica.PDF.interno',compact('aux_request'));
	}

	public function externo_pdf($aux_request){
		return view('Caja_Chica.PDF.externo',compact('aux_request'));
	}

	public function balance_logistica_pdf($aux_request){
		return view('Caja_Chica.PDF.balance_logistica',compact('aux_request'));
	}

	public function filtrado_pdf($aux_request){
		return view('Caja_Chica.PDF.filtrado',compact('aux_request'));
	}

	public function detalle_recebos_auxliar($aux_request){
		return view('Caja_Chica.PDF.detalle_recebos_auxliar',compact('aux_request'));
	}

	public function referencias_coincidencias($aux_request){
		return view('Caja_Chica.referencias_coincidencias',compact('aux_request'));
	}

	public function registrar_auxiliar($aux_request){
		return view('Caja_Chica.registrar_auxiliar',compact('aux_request'));
	}


	public function buscar_auxiliares(){
		DB::beginTransaction();
		try{
			$auxiliares = auxiliares::select('nombre')->where('visible','SI')->where('nombre','like','%'.request()->auxiliar.'%')->groupby('nombre')->get();
			foreach ($auxiliares as $auxiliar) {
				$auxiliar->nombre_encriptado = Crypt::encrypt($auxiliar->nombre);
				$montos_cargo = auxiliares::join('estado_cuenta_requisicion','estado_cuenta_requisicion.idestado_cuenta_requisicion','=','auxiliares.idestado_cuenta_requisicion')->where('estado_cuenta_requisicion.visible','SI')->where('auxiliares.visible','SI')->where('auxiliares.nombre',$auxiliar->nombre)->where('estado_cuenta_requisicion.tipo_movimiento','cargo')->sum('estado_cuenta_requisicion.cargo');
				$auxiliar->montos_cargo = number_format($montos_cargo,2);
				$montos_abono = auxiliares::join('estado_cuenta_requisicion','estado_cuenta_requisicion.idestado_cuenta_requisicion','=','auxiliares.idestado_cuenta_requisicion')->where('estado_cuenta_requisicion.visible','SI')->where('auxiliares.visible','SI')->where('auxiliares.nombre',$auxiliar->nombre)->where('estado_cuenta_requisicion.tipo_movimiento','abono')->sum('estado_cuenta_requisicion.abono');
				$auxiliar->montos_abono = number_format($montos_abono,2);
				$auxiliar->saldo =number_format($montos_cargo-$montos_abono,2);

				$validar_encabezados =auxiliar_principales::select('concepto','tipo_auxliar','balance','id','beneficiario')->where('visible','SI')->where('concepto',$auxiliar->nombre)->get();
				if ($validar_encabezados->isEmpty()) {
					$auxiliar->encabezados ="NO";
					$auxiliar->idname =	"";
					$auxiliar->balance =	"";
					$auxiliar->tipo_auxliar =	"";
					$auxiliar->beneficiario =	"";
				}else{
					$auxiliar->encabezados ="SI";
					foreach ($validar_encabezados as $key) {
						$auxiliar->idname =	$key['id'];
						$auxiliar->balance =	$key->balance;
						$auxiliar->tipo_auxliar =	$key->tipo_auxliar;
						$auxiliar->beneficiario =	$key->beneficiario;
					}

				}
			}
			DB::commit();
			return $auxiliares;
		}catch(\Exception $e){
			DB::rollback();
			return json_encode($e->getMessage());
		}
	}
}
