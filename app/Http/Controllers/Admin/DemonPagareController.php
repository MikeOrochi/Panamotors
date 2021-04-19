<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\documentos_pagar;
use App\Models\abonos_unidades_proveedores;
use App\Models\abonos_pagares_proveedores;
use App\Models\estado_cuenta_proveedores;
use App\Models\BitacoraCambiosCuadreECP;


use Illuminate\Support\Facades\Auth;

class DemonPagareController extends Controller
{

  public function PagaresSobrantes(){

    DB::beginTransaction();
    try {

      $PagaresOcultados = 0;

      $PagaresSinUso =  documentos_pagar::select('documentos_pagar.iddocumentos_pagar','estado_cuenta_proveedores.idestado_cuenta_proveedores')->leftJoin('estado_cuenta_proveedores', 'documentos_pagar.idestado_cuenta', '=', 'estado_cuenta_proveedores.idestado_cuenta_proveedores')
      ->where('documentos_pagar.estatus', 'Pendiente')
      ->where('documentos_pagar.visible', 'SI')
      ->where('estado_cuenta_proveedores.visible', 'NO')->get()->groupBy('idestado_cuenta_proveedores');

      foreach ($PagaresSinUso as $EstadoCuenta => $Pagares) {
        foreach ($Pagares as $P) {
          documentos_pagar::where('iddocumentos_pagar', $P->iddocumentos_pagar)->update([
            'visible' => 'NO'
          ]);
          BitacoraCambiosCuadreECP::createRegistroCambio('documentos_pagar','visible',$P->iddocumentos_pagar,'SI','NO','Se oculto el pagare debido a que el Estado de cuenta no era visible');
          $PagaresOcultados++;
        }
      }

      $Pagados_Con_DC_Pendientes =  estado_cuenta_proveedores::select('iddocumentos_pagar','idestado_cuenta_proveedores')
      ->leftJoin('documentos_pagar', 'idestado_cuenta', '=', 'idestado_cuenta_proveedores')
      ->where('estatus', 'Pendiente')
      ->where('estado_cuenta_proveedores.visible', 'SI')
      ->where('documentos_pagar.visible', 'SI')
      ->where('datos_estatus', 'Pagada')->get()->groupBy('idestado_cuenta_proveedores');

      foreach ($Pagados_Con_DC_Pendientes as $EstadoCuenta => $Pagares) {
        foreach ($Pagares as $P) {
          documentos_pagar::where('iddocumentos_pagar', $P->iddocumentos_pagar)->update([
            'visible' => 'NO'
          ]);
          BitacoraCambiosCuadreECP::createRegistroCambio('documentos_pagar','visible',$P->iddocumentos_pagar,'SI','NO','Se oculto el pagare debido a que el Estado de cuenta estaba Pagado');
          $PagaresOcultados++;
        }
      }

      DB::commit();
      if ($PagaresOcultados == 0) {
        dd('Sin cambios');
      }else{
        dd('Se ocultaron '.$PagaresOcultados.' Pagares');
      }
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }
  }

  public function CuadrarPapagresPagados(){

    //Cuadra los documentos por cobrar en estatus Pagado
    //con Abonos Pagares Proveedores

    DB::beginTransaction();
    try {

      $DatosActulizados = 0;

      $Estados_C = documentos_pagar::select('documentos_pagar.comentarios','documentos_pagar.monto as MontoPagare','documentos_pagar.estatus as EstatusP','abonos_pagares_proveedores.cantidad_pago as MontoAbonoPagPro',
      'abonos_pagares_proveedores.idabonos_pagares_proveedores as ID_AbonoPagProt','abonos_pagares_proveedores.tipo_moneda as Moneda',
      'documentos_pagar.idestado_cuenta','documentos_pagar.iddocumentos_pagar AS Id_Pagare','estado_cuenta_proveedores.monto_precio as MontoEDC')
      ->leftJoin('abonos_pagares_proveedores', 'documentos_pagar.iddocumentos_pagar', '=', 'abonos_pagares_proveedores.iddocumentos_pagar')
      ->leftJoin('estado_cuenta_proveedores', 'abonos_pagares_proveedores.idestado_cuenta_movimiento', '=', 'estado_cuenta_proveedores.idestado_cuenta_proveedores')
      ->where('estatus', 'Pagado')->get()->groupBy('idestado_cuenta');
      $RevisarPagares = [];

      foreach ($Estados_C as $key => $EDC) {//Recorremos cada Estado de Cuenta
        $Pagares =  $EDC->groupBy('Id_Pagare'); //los Agrupamos por pagos a pagares
        $Estados_C[$key] = $Pagares;
      }


      foreach ($Estados_C as $key_A => $EDC) {
        foreach ($EDC as $key_B => $Pagares) {
          $SumaAbonos = 0;
          foreach ($Pagares as $key_C => $Montos) {
            $SumaAbonos+= floatval($Montos->MontoAbono);
          }

          if($Pagares->first()->ID_Abono == null && $Pagares->first()->MontoEDC == null){//No tiene Abono
            $RevisarPagares['Sin_Abono_y_EDC'][$key_A] = $Estados_C[$key_A];
            $RevisarPagares['Sin_Abono_y_EDC'][$key_A]['Caso'] = '1';
          }else if ($SumaAbonos == floatval($Pagares->first()->MontoPagare)){//Los pagares coinciden con los abonos exactamente
            //No hay nada que hacer esta caudrado
          }else if(sizeof($Pagares) == 1){//Solo un pagare

            if($SumaAbonos == 0 && $Pagares->first()->ID_Abono != null){ //Si tiene Abono pero la cantidad del abono es 0
              abonos_pagares_proveedores::where('idabonos_pagares_proveedores', $Pagares->first()->ID_Abono)->update([
                'cantidad_pago' => $Pagares->first()->MontoPagare,
              ]);

              BitacoraCambiosCuadreECP::createRegistroCambio('abonos_pagares_proveedores','cantidad_pago',$Pagares->first()->ID_Abono,
              $Pagares->first()->MontoAbono,$Pagares->first()->MontoPagare,'El Pago en Abonos Pagares Proveedores en estado Pagado estava vacio pero su Documento por cobrar tenia el monto');

              $DatosActulizados++;
            }else{
              $RevisarPagares['Revicion'][$key_A] = $Estados_C[$key_A];
              $RevisarPagares['Revicion'][$key_A]['Caso'] = '2';
            }
          }else{
            $RevisarPagares['Revicion'][$key_A] = $Estados_C[$key_A];
            $RevisarPagares['Revicion'][$key_A]['Caso'] = '3 - '.$SumaAbonos.' ---- '.$Pagares->first()->MontoEDC;
          }


        }//Fin for pagares
      }//Fin for EDC

      DB::commit();
      if($DatosActulizados > 0){
        dd('Campos actualizados => '.$DatosActulizados);
      }else{
        return $RevisarPagares;
      }

    } catch (\Exception $e) {
      DB::rollback();
      return $e;
    }
  }

  public function ValidarAbonosPagaresP(){

    DB::beginTransaction();
    try {

      $UnidadesPagadas = 0;

      $EstadosCuentaP = estado_cuenta_proveedores::
      select('idestado_cuenta_proveedores','concepto','datos_estatus','monto_precio','monto_total','gran_total','emisora_institucion','emisora_agente','receptora_institucion','receptora_agente','tipo_moneda','tipo_cambio')
      ->where('visible', 'SI')
      ->where('concepto', 'Compra Directa')
      ->where('datos_estatus', '!=', 'Pagada')->where('monto_precio', '!=','1N093251')->get();

      foreach ($EstadosCuentaP as $key => $ECP) {
        $Pagares = documentos_pagar::where('idestado_cuenta', $ECP->idestado_cuenta_proveedores)->where('visible', 'SI')->get();
        $EstadosCuentaP[$key]['Pagares'] = $Pagares;

        //------------------------------------------------
        $AbonosUnidadesPro = abonos_unidades_proveedores::where('idestado_cuenta', $ECP->idestado_cuenta_proveedores)->where('visible', 'SI')->get();
        $Total_AbonosUP = 0;
        foreach ($AbonosUnidadesPro as $A_U_P) {
          if($A_U_P->tipo_moneda == 'MXN' && ($ECP->tipo_moneda == 'USD' || $ECP->tipo_moneda == 'CAD') ){
            $Total_AbonosUP+= floatval($A_U_P->cantidad_pago/$ECP->tipo_cambio);
          }else if($A_U_P->tipo_moneda == $ECP->tipo_moneda){
            $Total_AbonosUP+= floatval($A_U_P->cantidad_pago);
          }else{
            dd('Surgio algo inesperadeishon');
          }
        }
        $EstadosCuentaP[$key]['AbonosUnidadesP'] = $Total_AbonosUP;
        //------------------------------------------------


        $Total_AbonosPP  = floatval(abonos_pagares_proveedores::where('idestado_cuenta_movimiento', $ECP->idestado_cuenta_proveedores)->where('visible', 'SI')->sum('cantidad_pago'));
        $EstadosCuentaP[$key]['AbonosPagaresP']   = $Total_AbonosPP;

        if($Total_AbonosPP > 0 ){ //Cuadrar Los abonos a pagares con pagares no identificados
          $SumaPagaresPagados = 0;
          foreach ($Pagares as $pp => $p) {
            if($p->estatus == "Pagado"){
              $SumaPagaresPagados += floatval($p->monto);
            }
          }

          if($SumaPagaresPagados != $Total_AbonosPP){
            $Diferencia = abonos_pagares_proveedores::where('idestado_cuenta_movimiento', $ECP->idestado_cuenta_proveedores)->get();
            foreach ($Diferencia as $dif => $d) {
              $Diferencia[$dif]['Pagares'] = documentos_pagar::where('iddocumentos_pagar', $d->iddocumentos_pagar)->get();
            }
            $EstadosCuentaP[$key]['Diferencia'] = $Diferencia;
            return $EstadosCuentaP[$key];
          }
        }

        if( $Total_AbonosUP > 0){

          $SumaPagaresPendientes = 0;
          foreach ($Pagares as $pp => $p) {
            if($p->estatus == "Pendiente"){
              $SumaPagaresPendientes += floatval($p->monto);
            }
          }

          if ($Total_AbonosUP >= $ECP->monto_precio && sizeof($Pagares) == 0){

            estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $ECP->idestado_cuenta_proveedores)->update([
              'datos_estatus' => 'Pagada',
              'col6' => 'Pagada por el sistema los abonos registrados superan el monto '.$ECP->monto_precio.' < '.$Total_AbonosUP
            ]);

            $UnidadesPagadas++;
            BitacoraCambiosCuadreECP::createRegistroCambio('estado_cuenta_proveedores','datos_estatus',$ECP->idestado_cuenta_proveedores,'Pendiente','Pagada','Pagada por el sistema los abonos registrados >= a el monto '.$ECP->monto_precio.' , '.$Total_AbonosUP);

          }if ($Total_AbonosUP >= $ECP->monto_precio && sizeof($Pagares) > 0){
            estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $ECP->idestado_cuenta_proveedores)->update([
              'datos_estatus' => 'Pagada',
              'col6' => 'Pagada por el sistema los abonos registrados superan el monto '.$ECP->monto_precio.' < '.$Total_AbonosUP
            ]);
            $UnidadesPagadas++;
            BitacoraCambiosCuadreECP::createRegistroCambio('estado_cuenta_proveedores','datos_estatus',$ECP->idestado_cuenta_proveedores,'Pendiente','Pagada','Pagada por el sistema los abonos registrados >= a el monto '.$ECP->monto_precio.' , '.$Total_AbonosUP);
          }
        }

      }

      DB::commit();
      dd('Todo bien todo correcto :D', 'Unidades Pagadas => '.$UnidadesPagadas);
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
    }
  }

  public function createPromissoryNotes(){//Crea pagares si no tiene o hacen falta

    DB::beginTransaction();
    try {

      $PagaresGenerados = 0;
      $Faltantes = [];
      $Gen = 'Gen 1-';

      date_default_timezone_set('America/Mexico_City');
      $fecha_actual = date("Y-m-d H:i:s");

      $EstadosCuentaP = estado_cuenta_proveedores::
      select('idestado_cuenta_proveedores','concepto','datos_estatus','monto_precio','monto_total','gran_total','emisora_institucion','emisora_agente','receptora_institucion','receptora_agente','tipo_moneda','tipo_cambio')
      ->where('visible', 'SI')
      ->where('concepto', 'Compra Directa')
      ->where('datos_estatus', 'Pendiente')->where('monto_precio', '!=','1N093251')->get();


      foreach ($EstadosCuentaP as $key => $ECP) {

        $Pagares = documentos_pagar::select('documentos_pagar.iddocumentos_pagar','documentos_pagar.monto','documentos_pagar.estatus','abonos_unidades_proveedores.cantidad_pago as AbonoUP')
        ->leftJoin('abonos_pagares_proveedores', 'abonos_pagares_proveedores.iddocumentos_pagar' ,'=','documentos_pagar.iddocumentos_pagar')
        ->leftJoin('abonos_unidades_proveedores', 'abonos_unidades_proveedores.idestado_cuenta_movimiento' ,'=','abonos_pagares_proveedores.idestado_cuenta_movimiento')
        ->where('documentos_pagar.idestado_cuenta', $ECP->idestado_cuenta_proveedores)
        ->where('documentos_pagar.visible', 'SI')->get();

        $EstadosCuentaP[$key]['Pagares'] = $Pagares;

        $AbonosUnidadesPro = abonos_unidades_proveedores::select('concepto','cantidad_pago','tipo_moneda')->where('idestado_cuenta', $ECP->idestado_cuenta_proveedores)->where('visible', 'SI')->get();

        $Total_AbonosUP = 0;

        foreach ($AbonosUnidadesPro as $A_U_P) {

          if($A_U_P->tipo_moneda == 'MXN' && ($ECP->tipo_moneda == 'USD' || $ECP->tipo_moneda == 'CAD') ){
            $Total_AbonosUP+= floatval($A_U_P->cantidad_pago/$ECP->tipo_cambio);
          }else if($A_U_P->tipo_moneda == $ECP->tipo_moneda){
            $Total_AbonosUP+= floatval($A_U_P->cantidad_pago);
          }else{
            dd('Surgio un nuevo caso 1 ',$ECP,$AbonosUnidadesPro);
          }
        }

        $Total_AbonosUP = round($Total_AbonosUP,2);
        $EstadosCuentaP[$key]['AbonosUnidadesP'] = $Total_AbonosUP;


        $AbonosPagaresProve  = documentos_pagar::select('abonos_pagares_proveedores.cantidad_pago','abonos_pagares_proveedores.tipo_moneda')
        ->rightJoin('abonos_pagares_proveedores', 'documentos_pagar.iddocumentos_pagar', '=', 'abonos_pagares_proveedores.iddocumentos_pagar')
        ->where('documentos_pagar.idestado_cuenta', $ECP->idestado_cuenta_proveedores)
        ->where('documentos_pagar.estatus', 'Pagado')
        ->where('documentos_pagar.visible', 'SI')->get();

        $Total_AbonosPP = 0;
        foreach ($AbonosPagaresProve as $A_P_P) {
          if($A_P_P->tipo_moneda == 'MXN' && ($ECP->tipo_moneda == 'USD' || $ECP->tipo_moneda == 'CAD') ){
            $Total_AbonosPP+= floatval($A_P_P->cantidad_pago/$ECP->tipo_cambio);
          }else if($A_P_P->tipo_moneda == $ECP->tipo_moneda){
            $Total_AbonosPP+= floatval($A_P_P->cantidad_pago);
          }else{
            dd('Surgio un nuevo caso 2 ',$ECP,$AbonosPagaresProve);
          }
        }
        $EstadosCuentaP[$key]['AbonosPagaresP']  = $Total_AbonosPP;


        $MontoPrecioECP = floatval($ECP->monto_precio);

        //-*-
        if(sizeof($Pagares) == 0 && $Total_AbonosUP == 0 && $Total_AbonosPP == 0){ //Si no tiene Pagares y nada abonado se le asigna  un pagare con toda la deuda


          $Pagare_X = $this->CrearPagare('1-> 1/1',$MontoPrecioECP,'Pendiente',$ECP);
          $PagaresGenerados++;

        }else if( ($Total_AbonosUP ==  $MontoPrecioECP) && sizeof($Pagares) > 0 && $Total_AbonosUP > 0){
          dd('Aqui 1');
          return $EstadosCuentaP[$key];
          /*foreach ($Pagares as $B => $v) {
            if($v->estatus == 'Pendiente'){
              $v->visible = 'NO';
              $v->comentarios = $v->comentarios.'  |  (Modificado por el sistema visible a estado NO)';
              $v->save();
              BitacoraCambiosCuadreECP::createRegistroCambio('documentos_pagar','visible',$v->iddocumentos_pagar,'SI','NO','Se oculto el pagare');
            }
          }*/
        }else if(sizeof($Pagares) >= 1  && $Total_AbonosUP == 0 && $Total_AbonosPP == 0){ //-------> Si tiene pagares pero ningun Abono

          $SumaMontoPagares =  0;
          foreach ($Pagares as $B => $v) {
            $SumaMontoPagares += floatval($v->monto);
          }

          if ($SumaMontoPagares < $MontoPrecioECP) {//Se genera un nuevo pagare con la deuda restante
            $this->CrearPagare('2-> '.(sizeof($Pagares)+1).'/'.(sizeof($Pagares)+1),($MontoPrecioECP - $SumaMontoPagares),'Pendiente',$ECP);
            $PagaresGenerados++;
          }else if($SumaMontoPagares == $MontoPrecioECP){
            //Ya ha pagare creado con la cantidad exacta
          }else if ($SumaMontoPagares > $MontoPrecioECP){
            //Ya ha pagares creado con la cantidad >=
          }else{
            $EstadosCuentaP[$key]['Metodo 0'] = '*********** Suma Pagares '.$SumaMontoPagares.' != '.$MontoPrecioECP.'-----'.($MontoPrecioECP - $SumaMontoPagares);
            $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
          }
        }else if(sizeof($Pagares) >= 1 && $Total_AbonosUP != 0){ //------->Si tiene pagares y hay Abonos


          $SumaAbonos_y_Pagares =  0;
          $SumaPagaresPendiente = 0;
          foreach ($Pagares as $B => $v) {
            if ($v->estatus == 'Pendiente') {
              if($v->AbonoUP == null){//No tiene ningun abono
                $SumaPagaresPendiente += floatval($v->monto);
              }else if($v->AbonoUP != null){ //Tiene abono pero aun no ha sido pagado en su totalidad
                if(floatval($v->AbonoUP) > floatval($v->monto)){
                  dd('El monto resigtrado al que apunto es mayor');
                }else{
                  $SumaPagaresPendiente += round( (floatval($v->monto) - floatval($v->AbonoUP)), 2 );//Se suma la parte restante
                }
              }
            }else if($v->estatus == 'Pagado' && $v->AbonoUP == null){ //Hay un pagare sin su Abono Registrado
              dd('Se deberia registrar como Abono UP');
            }
          }
          $SumaAbonos_y_Pagares+= round( $Total_AbonosUP + $SumaPagaresPendiente,2);  //PagaresPendientes + AbonosUnidadesP



          if($SumaAbonos_y_Pagares == $MontoPrecioECP){
            //Ya ha pagare creado con la cantidad exacta
          }else if($SumaAbonos_y_Pagares < $MontoPrecioECP){
            $this->CrearPagare('3-> '.(sizeof($Pagares)+1).'/'.(sizeof($Pagares)+1),($MontoPrecioECP - $SumaAbonos_y_Pagares),'Pendiente',$ECP);
            $PagaresGenerados++;
          }else if($SumaAbonos_y_Pagares > $MontoPrecioECP){//Hay dinero de mas en el pagare a si que lo ajustamos


            $CantidadSobrante = round($MontoPrecioECP - $SumaAbonos_y_Pagares,2);
            if($CantidadSobrante < 0){
              $CantidadSobrante = $CantidadSobrante*-1;
            }



            if($CantidadSobrante <= $SumaPagaresPendiente){

              foreach ($Pagares as $C => $v) {
                if($v->estatus == "Pendiente" && $CantidadSobrante > 0){
                  if($v->monto > $CantidadSobrante){
                    $Resta = round($v->monto-$CantidadSobrante,2);
                    BitacoraCambiosCuadreECP::createRegistroCambio('documentos_pagar','monto',$v->iddocumentos_pagar,$v->monto,$Resta,'Se actualizo el pagare');
                    $v->comentarios = $v->comentarios.'  |  (Modificado por el sistema '.$v->monto.' -> '.$Resta.')';
                    $CantidadSobrante= round($CantidadSobrante-$v->monto,2);
                    $v->monto = $Resta;
                    $v->save();
                  }if($v->monto <= $CantidadSobrante){
                    $CantidadSobrante= round($CantidadSobrante-$v->monto,2);
                    $v->visible = 'NO';
                    BitacoraCambiosCuadreECP::createRegistroCambio('documentos_pagar','monto',$v->iddocumentos_pagar,$v->monto,'0','Se actualizo el pagare');
                    $v->comentarios = $v->comentarios.'  |  (Modificado por el sistema '.$v->monto.' -> 0)';
                    $v->monto = 0;
                    $v->save();
                  }
                }
              }

            }else{


              $EstadosCuentaP[$key]['Metodo ?'] = '';
              $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];

              /*foreach ($Pagares as $C => $v) {
                if($v->estatus == "Pendiente"){
                  $v->visible = 'NO';
                  $v->comentarios = $v->comentarios.'  |  (Modificado por el sistema a visible NO, hay Abonos sobrantes por $'.$CantidadSobrante.')';
                  $v->save();
                  BitacoraCambiosCuadreECP::createRegistroCambio('documentos_pagar','visible',$v->iddocumentos_pagar,'SI','NO','Se oculto el pagare hay Abonos sobrantes por $'.$CantidadSobrante.')');
                }
              }

              estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $ECP->idestado_cuenta_proveedores)->update([
                'datos_estatus' => 'Pagada',
                'comentarios' => $ECP->comentarios.'  |  (Modificado por el sistema estado Pendiente => Pagada debido a que se detecto la cantidad de Abonos Unidades P > Monto)'
              ]);
              BitacoraCambiosCuadreECP::createRegistroCambio('estado_cuenta_proveedores','datos_estatus',$ECP->idestado_cuenta_proveedores,'Pendiente','Pagada','Se actualizo debido a que se detecto la cantidad de Abonos Unidades P '.$CantidadSobrante.' > '.$ECP->monto_precio.' Monto');
              */
            }



          }else{
            $EstadosCuentaP[$key]['Metodo 2'] = '*********** Suma Pagares '.$SumaAbonos_y_Pagares.' != '.$MontoPrecioECP.'-> '.($MontoPrecioECP - $SumaAbonos_y_Pagares);
            $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
          }


        }else if(sizeof($Pagares) == 0){ //No tiene pagares

          //Tiene Abonos Unidades Proveedores pero no tiene Abonos Pagares Proveedores
          if($Total_AbonosUP >= 0 && $Total_AbonosPP == 0){
            if($Total_AbonosUP < $MontoPrecioECP){

              $this->CrearPagare('4-> 1/1',($MontoPrecioECP - $Total_AbonosUP),'Pendiente',$ECP);
              $PagaresGenerados++;
            }else if($Total_AbonosUP == $MontoPrecioECP){
              //Ya esta pagada solo hay que actualizar a pagada el estado de cuenta

              //DESCOMENTARRRRRRRRRRRRRRRRRRRRRRRR
              /*estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $ECP->idestado_cuenta_proveedores)->update([
                'datos_estatus' => 'Pagada',
                'comentarios' => $ECP->comentarios.'  |  (Modificado por el sistema estado Pendiente => Pagada debido a que se detecto la cantidad de Abonos Unidades P = Monto)'
              ]);
              BitacoraCambiosCuadreECP::createRegistroCambio('estado_cuenta_proveedores','datos_estatus',$ECP->idestado_cuenta_proveedores,'Pendiente','Pagada','Se actualizo debido a que se detecto la cantidad de Abonos Unidades P = Monto');
              */
            }else if($Total_AbonosUP > $MontoPrecioECP){

              $EstadosCuentaP[$key]['Deteccion de Pagado por Abonos'] = ':)';
              $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
            }else{
              $EstadosCuentaP[$key]['Metodo 3'] = '***********';
              $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
            }
          }
          //Tiene Abonos Pagares Proveedores sin tener registro en Documentos por cobrar :)
          //y sin tener registro en Abonos Unidades Proveedores
          else if($Total_AbonosPP >= 0 && $Total_AbonosUP == 0){
            if($Total_AbonosPP < $MontoPrecioECP){
              $this->CrearPagare('6-> 1/1',($MontoPrecioECP - $Total_AbonosPP),'Pendiente',$ECP);
              $PagaresGenerados++;
            }else if($Total_AbonosPP == $MontoPrecioECP){
              //Ya esta pagada solo hay que actualizar a pagada el estado de cuenta
            }else{
              $EstadosCuentaP[$key]['Metodo 4'] = '***********';
              $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
            }
          }else{
            $EstadosCuentaP[$key]['Metodo 5'] = '***********';
            $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
          }

        }else{
          $EstadosCuentaP[$key]['Metodo 6'] = '***********';
          $Faltantes[sizeof($Faltantes)] = $EstadosCuentaP[$key];
        }
      }

      //return $EstadosCuentaP;
      DB::commit();

      if(sizeof($Faltantes) != 0){
        return $Faltantes;
      }else if($PagaresGenerados != 0){
        dd('Pagares generados',$PagaresGenerados);
      }else{
        dd('Sin cambios :D');
      }


      return back()->with('success','Cita confirmada');
    } catch (\Exception $e) {
      DB::rollback();
      return $e;
      return $e->getMessage();
    }
  }

  public function CrearPagare($Serie,$Monto,$Estatus,$Estado_Cuenta){

    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date("Y-m-d H:i:s");

    $NuevoPagare = documentos_pagar::createDocumentosPagar(
      $Serie,
      $Monto,
      $Estado_Cuenta->fecha_creacion == null ? $fecha_actual:$Estado_Cuenta->fecha_creacion,
      'Virtual',
      $Estatus,
      $archivo_anticipo = 'N/A',
      $archivo_entregado = '#',
      'Generado por el sistema',
      $Estado_Cuenta->idestado_cuenta_proveedores,
      '',
      $fecha_actual,
      $visible = 'SI'
    );

    BitacoraCambiosCuadreECP::createRegistroCambio('documentos_pagar','*',$NuevoPagare->iddocumentos_pagar,'','','Se creo un pagare con el monto de '.$Monto);

    return $NuevoPagare;

  }

}
