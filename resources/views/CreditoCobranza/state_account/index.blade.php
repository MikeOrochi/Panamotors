@extends('layouts.appAdmin')
@section('titulo', 'Estado de cuenta')
@section('content')
  <style>
  #estado_cuenta_interno_1, #estado_cuenta_cliente_1, #estado_cuenta_interno, #estado_cuenta_cliente, #certificar {
    background: transparent;
    border: 0px;
  }
  .loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  select, input {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
  div.ex1 {
    height: 100%;
    width: 100%;
    overflow-y: scroll;
  }
  .iconselect{
    font-size: 18px;
  }
  #menu_estado_cuentas i{
    width: 50px;
    text-align: center;
  }
  .mostrar{
    display: block;
  }
  #list_menu{
    background: #444;
  }
  #list_menu li{
    list-style: none;
  }
  #list_menu li a{
    display: block;
    padding: 5px 10px;
    color: #fff;
  }
  #list_menu li a i{
    width: 50px;
    text-align: center;
  }
  #list_menu li a:hover{
    background: #fff;
    color: #444;
  }
  .imgloading{
    width: 120px;
  }
  .tabla-1 tbody tr:nth-child(odd){
    background: #f9f9f9;
  }
  </style>
  <script>
  document.addEventListener("DOMContentLoaded", function(event) {
    preloadFunc();
  });
  function preloadFunc() {
    getLocation();
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }
    function showPosition(position) {
      var latitud = position.coords.latitude;
      var Longitud = position.coords.longitude;
      var lat_long =latitud+", "+Longitud;
      document.getElementById("lat_l").value =  lat_long;
      document.getElementById("lat_l1").value =  lat_long;
    }
    $(".loader").hide();
    $("#mostrar_pdf").show();
  }
  function validar_password() {
    var password_access = $("#password").val();
    var usuario_view = $("#usuario_view").val();
    parametros = {
      "password_access" : password_access,
      "usuario_view" : usuario_view
    };
    $.ajax({
      data:  parametros,
      url:   'verificar_password_view_pdf_estado_cuenta.php',
      type:  'post',
      success:  function (response) {
        if (response.trim() === "SI") {
          $("#pase_visualizacion").val('U0k=');
        }else{
          $("#pase_visualizacion").val('Tk8=');
        }
      }
    });
  }
  function ver_pdf_interno() {
    var password_access = $("#password").val();
    var usuario_view = $("#usuario_view").val();
    var idc = $("#idc").val();
    var pase_visualizacion = $("#pase_visualizacion").val();
    var lat_l = $("#lat_l").val();
    var tipo_pdf = "Interno";
    if (pase_visualizacion === 'U0k=') { var pase_ver_pdf_interno = 'Visualizacion'; }
    if (pase_visualizacion === 'Tk8=') { var pase_ver_pdf_interno = 'Intento'; }
    parametros2 = {
      "password_access" : password_access,
      "usuario_view" : usuario_view,
      "idc" : idc,
      "tipo_pdf" : tipo_pdf,
      "pase_ver_pdf_interno" : pase_ver_pdf_interno,
      "lat_l" : lat_l
    };
    $.ajax({
      data:  parametros2,
      url:   'apertura_pdf_password.php',
      type:  'post',
      success:  function (response2) {
        $("#password").val("");
        if (response2.trim() === "SI" && pase_visualizacion === 'U0k=') {
          window.open("estado_cuenta_pdf.php?idc="+idc);
        }else{
          alert('La Contraseña no se ha podido autenticar, favor de vericar.');
        }
      }
    });
  }
  function validar_password_cliente() {
    var password_access = $("#password1").val();
    var usuario_view = $("#usuario_view1").val();
    parametros3 = {
      "password_access" : password_access,
      "usuario_view" : usuario_view
    };
    $.ajax({
      data:  parametros3,
      url:   'verificar_password_view_pdf_estado_cuenta.php',
      type:  'post',
      success:  function (response3) {
        if (response3.trim() ==="SI") {
          $("#pase_visualizacion1").val('U0k=');
        }else{
          $("#pase_visualizacion1").val('Tk8=');
        }
      }
    });
  }
  function ver_pdf_cliente() {
    var password_access = $("#password1").val();
    var usuario_view = $("#usuario_view1").val();
    var idc = $("#idc1").val();
    var pase_visualizacion = $("#pase_visualizacion1").val();
    var lat_l = $("#lat_l1").val();
    var tipo_pdf = "Cliente";
    if (pase_visualizacion === 'U0k=') { var pase_ver_pdf_interno = 'Visualizacion'; }
    if (pase_visualizacion === 'Tk8=') { var pase_ver_pdf_interno = 'Intento'; }
    parametros4 = {
      "password_access" : password_access,
      "usuario_view" : usuario_view,
      "idc" : idc,
      "tipo_pdf" : tipo_pdf,
      "pase_ver_pdf_interno" : pase_ver_pdf_interno,
      "lat_l" : lat_l
    };
    $.ajax({
      data:  parametros4,
      url:   'apertura_pdf_password.php',
      type:  'post',
      success:  function (response4) {
        $("#password1").val("");
        if (response4.trim()==="SI" && pase_visualizacion === 'U0k=') {
          window.open("estado_cuenta_cliente_pdf.php?idc="+idc);
        }else{
          alert('La Contraseña no se ha podido autenticar, favor de vericar.');
        }
      }
    });
  }
  </script>
  <div class="loader-wrapper">
    <div class="loader-circle">
      <div class="loader-wave"></div>
    </div>
  </div>
  <div class="container-fluid">
    {{-- <div class="col-sm-9 col-xs-12 content pt-3 pl-0" style="width: 100%;"> --}}
    <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
      <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i> </span>
      <span class="text-secondary">&nbsp;&nbsp;<a href="cliente_detalles.php?idc=<?php// echo $idcontacto_get; ?>">Cliente detalles</a></span>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</span>
      <span class="text-secondary"> Estado de cuenta</span>
      <br>
      <br>
      <center>
        <p><i class="fas fa-user-tie fa-2x"></i><br>{{$contacto->nombre}} {{$contacto->apellidos}}</p>
        <p><?php// echo $logo_unidad_truck; ?><br><?php// echo $label_title; ?></p>
      </center>
      <center><div class="loader"></div></center>

      <div style="display: none;" id="mostrar_pdf">
        <?php if (\Auth::user()->idempleados == 88 || \Auth::user()->idempleados == 204|| \Auth::user()->idempleados == 257|| \Auth::user()->idempleados == 258|| \Auth::user()->idempleados == 259): ?>


          <div class="form-control" id="menu_estado_cuentas"><i class="fas fa-list"></i>Selecciona una opción</div>
          <ul id="list_menu" style="display: none;">
            <li><a href="<?php echo 'agregar_abono_general.php?idc='.$contacto->idcontacto.''; ?>"><i class="fas fa-file-invoice-dollar"></i>Abono general</a></li>
            <li><a href="<?php echo 'agregar_otros_cargos_dev.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-coins"></i>Devolución monetaria (Cargo)</a></li>
            <li><a href="<?php echo 'anticipo_compra.php?idc='.$contacto->idcontact.''; ?>"><i class="far fa-money-bill-alt"></i>Anticipo de compra</a></li>
            <li><a href="<?php echo 'agregar_otros_cargos.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-coins"></i>Otros cargos (Cargo)</a></li>
            <li><a href="<?php echo 'agregar_venta_directa.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-hands-helping"></i>Venta directa</a></li>
            <li><a href="<?php echo 'auditar_estado_cuenta.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-search-dollar"></i>Auditar estado de cuenta</a></li>
            <li><a href="<?php echo 'agregar_venta_compra_permuta.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-people-carry"></i>Venta y compra "Permuta"</a></li>
            <li><a href="<?php echo 'agregar_apartado_vin.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-wallet"></i>Apartado del VIN</a></li>
            <li><a href="<?php echo 'estado_cuenta_cliente_pdf.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-file-pdf"></i>Estado de cuenta "Cliente"</a></li>

            <li><a href="<?php echo 'estado_cuenta_cliente_financiera_pdf.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-file-pdf"></i>Estado de cuenta "Financiera"</a></li>

            <li><a href="<?php echo 'estado_cuenta_pdf.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-passport"></i>Estado de cuenta "Interno"</a></li>
            <li><a href="<?php echo 'resumen_ejecutivo_pdf.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-scroll"></i></i>Resumen ejecutivo</a></li>
            <?php //if ($suma_ab_restante < 1): ?>
              <li><a href="<?php echo 'traspaso_admon_compras.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-exchange-alt"></i>Traspaso a: <b>Admon. Compras</b> Cargo-Abono</a></li>
              <?php //endif ?>

              <li><a href="<?php echo 'traspaso_admon_compras_abono.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-arrows-alt-h"></i>Traspaso a: <b>Admon. Compras</b> Abono-Abono </a></li>


              <!-- <li><a href="<?php echo 'graphPage.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-scroll"></i></i>Grafica</a></li> -->
            </ul>

            <!-- <select class="form-control fa" id="menu_estado_cuenta" style="height: 50px; display: none;">
            <option class="fas iconselect" value=""> &#xf03a; &emsp;Selecciona una opcion. </option>
            <option data-icon="glyphicon glyphicon-eye-open" class="fas iconselect" value="<?php echo 'agregar_abono_general.php?idc='.$contacto->idcontact.''; ?>"> &#xf571; &emsp;Abono general </option>
            <option class="fas iconselect" value="<?php echo 'agregar_otros_cargos.php?idc='.$contacto->idcontact.''; ?>"> &#xf51e; &emsp;Otros cargos </option>
            <option class="fas iconselect" value="<?php echo 'agregar_venta_directa.php?idc='.$contacto->idcontact.''; ?>"> &#xf4c4; &emsp;Venta directa </option>
            <option class="fas iconselect" value="<?php echo 'auditar_estado_cuenta.php?idc='.$contacto->idcontact.''; ?>"> &#xf688; &emsp;Auditar estado de cuenta </option>
            <option class="fas iconselect" value="<?php echo 'agregar_venta_compra_permuta.php?idc='.$contacto->idcontact.''; ?>"> &#xf4ce; &emsp;Venta y compra "Permuta" </option>
            <option class="fas iconselect" value="<?php echo 'agregar_apartado_vin.php?idc='.$contacto->idcontact.''; ?>"> &#xf555; &emsp;Apartado del VIN </option>
            <option class="fas iconselect" value="<?php echo 'estado_cuenta_cliente_pdf.php?idc='.$contacto->idcontact.''; ?>"> &#xf1c1; &emsp;Estado de cuenta "Cliente" </option>
            <option class="fas iconselect" value="<?php echo 'estado_cuenta_pdf.php?idc='.$contacto->idcontact.''; ?>"> &#xf5ab; &emsp;Estado de cuenta "Interno" </option>
          </select> -->

        <?php endif ?>

        <?php if (\Auth::user()->idempleados == 88 || \Auth::user()->idempleados == 2) {
        } else {
          date_default_timezone_set('America/Mexico_City');
          $fechainicio= date("Y-m-d H:i:s");
          $fecha=base64_encode($fechainicio);
          ?>
          <div class="form-control" id="menu_estado_cuentas"><i class="fas fa-list"></i>Selecciona una opción</div>
          <ul id="list_menu" style="display: none;">
            <li><a href="<?php echo 'agregar_abono_general.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-file-invoice-dollar"></i>Abono general</a></li>
            <li><a href="<?php echo 'anticipo_compra.php?idc='.$contacto->idcontact.''; ?>"><i class="far fa-money-bill-alt"></i>Anticipo de compra</a></li>
            <li><a href="<?php echo 'agregar_otros_cargos_dev.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-coins"></i>Devolución monetaria (Cargo)</a></li>
            <li><a href="<?php echo 'agregar_otros_cargos.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-coins"></i>Otros cargos (Cargo)</a></li>
            <li><a href="<?php echo 'agregar_venta_directa.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-hands-helping"></i>Venta directa</a></li>
            <li><a href="<?php echo 'auditar_estado_cuenta.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-search-dollar"></i>Auditar estado de cuenta</a></li>
            <li><a href="<?php echo 'agregar_venta_compra_permuta.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-people-carry"></i>Venta y compra "Permuta"</a></li>
            <li><a href="<?php echo 'agregar_apartado_vin.php?idc='.$contacto->idcontact.''; ?>"><i class="fas fa-wallet"></i>Apartado del VIN</a></li>
            <?php //if ($suma_ab_restante < 1): ?>
              <li><a href="<?php echo 'traspaso_admon_compras.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-exchange-alt"></i>Traspaso a: <b>Admon. Compras</b> Cargo-Abono</a></li>
              <?php //endif ?>
              <li><a href="<?php echo 'traspaso_admon_compras_abono.php?idc='.$contacto->idcontact.''; ?>" target="_blank"><i class="fas fa-arrows-alt-h"></i>Traspaso a: <b>Admon. Compras</b> Abono-Abono </a></li>
            </ul>
            <select class="form-control fa" id="menu_estado_cuenta" style="height: 50px; display: none;">
              <option class="fas iconselect" value=""> &#xf03a; &emsp;Selecciona una opcion. </option>
              <option class="fas iconselect" value="<?php echo 'agregar_abono_general.php?idc='.$contacto->idcontact.''; ?>"> &#xf571; &emsp; Abono general </option>
              <option class="fas iconselect" value="<?php echo 'agregar_otros_cargos.php?idc='.$contacto->idcontact.''; ?>"> &#xf51e; &emsp; Otros cargos </option>
              <option class="fas iconselect" value="<?php echo 'agregar_venta_directa.php?idc='.$contacto->idcontact.''; ?>"> &#xf4c4; &emsp; Venta directa </option>
              <option class="fas iconselect" value="<?php echo 'auditar_estado_cuenta.php?idc='.$contacto->idcontact.''; ?>"> &#xf688; &emsp; Auditar estado de cuenta </option>
              <option class="fas iconselect" value="<?php echo 'agregar_venta_compra_permuta.php?idc='.$contacto->idcontact.''; ?>"> &#xf4ce; &emsp; Venta y compra "Permuta" </option>
              <option class="fas iconselect" value="<?php echo 'agregar_apartado_vin.php?idc='.$contacto->idcontact.''; ?>"> &#xf555; &emsp; Apartado del VIN </option>
            </select>
            <div class="col-md-12"><br>
              <center>
                <!-- <button type='submit' id='estado_cuenta_interno' data-toggle="modal" data-target="#pdf_interno">
                <i class="far fa-file-pdf fa-4x"></i>
              </button> -->
              <button type='submit' id='estado_cuenta_cliente' data-toggle="modal" data-target="#pdf_cliente">
                <i class="fas fa-passport fa-4x"></i>
              </button>
              <button type='submit' id='certificar' data-toggle="modal" data-target="#certificar_estado_cuenta">
                <i class="fas fa-certificate fa-4x"></i>
              </button>
            </center>
          </div>
          <div class="modal fade bd-example-modal-lg" id="certificar_estado_cuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Validar estado de cuenta</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="col-md-12">
                    <center>
                      <div id="loading_validacion" class="ex1"></div>
                    </center>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" id="validar_edo_cuenta" style="display: none;">Validar</button>
                </div>
              </div>
            </div>
          </div>




          <div class="modal fade" id="pdf_interno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Visualizar PDF Interno</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action='estado_cuenta_pdf.php' target='_blank' autocomplete="off">
                    <div class="form-group">
                      <label for="password">Password Asignada</label>
                      <input type="password" class="form-control" id="password" onkeyup="validar_password()"  placeholder="Ingresa password" autocomplete="new-password">
                    </div>
                    <input type='hidden' id='lat_l' name='latlong'>
                    <input type='hidden' id='idc' value='<?php echo $contacto->idcontacto; ?>'>
                    <input type='hidden' id='usuario_view' value='<?php// echo $usuario_creador; ?>'>
                    <!-- <input type='text' name='pass' id='pass'> -->
                    <input type='hidden' name='pase_visualizacion' id='pase_visualizacion' value="Tk8=">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="ver_pdf_interno()">Ver Estado de Cuenta Interno</button>
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="pdf_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Visualizar PDF del Cliente</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action='estado_cuenta_cliente_pdf.php' target='_blank' autocomplete="off">
                    <div class="form-group">
                      <label for="password">Password Asignada</label>
                      <input type="password" class="form-control" id="password1" onkeyup="validar_password_cliente()" placeholder="Ingresa password" autocomplete="new-password" />
                    </div>
                    <input type='hidden' id='lat_l1' name='latlong'>
                    <input type='hidden' id='idc1' value='<?php echo $contacto->idcontact; ?>'>
                    <input type='hidden' id='usuario_view1' value='<?php// echo $usuario_creador; ?>'>
                    <!-- <input type='text' name='pass' id='pass'> -->
                    <input type='hidden' name='pase_visualizacion1' id='pase_visualizacion1' value="Tk8=">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal" onclick="ver_pdf_cliente()">Ver Estado de Cuenta Cliente</button>
                </div>
              </div>
            </div>
          </div>

          <?php } ?>



          <div class="panel-body datatable-panel">
            <table id="example" class="display nowrap" style="width:100%">
              <thead>
                <tr>

                  <th>Mov.: #</th>
                  <th>Concepto</th>
                  <th>T. Movimiento</th>
                  <th>Fecha Movimiento</th>
                  <th>Método de Pago</th>
                  <th>Monto/Precio</th>
                  <th>Cargo</th>
                  <th>Abono</th>

                  <th>Institución Emisora</th>
                  <th>Agente Emisor</th>
                  <th>Institución Receptora</th>
                  <th>Agente Receptor</th>
                  <th>Tipo Comprobante</th>
                  <th>Referencia</th>
                  <th>U. Marca</th>
                  <th>U. Versión</th>
                  <th>U. Color</th>
                  <th>U. Modelo</th>
                  <th>U. VIN</th>
                  <th>U. Estatus</th>
                  <th>Evidencia</th>
                  <th>Comentarios</th>
                  <th>Usuario Guardo</th>
                  <th>Fecha Guardado</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($estados_cuenta as $key => $estado_cuenta)
                  <tr class='odd gradeX'>
                    <td><center>{{$key+1}} <div class='sec-datos'></div> $contrato_firmado</center></td>
                    <td>{{$estado_cuenta->concepto}} $texto_doc_cobrar $abonos&nbsp;&nbsp;$documentos_cobrar</td>
                    <td>{{$estado_cuenta->tipo_movimiento}}</td>
                    <td>{{$estado_cuenta->fecha_movimiento}}</td>
                    <td>{{$estado_cuenta->metodo_pago}}</td>
                    <td>{{$estado_cuenta->monto_precio}}<br> ($saldo_letras)</td>

                    <td>$cargo_formato</td>
                    <td>$abono_formato</td>

                    <td>$fila1[emisora_institucion]</td>
                    <td>$fila1[emisora_agente]</td>
                    <td>$fila1[receptora_institucion]</td>
                    <td>$fila1[receptora_agente]</td>
                    <td>$fila1[tipo_comprobante]</td>
                    <td>$fila1[referencia]</td>
                    <td>$datos_marca</td>
                    <td>$datos_version</td>
                    <td>$datos_color</td>
                    <td>$datos_modelo</td>
                    <td>$datos_vin</td>
                    <td>$datos_estatus</td>
                    <td>$link_recibo_automatico $comprobante_pdf_recibo_automatico</td>
                    <td>$fila1[comentarios]</td>
                    <td>$usuario_creador</td>
                    <td>$fila1[fecha_guardado]</td>
                  </tr>
                @endforeach
                <?php
                // $contador = 0;
                // $sql20 = "SELECT *FROM estado_cuenta WHERE idcontacto='$contacto->idcontacto' AND visible='SI'";
                // $result20 = mysql_query($sql20);
                // $total_elementos = mysql_num_rows($result20);
                //
                // while ( $fila1 = mysql_fetch_array($result20)) {
                //   $contador++;
                //   $abonos = '';
                //   $documentos_cobrar="";
                //
                //   $ide = base64_encode($fila1['idestado_cuenta']);
                //
                //   if ($fila1['concepto']=="Venta Directa" || $fila1['concepto']=="Venta Permuta" || $fila1['concepto']=="Otros Cargos-C" || $fila1['concepto']=="Interés") {
                //     $idestado_cuenta_encode=base64_encode($fila1['idestado_cuenta']);
                //
                //     $abonos = '<li class="iconos-estatus tooltipAB">
                //     <a href="abonos_unidad.php?ide='.$idestado_cuenta_encode.'" target="_blank"><i class="fas fa-funnel-dollar"></i></a>
                //     </li>';
                //     $documentos_cobrar='<li class="iconos-estatus tooltipPG"><a href="pagares_unidad.php?idd='.$idestado_cuenta_encode.'" target="_blank"><i class="fa fa-archive" aria-hidden="true"></i></a>
                //     </li>';
                //
                //     if ($fila1['datos_estatus']=="Pagada") {
                //       $link_abonos="<b style='text-shadow: 5px 5px 5px #52ef90;'>$fila1[concepto]</b>";
                //       if ($fila1['concepto'] ==  'Venta Directa' || $fila1['concepto'] ==  'Venta Permuta') {
                //         $link_abonos.="
                //         <li class='iconos-estatus tooltip5'>
                //         <a href='carta_liberacion_pdf.php?idm=$ide' target='_blank'><i class='fas fa-clipboard-check'></i></a>
                //         </li>
                //         ";
                //       }
                //
                //     } else {
                //       $link_abonos="<b style='text-shadow: 5px 5px 5px #ef5353;'>$fila1[concepto]</b>";
                //
                //     }
                //
                //   }else{
                //     $link_abonos="$fila1[concepto]";
                //   }
                //   if (\Auth::user()->idempleados == 2 || \Auth::user()->idempleados == 88 || \Auth::user()->idempleados == 91 || \Auth::user()->idempleados == 177|| \Auth::user()->idempleados == 65) {
                //     if ($fila1['concepto']=="Venta Directa" || $fila1['concepto']=="Venta Permuta" || $fila1['concepto']=="Compra Permuta") {
                //       $ide=base64_encode($fila1['idestado_cuenta']);
                //       $contrato_firmado = '<a href="subir_cambio_archivos_firmados.php?ide='.$ide.'" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                //     }else{
                //       $contrato_firmado = '';
                //     }
                //   }
                //   $tipo_movimiento=ucwords("$fila1[tipo_movimiento]");
                //   $monto_precio_formato=number_format($fila1['monto_precio'],2);
                //   $saldo_letras= convertir($fila1['monto_precio']);
                //   if ($fila1['cargo']!="") {
                //     $cargo_formato="$ ".number_format($fila1['cargo'],2);
                //   }else{ $cargo_formato="N/A";}
                //
                //   if ($fila1['abono']!="") {
                //     $abono_formato="$ ".number_format($fila1['abono'],2);
                //   }else{ $abono_formato="N/A";}
                //
                //
                //   $abono_formato = $abono_formato == "$ " ? 'N/A' : $abono_formato;
                //   $cargo_formato = $cargo_formato == "$ " ? 'N/A' : $cargo_formato;
                //
                //
                //   $usuario_creador="N/A";
                //   $sql21= "SELECT nombre_usuario FROM usuarios WHERE idusuario='$fila1[usuario_creador]'";
                //   $result21=mysql_query($sql21);
                //   while ( $fila21 = mysql_fetch_array($result21)) {
                //     $usuario_creador="$fila21[nombre_usuario]";
                //   }
                //
                //   if ($fila1['tipo_comprobante']=="Recibo Automático") {
                //
                //     $sql23= "SELECT idrecibos FROM recibos WHERE id_estado_cuenta='$fila1[idestado_cuenta]'";
                //     $result23=mysql_query($sql23);
                //     while ( $fila23 = mysql_fetch_array($result23)) {
                //       $id_recibo="$fila23[idrecibos]";
                //     }
                //     $reciboo=base64_encode($id_recibo);
                //     $link_recibo_automatico=" <a href='recibo_pdf.php?idrb=$reciboo' title='Ver Recibo' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
                //     $url_archivo="$fila1[archivo]";
                //     if ($url_archivo=="#") {
                //       $c1=base64_encode($fila1['idcontacto']);
                //       $c2=base64_encode($fila1['idestado_cuenta']);
                //
                //       $link_archivos="<a href='recibo_firmado.php?idc=$c1&idm=$c2' title='Subir Recibo Firmado' target='_blank'><i class='fa fa-upload'></i></a>";
                //     }else{
                //       $link_archivos="<a href='$url_archivo' target='_blank'><i class='fa fa-file'></i></a>";
                //     }
                //     $link_recibo_automatico .= '&nbsp;&nbsp;&nbsp;'.$link_archivos;
                //   }else{$link_recibo_automatico='<a href="'.$fila1[archivo].'" target="_blank"><i class="fas fa-file-invoice"></i></a>'; }
                //
                //   $metodo_pago = $fila1['metodo_pago'] == '' ? 'N/A' : $fila1['metodo_pago'];
                //   $datos_marca = $fila1[datos_marca] == '' ? 'N/A' : $fila1[datos_marca];
                //   $datos_version = $fila1[datos_version] == '' ? 'N/A' : $fila1[datos_version];
                //   $datos_color = $fila1[datos_color] == '' ? 'N/A' : $fila1[datos_color];
                //   $datos_modelo = $fila1[datos_modelo] == '' ? 'N/A' : $fila1[datos_modelo];
                //   $datos_vin = $fila1[datos_vin] == '' ? 'N/A' : $fila1[datos_vin];
                //   $datos_estatus = $fila1[datos_estatus] == '' ? 'N/A' : $fila1[datos_estatus];
                //
                //
                //
                //   if ($fila1['tipo_comprobante'] == 'O-IN') {
                //     $referecia_x = $fila1['tipo_comprobante'];
                //     $sql21x= "SELECT idcomprabantes_transferencia FROM comprabantes_transferencia WHERE idmovimiento='$fila1[idestado_cuenta]' and tabla_movimiento = 'estado_cuenta'";
                //     $result21x=mysql_query($sql21x);
                //     while ( $fila21x = mysql_fetch_array($result21x)) {
                //       $idcomprabantes_transferencia=base64_encode("$fila21x[idcomprabantes_transferencia]");
                //     }
                //     $comprobante_pdf_recibo_automatico = '&nbsp;&nbsp;&nbsp;
                //     <a href="../comprobante_pdf.php?id='.$idcomprabantes_transferencia.'" target="_blank"><i class="fas fa-file-invoice-dollar"></i></a>
                //     ';
                //
                //   } else {
                //     $comprobante_pdf_recibo_automatico = '';
                //   }
                //
                //
                //
                //
                //
                //   echo "<tr class='odd gradeX'>
                //
                //   <td><center>$contador <div class='sec-datos'></div> $contrato_firmado</center></td>
                //   <td>$link_abonos $texto_doc_cobrar $abonos&nbsp;&nbsp;$documentos_cobrar</td>
                //   <td>$tipo_movimiento</td>
                //   <td>$fila1[fecha_movimiento]</td>
                //   <td>".$metodo_pago."</td>
                //   <td>$ $monto_precio_formato<br> ($saldo_letras)</td>
                //
                //   <td>$cargo_formato</td>
                //   <td>$abono_formato</td>
                //
                //   <td>$fila1[emisora_institucion]</td>
                //   <td>$fila1[emisora_agente]</td>
                //   <td>$fila1[receptora_institucion]</td>
                //   <td>$fila1[receptora_agente]</td>
                //   <td>$fila1[tipo_comprobante]</td>
                //   <td>$fila1[referencia]</td>
                //   <td>$datos_marca</td>
                //   <td>$datos_version</td>
                //   <td>$datos_color</td>
                //   <td>$datos_modelo</td>
                //   <td>$datos_vin</td>
                //   <td>$datos_estatus</td>
                //   <td>$link_recibo_automatico $comprobante_pdf_recibo_automatico</td>
                //   <td>$fila1[comentarios]</td>
                //   <td>$usuario_creador</td>
                //   <td>$fila1[fecha_guardado]</td>
                //
                //   </tr>";
                //
                //
                // }


                ?>
              </tbody>
            </table>
            {{-- </div> --}}


          </div>
        </div>
      </div>
    </div>
    <script>
    $("#validar_edo_cuenta").click(function(){
      var validar = confirm("Deseas continuar con la validacion del estado de cuenta?");

      parametros = {
        "validar" : validar,
        "idc" : "<?php// echo $idcontacto_get; ?>"
      };
      $.ajax({
        data:  parametros,
        url:   'validar_estado_cuenta.php',
        type:  'post',
        success:  function (response) {
          alert(response);
        }
      });
    });

    $("#certificar").click(function(){
      parametros = {
        "idc" : "<?php// echo $idcontacto_get; ?>"
      };
      $.ajax({
        data:  parametros,
        url:   'obtener_codigo_validacion.php',
        type:  'post',
        beforeSend: function () {
          $("#loading_validacion").html('<img class="imgloading" src="cargando.gif" alt="" >');
        },
        success: function (response) {
          parametros = {
            "idc" : "<?php// echo $idcontacto_get; ?>"
          };
          $.ajax({
            data:  parametros,
            url:   'estado_cuenta_validacion.php',
            type:  'post',
            beforeSend: function () {
              $("#loading_validacion").html('<img class="imgloading" src="cargando.gif" alt="" >');
            },
            success: function (response) {
              $("#loading_validacion").html(response);
              $("#validar_edo_cuenta").show();
            }
          });
        }
      });
    });


    $("#menu_estado_cuentas").click(function(){
      $("#list_menu").toggle("mostrar");
    })



    $('#menu_estado_cuenta').on('change', function () {
      var selectVal = $("#menu_estado_cuenta option:selected").val();
      var selectValx = $("#menu_estado_cuenta option:selected").val();
      selectVal = selectVal.split('?');

      if (selectVal[0] == 'estado_cuenta_cliente_pdf.php' || selectVal[0] == 'estado_cuenta_pdf.php') {
        window.open(selectValx);
      } else {
        location.href = selectValx;
      }


    });

    // $(document).ready(function(){
    // 	$('#example').DataTable( {
    // 		responsive: {
    // 			details: {
    // 				display: $.fn.dataTable.Responsive.display.modal( {
    // 					header: function ( row ) {
    // 						var data = row.data();
    // 						return 'Detalles de movimiento';
    // 					}
    // 				} ),
    // 				renderer: $.fn.dataTable.Responsive.renderer.tableAll()
    // 			}
    // 		},
    // 		language: {
    // 			"decimal": "",
    // 			"emptyTable": "No hay información",
    // 			"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    // 			"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    // 			"infoFiltered": "(Filtrado de _MAX_ total entradas)",
    // 			"infoPostFix": "",
    // 			"thousands": ",",
    // 			"lengthMenu": "Mostrar _MENU_ Entradas",
    // 			"loadingRecords": "Cargando...",
    // 			"processing": "Procesando...",
    // 			"search": "Buscar:",
    // 			"zeroRecords": "Sin resultados encontrados",
    // 			"paginate": {
    // 				"first": "Primero",
    // 				"last": "Ultimo",
    // 				"next": "Siguiente",
    // 				"previous": "Anterior"
    // 			}
    // 		}
    // 	} );
    // });
    </script>

  @endsection
