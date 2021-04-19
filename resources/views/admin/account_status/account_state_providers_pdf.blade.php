<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>{{$id_contacto_completo.' '.$nombre.' '.$apellidos}}</title>
	<style type="text/css">
		.img_header{
			margin: -30px 0 0 0;
		}
		.img_footer{
			margin: 500px 0 0 0;
		}
		.content-pedido{
			width:50%;
			display:block;
			float:left;
			padding: 10px 0px 0 0;
		}
		/*Start fecha*/
		.content-fecha{
			width:50%;
			display:block;
			float:right;
			padding: 10px 0 0 0;
		}
		.tabla-fecha {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
			margin: 0px 0 0 0;
			font-size: 10px;
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
		/*End fecha*/
		.both{
			clear: both;
		}
		.pleca-margin-top{

		}
		.container{
			width: 1024px;
			height: 100%;
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
		/* p.titulo-datos-facturar-titulo{
			font-size: 10px;
			font-weight: bold;
			font-family: Arial;
			height: 18px;
			display: block;
			padding:0 0px -10px 0;
		} */
		p.titulo-datos-facturar {
			font-size: 10px;
			font-weight: bold;
			font-family: Arial;
			display: block;
			text-align: right;
			padding:0 0px 0px 0;
		}
		p.text-datos-facturar {
			font-size: 10px;
			font-family: Arial;
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
			font-family: Arial;
			height: 18px;
			display: block;
			padding:0 20px 0 0;
		}
		p.text-datos-obs {
			font-size: 10px;
			font-family: Arial;
			height: 18px;
			display: block;
			color:gray;
		}
		p.titulo-datos {
			font-size: 10px;
			font-weight: bold;
			font-family: Arial;
			display: block;
			text-align: right;
			padding:0 20px 0 0;
		}
		p.text-datos {
			font-size: 10px;
			font-family: Arial;
			display: block;
		}
		.tabla-datos td, .tabla-datos th {
			padding: 8px;
		}
		/* Tabla 1*/
		.tabla-1 {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
			margin: -10px 0 0 0;
			font-size: 9px;
			autosize:0;
		}
		.tabla-1 td, .tabla-1 th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
			//text-align: center;
		}
		.tabla-1 tr:nth-child(even) {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
			text-align: center;
		}
		.tabla-2 {
			font-family: arial, sans-serif;
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
			font-family: arial, sans-serif;
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
			font-family: Arial;
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
			font-family: Arial;
			display: block;
			text-align: center;
			padding:0 0px 0px 0;
			color:#3f0f2d;
		}
		.titulos-total-final-text{
			font-size: 14px;
			font-weight: bold;
			font-family: Arial;
			display: block;
			text-align: center;
			padding:0 0px 0px 0;
		}
		p.titulo-datos-total {
			font-size: 10px;
			font-weight: bold;
			font-family: Arial;
			display: block;
			text-align: right;
			padding:0 0px 0px 0;
		}
		p.text-datos-total {
			font-size: 10px;
			font-family: Arial;
			display: block;
		}

		.tabla-datos-total td, .tabla-datos-total th {
			padding: 8px;
		}
		.estatus-abono-positivo{
			background-color: transparent;
			color: black;
		}
		.estatus-abono-negativo{
			background-color: transparent;
			color: black;
		}
		.estatus-abono-neutro{
			background-color: transparent;
			color: black;
		}
		.datos-textos-grande{
			text-align: right;
		}
		table { page-break-inside:auto }
		tr    { page-break-inside:avoid; page-break-after:auto }
		thead { display:table-header-group }
		tfoot { display:table-footer-group }
		table.tabla-1 td{
			font-size: 8.5px;
			/* line-height: 13px; */
		}
		.abonos, .cargos, .saldo{
			width: 80px;
		}
</style>
</head>
<body style=" margin: 0; background-image: url({{asset('public/img/mpdf/fondo_opacity.png')}}); background-repeat: no-repeat; background-position: center;">
<!-- <body style=" margin: 0; background:linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url({{asset('public/img/mpdf/fondo.png')}}) no-repeat 0 50%;"> -->
	<div class="container">
		<!--pedido-->
		<div class="content-pedido">
			<table class="tabla-datos-facturar">
				<tr>
					<td style="width: 20px;">
						<p class="titulo-datos-facturar">ID:</p>
					</td>
					<td style="width: 257px;">
						<p class="text-datos-facturar">@if(!empty($id_contacto_completo)){{$tipo_cliente.' '.$id_contacto_completo}}@else N/A @endif</p>
					</td>
				</tr>
			</table>
		</div>
		<!--fin-pedido-->
		<!--table-fecha-->
		<div class="content-fecha">
			<table class="tabla-fecha">
				<tr>
					<td></td>
					<td>@if(!empty($dia)){{$dia}}@else N/A @endif</td>
					<td>@if(!empty($mes)){{$mes}}@else N/A @endif</td>
					<td>@if(!empty($ano)){{$ano}}@else N/A @endif</td>
					<td>{{$hora}}</td>
				</tr>
				<tr>
					<th>Fecha corte:</th>
					<th>D&iacute;a</th>
					<th>Mes</th>
					<th>Año</th>
					<th>Hora</th>
				</tr>
			</table>
		</div>
		<!--fin-table-fecha-->
		<div class="both"></div>
		<!--pleca-->
		<div class="header">
			<img src="{{asset('public/img/mpdf/pleca.png')}}" alt="">
		</div>
		<!--fin-pleca-->
		<div class="content-facturar" style="margin-bottom:25px;">
			<table class="tabla-datos-facturar" autosize="1">
				<tr>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Nombre:</p></td>
					<td style="width: 207px;@if(!empty($nombre)) text-transform:capitalize;@endif"><p class="text-datos-facturar">@if(!empty($nombre)){{$nombre}}@else{{'N/A'}}@endif</p></td>

				</tr>
				<tr>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Apellido(s)</p></td>
					<td style="width: 207px; @if(!empty($apellidos)) text-transform:capitalize;@endif"><p class="text-datos-facturar">@if(!empty($apellidos)){{$apellidos}}@else{{'N/A'}}@endif</p></td>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Total cargos:</p></td>
					<td style="width: auto; text-align:right;">
						<p class="text-datos-facturar">
							@if(!empty($tabla_movimientos->cargos)){{number_format($tabla_movimientos->cargos,2)}}@else{{'0.00'}}@endif
						</p>
					</td>
					<td style="width: 80px;; text-align:left;">
						<p class="text-datos-facturar">
							@if(!empty($num_unidades))({{$num_unidades}}@else{{'(0 '}}@endif {{($num_unidades == 1)? 'unidad':'unidades'}})
						</p>
					</td>
				</tr>
				<tr>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Alias:</p></td>
					<td style="width: 207px;"><p class="text-datos-facturar">@if(!empty($alias)){{$alias}}@else{{'N/A'}}@endif</p></td>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Total abonos:</p></td>
					<td style="width: auto; text-align:right;"><p class="text-datos-facturar">@if(!empty($tabla_movimientos->abonos)){{number_format($tabla_movimientos->abonos,2)}}@else{{'0.00'}}@endif</p></td>
				</tr>
				<tr>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Tel&eacute;fono(s):</p></td>
					<td style="width: 207px;"><p class="text-datos-facturar">
						@if(!empty($telefono1) && !empty($telefono2)){{$telefono1.' / '.$telefono2}}
						@elseif(!empty($telefono1) && empty($telefono2)){{$telefono1}}
						@elseif(empty($telefono1) && !empty($telefono2)){{$telefono2}}
						@elseif(empty($telefono1) && empty($telefono2)){{'N/A'}}@endif
					</p></td>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Saldo: </p></td>
					<td style="width: auto; text-align:right;"><p class="text-datos-facturar">{{number_format((float)$tabla_movimientos->cargos - (float)$tabla_movimientos->abonos,2)}}</p></td>
				</tr>

				<tr>
					<td style="width: 136px; text-align:right;"><p class="titulo-datos-facturar">Domicilio:</p></td>
					<td style="width: 207px; text-transform:capitalize"><p class="text-datos-facturar">@if(!empty($domicilio_completo)){{$domicilio_completo}}@else{{'N/A'}}@endif</p></td>

				</tr>
			</table>
		</div>
		<!--fin-content-->
		<br>
		<div class="invisible"></div>
		<!--<div>-->
		<table class="tabla-1">
			<tr>
				<th>#</th>
				<th>Fecha</th>
				<th>Concepto</th>
				<th style="width: 136px;">Datos</th>
				<th>Informaci&oacute;n</th>
				@if($pdf_type=="reporte_compras_directas_proveedores")
				<th>Deuda</th>
				<th>Saldo</th>
				@else
				<th class="cargos">Cargos</th>
				<th class="abonos">Abonos</th>
				<th class="saldo">Saldo</th>
				@endif

			</tr>
			{!!$tabla_movimientos->tabla!!}
			{{----@foreach($tabla_movimientos->tabla as $key => $row)
				<tr >
					<td>{{$key+1}}</td>
					<td>{{$row['fecha']}}</td>
					<td>
						@if($row['concepto'] != '')
							@foreach($row['concepto'] as $value)
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
					</td>
					<td>
						@if($row['informacion'] != '')
							@foreach($row['informacion'] as $value)
								<p>{!!$value!!}</p>
							@endforeach
						@endif
					</td>
					<td class="cargos">{{$row['cargos']}}</td>
					<td class="abonos">{{$row['abonos']}}</td>
					<td class="saldo">{{$row['saldo']}}</td>
				</tr>
			@endforeach-----}}
		</table>

	</div>
</body>
</html>
