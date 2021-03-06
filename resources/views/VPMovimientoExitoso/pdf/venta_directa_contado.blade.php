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
			/* border-bottom: 2px solid #882439; */
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
<!-- <body style=" margin: 0; background:linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url({{asset('public/img/mpdf/fondo.png')}}) no-repeat 0 50%;"> -->
	<div class="container">
		<!--pedido-->
		<div class="content-pedido">
			<table class="tabla-datos-facturar">
				<tr>
					<td style="width: 20px;">
						<p class="titulo-datos-facturar">Folio: </p>
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
					<th>A??o</th>
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
			<table class="tabla-datos-facturar" autosize="1">
				<tr>
					<td style="text-align:justify;">
                        <p class="text-datos-facturar" style="font-size:10px;">
                            CONTRATO DE COMPRA -  VENTA DE PAGO TOTAL O AL CONTADO DE VEH??CULO AUTOMOTOR USADO, QUE CELEBRAN POR UNA PARTE EN SU CALIDAD DE PARTE
                            VENDEDORA PANAMOTORS CENTER, S.A. DE C.V., REPRESENTADO EN ESTE ACTO POR SU ADMINISTRADOR ??NICO EDUARDO DANIEL FLORES MENDOZA Y POR OTRA
                            PARTE EN SU CALIDAD DE PARTE COMPRADOR
                            (A)  C. @if(!empty(!empty($nombre))){{strtoupper($nombre)." "}}@endif @if(!empty(!empty($apellidos))){{strtoupper($apellidos)}}@endif, SUJET??NDOSE Y OBLIG??NDOSE  AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CL??USULAS:
                        </p>
                    </td>

				</tr>
			</table>
		</div>
		<table class="tablax tablaxdprincipales">
			<tr>
				<th colspan="1">D E C L A R A C I O N E S</th>

			</tr>
            <tr>
                <td style="text-align:justify;">
                    <p class="text-datos-facturar" style="font-size:10px;">
                        Declara PANAMOTORS CENTER, por conducto de su Administrador ??nico EDUARDO DANIEL FLORES MENDOZA, contar con las facultades amplias,
                        bastantes y  necesarias para obligarse en los t??rminos del presente contrato, las cuales a la fecha se encuentran vigentes y no le han
                        sido revocadas ni modificadas de forma alguna. Tener como domicilio bien conocido para los efectos jur??dicos a que haya lugar el ubicado
                        <b>Libramiento vial Jorge Jim??nez Cant?? S/N C.P, 50453 localidad de Atlacomulco de Fabela estado de M??xico</b> con n??mero telef??nico <b>7181271133</b>, con correo
                        electr??nico <b>atencionalcliente@panamotorscenter.com</b>, que est?? inscrito en el Registro Federal de Contribuyentes bajo el n??mero <b>PCE1411056H8</b>, as?? como
                        tambi??n que la informaci??n contenida en el anverso de este documento sirve como modo de identificaci??n y descripci??n del veh??culo materia de la
                        compraventa as?? como el monto de la operaci??n a pagar, sin embargo se obliga y sujeta a las clausulas establecidas en el reverso del presente
                        documento.
                    </p>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="text-align:justify;">
                    <p class="text-datos-facturar" style="font-size:10px;">
                        Declara El Comprador, tener las facultades amplias y necesarias para obligarse en los t??rminos del presente contrato, que sus recursos son
                        l??citos necesarios para comparecer a la celebraci??n del presente contrato y que la informaci??n contenida en el anverso de este documento
                        sirve como modo de identificaci??n y descripci??n del veh??culo materia de la compraventa, as?? como el monto de la operaci??n a pagar, sin
                        embargo se obliga y sujeta a las clausulas establecidas en el reverso del presente documento. Tener como datos de identificaci??n as?? como
                        su domicilio bien conocido en el se??alado y descrito en su credencial para votar, expedida por el Instituto Nacional Electoral y/o el
                        proporcionado a los agentes comerciales de la parte vendedora
                    </p>
                </td>
            </tr>
		</table>
        <br><br>

        <table class="tablax tablaxdprincipales" style="font-size:11px;">
            <tr>
                <td colspan="6" style="padding-bottom: 10px; border-bottom: 1px solid #c3c7cc;">Caracter??sticas de la unidad materia de la compra ??? venta:</td>
            </tr>
            <tr>
                <td style="text-align:right; width:15%;">Tipo:</td>
                <td style="text-align:left; width:15%;">@if(!empty($vpme->tipo_unidad)){{$vpme->tipo_unidad}}@else N/A @endif</td>

                <td style="text-align:right; width:15%;">N??mero de serie:</td>
                <td style="text-align:left;  width:15%;">@if(!empty($inventario_dinamico->contenido)){{$inventario_dinamico->contenido}}@else N/A @endif</td>

                <td style="text-align:right; width:15%;">Marca:</td>
                <td style="text-align:left; width:15%;">@if(!empty($inventario->marca)){{$inventario->marca}}@else N/A @endif</td>
            </tr>
            <tr>
                <td style="text-align:right;" colspan="1">Versi&oacute;n:</td>
                <td style="text-align:left;" colspan="5">@if(!empty($inventario->version)){{$inventario->version}}@else N/A @endif</td>
            </tr>
            <tr>
                <td style="text-align:right; ">Color:</td>
                <td style="text-align:left;">@if(!empty($inventario->color)){{$inventario->color}}@else N/A @endif</td>

                <td style="text-align:right; ">Modelo:</td>
                <td style="text-align:left;">@if(!empty($inventario->modelo)){{$inventario->modelo}}@else N/A @endif</td>

                <td style="text-align:right;">Transmisi??n:</td>
                <td style="text-align:left;">@if(!empty($inventario->transmision)){{ucfirst(strtolower($inventario->transmision))}}@else N/A @endif</td>

            </tr>

            <tr>

                <td style="text-align:right; width: 15%;">Procedencia:</td>
                <td style="text-align:left;  width: 15%;">@if(!empty($vpme->procedencia)){{ucfirst(strtolower($vpme->procedencia))}}@else N/A @endif</td>

                @if(!empty($vpme->tipo_unidad))
                @if($vpme->tipo_unidad != "Unidad")
                <td style="text-align:right; width: 15%;">N??mero de motor:</td>
                <td style="text-align:left;  width: 15%;"></td>
                @endif
                @endif


            </tr>
        </table>
        <br>

        <table class="tablax tablaxdprincipales" style="font-size:11px;">
            <tr>
                <td colspan="6">El precio pactado por las partes para la presente operaci??n es por la cantidad total de: $ @if(!empty($vpme->monto_unidad)){{number_format($vpme->monto_unidad,2)}}@endif @if(!empty($monto_letra)){{" (".$monto_letra."). "}}@endif</td>
            </tr>
        </table>
        <br><br>

        <table class="tablax tablaxdprincipales" style="font-size:11px;">
            <tr>
                <td colspan="2" style="width:50%; padding-bottom: 10px; border-bottom: 1px solid #c3c7cc;">VENDEDOR</td>
                <td colspan="2" style="width:50%; padding-bottom: 10px; border-bottom: 1px solid #c3c7cc;">COMPRADOR</td>
            </tr>
            <tr>
                <td style="text-align:right; width:20%;">Nombre:</td>
                <td style="text-align:left;  width:30%;">Panamotors Center S.A. DE C.V.</td>
                <td style="text-align:right; width:20%;">Nombre:</td>
                <td style="text-align:left;  width:30%;">@if(!empty(!empty($nombre))){{$nombre." "}}@endif @if(!empty(!empty($apellidos))){{$apellidos}}@endif</td>
            </tr>
            <tr>
                <td style="text-align:right;">Domicilio:</td>
                <td style="text-align:left; ">Carretera Panamericana sin numero</td>
                <td style="text-align:right;">Domicilio:</td>
                <td style="text-align:left; ">@if(!empty($calle)){{$calle}}@else N/A @endif</td>
            </tr>
            <tr>
                <td style="text-align:right;">Colonia:</td>
                <td style="text-align:left; ">Loc. Pathe, Acambay Mexico</td>
                <td style="text-align:right;">Colonia:</td>
                <td style="text-align:left; ">@if(!empty($domicilio_completo)){{$domicilio_completo}}@else N/A @endif</td>

            </tr>
            <tr>
                <td style="text-align:right;">Tel??fono:</td>
                <td style="text-align:left; ">@if(!empty($telefono_asesor)){{$telefono_asesor}}@endif</td>
                <td style="text-align:right;">Tel??fono:</td>
                <td style="text-align:left; ">
                    @if(!empty($telefono1) && !empty($telefono2)){{$telefono1.' / '.$telefono2}}
                    @elseif(!empty($telefono1) && empty($telefono2)){{$telefono1}}
                    @elseif(empty($telefono1) && !empty($telefono2)){{$telefono2}}
                    @elseif(empty($telefono1) && empty($telefono2)){{'N/A'}}@endif
                </td>

            </tr>
            <tr>
                <td style="text-align:right;">Se identifico con:</td>
                <td style="text-align:left; ">Acta constitutiva</td>
                <td style="text-align:right;">Se identifico con:</td>
                <td style="text-align:left; ">@if(!empty($identificacion)){{strtoupper(strtolower($identificacion))}}@else Pendiente @endif</td>
            </tr>
            <tr>
                <td style="text-align:right;">Folio:</td>
                <td style="text-align:left; "></td>
                <td style="text-align:right;">Folio:</td>
                <td style="text-align:left; ">@if(!empty($folio_identificacion)){{strtoupper(strtolower($folio_identificacion))}}@else Pendiente @endif</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><br><br><br>Entrego por mi voluntad</td>
                <td colspan="2" style="text-align:center;"><br><br><br>Recib?? de conformidad</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><br><br><br><br><br>
                    <u>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </u>
                </td>
                <td colspan="2" style="text-align:center;"><br><br><br><br><br>
                    <u>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </u>
                </td>
            </tr>
        </table>

        <pagebreak>

				<div style="width: 100%;">
					<div class="" style="width: 48%; float: left; padding: 0px 5px;">
						<p style="font-weight: bold; font-size: 9px; text-align: center;">C L ?? U S U L A S</p>
						<div style="font-size: 8px; text-align: justify;">
							<p>
								PRIMERA: (OBJETO).- El presente acuerdo de voluntades tiene por objeto que Panamotors Center vende desde este
								momento y para siempre  al comprador el veh??culo automotor de uso cuyas caracter??sticas, definiciones y glosarios
								se han detallado en la caratula de  este documento.
							</p>
							<p>
								SEGUNDA: (VALIDACI??N).- El veh??culo de uso motivo de la presente operaci??n ha sido consultado, verificado y validado para su autenticidad, legalidad y documentaci??n por Panamotors Center, habi??ndose validado por el comprador primeramente se realizo una investigaci??n e inspecci??n de car??cter visual verificando la autenticidad y condici??n de la unidad as?? como de su holograma (tipo papel donde se encuentra localizado el n??mero de serie del veh??culo), no existiendo anomal??a de ninguna ??ndole; aunado a ello se realizo una inspecci??n visual, electr??nica y mec??nica relativa a la condici??n f??sica y material de la unidad, encontr??ndose en buenas condiciones de uso y confiabilidad, por tanto el veh??culo motivo de este contrato cumple con todas y cada una de las Normas vigentes y aplicables en materia Administrativa, de Seguridad y Medio Ambiente, asimismo se consulto ante las diversas Plataformas Especializadas en Materia Vehicular de los Gobiernos Estatales, Federales y Empresas Privadas del Ramo Automotriz (Aseguradoras y Agencias) constat??ndose que la unidad se encuentra exenta de multas y/o pagos y/o recargos y/o garant??as y/o cr??ditos y/o coaliciones y/o reporte de robo, as?? como tambi??n que la documental que ampara la propiedad del veh??culo ha sido expedida por la Agencia en consulta as?? como se encuentra la validaci??n de las distintas facturas emitidos y validadas por el SAT y que por tanto el veh??culo no cuenta con vicio alguno; entonces El Comprador, acepta que la unidad se encuentra validada para su adquisici??n. Por lo anterior en caso de que el comprador llegara a tener alguna acci??n o acto de molestia por parte de una tercera persona f??sica,  moral y/o autoridad expresamente  libera al vendedor  de cualquier responsabilidad.
								Por virtud de las validaciones anteriormente expuestas, las cuales fueron validadas y verificadas por el comprador, est?? no se reserva acci??n o derecho alguno en contra del vendedor.
							</p>
							<p>
								TERCERA: (PAGO).-  La cantidad total de la compraventa descrita y establecida en la caratula de este documento, ser?? pagada en una sola exhibici??n e ??ntegramente en la fecha de la firma del presente documento, previo a la entrega material, jur??dica y virtual del veh??culo; ahora bien cualquier equipo y/o accesorio adicional solicitado por el comprador,  ser?? pagadero con independencia de la cantidad total establecida; as?? tambi??n cualquier equipo y/o accesorio adicional solicitado por el agente de ventas de Panamotors Center  y autorizado por el comprador ser?? pagadero con independencia de la cantidad total establecida.
							</p>
							<p>
								CUARTA: (GARANT??A).-  El comprador acepta el veh??culo motivo de este contrato en las condiciones f??sicas (internas y externas), mec??nicas (internas y externas), el??ctricas (internas y externas) y de documentaci??n en las que se encuentra, sin embargo tambi??n se sujetan:
							</p>
							<p>
								A).-  El vendedor manifiesta en este acto a el comprador que la garant??a que se otorga al mismo, ser?? directamente con la agencia automotriz de origen del veh??culo, por tanto el vendedor solamente se obliga a auxiliar en todo lo necesario para el efecto de que al comprador se le aplique la garant??a que tenga la unidad automotriz con la agencia de origen del veh??culo.
							</p>
							<p>
								B).- El vendedor en este acto otorga una garant??a sobre la unidad consistente en _____ kil??metros o  _____ meses, a favor del comprador, asumiendo la reparaci??n el vendedor, sin embargo se excluye de dicha garant??a, si la unidad sufre y/o reporta falla total o parcial con motivo de  cualquier coalici??n  vial y/o si la unidad  cae en baches o debido a inundaci??n y/o por circular por caminos intransitables y/o por conducir fuera de caminos trazados o en aquellos en que se encuentren en mal estado y/o por cat??strofes naturales y/o robo y/o fen??menos naturales.
							</p>
							<p>
								C).- Las partes manifiestan que Panamotors Center previo a la formalizaci??n del contrato de compraventa de veh??culo inform?? al comprador de la inexistencia de cualquier garant??a de cobertura (mec??nica, el??ctrica, est??tica y accesorios)  total o parcial respecto de sus veh??culos de uso comercializados. Por tanto el comprador recibe el veh??culo usado descrito en el presente contrato, asumiendo los costos por reparaciones, suministro de refacciones, mano de obra calificada, entre otros. Asimismo en este acto libera a Panamotors Center de adeudos o conflictos en materia Administrativa y/o Penal y/o Civil y/o Fiscal que por cualquier motivo pudiera generar dicho veh??culo a partir de la fecha de su entrega, en el entendido de que el comprador se obliga a realizar el cambio de propietario ante las Autoridades correspondientes,  en un termino no mayor a treinta d??as naturales.
							</p>
							<p>
								QUINTA: (SERVICIOS ADICIONALES).- Las partes manifiestan que se har??n cargos por servicios adicionales al veh??culo motivo de la presente operaci??n, de los ya pactados en el presente instrumento previo consentimiento de las partes, cubriendo dicho pago la parte compradora haci??ndose consistir en el detallado y/o evaluaci??n y/o diagnostico y/o mec??nica y/o est??tica y/o tapicer??a y/o hojalater??a y/o pintura y/o sistemas o reparaciones  el??ctricas.
							</p>
						</div>
					</div>
					<div class="" style="width: 48%; float: left; padding: 0px 5px;">
						<div style="font-size: 8px; text-align: justify;">
							<p>
								SEXTA: (DOCUMENTACI??N).- Panamotors Center hace entrega conjuntamente con el veh??culo a el comprador o en su caso en un termino
								de <u>&nbsp;&nbsp;90&nbsp;&nbsp;</u> d??as de la siguiente documentaci??n:
							</p>
							<p>
								<!-- 1)	Carta-Factura emitida por el Distribuidor.<br>
								2)	Tarjeta de Circulaci??n.<br>
								3)	Manual de Usuario.<br>
								4)	Registro Publico Vehicular.<br>
								5)	Comprobante de Pago de Tenencias.<br>
								6)	Comprobante de Verificaci??n Ambiental.<br>
								7)	Juego de Llaves.<br>
								8)	Pedimento de Importaci??n. (si es que aplica).<br>
								9)	Calcoman??a de Legalizaci??n. (si es que aplica).<br>
								10)	Constancia de Cambio de Propietario. (si es que aplica).<br>
								11)	Comprobantes de Pago Multas y Recargos. (si es que aplica).<br>
								<br> -->
								{!!$tabla_documentos!!}
							</p>
							<p>
								S??PTIMA: (RESCISI??N DEL CONTRATO).- Las partes pactan que  Panamotors Center tendra el derecho de rescindir el presente contrato, sin necesidad de declaraci??n judicial o extrajudicial alguna, en caso de que el comprador incumplan con cualquiera de las obligaciones a su cargo estipuladas y derivadas del presente instrumento.
							</p>
							<p>
								OCTAVA: (PENA CONVENCIONAL).- Ambas partes otorgando su mas amplio consentimiento y voluntad que conforme a derecho corresponda, pactan como pena convencional el equivalente al
								<u>&nbsp;&nbsp;25&nbsp;&nbsp;</u> % del precio total de la venta del veh??culo, ascendiendo a la cantidad de
								$ <u>&nbsp;&nbsp;@if(!empty($vpme->monto_unidad)){{number_format($vpme->monto_unidad,2)}}@endif&nbsp;&nbsp;</u> , para el caso hipot??tico de que la parte compradora rescinda el presente contrato por motivo de no dar cabal cumplimiento a la clausula tercera de este  instrumento y/o cancele dicha compraventa, por lo que Panamotors Center, retendr?? a su favor la cantidad resultante de dicho porcentaje devolviendo el remanente a el comprador, con independencia de la responsabilidad penal que podr?? ser exigible la parte vendedora.
							</p>
							<p>
								NOVENA: (INFORMACI??N DE DATOS PERSONALES).- El comprador otorga en este acto su mas amplia voluntad que conforme a derecho corresponda para que Panamotors Center utilice la informaci??n proporcionada por el comprador con fines mercadot??cnicos y/o publicitarios y/o de ventas, as?? como tambi??n le env??e publicidad sobre bienes y servicios.
							</p>
							<p>
								DECIMA: (TITULADO DE CL??USULAS).- ???Las Partes??? aceptan que los encabezados utilizados al principio de cada cl??usula han sido utilizados para agilizar la referencia de las mismas, sin que el contenido de las cl??usulas deba interpretarse en base a los t??tulos de las mismas.
							</p>
							<p>
								DECIMA PRIMERA: (EN CUANTO A LA NULIDAD).- En el presente contrato no existe, dolo, lesi??n, error, mala fe o vicio alguno que pudiera dar origen a su respectiva rescisi??n o nulidad, por lo que las partes que intervienen se sujetan a la literalidad de sus declaraciones y cl??usulas.
							</p>
							<p>
								DECIMA SEGUNDA: (JURISDICCI??N Y COMPETENCIA).-   Para todo lo relativo a la interpretaci??n y/o controversia y/o cumplimiento y/o ejecuci??n de lo establecido en el presente contrato, ???Las Partes??? otorgan sus respectivos consentimientos, para voluntariamente someterse a las Leyes aplicables dentro de la Republica Mexicana, as?? como  a los Tribunales y/o Autoridades Investigadoras competentes de la Ciudad de Atlacomulco, Estado de M??xico y/o a los Tribunales y/o Autoridades Investigadoras en el lugar de residencia y/o domicilio de el comprador y/o a elecci??n de  Panamotors Center; y en consecuencia, las partes expresamente renuncian clara y terminantemente a la aplicaci??n  de cualquier otro fuero, jurisdicci??n o competencia, que pudiere corresponderles en raz??n de sus domicilios presentes o futuros por cualesquier otra causa pudiera corresponderles.
							</p>
							<p>
								En este acto Panamotors Center expone  que su actividad preponderante es la compra-venta de veh??culos usados, que se encuentra Regulado y en cumplimiento conforme a las Normas Oficiales vigentes que nos rigen en este pa??s en materia de seguridad y protecci??n al medio ambiente y debidamente registrada como socio activo en la Asociaci??n Nacional de Comerciantes en Autom??viles y Camiones Nuevos y Usados A C. (ANCA).
							</p>
							<p>
								El comprador y Panamotors Center aceptan la realizaci??n de la presente compraventa en los t??rminos establecidos en este contrato, y sabedores de su contenido legal, lo firman por duplicado.
							</p>
						</div>
						<div style="width: 50%; float: left; font-size: 8px; text-align: center; margin-top: 30px;">
							<p>
								El Vendedor
							</p>
							<br>
							<p>
								_____________________________________
							</p>
						</div>
						<div style="width: 50%; float: left; font-size: 8px; text-align: center;">
							<p>
								El Comprador
							</p>
							<br>
							<p>
								_____________________________________
							</p>
						</div>
					</div>
				</div>
	</div>
</body>
</html>
