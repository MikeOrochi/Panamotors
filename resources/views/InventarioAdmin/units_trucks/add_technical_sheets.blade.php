@extends('layouts.appAdmin')
@section('titulo', 'Agregar información de fichas técnicas')
@section('content')
  <style media="screen">
  .dataTables_filter {
    display: none;
  }
  .dataTables_length{
    display: none;
  }
  .dataTables_info{
    display: none;
  }
  .dataTables_paginate{
    /* display: none; */
  }
  #select2-search_provider_client-container{
    font-size: 17px;
  }

  #select2-search_provider_client-results > li{
    color: #161714;
    font-size: 17px;

  }
  .flipOutX_izi{
    -webkit-backface-visibility: visible!important;
    backface-visibility: visible!important;
    -webkit-animation: iziT-flipOutX .7s cubic-bezier(.4,.45,.15,.91) both;
    animation: iziT-flipOutX .7s cubic-bezier(.4,.45,.15,.91) both;
  }

  .fadeInDown_izi{
    -webkit-animation: iziT-fadeInDown .7s ease both;
    animation: iziT-fadeInDown .7s ease both;
  }
  .flipInX_izi{
    -webkit-animation: iziT-flipInX .85s cubic-bezier(.35,0,.25,1) both;
    animation: iziT-flipInX .85s cubic-bezier(.35,0,.25,1) both;
  }
  .flipInRight_izi{
    -webkit-animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
    animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
  }
  .fadeOutLeft_izi {
    -webkit-animation: iziT-fadeOutLeft .5s ease both;
    animation: iziT-fadeOutLeft .5s ease both;
  }
  .bounceInUp_izi {
    -webkit-animation: iziT-bounceInUp .7s ease-in-out both;
    animation: iziT-bounceInUp .7s ease-in-out both;
  }
  .fadeOutDown_izi {
    -webkit-animation: iziT-fadeOutDown .7s cubic-bezier(.4,.45,.15,.91) both;
    animation: iziT-fadeOutDown .7s cubic-bezier(.4,.45,.15,.91) both;
  }
  </style>
  <form class="needs-validation" action="{{route('inventoryAdmin.storeEditDetailsTruck')}}" method="post" id='mi_formulario'>
    <div class="row mt-3">
      <div class="col-sm-12">
        <div class="shadow panel-head-primary">
          {{--<a class="btn-back" style="margin-left:15px;" href="{{route('wallet.showProvider',$id)}}"><i class="fas fa-chevron-left"></i> Perfil</a>--}}
          <!-- <h6 class="text-center mt-3 mb-3"><strong>Datos de usuario</strong></h6> -->
          <div class="table-responsive">
            <div class="container">
              @csrf
              {{---@include('admin.partials.providers.provider_edit_form')--}}

              <!-- ------------------------------------------- -->


              <div class="row" style="padding:30px">
                <div class="row" id='form_provider'>

                    <!-- ------------------------------------- -->
                    <div class="col-sm-12 col-xs-12 content pt-3 pl-0" style="width: 100%;">
                        <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
                        <!----------------------------------->




						<div class="row wrapper border-bottom white-bg page-heading">
							<div class="col-sm-6">
								<div class="form-group">
									<label>VIN</label>
									<input type="text" class="form-control" id="vin_numero_serie" name="vin_numero_serie" maxlength="17" required value="{{$inventario->vin_numero_serie}}" readonly="">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Marca</label>
									<select name="marca" id="marca" class="form-control marca">
										<option value="{{$inventario->marca}}">{{$inventario->marca}}</option>
										<option value="Freightliner">Freightliner</option>
										<option value="Kenworth">Kenworth</option>
										<option value="Sterling">Sterling</option>
										<option value="360">360</option>
										<option value="International">International</option>
										<option value="Volkswagen">Volkswagen</option>
									</select>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Versión</label>
									<input type="text" class="form-control" id="version" name="version" required  value="{{$inventario->version}}">
									<center>
										<div id="resultadoVersion"></div>
									</center>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Color</label>
									<input type="text" class="form-control" id="color" name="color" required onKeyUp="buscar_color();" value="{{$inventario->color}}" readonly="">
									<center>
										<div id="resultadoColor"></div>
									</center>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Modelo</label>
									<input type="text" class="form-control" id="modelo" name="modelo" required onKeyUp="buscar_modelo();" value="{{$inventario->modelo}}" readonly="">
									<center>
										<div id="resultadoModelo"></div>
									</center>
								</div>
							</div>


							<div class="col-sm-12 form-group">
								<label for="">Tipo trucks</label>
								<select name="tipo_trucks" id="tipo_trucks" class="form-control tipo_trucks" required="">
									<option value="">Elija una opción...</option>
									<option value="Tracto">Tracto</option>
									<option value="Camión">Camión</option>
								</select>
							</div>


							<div id="camion" class="row col-sm-12" style="display: none;width: 100%;">

								<div class="col-sm-12 formgroup">
									<label for="">Tipo</label>
									<select name="tipo" id="tipo" class="form-control tipo tipo_camion">
										<option value="">Elija una opción...</option>
										<option value="4x2">4x2</option>
										<option value="6x2">6x2</option>
										<option value="6x4">6x4</option>
										<option value="6x6">6x6</option>
										<option value="8x2">8x2</option>
										<option value="8x4">8x4</option>
										<option value="8x6">8x6</option>
										<option value="8x8">8x8</option>
									</select>
								</div>


								<div class="col-sm-6 form-group">
									<label for="">Medidas mínimas</label>
									<input type="text" name="medidas_min"  class="form-control medidas_min tipo_camion" id="medidas_min" readonly="">
								</div>

								<div class="col-sm-6 form-group">
									<label for="">Medidas máximas</label>
									<input type="text" name="medidas_max"  class="form-control medidas_max tipo_camion" id="medidas_max" readonly="">
								</div>

								<div class="col-sm-6 form-group">
									<label for="">Motor</label>
									<select name="motor" id="motor" class="form-control motor tipo_camion">
										<option value="{{$inventario->motor}}">{{$inventario->motor}}</option>


									</select>
								</div>

								<div class="col-sm-6">
									<label for="">Transmisión</label>
									<select name="transmision" id="transmision" class="form-control transmision tipo_camion" >
										<option value="{{$inventario->transmision}}">{{$inventario->transmision}}</option>

									</select>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label>Camarote</label>
										<input type="text" class="form-control camarote tipo_camion" id="camarote" name="camarote" value="{{$inventario->camarote}}">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Kilometraje</label>
										<input type="number" class="form-control kilometraje tipo_camion" id="kilometraje" name="kilometraje" value='{{$inventario->kilometraje}}'>
									</div>
								</div>




								<div class="col-sm-6">
									<label for="">Información técnica del motor</label>
									<select name="info_motor" id="info_motor" class="form-control info_motor tipo_camion">
										<option value="">Elija una opción...</option>
										<option value="Max force">Max force</option>
										<option value="Cummins">Cummins</option>
										<option value="Paccar">Paccar</option>
										<option value="Navistar">Navistar</option>
										<option value="Mercedes">Mercedes</option>
										<option value="Caterpilar">Caterpilar</option>
										<option value="Detroi">Detroi</option>
									</select>
								</div>

								<div class="col-sm-6">
									<label for="">Potencia</label>
									<select name="potencia" id="potencia" class="form-control potencia tipo_camion">
										<option value="">Elija una opción...</option>
										@php
										$con =190;
										while ($con <= 550) {
											echo "<option value='$con'>$con</option>";
											$con = $con + 10;
										}
										@endphp
									</select>
								</div>

								<div class="col-sm-6">
									<label for="">Información técnica del transmisión</label>
									<select name="info_transmision" id="info_transmision" class="form-control info_transmision tipo_camion">
										<option value="">Elija una opción...</option>
										<option value="Fuller">Fuller</option>
										<option value="Alison">Alison</option>
										<option value="Espaicer">Espaicer</option>
										<option value="Mercedes">Mercedes</option>
									</select>
								</div>


								<div class="col-sm-6">
									<label for="">Tipo de velocidades</label>
									<select name="tipo_velocidades" id="tipo_velocidades" class="form-control tipo_velocidades tipo_camion">
										<option value="">Elija una opción...</option>
										<option value="Manual">Manual</option>
										<option value="Automatizado">Automatizado</option>
									</select>
								</div>

								<div class="col-sm-6">
									<label for="">Velocidades</label>
									<select name="velocidades" id="velocidades" class="form-control velocidades tipo_camion">
										<option value="{{$inventario->velocidades}}">{{$inventario->velocidades}}</option>
										<option value="">Elija una opción...</option>
										<option value="6">6</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="13">13</option>
										<option value="18">18</option>

									</select>
								</div>

								<div class="col-sm-6">
									<label for="">Eje delantero</label>
									<select name="eje_delantero" id="eje_delantero" class="form-control eje_delantero tipo_camion">
										<option value="{{$inventario->eje_delantero}}">{{$inventario->eje_delantero}}</option>
										<option value="">Elija una opción...</option>
										<option value="9000">9,000</option>
										<option value="10000">10,000</option>
										<option value="12000">12,000</option>
										<option value="14000">14,000</option>
										<option value="16000">16,000</option>
									</select>
								</div>
								<div class="col-sm-6">
									<label for="">Eje trasero</label>
									<select name="eje_trasero" id="eje_trasero" class="form-control eje_trasero tipo_camion">
										<option value="{{$inventario->eje_trasero}}">{{$inventario->eje_trasero}}</option>
										<option value="20000">20,000</option>
										<option value="40000">40,000</option>
										<option value="42000">42,000</option>
										<option value="46000">46,000</option>
										<option value="52000">52,000</option>
									</select>
								</div>

								<div class="col-sm-6">
									<label for="">Rodado</label>
									<select name="rodado" id="rodado" class="form-control rodado tipo_camion">
										<option value="{{$inventario->rodado}}">{{$inventario->rodado}}</option>
										<option value="">Elija una opción...</option>
										<option value="19.5">19.5</option>
										<option value="22.5">22.5</option>
										<option value="24.5">24.5</option>
									</select>
								</div>

								<div class="col-sm-12">
									<label for="">Origen</label>
									<select name="origen" id="origen" class="form-control origen tipo_camion">
										<option value="{{$inventario->procedencia}}">{{$inventario->procedencia}}</option>
										<option value="">Elija una opción...</option>
										<option value="Nacional">Nacional</option>
										<option value="Importado">Importado</option>
										<option value="Armados">Armados</option>
									</select>
								</div>




							</div>


							<div class="col-sm-12 form-group">
								<label for="">¿Equipo aleado?</label>
								<select name="tiene_equipo_al" id="tiene_equipo_al" class="form-control tiene_equipo_al" required="">
									<option value="">Elija una opción...</option>
									<option value="SI">SI</option>
									<option value="NO">NO</option>
								</select>
							</div>

							<div id="equipo_aleado"  class="row col-sm-12" style="display: none;width: 100%;">

								<div class="col-sm-12 form-group">
									<label for="">Tipo equipo aleado</label>
									<select name="equipo_al" id="equipo_al" class="form-control equipo_al tipo_equipo_aleado">
										<option value="">Elija una opción...</option>
										<option value="Caja seca">Caja seca</option>
										<option value="Caja refrigeradas">Caja refrigeradas</option>
										<option value="Plataforma">Plataforma</option>
										<option value="Chasis cabina">Chasis cabina</option>
										<option value="Volteo 7mts">Volteo 7mts</option>
										<option value="Volteo 14mts">Volteo 14 mts</option>
										<option value="Tolva">Tolva</option>
										<option value="Grua">Grua</option>
										<option value="Jaula">Jaula</option>
									</select>
								</div>
								<div id="carac_cch_seca" class="row col-sm-12" style="display: none;width: 100%;">
									<div class="col-sm-6 form-group">
										<label for="">Caja seca</label>
										<select name="caja_seca" id="caja_seca" class="form-control caja_seca carac_marcas">
											<option value="">Elija una opción...</option>
											<option value="40">40</option>
											<option value="48">48</option>
											<option value="53">53</option>
										</select>
									</div>


									<div class="col-sm-6 form-group">
										<label for="">Marcas de caja seca</label>
										<select name="marca_caja_seca" id="marca_caja_seca" class="form-control marca_caja_seca carac_marcas">
											<option value="">Elija una opción...</option>
											<option value="Wabash">Wabash</option>
											<option value="De Lucio">De Lucio</option>
											<option value="Perea">Perea</option>
											<option value="Altamirano">Altamirano</option>
											<option value="Tec Movil">Tec Movil</option>
											<option value="Green Danes">Green Danes</option>
											<option value="Utility">Utility</option>
											<option value="Otras">Otras</option>
										</select>
									</div>

								</div>


								<div id="carac_cch_refrigerador" class="row col-sm-12" style="display: none;width: 100%;">

									<div class="col-sm-6 form-group">
										<label for="">Marcas de caja refrigeradas</label>
										<select name="marca_caja_refrigerador" id="marca_caja_refrigerador" class="form-control marca_caja_refrigerador carac_marcas">
											<option value="">Elija una opción...</option>
											<option value="Wabash">Wabash</option>
											<option value="De Lucio">De Lucio</option>
											<option value="Perea">Perea</option>
											<option value="Altamirano">Altamirano</option>
											<option value="Tec Movil">Tec Movil</option>
											<option value="Green Danes">Green Danes</option>
											<option value="Utility">Utility</option>
											<option value="Otras">Otras</option>
										</select>
									</div>

									<div class="col-sm-6 form-group">
										<label for="">Marcas del equipo de refrigeración</label>
										<select name="marca_equipo_refrigeracion" id="marca_equipo_refrigeracion" class="form-control marca_equipo_refrigeracion carac_marcas">
											<option value="">Elija una opción...</option>
											<option value="Thermoking">Thermoking</option>
											<option value="Carrier">Carrier</option>
										</select>
									</div>

								</div>


								<div id="carac_plataforma" class="row col-sm-12" style="display: none;width: 100%;">
									<div class="col-sm-12 form-group">
										<label for="">Marcas de plataforma</label>
										<select name="marca_plataforma" id="marca_plataforma" class="form-control marca_plataforma carac_marcas">
											<option value="">Elija una opción...</option>
											<option value="Wabash">Wabash</option>
											<option value="De Lucio">De Lucio</option>
											<option value="Mareksa">Mareksa</option>
											<option value="Vilchis">Vilchis</option>
											<option value="Altamirano">Altamirano</option>
											<option value="Perea">Perea</option>
											<option value="Tec Movil">Tec Movil</option>
											<option value="Otras">Otras</option>
										</select>
									</div>

								</div>

								<div id="carac_volteo" class="row col-sm-12" style="display: none;width: 100%;">


									<div class="col-sm-12 form-group">
										<label for="">Marcas de cajas de volteo</label>
										<select name="marca_cch_volteo" id="marca_cch_volteo" class="form-control marca_cch_volteo carac_marcas">
											<option value="">Elija una opción...</option>
											<option value="Hidromex">Hidromex</option>
											<option value="De Lucio">De Lucio</option>
											<option value="Mareksa">Mareksa</option>
											<option value="Freuhauf">Freuhauf</option>
											<option value="Vilchis">Vilchis</option>
											<option value="Taurho">Taurho</option>
											<option value="Utility">Utility</option>
											<option value="Otras">Otras</option>
										</select>
									</div>
								</div>


								<div class="col-sm-12 form-group">
									<label for="">Pertas</label>
									<select name="puertas" id="puertas" class="form-control puertas tipo_equipo_aleado">
										<option value="">Elija una opción...</option>
										<option value="N/A">N/A</option>
										<option value="Libro">Libro</option>
										<option value="Cortina">Cortina</option>
										<option value="Manual">Manual</option>
										<option value="Hidraulica">Hidraulica</option>
									</select>
								</div>
							</div>
	<!--
							<div id="tracto" style="display: none;">

							</div> -->
							<?php $fecha_guardado=date("Y-m-d H:i:s"); ?>
							<input type="hidden" name="idinventario" value="{{$inventario->idinventario_trucks}}"  required="" >
							<input type="hidden" name="vin" value="{{$inventario->vin_numero_serie}}" required="" >
							<input type="hidden" name="fecha_creacion" value="{{$fecha_guardado}}"  required="" >


							<div class="col-lg-12 mt-4">
								<div class="form-group">
									<center>
										<button class="btn btn-lg btn-primary w-40" type="submit">Guardar</button>
									</center>
								</div>
							</div>
						</form>


					</div>











                        <!----------------------------------->
                        </div>
                    </div>
                    <!-- ------------------------------------- -->





                </div>
              </div>



              <!-- ------------------------------------------- -->








            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  {{--@include('admin.partials.providers.js_edit_general')--}}

  <script type="text/javascript">
    var  TipoMoneda = '{{--$provider->col2--}}';
    $("#money option[value='"+TipoMoneda+"']").attr("selected", true);
    $('#ocultar_moneda').fadeOut();
    // $("#money").addClass("readonly");
    // $(".readonly").on('keydown paste focus mousedown', function(e){
    //   e.preventDefault();
    // });
  </script>


@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        var addButton = $('#add_button');
        var wrapper = $('.field_wrapper');
        var x = 0;

        $(addButton).click(function(){
            x++;
            $(wrapper).append('<div class="row"><div class="col-sm-3 form-group"> <label for="">Caracteristaica '+x+'</label><input type="text" name="caracteristicas[]" class="form-control carac"  list="caracte" value="" required/><div class="res"></div></div> <div class="col-sm-3 form-group"> <label for="">Información '+x+'</label><input type="text" name="informacion[]" class="form-control info" value="" list="infor" required/></div> <div class="col-sm-2 form-group"> <label for="">Tipo '+x+'</label><div class="content-select"><select name="tipo_especificaciones[]" class="form-control tipo_especificaciones2 tipo_especificaciones2'+x+'" id="'+x+'" onchange="nodo_sub_especificaiones('+x+')"  required><option value="">Elija una opción...</option><option value="1">Especificaciones Tecnicas</option><option value="2">Dimensiones</option><option value="3">Equipamiento</option></select><i></i></div> </div> <div class="col-sm-3 form-group"> <label for="">Sub Tipo '+x+'</label><select name="tipo_sub_especificaciones[]" class="form-control  tipo_sub_especificaciones2'+x+'"  required><option value="">Elija una opción...</option></select></div> <a class="remove_button" title="Remove field"><i class="fas fa-times fa-2x" style="color:red;"></i></a></div>');
            $(".numero_carac").val(x);
            if (x == 0) {
                $(".numero_carac").val("0");
            }
        });
        $(wrapper).on('click', '.remove_button', function(e){
            x--;
            e.preventDefault();
            $(this).parent('div').remove();
            $(".numero_carac").val(x);
        });
    });
</script>
<script>
    $(function(){
        $('.bxslider').bxSlider({
            mode: 'fade',
            captions: true,
            slideWidth: 1100
        });
    });


    // $(document).ready(function(){

    // 	$(".tipo_especificaciones2").change(function(){
    // 		var ids =$(".tipo_especificaciones2").attr("id");
    // 		var valor =$(".tipo_especificaciones2"+ids).val();
    // 		console.log(valor);
    // 		console.log("entro");
    // 		$(".tipo_sub_especificaciones2"+ids).empty();
    // 		$.post("ajax_sub_especificaciones.php", {valor:valor}, function(respuesta2) {
    // 			console.log(respuesta2);
    // 			$(".tipo_sub_especificaciones2"+ids).append(respuesta2);
    // 		});
    // 	});
    // });

    function nodo_sub_especificaiones(id){
        var ids =id;
        var valor =$(".tipo_especificaciones2"+ids).val();
        $(".tipo_sub_especificaciones2"+ids).empty();

        fetch("{{route('inventoryAdmin.getSubEspecificationsVin')}}", {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
            },
            method: "post",
            credentials: "same-origin",
            body: JSON.stringify({
                valor : valor
            })
        })
        .then(res => res.json())
        .then(function(response){
            if (response.tiempo_restante != "" ) {
                var NumNotificaciones = 1;
                // $('#body-notification-password').append('<h6 class="mt-0"><strong>Tu Key Access esta por expirar, favor de renovarla.</strong></h6><p>Ver</p><small class="text-success">Tiempo Restante: '+response.tiempo_restante+' </small>');
                $(".tipo_sub_especificaciones2"+ids).append(response.options);
            }
        })
        .catch(function(error){
            console.error('Error:', error);
        });
    }


</script>








<script  type="text/javascript" class="init">
    $(document).ready(function() {

        jQuery.datetimepicker.setLocale('es');
        jQuery('#fecha_apertura').datetimepicker({
            i18n:{
                de:{
                    months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
                    ]
                }
            },
            timepicker:false,
            format:'Y-m-d'
        });

        jQuery('#fecha_ingreso').datetimepicker({
            i18n:{
                de:{
                    months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
                    ]
                }
            },
            timepicker:false,
            format:'Y-m-d'
        });

        jQuery('#fecha_ingreso_taller').datetimepicker({
            i18n:{
                de:{
                    months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
                    ]
                }
            },
            timepicker:false,
            format:'Y-m-d'
        });

        jQuery('#fecha_salida_piso').datetimepicker({
            i18n:{
                de:{
                    months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
                    ]
                }
            },
            timepicker:false,
            format:'Y-m-d'
        });

    });


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

<script type="text/javascript" class="init">
/* Custom filtering function which will search data in column four between two values */

$(document).ready(function() {
// Event listener to the two range filtering inputs to redraw on input
$('#min, #max').keyup( function() {
table.draw();
} );
} );


</script>


<script  type="text/javascript" class="init">
				$(document).ready(function() {


					$(".equipo_al").change(function() {
						let  equipo_al = $(".equipo_al").val();
						$("#carac_cch_seca").hide(100);
						$("#carac_cch_refrigerador").hide(100);
						$("#carac_plataforma").hide(100);
						$("#carac_volteo").hide(100);
						$(".carac_marcas").removeAttr('required','required');


						if (equipo_al == "Caja seca") {
							$("#carac_cch_seca").show(100);
							$("#caja_seca").attr('required','required');
							$("#marca_caja_seca").attr('required','required');
						}else if (equipo_al =="Caja refrigeradas") {
							$("#carac_cch_refrigerador").show(100);
							$("#marca_caja_refrigerador").attr('required','required');
							$("#marca_equipo_refrigeracion").attr('required','required');
						}else if (equipo_al =="Plataforma") {
							$("#carac_plataforma").show(100);
							$("#marca_plataforma").attr('required','required');
						}else if (equipo_al =="Volteo 7mts" || equipo_al =="Volteo 14mts") {
							$("#carac_volteo").show(100);
							$("#marca_cch_volteo").attr('required','required');
						}

					});

					$("#tipo").change(function() {

						let tipo  = $("#tipo").val();
						$("#medidas_max").val("12");
						$("#motor").empty();
						$("#transmision").empty();
						if (tipo == "4x2") {
							$("#medidas_min").val("4.90");
							$("#motor").append('<option value="">Eliga opción...</option><option value="190">190</option><option value="200">200</option><option value="210">210</option><option value="220">220</option>');
							$("#transmision").append('<option value="">Eliga opción...</option><option value="6">6</option>');
						}else if (tipo == "6x2") {
							$("#medidas_min").val("6.70");
							$("#motor").append('<option value="">Eliga opción...</option><option value="250">250</option><option value="260">260</option><option value="270">270</option><option value="280">280</option><option value="290">290</option><option value="300">300</option><option value="310">310</option>');
							$("#transmision").append('<option value="">Eliga opción...</option><option value="9">9</option><option value="10">10</option>');
						}else if (tipo == "6x4") {
							$("#medidas_min").val("6.70");
							$("#motor").append('<option value="">Eliga opción...</option><option value="280">280</option><option value="290">290</option><option value="300">300</option><option value="310">310</option><option value="320">320</option><option value="330">330</option>');
							$("#transmision").append('<option value="">Eliga opción...</option><option value="9">9</option><option value="10">10</option>');
						}else if (tipo == "6x6") {
							$("#medidas_min").val("6.70");
							$("#motor").append('<option value="">Eliga opción...</option><option value="300">300</option><option value="310">310</option><option value="320">320</option><option value="330">330</option><option value="340">340</option><option value="350">350</option><option value="360">360</option><option value="370">370</option><option value="380">380</option><option value="390">390</option><option value="400">400</option>');

							$("#transmision").append('<option value="">Eliga opción...</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option>');
						}else if (tipo == "8x2") {
							$("#medidas_min").val("7.20");
							$("#motor").append('<option value="">Eliga opción...</option><option value="400">400</option><option value="410">410</option><option value="420">420</option><option value="430">430</option><option value="440">440</option><option value="450">450</option>');
							$("#transmision").append('<option value="">Eliga opción...</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option>');
						}else if (tipo == "8x4") {
							$("#medidas_min").val("7.20");
							$("#motor").append('<option value="">Eliga opción...</option><option value="400">400</option><option value="410">410</option><option value="420">420</option><option value="430">430</option><option value="440">440</option><option value="450">450</option><option value="460">460</option><option value="470">470</option><option value="480">480</option>');
							$("#transmision").append('<option value="">Eliga opción...</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option>');
						}else if (tipo == "8x6") {
							$("#medidas_min").val("7.20");
							$("#motor").append('<option value="">Eliga opción...</option><option value="430">430</option><option value="440">440</option><option value="450">450</option><option value="460">460</option><option value="470">470</option><option value="480">480</option><option value="490">490</option><option value="500">500</option>');
							$("#transmision").append('<option value="">Eliga opción...</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option>');
						}else if (tipo == "8x8") {
							$("#medidas_min").val("7.20");
							$("#motor").append('<option value="">Eliga opción...</option><option value="450">450</option><option value="460">460</option><option value="470">470</option><option value="480">480</option><option value="490">490</option><option value="500">500</option><option value="510">510</option><option value="520">520</option><option value="530">530</option><option value="540">540</option><option value="550">550</option>');
							$("#transmision").append('<option value="">Eliga opción...</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option>');
						}
					});



$("#tipo_trucks").change(function() {
	let tipo_trucks = $("#tipo_trucks").val();
	$("#medidas_max").val("");
	$("#medidas_min").val("");
	$("#motor").empty();
	$('.tipo_camion').prop('selectedIndex',0);
	$(".tipo_camion").removeAttr("required","required");
	$("#transmision").empty();
	if (tipo_trucks == "Camión" || tipo_trucks == "Tracto") {
		$("#camion").show(100);
		$(".tipo_camion").attr("required","true");

	}else{
		$("#camion").hide(100);
		$(".tipo_camion").removeAttr("required","required");


	}


});


$(".tiene_equipo_al").change(function(event) {
	let tiene_equipo_al =  $(".tiene_equipo_al").val();
	$('.tipo_equipo_aleado').prop('selectedIndex',0);
	$('.carac_marcas').prop('selectedIndex',0);
	$("#carac_cch_seca").hide(100);
	$("#carac_cch_refrigerador").hide(100);
	$("#carac_plataforma").hide(100);
	$("#carac_volteo").hide(100);
	$(".tipo_equipo_aleado").removeAttr("required","required");
	$(".carac_marcas").removeAttr('required','required');
	if (tiene_equipo_al == "SI") {
		$("#equipo_aleado").show(100);
		$(".tipo_equipo_aleado").attr("required","true");
	}else{
		$("#equipo_aleado").hide(100);
		$(".tipo_equipo_aleado").removeAttr("required","required");
	}
});
jQuery.datetimepicker.setLocale('es');
jQuery('#fecha_apertura').datetimepicker({
	i18n:{
		de:{
			months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
			],
			dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
			]
		}
	},
	timepicker:false,
	format:'Y-m-d'
});
jQuery('#fecha_ingreso').datetimepicker({
	i18n:{
		de:{
			months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
			],
			dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
			]
		}
	},
	timepicker:false,
	format:'Y-m-d'
});
jQuery('#fecha_ingreso_taller').datetimepicker({
	i18n:{
		de:{
			months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
			],
			dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
			]
		}
	},
	timepicker:false,
	format:'Y-m-d'
});
jQuery('#fecha_salida_piso').datetimepicker({
	i18n:{
		de:{
			months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
			],
			dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
			]
		}
	},
	timepicker:false,
	format:'Y-m-d'
});
});
</script>





@endsection
