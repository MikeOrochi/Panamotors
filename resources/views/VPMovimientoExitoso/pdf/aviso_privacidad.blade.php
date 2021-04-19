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
                <td style="width: 20px;">
                </td>
                <td style="width: 257px;">
                </td>
            </tr>
        </table>
    </div>
    <!--fin-pedido-->
    <!--table-fecha-->
    <div class="content-fecha">
        <table class="tabla-fecha">
            <tr>
            </tr>
            <tr>
            </tr>
        </table>
    </div>
    <!--fin-table-fecha-->
    <div class="both"></div>
    <!--pleca-->
    <div class="content-facturar" style="margin:10px 0;">
        <table class="tabla-datos-facturar" autosize="1">
            <tr>
                <td style="text-align:justify;">

                </td>

            </tr>
        </table>
    </div>
    <table class="tablax tablaxdprincipales" style="margin:0 6%; font-size:13px; word-spacing:3px; width:100%;">

        <tr>
            <td style="text-align:justify;">


                <p class="parrafo">
                    Para PANAMOTORS CENTER, S.A. DE C.V. con domicilio fiscal en libramiento vial Jorge Jiménez Cantú s/n C.P. 50453 localidad
                    Atlacomulco de Fabela, estado de México, México. Se encarga de la protección de sus datos personales es muy importante,
                    razón por la cual, usted puede tener la certeza de que los mismos serán manejados en forma confidencial de acuerdo con la
                     LEY FEDERAL DE PROTECCIÓN DE DATOS PERSONALES EN POSESIÓN DE LOS PARTICULARES
                    ARTICULO 76° PRIMERA FRACCION a través de este <span>AVISO DE PRIVACIDAD</span>, por lo que el presente tiene como fin informarle el
                    tipo de datos personales que recabamos de usted, cómo los usamos, manejamos y aprovechamos, y con quien los compartimos.
                </p>

                <p class="parrafo">
                    Este <span>AVISO DE PRIVACIDAD</span> regula la forma, términos y condiciones conforme a los cuales
                    <span>PANAMOTORS CENTER, S.A. DE C.V.</span>, incluyendo a sus empresas filiales, relacionadas y/o
                    subsidiarias, están facultadas y autorizadas por el “Titular” para obtener, tratar y transferir los datos personales
                    (en lo sucesivo los “Datos”) del “Titular”, para conocer dicho procedimiento del uso de sus datos ponemos a su alcance la pagina
                    web donde viene a detalle todo lo que necesita saber
                    <a href="https://www.panamotorscenter.com/demos/car/car-terminos-servicios.php">https://www.panamotorscenter.com/demos/car/car-terminos-servicios.php</a>
                </p>

                <p class="parrafo">
                    Sitios de terceros el sitio web de <span>PANAMOTORS CENTER, S.A. DE C.V.</span>, puede incluir enlaces a sitios web de terceros, si obtiene
                    acceso a dichos enlaces, abandonará el sitio web de <span style="white-space:nowrap; width: 50px;">PANAMOTORS CENTER, S.A. DE C.V.</span>,
                    por lo cual <span>PANAMOTORS CENTER, S.A. DE C.V.</span>, no
                    asumen ninguna responsabilidad en relación con esos sitios web de terceros. El “titular” en este acto manifiesta bajo protesta
                    de decir verdad que:
                </p>

                <p class="parrafo">
                    En caso de que este <span>AVISO DE PRIVACIDAD</span> esté disponible a través de una página electrónica (sitio Web, página de Internet, red
                    social o similar) o algún otro dispositivo electrónico, al hacer “clic” en “aceptar” o de cualquier otra  forma  seguir  navegando
                    en  el  sitio,  o  bien  al  proporcionar sus “Datos” a través  del mismo, constituye una manifestación de su consentimiento
                    para  que       el <span>AVISO DE PRIVACIDAD</span> realice el tratamiento de sus “Datos”, de conformidad con el presente <span>AVISO DE PRIVACIDAD.</span>
                </p>

                <p class="parrafo">
                    En caso de que este <span>AVISO DE PRIVACIDAD</span> esté disponible a través de medios sonoros, audiovisuales o de cualquier otra tecnología,
                    el hecho de proporcionar sus “Datos” constituye una manifestación de su consentimiento para <span>PANAMOTORS CENTER, S.A. DE C.V.</span>,
                    realice el tratamiento de sus “Datos” de conformidad con este <span>AVISO DE PRIVACIDAD.</span>
                </p>

                <p class="parrafo">
                    Que en caso de que este <span>AVISO DE PRIVACIDAD</span> esté disponible por escrito, su firma, rúbrica, nombre o huella o bien al proporcionar
                    sus “Datos” en cualquier parte del sitio, constituye una manifestación de su consentimiento para que <span>PANAMOTORS CENTER, S.A. DE C.V.</span>,
                    realice el tratamiento de sus “Datos”, de conformidad con este <span>AVISO DE PRIVACIDAD.</span>
                </p>

                <p class="parrafo">
                    Que toda la información que proporcione es veraz y completa, el “Titular” responderá en todo momento por los “Datos” proporcionados,
                     el medio para poder ejercer sus derechos ARCO (Acceso, Rectificación, cancelación y oposición) de sus datos personales, serán directamente
                      ante la empresa
                    <span> PANAMOTORS CENTER, S.A. DE C.V.</span>
                </p>
            </tr>
        </td>
        <tr>
            <td style="text-align:center;">
                <div class="" style="font-size:14px;margin-left:5%;margin-right: 5%; ">
                    <br><br><br><br><br><br><br><br><br>
                    <p>
                        <b style="border-top: solid 1.5px black;padding-left: 35px;padding-right: 35px;">
                            NOMBRE Y FIRMA DE ENTERADO
                        </b>
                    </p>
                </div>

            </td>
        </tr>
    </table>
</div>

</body>
</html>
