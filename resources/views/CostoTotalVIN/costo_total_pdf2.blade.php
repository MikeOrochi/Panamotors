<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title></title>
  <style type="text/css">
  body{
    font-family: "geometric" !important;
  }


  .img_header{
    margin: -30px 0 0 0;
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
  hr{
    padding: 0px;
  }

  .tabla-fecha {
    border-collapse: collapse;
    width: 100%;
    margin: 0px 0 0 0;
    font-size: 9px;
    page-break-inside: avoid;
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
    margin: 0px;
    height: 100px;
    display: block;
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
    padding: 0px;
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
    font-size: 7px;
    height: 15px;
    display: block;
    color:gray;
    text-align: right;
    margin-top: -40px;
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
    margin: -10px 0 0 0;
    font-size: 12px;
    /* background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png); */
    background-repeat: no-repeat;
    background-position: center;
    border-collapse: none;
  }

  .tabla-1 td {
    padding: 3px;
    text-align: center;
  }
  .tabla-1 td.tfondo{
    background: linear-gradient(0deg,#c3c7cc,#ffffff,#c3c7cc);
    color: #212121;
  }

  .tabla-1 th {
    font-size: 10px;
    padding: 3px;
    text-align: center;
    background: linear-gradient(0deg,#882439,#A51D3A,#882439);
    color: #fff;
    border-right: 1px solid #fff;
  }

  .tabla-1 tr:nth-child(even) {
    border: none;
    padding: 3px;
    text-align: center;
  }

  .tabla2 tr td{
    padding: 5px;
  }


  /* Tabla 1-1*/

  .tabla-1-1 {
    border: 1px solid #dddddd;
    border-collapse: collapse;
    width: 100%;
    margin: -10px 0 0 0;
    font-size: 11px;
    /* background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png); */
    background-repeat: no-repeat;
    background-position: center;
  }

  .tabla-1-1 td {
    border: 1px solid #dddddd;
    border-collapse: collapse;
    padding: 0px;
    text-align: center;
    font-size: 11px;
  }

  .tabla-1-1 th {
    border: 1px solid #dddddd;
    border-collapse: collapse;
    font-size: 11px;
    padding: 0px;
    text-align: center;
  }


  .tabla-1-1 tr:nth-child(even) {
    border: 1px solid #dddddd;
    border-collapse: collapse;
    font-size: 11px;
    padding: 0px;
    text-align: center;
  }

  .tabla-2 {
    border-collapse: collapse;
    width: 100%;
    margin: 20px 0 30px 0;
    font-size: 10px;
  }

  .tabla-2 td, .tabla-2 th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
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
  .tablax {

    width: 100%;
    margin: -10px 0 0 0;
    font-size: 12px;
    /* background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png); */
    background-repeat: no-repeat;
    background-position: center;
  }

  .tablax td {
    text-align: center;
  }

  .tablax th {
    text-align: center;

  }

  .tablax-1 tr:nth-child(even) {
    margin-bottom:20px;
  }
  .tablaxdprincipales th{
    border-bottom: 2px solid #882439;
  }



  .tablax2 {
    margin:5px,5px;
    padding:10px;
    width: 100%;
    margin: -10px 0 0 0;
    font-size: 8px;
    /* background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png); */
    background-repeat: no-repeat;
    background-position: center;
  }

  .tablax2 td {
    text-align: center;
  }

  .tablax2 th {
    text-align: center;

  }

  #centro {
    text-align center;
  }
  tr.tr-detalles-titulo td {
    font-size:12px;
    text-align: left;
    border: 1px solid #dddddd;
    padding: 8px;
  }
  tr.tr-detalles td {
    font-size:9px;
    text-align: left;
    border: 1px solid #dddddd;
    padding: 8px;
  }
  .cantidad{
    width: 75px;
  }
  .documentos{
    width: 100px;
  }

  .parrafo{
    /* font-size:12px; */
    margin-left:5%;
    margin-right: 5%;
    margin-bottom: 5px;
    /* text-align: justify; */
  }
  span {
    /* background-color: green; */
    /* word-wrap: normal; */
    /* white-space:nowrap; */
    /* word-break: keep-all; */
  }
  </style>
</head>
<body style=" margin: 0; background-image: url({{asset('public/img/mpdf/fondo_opacity.png')}});
background-repeat: no-repeat; background-position: center;">

<div class="container" style="padding:top:30px;">


  <div class="content-pedido">
    <table class="tabla-datos-facturar">
      <tr>
        <td width="400px"><p class="numOrden">VIN # {{$vin}}</p></td>
      </tr>
    </table>
  </div>
  <!--*********************************************************************************************************************-->
  <div class="content-fecha">
    <table class="tabla-fecha">
      <tr>
        <td></td>
        <td>{{$day}}</td>
        <td>{{$month}}</td>
        <td>{{$year}}</td>
        <td>{{$hour}}</td>
      </tr>
      <tr><th>FECHA DE IMPRESIÓN:</th>
        <th>DÍA</th>
        <th>MES</th>
        <th>AÑO</th>
        <th>HORA</th>
      </tr>
    </table>
  </div>
  <!--*********************************************************************************************************************-->
  <div class="both"></div>
  <table class="tabla-datos">
    <tr><td style="font-size: 11px;">Estatus: {{$estatus}}</td></tr>
    <tr><td style="font-size:11px;">Fecha de Inicio: {{$fecha}}</td></tr>

    @if ($EstadoCuenta->monto_precio != "")
        <tr>
          <td style="font-size:11px;">
            Precio de Venta: ${{number_format($EstadoCuenta->monto_precio,2) ." / ". $EstadoCuenta->nombre_cliente}}
          </td>
        </tr>
      @else
        <tr>
          <td style="font-size:11px;">
            Precio de Venta: N/A
          </td>
        </tr>
    @endif

    <tr><td style="font-size:11px;">Fecha de Venta: {{\Carbon\Carbon::parse($EstadoCuenta->fecha_movimiento)->format('d-m-Y')}}</td></tr>
    <tr><td style="font-size:11px;">Días en Inventario: {{floor(abs(strtotime($EstadoCuenta->fecha_movimiento)-strtotime($fecha))/(60*60*24))}}</td></tr>
  </table>
  <!--*********************************************************************************************************************-->
  <div class="both"><br><br></div>
  <table class="tabla-1">
    <tr>
      <th colspan ="4" style="text-align: center;"><b>DATOS DEL VIN</b></th>
    </tr>
    <tr>
      <td style="text-align:right;"><b>VIN:</b></td>
      <td style="text-align:left;">{{$vin}}</td>
      <td style="text-align:right;"><b>Modelo:</b></td>
      <td style="text-align:left;">$modelo</td>
    </tr>
    <tr>
      <td style="text-align:right;"><b>Marca:</b></td>
      <td style="text-align:left;">$marca</td>
      <td style="text-align:right;"><b>Color:</b></td>
      <td style="text-align:left;">$color</td>
    </tr>
    <tr>
      <td colspan = "1"  style="text-align:right;"><b>Version:</b></td>
      <td colspan = "3" style="text-align:left;">$version</td>
    </tr>
  </table>
  <!--*********************************************************************************************************************-->
  <div class="both"><br><br></div>
  <table width="100%" class="tabla-1">
    <tbody>
      <tr>
        <th><center>#</center></th>
        <th><center>Fecha</center></th>
        <th><center>Concepto</center></th>
        <th><center>Departamento</center></th>
        <th><center>Tipo</center></th>
        <th width="50px"><center>No. de Referencia</center></th>
        <th><center>Proveedor</center></th>
        <th><center>Monto</center></th>
        <th><center>Tipo</center></th>
        <th><center>Estatus</center></th>
      </tr>$contenido_tabla
    </tbody>
  </table>



  <!--*********************************************************************************************************************-->
  <div class="both"><br><br></div>

  <table class="tabla-1">

    <tr>
      <th colspan ="4" style="text-align: center;"><b>COSTO TOTAL DEL VIN</b></th>
    </tr>

    <tr>
      <td colspan ="2" style="text-align:center;"><b>Departamento</b></td>
      <td  style="text-align:center;"><b>Cantidad</b></td>
      <td style="text-align:center;" width="150px"><b>Monto</b></td>
    </tr>
    $tabla2


  </table>
  <!--*********************************************************************************************************************-->



</body>
</html>
