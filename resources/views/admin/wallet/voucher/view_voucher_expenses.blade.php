<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
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
      /* // border-top: 2px solid #cdcdcd; */
      /* // border-bottom: 2px solid #cdcdcd; */
      border: 2px solid #cdcdcd;
      border-collapse: none;
   }
   .tabla-1 tr td{
      padding: 10px;
   }
   .tabla-1 tr:nth-child(even){
      background: #F3F3F3;
   }
</style>
</head>
<body>
   <div>
      <br>
      <br>
   </div>
   <div style="width: 100%;">
      <div style="width: 70%; float: left;">
         <h6 class="tit1">Transferencia realizada por: <span style="color: #616161;">@if(!empty($nombre_completo)){{$nombre_completo}}@else{{'N/A'}}@endif</span></h6>
      </div>
      <div style="width: 29%; float: left;">
         <h6 class="tit1">Fecha: <span style="color: #616161;">@if(!empty($fecha)){{$fecha}}@else{{'N/A'}}@endif</span></h6>
         <h6 class="tit1">Hora: <span style="color: #616161;">@if(!empty($hora)){{$hora}}@else{{'N/A'}}@endif</span></h6>
      </div>
   </div>
   <div>
      <h1 class="tit1">@if(!empty($modo_pago)){{$modo_pago}}@else{{'N/A'}}@endif <span style="color: #616161;">@if(!empty($comprobante_transferencia->tipo_pago)){{$comprobante_transferencia->tipo_pago}}@else{{'N/A'}}@endif</span></h1>
   </div>
   <div style="padding: 0px 30px; background: #39CA74;">
      <h1 class="tit1" style="font-weight: normal; color: #fff;">Tu transferencia ha sido recibido con número de instrucción #@if(!empty($comprobante_transferencia->folio)){{$comprobante_transferencia->folio}}@else{{'N/A'}}@endif</h1>
   </div>
   <div style="margin-top: 20px;">
      <table class="tabla-1">
         <tr>
            <td class="tit1" colspan="1" rowspan="6" style="width: 30%; border-right: 2px solid #cdcdcd; background: #ECECEC;"><b>Cuentas</b></td>
            <td class="tit1" colspan="2" style="width: 69%;">Cuenta retiro</td>
         </tr>
         <tr>
            <td class="tit1" colspan="2">@if(!empty($comprobante_transferencia->emisora_institucion)){{$comprobante_transferencia->emisora_institucion}}@else{{'N/A'}}@endif</td>
         </tr>
         <tr>
            <td class="tit1" colspan="2">@if(!empty($comprobante_transferencia->emisora_agente)){{$comprobante_transferencia->emisora_agente}}@else {{'N/A'}}@endif</td>
         </tr>
         <tr>
            <td class="tit1" colspan="2">Cuenta depósito o beneficiario</td>
         </tr>
         <tr>
            <td class="tit1" colspan="2">@if(!empty($comprobante_transferencia->id)){{$comprobante_transferencia->id}}@else{{'N/A'}}@endif</td>
         </tr>
         <tr>
            <td class="tit1" style="width: 34.5%;">Nombre: </td>
            <td class="tit1 text-dato-base" style="width: 34.5%;">@if(!empty($nombre_receptor)){{$nombre_receptor}}@else{{'N/A'}}@endif</td>
         </tr>
      </table>
   </div>
   <div style="margin-top: 20px;">
      <table class="tabla-1">
         <tr>
            <td class="tit1" colspan="1" rowspan="5" style="width: 30%; border-right: 2px solid #cdcdcd; background: #ECECEC;"><b>Datos del movimiento</b></td>
            <td class="tit1" colspan="1" style="width: 34.5%;">Monto</td>
            <td class="tit1 text-dato-base" colspan="1" style="width: 34.5%;">@if(!empty($comprobante_transferencia->monto_entrada) && !empty($comprobante_transferencia->tipo_moneda))${{number_format($comprobante_transferencia->monto_entrada,2).' '.$comprobante_transferencia->tipo_moneda}}@else{{'N/A'}}@endif</td>
         </tr>
         <tr>
            <td class="tit1">Tipo de beneficiario: </td>
            <td class="tit1 text-dato-base">@if(!empty($comprobante_transferencia->tipo_id)){{$comprobante_transferencia->tipo_id}}@else{{'N/A'}}@endif</td>
         </tr>
         <tr>
            <td class="tit1">Referencia: </td>
            <td class="tit1 text-dato-base">@if(!empty($comprobante_transferencia->referencia)){{$comprobante_transferencia->referencia}}@else{{'N/A'}}@endif</td>
         </tr>
         <tr>
            <td class="tit1">Concepto de pago: </td>
            <td class="tit1 text-dato-base">@if(!empty($conceptos)){{$conceptos}}@else{{'N/A'}}@endif</td>
         </tr>
         <tr>
            <td class="tit1">Plazo: </td>
            <td class="tit1 text-dato-base">Mismo día</td>
         </tr>
      </table>
   </div>
   <div style="margin-top: 20px;">
      <p class="tit2" style="text-align: center; color: #836C71;">Este documento es de carácter informativo, no tiene validez como comprobante fiscal</p>
   </div>

</body>
</html>
