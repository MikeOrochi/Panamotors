@extends('layouts.appAdmin')
@if($type == "unidad") @section('titulo', 'Editar unidad') @endif
@if($type == "truck") @section('titulo', 'Editar truck') @endif
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
  @if($type == "unidad")
  <form class="needs-validation" action="{{route('inventoryAdmin.storeEditDetailsUnit')}}" method="post" id='mi_formulario'> @endif
  @if($type == "truck")
  <form class="needs-validation" action="{{route('inventoryAdmin.storeEditDetailsTruck')}}" method="post" id='mi_formulario'> @endif
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
                            <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
                            <span class="text-secondary"> Editar unidad</span>
                            <br>

                                <form id="contacto" name="contacto" method="post" action="guardar_editar_inventario.php" onsubmit="return validateForm()">
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
                                                <input type="text" class="form-control" id="marca" name="marca" required onKeyUp="buscar_marca();" value="{{$inventario->marca}}" @if($empleados == 52) readonly="" @endif>
                                                <center>
                                                    <div id="resultadoMarca"></div>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Versión</label>
                                                <input type="text" class="form-control" id="version" name="version" required onKeyUp="buscar_version();" value="{{$inventario->version}}" @if($empleados == 52) readonly="" @endif>
                                                <center>
                                                    <div id="resultadoVersion"></div>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Color</label>
                                                <input type="text" class="form-control" id="color" name="color" required onKeyUp="buscar_color();" value="{{$inventario->color}}" @if($empleados == 52) readonly="" @endif>
                                                <center>
                                                    <div id="resultadoColor"></div>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Modelo</label>
                                                <input type="text" class="form-control" id="modelo" name="modelo" required onKeyUp="buscar_modelo();" value="{{$inventario->modelo}}" @if($empleados == 52) readonly="" @endif>
                                                <center>
                                                    <div id="resultadoModelo"></div>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Precio piso</label>
                                                <input type="number" class="form-control" id="precio_piso" name="precio_piso" required value="{{$inventario->precio_piso}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Precio digital</label>
                                                <input type="number" class="form-control" id="precio_digital" name="precio_digital" required value="{{$inventario->precio_digital}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Transmisión</label>
                                                <div class="content-select">
                                                        @if($type == "unidad")
                                                        <select name="transmision" class="form-control" required="" @if($empleados == 52) readonly="" @endif>
                                                            <option value="{{$inventario->transmision}}">--- {{$inventario->transmision}} ---</option>
                                                            <option value="Manual">Manual</option>
                                                            <option value="Automática">Automática</option>
                                                        </select>
                                                        @endif
                                                        @if($type == "truck")
                                                            <input type="text" name="transmision" class="form-control transmision" id="transmision" list="transmisiones" value="{{$inventario->transmision}}" required>
                            								<datalist id="transmisiones">
                                                                @foreach($transmisiones as $key => $fila80) {
                                                                    <option value='{{$key}}'></option>";
                                                                @endforeach
                                                            </datalist>
                                                        @endif
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Procedencia</label>
                                                <div class="content-select">
                                                    <select name="procedencia" class="form-control" id="procedencia" required @if($empleados == 52) readonly="" @endif>
                                                        <option value="{{$inventario->procedencia}}">--- {{$inventario->procedencia}} ---</option>
                                                        <option value="Nacional">Nacional</option>
                                                        <option value="Importado">Importado</option>
                                                        <option value="N/A">N/A</option>
                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Matrícula</label>
                                                <input type="text" class="form-control" id="matricula" name="matricula" required value="{{$inventario->matricula}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Entidad</label>
                                                <div class="content-select">
                                                    <select name="entidad" class="form-control" id="entidad" required @if($empleados == 52) readonly="" @endif>
                                                        <option value="{{$inventario->entidad}}">--- {{$inventario->entidad}} ---</option>
                                                        @foreach($entidades as $entidad)
                                                            <option value="{{$entidad->estado}}">{{$entidad->estado}}</option>
                                                        @endforeach

                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"> <label> <i id="clean1" class="fa fa-trash-o fa-1x" aria-hidden="true"></i> Fecha de movimiento: </label><input type="text" class="form-control" id="fecha_apertura" name="fecha_apertura" required readonly value="{{$inventario->fecha_apertura}}"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group"> <label> <i id="clean2" class="fa fa-trash-o fa-1x" aria-hidden="true"></i> Fecha ingreso: </label><input type="text" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required readonly value="{{$inventario->fecha_ingreso}}"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> <i id="clean2" class="fa fa-trash-o fa-1x" aria-hidden="true"></i> Fecha ingreso taller: </label>
                                                <input type="text" class="form-control" name="fecha_ingreso_taller" id="fecha_ingreso_taller" value="{{$inventario->fecha_ingreso_taller}}" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> <i id="clean2" class="fa fa-trash-o fa-1x" aria-hidden="true"></i> Fecha salida piso: </label>
                                                <input type="text" class="form-control" name="fecha_salida_piso" id="fecha_salida_piso" value="{{$inventario->fecha_salida_piso}}" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Razón social de ingreso</label>
                                                <div class="content-select">
                                                    <select name="razon_social_ingreso" class="form-control" required @if($empleados == 52) readonly="" @endif>
                                                        <option value="{{$inventario->razon_social_ingreso}}">--- {{$inventario->razon_social_ingreso}} ---</option>
                                                        @foreach($razones_sociales as $razon_social)
                                                            <option value='{{$razon_social->nombre}}'>{{$razon_social->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Kilometraje</label>
                                                <input type="number" class="form-control" id="kilometraje" name="kilometraje" required value="{{$inventario->kilometraje}}" @if($empleados == 52) readonly="" @endif>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Segmentacion</label>
                                                <div class="content-select">
                                                    <select name="segmentacion" class="form-control" id="segmentacion" required @if($empleados == 52) readonly="" @endif>
                                                        <option value="{{$inventario->segmentacion}}">--- {{$inventario->segmentacion}} ---</option>

                                                        @foreach($segmentacion as $key => $segmento)
                                                            <option value='{{$segmento->nombre}}'>{{$segmento->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>

                                        @if($empleados != 52 && $type == "unidad")
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Tipo</label>
                                                <input type="hidden" name="segmento" value="N/A">
                                                <div class="content-select">
                                                    <select name="tipo" class="form-control" id="tipo" required>
                                                        <option value="{{$inventario->tipo}}">{{$inventario->tipo}}</option>
                                                        @foreach($tipos as $key => $tipo)
                                                            <option value='{{$key}}'>{{$key}} </option>
                                                        @endforeach
                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-sm-6" id="o_s" style="display: none;">
                                            <div class="form-group">
                                                <div id="otra_segmentacion" ></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Estatus unidad</label>
                                                <div class="content-select">
                                                    <select name="estatus_unidad" id="estatus_unidad" class="form-control" required @if($empleados == 52) readonly="" @endif>
                                                        <option value="{{$inventario->estatus_unidad}}">--- {{$inventario->estatus_unidad}} ---</option>
                                                        @foreach($estatuses as $estatus)
                                                            <option value='{{$estatus->estatus}}'>{{$estatus->estatus}} </option>
                                                        @endforeach
                                                        <?php if ($empleados == 233): ?>
                                                            <option value='Vendido'>Vendido</option>
                                                            <option value='Devolución del VIN'>Devolución del VIN</option>
                                                        <?php endif ?>
                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="e_u" style="display: none;">
                                            <div class="form-group">
                                                <div id="nombre_prestamo"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Ubicación</label>
                                                <div class="content-select">
                                                    <select name="ubicacion" class="form-control" id="ubicacion" required @if($empleados == 52) readonly="" @endif>
                                                        <option value="{{$inventario->ubicacion}}">--- {{$inventario->ubicacion}} ---</option>
                                                        @foreach($ubicaciones as $registro2){
                                                            <option value='{{$registro2->nomenclatura}}'>{{$registro2->nomenclatura."-".$registro2->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>





                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pase de VIN</label>
                                    <div class="content-select">
                                        <select name="publicado" class="form-control" id="pase_vin" required @if($empleados == 52) readonly="" @endif>
                                            <option value="{{$inventario->publicado}}">--- {{$inventario->publicado}} ---</option>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                        <i></i>
                                    </div>
                                </div>
                            </div>



                            <div class="col-sm-6" id="niveles" style="display: none;">
                                <div class="form-group">
                                    <div id="niveles_pase_vin"></div>
                                    <div><select id='nivel_pase' name='nivel_pase' class="form-control"></select></div>
                                </div>
                            </div>

                            @if($empleados != 52 && $type=="unidad")
                                @if(!$inventario_dinamico_collect->isEmpty())
                                    @foreach($inventario_dinamico_collect as $value)
                                        {!! $value!!}
                                    @endforeach
                                @endif

                                <div class="col-sm-12">
                                    <center>
                                        <a id='add_button' style='width: 180px;height: 90px;' class="add_button icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true' ></i></a>
                                        <div class="tooltipDetalleOrden mb-3">
                                            <p>Agregar Nueva Caracteristica</p>
                                        </div>
                                    </center>

                                </div>
                            @endif
                            @if($type == "truck")
                                @include('InventarioAdmin.units_trucks._edit_extra_truck')
                            @endif

                            <div class="col-sm-12 field_wrapper">

                            </div>


                            <input type="hidden" name="consignacion" value="NO">

                            @php
                            date_default_timezone_set('America/Mexico_City');
                            $actual= date("Y-m-d H:i:s");
                            $encry_f = Crypt::encrypt($actual);
                            @endphp
                            <input type="hidden" name="f" value="{{$encry_f}}">
                            @if($type == "unidad")
                            <input type="hidden" name="idi" value="{{Crypt::encrypt($inventario->idinventario)}}">@endif
                            @if($type == "truck")
                            <input type="hidden" name="idi" value="{{Crypt::encrypt($inventario->idinventario_trucks)}}">@endif

                            <input type="hidden" name="v" value="{{Crypt::encrypt($inventario->vin_numero_serie)}}">

                            <input type="hidden" name="numero_carac" value="0" required="" class="numero_carac">
                            <input type="hidden" name="iva" value="Pendiente">
                            <input type="hidden" name="estatus" value="Pendiente">


                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Comentarios</label>
                                    <textarea name="comentarios" class="form-control" rows="4" value="{{$inventario->comentarios}}" @if($empleados == 52) readonly="" @endif>{{$inventario->comentarios}}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <center>
                                        <button class="btn btn-lg btn-primary" type="submit">Guardar</button>
                                    </center>
                                </div>

                            </form>





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
@endsection
