<?php

namespace App\Http\Controllers\VPMovimientoExitoso;
use App\Http\Controllers\GlobalFunctionsController;
use App\Http\Controllers\VPMovimientoExitoso\PDFSaveIntoServerController;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\vista_previa_movimiento_exitoso;
use App\Models\vpme_codigo_autorizacion;



class AprobacionController extends Controller {

  public function __construct(){
    $this->middleware('auth');
  }


  public function GuardarCodigo(){

    DB::beginTransaction();
    try {
      $idVistaPrevia = Crypt::decrypt(request()->idVistaPrevia);

      $VistaPrevia = vista_previa_movimiento_exitoso::select('idcontacto')->where('id', $idVistaPrevia)
      ->where('visible', 'SI')
      ->first();
      if ($VistaPrevia) {
        $CodigoAutorizacion = vpme_codigo_autorizacion::where('id_vista_previa_movimiento_exitoso', $idVistaPrevia)->where('visible', 'SI')->first();
        $Id_Autorizo =  \Auth::user()->idempleados;

        if ($CodigoAutorizacion) {
          $CodigoAutorizacion->codigo = request()->CodigoAdmin;
          $CodigoAutorizacion->comentarios = request()->comentarios;
          $CodigoAutorizacion->evidencia = '';
          $CodigoAutorizacion->id_usuario_autorizo = $Id_Autorizo;
          $CodigoAutorizacion->save();
        }else{
          vpme_codigo_autorizacion::createCodigoAutorizacion(
            $idVistaPrevia, request()->CodigoAdmin,request()->comentarios,$evidencia = '','SI',$Id_Autorizo
          );
        }


        //Copiar Archivo-----------------------------------------
        $file = request()->file('EvidenciaAutorizacion');
        date_default_timezone_set('America/Mexico_City');
        $fecha_actual = date("Y-m-d");
        $usuario_creador = \Request::cookie('usuario_creador');
        $cliente = $VistaPrevia->idcontacto;

        $nombre = "P".$cliente."_".$fecha_actual."_Usr_".$usuario_creador."_".$file->getClientOriginalName();
        $archivo_cargado = 'storage/app/aprobacion/'.$nombre;

        \Storage::disk('local')->put('/aprobacion/'.$nombre,  \File::get($file));



        //Copiar Archivo-----------------------------------------
      }else{
        return back()->with('error','Error no se encontro la venta')->withInput();
      }

      DB::commit();
      return back()->with('success','Codigo alamacenado');
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
      return back()->with('error','Error intente de nuevo')->withInput();
    }
  }

  public function UsarCodigo(){

    DB::beginTransaction();
    try {
      $idVistaPrevia = Crypt::decrypt(request()->idVistaPrevia);
      $CodigoAutorizacion = vpme_codigo_autorizacion::where('id_vista_previa_movimiento_exitoso', $idVistaPrevia)
      ->where('codigo', request()->CodigoAdminAceptar)
      ->where('visible', 'SI')->first();
      if ($CodigoAutorizacion) {
        $CodigoAutorizacion->visible = 'NO';
        $CodigoAutorizacion->save();
        DB::commit();

        return redirect()->route('vpMovimientoExitoso.verificarAprobarVenta',
        [
          request()->idVistaPrevia,
          Crypt::encrypt(true)
        ]
      );
    }else{
      return back()->with('error','El codigo no esta disponible')->withInput();
    }
  } catch (\Exception $e) {
    DB::rollback();
    return back()->with('error','Error, intente de nuevo')->withInput();
  }
}




}
