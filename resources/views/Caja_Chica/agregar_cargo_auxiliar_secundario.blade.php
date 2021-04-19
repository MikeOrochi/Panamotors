@extends('layouts.appAdmin')
@section('titulo', 'Moviento balance')
@section('head')
@endsection
@section('content')
  <h1></h1>
  <div class="col-sm-12 col-xs-12 content pt-3 pl-0">
    <div class="row mt-3">
      <div class="col-sm-12">
        <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
          <span class="text-secondary"> <a href=""><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
          <span class="text-secondary"> Movimientos</span>
          <br>
          <center>
            <h2><b>{{Crypt::decrypt($aux)}}</b></h2>
          </center>

          <form  action="{{route('Caja_Chica.store')}}" method="post" enctype="multipart/form-data" >
              @csrf
            <div class="row">

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="departamentos">*Departamento</label>
                  <select name="departamentos" id="departamentos" class="form-control">
                    <option value="">Eliga una opción...</option>
                    @foreach ($departamentos as $element)
                      <option value="{{$element->departamento}}">{{$element->departamento}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label for="concepto">*Concepto</label>
                  <select name="concepto" id="concepto" class="form-control" required="">
                    <option value="">Eliga una opción...</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label>Tipo</label>
                  <div class="content-select">
                    <select class="form-control" id="tipo_movimiento" name="tipo_movimiento" required>
                      <option value="">Selecciona una opción</option>
                      <option value="cargo">Cargo</option>
                      <option value="abono">Abono</option>
                    </select>
                  </div>
                </div>
              </div>

              <input type="hidden" id="efecto_venta" name="efecto_venta" class="form-control" value="" readonly="">

              <div class="col-sm-6">
                <div class="form-group">
                  <label>Fecha </label>
                  <input class="form-control" type="text" id="fecha_movimiento" name="fecha_movimiento" onclick="datatime_global('#fecha_movimiento')" required="" readonly />
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label>Buscar Proveedor</label>
                  <input placeholder="Buscar" class="form-control" type="text" name="busqueda_colaborador" id="busqueda_colaborador" value="" autocomplete="off" onKeyUp=" buscar_colaborador();" size="19" width="300%"  />
                  <center>
                    <div id="resultadoBusquedaColaborador" class="mt-4" style="display: none;"></div>
                  </center>
                </div>
              </div>

              <input type="hidden" name="fecha_creacion" id="fecha_creacion_proveedor" value="{{\Carbon\Carbon::now()}}">

              <input type="hidden" name="idcompuesto_proveedor" id="idcompuesto_proveedor" required="">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nombre </label>
                  <input class="form-control" type="text" id="nombre_ayudante" name="nombre_ayudante"  required="" readonly="" />
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label>Apellidos</label>
                  <input class="form-control" type="text" id="apellidos_ayudante" name="apellidos_ayudante" required="" readonly="" />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nomenclatura</label>
                  <input class="form-control" type="text" id="nomenclatura_ayudante" name="nomenclatura_ayudante" required="" readonly="" />
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <label>Tipo</label>
                  <input class="form-control" type="text" id="tipo_ayudante" name="tipo_ayudante" required="" readonly="" />
                </div>
              </div>



              <div class="col-sm-6">
                <div class="form-group" id="res">
                  <label for="tokenfield">*Responsable</label>
                  <input type = "text" class = "form-control" list="emple" name="empleados" id ="empleados"  required=""  />
                  <datalist id="emple">
                    @foreach ($empleados as $empleado)
                      <option value="{{$empleado->idempleados}} {{$empleado->nombre}} {{$empleado->apellido_paterno}} {{$empleado->apellido_materno}}"></option>
                    @endforeach
                  </datalist>
                </div>
              </div>


              <div class="col-sm-4">
                <div class="form-group">
                  <label for="auxiliar">¿Nuevo auxiliar?</label> <br>
                  <label>SI</label>
                  <input type="radio" class="nuevo_auxiliar radio1" name="nuevo_auxiliar" value="SI" required=""> <br>
                  <label>NO</label>
                  <input type="radio" class="nuevo_auxiliar radio1" name="nuevo_auxiliar" value="NO" required="">
                </div>
              </div>

              <div id="desc_auxiliares" style="display: none;width: 100%;">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group p-4" id="ax">
                      <label for="">*Auxiliares</label>
                      <input type = "text" class = "form-control yo" name="auxiliares[]"  id ="tokenfield3" class="komando" list="tokenfieles">
                      <datalist id="tokenfieles">
                        @foreach ($auxiliares as $auxiliar)
                          <option value="{{$auxiliar->nombre}}">
                          @endforeach
                        </datalist>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Número de Referencia</label>
                    <input class="form-control" type="text" id="n_referencia_venta" name="n_referencia_venta" onkeyup="referencias();"  required="" />
                  </div>
                </div>
                <input type="hidden" name="fecha_inicio" value='{{\Carbon\Carbon::now()}}'>
                <input type="hidden" name="nombre_auxliar" id="nombre_auxliar" value="{{Crypt::decrypt($aux)}}">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  @endsection

  @section('js')
    <script type="text/javascript">

    $(document).ready(function(){
      $('#tokenfield3').tokenfield({
        autocomplete: {
          source: function (request, response) {
            $.ajax({
              headers: {
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
              },
              data : {
                query: request.term
              },
              url : '{{route('Caja_Chica.auxiliares_tokenkenfield')}}',
              type : 'post',
              dataType: "json",
              processData: false,
              contentType: false,
              success : function(data) {
                response( data );
              },
              error : function(xhr, status) {
                alert("Error");
              }
            });
          },
          delay: 100
        },
        showAutocompleteOnFocus: true
      });

      $(".nuevo_auxiliar").change(function(evento){
        var valor = $(this).val();
        if(valor === "NO"){
          $("#desc_auxiliares").hide();
          $('#tokenfield3').removeAttr("required", "required");
          $("#tokenfield3").tokenfield('destroy');
          $("#tokenfield3").val('');

        }else{
          $('#tokenfield3').tokenfield();
          $("#desc_auxiliares").show();
          $("#tokenfield3").focus("");
          $("#tokenfield3").val("");
          $('#tokenfield3').attr("required", "required");
        }
      });

      $('select#tipo_moneda1').change(function(){

        var cambio1 = "19.50";
        var cambio2 = "15.20";
        var cambio3 = "1";
        var nada = "0";
        var valor = $(this).val();
        if(valor == 'USD'){
          $("#tipo_cambio2").val(parseFloat(cambio1));
          $('#tipo_cambio2').prop('readonly', false);
        }else if (valor == 'CAD'){
          $("#tipo_cambio2").val(parseFloat(cambio2));
          $('#tipo_cambio2').prop('readonly', false);
        }else if(valor == 'MXN'){
          $("#tipo_cambio2").val(parseFloat(cambio3));
          $('#tipo_cambio2').prop('readonly', true);
        }else if(valor == ''){
          $("#tipo_cambio2").val(parseFloat(0));
        }
      });

      $("#monto_entrada").keyup(function(){
        tipo_cambio = $("#tipo_cambio2").val();
        monto_entrada = $("#monto_entrada").val();
        monto_entrada = parseFloat(monto_entrada);
        tipo_cambio = parseFloat(tipo_cambio);
        total = monto_entrada * tipo_cambio;
        $("#monto_abono").val(total);

      });

      $("#tipo_moneda1").change(function(){
        tipo_cambio = $("#tipo_cambio2").val();
        monto_entrada = $("#monto_entrada").val();
        monto_entrada = parseFloat(monto_entrada);
        tipo_cambio = parseFloat(tipo_cambio);
        total = monto_entrada * tipo_cambio;
        $("#monto_abono").val(total);
      });

      $("#tipo_cambio2").change(function(){
        tipo_cambio = $("#tipo_cambio2").val();
        monto_entrada = $("#monto_entrada").val();
        monto_entrada = parseFloat(monto_entrada);
        tipo_cambio = parseFloat(tipo_cambio);
        total = monto_entrada * tipo_cambio;
        $("#monto_abono").val(total);
      });

      $("#monto_entrada").keyup(function(){
        monto_capturado=$("#monto_abono").val();
        saldo_pendiente=$("#saldo").val();
        operacion=$("#efecto_venta").val();
        console.log(operacion)
        monto_genereral_cifra=$("#monto_general").val(monto_capturado);
        monto_genereral_serie=$("#serie_general").val("1/1");
        if (operacion=="") {
          alert("No se ha definido un efecto para la operación (Positivo, Negativo), imposible hacer el cálculo");
          $("#monto_abono").val("");
          $("#saldo_nuevo").val("");
        }else if (operacion=="suma") {
          calculo = parseFloat(saldo_pendiente)+parseFloat(monto_capturado);
        }else if (operacion=="resta") {
          calculo = parseFloat(saldo_pendiente)-parseFloat(monto_capturado);
        }
        saldo_calculo=$("#saldo_nuevo").val(calculo);
      });

      $("#tipo_moneda1").change(function(){
        monto_capturado=$("#monto_abono").val();
        saldo_pendiente=$("#saldo").val();
        operacion=$("#efecto_venta").val();
        var calculo="";
        monto_genereral_cifra=$("#monto_general").val(monto_capturado);
        monto_genereral_serie=$("#serie_general").val("1/1");
        if (operacion=="") {
          alert("No se ha definido un efecto para la operación (Positivo, Negativo), imposible hacer el cálculo");
          $("#monto_abono").val("");
          $("#saldo_nuevo").val("");
        }
        if (operacion=="suma") {
          calculo = parseFloat(saldo_pendiente)+parseFloat(monto_capturado);
          console.log(calculo);
          $("#saldo_nuevo").val(calculo);
        }

        if (operacion=="resta") {
          calculo = parseFloat(saldo_pendiente)-parseFloat(monto_capturado);
          console.log(calculo);
          $("#saldo_nuevo").val(calculo);
        }
      });

      $('select#tipo_moneda').on('change',function(){
        var cambio1 = "19.50";
        var cambio2 = "15.20";
        var cambio3 = "1";
        var nada = "0";
        var valor = $(this).val();
        if(valor == '1'){
          $("#tipo_cambio1").val(parseFloat(cambio1));
        }else if (valor == '2'){
          $("#tipo_cambio1").val(parseFloat(cambio2));
        }else if(valor == '3'){
          $("#tipo_cambio1").val(parseFloat(cambio3));
          $('#tipo_cambio1').prop('readonly', true);

        }else if(valor == ''){
          $("#tipo_cambio1").val(parseFloat(nada));
        }
      });

      $("#monto_abono_venta").keyup(function(){
        monto_capturado_venta=$("#monto_abono_venta").val();
        saldo_pendiente_venta=$("#saldo_venta").val();
        operacion_venta=$("#efecto_venta").val();
        if (operacion_venta=="") {
          alert("No se ha definido un efecto para la operación (Positivo, Negativo), imposible hacer el cálculo");
          $("#monto_abono_venta").val("");
          $("#saldo_nuevo_venta").val("");
        }

        if (operacion_venta=="suma") {
          calculo_venta=parseFloat(saldo_pendiente_venta)+parseFloat(monto_capturado_venta);
        }
        if (operacion_venta=="resta") {
          calculo_venta=parseFloat(saldo_pendiente_venta)-parseFloat(monto_capturado_venta);
        }
        saldo_calculo_venta=$("#saldo_nuevo_venta").val(calculo_venta);
      });


      $("#tipo_movimiento").change(function(){
        $('#metodo_pago').empty();
        if($("#tipo_movimiento").val() === "cargo"){
          $("#efecto_venta").val("suma");
          $('#metodo_pago').append(
            `<option value="">Elige una opción…</option>
            <option value="1">Efectivo</option>
            <option value="3">Panamotors Center, S.A. de C.V.</option>
            <option value="6">Traspaso</option>
            `);
            referencias();
          }else{
            $("#efecto_venta").val("resta");
            $('#metodo_pago').append(
              `<option value="">Elige una opción…</option>
              <option value="3">Panamotors Center, S.A. de C.V.</option>
              <option value="6">Traspaso</option>
              `);
              referencias();
            }
          });
          $(".vin_auxi").click(function(){
            if ($(".vin_auxi").is(':checked')) {
              $("#busqueda_vin").val("");
              $("#vin_venta").val("");
              $("#desc_vin").show();
              $(".vin_auxi").removeAttr("required","required");
              $(".vin_auxi2").removeAttr("required","required");
            }

          });

          $(".vin_auxi2").click(function(){
            if ($(".vin_auxi2").is(':checked')) {
              $("#vin_venta").val("N/A");
              $("#desc_vin").hide();
              $(".vin_auxi").removeAttr("required","required");
              $(".vin_auxi2").removeAttr("required","required");
            }
          });
        });

        function ocultar_proveedor(){
          $("#buscarComi_me").val("");
          $("#nombreComi_me").val("");
          $("#apellidosComi_me").val("");
          $("#aliasComi_me").val("");
          $("#tipo_contactoComi_me").val("");
          $("#idcontacto_comision_mediacion").val("");
          $("#idcontactoComi_me").val("");
          $("#idemisor").val("");
          $('#tipo_teso').prop('selectedIndex',0);
          $('#tipo_movimiento_traspaso').prop('selectedIndex',0);

          $("#nombreComi_me").removeAttr("required","required");
          $("#apellidosComi_me").removeAttr("required","required");
          $("#aliasComi_me").removeAttr("required","required");
          $("#tipo_contactoComi_me").removeAttr("required","required");
          $("#idcontacto_comision_mediacion").removeAttr("required","required");
          $("#idcontactoComi_me").removeAttr("required","required");
          $("#idemisor").removeAttr("required","required");
          $('#tipo_teso').removeAttr("required","required");
          $('#tipo_movimiento_traspaso').removeAttr("required","required");


        }

        function mostrar_proveedor(){
          $("#buscarComi_me").val("");
          $("#nombreComi_me").val("");
          $("#apellidosComi_me").val("");
          $("#aliasComi_me").val("");
          $("#tipo_contactoComi_me").val("");
          $("#idcontacto_comision_mediacion").val("");
          $("#idcontactoComi_me").val("");
          $("#idemisor").val("");
          $('#tipo_teso').prop('selectedIndex',0);
          $('#tipo_movimiento_traspaso').prop('selectedIndex',0);


          $("#nombreComi_me").attr("required","required");
          $("#apellidosComi_me").attr("required","required");
          $("#aliasComi_me").attr("required","required");
          $("#tipo_contactoComi_me").attr("required","required");
          $("#idcontacto_comision_mediacion").attr("required","required");
          $("#idcontactoComi_me").attr("required","required");
          $("#idemisor").attr("required","required");
          $('#tipo_teso').attr("required","required");
          $('#tipo_movimiento_traspaso').attr("required","required");

        }

        function  guardarProveedorNew(){
          console.log("Entro")
          let nombre_provedor = document.getElementById('nombre_provedor').value;
          let apellidos_provedor = document.getElementById('apellidos_provedor').value;
          let alias_provedor = document.getElementById('alias_provedor').value;
          let archivo_provedor = document.getElementById('archivo_provedor').value;
          let tipo_mone_provedor = document.getElementById('tipo_mone_provedor').value;
          var files = $("#archivo_provedor")[0].files[0];
          console.log(files);
          if (nombre_provedor != "" && alias_provedor != ""  && tipo_mone_provedor != "" && archivo_provedor != "") {

            var formData = new FormData();
            formData.append('uploadedfile',files);
            formData.append('nombre_provedor',nombre_provedor);
            formData.append('apellidos_provedor',apellidos_provedor);
            formData.append('alias_provedor',alias_provedor);
            formData.append('tipo_mone_provedor',tipo_mone_provedor);
            console.log(formData);


            $.ajax({
              headers: {
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
              },
              data : formData,
              url : '{{route("Caja_Chica.store")}}',
              type : 'post',
              processData: false,
              contentType: false,
              success : function(response) {
                $("#busqueda_colaborador").val("");
                $("#resultadoBusquedaColaborador").html("");
                $("#resultadoBusquedaColaborador").hide();
                $("#idcompuesto_proveedor").val(response.idprovedores_compuesto);
                $("#nombre_ayudante").val(response.nombre);
                $("#apellidos_ayudante").val(response.apellidos);
                $("#nomenclatura_ayudante").val(response.nomeclatura);
                $("#tipo_ayudante").val("Auxiliares");
              },
              error : function(xhr, status) {
                alert("Error");
              }
            });

          }else{
            alert("vacio");
          }
        }
        function prove_su(){
          console.log("Entro")
          var textoBusquedaVin = $("#busqueda_colaborador").val();
          console.log(textoBusquedaVin);
          let partes = textoBusquedaVin.split("@@");
          $("#nombre_provedor").val(partes[0].trim());
          let apellidos;
          if (partes[1] == "") {
            apellidos= "N/A";
          }else{
            apellidos = partes[1];
          }
          $("#apellidos_provedor").val(apellidos);
        }

        function buscar_colaborador() {
          var textoBusquedaVin = $("#busqueda_colaborador").val();
          if (textoBusquedaVin != "") {
            $("#resultadoBusquedaColaborador").empty();
            $("#resultadoBusquedaColaborador").show();
            fetch("{{route('Caja_Chica.find_provider')}}",{
              headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
              },
              method: "post",
              credentials: "same-origin",
              body: JSON.stringify({
                valorBusqueda: textoBusquedaVin
              })
            }).then(res => res.json())
            .catch(function(error){
              console.error('Error:', error);
            }).then(function(response){
              $("#resultadoBusquedaColaborador").empty();
              response.providers.forEach(function array(element, index, array) {
                $("#resultadoBusquedaColaborador").append(`<div class='content-op-busqueda'>
                <option class='sugerencias_colaborador' value='`+element.idcontacto+`;`+element.nombre+`;`+element.apellidos+`;`+element.nomeclatura+`;`+element.tipo+`;'>`+element.tipo_moneda+` - `+element.idcontacto+` - `+element.nombre+` `+element.apellidos+` `+element.nomeclatura+`-`+element.tipo+`</option><span></span>
                </div>`);
              });

              response.contacts.forEach(function array(element, index, array) {
                $("#resultadoBusquedaColaborador").append(`<div class='content-op-busqueda'>
                <option class='sugerencias_colaborador' value='`+element.idcontacto+`;`+element.nombre+`;`+element.apellidos+`;`+element.nomeclatura+`;`+element.tipo+`;'>`+element.tipo_moneda+` - `+element.idcontacto+` - `+element.nombre+` `+element.apellidos+` `+element.nomeclatura+`-`+element.tipo+`</option><span></span>
                </div>`);
              });

              response.providers_inf.forEach(function array(element, index, array) {
                $("#resultadoBusquedaColaborador").append(`<div class='content-op-busqueda'>
                <option class='sugerencias_colaborador' value='`+element.idcontacto+`;`+element.nombre+`;`+element.apellidos+`;`+element.nomeclatura+`;`+element.tipo+`;'>`+element.tipo_moneda+` - `+element.idcontacto+` - `+element.nombre+` `+element.apellidos+` `+element.nomeclatura+`-`+element.tipo+`</option><span></span>
                </div>`);
              });

              if (response.contacts.length == 0 && response.providers_inf.length== 0 && response.providers.length== 0) {
                let modal_agregar_prov =`
                <div class="modal fade bd-example-modal-xl" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <div class="row">

                <div class="col-sm-6">
                <label>Nombre</label>
                <input class="form-control" type="text" id="nombre_provedor" name="nombre_provedor" readonly=""/>
                </div>

                <div class="col-sm-6">
                <label>Apellidos</label>
                <input class="form-control" type="text" id="apellidos_provedor" name="apellidos_pro" readonly=""/>
                </div>

                <div class="col-sm-6">
                <label>Alias</label>
                <input class="form-control" type="text" id="alias_provedor" name="alias_pro"/>
                </div>

                <div class="col-sm-6">
                <label>Evidencia</label>
                <input class="form-control" type="file" id="archivo_provedor" name="archivo_pro"/>
                </div>

                <div class="col-sm-12">
                <label>Moneda</label>
                <select class="form-control" id="tipo_mone_provedor" name="tipo_mone_provedor">
                <option value="">Elige una opción…</option>
                <option value="USD">USD</option>
                <option value="CAD">CAD</option>
                <option value="MXN">MXN</option>
                </select>
                </div>

                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <a  class="btn btn-primary guardarProveedorNew" id="guardarProveedorNew" onclick="guardarProveedorNew()" data-dismiss="modal">Guardar</a>
                </div>
                </div>
                </div>
                </div>
                `;

                $("#resultadoBusquedaColaborador").append(` `+modal_agregar_prov+`<div style='color:red;'><i  data-toggle="modal" data-target=".bd-example-modal-xl" onclick="prove_su();">`+textoBusquedaVin+`<i></div>`);
              }
            });
          }else{
            $("#resultadoBusquedaColaborador").hide();
            $("#resultadoBusquedaColaborador").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
          };
        };

        $(document).on('click', '.sugerencias_colaborador', function (event) {
          event.preventDefault();
          aux_recibido=$(this).val();
          var porcion = aux_recibido.split(';');
          unidad_id=porcion[0].trim();
          unidad_nombre=porcion[1].trim();
          unidad_apellidos=porcion[2].trim();
          unidad_nomenclatura=porcion[3].trim();
          unidad_tipo=porcion[4].trim();
          $("#busqueda_colaborador").val("");
          $("#colaborador").val(unidad_id);
          $("#nombre_ayudante").val(unidad_nombre);
          $("#apellidos_ayudante").val(unidad_apellidos);
          $("#nomenclatura_ayudante").val(unidad_nomenclatura);
          $("#tipo_ayudante").val(unidad_tipo);
          $("#resultadoBusquedaColaborador").html("");
          $("#resultadoBusquedaColaborador").hide();
          var nombre_ayudante = unidad_nombre.trim();
          var apellidos_ayudante = unidad_apellidos.trim();
          var res_sin = nombre_ayudante+" "+apellidos_ayudante;
          var res = res_sin.trim();
          console.log(res);
          if (res.trim() != "CCH" && res.trim() != "Caja Chica" && res.trim() != "TP1" && res.trim() != "CAJA CHICA" && res.trim() != "PANAMOTORS CENTER SA DE CV" && res.trim() != "") {
            $("#emisor_venta").append("<option value='"+res+"' >"+res+"</option>");
            $("#agente_emisor_venta").append("<option value='"+res+"' >"+res+"</option>");
            $("#receptor_venta").append("<option value='"+res+"' >"+res+"</option>");
            $("#agente_receptor_venta").append("<option value='"+res+"' >"+res+"</option>");
          }
          $("#idcompuesto_proveedor").val(unidad_id);

        });
        window.addEventListener("load",inicio);
        function inicio(){
          document.getElementById("departamentos").addEventListener("change",buscar_conceptos);
        }
        function referencias(){
          var referencia =$("#n_referencia_venta").val();
          var nombre_auxliar =$("#nombre_auxliar").val();
          var tipo_movimiento =$("#tipo_movimiento").val();
          if (referencia != "") {

            fetch("{{route('Caja_Chica.verificar_referencias')}}",{
              headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
              },
              method: "post",
              credentials: "same-origin",
              body: JSON.stringify({
                referencia:referencia ,
                nombre_auxliar:nombre_auxliar,
                tipo_movimiento:tipo_movimiento
              })
            }).then(res => res.json())
            .catch(function(error){
              console.error('Error:', error);
            }).then(function(response_refe){
              console.log(response_refe);
              response_refe.forEach(function array(element, index, array) {
                if (element.respuesta == "si") {
                  $("#n_referencia_venta").css("border", "3px solid black");
                  $("#n_referencia_venta").css("border-color", "#a5d6a7");
                  $("#enviar").removeAttr("disabled");
                  return true;
                } else if(element.respuesta == "talvez"){
                  $("#n_referencia_venta").css("border", "3px solid black");
                  $("#n_referencia_venta").css("border-color", "#ffcc80");
                  $("#enviar").removeAttr("disabled");
                  return true;

                }else{
                  $("#n_referencia_venta").css("border", "3px solid black");
                  $("#n_referencia_venta").css("border-color", "#e57373");
                  $("#enviar").attr("disabled","disabled");
                  return false;
                }
              });
            });
          }else{
            $("#n_referencia_venta").css("border", "1px solid #ced4da");
            $("#n_referencia_venta").css("border-color", "#ced4da");
            return false;
            $("#enviar").removeAttr("disabled","disabled");
          }
        }

        function buscar_conceptos(){
          let departamentos = document.getElementById("departamentos").value;
          let conceptos = document.getElementById("concepto");
          let option ="";
          $("#concepto").empty();
          $("#concepto").append(`<option value="">Eliga una opción...</option>`);
          fetch("{{route('Caja_Chica.buscar_conceptos')}}",{
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
              "X-Requested-With": "XMLHttpRequest",
              "X-CSRF-Token": '{{csrf_token()}}',
            },
            method: "post",
            credentials: "same-origin",
            body: JSON.stringify({
              departamentos:departamentos
            })
          }).then(res => res.json())
          .catch(function(error){
            console.error('Error:', error);
          }).then(function(response){
            console.log(response);
            response.forEach(function array(element, index, array) {
              option = `<option value="`+element.concepto+`">`+element.concepto+`</option>` + option;
            });
            $("#concepto").append(option);
          });
        }
        </script>


      @endsection
