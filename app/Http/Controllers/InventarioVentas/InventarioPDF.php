<?php

namespace App\Http\Controllers\InventarioVentas;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\inventario_dinamico;
use App\Models\publicacion_vin_fotos;
use App\Models\tipos_especificaciones_vin;
use App\Models\tipos_sub_especificaciones_vin;
/*use App\Models\orden_compra_unidades;
use App\Models\check_list_expediente_original;*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class InventarioPDF extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function CrearPDF($id,$vin){

    try {

      $id = Crypt::decrypt($id);
      $vin = Crypt::decrypt($vin);

      $Is_Truck = false;

      $Vehiculo = inventario::where('idinventario', $id)->where('visible', 'SI')->where('vin_numero_serie', $vin)->first();
      if (!$Vehiculo) {
        $Vehiculo = inventario_trucks::where('idinventario_trucks', $id)->where('visible', 'SI')->where('vin_numero_serie', $vin)->first();
        $Is_Truck = true;
      }
      if (!$Vehiculo) {
        return back()->with('error','Vehiculo no encontrado')->withInput();
      }


      $PubliFotos = publicacion_vin_fotos::select('tipo','ruta_foto')->where('visible', 'SI')->where('vin', $vin)
      ->where(function ($query) {
        $query->where('tipo' , 'Principal')
        ->orWhere('tipo' , 'Vista Frontal')
        ->orWhere('tipo' , 'Vista Trasera')
        ->orWhere('tipo' , 'Vista Lateral Izquierdo')
        ->orWhere('tipo' , 'Vista Lateral Derecho')
        ->orWhere('tipo' , 'Vista Interior 1')
        ->orWhere('tipo' , 'Vista Interior 2');
      })->get();


      $Fotos = [];

      $Fotos['principal'] = $PubliFotos->where('tipo', 'Principal')->first();
      $Fotos['vistafrontal'] = $PubliFotos->where('tipo', 'Vista Frontal')->first();
      $Fotos['vistatrasera'] = $PubliFotos->where('tipo', 'Vista Trasera')->first();
      $Fotos['vistalateralizquierdo'] = $PubliFotos->where('tipo', 'Vista Lateral Izquierdo')->first();
      $Fotos['vistalateralderecho'] = $PubliFotos->where('tipo', 'Vista Lateral Derecho')->first();
      $Fotos['VistaInterior1'] = $PubliFotos->where('tipo', 'Vista Interior 1')->first();
      $Fotos['VistaInterior2'] = $PubliFotos->where('tipo', 'Vista Interior 2')->first();



      foreach ($Fotos as $key => $f) {
        if ($f) {
          $Fotos[$key] = "<img id='fotos' src='".str_replace('../../','https://www.panamotorscenter.com/Des/CCP/',$f->ruta_foto)."' class='img-max imgGeneral'>";
        }else{
          $Fotos[$key] = "<img id='fotos' src='https://www.panamotorscenter.com/Des/CCP/Sesion_VIN/blanco.jpeg' class='img-max imgGeneral'>";
        }
      }


      $TiposEspeVIN =  tipos_especificaciones_vin::select('idtipos_especificaciones_vin')->where('visible', 'SI')->orderBy('idtipos_especificaciones_vin','ASC')->get();

      $tabla_dinamica = "";
      $tabla_dinamica2 = '<table class="tabla-1">';
      foreach ($TiposEspeVIN as $TEV_KEY => $TEV) {

        $InventarioD =  inventario_dinamico::join('inventario_d_tipos_especificaciones','inventario_dinamico.idinventario_dinamico','=','inventario_d_tipos_especificaciones.idinventario_dinamico')
        ->where('inventario_dinamico.idinventario', $id)
        ->where('inventario_dinamico.visible', 'SI')
        ->where('inventario_d_tipos_especificaciones.visible', 'SI')
        ->where('inventario_d_tipos_especificaciones.idtipos_especificaciones_vin', $TEV->idtipos_especificaciones_vin)->get();

        if (sizeof($InventarioD) > 0) {

          $tabla_dinamica .= '<br>
          <tr>
          <td colspan="3" style="border-bottom: 4px solid #882439;"><p style="color: #131313; text-transform: uppercase; font-size: 18px;">'.$InventarioD->tipo.'</p></td>
          </tr>';

          foreach ($InventarioD as $ID_KEY => $InvD) {
            $TiposSubE = tipos_sub_especificaciones_vin::select('idtipos_sub_especificaciones_vin','tipo')->where('visible','SI')
            ->where('idtipos_especificaciones_vin', $TEV->idtipos_especificaciones_vin)
            ->orderBy('idtipos_sub_especificaciones_vin','ASC')->get();

            foreach ($TiposSubE as $TSE_key => $TSE) {

              $InvDinamico_Two = inventario_dinamico::select('columna','contenido')->join('inventario_d_tipos_especificaciones','inventario_dinamico.idinventario_dinamico','=','inventario_d_tipos_especificaciones.idinventario_dinamico')
              ->where('inventario_dinamico.idinventario', $id)
              ->where('inventario_dinamico.visible', 'SI')
              ->where('inventario_d_tipos_especificaciones.visible', 'SI')
              ->where('inventario_d_tipos_especificaciones.idtipos_especificaciones_vin', $TEV->idtipos_especificaciones_vin)
              ->where('inventario_d_tipos_especificaciones.idtipos_sub_especificaciones_vin', $TSE->idtipos_sub_especificaciones_vin)->get();

              if (sizeof($InvDinamico_Two) > 0) {

                $tabla_dinamica .= '<br><br><br>
                <tr>
                <td style="width: 10%; padding: 5px 0px;"></td>
                <td style="border-bottom: 4px solid #882439;width: 80%;"><p style="color: #131313; text-transform: uppercase; font-size: 12px; border-bottom: 4px solid #882439;">'.$TSE->tipo.'</p></td>
                <td style="10%;"></td>
                </tr>';

                for ($i=0; $i < sizeof($InvDinamico_Two); $i+=3) {


                  $enca1 = $InvDinamico_Two[$i]->columna;
                  $enca2 = $InvDinamico_Two[$i+1]->columna;
                  $enca3 = $InvDinamico_Two[$i+2]->columna;

                  $enca1x = str_replace("_", " ",  ucfirst (mb_strtolower($enca1, 'UTF-8')));
                  $enca2x = str_replace("_", " ",  ucfirst (mb_strtolower($enca2, 'UTF-8')));
                  $enca3x = str_replace("_", " ",  ucfirst (mb_strtolower($enca3, 'UTF-8')));
                  $enca1x = str_replace("usb", "USB",  $enca1x);
                  $enca2x = str_replace("usb", "USB",  $enca2x);
                  $enca3x = str_replace("usb", "USB",  $enca3x);


                  $info1 = $InvDinamico_Two[$i]->contenido;
                  $info2 = $InvDinamico_Two[$i+1]->contenido;
                  $info3 = $InvDinamico_Two[$i+2]->contenido;

                  if ($enca1 !="" || $enca2 !="" || $info1!="" || $info2 !="") {
                    $tabla_dinamica .= '

                    <tr>
                    <th style="width: 33.33%; padding: 5px 0px;">'.$enca1x.'</th>
                    <th style="width: 33.33%; padding: 5px 0px;">'.$enca2x.'</th>
                    <th style="width: 33.33%; padding: 5px 0px;">'.$enca3x.'</th>

                    </tr>
                    <tr>
                    <td style="width: 33.33%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">'.$info1.'</td>
                    <td style="width: 33.33%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">'.$info2.'</td>
                    <td style="width: 33.33%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">'.$info3.'</td>

                    </tr>

                    ';
                  }
                }

              }else{
                $tabla_dinamica2 .= $tabla_dinamica;
                $tabla_dinamica = "";
              }
            }
            $tabla_dinamica2 .= $tabla_dinamica;
            $tabla_dinamica = "";
          }
        }else{
          $tabla_dinamica = "";
        }
      }

      if ($tabla_dinamica2 ==  '<table class="tabla-1">') {
        $tabla_dinamica2 .= '</table>';
      }else{
        $tabla_dinamica2 .= '</table><pagebreak />';
      }


      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => storage_path('mpdf/temp/'),
        // 'mode' => 'utf-8',
        'mode' => 'c',
        'format' => 'Letter',
        // 'format' => [190, 236],
        // 'format' => [200, 236],
        //'margin_top' => 30,
        //'margin_left' => 10,
        //'margin_right' => 10,
        //'margin_bottom' => 50,
        //'margin_header'=>18,
        /*debug*/
        // DEPURACIÓN Y DESARROLLADORES
        // 'debug' => true ,
      ]);
      $mpdf->defaultheaderfontsize = 10;
      $mpdf->defaultheaderfontstyle = 'B';
      $mpdf->defaultheaderline = 0;
      $mpdf->defaultfooterfontsize = 10;
      $mpdf->defaultfooterfontstyle = 'BI';
      $mpdf->defaultfooterline = 0;

      $mpdf->SetHTMLFooter('<p class="text-datos-obs" style="color: black;"><img src="'.secure_asset('storage/app/mercadotecnia/header_merca.png').'" alt="">{PAGENO} de {nb}</p>');
      $html_content = view('InventarioVentas.pdf',compact('Fotos','Vehiculo','Is_Truck','tabla_dinamica2'))->render();
      $mpdf->WriteHTML($html_content);

      $mpdf->Output('Prueba', 'I');

    } catch (\Exception $e) {      
      return back()->with('error',$e->getMessage())->withInput();
    }

  }


}
