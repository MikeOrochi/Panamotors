@extends('layouts.appAdmin')
@section('titulo', 'Editar Vista Previa de Movimiento Exitoso')
@php
use App\Http\Controllers\GlobalFunctionsController;
@endphp
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

  .readonly{
    background: #e9ecef;
    cursor: default;
  }

  </style>

  {{--@include('admin.partials.providers.js_edit_general')--}}

  <div class="">


      <form id="venta" name="venta" enctype="multipart/form-data" method="post" action="{{route('vpMovimientoExitoso.guardar_orden')}}" class="needs-validation confirmation">
          @csrf

          <input type="hidden" name="idVistaPrevia" value="{{Crypt::encrypt($vpme->id)}}">
          <div class="shadow panel-head-primary" style="margin-bottom:50px;">
              <h3 class="mt-3 mb-3" style="text-align:center;"><b>Datos VIN</b> </h3>
              <div class="row" style="margin-bottom:15px;">
                  <div class="col-sm-4">
                      <label for="Tipo"><b style="color:red;padding-right: 10px;">*</b>Tipo</label>
                      <input type="text" class="form-control" required value="{{$vpme->tipo_unidad}}" disabled>
                  </div>
                  <div class="col-sm-4">
                      <label for="modelo"><b style="color:red;padding-right: 10px;">*</b>VIN</label>
                      <input type="text" class="form-control" required value="{{$vpme->vin_numero_serie}}" disabled>
                  </div>
                  <div class="col-sm-4">
                      <label for="modelo"><b style="color:red;padding-right: 10px;">*</b>Marca</label>
                      <input type="text" class="form-control" required value="{{$inventario->marca}}" disabled>
                  </div>
              </div>
              <div class="row" style="margin-bottom:15px;">
                  <div class="col-sm-12">
                      <label for="modelo"><b style="color:red;padding-right: 10px;">*</b>Versión</label>
                      <input type="text" class="form-control" required value="{{$inventario->version}}" disabled>
                  </div>
              </div>
              <div class="row" style="margin-bottom:15px;">
                  <div class="col-sm-4">
                      <label for="Tipo"><b style="color:red;padding-right: 10px;">*</b>Color</label>
                      <input type="text" class="form-control" required value="{{$inventario->color}}" disabled>
                  </div>
                  <div class="col-sm-4">
                      <label for="modelo"><b style="color:red;padding-right: 10px;">*</b>Modelo</label>
                      <input type="text" class="form-control" required value="{{$inventario->modelo}}" disabled>
                  </div>
              </div>
          </div>

          <div class="shadow panel-head-primary">
              <h3 class="mt-3 mb-3" style="text-align:center;"><b>Documentación</b></h3>
              <div class="col-sm-12">
                  <div class="row" style="margin-bottom:30px;">
                      <div class="col-sm-6">
                          <label for="departamento"><b style="color:red;padding-right: 10px;">*</b>Departamento</label>
                          <select id="category" name="asignacion" class="form-control" aria-label="Default select example" required>
                              @foreach($departamentos as $value)
                                <option value='{{$value->idcatalogo_departamento}}'>{{$value->nomenclatura." - ".$value->nombre}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="col-sm-6">
                          <label for="tipo_orden"><b style="color:red;padding-right: 10px;">*</b>Tipo Orden</label>
                          <select id="tipo_ordenx" name="tipo_orden" class="form-control" aria-label="Default select example">
                          </select>
                          <!-- <input type="hidden" name='tipo_orden' id="tipx"> -->
                      </div>
                  </div>
                  <div class="row" style="margin-bottom:30px;">
                      <div class="col-sm-6">
                          <label for="responsable"><b style="color:red;padding-right: 10px;">*</b>Responsable de seguimiento</label>
                          <select id="responsablex" name="responsable" class="form-control" aria-label="Default select example" required>
                              <option selected>Open this select menu</option>
                          </select>
                          <input type="hidden" name="caso" id="caso" class="form-control" required="" value="N/A">
                          <!-- <input type="hidden" name='responsable' id="colx"> -->
                      </div>
                      <div class="col-sm-6">
                          <label for="master"><b style="color:red;padding-right: 10px;">*</b>Master</label>
                          <select id="master" name="master" class="form-control" aria-label="Default select example">
                              <!-- <option value="N/A" >N/A</option> -->
                              @foreach($masters as $value)
                                <option value='{{$value->idempleados}}'>{{$value->columna_b." - ".$value->nombre." ".$value->apellido_paterno." ".$value->apellido_materno}}</option>
                              @endforeach
                          </select>
                          <input type="hidden" class="form-control" id="idestado_cuenta" name="idestado_cuenta" value="<?php //echo "$VIN";?>" required readonly>
                          <input type="hidden" class="form-control" id="idusuario" name="idusuario" value="<?php //echo "$usuario_creador";?>" required readonly>
                          <?php
                          date_default_timezone_set('America/Mexico_City');
                          $fecha_creacion= date("Y-m-d H:i:s");
                          ?>
                          <input type="hidden" class="form-control" id="fecha_creacion" name="fecha_creacion" value="<?php echo "$fecha_creacion";?>" required readonly>
                          <input type="hidden" class="form-control" id="estatus" name="estatus" value="Solicitud" required readonly>
                      </div>
                  </div>
                  <div class="row" style="margin-bottom:30px;">
                      <div class="col-sm-6">
                          <label for="cargo_abono"><b style="color:red;padding-right: 10px;">*</b>Cargo/Abono</label>
                          <select id="cargo_abono" name="cargo_abono" class="form-control" aria-label="Default select example" required>
                              <option selected>Selecciona una opción</option>
                          </select>
                          <input type="hidden" name='tipo_mov_name' id="tipo_mov_name">
                      </div>
                      <div class="col-sm-6">
                          <label for="fecha_estimada"><b style="color:red;padding-right: 10px;">*</b>Fecha estimada de solución</label>
                          <input type="date" name="fecha_estimada_solucion" id="fecha_estimada_solucion" class="form-control" required>
                      </div>
                  </div>
                  <div class="row" style="margin-bottom:30px;">
                      <div class="col-sm-12">
                          <label for="">&nbsp; *Buscar fuente de información</label>
                          <input class="form-control" type="text" name="buscar" id="buscar_finformacion" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_finformaciones();" size="19" width="300%" required="">
                      </div>
                      <div class="col-sm-12">
                          <select id="resultadobuscar_informacion" class="form-control" style="display: none;"></select>
                          <input type="hidden" class="form-control" id="fuente_informacion" name="fuente_informacion" required readonly="">
                      </div>
                  </div>
                  <div class="row" style="margin-bottom:30px;">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label>*Descripción</label>
                              <textarea rows="6" cols="50" name="comentarios"  id="comentarios" placeholder="Descripción" class="form-control" required=""></textarea>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="shadow panel-head-primary">
              <h3 class="mt-3 mb-3" style="text-align:center;"><b>Buscar Cliente/ID</b></h3>
              <div class="col-sm-12">
                  <div class="row" style="margin-bottom:30px;">
                      <div class="col-sm-12">
                          <div class="form-group floating-label">
                              <input class="form-control" type="text" name="buscar" id="buscar_provedor" style="text-transform: uppercase" value=""  autocomplete="off" onKeyUp="buscar_provedores();" size="19" width="300%" required="">
                              <label for="cargo_abono"><b style="color:red;padding-right: 10px;">*</b>Buscar cliente/ID</label>
                              <select id="resultadobuscar" name="resultadobuscar" class="form-control" aria-label="Default select example" required>
                              </select>

                              <input type="hidden" class="form-control" id="idcontacto" name="idcontacto" required readonly="">
                              <input type="hidden" class="form-control" id="proveedor_cliente" name="proveedor_cliente" required readonly="">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-12" id="" >
                  <div class="row">
                      <div class="col-sm-6 form-group">
                          <label for="">Orden de Compra</label>
                          <select name="orden_compra" id="orden_compra" class="form-control">

                              <?php
                              // $sql2 = "SELECT * FROM orden_compra_unidades WHERE estatus != 'Finalizado' AND estatus != 'Cancelado' AND visible='SI' AND procedencia <> '' AND estatus_orden != 'No Negociable'";
                              // $resultado2 =mysql_query($sql2);
                              // while ($fila2 = mysql_fetch_array($resultado2)) {
                              //     $idorden_compra_unidades = "$fila2[idorden_compra_unidades]";
                              //     $vinoc = "$fila2[vin]";
                              //     echo '<option value="'.$idorden_compra_unidades.'">'.$idorden_compra_unidades.' - '.$vinoc.'</option>';
                              // }
                              ?>
                                @if(!empty($orden_compra_unidades))
                                <option value="{{$orden_compra_unidades->idorden_compra_unidades}}">{{$orden_compra_unidades->idorden_compra_unidades.' - '.$orden_compra_unidades->vin}}</option>
                                @else
                                <option value="N/A">N/A</option>
                                @endif

                          </select>
                      </div>
                      <div class="col-sm-6 form-group" >
                          <label for="">No. Refacturación</label>
                          <select name="refacturacion" id="refacturacion" class="form-control">
                              <option value="">Seleccione opción...</option>
                              <option value="N/A">N/A</option>
                              <?php
                              $con = 1;
                              $var = 20;
                              while ($con <= $var) {
                                  echo '<option value="'.$con.'">'.$con.'</option>';
                                  $con++;
                              }
                              ?>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12">
                  <div class="form-group">
                      <center>
                          <button class="btn btn-lg btn-primary" type="submit" id="guardar ordenes clientes">Guardar</button>
                      </center>
                  </div>
              </div>
          </div>

      </form>
  </div>



  @endsection


  @section('js')


  <script language="javascript">
      $(document).ready(function(){
          $("#category").on('change', function () {
              $("#category option:selected").each(function () {
                  var id_category = $(this).val();
                  fetch("{{route('vpMovimientoExitoso.busquedaFacturacion')}}", {
                      headers: {
                          "Content-Type": "application/json",
                          "Accept": "application/json",
                          "X-Requested-With": "XMLHttpRequest",
                          "X-CSRF-Token": '{{csrf_token()}}',
                      },
                      method: "post",
                      credentials: "same-origin",
                      body: JSON.stringify({
                          id_category : id_category
                      })
                  }).then(res => res.json())
                  .catch(function(error){
                      console.error('Error:', error)
                  })
                  .then(function(response){
                      console.log(response);
                      if (response != "") {
                          $("#responsablex").html(response.colaborador);
                          $("#tipo_ordenx").html(response.catalogo_tipo_orden);

                          var get = response.niveles_permiso.trim();
                          if (get === 'Cargo;Abono') {
                              $("#cargo_abono").html('');
                              $("#cargo_abono").append('<option value="cargo">Cargo</option><option value="abono">Abono</option>');
                              $("#tipo_mov_name").val('');
                              $("#c_a").show();
                          }
                          if (get === 'Cargo') {
                              $("#cargo_abono").html('');
                              $("#cargo_abono").append('<option value="cargo">Cargo</option><option value="N/A">N/A</option>');
                              $("#tipo_mov_name").val('cargo');
                              $("#c_a").show();
                          }
                          if (get === 'Generacion') {
                              $("#cargo_abono").html('');
                              $("#cargo_abono").append('<option value="N/A">N/A</option>');
                              $("#tipo_mov_name").val('N/A');

                          }
                      }

                  });



              });
          });

          ///Precargar opciones en tipo de orden
          id_category = $("#category").val()
          fetch("{{route('vpMovimientoExitoso.busquedaFacturacion')}}", {
              headers: {
                  "Content-Type": "application/json",
                  "Accept": "application/json",
                  "X-Requested-With": "XMLHttpRequest",
                  "X-CSRF-Token": '{{csrf_token()}}',
              },
              method: "post",
              credentials: "same-origin",
              body: JSON.stringify({
                  id_category : id_category
              })
          }).then(res => res.json())
          .catch(function(error){
              console.error('Error:', error)
          })
          .then(function(response){
              console.log(response);
              if (response != "") {
                  $("#responsablex").html(response.colaborador);
                  $("#tipo_ordenx").html(response.catalogo_tipo_orden);

                  var get = response.niveles_permiso.trim();
                  if (get === 'Cargo;Abono') {
                      $("#cargo_abono").html('');
                      $("#cargo_abono").append('<option value="cargo">Cargo</option><option value="abono">Abono</option>');
                      $("#tipo_mov_name").val('');
                      $("#c_a").show();
                  }
                  if (get === 'Cargo') {
                      $("#cargo_abono").html('');
                      $("#cargo_abono").append('<option value="cargo">Cargo</option><option value="N/A">N/A</option>');
                      $("#tipo_mov_name").val('cargo');
                      $("#c_a").show();
                  }
                  if (get === 'Generacion') {
                      $("#cargo_abono").html('');
                      $("#cargo_abono").append('<option value="N/A">N/A</option>');
                      $("#tipo_mov_name").val('N/A');

                  }
              }

          });
          ///end Precargar
      });
  </script>
  <script type="text/javascript">
      $(document).ready(function(){
         $("#resultadobuscar").click(function(){
            $("#resultadobuscar").attr('size','1');
            var selectedText = $("#resultadobuscar option:selected").html();
            $("#buscar_provedor").val(selectedText);
            $("#idcontacto").val($("#resultadobuscar option:selected").val());
         });


      });
      function buscar_provedores() {
          $("#emisor_venta").prop( "disabled", true );
          $("#agente_emisor_venta").prop( "disabled", true );
          $("#receptor_venta").prop( "disabled", true );
          $("#agente_receptor_venta").prop( "disabled", true );
          var txtbuscar = $("#buscar_provedor").val();
          if (txtbuscar != "") {
              // $.post("buscar_cliente_id.php", {valorBusqueda: txtbuscar}, function(mensaje_buscar) {
              //     $("#resultadobuscar").show(); // Mostrando Div resultadobuscar de Buscar Proveedores
              //     $("#resultadobuscar").html(mensaje_buscar);
              // });

              fetch("{{route('vpMovimientoExitoso.busquedaInformacion')}}", {
                  headers: {
                      "Content-Type": "application/json",
                      "Accept": "application/json",
                      "X-Requested-With": "XMLHttpRequest",
                      "X-CSRF-Token": '{{csrf_token()}}',
                  },
                  method: "post",
                  credentials: "same-origin",
                  body: JSON.stringify({
                      valorBusqueda : txtbuscar
                  })
              }).then(res => res.json())
              .catch(function(error){
                  console.error('Error:', error)
              })
              .then(function(response){
                  if (response != "" && response != null ) {
                      $("#resultadobuscar").show();
                      $("#resultadobuscar").attr('size','8');
                      $("#resultadobuscar").html(response.cliente);
                  }else {
                      $("#resultadobuscar_informacion").html("<p style='color: red;'>Información no encontrada</p>");
                  }

              });


          } else {
              $("#resultadobuscar").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
          };
      };
      $(document).on('click', '.sugerencias', function (event) {
          event.preventDefault();
          aux_recibido=$(this).val();
          var porcion = aux_recibido.split(';');
          $("#idcontacto").val(porcion[0]);
          $("#proveedor_cliente").val(porcion[5]);
          var1 =porcion[1];
          var2 =porcion[2];
          var3 = porcion[0];
          buscar_auxiliares_secundarios(var3);
          $("#buscar_provedor").val(var1+" "+var2);
          $("#IE").html(var1+" "+var2);
          $("#AE").html(var1+" "+var2);
          $("#IE").attr("selected", "selected");
          $("#AE").attr("selected", "selected");
          $("#IE").val(var1+" "+var2);
          $("#AE").val(var1+" "+var2);
          $("#emisor_venta").prop( "disabled", false );
          $("#agente_emisor_venta").prop( "disabled", false );
          $("#receptor_venta").prop( "disabled", false );
          $("#agente_receptor_venta").prop( "disabled", false );
          $("#resultadobuscar").html("");
          $("#resultadobuscar").hide();
          <?php if ($empleados == 2 || $empleados == 88 || $empleados == 91): ?>
              if (porcion[0] == "000.") {
                  parametros = {
                      "valor" : porcion[1]
                  };
                  $.ajax({
                      data:  parametros,
                      url:   'agregar_proveedor.php',
                      type:  'post',
                      beforeSend: function () {
                          $("#resultadobuscar").html("Agregando Proveedor, espera por favor...");
                      },
                      success:  function (response) {
                          $("#resultadobuscar").html("Guardado");
                          $("#idcontacto").val($.trim(response));
                      }
                  });
              }
          <?php endif ?>
      });
  </script>
  <script type="text/javascript">
      function buscar_finformaciones() {
          var txtbuscar = $("#buscar_finformacion").val();
          if (txtbuscar != "") {
              // $.post("buscar_fuente_informacion.php", {valorBusqueda: txtbuscar}, function(mensaje_buscar) {
              //     $("#resultadobuscar_informacion").html(mensaje_buscar);
              //     $("#resultadobuscar_informacion").show();
              // });


              fetch("{{route('vpMovimientoExitoso.busquedaInformacion')}}", {
                  headers: {
                      "Content-Type": "application/json",
                      "Accept": "application/json",
                      "X-Requested-With": "XMLHttpRequest",
                      "X-CSRF-Token": '{{csrf_token()}}',
                  },
                  method: "post",
                  credentials: "same-origin",
                  body: JSON.stringify({
                      valorBusqueda : txtbuscar
                  })
              }).then(res => res.json())
              .catch(function(error){
                  console.error('Error:', error)
              })
              .then(function(response){
                  if (response != "" && response != null ) {
                      $("#resultadobuscar_informacion").html(response.contacts+response.empleados);
                      $("#resultadobuscar_informacion").show();
                  }else {
                      $("#resultadobuscar_informacion").html("<p style='color: red;'>Información no encontrada</p>");
                  }

              });
              $("#resultadobuscar_informacion").attr('size','8');
          } else {
              $("#resultadobuscar_informacion").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
          };
      };

      $(document).ready(function(){
          $("#resultadobuscar_informacion").click(function(){
              $("#resultadobuscar_informacion").attr('size','1');
              $("#buscar_finformacion").val($("#resultadobuscar_informacion").val());
              $("#fuente_informacion").val($("#resultadobuscar_informacion").val());

          });
      });
      $(document).on('click', '.sugerencias_informacion', function (event) {
          event.preventDefault();
          aux_recibido=$(this).val();
          var porcion = aux_recibido.split(';');
          $("#fuente_informacion").val(porcion[5]);
          $("#buscar_finformacion").val(porcion[0]);
          $("#resultadobuscar_informacion").html("");
          $("#resultadobuscar_informacion").hide();
      });


      function SoloNumeros(evt){
          if(window.event){
              keynum = evt.keyCode;
          }
          else{
              keynum = evt.which;
          }
          if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
              return true;
          }else{
              return false;
          }
      }
  </script>

      <script type="text/javascript">

          window.addEventListener("load",inicio);
          function inicio(){
              document.getElementById("tipo_ordenx").addEventListener("change",activar_oc)
          }
          function activar_oc(){
              let tipo_orden = document.getElementById("tipo_ordenx").value;
              let oc_oculto = document.getElementById("oc_oculto");
              let refacturacion = document.getElementById("refacturacion");
              let orden_compra = document.getElementById("orden_compra");
              if (tipo_orden == "12") {
                  oc_oculto.style.display ="block";
                  refacturacion.setAttribute("required","true");
                  orden_compra.setAttribute("required","true");
              }else{
                  oc_oculto.style.display ="none";
                  refacturacion.removeAttribute("required","true");
                  orden_compra.removeAttribute("required","true");
              }
          }


          $(document).ready(function() {
              $('#tipo_ordenx').on('change', function () {
                  $("#tipx").val($("#tipo_ordenx option:selected").val());
              });
              $('#responsablex').on('change', function () {
                  $("#colx").val($("#responsablex option:selected").val());
              });
              $('#cargo_abono').on('change', function () {
                  $("#tipo_mov_name").val($("#cargo_abono option:selected").val());
                  if ($("#cargo_abono option:selected").val() === 'cargo') {
                      $("#c_a").show();
                      $("#asignacion").show();
                      $("#auxiliar").attr('required', 'required');
                  }if ($("#cargo_abono option:selected").val() === 'abono') {
                      $("#c_a").show();
                      $("#asignacion").show();
                      $("#auxiliar").attr('required', 'required');
                  }if ($("#cargo_abono option:selected").val() === 'N/A') {
                      $("#auxiliar").removeAttr('required', 'required');
                      $("#auxiliar").val('N/A');
                      $("#c_a").hide();
                      $("#asignacion").hide();
                  }
              });
          });
          $("#paga_cliente").keyup(function(){
              var resto_pcu = ($("#precio_orden").val()) - ($("#paga_cliente").val());
              if (resto_pcu > 0){
                  $("#utilidad_v3").css("border-color","#E7E3E2");
                  $("#utilidad_v3").css("border-color","red");
                  $("#utilidad_v3").val("La cantidad ingresada debe ser igual o mayor al costo de la orden");
              }else{
                  $("#utilidad_v3").css("border-color","black");
                  resto_pcu = Math.abs(resto_pcu);
                  $("#utilidad_v3").val(resto_pcu);
              }
          });
          function buscar_cliente() {
              var textoBusquedaVin = $("#busca_cliente").val();
              if (textoBusquedaVin != "") {
                  $.post("buscar_cliente_orden.php", {valorBusqueda: textoBusquedaVin}, function(get_data) {
                      $("#resultadobusquedacontacto").html(get_data);
                      $("#resultadobusquedacontacto").show();
                  });
              } else {
                  $("#resultadobusquedacontacto").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
              };
          };
          $(document).on('click', '.sugerencias_clienteX', function (event) {
              event.preventDefault();
              aux_recibido=$(this).val();
              var porcion = aux_recibido.split(';');
              $("#idc").val(porcion[0]);
              $("#busca_cliente").val(porcion[1]);
              $("#resultadobusquedacontacto").html('');
              $("#resultadobusquedacontacto").hide();
          });
          function buscar_letras_cliente() {
              var textoletras = $("#paga_cliente").val();
              var ppp = $("#paga_panamotors").val();
              $.post("buscar_letras.php", {valorBusqueda: ppp}, function(mensaje_letras) {
                  $("#Letra_panamotors").html(mensaje_letras);
              });
              if (textoletras != "") {
                  $.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
                      $("#Letra_cliente").html(mensaje_letras);
                  });
              } else {
                  $("#Letra_cliente").html('');
              };
          };

      </script>
      <style>
          .sugerencias_informacion:hover{
              background-color: #adadad;
              cursor:default;
          }
      </style>
      <script>
          function validateForm() {
              var idc = $("#idcontacto").val();
              var idfi = $("#fuente_informacion").val();
              if (idc === ""){
                  alert("Selecciona un proveedor");
                  $("#buscar_provedor").focus();
                  return false;
              }else if(idfi === ""){
                  alert("Selecciona una fuente de información");
                  $("#buscar_finformacion").focus();
                  return false;
              }else{
                  return true;
              }
              return false;
          }
      </script>

  @endsection
