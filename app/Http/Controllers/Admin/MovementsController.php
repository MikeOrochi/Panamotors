<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\orden_logistica_inventario;
use App\Models\abonos_pagares_proveedores;
use App\Models\estado_cuenta_proveedores;
use App\Models\beneficiarios_proveedores;
use App\Models\catalogo_metodos_pago;
use App\Models\catalogo_comprobantes;
use App\Models\catalogo_tesorerias;
use App\Models\catalogo_cobranza;
use App\Models\inventario_trucks;
use App\Models\bancos_emisores;
use App\Models\estado_cuenta;
use App\Models\saldo_compras;
use App\Models\proveedores;
use App\Models\inventario;
use App\Models\contactos;

class MovementsController extends Controller{

  public function __construct(){
    $this->middleware('auth');
  }

  public function BuscarMarca(){
    $Busqueda = inventario::select('marca')->where('marca', 'like' , '%'.request()->marca.'%' )->groupBy('marca')->limit(5)->get();
    if(sizeof($Busqueda) == 0){
      return json_encode(null);
    }
    return json_encode($Busqueda);
  }

  public function BuscarModelo(){

    $Busqueda = inventario::select('modelo')
    ->where('modelo', 'like' , '%'.request()->modelo.'%' )
    ->where('marca', 'like' , '%'.request()->marca.'%' )
    ->groupBy('modelo')->limit(5)->get();
    if(sizeof($Busqueda) == 0){
      return json_encode(null);
    }
    return json_encode($Busqueda);
  }

  public function BuscarColor(){
    $Busqueda = inventario::select('color')->where('color', 'like' , '%'.request()->color.'%' )->groupBy('color')->limit(5)->get();
    if(sizeof($Busqueda) == 0){
      return json_encode(null);
    }
    return json_encode($Busqueda);
  }

  public function BuscarVersion(){
    $Busqueda = inventario::select('version')
    ->where('version', 'like' , '%'.request()->version.'%' )
    ->where('marca', 'like' , '%'.request()->marca.'%' )
    ->groupBy('version')->limit(5)->get();
    if(sizeof($Busqueda) == 0){
      return json_encode(null);
    }
    return json_encode($Busqueda);
  }

  public function GastosFinacieros($idconta,$vin){

    $Proveedor = proveedores::where('idproveedores', $idconta)->first();
    $Contacto = contactos::where('nombre', $Proveedor->nombre)->where('apellidos', $Proveedor->apellidos)->first();
    if(!$Contacto){
      $idclienteContacto = "N/A";
    }else{
      $idclienteContacto = $Contacto->idcontacto;
    }

    $nombre_completo = $Proveedor->nombre.' '.$Proveedor->apellidos;

    $iniciales_cliente="";
    $porciones = explode(" ", $nombre_completo);
    foreach ($porciones as $parte) {
      $iniciales_cliente.=substr($parte,0,1);
    }

    $saldo_anterior = $this->calcular_saldo_general($idconta);

    $catalogo_cobranza = catalogo_cobranza::select('nomeclatura', 'nombre')->where('idcatalogo_cobranza', '3')
    ->orWhere('idcatalogo_cobranza','22')->orWhere('idcatalogo_cobranza','14')
    ->orWhere('idcatalogo_cobranza','18')->orWhere('idcatalogo_cobranza','7')->get();
    $MetodosPago = catalogo_metodos_pago::select('nomeclatura', 'nombre')->get()->whereIn('nomeclatura', [1,3]);
    $CatalogoComprobante = catalogo_comprobantes::select('nombre')->get();
    $CatalogoTesorerias = catalogo_tesorerias::select('nombre','nomeclatura')->get();
    $BancosEmisores = bancos_emisores::select('nombre')->get();


    return view('admin.wallet.gastosFinanciamiento',compact('nombre_completo','iniciales_cliente','catalogo_cobranza','Proveedor','saldo_anterior','idconta','MetodosPago','CatalogoComprobante','CatalogoTesorerias','BancosEmisores','idclienteContacto'));
  }

  public function show($idconta,$fecha_inicio){

    DB::beginTransaction();
    try {

      //$idconta=base64_decode('NTY');
      $fecha_inicio= Crypt::decrypt($fecha_inicio);

      $Proveedor = proveedores::where('idproveedores', $idconta)->first();
      $Contacto = contactos::where('nombre', $Proveedor->nombre)->where('apellidos', $Proveedor->apellidos)->first();
      if(!$Contacto){
        $idclienteContacto = "N/A";
      }else{
        $idclienteContacto = $Contacto->idcontacto;
      }

      $nombre_completo = $Proveedor->nombre.' '.$Proveedor->apellidos;

      $iniciales_cliente="";
      $porciones = explode(" ", $nombre_completo);
      foreach ($porciones as $parte) {
        $iniciales_cliente.=substr($parte,0,1);
      }

      $iniciales_cliente=mb_strtoupper($iniciales_cliente);



      $saldo_anterior = $this->calcular_saldo_general($idconta);



      $catalogo_cobranza = catalogo_cobranza::select('nomeclatura', 'nombre')->where('idcatalogo_cobranza', '3')
      ->orWhere('idcatalogo_cobranza','22')->orWhere('idcatalogo_cobranza','14')
      ->orWhere('idcatalogo_cobranza','18')->orWhere('idcatalogo_cobranza','7')->get();

      $MetodosPago = catalogo_metodos_pago::select('nomeclatura', 'nombre')->get()->whereIn('nomeclatura', [1,3]);
      $BancosEmisores = bancos_emisores::select('nombre')->get();
      $CatalogoTesorerias = catalogo_tesorerias::select('nombre','nomeclatura')->get();
      $BeneficiariosProv = beneficiarios_proveedores::select('nombre')->where('idproveedor', $idconta)->get();
      $CatalogoComprobante = catalogo_comprobantes::select('nombre')->get();



      $compras_pendientes = estado_cuenta_proveedores::where('datos_estatus', 'Pendiente')->where('visible', 'SI')
      ->whereIn('concepto', ['Compra Directa','Cuenta de Deuda'])
      ->where('idcontacto', $Proveedor->idproveedores)->orderBy('idestado_cuenta_proveedores','desc')->get(['idestado_cuenta_proveedores','idcontacto','datos_marca','datos_version','referencia','datos_vin','datos_precio']);
      $saldo_compras_abono = saldo_compras::where('idproveedores', $idconta)->where('concepto', 'Abono')->where('visible', 'SI')->sum('cantidad');
      $saldo_compras_cargo = saldo_compras::where('idproveedores', $idconta)->where('concepto', 'Cargo')->where('visible', 'SI')->sum('cantidad');
      $saldo_compras = $saldo_compras_abono - $saldo_compras_cargo;
      // dd($saldo_compras);

      DB::commit();

      return view('admin.wallet.compras_entrada',compact(
        'catalogo_cobranza',
        'Contacto',
        'MetodosPago',
        'saldo_anterior',
        'BancosEmisores',
        'idconta',
        'iniciales_cliente',
        'idclienteContacto',
        'CatalogoTesorerias',
        'BeneficiariosProv',
        'CatalogoComprobante',
        'nombre_completo',
        'compras_pendientes',
        'Proveedor',
        'saldo_compras'
      ));
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
      return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
    }
  }


  public function calcular_saldo_general($id_contacto){

    $Estado_CuentaP = estado_cuenta_proveedores::select('monto_precio','concepto')->where('idcontacto', $id_contacto)->where('visible', 'SI')->orderBy('fecha_movimiento', 'ASC')->get();
    $Saldo = 0;
    foreach ($Estado_CuentaP as $key => $ECP) {

      if ($ECP->concepto=="Compra Directa"     || $ECP->concepto=="Compra Permuta"      || $ECP->concepto=="Cargo no asignado"||
      $ECP->concepto=="Cuenta de Deuda"    || $ECP->concepto=="Consignacion"        ||
      $ECP->concepto=="Devolucion del VIN" || $ECP->concepto=="Devolución del VIN"  ||
      $ECP->concepto=="Legalizacion"       || $ECP->concepto=="Comision de Compra"  ||
      $ECP->concepto=="Traslado"           || $ECP->concepto=="Otros Cargos"        || $ECP->concepto=="Devolución Monetaria") {
        $Saldo+= number_format($ECP->monto_precio, 2, '.', '');
      }elseif ($ECP->concepto=="Otros Cargos-C") {
        $Saldo+= number_format($ECP->monto_precio, 2, '.', '');
      }else {
        $Saldo-= number_format($ECP->monto_precio, 2, '.', '');
      }
    }
    return number_format($Saldo, 2, '.', '');
    return $Saldo;
  }

  public function BusquedaVIN(){


    DB::beginTransaction();
    try {
      $vin = request()->valorBusqueda;

      $Inventario = inventario::select(
        DB::raw('"Unidad" as tipo'),
        'idinventario','marca','version','color','modelo','vin_numero_serie','precio_piso','precio_digital','fecha_apertura'
        )
      ->where('visible', 'SI')->where('idinventario', '<>',0)->where(function ($query) use ($vin){
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

  public function BusquedaVIN_Apartado(){
    $Texto = '%'.request()->valorBusqueda.'%';

    $Inventario = inventario::select('idinventario','marca','version','color','modelo','vin_numero_serie')
    ->where('vin_numero_serie', 'like' , $Texto )
    ->orWhere('marca', 'like' , $Texto )
    ->orWhere('version', 'like' , $Texto )
    ->orWhere('color', 'like' , $Texto )
    ->orWhere('modelo', 'like' , $Texto )->limit(5)->get();


    if(sizeof($Inventario) == 0){

      $Inventario = inventario_trucks::select('idinventario_trucks','marca','version','color','modelo','vin_numero_serie')
      ->where('vin_numero_serie', 'like' , $Texto )
      ->orWhere('marca', 'like' , $Texto )
      ->orWhere('version', 'like' , $Texto )
      ->orWhere('color', 'like' , $Texto )
      ->orWhere('modelo', 'like' , $Texto )->limit(5)->get();

      if(sizeof($Inventario) == 0){
        return json_encode(null);
      }else{
        return $Inventario;
      }

    }else{
      return $Inventario;
    }
  }

  public function BusquedaVinBloqueado(){

    $EstadoCp = estado_cuenta_proveedores::where('datos_vin', request()->valorBusqueda)->where('visible', 'SI')->first();
    if($EstadoCp){
      return json_encode('NO');
    }else{
      //return json_encode('SI');
      if(request()->idCliente=="N/A"){//El proveedor no es un cliente
        return json_encode($this->validarEdoGral(request()->valorBusqueda,request()->idCliente));
      }else{//El proveedor es un cliente
        return json_encode($this->validarEdoCliente(request()->valorBusqueda,request()->idCliente));
      }
    }
  }

  public function BuscarReferencia(){

    try {

      $Estado_Cuenta_P = estado_cuenta_proveedores::where('referencia', "".request()->ref."")->where('visible', 'SI')->where('referencia', '<>','S/N')->get();

      if(sizeof($Estado_Cuenta_P) == 0 ){

        if (strlen(request()->ref) < 6) {
          return json_encode('Longitud');
        }

        return json_encode('SI');
      }else{

        $Muliples_Cargos_o_Abonos = false;

        foreach ($Estado_Cuenta_P as $key => $ECP) {//Validamos si ya esta ocupado por su contrario

          if (request()->tipo_mov == "abono") {
            if($ECP->tipo_movimiento == "cargo" || $ECP->tipo_movimiento == "Cargo"){
              return json_encode('Cargo');//Esa referencia ya esta ocupada por un cargo - no puede haber un abono con esa ref
            }else if($ECP->tipo_movimiento == "abono" || $ECP->tipo_movimiento == "Abono"){
              $Muliples_Cargos_o_Abonos = true;
            }
          }else if (request()->tipo_mov == "cargo") { //cargo
            if($ECP->tipo_movimiento == "abono" || $ECP->tipo_movimiento == "Abono"){
              return json_encode('Abono');//Esa referencia ya esta ocupada por un abono - no puede haber un cargo con esa ref
            }else if($ECP->tipo_movimiento == "cargo" || $ECP->tipo_movimiento == "Cargo"){
              $Muliples_Cargos_o_Abonos = true;
            }
          }else{
            return json_encode('Tipo de movimiento invalido');
          }

        }

        foreach ($Estado_Cuenta_P as $key => $ECP) {

          if(request()->ref != $ECP->referencia){
            return json_encode('La referencia no coincide');
          }
          if(request()->ins_receptora != $ECP->receptora_institucion){
            return json_encode('La Institucion Receptora no coincide ('.request()->ins_receptora .' - '. $ECP->receptora_institucion.')');
          }
          if(request()->ag_receptor != $ECP->receptora_agente){
            return json_encode('La Agencia Receptora no coincide ('.request()->ag_receptor .' - '. $ECP->receptora_agente.')');
          }
          if(request()->ins_e != $ECP->emisora_institucion){
            return json_encode('La Institución Emisora no coincide ('.request()->ins_e .' - '. $ECP->emisora_institucion.')');
          }
          if(request()->ag_emisora != $ECP->emisora_agente){
            return json_encode('La Agencia Emisora no coincide ('.request()->ag_emisora .' - '. $ECP->emisora_agente.')');
          }
          if(request()->ic != $ECP->idcontacto){
            return json_encode('El Contacto no coincide');
          }


          return json_encode('La referencia no esta disponible');
          /*$Suma_ECP = estado_cuenta_proveedores::where('referencia', $ECP->referencia)->where('idcontacto', $ECP->idcontacto)->where('visible', 'SI')->sum('monto_precio');

          if ( ($Suma_ECP + request()->cantidad) <= request()->m_g ) {
            if ($Muliples_Cargos_o_Abonos) {
              return json_encode('Multiple');
            }
            return json_encode('SI');
          }else{
            return json_encode('La suma supera el monto total');
          }*/


        }
      }
    } catch (\Exception $e) {
      return json_encode($e->getMessage());
    }
  }

  public function BuscarReferenciaVenta(){

    try {

      if (request()->tabla == "ECP") {
        $Referencia = estado_cuenta_proveedores::where('referencia', "".request()->ref."")->where('visible', 'SI')->where('referencia', '<>','S/N')->get();
      }else if (request()->tabla == "APP") {
        $Referencia = abonos_pagares_proveedores::where('referencia', "".request()->ref."")->where('visible', 'SI')->where('referencia', '<>','S/N')->get();
      }else{
        return json_encode('El tipo de tabla '.request()->tabla.' no esta disponible en este metodo');
      }


      if(sizeof($Referencia) == 0 ){

        return json_encode('SI');

      }else if(request()->tabla == "ECP"){
        $Validacion = true;
        foreach ($Referencia as $key => $ECP) {
          if($ECP->tipo_movimiento == "abono" || $ECP->tipo_movimiento == "Abono"){
            return json_encode('Abono');
          }else if($ECP->tipo_movimiento == "cargo" || $ECP->tipo_movimiento == "Cargo"){
            $Validacion = false;
          }
        }
        if (!$Validacion) {//No hay abonos pero si cargos
          return json_encode('Cargo');
        }else{
          return json_encode('SI');
        }
      }else{
        return json_encode('NO');
      }
    } catch (\Exception $e) {
      return json_encode($e->getMessage());
    }
  }


  //*********************************************************************************************
  public function validarEdoGral($vin,$cliente){//funcion para validar si el VIN se encuentra en el estado de cuenta general
    if($cliente=="N/A"){//Si el proveedor no es un cliente
      $Estado_de_Cuenta = estado_cuenta::select('datos_estatus')->where('datos_vin', $vin)->where('visible', 'SI')->where('datos_estatus', 'Pendiente')->get();
    }else{//El proveedor es un cliente
      $Estado_de_Cuenta = estado_cuenta::select('datos_estatus')->where('datos_vin', $vin)->where('visible', 'SI')->where('datos_estatus', 'Pendiente')->where('idcontacto','!=',$cliente)->get();
    }//end else; El proveedor es un cliente

    if(sizeof($Estado_de_Cuenta)==0){//El VIN no aparece en el estado de cuenta general
      return $this->validarInventario($vin);
    }//end if; //El VIN no aparece en el estado de cuenta general
    else{//El VIN aparece en el estado de cuenta general
      return 3;
    }//end else; El VIN aparece en el estado de cuenta general
  }//end function validarEdoGral
  //*********************************************************************************************

  //*****************************************************************************************************************************************************************************************
  public function validarEdoCliente($vin,$cliente){//funcion para validar si el vin proporcionado aparece en el estado de cuenta del cliente

    $status_cliente= $this->consultarEdoCliente($vin,$cliente);
    $validacion= $this->validarEdoGral($vin,$cliente);
    if($status_cliente==0){//El VIN no aparece en el estado de cuenta del cliente
      return $validacion;
    }//en if; El VIN no aparece en el estado de cuenta del cliente
    else if($status_cliente=="Pendiente"){//El VIN aparece en el estado de cuenta del cliente como Pendiente
      if($validacion==0){//El VIN esta Pendiente con el cliente y no aparece en nada mas
        return 4;
      }//end if; El VIN esta Pendiente con el cliente y no aparece en nada mas
      else{//El VIN aparece en alguna otra validacion
        return $validacion;
      }//end else; El VIN aparece en alguna otra validacion
    }//end ese if; El VIN aparece en el estado de cuenta del cliente como Pendiente
    else{//El VIN aparece en el estado de cuenta del cliente como Pagado/Apartado
      if($validacion==0){//El VIN esta Pagado con el cliente y no aparece en nada mas
        return 5;
      }//end if; El VIN esta Pagado con el cliente y no aparece en nada mas
      else{//El VIN aparece en alguna otra validacion
        return $validacion;
      }//end else; El VIN aparece en alguna otra validacion
    }//El VIN aparece en el estado de cuenta del cliente como Pagado/Apartado
  }//end function validarEdoCliente
  //*****************************************************************************************************************************************************************************************

  //*****************************************************************************************************************************************************************************************
  function consultarEdoCliente($vin,$cliente){//funcion para consultar si el vin proporcionado aparece en el estado de cuenta del cliente

    $Estado_de_Cuenta = estado_cuenta::select('datos_estatus')->where('datos_vin', $vin)->where('visible', 'SI')->where('idcontacto', $cliente)->get();

    if(sizeof($Estado_de_Cuenta)==0){//El VIN no aparece en el estado de cuenta del cliente
      return 0;
    }//end if; El VIN no aparece en el estado de cuenta del cliente
    else{//El VIN aparece en el estado de cuenta del cliente
      return $Estado_de_Cuenta->datos_estatus;
    }//end else; El VIN aparece en el estado de cuenta del cliente
  }//end function validarEdoCliente
  //*****************************************************************************************************************************************************************************************

  //*****************************************************************************************************************************************************************************************
  function validarInventario($vin){//funcion para validar si el VIN proporcionado se encuentra en el inventario de unidades
    $Inventario = inventario::where('vin_numero_serie', $vin)->where('visible', 'SI')->where('estatus_unidad', '!=', 'Vendido')->get();
    if(sizeof($Inventario)==0){//El VIN no aparece en el inventario de unidades
      return $this->validarInventarioTrucks($vin);
    }//end if; El VIN no aparece en el inventario de unidades
    else{//El VIN aparece en el inventario de unidades
      return 2;//retornar estatus de launidad en el inventario
    }//end else; El VIN aparece en el inventario de unidades
  }//end function validarInventario
  //*****************************************************************************************************************************************************************************************

  //*****************************************************************************************************************************************************************************************
  function validarInventarioTrucks($vin){//funcion para validar si el VIN proporcionado se encuentra en el inventario de trucks
    $Inventario_Trucks = inventario_trucks::where('vin_numero_serie', $vin)->where('visible', 'SI')->where('estatus_unidad', '!=', 'Vendido')->get();
    if(sizeof($Inventario_Trucks)==0){//El VIN no aparece en el inventario de trucks
      return $this->validarOrdenLogistica($vin);
    }//end if; El VIN no aparece en el inventario de trucks
    else{//El VIN aparece en el inventario
      return 2;
    }//en else; El VIN aparece en el inventario
  }//end function validarInventarioTrucks
  //*****************************************************************************************************************************************************************************************

  //*****************************************************************************************************************************************************************************************
  function validarOrdenLogistica($vin){//funcion para validar si ya existe una orden de logistica por este VIN
    $Or_Logistica = orden_logistica_inventario::where('vin', $vin)->where('visible', 'SI')->get();

    if(sizeof($Or_Logistica)==0){//El VIN no aparece en las ordens de logistica
      return 0;
    }//end if; El VIN no aparece en las ordens de logistica
    else{//El VIN aparece en las ordenes de logistica
      return 1;
    }//El VIN aparece en las ordenes de logistica
  }//end function validarOrdenLogistica
  //*****************************************************************************************************************************************************************************************
  public function saldoOtrosCargos($id_conta){
    $provider = proveedores::where('idproveedores', $id_conta)->get(['idproveedores','nombre','apellidos','col2'])->last();
    $compras_pendientes = estado_cuenta_proveedores::where('datos_estatus', 'Pendiente')->where('visible', 'SI')->where('concepto', 'Compra Directa')->where('idcontacto', $provider->idproveedores)->orderBy('idestado_cuenta_proveedores','desc')
    ->get(['idestado_cuenta_proveedores','idcontacto','datos_marca','datos_version','referencia','datos_vin','datos_precio']);
    $otros_cargos_c = estado_cuenta_proveedores::where('concepto', 'Otros Cargos-C')->where('visible', 'SI')->where('idcontacto', $provider->idproveedores)->sum('cargo');
    $otros_cargos_a = estado_cuenta_proveedores::where('concepto', 'Otros Cargos-A')->where('visible', 'SI')->where('idcontacto', $provider->idproveedores)->sum('abono');
    $saldo_otros_cargos = $otros_cargos_c - $otros_cargos_a;
    if ($provider->col2 == 'MXN') { $tipo_cambio = 1; }else
    if ($provider->col2 == 'USD') { $tipo_cambio = 19.5; }else
    if ($provider->col2 == 'CAD') { $tipo_cambio = 15.5; }
    else {$tipo_cambio = 1;}
    foreach ($compras_pendientes as $compra_pendiente) {
      $compra_pendiente->saldos = SaveMovementController::getSaldoStatic($compra_pendiente->idestado_cuenta_proveedores);
      // return $compra_pendiente;
    }
    // return $provider->col2;
    // dd($otros_cargos_c,$otros_cargos_a);
    // return $provider;
    return view('admin.wallet.saldo_otros_cargos',compact(
      'provider','compras_pendientes', 'saldo_otros_cargos','tipo_cambio'
    ));
  }
}
