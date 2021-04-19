<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>{{$id_contacto_completo.' '.$nombre.' '.$apellidos}}</title>
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

		.tabla-1 tr:nth-child(even) {
			border: none;
			padding: 3px;
			text-align: center;
		}

		.tabla2 tr td{
			padding: 5px;
		}

		.tabla-1 tr th.line{
			border-bottom: 2px solid #882439;
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
		.background-gradient{
			background: linear-gradient(0deg,#882439,#A51D3A,#882439);
			color: #FFFFFF;
			border-right: 1px solid #FFFFFF;
		}
	</style>
</head>
<body style=" margin: 0; background-image: url({{asset('public/img/mpdf/fondo_opacity.png')}}); background-repeat: no-repeat; background-position: center; background-size: cover;">
<!-- <body style=" margin: 0; background:linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url({{asset('public/img/mpdf/fondo.png')}}) no-repeat 0 50%;"> -->
	<div class="container">
		<!--pedido-->
		<div class="content-pedido">
			<table class="tabla-datos-facturar">
				<tr>
					<td style="width: 20px;">
						<p class="titulo-datos-facturar">No. </p>
					</td>
					<td style="width: 257px;">
						<p class="text-datos-facturar">@if(!empty($id_movimiento_completo)){{$id_movimiento_completo}}@else N/A @endif </p>
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
					<th>Fecha:</th>
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
		<div class="content-facturar" style="margin:10px 0;">
			<table class="tabla-1" autosize="1">
				<tr>
					<td colspan="1" style="text-align:right;"><p class="titulo-datos-facturar">ID: </p></td>
					<td colspan="3" style="text-align: left;"><p class="text-datos-facturar">@if(!empty($id_contacto_completo)){{$id_contacto_completo}}@else N/A @endif</p></td>
				</tr>
				<tr>
					<td colspan="1" style="text-align:right;"><p class="titulo-datos-facturar">Nombre:</p></td>
					<td colspan="1" style="text-align: left;@if(!empty($nombre)) text-transform:capitalize;@endif"><p class="text-datos-facturar">@if(!empty($nombre) && !empty($apellidos)){{$nombre." ".$apellidos}}@else{{'N/A'}}@endif</p></td>
          <td colspan="2"><p class="titulo-datos-facturar">Responsables de venta: </p></td>
				</tr>
				<tr>
					<td style="width: 15%; text-align:right;"><p class="titulo-datos-facturar">Tel&eacute;fono(s):</p></td>
					<td style="width: 55%; text-align: left;"><p class="text-datos-facturar">
						@if(!empty($telefono1) && !empty($telefono2)){{$telefono1.' / '.$telefono2}}
						@elseif(!empty($telefono1) && empty($telefono2)){{$telefono1}}
						@elseif(empty($telefono1) && !empty($telefono2)){{$telefono2}}
						@elseif(empty($telefono1) && empty($telefono2)){{'N/A'}}@endif
					</p></td>
					<td style="width: 15%; text-align:right;"><p class="titulo-datos-facturar">Asesor: </p></td>
					<td style="width: 15%; text-align:left;"><p class="text-datos-facturar">{{$asesores_nomenclatura->asesor_1}}</p></td>
				</tr>
				<tr>
					<td style="text-align:right;"><p class="titulo-datos-facturar">Domicilio:</p></td>
					<td style="text-align: left; text-transform:capitalize"><p class="text-datos-facturar">@if(!empty($domicilio_completo)){{$domicilio_completo}}@else{{'N/A'}}@endif</p></td>
        	<td style="width: 100px; text-align:right;"><p class="titulo-datos-facturar">Asesor 2: </p></td>
					<td style="text-align:left;"><p class="text-datos-facturar">@if(!empty($asesores_nomenclatura->asesor_2)){{$asesores_nomenclatura->asesor_2}}@else N/A @endif</p></td>
				</tr>
				<tr>
					<td style="text-align:right;"><p class="titulo-datos-facturar">Tipo: </p></td>
					<td style="text-align: left; text-transform:capitalize"><p class="text-datos-facturar">@if(!empty($tipo_cliente)){{$tipo_cliente}}@else{{'N/A'}}@endif</p></td>
          <td style="text-align:right;"><p class="titulo-datos-facturar">Enlace: </p></td>
					<td style="text-align:left;"><p class="text-datos-facturar">@if(!empty($asesores_nomenclatura->enlace_1)){{$asesores_nomenclatura->enlace_1}}@else N/A @endif</p></td>
				</tr>
			</table>
		</div>
		<!--fin-content-->
		<br>
		<div class="invisible"></div>
		<!--<div>-->
        <br>
		<table class="tabla-1">
			<tr>
				<th class="line" colspan="4" style="font-size: 15px;">Unidad</th>
			</tr>
            <tr>
							<td style="width: 15%; text-align:right; font-size: 10px;"><b>VIN:</b></td>
							<td style="width: 55%; text-align:left; font-size: 10px;">@if(!empty($inventario->vin_numero_serie)){{$inventario->vin_numero_serie}}@else N/A @endif</td>
							<td style="width: 15%; text-align:right; font-size: 10px;"><b>Modelo:</b></td>
							<td style="width: 15%; text-align:left; font-size: 10px;">@if(!empty($inventario->modelo)){{$inventario->modelo}}@else N/A @endif</td>
            </tr>
						<tr>
              <td style="text-align:right; font-size: 10px;"><b>Marca:</b></td>
              <td style="text-align:left; font-size: 10px;">@if(!empty($inventario->marca)){{$inventario->marca}}@else N/A @endif</td>
							<td style="text-align:right; font-size: 10px;"><b>Tipo:</b></td>
              <td style="text-align:left; font-size: 10px;">@if(!empty($vpme->tipo_unidad)){{$vpme->tipo_unidad}}@else N/A @endif</td>
						</tr>
            <tr>
              <td colspan="1" style="text-align:right; font-size: 10px;"><b>Versi&oacute;n:</b></td>
              <td colspan="3" style="text-align:left; font-size: 10px;">@if(!empty($inventario->version)){{$inventario->version}}@else N/A @endif</td>
            </tr>
            <tr>
              <td colspan="1" style="text-align:right; font-size: 10px;"><b>Color:</b></td>
              <td colspan="3" style="text-align:left; font-size: 10px;">@if(!empty($inventario->color)){{$inventario->color}}@else N/A @endif</td>
            </tr>

            <!-- ******************SEGUNDA SECCION DE PENDIENTES***************** -->
            <!-- <tr><td colspan="8"></td></tr><tr><td colspan="8"></td></tr><tr><td colspan="8"></td></tr> -->
		</table>
		<!--<div>-->
        <br>
		<table class="tabla-1">
			<!-- <thead> -->
					<tr>
						<th class="line" colspan="4" style="font-size: 15px;">Venta @if(!empty($vpme->tipo_venta)){{$vpme->tipo_venta}}@else N/A @endif</th>
					</tr>
          <!-- <tr>
              <th>#</th>
              <th colspan="2">Monto</th>
              <th colspan="2">M&eacute;todo de pago:</th>
          </tr>
        </thead> -->

            @if(!$vpme_pagos->isEmpty())
            @foreach($vpme_pagos as $key_vpme => $pago)
            <tr>
								<!-- <td>{{$key_vpme+1}}</td> -->
                <td colspan="2" style="font-size: 10px;"><b>Monto:</b> @if(!empty($pago->monto))$ {{number_format($pago->monto,2)}}@else N/A @endif</td>
                <td colspan="2" style="font-size: 10px;"><b>M&eacute;todo de pago:</b> @if(!empty($pago->metodo_pago)){{$pago->metodo_pago}}@else N/A @endif</td>
            </tr>
            @endforeach
            @else
            <tr>
								<!-- <td>1</td> -->
                <td colspan="4" style="font-size:10px;"><b>Monto:</b> @if(!empty($vpme->monto_unidad))$ {{number_format($vpme->monto_unidad,2)}}@else N/A @endif</td>
								<!-- <td colspan="2" ></td> -->
            </tr>

            @endif


            @if($vpme->tipo_venta == "Directa a Crédito" || $vpme->tipo_venta == "Crédito")
            <tr>
                @php $colspan = "4"; @endphp
                @if(!empty($vpme->anticipo))
                    @if($vpme->anticipo != 0)
                            <td colspan="2" style="text-align:center; width:25%;"><b>Anticipo: </b>$ {{number_format($vpme->anticipo,2)}}</td>
                            @php $colspan = "2";@endphp
                    @endif
                @endif
                <td  colspan="{{$colspan}}" style="text-align:center;"><b>L&iacute;nea de cr&eacute;dito: </b>
                    @if(!empty($vpme->monto_unidad))
                        @if($vpme->anticipo != 0)
                            $ {{number_format($vpme->monto_unidad - $vpme->anticipo,2)}}
                        @else
                            $ {{number_format($vpme->monto_unidad,2)}}
                        @endif
                    @endif
                </td>
            </tr>
            <tr>

                <td colspan="2" style="text-align:center;"><b>No. pagares: </b>{{count($vpme_pagares)}}</td>
                <td colspan="2" style="text-align:center;"><b>Tipo de pagare: </b>F&iacute;sico </td>
            </tr>


			<tr><td colspan="4"></td></tr>
			<tr><td colspan="4"></td></tr>

            <!-- ******************SEGUNDA SECCION DE PENDIENTES***************** -->
		</table>
		<!--<div>-->
        <br>
		<table class="tablax tablaxdprincipales" >
            @endif
            @if($vpme->tipo_venta == "Directa de Contado" || $vpme->tipo_venta == "Contado")
            <tr><td colspan="4"></td></tr>
            <tr><td colspan="4"></td></tr>
            <tr><td colspan="4"></td></tr>
			<tr><td colspan="4"></td></tr>
            <tr><td colspan="4"></td></tr>
    		<tr><td colspan="4"></td></tr>
            @endif
            <tr>
				<th colspan="4" style="font-size: 15px;">Condiciones de pago</th>
			</tr>
              <tr>
                <th class="background-gradient" scope="col">#</th>
                <th class="background-gradient" scope="col">Fecha</th>
                <th class="background-gradient" scope="col">Pago</th>
                <th class="background-gradient" scope="col">Saldo</th>
              </tr>
            <tbody>

            @if($vpme->tipo_venta == "Directa a Crédito" || $vpme->tipo_venta == "Crédito" || $vpme->tipo_venta == "Credito")

              @else
              <tr>
                <td style="width:15%;">1</td>
                <td style="width:28.3%;">{{$calculate_amortization_table->disbursement_date}}</td>
                <td style="width:28.3%;">$ {{number_format($calculate_amortization_table->disbursement_amount,2)}}</td>
                <td style="width:28.3%;">0.00</td>
              </tr>
              @endif
              @php $id = 1; @endphp
              @foreach($calculate_amortization_table->table as $key => $value)
                <tr>
                  <td name="at_period_{{$id}}">{{$value['period']}}</td>
                  <td name="at_date_{{$id}}">{{$value['date']}}</td>
                  <td name="at_payment_{{$id}}">$ {{number_format($value['payment'],2)}}</td>
                  <td name="at_balance_{{$id}}">$ {{number_format($value['balance'],2)}}</td>
                </tr>
                @php $id+=1; @endphp
              @endforeach

              <tr>
                  @php $numero_pagares = 0; $height = '300';
                    if($vpme->tipo_venta == "Directa a Crédito" || $vpme->tipo_venta == "Crédito" || $vpme->tipo_venta == "Credito"){
                        $numero_pagares = count($calculate_amortization_table->table);
                        if($numero_pagares == 12) $height = '140';
                        if($numero_pagares == 11) $height = '170';
                        if($numero_pagares == 10) $height = '190';
                        if($numero_pagares == 9) $height = '210';
                        if($numero_pagares == 8) $height = '230';
                        if($numero_pagares == 7) $height = '250';
                        if($numero_pagares == 6) $height = '270';
                        if($numero_pagares == 5) $height = '290';
                        if($numero_pagares == 4) $height = '305';
                        if($numero_pagares == 3) $height = '310';
                        if($numero_pagares == 2) $height = '330';
                        if($numero_pagares == 1) $height = '350';
                    }
                  @endphp

                  @if(!empty($calculate_amortization_table->img))
                      <td colspan="4"><br>
                          @if($vpme->tipo_venta == "Directa de Contado" || $vpme->tipo_venta == "Contado")
                            <br>
                          @endif
                          <img alt='image' height='{{$height}}' class='rounded-circle' src="{{$calculate_amortization_table->img}}" alt="">

                      </td>
                  @else
                        @php $foto = "https://www.panamotorscenter.com/Des/CCP/style_direccionador/assets/img/grupo_panamotors_b.png"; @endphp
                      <td colspan="4"><br>
                          @if($vpme->tipo_venta == "Directa de Contado" || $vpme->tipo_venta == "Contado")
                            <br>
                          @endif
                          <img alt='image' height="{{$height}}" class='rounded-circle' src="{{url('/').'/storage/app/public/proximamente_galeria.png'}}" alt="">
                          <!-- <img alt='image' width='350' class='rounded-circle' src="{{---$foto----}}" alt=""> -->
                          <!-- <br><br><br><br><br><br><br><br> -->
                          <!-- <h2>-- Próximamente en galería --</h2> -->
                      </td>
                  @endif
              </tr>
            </tbody>
			<tr><td colspan="4"></td></tr>
			<tr><td colspan="4"></td></tr>

            <!-- ******************SEGUNDA SECCION DE PENDIENTES***************** -->
            <tr><td colspan="8"></td></tr><tr><td colspan="8"></td></tr><tr><td colspan="8"></td></tr>
		</table>


	</div>
</body>
</html>
