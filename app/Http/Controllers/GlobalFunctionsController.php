<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GlobalFunctionsController extends Controller
{
   public static function convertirTildesCaracteres($cadena){
      //Codificamos la cadena en formato utf8 en caso de que nos de errores
      //Ahora reemplazamos las letras
      $cadena = str_replace(array('á', 'à', 'ä', 'â', 'ª'), array('a', 'a', 'a', 'a', 'a'),$cadena);
      $cadena = str_replace(array('Á', 'À', 'Â', 'Ä'), array('A', 'A', 'A', 'A'),$cadena);
      $cadena = str_replace(array('é', 'è', 'ë', 'ê'),array('e', 'e', 'e', 'e'),$cadena );
      $cadena = str_replace(array('É', 'È', 'Ê', 'Ë'),array('E', 'E', 'E', 'E'),$cadena );
      $cadena = str_replace(array('í', 'ì', 'ï', 'î'),array('i', 'i', 'i', 'i'),$cadena );
      $cadena = str_replace(array('Í', 'Ì', 'Ï', 'Î'),array('I', 'I', 'I', 'I'),$cadena );
      $cadena = str_replace(array('ó', 'ò', 'ö', 'ô'),array('o', 'o', 'o', 'o'),$cadena );
      $cadena = str_replace(array('Ó', 'Ò', 'Ö', 'Ô'),array('O', 'O', 'O', 'O'),$cadena );
      $cadena = str_replace(array('ú', 'ù', 'ü', 'û'),array('u', 'u', 'u', 'u'),$cadena );
      $cadena = str_replace(array('Ú', 'Ù', 'Û', 'Ü'),array('U', 'U', 'U', 'U'),$cadena );
      $cadena = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),array('n', 'N', 'c', 'C'),$cadena);
      return $cadena;
   }
   public static function convertirTildesHtml($cadena){
      //Codificamos la cadena en formato utf8 en caso de que nos de errores
      //Ahora reemplazamos las letras
      $cadena = str_replace(array('á', 'à', 'ä', 'â', 'ª'), array('&aacute;', '&aacute;', '&aacute;', '&aacute;', '&aacute;'),$cadena);
      $cadena = str_replace(array('Á', 'À', 'Â', 'Ä'), array('&Aacute;', '&Aacute;', '&Aacute;', '&Aacute;'),$cadena);
      $cadena = str_replace(array('é', 'è', 'ë', 'ê'),array('&eacute;', '&eacute;', '&eacute;', '&eacute;'),$cadena );
      $cadena = str_replace(array('É', 'È', 'Ê', 'Ë'),array('&Eacute;', '&Eacute;', '&Eacute;', '&Eacute;'),$cadena );
      $cadena = str_replace(array('í', 'ì', 'ï', 'î'),array('&iacute;', '&iacute;', '&iacute;', '&iacute;'),$cadena );
      $cadena = str_replace(array('Í', 'Ì', 'Ï', 'Î'),array('&Iacute;', '&Iacute;', '&Iacute;', '&Iacute;'),$cadena );
      $cadena = str_replace(array('ó', 'ò', 'ö', 'ô'),array('&oacute;', '&oacute;', '&oacute;', '&oacute;'),$cadena );
      $cadena = str_replace(array('Ó', 'Ò', 'Ö', 'Ô'),array('&Oacute;', '&Oacute;', '&Oacute;', '&Oacute;'),$cadena );
      $cadena = str_replace(array('ú', 'ù', 'ü', 'û'),array('&uacute;', '&uacute;', '&uacute;', '&uacute;'),$cadena );
      $cadena = str_replace(array('Ú', 'Ù', 'Û', 'Ü'),array('&Uacute;', '&Uacute;', '&Uacute;', '&Uacute;'),$cadena );
      $cadena = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),array('&ntilde;', '&Ntilde;', 'c', 'C'),$cadena);
      return $cadena;
   }
   public static function eliminar_tildes($cadena){
      //Codificamos la cadena en formato utf8 en caso de que nos de errores
      //Ahora reemplazamos las letras
      $cadena = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A'),$cadena);
      $cadena = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'),$cadena );
      $cadena = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),array('I', 'I', 'I', 'I', 'I', 'I', 'I', 'I'),$cadena );
      $cadena = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),array('O', 'O', 'O', 'O', 'O', 'O', 'O', 'O'),$cadena );
      $cadena = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),array('U', 'U', 'U', 'U', 'U', 'U', 'U', 'U'),$cadena );
      $cadena = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'),array('n', 'N', 'c', 'C'),$cadena);
      return $cadena;
   }
   public static function eliminarCaracteresSeriePagare($cadena){
      //Codificamos la cadena en formato utf8 en caso de que nos de errores
      //Ahora reemplazamos las letras
      $cadena = str_replace(array('1-> ', '2-> ', '3-> ', '4-> ', '5-> ', '6-> '), array('', '', '', '', '', ''),$cadena);
      return $cadena;
   }

   /*Start letras a numeros*/
   public static function unidad($numuero) {
      switch ($numuero) {
         case 9:{$numu = "NUEVE ";break;}
         case 8:{$numu = "OCHO ";break;}
         case 7:{$numu = "SIETE ";break;}
         case 6:{$numu = "SEIS ";break;}
         case 5:{$numu = "CINCO ";break;}
         case 4:{$numu = "CUATRO";break;}
         case 3:{$numu = "TRES ";break;}
         case 2:{$numu = "DOS ";break;}
         case 1:{$numu = "UNO ";break;}
         case 0:{$numu = "";break;}
      }
      return $numu;
   }

   public static function decena($numdero) {
      if ($numdero >= 90 && $numdero <= 99) {
         $numd = "NOVENTA ";
         if ($numdero > 90)  $numd = $numd."Y ".(GlobalFunctionsController::unidad($numdero - 90));
      } else if ($numdero >= 80 && $numdero <= 89) {
         $numd = "OCHENTA ";
         if ($numdero > 80)  $numd = $numd."Y ".(GlobalFunctionsController::unidad($numdero - 80));
      } else if ($numdero >= 70 && $numdero <= 79) {
         $numd = "SETENTA ";
         if ($numdero > 70)  $numd = $numd."Y ".(GlobalFunctionsController::unidad($numdero - 70));
      } else if ($numdero >= 60 && $numdero <= 69) {
         $numd = "SESENTA ";
         if ($numdero > 60)  $numd = $numd."Y ".(GlobalFunctionsController::unidad($numdero - 60));
      } else if ($numdero >= 50 && $numdero <= 59) {
         $numd = "CINCUENTA ";
         if ($numdero > 50)  $numd = $numd."Y ".(GlobalFunctionsController::unidad($numdero - 50));
      } else if ($numdero >= 40 && $numdero <= 49) {
         $numd = "CUARENTA ";
         if ($numdero > 40)  $numd = $numd."Y ".(GlobalFunctionsController::unidad($numdero - 40));
      } else if ($numdero >= 30 && $numdero <= 39) {
         $numd = "TREINTA ";
         if ($numdero > 30)  $numd = $numd."Y ".(GlobalFunctionsController::unidad($numdero - 30));
      } else if ($numdero >= 20 && $numdero <= 29) {
         if ($numdero == 20)
         $numd = "VEINTE ";
         else $numd = "VEINTI".(GlobalFunctionsController::unidad($numdero - 20));
      } else if ($numdero >= 10 && $numdero <= 19) {
         switch ($numdero) {
            case 10:{$numd = "DIEZ ";break;}
            case 11:{$numd = "ONCE ";break;}
            case 12:{$numd = "DOCE ";break;}
            case 13:{$numd = "TRECE ";break;}
            case 14:{$numd = "CATORCE ";break;}
            case 15:{$numd = "QUINCE ";break;}
            case 16:{$numd = "DIECISEIS ";break;}
            case 17:{$numd = "DIECISIETE ";break;}
            case 18:{$numd = "DIECIOCHO ";break;}
            case 19:{$numd = "DIECINUEVE ";break;}
         }
      } else
      $numd = GlobalFunctionsController::unidad($numdero);
      return $numd;
   }

   public static function centena($numc) {
      if ($numc >= 100) {
         if ($numc >= 900 && $numc <= 999) {
            $numce = "NOVECIENTOS ";
            if ($numc > 900)$numce = $numce.(GlobalFunctionsController::decena($numc - 900));
         } else if ($numc >= 800 && $numc <= 899) {
            $numce = "OCHOCIENTOS ";
            if ($numc > 800)$numce = $numce.(GlobalFunctionsController::decena($numc - 800));
         } else if ($numc >= 700 && $numc <= 799) {
            $numce = "SETECIENTOS ";
            if ($numc > 700)$numce = $numce.(GlobalFunctionsController::decena($numc - 700));
         } else if ($numc >= 600 && $numc <= 699) {
            $numce = "SEISCIENTOS ";
            if ($numc > 600)$numce = $numce.(GlobalFunctionsController::decena($numc - 600));
         } else if ($numc >= 500 && $numc <= 599) {
            $numce = "QUINIENTOS ";
            if ($numc > 500)$numce = $numce.(GlobalFunctionsController::decena($numc - 500));
         } else if ($numc >= 400 && $numc <= 499) {
            $numce = "CUATROCIENTOS ";
            if ($numc > 400)$numce = $numce.(GlobalFunctionsController::decena($numc - 400));
         } else if ($numc >= 300 && $numc <= 399) {
            $numce = "TRESCIENTOS ";
            if ($numc > 300)$numce = $numce.(GlobalFunctionsController::decena($numc - 300));
         } else if ($numc >= 200 && $numc <= 299) {
            $numce = "DOSCIENTOS ";
            if ($numc > 200)$numce = $numce.(GlobalFunctionsController::decena($numc - 200));
         } else if ($numc >= 100 && $numc <= 199) {
            if ($numc == 100)
            $numce = "CIEN ";
            else
            $numce = "CIENTO ".(GlobalFunctionsController::decena($numc - 100));
         }
      } else
      $numce = GlobalFunctionsController::decena($numc);
      return $numce;
   }

   public static function miles($nummero) {
      if ($nummero >= 1000 && $nummero < 2000) {$numm = "MIL ".(GlobalFunctionsController::centena($nummero%1000));}
      if ($nummero >= 2000 && $nummero <10000) {$numm = GlobalFunctionsController::unidad(Floor($nummero/1000))." MIL ".(GlobalFunctionsController::centena($nummero%1000));}
      if ($nummero < 1000)$numm = GlobalFunctionsController::centena($nummero);
      return $numm;
   }

   public static function decmiles($numdmero) {
      if ($numdmero == 10000)$numde = "DIEZ MIL ";
      if ($numdmero > 10000 && $numdmero <20000) {$numde = GlobalFunctionsController::decena(Floor($numdmero/1000))."MIL ".(GlobalFunctionsController::centena($numdmero%1000));}
      if ($numdmero >= 20000 && $numdmero <100000) {$numde = GlobalFunctionsController::decena(Floor($numdmero/1000))."MIL ".(GlobalFunctionsController::miles($numdmero%1000));}
      if ($numdmero < 10000)$numde = GlobalFunctionsController::miles($numdmero);
      return $numde;
   }

   public static function cienmiles($numcmero){
      if ($numcmero == 100000)$num_letracm = "CIEN MIL ";
      if ($numcmero >= 100000 && $numcmero <1000000) {$num_letracm = GlobalFunctionsController::centena(Floor($numcmero/1000))."MIL ".(GlobalFunctionsController::centena($numcmero%1000));}
      if ($numcmero < 100000)$num_letracm = GlobalFunctionsController::decmiles($numcmero);
      return $num_letracm;
   }

   public static function millon($nummiero) {
      if ($nummiero >= 1000000 && $nummiero <2000000) {$num_letramm = "UN MILLON ".(GlobalFunctionsController::cienmiles($nummiero%1000000));}
      if ($nummiero >= 2000000 && $nummiero <10000000){$num_letramm = GlobalFunctionsController::unidad(Floor($nummiero/1000000))." MILLONES ".(GlobalFunctionsController::cienmiles($nummiero%1000000));}
      if ($nummiero < 1000000)$num_letramm = GlobalFunctionsController::cienmiles($nummiero);
      return $num_letramm;
   }

   public static function decmillon($numerodm) {
      if ($numerodm == 10000000)$num_letradmm = "DIEZ MILLONES ";
      if ($numerodm > 10000000 && $numerodm <20000000){$num_letradmm = GlobalFunctionsController::decena(Floor($numerodm/1000000))."MILLONES ".(GlobalFunctionsController::cienmiles($numerodm%1000000));}
      if ($numerodm >= 20000000 && $numerodm <100000000){$num_letradmm = GlobalFunctionsController::decena(Floor($numerodm/1000000))."MILLONES ".(GlobalFunctionsController::millon($numerodm%1000000));}
      if ($numerodm < 10000000)$num_letradmm = GlobalFunctionsController::millon($numerodm);
      return $num_letradmm;
   }

   public static function cienmillon($numcmeros) {
      if ($numcmeros == 100000000)$num_letracms = "CIEN MILLONES ";
      if ($numcmeros >= 100000000 && $numcmeros <1000000000) {$num_letracms = GlobalFunctionsController::centena(Floor($numcmeros/1000000))."MILLONES ".(GlobalFunctionsController::millon($numcmeros%1000000));}
      if ($numcmeros < 100000000)$num_letracms = GlobalFunctionsController::decmillon($numcmeros);
      return $num_letracms;
   }

   public static function milmillon($nummierod) {
      if ($nummierod >= 1000000000 && $nummierod <2000000000) {$num_letrammd = "MIL ".(GlobalFunctionsController::cienmillon($nummierod%1000000000));}
      if ($nummierod >= 2000000000 && $nummierod <10000000000) {$num_letrammd = GlobalFunctionsController::unidad(Floor($nummierod/1000000000))." MIL ".(GlobalFunctionsController::cienmillon($nummierod%1000000000));}
      if ($nummierod < 1000000000)$num_letrammd = GlobalFunctionsController::cienmillon($nummierod);
      return $num_letrammd;
   }

   public static function convertir($numero, $tipo_moneda){
      $num = str_replace(",","",$numero);
      $num = number_format((float)$num,2,'.','');
      $cents = substr($num,strlen($num)-2,strlen($num)-1);
      $num = (int)$num;
      $numf = GlobalFunctionsController::milmillon($num);
      if($tipo_moneda == "MXN") return $numf." PESOS ".$cents."/100 M/N";
      if($tipo_moneda == "USD") return $numf." DOLARES ".$cents."/100 M/A";
      if($tipo_moneda == "CAD") return $numf." DOLARES ".$cents."/100 CAD";
   }

   /*End letras a numeros*/


   public static function createPdf($view, $nombre, $apellidos, $id_contacto_completo, $module, $header,$code_qr, $user){

      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => storage_path('mpdf/temp/'),
        // 'mode' => 'utf-8',
        'mode' => 's',
        'format' => 'Letter',
        // 'format' => [190, 236],
        // 'format' => [200, 236],
        'margin_top' => 28,
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_bottom' => 30,
        'margin_header'=>18,
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
      // $mpdf=new mPDF('c','A4','','','10','10','28','10');

      $img_header = "";
      $content_footer = '<img src="'.public_path('/img/mpdf/footer.png').'" class="img_footer" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>';

      if($module == "admon_compras" && $header == "estado_cuenta_compras") $img_header = "estado_cuenta_compras";

      if($module == "admon_compras" && $header == "comprobante_egreso") $img_header = "head_comprobante_egreso";

      if($module == "admon_compras" && $header == "recibo"){
         $img_header = "head_recibo";
         $content_footer = '
             <p class="text-datos-obs">
                <div style="width: 100%;">
                   <div style="width: 80%; float: left;">
                     <p class="tit3" style="text-align: center; color: #AFAEAE; margin-top: 80px; margin-left: 40px;">El presente recibo no es válido si los datos desplegados con la lectura del QR son diferentes al impreso. Valide la información y asegúrese de recibir un comprobante válido.</p>
                   </div>
                   <div style="width: 19%; float: left;">
                      <div style="width: 100px; float: right;">'
                        // <img src="../../Codigos_qr_recibos/codigoqr2.png" style="width: 100px;">
                        .$code_qr.
                      '</div>
                   </div>
                </div>
                <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>
             </p>';
      }

      if($header == "compras_directas_proveedores")$img_header = "reporte_compras_proveedor";
      if($header == "compras_directas_proveedores_deuda_sin_inventario")$img_header = "reporte_compras_proveedor_deuda_sin_ingreso";
      if($header == "compras_directas_proveedores_pagado_sin_inventario")$img_header = "reporte_compras_proveedor_recepcion_pendiente";
      if($header == "compras_directas_proveedores_deuda")$img_header = "reporte_compras_proveedor_deuda";
      if($header == "compras_directas_comisiones")$img_header = "reporte_compras_proveedor_general";
      if($header == "reporte_ejecutivo_compras")$img_header = "reporte_ejecutivo_compras";


      if($module == "vpme"){
          if($header == "vista_previa_movimiento_exitoso"){
              $img_header = "vista_previa_movimiento_exitoso";
              $content_footer = '
                  <p class="text-datos-obs">
                     <div style="width: 100%;">
                        <div style="width: 90%; float: left;">
                          <p class="tit3" style="margin-top: 80px; font-size:12px;">Comentarios: '.$user->comentarios_venta.'</p>
                        </div>
                        <div style="width: 10%; float: left;">
                           <div style=" float: right;">'.
                            // <p class="tit3" style="margin-top: 80px; margin-left: 40px; font-size:12px;">Fecha recibido: '.$user->fecha.'</p>'.
                             // <img src="../../Codigos_qr_recibos/codigoqr2.png" style="width: 100px;">
                             // .$code_qr.
                           '</div>
                        </div>
                     </div>
                  </p>
                     <div style="width: 100%;">
                        <div style="width: 64.9%; float: left;">
                          <p class="tit3" style="font-size:12px;">Recibido por: '.$user->usuario.'</p>
                        </div>
                        <div style="width: 35%; float: left;">
                          <p class="tit3" style="font-size:12px; text-align: right;">Fecha recibido: '.$user->fecha.'</p>'.
                             // <img src="../../Codigos_qr_recibos/codigoqr2.png" style="width: 100px;">
                             // .$code_qr.
                          '
                        </div>
                     </div>
                     <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>


                  ';

          }
          if($header == "venta_directa_contado") $img_header = "contrato_compra_venta";

          if($header == "personas_fisicas"){
              $img_header = "ley_antilavado";
              $content_footer = '
                  <p class="text-datos-obs">
                     <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>
                  </p>';
          }
          if($header == "aviso_privacidad"){
              $img_header = "aviso_privacidad";
              $content_footer = '
                  <p class="text-datos-obs">
                     <div style="width: 100%; text-align:center;">
                        <div style="width: 98%; float: left;">
                          <p class="tit3" style="margin-top: 80px; margin-left: 40px; font-size:10px;">
                            INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER S.A DE C.V.
                          </p>
                        </div>
                        <div style="width: 2%; float: left;">
                           <div style=" float: right;">
                           </div>
                        </div>
                     </div>
                     <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>
                  </p>';

          }

      }



      if($module == "admon_compras")$mpdf->SetHTMLHeader('<img src="'.public_path('/img/mpdf/'.$img_header.'.png').'" class="img_header" style="width:100%;" alt=""><br>');
      if($module == "vpme")$mpdf->SetHTMLHeader('<img src="'.storage_path('app/VPMovimientoExitoso/mpdf/'.$img_header.'.png').'" class="img_header" style="width:100%;" alt=""><br>');

      $mpdf->SetHTMLFooter($content_footer);
      $html_content =$view->render();
      $mpdf->WriteHTML($html_content);
      // $mpdf->SetProtection(array('copy','print'), 'UserPassword', 'password');
      $nc = $nombre." ".$apellidos;
      $nombre_completo2 = GlobalFunctionsController::eliminar_tildes($nc);
      $words = explode(" ", $nombre_completo2); $acronym = "";
      foreach ($words as $w) { if(!empty($w))$acronym .= $w[0]; }
      $nombre_de_archivo = $id_contacto_completo.".".$acronym."-".$nombre_completo2.".pdf";
      if($header == "comprobante_egreso") $nombre_de_archivo = "Folio_".$id_contacto_completo.".pdf";

      $mpdf->Output($nombre_de_archivo, 'I');
      exit;
   }

   public static function savePdfIntoServer($view, $nombre, $apellidos, $id_contacto_completo, $module, $header,$code_qr, $info_extra){

      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => storage_path('mpdf/temp/'),
        'mode' => 'c',
        'format' => 'A4',
        'margin_top' => 28,
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_bottom' => 30,
        'margin_header'=>18,
      ]);
      $mpdf->defaultheaderfontsize = 10;
      $mpdf->defaultheaderfontstyle = 'B';
      $mpdf->defaultheaderline = 0;
      $mpdf->defaultfooterfontsize = 10;
      $mpdf->defaultfooterfontstyle = 'BI';
      $mpdf->defaultfooterline = 0;

      $img_header = "";
      $content_footer = '<img src="'.public_path('/img/mpdf/footer.png').'" class="img_footer" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>';


      if($module == "vpme"){
          if($header == "vista_previa_movimiento_exitoso"){
              $img_header = "vista_previa_movimiento_exitoso";
              $content_footer = '
                  <p class="text-datos-obs">
                     <div style="width: 100%;">
                        <div style="width: 65%; float: left;">
                          <p class="tit3" style="margin-top: 80px; margin-left: 40px; font-size:12px;">Recibido por: '.$user->usuario.'</p>
                        </div>
                        <div style="width: 35%; float: left;">
                           <div style=" float: right;">
                            <p class="tit3" style="margin-top: 80px; margin-left: 40px; font-size:12px;">Fecha recibido: '.$user->fecha.'</p>'.
                             // <img src="../../Codigos_qr_recibos/codigoqr2.png" style="width: 100px;">
                             // .$code_qr.
                           '</div>
                        </div>
                     </div>
                     <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>
                  </p>';

          }
          if($header == "venta_directa_contado") $img_header = "contrato_compra_venta";

          if($header == "personas_fisicas"){
              $img_header = "ley_antilavado";
              $content_footer = '
                  <p class="text-datos-obs">
                     <div style="width: 100%;">
                        <div style="width: 70%; float: left;">
                          <p class="tit3" style="margin-top: 80px; margin-left: 40px; font-size:10px;">
                          FAVOR DE AGREGAR EN COPIA LA SIGUIENTE INFORMACIÓN:<br>
                            -	IDENTIFICACIÓN OFICIAL (INE, CARTILLA MILITAR, PASAPORTE, CEDULA PROFESIONAL)<br>
                            -	CURP<br>
                            -	COMPROBANTE DOMICILIO<br>
                          </p>
                        </div>
                        <div style="width: 30%; float: left;">
                           <div style=" float: right;">
                            <p class="tit3" style="margin-top: 80px; margin-left: 40px; font-size:12px;"></p>'.
                             // <img src="../../Codigos_qr_recibos/codigoqr2.png" style="width: 100px;">
                             // .$code_qr.
                           '</div>
                        </div>
                     </div>
                     <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>
                  </p>';
          }
          if($header == "aviso_privacidad"){
              $img_header = "aviso_privacidad";
              $content_footer = '
                  <p class="text-datos-obs">
                     <div style="width: 100%; text-align:center;">
                        <div style="width: 98%; float: left;">
                          <p class="tit3" style="margin-top: 80px; margin-left: 40px; font-size:10px;">
                            INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER S.A DE C.V.
                          </p>
                        </div>
                        <div style="width: 2%; float: left;">
                           <div style=" float: right;">
                           </div>
                        </div>
                     </div>
                     <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>
                  </p>';

          }

      }

      if($module == "vpme")$mpdf->SetHTMLHeader('<img src="'.storage_path('app/VPMovimientoExitoso/mpdf/'.$img_header.'.png').'" class="img_header" style="width:100%;" alt=""><br>');

      $mpdf->SetHTMLFooter($content_footer);
      $html_content =$view->render();
      $mpdf->WriteHTML($html_content);
      $nc = $nombre." ".$apellidos;
      $nombre_completo2 = GlobalFunctionsController::eliminar_tildes($nc);
      $nombre_completo2 = str_replace(" ", "_",$nombre_completo2);

      $words = explode(" ", $nombre_completo2); $acronym = "";
      foreach ($words as $w) { if(!empty($w))$acronym .= $w[0]; }
      // $nombre_de_archivo = $id_contacto_completo."_".$acronym."_".$nombre_completo2.".pdf";

      // $fecha = $user->usuario->created_at;
      $nombre_de_archivo = $id_contacto_completo."_".$acronym."_".$nombre_completo2."_".($info_extra->fecha).".pdf";
      // dd($info_extra);
      // $nombre_de_archivo = $nombre_de_archivo."_";
      $ruta = storage_path('app/VPMovimientoExitoso/formatos_pdf/').$nombre_de_archivo;
      // dd($ruta);
      $mpdf->Output($ruta, 'F');
      $bd = 'storage/app/VPMovimientoExitoso/formatos_pdf/'.$nombre_de_archivo;
      // dd($bd);
      return $bd;
      // exit;
   }










}
