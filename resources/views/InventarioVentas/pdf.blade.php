<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PANAMOTORS | Detalle del VIN</title>
  <style type="text/css">
  body{
    font-family: "geometric" !important;
  }

  .img_header{
    margin: 0px 0 0 0;
  }

  .content-pedido{
    width:50%;
    display:block;
    float:left;
    padding: 10px 0px 0 0;
  }

  /*fecha*/

  .content-fecha{
    width:50%;
    display:block;
    float:right;
    padding: 10px 0 0 0;
  }

  .tabla-fecha {
    border-collapse: collapse;
    width: 100%;
    margin: 0px 0 0 0;
    font-size: 10px;
  }

  .tabla-fecha td, .tabla-fecha th {
    border: 0px solid #dddddd;
    text-align: left;
    padding: 0px;
    text-align: center;
  }

  .tabla-fecha tr:nth-child(even) {
    border: 0px solid #dddddd;
    text-align: left;
    padding: 0px;
    text-align: center;
  }


  .both{
    clear: both;
  }




  .pleca-margin-top{

  }

  .container{
    width: 1024px;
    height: 400px;
    margin: 0;
  }

  /*Content-datos*/
  .content-datos{
    margin: 10px 0 0 0;
  }

  .cliente-img{
    width: 100px;
    margin: -15px 0 0 0;
  }

  table.tabla-datos {
    margin: 0px 0 0 0;
    height: 100px;
    display: block;
    background-color: red;
  }

  .invisible{
    display:block;
    margin:-29px 0 0 0;
  }

  /*Content-datos-facturar*/

  p.titulo-datos-facturar-titulo{
    font-size: 10px;
    font-weight: bold;
    height: 18px;
    display: block;
    padding:0 0px -10px 0;
  }

  p.titulo-datos-facturar {
    font-size: 10px;
    font-weight: bold;
    display: block;
    text-align: right;
    padding:0 0px 0px 0;
  }

  p.text-datos-facturar {
    font-size: 10px;
    display: block;
  }

  .tabla-datos-facturar td, .tabla-datos-facturar th {
    padding: 8px;
  }

  /*Content-datos-observaciones*/

  .content-datos-obs{
    margin:0px 0 0 0;
  }

  p.titulo-datos-obs {
    font-size: 10px;
    font-weight: bold;
    height: 18px;
    display: block;
    padding:0 20px 0 0;
  }

  p.text-datos-obs {
    font-size: 9px;
    height: 18px;
    display: block;
    color:gray;
    text-align: right;
  }

  p.text-datos-obs-2 {
    font-size: 7px;
    height: 18px;
    display: block;
    color:gray;
  }

  p.titulo-datos {
    font-size: 10px;
    font-weight: bold;
    display: block;
    text-align: right;
    padding:0 20px 0 0;
  }

  p.text-datos {
    font-size: 10px;
    display: block;
  }

  .tabla-datos td, .tabla-datos th {
    padding: 8px;
  }

  /* Tabla 1*/

  .tabla-1 {
    width: 100%;
    font-size: 11px;
    aling:center;
    /*background-image: url({{secure_asset('storage/app/mercadotecnia/fondo_recibo.png')}});
    background-repeat: no-repeat;
    background-position: center;
    border-collapse: none;*/
  }

  .tabla-1 td {
    //border: 1px solid #dddddd;
    text-align: center;
    //text-align: center;
  }
  .tabla-1 tr td{
    //border: 7px solid #fff;
  }

  .tabla-1 th {
    font-size: 14px;

    text-align: center;
  }
  .tabla-1 tr th{
    color: #131313;
  }

  .tabla-1 tr:nth-child(even) {
    padding: 0px;
    text-align: center;
  }

  .tabla-2 {
    border-collapse: collapse;

    margin: 20px 0 30px 0;
    font-size: 10px;
  }

  .tabla-2 td, .tabla-2 th {
    width: 80%;
    border: 1px solid #dddddd;
    text-align: left;
    padding: -.5px;
    text-align: center;
  }

  .tabla-2 tr:nth-child(even) {
    background-color: #dddddd;
    text-align: center;
  }

  .logo-edo-cot{
    width: 100px;
    display: block;
    margin: -20px 0 0 0;
  }

  /*Credito y cobranza*/
  .tabla-credito {
    border-collapse: collapse;
    width: 100%;
    margin: -10px 0 0 0;
    font-size: 10px;
    color: #696969;
  }

  .tabla-credito td, .tabla-credito th {
    border: 0px solid #dddddd;
    text-align: left;
    padding: 8px;
    text-align: center;
  }

  .tabla-credito tr:nth-child(even) {
    border: 0px solid #dddddd;
    text-align: left;
    padding: 8px;
    text-align: center;
  }

  .tabla-datos-entrega{
    margin: 20px 0 0 0;
  }

  p.titulo-datos-entrega {
    font-size: 10px;
    font-weight: bold;
    height: 18px;
    margin: 0px 0 -20px 0;
  }



  /*total-1*/

  .content-total-1{
    width:50%;
    display:block;
    float:left;
  }

  /*total-2*/

  .content-total-2{
    width:50%;
    display:block;
    float:right;
  }

  .titulo-total-final {
    font-size: 22px;
    font-weight: bold;
    display: block;
    text-align: center;
    padding:0 0px 0px 0;
    color:#3f0f2d;
  }

  .titulos-total-final-text{
    font-size: 14px;
    font-weight: bold;
    display: block;
    text-align: center;
    padding:0 0px 0px 0;

  }

  p.titulo-datos-total {
    font-size: 10px;
    font-weight: bold;
    display: block;
    text-align: right;
    padding:0 0px 0px 0;
  }

  p.text-datos-total {
    font-size: 10px;
    display: block;
  }

  .tabla-datos-total td, .tabla-datos-total th {
    padding: 8px;
  }

  .estatus-abono-positivo{
    background-color: #52ef90;
    color:black;
  }


  .estatus-abono-negativo{
    background-color: #ef5353;
    color:black;
  }

  .estatus-abono-neutro{
    background-color: white;
    color: black;
  }

  .datos-textos-grande{
    text-align: right;
  }

  .header-segundo {
    margin-top: 35px;
  }

  #fotos {
    //display: inline-block;
    //width: 50%;
    //height: auto;
    //position: relative;
  }
  .imgPrincipal{
    display: block;
    width: 80%;
    height: auto;
  }
  .imgGeneral{
    display: block;
    width: 85%;
    height: auto;
  }

  .tabla-1 tr td .iz {
    text-align:right;
  }

  .tabla-1 tr td .de {
    text-align:left;
  }


  .iz {
    text-align:right;
    line-height:0px;
  }

  .de {
    text-align:left;
    line-height:0px;
  }


  .centrar {
    margin:auto;
  }
  .textTitulo{
    color: #131313; text-transform: uppercase; font-size: 18px; border-bottom: 4px solid #882439;
  }
  .fa {
    font-family: fontawesome;
  }
</style>
</head>
<body>

  <div class="container">
    <!--<div class="header">
    <img src="../../img/mercadotecnia/header_detalle_vin.png" class="img_header" alt="">
  </div>-->
  <!--fin-header-->

  <table class="tabla-1">
    <tr>
      <td style="width: 40%; padding: 10px 0px; text-align: left; font-size: 24px;"></td>
      <td style="width: 30%; padding: 10px 0px;" align="center"><img src="{{secure_asset('storage/app/mercadotecnia/grupopanamotors.png')}}" alt="" style="width: 200px;"></td>
      <td style="width: 40%; padding: 10px 0px; text-align: left; font-size: 24px;"></td>
    </tr>
  </table>

  <table class="tabla-1">
    <tr>
      <td width="100%">'>{!!$Fotos['principal']!!}</td>
    </tr>
    <tr>
      <td style="width: 100%; padding: 10px 0px;" align="center"><img src="
        @if ($Is_Truck)
          {{secure_asset('storage/app/logos_marcas/trucks/'.str_replace(" ", "", strtolower($Vehiculo->marca)).'.png')}}
        @else
          {{secure_asset('storage/app/logos_marcas/unidades/'.str_replace(" ", "", strtolower($Vehiculo->marca)).'.png')}}
        @endif
        " alt="" style="width: 180px;"></td>
      </tr>
      <tr>
        <td style="width: 100%; padding: 10px 60px; text-align: center; font-size: 18px; font-weigth: bold; border-bottom: 4px solid #882439;">{{$Vehiculo->version}},{{$Vehiculo->marca}}</td>
      </tr>
      <tr>
        <td style="width: 100%; padding: 10px 0px; text-align: center; font-size: 32px;">
          @if ($Vehiculo->precio_piso == "0")
            Proximamente
          @else
            ${{number_format($Vehiculo->precio_piso,2)}}'</td>
          @endif

        </tr>
        <br>
      </table>

      <div style="margin-top: 400px;">
        <table class="tabla-1">
          <tr>
            <td width="100%" style="text-align: center;"><p class="textTitulo">Vista Frontal</p></td>
          </tr>
          <br>
          <tr>
            <td width="100%">{!!$Fotos['vistafrontal']!!}</td>
          </tr>
        </table>
      </div>

      <div style="margin-top: 10px;">
        <table class="tabla-1">
          <tr>
            <td width="100%" style="text-align: center;"><p style="color: #131313; text-transform: uppercase; font-size: 18px; border-bottom: 4px solid #882439;">Vista Trasera</p></td>
          </tr>
          <br>
          <tr>
            <td width="100%">'{!!$Fotos['vistatrasera']!!}</td>
          </tr>
        </table>
      </div>

      <div style="margin-top: 50px;">
        <table class="tabla-1">
          <tr>
            <td width="100%" style="text-align: center;"><p style="color: #131313; text-transform: uppercase; font-size: 18px; border-bottom: 4px solid #882439;">Vista Lateral Izquierdo</p></td>
          </tr>
          <br>
          <tr>
            <td width="100%">{!!$Fotos['vistalateralizquierdo']!!}</td>
          </tr>
        </table>
      </div>

      <div style="margin-top: 10px;">
        <table class="tabla-1">
          <tr>
            <td width="100%" style="text-align: center;"><p style="color: #131313; text-transform: uppercase; font-size: 18px; border-bottom: 4px solid #882439;">Vista Lateral Derecho</p></td>
          </tr>
          <br>
          <tr>
            <td width="100%">{!!$Fotos['vistalateralderecho']!!}</td>
          </tr>
        </table>
      </div>

      <div style="margin-top: 50px;">
        <table class="tabla-1">
          <tr>
            <td width="100%" style="text-align: center;"><p style="color: #131313; text-transform: uppercase; font-size: 18px; border-bottom: 4px solid #882439;">Vista Interior</p></td>
          </tr>
          <br>
          <tr>
            <td width="100%">'{!!$Fotos['VistaInterior1']!!}'</td>
          </tr>
          <tr>
            <td width="100%">{!!$Fotos['VistaInterior2']!!}</td>
          </tr>
        </table>
      </div>
      <pagebreak />
      <div style="margin-top: 100px;">
        <div style="width: 100%; height: 100%; background: url({{secure_asset('storage/app/mercadotecnia/fondo2.png')}}); background-repeat: no-repeat; background-position: center;">
          <table class="tabla-1">
            <tr>
              <td colspan="3" style="border-bottom: 4px solid #882439;"><p style="color: #131313; text-transform: uppercase; font-size: 18px;">Datos generales</p></td>
            </tr>
            <br>

            @if (!$Is_Truck)
              <tr>
                <th style="width: 33%; padding: 5px 0px;">Marca</th>
                <th colspan="2" style="width: 66%; padding: 5px 0px;">Versión</th>
              </tr>
              <tr>
                <td style="width: 33%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">{{$Vehiculo->marca}}</td>
                <td colspan="2" style="width: 66%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">{{$Vehiculo->version}}</td>
              </tr>
            @endif


            <tr>
              <th style="width: 33%; padding: 5px 0px;">Color</th>
              <th style="width: 33%; padding: 5px 0px;">Modelo</th>
              <th style="width: 33%; padding: 5px 0px;">Precio</th>
            </tr>
            <tr>
              <td style="width: 33%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">{{$Vehiculo->color}}</td>
              <td style="width: 33%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">{{$Vehiculo->modelo}}</td>
              <td style="width: 33%; border-bottom: 1px solid #dddddd; padding: 5px 0px;">
                @if ($Vehiculo->precio_piso == "0")
                  Proximamente
                @else
                  ${{number_format($Vehiculo->precio_piso,2)}}'</td>
                @endif
              </td>
            </tr>


          </table>

          {!!$tabla_dinamica2!!}

          <table class="tabla-1">

            <tr>
              <td colspan="3" style="border-bottom: 4px solid #882439;"><p style="color: #131313; text-transform: uppercase; font-size: 18px;">Contáctanos</p></td><br>
            </tr>

            <tr>
              <th style="width: 33%; padding: 10px 0px;"></th>
              <th style="width: 33%;padding: 10px 0px;">Llámanos</th>
              <th style="width: 33%; padding: 10px 0px;"></th>
            </tr>
            <tr>
              <td style="width: 33%;padding: 10px 0px;"></td>
              <td style="width: 33%; padding: 10px 0px;"><i class="fa" style="font-style: normal;">&#xf095;</i> (556) 141 6018</td>
              <td style="width: 33%;padding: 10px 0px;"></td>
            </tr>

            <tr>
              <th style="width: 33%; padding: 10px 0px;">Redes Sociales</th>
              <th style="width: 33%; padding: 10px 0px;">Página Web</th>
              <th style="width: 33%; padding: 10px 0px;">E-mail</th>
            </tr>

            <tr>
              <td style="width: 33%; padding: 10px 0px;">Facebook: <a href="https://es-la.facebook.com/panamotorspremiumoficial/" target="_blank" style="color: #882439;">Panamotors Premium Oficial</a></td>
              <td padding: 10px 0px;><a href="https://www.panamotorscenter.com/" target="_blank" style="color: #882439;">https://www.panamotorscenter.com/</a>  </td>
              <td>
                <a href="mailto:ventas@panamotorscenter.com" style="color: #882439;">ventas@panamotorscenter.com</a>
              </td>
            </tr>

            <tr>
              <td style="width: 33%; padding: 10px 0px;">Instagram: <a href="https://www.instagram.com/panamotorspremiumoficial/" target="_blank" style="color: #882439;">@panamotorspremiumoficial</a></td>
              <td padding: 10px 0px;><a href="https://www.grupopanamotors.com/" target="_blank" style="color: #882439;">https://www.grupopanamotors.com/</a> </td>
            </tr>

            <tr>
              <td style="width: 33%; padding: 10px 0px;">Youtube: <a href="https://www.youtube.com/channel/UCzAjbTQf-kPCQu2rOLllcWA" target="_blank" style="color: #882439;">Panamotors Premium Oficial</a></td>
            </tr>


          </table>

          <div style="margin-top: 5px;">
            <a target="_blank" href="https://www.panamotorscenter.com/iniciar-form.php" ><img src="{{secure_asset('storage/app/mercadotecnia/baner_finaciado.png')}}" alt="" style="width:100%;height:auto;"></a>
          </div>

          <div style="margin-top: 5px;">
            <img src="{{secure_asset('storage/app/mercadotecnia/footer_grupos.png')}}" alt="">
          </div>
        </div>
      </div>

    </div>
    <!--fin-content-tabla-2-->

    <!--<br><div class="content-datos-obs"><br>-->
    <!--<p class="text-datos-obs" align="center">______________________________________________</p>-->
    <!-- <p class="text-datos-obs" align="center">'.$responsable_equipo.'<br>Firma de solicitud.</p>-->
    <!--</div>  -->




    <!--table-entrega-->
    <!--<div class="content-datos-obs">
    <p class="text-datos-obs" style="color: black;"><img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">1 de {nb}</p>
  </div>-->
  <!--fin-table-entrega-->


</div>


</body>
</html>
