<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <?xml version="1.0" encoding="UTF-8"?>
   <title>PANAMOTORS | Recibo</title>
   <style type="text/css">
      body{
         margin: 0;
         font-family: "geometric" !important;
      }
      p.text-datos-obs {
         font-size: 10px;
         height: 18px;
         display: block;
         color:gray;
         text-align: right;
         margin-top: -40px;
      }
      .tit1{
         font-size: 12px;
      }
      .tit2{
         font-size: 10px;
      }
      .text-blanco{
         color: #fff;
      }
      .text-vino{
         color: #882439;
      }
      .text-derechos{
         line-height: 2px;
         text-align: center;
      }
      .text-dato-base{
         text-align: left;
         color: #4E4043;
      }
      .tabla-1{
         width: 100%;
         /* border-top: 2px solid #cdcdcd;
         border-bottom: 2px solid #cdcdcd; */
         border: 2px solid #cdcdcd;
         border-collapse: none;
      }
      .tabla-1 tr td{
         padding: 10px;
      }
      .tabla-1 tr:nth-child(even){
         background: #F3F3F3;
      }
      .c-dato-personal h6{
         line-height: 5px;
         font-size: 12px;
      }
      .m-t-100{
         margin-top: 100px;
      }
   </style>
</head>
<body>


<div style="width: 100%;">
   <br>
   <br>
   <div class="c-dato-personal" style="width: 55%; float: left;">
      <h6 class="tit1" style="width: 100%;">
         <div style="width: 16%; float: left; text-align: right; padding-right: 5px;">ID: </div>
         <div style="width: 75%; float: left; font-weight: normal; color: #616161;">
            @if(!empty($proveedor->idproveedores)){{$proveedor->idproveedores}}@else
            {{"Sin ID"}}@endif
         </div>
      </h6>
      <h6 class="tit1" style="width: 100%;">
         <div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Nombre: </div>
         <div style="width: 75%; float: left; font-weight: normal; color: #616161;">
            @if(!empty($proveedor->nombre)){{$proveedor->nombre." "}}@endif
            @if(!empty($proveedor->apellidos)){{$proveedor->apellidos}}@endif
         </div>
      </h6>
      <h6 class="tit1" style="width: 100%;">
         <div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Calle: </div>
         <div style="width: 75%; float: left; font-weight: normal; color: #616161;">@if(!empty($proveedor->calle)){{$proveedor->calle}}@else {{"N/A"}}@endif</div>
      </h6>
      <h6 class="tit1" style="width: 100%;">
         <div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Colonia: </div>
         <div style="width: 75%; float: left; font-weight: normal; color: #616161;">@if(!empty($proveedor->colonia)){{$proveedor->colonia}}@else{{"N/A"}} @endif</div>
      </h6>
      <h6 class="tit1" style="width: 100%;">
         <div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Municipio: </div>
         <div style="width: 75%; float: left; font-weight: normal; color: #616161;">@if(!empty($proveedor->delmuni)){{$proveedor->delmuni}}@else {{"N/A"}}@endif</div>
      </h6>
      <h6 class="tit1" style="width: 100%;">
         <div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Estado: </div>
         <div style="width: 75%; float: left; font-weight: normal; color: #616161;">@if(!empty($proveedor->estado)){{$proveedor->estado}}@else{{"N/A"}}@endif</div>
      </h6>
   </div>
   <div style="width: 45%; float: left;">
      <h6 class="tit1" style="text-align: right;">Fecha: <span style="color: #616161;">@if(!empty($fecha_recibo_encabezado)){{$fecha_recibo_encabezado}}@else{{"Sin fecha"}}@endif</span></h6>
      <h6 class="tit1" style="text-align: right;">Recibo: <span style="color: #616161;">@if(!empty($id_generic_voucher)){{$id_generic_voucher}}@else{{"Sin ID"}}@endif</span></h6>
   </div>
</div>

<div style="margin-top: 20px;">
   <table class="tabla-1">
      <tr>
         <td class="tit1" style="width: 33%; background: #ECECEC;"><b>Movimiento</b></td>
         <td class="tit1" style="width: 33%; background: #ECECEC;"><b>Forma de pago</b></td>
         <td class="tit1" style="width: 33%; background: #ECECEC;"><b>Tipo de cambio</b></td>
      </tr>
      <tr>
         <td class="tit1">@if(!empty($recibo->concepto)){{$recibo->concepto}}@else{{"Sin concepto"}} @endif</td>
         <td class="tit1">@if(!empty($metodo_pago)){{$metodo_pago->nombre}}@else{{"Sin registro"}}@endif</td>
         <td class="tit1">@if(!empty($recibo->tipo_cambio)){{$recibo->tipo_cambio}}@else{{"Sin tipo de cambio"}}@endif</td>
      </tr>
   </table>
</div>

<div style="margin-top: 20px;">
   <table class="tabla-1">
      <tr>
         <td class="tit1" style="width: 20%;">TOTAL: </td>
         <td class="tit1 text-dato-base" style="width: 80%;">$@if(!empty($total)){{$total}}@else{{"0.00"}}@endif</td>
      </tr>
      <tr>
         <td></td>
         <td class="tit1">@if(!empty($total_text)){{$total_text}}@else{{"CERO PESOS 00/100 M.N"}}@endif</td>
      </tr>
   </table>
</div>

<div style="margin-top: 20px;">
   <p class="tit1">Recibido por: <span style="color: #616161;">@if(!empty($nombre_usuario)){{$nombre_usuario}}@else{{"Sin receptor"}}@endif</span></p>
   <p style="font-size: 12px; margin-top: 20px;">Fecha impresión: <span style="color: #616161;">@if(!empty($string_fecha)){{$string_fecha}}@else{{'Error al obtener fecha'}}@endif</span></p>
</div>

<div style="margin-top: 120px;">

</div>

</body>
</html>
