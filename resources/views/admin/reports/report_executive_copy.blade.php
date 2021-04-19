<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PANAMOTORS | Reporte Mensual de Ventas</title>
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

		<!--pedido-->
		<div class="content-pedido">
			<br><br>
			<table class="tabla-datos-facturar">
				<tr>
					<td style="width: 100px;">
						<p class="titulo-datos-facturar">Periodo:</p>
					</td>
					<td style="width: 157px;">
						<p class="text-datos-facturar">{{$fecha_i}} a {{$fecha_f}}</p>
					</td>
				</tr>
			</table>
		</div>
		<!--fin-pedido-->
		<br>
		<!--table-fecha-->
		<div class="content-fecha" style="margin-top:5px;">
			<table class="tabla-fecha">
				<tr>
					<td></td>
					<td>{{$fecha_impresion->format('d')}}</td>
					<td>{{$mes}}</td>
					<td>{{$fecha_impresion->format('Y')}}</td>
					<td>{{$fecha_impresion->format('h:m:s')}}</td>
				</tr>
				<tr>
					<th>FECHA IMPRESIÓN</th>
					<th>DÍA</th>
					<th>MES</th>
					<th>AÑO</th>
					<th>HORA</th>
				</tr>
			</table>
		</div>
		<!--fin-table-fecha-->
		<br>
		<br>
		<br>
		<table class="tablax tablaxdprincipales">
            @foreach($tabla_unidades as $key => $value)
                <tr>
                    <th colspan="4">Unidades pagadas {{$key}}</th>
                </tr>

                <tr>
                    <td colspan="2"><b>Unidades: </b> {{$tabla_unidades->$key->total_unidades_pagadas}}</td>
                    <td colspan="2"><b>Monto: </b> ${{number_format((float)$tabla_unidades->$key->total_monto_pagadas,2)}}</td>
                </tr>

                <tr><td colspan="4"></td></tr>
                <tr><td colspan="4"></td></tr>
                <tr><td colspan="4"></td></tr>

                <tr>
                    <td><br><b>Directas: </b>{{$tabla_unidades->$key->pagadas[0]['directas']}}</td>
                    <td><br><b>Monto Directas: </b> $ {{number_format($tabla_unidades->$key->pagadas[0]['monto_directas'],2)}}</td>
                    <td><br><b>Cuenta de deuda: </b> {{$tabla_unidades->$key->pagadas[0]['cuenta_deuda']}}</td>
                    <td><br><b>Monto Cuenta de deuda: </b>$ {{number_format($tabla_unidades->$key->pagadas[0]['monto_cuenta_deuda'],2)}}</td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="1" style="text-align:center;"><br><b style="margin-left:-50px;" >Devoluci&oacute;n del VIN: </b> {{$tabla_unidades->$key->pagadas[0]['devolucion_vin']}}</td>
                    <td colspan="2" style="text-align:left;"><br><b style="margin-left:50px;">Monto Devoluci&oacute;n del VIN: </b>$ {{number_format($tabla_unidades->$key->pagadas[0]['monto_devolucion_vin'],2)}}</td>
                </tr>
            @endforeach
		</table>
		<br>
		<br>

		<table class="tablax tablaxdprincipales">
			<tr>
				<th colspan="4">Documentos por pagar</th>
			</tr>

			<tr>
				<td colspan="2"><b>Doc. por pagar: </b>{{$tabla_movimientos->num_documentos_pendientes}}</td>
				<td colspan="2"><b>Total Doc. por pagar: </b> $ {{number_format($tabla_movimientos->monto_documentos_pendientes,2)}}</td>
			</tr>

			<tr><td colspan="4"></td></tr>
			<tr><td colspan="4"></td></tr>
			<tr><td colspan="4"></td></tr>
			<tr>
				<td><b>Doc. por pagar virtuales: </b> {{$tabla_movimientos->num_virtuales_pendientes}}</td>
				<td><b>Monto virtuales: </b>$ {{number_format($tabla_movimientos->monto_virtuales_pendientes,2)}}</td>
				<td><b>Doc. por pagar f&iacute;sicos: </b>{{$tabla_movimientos->num_fisicos_pendientes}}</td>
				<td><b>Monto f&iacute;sicos: </b>$ {{number_format($tabla_movimientos->monto_fisicos_pendientes,2)}}</td>
			</tr>

			<tr>
				<td colspan="4"><b>Promedio por pagare: </b> @if($tabla_movimientos->monto_documentos_pendientes > 0)$ {{number_format($tabla_movimientos->monto_documentos_pendientes/$tabla_movimientos->num_documentos_pendientes,2)}}@else $ 0.00 @endif</td>
			</tr>

		</table>
		<br>
		<br>
		<!-- <table class="tablax tablaxdprincipales">
			<tr>
				<th colspan="4">Ingresos</th>
			</tr>

			<tr>
				<td colspan="2"><b>Ingresos Totales: </b>   </td>
				<td colspan="2">$ '.number_format($suma_abonos2 + $suma_abonos3,2).'</td>
			</tr>

			<tr>
				<td colspan="2"><b>Ingreso Monetario: </b>   </td>
				<td colspan="2">$ '.number_format($suma_abonos2,2).'</td>
			</tr>

			<tr>
				<td colspan="2"><b>Ingreso Especie: </b>   </td>
				<td colspan="2">$ '.number_format($suma_abonos3,2).'</td>
			</tr>

			<tr>
				<td colspan="2"><b>Credito Otorgado</b></td>
				<td colspan="2">$ '.number_format($suma_total_ventas - $suma_total_abonos,2).'</td>
			</tr>
		</table>

		<br>
		<!-- <br>
		<table class="tablax tablaxdprincipales" style="font-size:9px !important;">
			<tr>
				<th colspan="10">Detalle Ventas</th>
			</tr>
			<tr>
				<td><b>Fecha Movimiento</b></td>
				<td><b>Contacto</b></td>
				<td><b>VIN</b></td>
				<td><b>Marca</b></td>
				<td><b>Version</b></td>
				<td><b>Modelo</b></td>
				<td><b>Color</b></td>
				<td><b>Venta</b></td>
				<td><b>Costo</b></td>
				<td><b>Utilidad</b></td>
			</tr>
			'.$detalle_ventas.'

		</table>

		<br>
		<br>
		</pagebreak>

		<table class="tablax tablaxdprincipales">
			<tr>
				<th colspan="4">Utilidad</th>
			</tr>

			<tr>
				<td colspan="2"><b>Utilidad: </b></td>
				<td colspan="2">$ '.number_format($suma_utilidad,2).'</td>
			</tr>

			<tr>
				<td colspan="2"><b>Promedio utilidad: </b></td>
				<td colspan="2">$ '.number_format($suma_utilidad/$numero_ventas,2).'</td>
			</tr>

		</table>
		<br>
		<br> -->
		<table class="tablax tablaxdprincipales" style="font-size:8px !important; border-spacing:0; border-collapse:collapse;">
			<tr>
				<th colspan="8">Detalle Compras</th>
			</tr>
			<tr class="tr-detalles-titulo" style="font-size:14px;">
				<td>Fecha</td>
				<td>Proveedor</td>
				<td style="width: 136px;">Informaci&oacute;n</td>
				<td class="documentos">Pagados</td>
				<td class="documentos">Pendientes</td>
				<td class="cantidad">Cargos</td>
				<td class="cantidad">Abonos</td>
				<td class="cantidad">Saldo</td>

			</tr>
			@foreach($tabla_movimientos->tabla as $key => $row)
			<tr class="tr-detalles">
				<td>
					<p>{{$row['fecha']}}</p>
				</td>
				<td>
					@if($row['proveedor'] != '')
					@foreach($row['proveedor'] as $value)
					<p>{!!$value!!}</p>
					@endforeach
					@endif
				</td>
				<td>
					@if($row['datos'] != '')
					@foreach($row['datos'] as $value)
					<p>{!!$value!!}</p>
					@endforeach
					@endif
					<br>
					@if($row['informacion'] != '')
					@foreach($row['informacion'] as $value)
					<p>{!!$value!!}</p>
					@endforeach
					@endif
				</td>
				<td>
					@if($row['documentos'] != '')
					@foreach($row['documentos'] as $value)
					<p>{!!$value!!}</p>
					@endforeach
					@endif

				</td>
				<td>
					@if($row['documentos_pendientes'] != '')
					@foreach($row['documentos_pendientes'] as $value)
					<p>{!!$value!!}</p>
					@endforeach
					@endif

				</td>
				<td class="cantidad">$ {{$row['cargos']}}</td>
				<td class="cantidad">$ {{$row['abonos']}}</td>
				<td class="cantidad">{{$row['saldo']}}</td>
			</tr>
			@endforeach
		</table>


		<br>
		<br>



</body>
</html>
