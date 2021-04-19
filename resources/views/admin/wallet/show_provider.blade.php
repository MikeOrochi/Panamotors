@extends('layouts.appAdmin')
@section('titulo', 'Catalogo de proveedores')

@section('head')

<style type="text/css">

   .fadeOutLeft_izi{
      -webkit-animation: iziT-fadeOutLeft .5s ease both;
      animation: iziT-fadeOutLeft .5s ease both;
   }

   .fadeOutRight_izi{
      -webkit-animation: iziT-fadeOutRight .5s ease both;
      animation: iziT-fadeOutRight .5s ease both;
   }

   .fadeInLeft_izi{
      -webkit-animation: iziT-fadeInLeft .85s cubic-bezier(.25,.8,.25,1) both;
      animation: iziT-fadeInLeft .85s cubic-bezier(.25,.8,.25,1) both;
   }

   .fadeInRight_izi{
      -webkit-animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
      animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
   }


   #rcorners2error {
      -webkit-box-shadow: 0px 0px 100px -15px rgba(164,30,54,1);
      -moz-box-shadow: 0px 0px 100px -15px rgba(164,30,54,1);
      box-shadow: 0px 0px 100px -15px rgba(164,30,54,1);
   }

   #rcorners2bien {
      -webkit-box-shadow: 0px 0px 100px -15px rgba(57,178,38,1);
      -moz-box-shadow: 0px 0px 100px -15px rgba(57,178,38,1);
      box-shadow: 0px 0px 100px -15px rgba(57,178,38,1);
   }
   img.rounded-circle{
      border-color: rgb(85, 79, 69);
      display: block;
      margin: auto;
      border-radius: 50%;
      border: 10px solid #dddddd;
      position: relative;
      z-index: 2;
   }
   }



   .hidden{
      display: none;
   }
   @media (min-width:600px) {
      .card {
         max-width:70%;
      }

   }

   .botonCard{
      display: block;
      width: 200px;
      height: 40px;
      border: none;
      color: #fff !important;
      border-radius: 20px;
      text-align: center;
      position: relative;
      z-index: 1;
   }

</style>
@endsection





@section('content')
<div class="container">
	<div class="row">
	  <div class="col-lg-12">
	    <!-- <h2 style="text-align:center;">{{---$id_contacto_completo---}}</h2> -->
	    <!-- <ol class="breadcrumb">
	      <li>
	        <a href="index.php">Inicio</a>
	      </li>
	      <li class="active">
	        <strong>Perfil</strong>
	      </li>
	      <li class="active">
	        <strong><a href="editar_proveedor.php?idc=<?php echo $idc;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></strong>
	      </li>
	  	</ol> -->
		</div>
	</div>

</div>
<div class="container">
	<div class="row mt-3">
		<div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">

			<div class="shadow panel-head-primary" style="padding-top: 2%; padding-bottom:2%;">
				<!-- <h5 class="mt-3 mb-3"><strong>Información Detallada</strong></h5> -->
<!-- -----------------------------------INFORMACION DETALLADA----------------------------------------------------------------------- -->
				<div class="col-lg-8 offset-lg-2 col-sm-12 col-md-12 col-12">

					<div class="card" style="margin:0 auto; min-height:800px;border-radius: 20px;background: #dadbe0;box-shadow: 0px 0px 20px rgb(136 36 57 / 20%);position: relative;overflow: hidden;">
						<div class="card-header" style="padding:10px;background: #F3F3F3;">
							<h2 style="text-align:center;">@if(!empty($id_contacto_completo)){{$id_contacto_completo}}@else{{'N/A'}}@endif</h2>
 						</div>
					  <div class="card-body" id="datos-principales" style="padding:0px;">
						  <div class="col-lg-12 imagen-perfil" style="background: #fff;padding: 20px 0px;">
                <div class="" style="text-align: right;">
                  <a style="margin-right: 15px;" href="{{route('provider.edit',$proveedor->idproveedores)}}"><i class="far fa-edit"></i></a>
                </div>
							  <div class="text-center">
								  @if ($proveedor->foto_perfil !="N/A" && !empty($proveedor->foto_perfil))
								  <img alt='image' width='150' height='150' class='rounded-circle' src="{{secure_asset('public/Fotos_Perfil/'.$proveedor->foto_perfil)}}" alt="">
								  @else
								  @if ($proveedor->sexo == "Hombre")
								  <img alt='image' width='150' height='150' class='rounded-circle' src="{{secure_asset('public/Fotos_Perfil/avatar_hombre.png')}}" alt="">
								  @elseif ($proveedor->sexo == "Mujer")
								  <img alt='image' width='150' height='150' class='rounded-circle' src="{{secure_asset('public/Fotos_Perfil/avatar_mujer.png')}}" alt="">
								  @else
								  <img alt='image' width='150' height='150' class='rounded-circle' src="{{secure_asset('public/Fotos_Perfil/perfil.png')}}" alt="">
								  @endif
								  @endif
							  </div>

						  </div>
						  <h5 class="mt-3 mb-3" style="text-align: center;"><strong>Datos personales</strong></h5>
						  <div class="table-responsive">
							  <table class="table table-striped">
								  <tbody>
									  <tr>
										  <td>Nombre(s)</td>
										  <td colspan="3"><b>@if(!empty($proveedor->nombre) && !empty($proveedor->apellidos))
											  {{$proveedor->nombre." ".$proveedor->apellidos}}
										  	@else
												{{"N/A"}}
											@endif
									  		</b></td>
									  </tr>
									  <tr>
										  <td>Alias</td>
										  <td><b>@if(!empty($proveedor->alias)){{$proveedor->alias}}@else {{"N/A"}}  @endif</b></td>
										  <td>RFC</td>
										  <td><b>@if(!empty($proveedor->rfc)){{$proveedor->rfc}}@else{{'N/A'}}@endif</b></td>
									  </tr>
									  <tr>
										  <td>Tel. 1
											  	@if (!empty($proveedor->telefono_celular))
												  <a title='Llamar' href='tel:+52{{$proveedor->telefono_celular}}'><i class='fa fa-mobile' aria-hidden='true'></i></a>
												@endif
										  </td>
										  <td><b>
											  @if (!empty($proveedor->telefono_celular))
											  		{{$proveedor->telefono_celular}}
										  		@else
											  		{{"S/N"}}
											  @endif
										  </b></td>
										  <td class="col" style="padding-right:0px;">Tel. 2 &nbsp;
											  @if (!empty($proveedor->telefono_otro))
											  	<a title='Llamar' href='tel:+52$proveedor->telefono_otro'><i class='fa fa-phone' aria-hidden='true'></i></a>
											  @endif
										  </td>
										  <td><b>
											  @if (!empty($proveedor->telefono_otro) && !is_Null($proveedor->telefono_otro))
											  		{{$proveedor->telefono_otro}}
										  		@else
											  		{{"S/N"}}
											  	@endif
										  </b></td>
									  </tr>

									  <tr>
										  <td>E-mail @if (!empty($proveedor->email))
											  	<a title='Redactar' href='mailto:{{$proveedor->email}}'><i class='fa fa-envelope-o' aria-hidden='true'></i></a>
											  @endif
										  </td>
										  <td colspan="3"><b>@if (!empty($proveedor->email))
											  {{$proveedor->email}}
										  @else
											  {{"N/A"}}
											@endif
										  </b></td>
									  </tr>
									  <tr>
										  <td style="width: 50%;">Razón Social / Persona Física</td>
										  <td colspan="3"><b>@if(!empty($proveedor->col1)){{$proveedor->col1}}@else {{"N/A"}}@endif</b></td>
									  </tr>
								  </tbody>
							  </table>
						  </div>
						  <div class="row" style="margin-bottom: 15px;">
                <h5 class="col-lg-12" style="text-align: center;"><strong>Estado de cuenta</strong></h5>
        				<div class="col-lg-12" style="text-align: center;margin-bottom: 10px;">
                  <a href="{{route('account_status.showAccountStatus',['idc'=>$idc])}}" title='Estado de Cuenta'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                      <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
                    </svg>
                  </a>
        				</div>
							  <input type="button" class="btn btn-primary botonCard" id="ver_mas" style="margin: 0 auto;" value="Ver m&aacute;s">
						  </div>
					  </div>
					<!-- Fin | Datos Personales -->
					<!-- Direccion -->
					  <div class="card-body" id="datos-secundarios" style="display:none;">
							<h5 class="mt-3 mb-3" style="text-align: center;"><strong>Dirección</strong></h5>
							<div class="table-responsive">
								<table class="table table-striped">
									<tbody>
										<tr>
											<td>Código Postal</td>
											<td><b>@if(!empty($proveedor->codigo_postal)){{$proveedor->codigo_postal}}@else {{"N/A"}}@endif</b></td>
											<td>Estado</td>
											<td><b>@if(!empty($proveedor->estado)){{$proveedor->estado}}@else {{"N/A"}}@endif</b></td>
										</tr>

										<tr>
											<td>Delegación/Municipio </td>
											<td><b>@if(!empty($proveedor->delmuni)){{$proveedor->delmuni}}@else {{"N/A"}}@endif
											</b></td>
											<td>Colonia/Zona </td>
											<td><b>@if(!empty($proveedor->colonia)){{$proveedor->colonia}}@else {{"N/A"}}@endif</b></td>
										</tr>
										<tr>
											<td>Calle y Número</td>
											<td colspan="3"><b>@if(!empty($proveedor->calle)){{$proveedor->calle}}@else {{"N/A"}}@endif</b></td>
										</tr>

									</tbody>
								</table>
							</div>
							<div class="row">
 							   <input type="button"  class="btn btn-primary botonCard" id="regresar" style="margin: 15px auto;" value="Regresar">
 						  </div>
						</div>
					</div>
					<!-- Fin | Direccion -->
				</div>



<!-- ---------------------------------------------------------------------------------------------------------- -->
			</div>



			<!-- <div class="shadow panel-head-primary">
				<h5 class="text-center mt-3 mb-3"><strong>Estado de cuenta</strong></h5>
				<div class="col-lg-12">

					<div class="panel-body datatable-panel">
						<center>
							<a href="{{route('account_status.showAccountStatus',['idc'=>$idc])}}" title='Estado de Cuenta'>
								<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
  								<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
								</svg>
							</a>

						</center>

						<h5 class="mt-3 mb-3"><strong>Resumen Crediticio</strong></h5>
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td>Saldo</td>
										<td colspan="3"><b><?php //echo "$ ".number_format($saldo_anterior,2); ?></b></td>
									</tr>
									<tr>
										<td>Último Abono</td>
										<td><b><?php //echo "$ ".number_format($ultimo_abono,2); ?></b></td>
										<td>Fecha Último Abono</td>
										<td><b><?php //echo $fecha_ultimo_abono; ?></b></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div> -->





			<div class="shadow panel-head-primary">
				<h5 class="mt-3 mb-3"><strong>Modificaciones de proveedor</strong></h5>
				<div class="col-lg-12">

<!-- ----------------------------------------------- -->


								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example4" style="width:100%">
										<thead>
											<tr>
												<th>Descripción de modificación</th>
												<th>Usuario</th>
												<th>Fecha</th>
											</tr>
										</thead>
										<tbody>
											@foreach($proveedores_cambios as $value)
												<tr class="odd gradeX">
													<td>@if(!empty($value['descripcion'])){!!$value['descripcion']!!}@else {{"Sin registro"}}@endif</td>
													<td>@if(!empty($value['usuario'])) {!!$value['usuario']!!}@else {{"Sin registro"}}@endif</td>
													<td>@if(!empty($value['fecha'])){!!$value['fecha']!!}@else {{"Sin registro"}}@endif</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									<!-- /.table-responsive -->
								</div>
								<!-- /.panel-body -->


<!-- ----------------------------------------------- -->



				</div>
			</div>




		</div>
	</div>

</div>


























@endsection


@section('js')



<script type="text/javascript">


$('#alternar-respuesta-ej1').on('click',function(){
	$('#respuesta-ej1').toggle('slow');
});

$('#alternar-respuesta-ej2').on('click',function(){
	$('#respuesta-ej2').toggle('slow');
});


function confirmar(url){
	if (!confirm("¿Está seguro de que desea eliminar a este Proveedor?")) {
		return false;
	}
	else {
		document.location= url;
		return true;
	}
}

	//<!------Se utiliza para que el campo de texto solo acepte letras------>
	function SoloLetras(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toString();
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
		especiales = [8, 37, 39, 46, 6];
		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}
		if(letras.indexOf(tecla) == -1 && !tecla_especial){
			return false;
		}
	}
	//<!-----Se utiliza para que el campo de texto solo acepte numeros----->
	function SoloNumeros(evt){
		if(window.event){ //asignamos el valor de la tecla a keynum
			keynum = evt.keyCode; //IE
		}
		else{
			keynum = evt.which; //FF
		}

		//comprobamos si se encuentra en el rango numérico
		if((keynum >= 48 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
			return true;
		}
		else{
			return false;
		}

	}


		$("#ver_mas").click(function(){
			$("#datos-principales").addClass('fadeOutLeft_izi');
			$("#datos-principales").fadeOut( function(){
					$("#datos-secundarios").addClass("fadeInLeft_izi");
					$("#datos-secundarios").fadeIn(function(){
							$("#datos-secundarios").removeClass("fadeInLeft_izi");
							$("#datos-principales").removeClass('fadeOutLeft_izi');
					});
				}
			);
		});
		$("#regresar").click(function(){
			$("#datos-secundarios").addClass('fadeOutRight_izi');
			$("#datos-secundarios").fadeOut(function(){
				$("#datos-principales").addClass("fadeInRight_izi");
				$("#datos-principales").fadeIn(function(){
					$("#datos-principales").removeClass('fadeInRight_izi');
					$("#datos-secundarios").removeClass('fadeOutRight_izi');
				});
			});
		});

	$(function() {
    $("[data-ref^='#']").bind('click', function(e) {
    //$('a[href*=#]').bind('click', function(e) {
        e.preventDefault();
        var target = $(this).attr("data-ref");
        $('html, body').stop().animate({
            scrollTop: $(target).offset().top
        }, 600, function() {
            // location.hash = target;
        });
        return false;
    });
});

	$(document).ready(function(){
		$("#porcentaje").keyup(function(){
			var vari = $("#porcentaje").val();
			var contacid =  $("#contacid").val();
			var de =  $("#de").val();
			$.post("recibe_por.php", {vari: vari,contacid:contacid}, function(resultado) {
				$("#cantidad_de").val(parseFloat(resultado).toFixed(2));
				$("#new_saldos").val((parseFloat(resultado)+parseFloat(de)).toFixed(2));
				console.log(resultado);
				var textoletras = $("#new_saldos").val();

				if (textoletras != "") {
					$.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
						delete mensaje_letras;
						$("#letra").val(mensaje_letras);
						console.log(mensaje_letras);
          });
				} else {
					$("#letra").val('');
				}
			});
		});
	});
	/* var  valor =resultado;*/

	$(document).ready(function(){
		var porcen2 = $("#porcen").val();
		var debe2 = $("#debe").val();
		var cantidad2 = $("#cantidad_porcentaje").val();
		var di3 = $("#di").val();
		var nuevo_s= parseFloat(debe2) + (((parseFloat(porcen2)/100)/30)*parseFloat(di3))*parseFloat(debe2);

		$("#new_saldo").val(nuevo_s.toFixed(2));
		$("#cantidad_porcentaje").val(((((parseFloat(porcen2)/100)/30)*parseFloat(di3))*parseFloat(debe2)).toFixed(2));
		$("#porcen").keyup(function(){
			var debe = $("#debe").val();
			var porcen = $("#porcen").val();
			var di2 = $("#di").val();
			var cantidad = ((((parseFloat(porcen)/100)/30)*parseFloat(di2))*parseFloat(debe));
			var nuevo_saldo = parseFloat(debe) + parseFloat(cantidad);
			if (porcen < 2) {
				$("#porcen").css("border-color","red");
				$("#cantidad_porcentaje").val("");
				$("#new_saldo").val("");
			}else{
				$("#cantidad_porcentaje").val(cantidad.toFixed(2));
				$("#porcen").css("border-color","white");
				$("#new_saldo").val(nuevo_saldo.toFixed(2));
			}
		});

		$("#cantidad_porcentaje").keyup(function(){
			var debe = $("#debe").val();
			var di = $("#di").val();
			var cantidad = $("#cantidad_porcentaje").val();
			var nuevo_sal = parseFloat(debe) + parseFloat(cantidad);
			var p = ((parseFloat(cantidad)/parseFloat(debe))/parseFloat(di)*30*100)  ;
			if (p < 2) {
				$("#porcen").css("border-color","red");
				$("#new_saldo").val("");
			}else{
				$("#porcen").val(p.toFixed(2));
				$("#porcen").css("border-color","white");
				$("#new_saldo").val(nuevo_sal.toFixed(2));
			}
		});

		$("#cantidad_porcentaje").keyup(function(){
			var textoletras = $("#new_saldo").val();
			if (textoletras != "") {
				$.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
					delete mensaje_letras;
					$("#letra").val(mensaje_letras);
					console.log(mensaje_letras);
          });
			} else {
				$("#letra").val('');
			}
		});

		$("#porcen").keyup(function(){
			var textoletras = $("#new_saldo").val();
			if (textoletras != "") {
				$.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
					delete mensaje_letras;
					$("#letra").val(mensaje_letras);
					console.log(mensaje_letras);
          });
			} else {
				$("#letra").val('');
			}
		});

		$("#agregar_po").click(function(){
			var checado = "no";
			if( $("#check").prop('checked') ) {
				checado = "si";
			}
			var porcen = $("#porcen").val();
			var di = $("#di").val();
			var cantidad_porcentaje = $("#cantidad_porcentaje").val();
			var new_saldo = $("#new_saldo").val();
			var contac = $("#contac").val();
			$.post("guardar_porcentaje.php", {checado: checado,porcen: porcen,di: di,cantidad_porcentaje: cantidad_porcentaje,new_saldo: new_saldo,contac: contac }, function(resultado) {
				alert(resultado);
				$("#ibox-content").load(" #ibox-content");
			});
		});

		$("#agregar_po2").click(function(){
			var checado1 = "no";
			if( $("#check2").prop('checked') ) {
				checado1 = "si";
			}
			var porcentaje = $("#porcentaje").val();
			var di = $("#di").val();
			var cantidad_de = $("#cantidad_de").val();
			var new_saldos = $("#new_saldos").val();
			var contacid = $("#contacid").val();
			var total_vencido = $("#de").val();
			var pagares_numero = $("#pagares_numero").val();
			var fecha_creaci =$("#fecha_creacion2").val();
			var total_de =$("#total_de").val();
			if (new_saldos !="") {
				if (porcentaje < 2) {
					alert("El Porcentaje es Inferior a 2");
					$("#porcentaje").val("");
					$("#cantidad_de").val("");
					$("#new_saldos").val("");
				}else{
					$.post("guardar_porcentaje_por_pagare.php", {checado: checado1,porcen: porcentaje,di: di,cantidad_porcentaje: cantidad_de,new_saldo: new_saldos,contac: contacid,total_vencido: total_vencido,pagares_numero :pagares_numero,fecha_creaci:fecha_creaci,total_de: total_de }, function(resultado) {
						if (new_saldos != "NaN") {
							if (resultado=="Se Presentó un Error" && resultado== "El Nuevo Saldo  no es un valor numérico") {
								alert(resultado);
							}else{
								if (checado1 == "si") {
									alert("Agregado Correctamente");
									window.open(resultado);
								}else{
									alert("Agregado Correctamente");
								}
							}
						}else{
							alert("No hay datos");
						}

						$("#ibox-content").load(" #ibox-content");
						$("#conte").load(" #conte");
					});
				}
			}else{
				alert("Los Campos estan vacíos");
			}
		});
	});

function buscar_letras() {
	var textoletras = $("#new_saldo").val();
    if (textoletras != "") {
    	$.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
    		$("#letra").val(mensaje_letras);
          });
    } else {
    	$("#letra").val('');
    };
  };


var formatNumber = {
 separador: ",", // separador para los miles
 sepDecimal: '.', // separador para los decimales
 formatear:function (num){
 	num +='';
 	var splitStr = num.split('.');
 	var splitLeft = splitStr[0];
 	var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
 	var regx = /(\d+)(\d{3})/;
 	while (regx.test(splitLeft)) {
 		splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 	}
 	return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
 	this.simbol = simbol ||'';
 	return this.formatear(num);
 }
}
</script>


@endsection
