<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PANAMOTORS | Recibo QR</title>
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
  </style>
</head>
<body style=" margin: 0; background-image: url({{asset('public/img/mpdf/fondo_opacity.png')}}); background-repeat: no-repeat; background-position: center;">
  <div class="container">

    <br>
    <br>

  </div>


</body>
</html>
