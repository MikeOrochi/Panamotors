@php use App\Http\Controllers\GlobalFunctionsController; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>{{'Personas fisicas - '.$nombre.' '.$apellidos}}</title>
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
						<p class="titulo-datos-facturar"></p>
					</td>
					<td style="width: 257px;">
						<p class="text-datos-facturar"></p>
					</td>
				</tr>
			</table>
		</div>
		<!--fin-pedido-->
		<!--table-fecha-->
		<div class="content-fecha">
			<table class="tabla-fecha">
				<tr>
					<td colspan="5" style="font-style:italic; font-size:12px;">PERSONAS FISICAS</td>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</table>
		</div>
		<!--fin-table-fecha-->
		<div class="both"></div>
		<!--pleca-->

		<!--fin-pleca-->
		<div class="content-facturar" style="margin:10px 5%;">
			<table class="tabla-datos-facturar" autosize="1">
				<tr>
					<td style="text-align:justify;">
                        <p class="text-datos-facturar" style="font-size:10px; font-style:italic;">
                            <b>PANAMOTORS CENTER SA DE CV</b>
                        </p>
                        <p class="text-datos-facturar" style="font-size:10px;">
                            LIBRAMIENTO VIAL JORGE JIMÉNEZ CANTÚ S/N C.P. 50453 LOCALIDAD DE ATLACOMULCO DE FABELA ESTADO DE MÉXICO, MÉXICO</b>
                        </p>
                    </td>

				</tr>
			</table>
		</div>
		<table class="tablax tablaxdprincipales" style="font-size:10px; margin:0 5%;">
            <tr>
                <td style="text-align:justify;">
                    <p class="text-datos-facturar">
                        0045n cumplimiento a lo dispuesto por el <b>ANEXO 3 DEL ACUERDO 02/2013 POR EL QUE SE EMITEN LAS REGLAS DE CARÁCTER GENERAL A QUE SE REFIERE LA LEY FEDERAL PARA LA PREVENCIÓN E
                        IDENTIFICACIÓN DE OPERACIONES CON RECURSOS DE PROCEDENCIA ILÍCITA, les solicitamos la siguiente
                        información:</b>

                    </p>
                    <br>
                </td>
            </tr>
		</table>
        <br>

        <table class="tablax tablaxdprincipales" style="font-size:10px; margin:0 5%;">
            <tr>
                <td colspan="3" style="width:97%; text-align:left;">NOMBRE COMPLETO (CON APELLIDOS Y SIN ABREVIATURAS): <b style="font-size:10px;">@if(!empty($nombre)){{$nombre." "}}@endif @if(!empty($apellidos)){{$apellidos}}@endif</b> </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:left;"><br><b>FECHA DE NACIMIENTO: </b><span style="font-size:10px;">@if(!empty($fecha_nacimiento)){{$fecha_nacimiento}}@endif</span></td>
            </tr>
            <tr>
                <td colspan="1" style="width:3%;"><br><b>1.</b></td>
                <td colspan="2" style="text-align:left;"><br><b>PAÍS DE NACIMIENTO: </b>
                    <span style="font-size:10px;">
                        @if(!empty($informacion_cliente->pais_nacimiento))
                        {{strtoupper(GlobalFunctionsController::convertirTildesCaracteres($informacion_cliente->pais_nacimiento))}}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><br><b>2.</b></td>
                <td colspan="2" style="text-align:left;"><br><b>PAÍS DE NACIONALIDAD: </b>
                    <span style="font-size:10px;">
                        @if(!empty($informacion_cliente->pais_nacionalidad))
                        {{strtoupper(GlobalFunctionsController::convertirTildesCaracteres($informacion_cliente->pais_nacionalidad))}}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><br><b>3.</b></td>
                <td colspan="2" style="text-align:left;"><br><b>ACTIVIDAD, OCUPACIÓN, PROFESIÓN O GIRO DE SU NEGOCIO: </b>
                    <span style="font-size:10px;">
                        @if(!empty($informacion_cliente->ocupacion))
                        {{strtoupper(GlobalFunctionsController::convertirTildesCaracteres($informacion_cliente->ocupacion))}}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><b>4.</b></td>
                <td colspan="2" style="text-align:left;"><br><b>DOMICILIO COMPLETO (CALLE, NÚMERO INTERIOR Y EXTERIOR, COLONIA, POBLACIÓN, MUNICIPIO Y/O DELEGACIÓN, CÓDIGO POSTAL, ESTADO, PAÍS).</b></td>
            </tr>
            <tr>
                <td colspan="1"><br><b> </b></td>
                <td colspan="2" style="text-align:left; font-size:10px;">
                    @if(!empty($domicilio_completo)){{$domicilio_completo}}@endif
                </td>
            </tr>
            <tr>
                <td colspan="1"><br><b> </b></td>
                <td colspan="2" style="text-align:left;">TELEFONO (CON LADA):
                    <span style="font-size:10px;">@if(!empty($telefono1) && !empty($telefono2)){{$telefono1.' / '.$telefono2}}
                    @elseif(!empty($telefono1) && empty($telefono2)){{$telefono1}}
                    @elseif(empty($telefono1) && !empty($telefono2)){{$telefono2}}
                    @elseif(empty($telefono1) && empty($telefono2)){{'N/A'}}@endif</span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><br><b>5.</b></td>
                <td colspan="2" style="text-align:left;"><br><b>CORREO ELECTRONICO (OPCIONAL): </b>
                    <span style="font-size:10px;">
                        @if(!empty($informacion_cliente->correo))
                        {{strtoupper(GlobalFunctionsController::convertirTildesCaracteres($informacion_cliente->correo))}}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><br><b>6.</b></td>
                <td colspan="1" style="width:50%; text-align:left;"><br><b>CURP: </b>
                    <span style="font-size:10px;">@if(!empty($informacion_cliente->curp)){{$informacion_cliente->curp}}@endif
                    </span>
                </td>
                <td colspan="1" style="width:50%; text-align:left;"><br><b>RFC: </b>
                    <span style="font-size:10px;">@if(!empty($informacion_cliente->rfc)){{$informacion_cliente->rfc}}@endif
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><b>7.</b></td>
                <td colspan="2" style="text-align:left;"><br><b>NOMBRE DE LA IDENTIFICACIÓN CON LA QUE SE IDENTIFICÓ EL CLIENTE O USUARIO, AUTORIDAD EMISORA Y NÚMERO DE LA MISMA: </b></td>
            </tr>
            <tr>
                <td colspan="1"><br><b> </b></td>
                <td colspan="2" style="text-align:left; font-size:10px;"><br>
                    <b>
                        @if(!empty($informacion_cliente->identificacion))
                        {{strtoupper(GlobalFunctionsController::convertirTildesCaracteres($informacion_cliente->identificacion)).": "}}
                        @endif
                        @if(!empty($informacion_cliente->folio_identificacion)){{$informacion_cliente->folio_identificacion}}@endif
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="1"><br><b>8.</b></td>
                <td colspan="2" style="text-align:left;"><br><b>¿TIENE USTED CONOCIMIENTO DE LA EXISTENCIA DE ALGÚN DUEÑO BENEFICIARIO?</b>
                    <span style="font-size:10px;">
                        @if(!empty($informacion_cliente->beneficiario))
                        {{strtoupper(GlobalFunctionsController::convertirTildesCaracteres($informacion_cliente->beneficiario))}}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><br><b> </b></td>
                <td colspan="2" style="text-align:left; font-size:10px;"><br><b>EN CASO AFIRMATIVO FAVOR DE LLENAR OTRO FORMATO CON LOS DATOS DEL DUEÑO BENEFICIARIO.</b></td>
            </tr>
            <tr>
                <td colspan="1"><br><b> </b></td>
                <td colspan="2" style="text-align:left; font-size: 10px;"><br><b>HAGO CONSTAR QUE MIS RESPUESTAS SON VERDADERAS.</b></td>
            </tr>
        </table>
        <br> <br>

        <table class="tablax tablaxdprincipales" style="font-size:10px;">
            <tr>
                <td colspan="2" style="text-align:center;"><br><br><br><br>
                    <u>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </u>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width:50%;">FIRMA DEL CLIENTE O USUARIO</td>
                <td colspan="2" style="width:50%;">
                    <p>FIRMA DEL REPRESENTANTE LEGAL DE <br>PANAMOTORS CENTER, S.A. DE C.V.</p>
                </td>
            </tr>
        </table>
				<div style="margin-top: 20px;">
					<p class="tit3" style="margin-left: 40px; font-size:10px;">
					FAVOR DE AGREGAR EN COPIA LA SIGUIENTE INFORMACIÓN:<br>
						-	IDENTIFICACIÓN OFICIAL (INE, CARTILLA MILITAR, PASAPORTE, CEDULA PROFESIONAL)<br>
						-	CURP<br>
						-	COMPROBANTE DOMICILIO<br>
					</p>
				</div>





	</div>
</body>
</html>
