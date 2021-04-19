<?php
// session_start();
// include_once "../../config.php";
// $usuario_creador=$_SESSION['usuario_clave'];



function eliminar_tildes($cadena){

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
	/*$cadena = utf8_encode($cadena);*/

    //Ahora reemplazamos las letras
	$cadena = str_replace(
		array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		array('A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A'),
		$cadena
	);

	$cadena = str_replace(
		array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'),
		$cadena );

	$cadena = str_replace(
		array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		array('I', 'I', 'I', 'I', 'I', 'I', 'I', 'I'),
		$cadena );

	$cadena = str_replace(
		array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		array('O', 'O', 'O', 'O', 'O', 'O', 'O', 'O'),
		$cadena );

	$cadena = str_replace(
		array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		array('U', 'U', 'U', 'U', 'U', 'U', 'U', 'U'),
		$cadena );

	$cadena = str_replace(
		array('ñ', 'Ñ', 'ç', 'Ç'),
		array('n', 'N', 'c', 'C'),
		$cadena
	);

	return $cadena;
}


$saldo_total = 0;
$saldos = 0;

$count_principal_general=0;
$count_principal_general_x=0;
$fin = "";
$fin = "antes finiquito";
$reci=$id_proveedor;
$id_contacto=base64_decode($reci);
$n1=strlen($id_contacto);
$n1_aux=6-$n1;
$mat="";
for ($i=0; $i <$n1_aux ; $i++) {
	$mat.="0";
}
$id_contacto_completo=$mat.$id_contacto;

/*Start letras a numeros*/
function unidad($numuero) {
	switch ($numuero) {
		case 9:
		{
			$numu = "NUEVE ";
			break;
		}
		case 8:
		{
			$numu = "OCHO ";
			break;
		}
		case 7:
		{
			$numu = "SIETE ";
			break;
		}
		case 6:
		{
			$numu = "SEIS ";
			break;
		}
		case 5:
		{
			$numu = "CINCO ";
			break;
		}
		case 4:
		{
			$numu = "CUATRO";
			break;
		}
		case 3:
		{
			$numu = "TRES ";
			break;
		}
		case 2:
		{
			$numu = "DOS ";
			break;
		}
		case 1:
		{
			$numu = "UNO ";
			break;
		}
		case 0:
		{
			$numu = "";
			break;
		}
	}
	return $numu;
}

function decena($numdero) {
	if ($numdero >= 90 && $numdero <= 99) {
		$numd = "NOVENTA ";
		if ($numdero > 90)
			$numd = $numd."Y ".(unidad($numdero - 90));
	} else if ($numdero >= 80 && $numdero <= 89) {
		$numd = "OCHENTA ";
		if ($numdero > 80)
			$numd = $numd."Y ".(unidad($numdero - 80));
	} else if ($numdero >= 70 && $numdero <= 79) {
		$numd = "SETENTA ";
		if ($numdero > 70)
			$numd = $numd."Y ".(unidad($numdero - 70));
	} else if ($numdero >= 60 && $numdero <= 69) {
		$numd = "SESENTA ";
		if ($numdero > 60)
			$numd = $numd."Y ".(unidad($numdero - 60));
	} else if ($numdero >= 50 && $numdero <= 59) {
		$numd = "CINCUENTA ";
		if ($numdero > 50)
			$numd = $numd."Y ".(unidad($numdero - 50));
	} else if ($numdero >= 40 && $numdero <= 49) {
		$numd = "CUARENTA ";
		if ($numdero > 40)
			$numd = $numd."Y ".(unidad($numdero - 40));
	} else if ($numdero >= 30 && $numdero <= 39) {
		$numd = "TREINTA ";
		if ($numdero > 30)
			$numd = $numd."Y ".(unidad($numdero - 30));
	} else if ($numdero >= 20 && $numdero <= 29) {
		if ($numdero == 20)
			$numd = "VEINTE ";
		else
			$numd = "VEINTI".(unidad($numdero - 20));
	} else if ($numdero >= 10 && $numdero <= 19) {
		switch ($numdero) {
			case 10:
			{
				$numd = "DIEZ ";
				break;
			}
			case 11:
			{
				$numd = "ONCE ";
				break;
			}
			case 12:
			{
				$numd = "DOCE ";
				break;
			}
			case 13:
			{
				$numd = "TRECE ";
				break;
			}
			case 14:
			{
				$numd = "CATORCE ";
				break;
			}
			case 15:
			{
				$numd = "QUINCE ";
				break;
			}
			case 16:
			{
				$numd = "DIECISEIS ";
				break;
			}
			case 17:
			{
				$numd = "DIECISIETE ";
				break;
			}
			case 18:
			{
				$numd = "DIECIOCHO ";
				break;
			}
			case 19:
			{
				$numd = "DIECINUEVE ";
				break;
			}
		}
	} else
	$numd = unidad($numdero);
	return $numd;
}

function centena($numc) {
	if ($numc >= 100) {
		if ($numc >= 900 && $numc <= 999) {
			$numce = "NOVECIENTOS ";
			if ($numc > 900)
				$numce = $numce.(decena($numc - 900));
		} else if ($numc >= 800 && $numc <= 899) {
			$numce = "OCHOCIENTOS ";
			if ($numc > 800)
				$numce = $numce.(decena($numc - 800));
		} else if ($numc >= 700 && $numc <= 799) {
			$numce = "SETECIENTOS ";
			if ($numc > 700)
				$numce = $numce.(decena($numc - 700));
		} else if ($numc >= 600 && $numc <= 699) {
			$numce = "SEISCIENTOS ";
			if ($numc > 600)
				$numce = $numce.(decena($numc - 600));
		} else if ($numc >= 500 && $numc <= 599) {
			$numce = "QUINIENTOS ";
			if ($numc > 500)
				$numce = $numce.(decena($numc - 500));
		} else if ($numc >= 400 && $numc <= 499) {
			$numce = "CUATROCIENTOS ";
			if ($numc > 400)
				$numce = $numce.(decena($numc - 400));
		} else if ($numc >= 300 && $numc <= 399) {
			$numce = "TRESCIENTOS ";
			if ($numc > 300)
				$numce = $numce.(decena($numc - 300));
		} else if ($numc >= 200 && $numc <= 299) {
			$numce = "DOSCIENTOS ";
			if ($numc > 200)
				$numce = $numce.(decena($numc - 200));
		} else if ($numc >= 100 && $numc <= 199) {
			if ($numc == 100)
				$numce = "CIEN ";
			else
				$numce = "CIENTO ".(decena($numc - 100));
		}
	} else
	$numce = decena($numc);
	return $numce;
}

function miles($nummero) {
	if ($nummero >= 1000 && $nummero < 2000) {
		$numm = "MIL ".(centena($nummero%1000));
	}
	if ($nummero >= 2000 && $nummero <10000) {
		$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
	}
	if ($nummero < 1000)
		$numm = centena($nummero);
	return $numm;
}

function decmiles($numdmero) {
	if ($numdmero == 10000)
		$numde = "DIEZ MIL ";
	if ($numdmero > 10000 && $numdmero <20000) {
		$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
	}
	if ($numdmero >= 20000 && $numdmero <100000) {
		$numde = decena(Floor($numdmero/1000))."MIL ".(miles($numdmero%1000));
	}
	if ($numdmero < 10000)
		$numde = miles($numdmero);
	return $numde;
}

function cienmiles($numcmero){
	if ($numcmero == 100000)
		$num_letracm = "CIEN MIL ";
	if ($numcmero >= 100000 && $numcmero <1000000) {
		$num_letracm = centena(Floor($numcmero/1000))."MIL ".(centena($numcmero%1000));
	}
	if ($numcmero < 100000)
		$num_letracm = decmiles($numcmero);
	return $num_letracm;
}

function millon($nummiero) {
	if ($nummiero >= 1000000 && $nummiero <2000000) {
		$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
	}
	if ($nummiero >= 2000000 && $nummiero <10000000){
		$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
	}
	if ($nummiero < 1000000)
		$num_letramm = cienmiles($nummiero);
	return $num_letramm;
}

function decmillon($numerodm) {
	if ($numerodm == 10000000)
		$num_letradmm = "DIEZ MILLONES ";
	if ($numerodm > 10000000 && $numerodm <20000000){
		$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
	}
	if ($numerodm >= 20000000 && $numerodm <100000000){
		$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(millon($numerodm%1000000));
	}
	if ($numerodm < 10000000)
		$num_letradmm = millon($numerodm);
	return $num_letradmm;
}

function cienmillon($numcmeros) {
	if ($numcmeros == 100000000)
		$num_letracms = "CIEN MILLONES ";
	if ($numcmeros >= 100000000 && $numcmeros <1000000000) {
		$num_letracms = centena(Floor($numcmeros/1000000))."MILLONES ".(millon($numcmeros%1000000));
	}
	if ($numcmeros < 100000000)
		$num_letracms = decmillon($numcmeros);
	return $num_letracms;
}

function milmillon($nummierod) {
	if ($nummierod >= 1000000000 && $nummierod <2000000000) {
		$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
	}
	if ($nummierod >= 2000000000 && $nummierod <10000000000) {
		$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
	}
	if ($nummierod < 1000000000)
		$num_letrammd = cienmillon($nummierod);
	return $num_letrammd;
}

function convertir($numero){
	$num = str_replace(",","",$numero);
	$num = number_format($num,2,'.','');
	$cents = substr($num,strlen($num)-2,strlen($num)-1);
	$num = (int)$num;
	$numf = milmillon($num);
	return $numf." PESOS ".$cents."/100 M/N";
}
/*End letras a numeros*/






$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

date_default_timezone_set('America/Mexico_City');
$date = date_create();
$dia = date_format($date, 'd');
$mes_aux = date_format($date, 'm');
$mes = ucfirst($meses[$mes_aux-1]);
$ano = date_format($date, 'Y');
$hora = date_format($date, 'H:i:s');
/*Start Contactos*/
// $sql = "SELECT *FROM proveedores WHERE idproveedores='$id_contacto'";
//echo $sql;
// $result = mysql_query($sql);
foreach ($proveedor as $key => $value) {
	$nombre = $value->nombre;
	$apellidos = $value->apellidos;
	$alias = $value->alias;
	$correo = $value->email;
	$telefono1 = $value->telefono_celular;
	$telefono2 = $value->telefono_otro;
	$calle = $value->calle;
	$colonia = $value->colonia;
	$municipio = $value->delmuni;
	$estado = $value->estado;

  $linea_credito = $value->linea_credito;
	if($value->linea_credito != "N/A") $linea_credito = "$ ".number_format($value->linea_credito,2);
	/*Start Converción de telefonos*/
	if ($telefono1 == "0000000000") {
		$telefono1 = "N/A";
	}
	if ($telefono2 == "0000000000") {
		$telefono2 = "N/A";
	}
	/*End Conversión telefonos*/
	/*Start conversión dirección*/
	if ($calle != "") {
		$calle_v = $calle.", ";
	}

	if ($colonia != "") {
		$colonia_v = $colonia.", ";
	}
	/*End conversión dirección*/
	/*Start nomenclaturas*/
	// $sql1 = "SELECT nomeclatura FROM asesores WHERE idasesores='$value[asesor]'";
	// $result1 = mysql_query($sql1);
	// while ($fila1 = mysql_fetch_array($result1)) {
		// $asesor = "$fila1[nomeclatura]";
	// }

	/*$sql2 = "SELECT nomeclatura FROM clientes_tipos WHERE idclientes_tipos='$fila[tipo_cliente]'";
	$result2 = mysql_query($sql2);
	while ($fila2 = mysql_fetch_array($result2)) {
		$tipo_cliente = "$fila2[nomeclatura]";
	}*/
	$tipo_cliente="P";
	// $sql3 = "SELECT nombre FROM credito_tipos WHERE idcredito_tipos='$value[tipo_credito]'";
	// $result3 = mysql_query($sql3);
	// while ($fila3 = mysql_fetch_array($result3)) {
	// 	$tipo_credito = "$fila3[nombre]";
	// }
	/*End nomenclaturas*/
}
/*End Contactos*/

//*************************************************************************************************************************************************************************************************************************************************************
/*End Contactos*/
$sqlX2 = "TRUNCATE TABLE estado_cuenta_orden_fechas_proveedores";///------------------------------------------------------
// $resultX2 = mysql_query($sqlX2);
/*Datos complementarios de dirección*/
$domicilio_completo=ucfirst($calle.$colonia.$municipio.", ".$estado);


$count_orden=1;
// $sql101x = "SELECT * FROM estado_cuenta_proveedores WHERE idcontacto = '$id_contacto' and visible = 'SI' ORDER BY fecha_movimiento ASC";
// $result101x = mysql_query($sql101x);
foreach($estado_cuenta_proveedores as $value) {

	if($value->concepto=='Compra Directa' || $value->concepto=='Cuenta de Deuda' || $value->concepto=='Compra Permuta' || $value->concepto=='Devolución del VIN' || $value->concepto=='Consignación'  || $value->concepto=='Devolucion del VIN' || $value->concepto=='Consignacion'){
		$sql4 = "INSERT INTO estado_cuenta_orden_fechas_proveedores (idestado_cuenta_orden_fechas_proveedores, concepto, apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, serie_monto, monto_total, tipo_moneda, tipo_cambio, gran_total, cargo, abono, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, datos_marca, datos_version, datos_color, datos_modelo, datos_vin, datos_precio, datos_estatus, asesor1, enlace1, asesor2, enlace2, coach, archivo, comentarios, idcontacto, comision, visible, comentarios_eliminacion, usuario_elimino, fecha_eliminacion, usuario_creador, fecha_creacion, fecha_guardado, orden) values('$value[0]', '$value->concepto',  '$value[2]',  '$value[3]',  '$value[4]',  '$value[5]',  '$value[6]',  '$value[7]',  '$value[8]',  '$value[9]',  '$value[10]',  '$value[11]',  '$value[12]',  '$value[13]',  '$value[14]',  '$value[15]',  '$value[16]',  '$value[17]',  '$value[18]',  '$value[19]',  '$value[20]',  '$value[21]',  '$value[22]',  '$value[23]',  '$value[24]',  '$value[25]',  '$value[26]',  '$value[27]',  '$value[28]',  '$value[29]',  '$value[30]',  '$value[31]',  '$value[32]',  '$value[33]',  '$value[34]',  '$value[35]',  '$value[36]',  '$value[37]',  '$value[38]',  '$value[39]',  '$value[40]',  '$value[41]',  '0001-01-01 00:00:00',  '$value[43]',  '$value[44]',  '$value[45]', '$count_orden' )";
		$result4 = mysql_query($sql4);
		$count_orden++;
	}
	else{
		if($value->concepto=='Abono'){
			$sql101y="SELECT * FROM abonos_unidades_proveedores WHERE idestado_cuenta_movimiento='$value[0]' and visible = 'SI';";
			$result101y=mysql_query($sql101y);
			if(mysql_num_rows($result101y)<=1){
				$sql4 = "INSERT INTO estado_cuenta_orden_fechas_proveedores (idestado_cuenta_orden_fechas_proveedores, concepto, apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, serie_monto, monto_total, tipo_moneda, tipo_cambio, gran_total, cargo, abono, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, datos_marca, datos_version, datos_color, datos_modelo, datos_vin, datos_precio, datos_estatus, asesor1, enlace1, asesor2, enlace2, coach, archivo, comentarios, idcontacto, comision, visible, comentarios_eliminacion, usuario_elimino, fecha_eliminacion, usuario_creador, fecha_creacion, fecha_guardado, orden) values('$value[0]', '$value->concepto',  '$value[2]',  '$value[3]',  '$value[4]',  '$value[5]',  '$value[6]',  '$value[7]',  '$value[8]',  '$value[9]',  '$value[10]',  '$value[11]',  '$value[12]',  '$value[13]',  '$value[14]',  '$value[15]',  '$value[16]',  '$value[17]',  '$value[18]',  '$value[19]',  '$value[20]',  '$value[21]',  '$value[22]',  '$value[23]',  '$value[24]',  '$value[25]',  '$value[26]',  '$value[27]',  '$value[28]',  '$value[29]',  '$value[30]',  '$value[31]',  '$value[32]',  '$value[33]',  '$value[34]',  '$value[35]',  '$value[36]',  '$value[37]',  '$value[38]',  '$value[39]',  '$value[40]',  '$value[41]',  '0001-01-01 00:00:00',  '$value[43]',  '$value[44]',  '$value[45]', '$count_orden' )";
				$result4 = mysql_query($sql4);
				$count_orden++;
			}else{
				while($fila101y=mysql_fetch_array($result101y)){
					$sql4 = "INSERT INTO estado_cuenta_orden_fechas_proveedores (idestado_cuenta_orden_fechas_proveedores, concepto, apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, serie_monto, monto_total, tipo_moneda, tipo_cambio, gran_total, cargo, abono, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, datos_marca, datos_version, datos_color, datos_modelo, datos_vin, datos_precio, datos_estatus, asesor1, enlace1, asesor2, enlace2, coach, archivo, comentarios, idcontacto, comision, visible, comentarios_eliminacion, usuario_elimino, fecha_eliminacion, usuario_creador, fecha_creacion, fecha_guardado, orden) values('$value[0]', '$value->concepto',  '$value[2]',  '$value[3]',  '$value[4]',  '$value[5]',  '$value[6]',  '$fila10y[cantidad_inicial]',  '$fila101y[cantidad_pendiente]',  '$fila101y[cantidad_pago]',  '$value[10]',  '$value[11]',  '$value[12]',  '$value[13]',  '$value[14]',  '$value[15]',  '$value[16]',  '$value[17]',  '$value[18]',  '$value[19]',  '$value[20]',  '$value[21]',  '$value[22]',  '$value[23]',  '$value[24]',  '$value[25]',  '$value[26]',  '$value[27]',  '$value[28]',  '$value[29]',  '$value[30]',  '$value[31]',  '$value[32]',  '$value[33]',  '$value[34]',  '$value[35]',  '$value[36]',  '$value[37]',  '$value[38]',  '$value[39]',  '$value[40]',  '$value[41]',  '0001-01-01 00:00:00',  '$value[43]',  '$value[44]',  '$value[45]', '$count_orden' )";
					$result4 = mysql_query($sql4);
					$count_orden++;
				}
			}
		}
	}
	//$count_orden++;
}
//*************************************************************************************************************************************************************************************************************************************************************


$idestado_cuenta_general = "";
$COUNT=0;
$bandera = false;
$contador =0;
$count_verifica_mov = 0;

$ref = "";

$contador=0;
$sql100 = "SELECT * FROM estado_cuenta_proveedores WHERE idcontacto = '$id_contacto' and visible = 'SI'";
//echo $sql100;
$result100 = mysql_query($sql100);
while ($fila100 = mysql_fetch_array($result100)) {
	$contador++;
	$date = date_create($fila100['fecha_movimiento']);
	$fecha_bien=date_format($date, 'd-m-Y');
	$tabla_movimientos .= imprimir("$fila100[idestado_cuenta_proveedores]", "$fila100[monto_precio]", $id_contacto, $contador, $fecha_bien);
	//echo "<br>$tabla_movimientos";******************************************************************************************************************************************************************************************************************
}


function imprimir($idec, $mt_total, $idc, $contador, $fechas_mv){
	global $saldo_total;
	global $saldos;
	$sql6 = "SELECT * FROM estado_cuenta_proveedores WHERE idcontacto = '$idc' and visible = 'SI' and idestado_cuenta_proveedores ='$idec'";
	//echo $sql6;
	//$imp=$sql6;
	$result6 = mysql_query($sql6);
	while ($fila6 = mysql_fetch_array($result6)) {
		//$contador.=".- "." "."$fila6[idestado_cuenta_proveedores]"."=>"."$fila6[concepto]"." ";//."$fila6[fecha_movimiento]"."<br>";
		/*Start venta permuta*/
		/*End venta permuta*/
		/*Start apartado*/
		$folio=$fila6[col1];
		if ($fila6['concepto']=="Abono" || $fila6['concepto']=="Otros Abonos" || $fila6['concepto']=="Enganche" || $fila6['concepto']=="Finiquito" || $fila6['concepto']=="Apartado" || $fila6['concepto']=="Anticipo de Compra" || $fila6['concepto']=="Movimiento Post-Venta" || $fila6['concepto']=="Descuento por Pago Anticipado" || $fila6['concepto']=="Aclaración"  || $fila6['concepto']=="Intereses" || $fila6['concepto']=="Interés"  || $fila6['concepto']=="Finiquito de VIN" || $fila6['concepto']=="Finiquito de Deuda" || $fila6['concepto']=="Aclaración de Cuentas" || $fila6['concepto']=="Traspaso"|| $fila6['concepto']=="Legalizacion" || $fila6['concepto']=="Comision de Compra"  || $fila6['concepto']=="Anticipo de Comision" || $fila6['concepto']=="Devolución Monetaria" || $fila6['concepto']=="Crédito" || $fila6['concepto']=="Traslado" || $fila6['concepto']=="Gastos Diversos de Financiamiento" || $fila6['concepto']=="Comisión por Mediación Mercantil"|| $fila6['concepto']=="Devolución de Comisión por Mediación Mercantil") {
			$tipo_mon = "";
			$cambio = "";
			$cantidad = "";

			if ($fila6[tipo_moneda] == "MXN" || $fila6[tipo_moneda] == "USD" || $fila6[tipo_moneda] == "CAD") {
				$cambio = number_format($fila6[tipo_cambio],2);
				$tipo_mon = "Moneda: $fila6[tipo_moneda]<br> T. Cambio: $cambio<br>";
				$cantidad = "Cantidad: ".number_format($fila6[gran_total], 2)."<br>";
			}else{
				$tipo_mon = "";
				$cantidad = "";
			}
			//--------------- INICIO Conversión de ATC a Atención a Clientes
			if ($fila6[emisora_institucion]=="ATC") {
				$emisora_institucion = "Atención a Clientes";
			}else{
				$emisora_institucion = $fila6[emisora_institucion];
			}
			if ($fila6[emisora_agente]=="ATC") {
				$emisora_agente = "Atención a Clientes";
			}else{
				$emisora_agente = $fila6[emisora_agente];
			}
			if ($fila6[receptora_institucion]=="ATC") {
				$receptora_institucion = "Atención a Clientes";
			}else{
				$receptora_institucion = $fila6[receptora_institucion];
			}
			if ($fila6[receptora_agente]=="ATC") {
				$receptora_agente = "Atención a Clientes";
			}else{
				$receptora_agente = $fila6[receptora_agente];
			}
			//---------------    FIN Conversión de ATC a Atención a Clientes
			/*Start definición cargo abono*/
			if ($fila6['abono']!="") {
				$abono=number_format($mt_total,2);
			} else { $abono=""; }
			if ($fila6['cargo']!="") {
				$cargo=number_format($mt_total,2);
			} else { $cargo=""; }
			if ($fila6['tipo_movimiento']=="abono") {
				$cargo_abono_texto="<td><span></span></td>
				<td><span>$ $abono</span></td>";
				$saldo_total = $saldos - $mt_total;
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);
				$monto_precio_formato_letras= convertir($abono);
				$montos_abono_cargo = "Monto: $ $abono ($monto_precio_formato_letras)<br>";
				$total = "";
			}
			if ($fila6['tipo_movimiento']=="cargo") {
				$cargo_abono_texto="<td><span>$ $cargo</span></td>
				<td><span></span></td>";
				$saldo_total = $saldos + $mt_total;
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);
				$monto_precio_formato_letras= convertir($cargo);
				$montos_abono_cargo = "Monto: $ $cargo ($monto_precio_formato_letras)<br>";
				$total = "Total: $ $cargo";
			}
			//$saldo_total = "P";
			$fecha_movimiento_bien="";
			$date = date_create($fila6['fecha_movimiento']);
			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
			$monto_precio_formato_letras= convertir($abono);
			$folio_aplicado=$fila6[col1]." (".$fila6[col2].")";
			/*End definición cargo abono*/
			if($fila6[concepto]=="Legalizacion" || $fila6[concepto]=="Comision de Compra"){
				$texto_informacion="Método de pago: $fila6[metodo_pago]<br>
				$montos_abono_cargo
				$tipo_mon
				$cantidad
				I. Emisora: $emisora_institucion<br>
				A. Emisor: $emisora_agente<br>
				I. Receptora: $receptora_institucion<br>
				A. Receptor: $receptora_agente<br>
				Tipo de Comprobante: $fila6[tipo_comprobante]<br>
				No. de Referencia: $fila6[referencia]<br>
				Folio: $folio_aplicado<br>";
			}else{
				$texto_informacion="Método de pago: $fila6[metodo_pago]<br>
				$montos_abono_cargo
				$tipo_mon
				$cantidad
				I. Emisora: $emisora_institucion<br>
				A. Emisor: $emisora_agente<br>
				I. Receptora: $receptora_institucion<br>
				A. Receptor: $receptora_agente<br>
				Tipo de Comprobante: $fila6[tipo_comprobante]<br>
				No. de Referencia: $fila6[referencia]<br>
				Folio: $folio_aplicado<br>
				No. de Actividad: $fila6[col3]<br>
				Depositante: $fila6[col4]<br>";
			}
			$fechas_mv = str_replace(",", "<br>", $fechas_mv);
			$tabla_movimientos.="<tr>
			<td><span>$contador</span></td>
			<td><span>$fechas_mv</span></td>
			<td><span>$fila6[concepto]</span></td>
			<td></td>
			<td><span>$texto_informacion</span></td>
			$cargo_abono_texto
			<td><span>$ $saldo_total</span></td>
			</tr>";
		}
		/*End apartado, enganche*/
		/*Start apartado*/
		else if ($fila6['concepto']=="Devolucion" || $fila6['concepto']=="Interés") {
		//--------------- INICIO Conversión de ATC a Atención a Clientes
			if ($fila6[emisora_institucion]=="ATC") {
				$emisora_institucion = "Atención a Clientes";
			}else{
				$emisora_institucion = $fila6[emisora_institucion];
			}
			if ($fila6[emisora_agente]=="ATC") {
				$emisora_agente = "Atención a Clientes";
			}else{
				$emisora_agente = $fila6[emisora_agente];
			}
			if ($fila6[receptora_institucion]=="ATC") {
				$receptora_institucion = "Atención a Clientes";
			}else{
				$receptora_institucion = $fila6[receptora_institucion];
			}
			if ($fila6[receptora_agente]=="ATC") {
				$receptora_agente = "Atención a Clientes";
			}else{
				$receptora_agente = $fila6[receptora_agente];
			}
			//---------------    FIN Conversión de ATC a Atención a Clientes
			/*Start definición cargo abono*/
			if ($fila6['abono']!="") {
				$abono=number_format($mt_total,2);
			} else { $abono=""; }
			if ($fila6['cargo']!="") {
				$cargo=number_format($mt_total,2);
			} else { $cargo=""; }
			if ($fila6['tipo_movimiento']!="abono") {
				$cargo_abono_texto="<td><span></span></td>
				<td><span>$ $abono</span></td>";
				$saldo_total = $saldos - $mt_total;
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);
			}
			if ($fila6['tipo_movimiento']!="cargo") {
				$cargo_abono_texto="<td><span>$ $abono</span></td>
				<td><span></span></td>";
				$saldo_total = $saldos + $mt_total;
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);
			}
			//$saldo_total = "P";
			$fecha_movimiento_bien="";
			$date = date_create($fila6['fecha_movimiento']);
			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
			$monto_precio_formato_letras= convertir($abono);
			/*End definición cargo abono*/
			$texto_informacion="Método de pago: $fila6[metodo_pago]<br>
			Monto: $ $abono ($monto_precio_formato_letras)<br>
			$tipo_mon
			$cantidad
			I. Emisora: $emisora_institucion<br>
			A. Emisor: $emisora_agente<br>
			I. Receptora: $receptora_institucion<br>
			A. Receptor: $receptora_agente<br>
			Tipo de Comprobante: $fila6[tipo_comprobante]<br>
			No. de Referencia: $fila6[referencia]<br>";
			$tabla_movimientos.="<tr>
			<td><span>$contador</span></td>
			<td><span>$fecha_movimiento_bien</span></td>
			<td><span>$fila6[concepto]<br>$folio</span></td>
			<td></td>
			<td><span>$texto_informacion</span></td>
			$cargo_abono_texto
			<td><span>$ $saldo_total</span></td>
			</tr>";
		}
		/*End apartado, enganche*/
		/*Start venta directa*/
		else if ($fila6['concepto']=="Venta Directa" || $fila6['concepto']=="Venta Permuta" || $fila6['concepto']=="Compra Directa" || $fila6['concepto']=="Compra Permuta" || $fila6['concepto']=="Cuenta de Deuda" || $fila6['concepto']=="Consignacion" || $fila6['concepto']=="Devolución del VIN") {
			$tipo_mon = "";
			$cambio = "";
			$cantidad = "";
			if ($fila6[tipo_moneda] == "MXN" || $fila6[tipo_moneda] == "USD" || $fila6[tipo_moneda] == "CAD") {
				$cambio = number_format($fila6[tipo_cambio],2);
				$tipo_mon = "Moneda: $fila6[tipo_moneda]<br> T. Cambio: $cambio<br>";
				$cantidad = "Cantidad: ".number_format($fila6[gran_total], 2)."<br>";
			}else{
				$tipo_mon = "";
				$cantidad = "";
			}

			if ($fila6[datos_estatus] == "Pagada") {
				$estatus_unidad="Estatus:  <span  style='color:#00b248; font-size:12px;'><b>$fila6[datos_estatus]</b></span><br>";
			}else{
				$estatus_unidad="Estatus:  <span  style='color:red; font-size:12px;'><b>$fila6[datos_estatus]</b></span><br>";
			}



  	//--------------- INICIO Conversión de ATC a Atención a Clientes
			if ($fila6[emisora_institucion]=="ATC") {
				$emisora_institucion = "Atención a Clientes";
			}else{
				$emisora_institucion = $fila6[emisora_institucion];
			}
			if ($fila6[emisora_agente]=="ATC") {
				$emisora_agente = "Atención a Clientes";
			}else{
				$emisora_agente = $fila6[emisora_agente];
			}
			if ($fila6[receptora_institucion]=="ATC") {
				$receptora_institucion = "Atención a Clientes";
			}else{
				$receptora_institucion = $fila6[receptora_institucion];
			}
			if ($fila6[receptora_agente]=="ATC") {
				$receptora_agente = "Atención a Clientes";
			}else{
				$receptora_agente = $fila6[receptora_agente];
			}
  //---------------    FIN Conversión de ATC a Atención a Clientes

			/*Start fecha formato*/
			$fecha_movimiento_bien="";
			$date = date_create($fila6['fecha_movimiento']);
			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
			/*End fecha formato*/
			/*Start color estatus*/
			if ($fila6['datos_estatus']=="Pagada" && $fila6['concepto']=="Venta Directa" || $fila6['datos_estatus']=="Pagada" && $fila6['concepto']=="Venta Permuta" ) {
				$color_cuenta="class='estatus-abono-positivo'";
			}else if ($fila6['datos_estatus']=="Pendiente" && $fila6['concepto']=="Venta Directa" || $fila6['datos_estatus']=="Pendiente" && $fila6['concepto']=="Venta Permuta") {
				$color_cuenta="class='estatus-abono-negativo'";
			}else{
				$color_cuenta="class='estatus-abono-neutro'";
			}
			/*End color estatus*/
			/*Start number format precio unidad*/
			if ($fila6['datos_precio']!="") {
				$precio_unidad=number_format("$fila6[datos_precio]",2);
			}else{ $precio_unidad=""; }

			$saldo_unidad = "";
			$sql85= "SELECT *FROM abonos_unidades_proveedores WHERE idestado_cuenta='$fila6[idestado_cuenta_orden_fechas_proveedores]' AND visible='SI'";
			$result85=mysql_query($sql85);
			while ( $fila85 = mysql_fetch_array($result85)) {
				$saldo_unidad = $saldo_unidad + $fila85[cantidad_pago];
			}
			$saldo_unidad = $fila6[datos_precio]-$saldo_unidad;
			$saldo_unidad = "Saldo: $ ".number_format($saldo_unidad, 2);
			/*End number format precio unidad*/
			/*Start datos*/

			if ($fila6['concepto']=="Comisión por Mediación Mercantil") {
				$datos_pe= "$estatus_unidad<br>";
			}else{
				$datos_pe="Precio: $ $precio_unidad<br>
				$saldo_unidad<br>
				$estatus_unidad";
			}



			$texto_datos="
			Marca: $fila6[datos_marca]<br>
			Versión: $fila6[datos_version]<br>
			Modelo: $fila6[datos_modelo]<br>
			Color: $fila6[datos_color]<br>
			VIN: $fila6[datos_vin]<br>
			$datos_pe
			";
			/*End datos*/
			/*Start conversion de numeros a letras*/
			$monto_precio_formato_letras= convertir($fila6['monto_precio']);
			$monto_precio_formato_letras_m_pago= convertir($m_pago);
			/*End conversion de numeros a letras*/
			/*Start definición cargo abono*/
			$abono=0;
			$cargo=0;
			if ($fila6['abono']!="") {
				$abono=number_format("$fila6[abono]",2);
			} else { $abono=""; }

			if ($fila6['cargo']!="") {
				$cargo=number_format("$fila6[cargo]",2);
			} else { $cargo=""; }

			if ($fila6['tipo_movimiento']=="abono") {
				$cargo_abono_texto="<td><span></span></td>
				<td><span>$ $abono</span></td>";
			}
			if ($fila6['tipo_movimiento']=="cargo") {
				$cargo_abono_texto="<td><span>$ $cargo</span></td>
				<td><span></span></td>";
				$saldo_total = $saldos + "$fila6[cargo]";
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);
			}
    //$saldo_total = "P";
			if ($fila6['monto_total']!="") {
				$monto_total_general=number_format($fila6['monto_total'],2);
			}else{ $monto_total_general="";}
			/*Start información*/
			$general_monto="";
			$general_monto="Serie: "."$fila6[serie_monto]";
			/*Start number format precio unidad*/
			if ($fila6['datos_precio']!="") {
				$precio_unidad=number_format("$fila6[datos_precio]",2);
			}else{ $precio_unidad=""; }
			$monto_total_general=$precio_unidad;
			/*End number format precio unidad*/
    ///Pagares
			$lista_pagares_titulo="";
			$lista_pagares="";
			$sql20= "SELECT *FROM documentos_pagar WHERE idestado_cuenta='$fila6[idestado_cuenta_orden_fechas_proveedores]'";
			$result20=mysql_query($sql20);

			while ( $fila1 = mysql_fetch_array($result20)) {
				$monto_precio_formato=number_format($fila1['monto'],2);
				$saldo_letras= convertir($fila1['monto']);

				$sql201= "SELECT *FROM abonos_pagares_proveedores WHERE iddocumentos_pagar='$fila1[iddocumentos_pagar]'";
				$result201=mysql_query($sql201);
				if(mysql_num_rows($result201)==0){
					$saldo_actual=$monto_precio_formato;
				}else{
					while ( $fila11 = mysql_fetch_array($result201)) {
						$saldo_actual=number_format($fila11['cantidad_pendiente'],2);
					}
				}

# dias transcurridos
				if ($fila1['estatus'] == "Pendiente" && $saldo_actual != "0.00" ) {
					date_default_timezone_set('America/Mexico_City');
					$fechaactual1= date("Y-m-d H:i:s");
					$time_difference1 = strtotime($fechaactual1) - strtotime($fila1['fecha_vencimiento']) ;
					$dias=floor($time_difference1/86400);
					$aux31=$dias*86400;
					$aux41=$time_difference1-$aux31;
					$hours1 = floor($aux41 / 3600);
					$aux1=$hours1*3600;
    //echo "aux ".$aux;
					$aux11=$aux41-$aux1;
    //echo " aux 1  ".$aux1;
					$minutes1 = floor( $aux11 / 60);
    //echo " minuties: ".$minutes;
					$aux21=$minutes1*60;
    //echo " Aux2: ".$aux2;
					$seconds1 = $aux11-$aux21 ;
					if ($dias<0) {
						$dias=0;
					}
					if ($hours1=="0") {
						$hours1="00";
					}
					if ($hours1>"0" && $hours1<"10") {
						$hours1="0".$hours1;
					}
					if ($minutes1=="0") {
						$minutes1="00";
					}
					if ($minutes1>"0" && $minutes1<"10") {
						$minutes1="0".$minutes1;
					}
					if ($seconds1=="0") {
						$seconds1="00";
					}
					if ($seconds1>"0" && $seconds1<"10") {
						$seconds1="0".$seconds1;
					}
					$tiempo_solucion="<br>Días Trascurridos: ".$dias."<br>";
				}else{
					$tiempo_solucion = "<br>";
				}
# dias transcurridos
				$vencimientof = date_create($fila1[fecha_vencimiento]);
				$vencimientof = date_format($vencimientof, "d-m-Y");
				$lista_pagares_titulo="Documentos por Pagar:<br>";
				$lista_pagares.="Serie: $fila1[num_pagare]<br>
				Monto: $ $monto_precio_formato<br> ($saldo_letras)<br>
				Vencimiento: $vencimientof
				$tiempo_solucion
				Saldo: $ $saldo_actual<br>
				Estatus: $fila1[estatus]<br>
				";
 }//Fin de consulta pagares
 if($fila6[concepto]=="Cuenta de Deuda")
 	$conc="A ".$fila6[concepto];
 else
 	$conc=$fila6[concepto];
 if ($fila6[referencia] == "N/A" || $fila6[referencia] == "S/N") {
 	$ref_nueva = "";
 }else{
 	$ref_nueva = "No. de Referencia: $fila6[referencia]<br>";
 }


 $sqly="SELECT *FROM estado_cuenta_proveedores WHERE idestado_cuenta_proveedores='$fila6[idestado_cuenta_proveedores]';";
 $resulty=mysql_query($sqly);
 while($filay=mysql_fetch_array($resulty)){
 	$folio_nuevo=$filay[col1];
 	$folio_anterior=$filay[col2];
 	$actividad=$filay[col3];
 	$depositante=$filay[col4];
 }
    /// Fin de Pagares
 /*$texto_informacion=
			$montos_abono_cargo
			*/
			$texto_informacion="
			Precio: $ $precio_unidad ($monto_precio_formato_letras)<br>
			$tipo_mon
			$cantidad
			I. Emisora: $emisora_institucion<br>
			A. Emisor: $emisora_agente<br>
			I. Receptora: $receptora_institucion<br>
			A. Receptor: $receptora_agente<br>
			Tipo de Comprobante: $fila6[tipo_comprobante]<br>
			".$ref_nueva."

			"." ".$lista_pagares_titulo." ".$lista_pagares."
			Folio: ".$folio_nuevo." (".$folio_anterior.")<br>";
			/*End información*/
			$tabla_movimientos.="<tr>
			<td><span>$contador</span></td>
			<td><span>$fecha_movimiento_bien</span></td>
			<td><span>$conc<br>$folio_nuevo</span></td>
			<td $color_cuenta><span>$texto_datos</span></td>
			<td><span>$texto_informacion</span></td>
			$cargo_abono_texto
			<td><span>$ $saldo_total</span></td>
			</tr>";
		}
		/*End venta directa*/
		/*Start apartado*/
		else if ($fila6['concepto']=="Otros Cargos") {
		//--------------- INICIO Conversión de ATC a Atención a Clientes
			if ($fila6[emisora_institucion]=="ATC") {
				$emisora_institucion = "Atención a Clientes";
			}else{
				$emisora_institucion = $fila6[emisora_institucion];
			}
			if ($fila6[emisora_agente]=="ATC") {
				$emisora_agente = "Atención a Clientes";
			}else{
				$emisora_agente = $fila6[emisora_agente];
			}
			if ($fila6[receptora_institucion]=="ATC") {
				$receptora_institucion = "Atención a Clientes";
			}else{
				$receptora_institucion = $fila6[receptora_institucion];
			}
			if ($fila6[receptora_agente]=="ATC") {
				$receptora_agente = "Atención a Clientes";
			}else{
				$receptora_agente = $fila6[receptora_agente];
			}
  //---------------    FIN Conversión de ATC a Atención a Clientes

			/*Start definición cargo abono*/
			if ($fila6['abono']!="") {
				$abono=number_format($mt_total,2);
			} else { $abono=""; }

			if ($fila6['cargo']!="") {
				$cargo=number_format($mt_total,2);
			} else { $cargo=""; }

			if ($fila6['tipo_movimiento']!="abono") {
				$cargo_abono_texto="<td><span></span></td>
				<td><span>$ $abono</span></td>";
				$saldo_total = $saldos - $mt_total;
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);
			}
			if ($fila6['tipo_movimiento']!="cargo") {
				$cargo_abono_texto="<td><span>$ $abono</span></td>
				<td><span></span></td>";
				$saldo_total = $saldos + $mt_total;
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);

			}
    //$saldo_total = "P";
			$fecha_movimiento_bien="";
			$date = date_create($fila6['fecha_movimiento']);
			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
			$monto_precio_formato_letras= convertir($abono);
			/*End definición cargo abono*/

			$texto_informacion="Método de pago: $fila6[metodo_pago]<br>
			Monto: $ $abono ($monto_precio_formato_letras)<br>
			$tipo_mon
			$cantidad
			I. Emisora: $emisora_institucion<br>
			A. Emisor: $emisora_agente<br>
			I. Receptora: $receptora_institucion<br>
			A. Receptor: $receptora_agente<br>
			Tipo de Comprobante: $fila6[tipo_comprobante]<br>
			No. de Referencia: $fila6[referencia]<br>
			";


			$tabla_movimientos.="<tr>
			<td><span>$contador</span></td>
			<td><span>$fecha_movimiento_bien</span></td>
			<td><span>$fila6[concepto]</span></td>
			<td></td>
			<td><span>$texto_informacion</span></td>
			$cargo_abono_texto
			<td><span>$ $saldo_total</span></td>
			</tr>";
		}else if ($fila6['concepto']=="Devolución Prestamo") {

			$tipo_mon = "";
			$cambio = "";
			$cantidad = "";
			if ($fila6[tipo_moneda] == "MXN" || $fila6[tipo_moneda] == "USD" || $fila6[tipo_moneda] == "CAN") {
				$cambio = number_format($fila6[tipo_cambio],2);
				$tipo_mon = "Moneda: $fila6[tipo_moneda]<br> T. Cambio: $cambio<br>";
				$cantidad = "Cantidad: ".number_format($fila6[gran_total], 2)."<br>";
			}else{
				$tipo_mon = "";
				$cantidad = "";
			}

  	//--------------- INICIO Conversión de ATC a Atención a Clientes
			if ($fila6[emisora_institucion]=="ATC") {

				$emisora_institucion = "Atención a Clientes";
			}else{
				$emisora_institucion = $fila6[emisora_institucion];
			}
			if ($fila6[emisora_agente]=="ATC") {
				$emisora_agente = "Atención a Clientes";
			}else{
				$emisora_agente = $fila6[emisora_agente];
			}
			if ($fila6[receptora_institucion]=="ATC") {
				$receptora_institucion = "Atención a Clientes";
			}else{
				$receptora_institucion = $fila6[receptora_institucion];
			}
			if ($fila6[receptora_agente]=="ATC") {
				$receptora_agente = "Atención a Clientes";
			}else{
				$receptora_agente = $fila6[receptora_agente];
			}
  //---------------    FIN Conversión de ATC a Atención a Clientes

			/*Start definición cargo abono*/
			if ($fila6['abono']!="") {
				$abono=number_format($mt_total,2);
			} else { $abono=""; }

			if ($fila6['cargo']!="") {
				$cargo=number_format($mt_total,2);
			} else { $cargo=""; }

			if ($fila6['tipo_movimiento']=="abono") {
				$cargo_abono_texto="<td><span></span></td>
				<td><span>$ $abono</span></td>";
				$saldo_total = $saldos - 0;
				$saldos = $saldo_total;
				$saldo_total = number_format(0,2);
			}
			if ($fila6['tipo_movimiento']=="cargo") {
				$cargo_abono_texto="<td><span>$ $cargo</span></td>
				<td><span></span></td>";
				$saldo_total = $saldos + 0;
				$saldos = $saldo_total;
				$saldo_total = number_format(0,2);
			}
    //$saldo_total = "P";
			$fecha_movimiento_bien="";
			$date = date_create($fila6['fecha_movimiento']);
			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
			$monto_precio_formato_letras= convertir($abono);
			/*End definición cargo abono*/

			$texto_informacion="Método de pago: $fila6[metodo_pago]<br>
			Monto: $ $abono ($monto_precio_formato_letras)<br>
			$tipo_mon
			$cantidad
			I. Emisora: $emisora_institucion<br>
			A. Emisor: $emisora_agente<br>
			I. Receptora: $receptora_institucion<br>
			A. Receptor: $receptora_agente<br>
			Tipo de Comprobante: $fila6[tipo_comprobante]<br>
			No. de Referencia: $fila6[referencia]<br>
			";


			$tabla_movimientos.="<tr>
			<td><span>$contador</span></td>
			<td><span>$fecha_movimiento_bien</span></td>
			<td><span>$fila6[concepto]</span></td>
			<td></td>
			<td><span>$texto_informacion</span></td>
			$cargo_abono_texto
			<td><span>$ $saldo_total</span></td>
			</tr>";
		}
		else if ($fila6['concepto']=="Préstamo") {

			$tipo_mon = "";
			$cambio = "";
			$cantidad = "";
			if ($fila6[tipo_moneda] == "MXN" || $fila6[tipo_moneda] == "USD" || $fila6[tipo_moneda] == "CAN") {
				$cambio = number_format($fila6[tipo_cambio],2);
				$tipo_mon = "Moneda: $fila6[tipo_moneda]<br> T. Cambio: $cambio<br>";
				$cantidad = "Cantidad: ".number_format($fila6[gran_total], 2)."<br>";
			}else{
				$tipo_mon = "";
				$cantidad = "";
			}

  	//--------------- INICIO Conversión de ATC a Atención a Clientes
			if ($fila6[emisora_institucion]=="ATC") {

				$emisora_institucion = "Atención a Clientes";
			}else{
				$emisora_institucion = $fila6[emisora_institucion];
			}
			if ($fila6[emisora_agente]=="ATC") {
				$emisora_agente = "Atención a Clientes";
			}else{
				$emisora_agente = $fila6[emisora_agente];
			}
			if ($fila6[receptora_institucion]=="ATC") {
				$receptora_institucion = "Atención a Clientes";
			}else{
				$receptora_institucion = $fila6[receptora_institucion];
			}
			if ($fila6[receptora_agente]=="ATC") {
				$receptora_agente = "Atención a Clientes";
			}else{
				$receptora_agente = $fila6[receptora_agente];
			}
  //---------------    FIN Conversión de ATC a Atención a Clientes

			/*Start definición cargo abono*/
			if ($fila6['abono']!="") {
				$abono=number_format($mt_total,2);
			} else { $abono=""; }

			if ($fila6['cargo']!="") {
				$cargo=number_format($mt_total,2);
			} else { $cargo=""; }

			if ($fila6['tipo_movimiento']=="abono") {
				$cargo_abono_texto="<td><span></span></td>
				<td><span>$ $abono</span></td>";
				$saldo_total = $saldos - 0;
				$saldos = $saldo_total;
				$saldo_total = number_format(0,2);
			}
			if ($fila6['tipo_movimiento']=="cargo") {
				$cargo_abono_texto="<td><span>$ $cargo</span></td>
				<td><span></span></td>";
				$saldo_total = $saldos + 0;
				$saldos = $saldo_total;
				$saldo_total = number_format(0,2);
			}
    //$saldo_total = "P";
			$fecha_movimiento_bien="";
			$date = date_create($fila6['fecha_movimiento']);
			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
			$monto_precio_formato_letras= convertir($abono);
			/*End definición cargo abono*/

			$texto_informacion="Método de pago: $fila6[metodo_pago]<br>
			Monto: $ $abono ($monto_precio_formato_letras)<br>
			$tipo_mon
			$cantidad
			I. Emisora: $emisora_institucion<br>
			A. Emisor: $emisora_agente<br>
			I. Receptora: $receptora_institucion<br>
			A. Receptor: $receptora_agente<br>
			Tipo de Comprobante: $fila6[tipo_comprobante]<br>
			No. de Referencia: $fila6[referencia]<br>

			";


			$tabla_movimientos.="<tr>
			<td><span>$contador</span></td>
			<td><span>$fecha_movimiento_bien</span></td>
			<td><span>$fila6[concepto]</span></td>
			<td></td>
			<td><span>$texto_informacion</span></td>
			$cargo_abono_texto
			<td><span>$ $saldo_total</span></td>
			</tr>";
		}
		/*End apartado, enganche*/

	}
	return $tabla_movimientos;

}
//*************************************************************************************************************************************************************

/*Start PDF*/
$contenido='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>'.$id_contacto_completo.'.'.$nombre.' '.$apellidos.'</title>
<style type="text/css">
.img_header{
	margin: -30px 0 0 0;
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
	font-family: Arial;
	height: 18px;
	display: block;
	padding:0 0px -10px 0;
}
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
	padding: 8px;
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
</style>
</head>
<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo.png); background-repeat: no-repeat; background-position: center;">
<div class="container">
<!--pedido-->
<div class="content-pedido">
<table class="tabla-datos-facturar">
<tr>
<td style="width: 20px;">
<p class="titulo-datos-facturar">ID:</p>
</td>
<td style="width: 257px;">
<p class="text-datos-facturar">'.$tipo_cliente.'.'.$id_contacto_completo.'</p>
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
<td>'.$dia.'</td>
<td>'.$mes.'</td>
<td>'.$ano.'</td>
<td>'.$hora.'</td>
</tr>
<tr>
<th>FECHA CORTE:</th>
<th>DÍA</th>
<th>MES</th>
<th>AÑO</th>
<th>HORA</th>
</tr>
</table>
</div>
<!--fin-table-fecha-->
<div class="both"></div>
<!--pleca-->
<div class="header">
<img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
</div>
<!--fin-pleca-->
<div class="content-facturar">
<table class="tabla-datos-facturar">
<tr>
<td style="width: 136px;">
<p class="titulo-datos-facturar">NOMBRE:</p>
<p class="titulo-datos-facturar">APELLIDO(S)</p>
<p class="titulo-datos-facturar">ALIAS:</p>
<p class="titulo-datos-facturar">TELÉFONO(S):</p>
<p class="titulo-datos-facturar">DOMICILIO:</p>
</td>
<td style="width: 207px;">
<p class="text-datos-facturar">'.$nombre.'</p>
<p class="text-datos-facturar">'.$apellidos.'</p>
<p class="text-datos-facturar">'.$alias.'</p>
<p class="text-datos-facturar">'.$telefono1.' / '.$telefono2.'</p>
<p class="text-datos-facturar">'.$domicilio_completo.'</p>
</td>
<td style="width: 136px;">
<p class="titulo-datos-facturar">TIPO DE CRÉDITO:</p>
<p class="titulo-datos-facturar">LÍNEA DE CRÉDITO:</p>
<p class="titulo-datos-facturar">ASESOR:</p>
</td>
<td style="width: 207px;">
<p class="text-datos-facturar">'.$tipo_credito.'</p>
<p class="text-datos-facturar">'.$linea_credito.'</p>
<p class="text-datos-facturar">'.$asesor.'</p>
</td>
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
<th>FECHA</th>
<th>CONCEPTO</th>
<th style="width: 136px;">DATOS</th>
<th>INFORMACIÓN</th>
<th>CARGOS</th>
<th>ABONOS</th>
<th>SALDO</th>

</tr>
'.$tabla_movimientos.'
</table>



<br>
<!--<div>-->
<!--table-entrega-->
<!--<div>-->
<p></p>
</body>
</html>';






//echo $contenido;
include("../../MPDF57/mpdf.php");
$mpdf=new mPDF('c','A4','','','10','10','28','10');
$mpdf->SetHTMLHeader('<img src="../../img/Admon_Compras/header_compras_interno.png" class="img_header" alt=""><br>');
$mpdf->SetHTMLFooter('
	<p class="text-datos-obs">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER S.A. DE C.V. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  {PAGENO} de {nb}</p>
	');
$latlong1 = $_POST['latlong1'];
$pass1 = "$_POST[pass1]";





/*date_default_timezone_set('America/Mexico_City');
$actual= date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];



$sql="INSERT INTO datos_visualizacion_pdf (cliente_pdf, tipo_pdf, consenia_acceso, fecha_acceso, ip, lat_lgn, usuario) VALUES ('$id_contacto', 'PDF Cliente', 'DID*19', '$actual', '$ip', '$latlong1', '$usuario_creador')";
$result=mysql_query($sql);
$latlong1="";
$pass1="";*/

//echo $contenido;
$mpdf->WriteHTML($contenido);
//$mpdf->SetProtection(array('copy','print'), $consenia_acceso."pana.center", $consenia_acceso."pana.center");

$nc = $nombre." ".$apellidos;

$nombre_completo2 = eliminar_tildes($nc);
$words = explode(" ", $nombre_completo2); $acronym = ""; foreach ($words as $w) { $acronym .= $w[0]; }

$nombre_de_archivo = $id_contacto_completo.".".$acronym."-".$nombre_completo2.".pdf";

$mpdf->Output($nombre_de_archivo, 'I');



exit;
/*End PDF*/
?>
