@extends('layouts.appAdmin')
@section('titulo', 'Catalogo de proveedores')

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







            <div class="collapse" id="collapseExample">
              <div class="card card-body">
                <br>
                <div class="form-group col-lg-12">
                  <label for="exampleInputEmail1">Concepto</label>
                  <input type="text" class="form-control" id="concepto" name="">

                </div>
                <div class="form-group col-lg-12">
                  <label for="exampleInputPassword1">Descripción</label>
                  <textarea cols="5" class="form-control" name="descripcion" id="descripcion"></textarea>
                </div>
                <div class="form-group col-lg-6">
                  <label for="exampleInputEmail1">Tipo de Unidades</label>
                  <select name="tipo_unidad" id="tipo_unidad" class="form-control">
                    <option value="">Selecciona una Opción...</option>
                    <option value="AUTOS">AUTOS</option>
                    <option value="PICK UP">PICK UP</option>
                    <option value="TRUCKS">TRUCKS</option>
                  </select>

                </div>
                <div class="form-group col-lg-6">
                  <label for="exampleInputPassword1">Precio</label>
                  <input type="text" class="form-control" id="precio" name="" onkeypress="return SoloNumeros(event);">
                  <?php
                  date_default_timezone_set('America/Mexico_City');
                  $fecha_actual= date("Y-m-d H:i:s");

                  ?>
                  <input type="hidden" class="form-control" id="f" name="" value="<?php echo $fecha_actual; ?>">
                </div>

                <div class="col-sm-12">

                  <div class="form-group">
                    <label>Buscar proveedores</label>
                    <input placeholder="Buscar" class="form-control" type="text" name="buscar" id="buscar_provedor" style="text-transform: uppercase" value=""  autocomplete="off" onKeyUp="buscar_provedores();" size="19" width="300%">
                    <center>
                      <div id="resultadobuscar"></div>
                    </center>
                    <input type="hidden" class="form-control" id="idproveedor" name="idproveedor" required readonly="">
                  </div>
                </div>


                <div class="form-group">
                  <div id="btn_eliminar"><center><button type="submit" class="btn btn-primary" id="guardar_info">Guardar</button></center></div>

                </div>


              </div>
            </div>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>

            {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-lazyload-any/0.3.0/jquery.lazyload-any.min.js" charset="utf-8"></script> --}}
            {{-- <div class="lazyload"> --}}
              {{-- <script type="text/lazyload"> --}}
              {{-- // </script> --}}
              {{-- </div> --}}
            <div class="lazyload">
              <script type="text/lazyload">
              </script>
              </div>
            <div class="table-responsive">


              <div class="table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Apellidos</th>
                      <th>Editar</th>
                      <!--<th>Tab. Precios</th> <a href=""></a>-->
                    </tr>
                  </thead>
                  <tbody style="cursor: pointer;">
                    @foreach($proveedores as $key => $value)

                      <tr onclick="VerProveedor('{{route('wallet.showProvider',['idproveedores' => $value->idproveedores])}}')" class='odd gradeX'>
                        <td>{{$key+1}}</td>
                        <td>{{$value->nombre}}</td>
                        <td>{{$value->apellidos}}</td>
                        <td><a class="btn btn-success" href="{{route('provider.edit',$value->idproveedores)}}" style="color:white !important;"><i class="far fa-edit"></i></a></td>
                      </tr>
                    @endforeach
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
  <!-- <script src="../../js/bootstrap.js"></script> -->
  <!-- <script src="../../js/plugins/metisMenu/jquery.metisMenu.js"></script> -->
  <!-- <script src="../../js/plugins/slimscroll/jquery.slimscroll.min.js"></script> -->

  <!-- Custom and plugin javascript -->
  <!-- <script src="../../js/inspinia.js"></script> -->
  <!-- <script src="{{---secure_asset('public/js/plugins/pace/pace.min.js')----}}"></script> -->

  <!-- Peity -->
  <!-- <script src="{{---secure_asset('public/js/plugins/peity/jquery.peity.min.js')----}}"></script> -->

  <!-- Peity -->
  <!-- <script src="{{---secure_asset('public/js/demo/peity-demo.js')----}}"></script> -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.js"></script>
  <!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>

  function VerProveedor(url){
    window.location = url;
  }

  $(document).ready(function() {


    /*
    $('#dataTables-example').DataTable({

    "footerCallback": function ( row, data, start, end, display ) {
    var api = this.api(), data;

    // Remove the formatting to get integer data for summation
    var intVal = function ( i ) {
    return typeof i === 'string' ?
    i.replace(/[\$,]/g, '')*1 :
    typeof i === 'number' ?
    i : 0;
  };

  // Total over all pages
  total = api
  .column( 0 )
  .data()
  .reduce( function (a, b) {
  return intVal(a) + intVal(b);
}, 0 );

// Total over this page
pageTotal = api
.column( 0, { page: 'current'} )
.data()
.reduce( function (a, b) {
return intVal(a) + intVal(b);
}, 0 );

// Update footer
$( api.column( 0 ).footer() ).html(
'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Saldo Total: $ '+formatNumber.new(total.toFixed(2))+' )'
);
},
responsive: true,
lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
dom: 'Blfrtip',
});


var table = $('#dataTables-example').DataTable();

table
.order([ 0, 'asc' ])
.draw();

*/

});

/*
$(function() {
otable = $('#dataTables-example').dataTable();
})
*/







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
