@extends('layouts.appAdmin')
@section('titulo', '')

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
   .after-generate{
       display: none;
   }

</style>
@endsection





@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>
</div>
<div class="container">
    <div class="row mt-3">
        <div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">

            <div class="shadow panel-head-primary" style="padding-top: 2%; padding-bottom:2%;">
                <div class="col-lg-8 offset-lg-2 col-sm-12 col-md-12 col-12">

                    <div class="card" style="margin:0 auto;border-radius: 20px;background: #dadbe0;box-shadow: 0px 0px 20px rgb(136 36 57 / 20%);position: relative;overflow: hidden;">
                        <div class="card-header" style="padding:10px;background: #F3F3F3;">
                            <h2 style="text-align:center;">Cambiar contraseña de acceso</h2>
                        </div>
                        <div class="card-body" id="datos-principales" style="padding:0px;">
                            <div class="col-lg-12 imagen-perfil" style="background: #fff;padding: 20px 0px;">
                                <div class="" style="text-align: right;">
                                    <a style="margin-right: 15px;" href="{{---route('provider.edit',$proveedor->idproveedores)---}}"><i class="far fa-edit"></i></a>
                                </div>
                                <div class="text-center">
                                    <img alt='image' width='150' height='150' class='rounded-circle' src="{{secure_asset('public/Fotos_Perfil/avatar_hombre.png')}}" alt="">
                                </div>
                            </div>
                            <h5 class="mt-3 mb-3" style="text-align: center;"><strong>Datos personales</strong></h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Nombre(s)</td>
                                            <td colspan="3"><b>@if(!empty($usuario->nombre_usuario))
                                                {{$usuario->nombre_usuario}}
                                                @else
                                                {{"N/A"}}
                                                @endif
                                            </b></td>
                                        </tr>

                                        <tr>
                                            <td>Usuario: </td>
                                            <td colspan="3"><b>@if (!empty($usuario->usuario))
                                                {{$usuario->usuario}}
                                                @else
                                                {{"N/A"}}
                                                @endif
                                            </b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="padding:3% 5%; padding-top:7%;">
                                                <form id="form-change-password" name="form-change-password" enctype="multipart/form-data" method="post" action="{{route('change_password_automatic.storePassword')}}" class="needs-validation">
                                                    @csrf
                                                    <div class="row after-generate" style="margin-bottom:5%;">
                                                        <div class="col-md-12">
                                                            <input class="form-control" type="text" id="nuevo-password" name="nuevo-password" value="" placeholder="Contraseña nueva" readonly required >
                                                        </div>

                                                    </div>
                                                    <div class="row" style="margin-bottom: 15px;">
                                                        <div class="col-md-12" id="div-button-generate">
                                                            <input type="button" class="btn btn-primary botonCard" id="generar-password" style="margin: 0 auto; width:10em;" value="Generar" onclick="GenerarPassword()">
                                                        </div>
                                                        <div class="col-md-12 after-generate">
                                                            <h1><i class="fa fa-clone" aria-hidden="true" id="copy_info" onclick="copiar_info();" style="cursor:pointer; margin: 0 auto; display: table;"></i></h1>
                                                        </div>
                                                        
                                                        <div class="col-md-12" id="mensajes" style="margin-top:12px;">

                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Fin | Datos Personales -->
                        <!-- Direccion -->
                    </div>
                    <!-- Fin | Direccion -->
                </div>



                <!-- ---------------------------------------------------------------------------------------------------------- -->
            </div>














        </div>
    </div>

</div>

@endsection


@section('js')
<script type="text/javascript">

function GenerarPassword(){
    $('#nuevo-password').val('{{$new_password}}');
    $('#div-button-generate').css('display','none');
    $('.after-generate').removeClass('after-generate');

}
function copiar_info() {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val("{{$new_password}}").select();
    document.execCommand("copy");
    $temp.remove();
      $('#mensajes').append('<div class="alert alert-success" role="alert">Key Access Copiada. Guarda la Key Access, te servira para ingresar desde otro dispositivo.</div>');
      $('#copy_info').css('pointer-events','none');
      setTimeout(function(){ $( "form" ).first().submit(); }, 3000);


}
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
