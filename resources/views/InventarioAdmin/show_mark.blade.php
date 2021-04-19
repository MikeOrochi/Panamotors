@extends('layouts.appAdmin')
@if($type == "unidades")
@section('titulo', 'Inventario de unidades')
@endif
@if($type == "trucks")
@section('titulo', 'Inventario de trucks')
@endif

@section('head')

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script language="javascript">
  $(document).ready(function(){
    $("#category").on('change', function () {
      $("#category option:selected").each(function () {
        var id_category = $(this).val();
        $.post("colaborador.php", { id_category: id_category }, function(data) {
          $("#contenedorColaborador").html(data);
        });
      });
    });

    $("#category").on('change', function () {
      $("#category option:selected").each(function () {
        var id_category = $(this).val();

        $.post("tipo_orden.php", { id_category: id_category }, function(data) {
          $("#contenedortipo_orden").html(data);
        });
      });
    });
  });
</script>

<script type="text/javascript">
function buscar_provedores() {
  var txtbuscar = $("#buscar_provedor").val();
  if (txtbuscar != "") {
    $.post("buscar_proveedores.php", {valorBusqueda: txtbuscar}, function(mensaje_buscar) {
      $("#resultadobuscar").html(mensaje_buscar);
    });
  } else {
    $("#resultadobuscar").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
  };
};
$(document).on('click', '.sugerencias', function (event) {
  event.preventDefault();
  aux_recibido=$(this).val();
  var porcion = aux_recibido.split(';');
  $("#idproveedor").val(porcion[0]);
  var1 =porcion[1];
  $("#buscar_provedor").val(var1/*+" "+var2*/);
  $("#resultadobuscar").html("");
  if (porcion[0] == "000.") {
    parametros = {
      "valor" : porcion[1]
    };
    $.ajax({
      data:  parametros, //datos que se envian a traves de ajax
      url:   'agregar_proveedor.php', //archivo que recibe la peticion
      type:  'post', //método de envio
      beforeSend: function () {
        $("#resultadobuscar").html("Agregando Proveedor, espera por favor...");
      },
      success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
        $("#resultadobuscar").html("Guardado");
        $("#idproveedor").val($.trim(response));
      }
    });
  }
});
</script>

<script type="text/javascript">
function buscar_finformaciones() {
  var txtbuscar = $("#buscar_finformacion").val();
  if (txtbuscar != "") {
    $.post("buscar_fuente_informacion.php", {valorBusqueda: txtbuscar}, function(mensaje_buscar) {
      $("#resultadobuscar_informacion").html(mensaje_buscar);
    });
  } else {
    $("#resultadobuscar_informacion").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
  };
};
$(document).on('click', '.sugerencias_informacion', function (event) {
  event.preventDefault();
  aux_recibido=$(this).val();
  var porcion = aux_recibido.split(';');
  $("#fuente_informacion").val(porcion[5]);
  $("#buscar_finformacion").val(porcion[0]);
  $("#resultadobuscar_informacion").html("");
});
</script>

@endsection

@section('content')

  <style media="screen">
  #dataTables-example tr:hover >td {
    color: blue;
  }
</style>

<div class="row mt-3">
  <div class="col-sm-12">
    <div class="shadow panel-head-primary">
      <div class="table-responsive">
        <div class="container">
          <div class="row" style="padding:30px">


            <!-- --------------------------------------------------------------------------------- -->
            <div class="col-md-12" style="padding:0;">
                <span class="text-secondary">Actualización: @if(!empty($actualizacion)){{$actualizacion}}@else N/A @endif</span><br><br>
            </div>


            <div class="lazyload">
              <script type="text/lazyload">
              </script>
              </div>
            <div class="table-responsive">


              <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>VIN</th>
                      <th>Marca</th>
                      <th>Versi&oacute;n</th>
                      <th>Color</th>
                      <th>Modelo</th>
                      <th>Precio</th>
                      <th>Estatus</th>
                      @if($type == "unidades")
                      <th>Consignados</th>
                      @endif
                      @if($type == "trucks")
                      <th>Motor</th>
                      <th>Camarote</th>
                      <th>Tipo Tracto</th>
                      <th>Velocidades</th>
                      <th>Rodado</th>
                      <th>Potencia</th>
                      <th>Eje Delantero</th>
                      <th>Eje Trasero</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody style="cursor: pointer;">
                    @if($type == "unidades")
                        @foreach($inventario_unidades as $key => $value)
                            @if(!empty($value))
                                <tr onclick="VerDetalles('{{route('inventoryAdmin.showDetailsUnit',['type' => 'unidad','id'=>$value->idinventario])}}')" class='odd gradeX'>
                                    <td>@if(!empty($value->vin_numero_serie)){{$value->vin_numero_serie}}@else N/A @endif</td>
                                    <td>@if(!empty($value->marca)){{$value->marca}}@else N/A @endif</td>
                                    <td>@if(!empty($value->version)){{$value->version}}@else N/A @endif</td>
                                    <td>@if(!empty($value->color)){{$value->color}}@else N/A @endif</td>
                                    <td>@if(!empty($value->modelo)){{$value->modelo}}@else N/A @endif</td>
                                    <td>@if(!empty($value->precio_piso)){{number_format($value->precio_piso,2)}}@else N/A @endif</td>
                                    <td>@if(!empty($value->estatus_unidad)){{strtoupper($value->estatus_unidad)}}@else N/A @endif</td>
                                    <td>@if(!empty($value->consignacion)){{strtoupper($value->consignacion)}}@else N/A @endif</td>

                                    {{---<td><a class="btn btn-success" href="{{route('provider.edit',$value->idproveedores)}}" style="color:white !important;"><i class="far fa-edit"></i></a></td>---}}
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    @if($type == "trucks")
                        @foreach($inventario_trucks as $key => $value)
                            @if(!empty($value->info))
                                <tr onclick="VerDetalles('{{route('inventoryAdmin.showDetailsUnit',['type' => 'truck','id'=>$value->info->idinventario_trucks])}}')" class='odd gradeX'>
                                    <td>@if(!empty($value->info->vin_numero_serie)){{$value->info->vin_numero_serie}}@else N/A @endif</td>
                                    <td>@if(!empty($value->info->marca)){{$value->info->marca}}@else N/A @endif</td>
                                    <td>@if(!empty($value->info->version)){{$value->info->version}}@else N/A @endif</td>
                                    <td>@if(!empty($value->info->color)){{$value->info->color}}@else N/A @endif</td>
                                    <td>@if(!empty($value->info->modelo)){{$value->info->modelo}}@else N/A @endif</td>
                                    <td>@if(!empty($value->info->precio_piso)){{number_format($value->info->precio_piso,2)}}@else N/A @endif</td>
                                    <td>@if(!empty($value->info->estatus_unidad)){{strtoupper($value->info->estatus_unidad)}}@else N/A @endif</td>
                                    <td>@if(!empty($value->motor)){{$value->motor}}@else N/A @endif</td>
                                    <td>@if(!empty($value->camarote)){{$value->camarote}}@else N/A @endif</td>
                                    <td>@if(!empty($value->tipo_tracto)){{$value->tipo_tracto}}@else N/A @endif</td>
                                    <td>@if(!empty($value->velocidades)){{$value->velocidades}}@else N/A @endif</td>
                                    <td>@if(!empty($value->rodado)){{$value->rodado}}@else N/A @endif</td>
                                    <td>@if(!empty($value->potencia)){{$value->potencia}}@else N/A @endif</td>
                                    <td>@if(!empty($value->eje_delantero)){{$value->eje_delantero}}@else N/A @endif</td>
                                    <td>@if(!empty($value->eje_trasero)){{$value->eje_trasero}}@else N/A @endif</td>

                                    {{---<td><a class="btn btn-success" href="{{route('provider.edit',$value->info->idproveedores)}}" style="color:white !important;"><i class="far fa-edit"></i></a></td>---}}
                                </tr>
                            @endif
                        @endforeach
                    @endif
                  </tbody>

                </table>
                <!-- /.table-responsive -->
              </div>
            </div>

            <!-- Fin | ibox-content -->















            <!-- ------------------------------------------------------------- -->



          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection


@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.js"></script>
  <!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>

  function VerDetalles(url){
    window.location = url;
  }

  $(document).ready(function() {



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

<script type="text/javascript">






</script>

<script>
$(document).ready(function(){
  $("#guardar_info").click(function(){
    var concepto = $("#concepto").val();
    var descripcion = $("#descripcion").val();
    var tipo_unidad = $("#tipo_unidad").val();
    var precio = $("#precio").val();
    var f = $("#f").val();
    var idproveedor = $("#idproveedor").val();

    console.log(concepto);
    console.log(descripcion);
    console.log(tipo_unidad);
    console.log(precio);
    console.log(f);
    console.log(idproveedor);

    if (concepto === "") {
      $("#concepto").focus();
    }else if (descripcion === "") {
      $("#descripcion").focus();
    }else if (tipo_unidad === "") {
      $("#tipo_unidad").focus();
    }else if (precio === "") {
      $("#precio").focus();
    }else{
      parametros = {
        "concepto" : concepto,
        "descripcion" : descripcion,
        "tipo_unidad" : tipo_unidad,
        "precio" : precio,
        "idproveedor" : idproveedor,
        "f" : f
      };
      $.ajax({
        data:  parametros, //datos que se envian a traves de ajax
        url:   'agregar_tabulador_precios.php', //archivo que recibe la peticion
        type:  'post', //método de envio
        beforeSend: function () {

          $("#guardar_info").remove();
          $("#btn_eliminar").append('<center><button class="btn btn-primary" type="button" disabled id="act_btn">  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Cargando</button></center>');
        },
        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          console.log(response);
          if (response===" SI") {
            $("#act_btn").remove();
            $("#btn_eliminar").append('<center><button type="button" class="btn btn-success">Guardado</button></center>');
            myFunction();

          }else{
            alert("Error");
            myFunction1();
          }
        }
      });
    }

  });
});
</script>

<script>
function myFunction() {
  setTimeout(function(){ location.reload(); }, 1000);
}
function myFunction1() {
  setTimeout(function(){ location.reload(); }, 0);
}


function SoloNumeros(evt){
  if(window.event){ //asignamos el valor de la tecla a keynum
    keynum = evt.keyCode; //IE
  }
  else{
    keynum = evt.which; //FF
  }
  //comprobamos si se encuentra en el rango numérico
  if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47 ){
    return true;
  }
  else{
    return false;
  }
}



</script>

<script>
function myFunction() {
  alert("Proximamente...");
}
</script>
@endsection
