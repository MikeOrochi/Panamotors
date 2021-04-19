@extends('layouts.appAdmin')
@section('titulo', 'CCP | Carga movimiento')

@section('content')

  <div class="col-lg-12" style="margin-bottom: 20px;">

    <center>
      {{-- <h2>{{$nombre_completo}}</h2> --}}
      <i class="fa fa-balance-scale fa-2x" aria-hidden="true"></i>
    </center>

  </div>


  <div class="card">
    <div class="card-header row">
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        Nuevo Movimiento
      </div>
    </div>
    <div class="card-body">
      <div id="secundario">
        <form id="cobranza" name="cobranza" enctype="multipart/form-data" method="post" action="{{route('movement.store')}}" class="needs-validation">
          @csrf
          <div id="extra"><input type="hidden" name="muestra" id="muestra1"></div>
          <input type="hidden" name="movimiento_general" value='{{$id_movimiento}}'>
          <input type="hidden" name="vin_venta_apartado" value='{{$movement->datos_vin}}'>
          <input type="hidden" name="marca_venta_apartado" value='{{$movement->datos_marca}}'>
          <input type="hidden" name="modelo_venta_apartado" value='{{$movement->datos_modelo}}'>
          <input type="hidden" name="color_venta_apartado" value='{{$movement->datos_color}}'>
          <input type="hidden" name="version_venta_apartado" value='{{$movement->datos_version}}'>
          <input type="hidden" name="precio_u" value='{{$movement->datos_precio}}'>
          <input type="hidden" name="" value='{{$movement->datos_precio}}'>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Concepto</label>
                <select class="form-control" id="concepto_grl" name="muestra" required>
                  <option value="">Selecciona una Opcion...</option>
                  <option value="Abono">Abono</option>
                  <option value="Finiquito de VIN">Finiquito de VIN</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Tipo</label>
                <select class="form-control" id="tipo_general" name="tipo_general" required="" value="{{old('tipo_general')}}" onchange="buscar_referencia()">
                  <option value="abono">Abono</option>
                  <option value="cargo">Cargo</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Efecto</label>
                <select class="form-control" id="efecto" name="efecto" required="" value="{{old('efecto')}}">

                  <option value="resta">Negativo</option>
                </select>
              </div>
            </div>
            <!--******************************************************************************************************************************************************************************-->
            <div class="col-sm-4">
              <div class="form-group">
                <label>Fecha <i id="clean1" class="fa fa-trash-o fa-1x" aria-hidden="true"></i></label>
                <input class="form-control" type="date" id="fechapago1" name="fechapago1" required="" value="{{old('fechapago1')}}">
              </div>
            </div>
          </div>
          <!--******************************************************************************************************************************************************************************-->
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Método de Pago</label>
                <select class="form-control" id="m_pago" name="m_pago" required="">
                  <option value="">Elige una opción…</option>
                  @foreach ($MetodosPago as $key => $MP)
                    <option value="{{$MP->nomeclatura}}"
                      @if ($MP->nomeclatura == old('m_pago'))
                        selected
                      @endif
                      >{{$MP->nomeclatura.' '.$MP->nombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <!--******************************************************************************************************************************************************************************-->
              <div class="col-lg-4">
                <div class="form-group">
                  <label>Tipo de Moneda</label>
                  <select class="form-control" id="tipo_moneda1" name="tipo_moneda1" required="">
                    <option value="">Elige una opción…</option>
                    @foreach (["USD","CAD","MXN"] as $key => $value)
                      <option value="{{$value}}"
                      @if ($value == old('tipo_moneda1'))
                        selected
                      @endif
                      >{{$value}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <!--******************************************************************************************************************************************************************************-->
              <div class="col-lg-4">
                <div class="form-group">
                  <label>Tipo de Cambio</label>
                  <input class="form-control" type="text" id="tipo_cambio2" name="tipo_cambio2" required="" onkeypress="return SoloNumeros(event);" value="{{old('tipo_cambio2')}}">
                </div>
              </div>
            </div>
            <!--******************************************************************************************************************************************************************************-->
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Saldo</label>
                  <input class="form-control" type="text" id="saldo" name="saldo" value="{{$saldo_anterior}}" readonly="" required="">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Cantidad</label>
                  <input class="form-control" type="text" id="monto_abono" name="monto_abono" onkeypress="return SoloNumeros(event);" required="" readonly="" value="{{old('monto_abono')}}">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Nuevo Saldo</label>
                  <input class="form-control" type="text" id="saldo_nuevo" name="saldo_nuevo" readonly="" required="" value="{{old('saldo_nuevo')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Monto</label>
                  <input class="form-control" type="text" id="monto_entrada" name="monto_entrada" required="" onkeypress="return SoloNumeros(event);" value="{{old('monto_entrada')}}">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Monto General</label>
                  <input class="form-control" type="text" id="monto_general" name="monto_general" onkeypress="return SoloNumeros(event);" required="" value="{{old('monto_general')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Monto Letra</label>
                  <input type="text" class="form-control" id="letra1" name="letra" required="" readonly="" value="{{old('letra')}}">
                </div>
              </div>
            </div>
            <!--******************************************************************************************************************************************************************************-->

            <div style="display: none;" id="vin_apartado">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Buscar VIN</label>
                    {{-- <input placeholder="Buscar" class="form-control" type="text" name="busqueda_vin_apartado" id="busqueda_vin_apartado"  maxlength="25" autocomplete="off" onkeyup="buscar_vin_apartado();" size="19" width="300%" value="{{old('busqueda_vin_apartado')}}"> --}}
                    <center>
                      <div id="resultadoBusquedaVin_apartado"></div>
                    </center>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Marca</label>
                    {{-- <input class="form-control" type="text" id="marca_venta_apartado" name="marca_venta_apartado" value="{{old('marca_venta_apartado')}}"> --}}
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Modelo</label>
                    {{-- <input class="form-control" type="text" id="modelo_venta_apartado" name="modelo_venta_apartado" value="{{old('modelo_venta_apartado')}}"> --}}
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Color</label>
                    {{-- <input class="form-control" type="text" id="color_venta_apartado" name="color_venta_apartado" value="{{old('color_venta_apartado')}}"> --}}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Versión</label>
                    {{-- <input class="form-control" type="text" id="version_venta_apartado" name="version_venta_apartado" value="{{old('version_venta_apartado')}}"> --}}
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>VIN</label>
                    {{-- <input class="form-control" type="text" id="vin_venta_apartado" name="vin_venta_apartado" minlength="8" maxlength="17" value="{{old('vin_venta_apartado')}}"> --}}
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="col-sm-12" style="display: none;" id="id_traspaso">
            <div class="form-group">
            <label>VIN Traspaso</label>
            <select class="form-control" id="cta_traspaso" name="cta_traspaso" required>
            <option value="">Elige una opción…</option>

          </select>
        </div>
      </div>-->
      <!--******************************************************************************************************************************************************************************-->
      <!--</div>
      <hr>
      <div class="col-sm-6">
      <div class="form-group">
      <label>Serie</label>
      <input class="form-control" type="text" id="serie_general" name="serie_general" onkeypress="return SoloNumeros(event);" required="" />
    </div>
  </div>-->
  <!--******************************************************************************************************************************************************************************-->
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>Institución Emisora</label>
        <select class="form-control" id="emisor" name="emisor" required="">
          <option value="">Elige una opción…</option>

          <option value="{{$idconta.'.'.$iniciales_cliente}}"
          @if ($idconta.'.'.$iniciales_cliente == old('emisor'))
            selected
          @endif
          >{{$idconta.'.'.$iniciales_cliente}}</option>

          <option value="{{$idclienteContacto.'.'.$iniciales_cliente}}"
          @if ($idclienteContacto.'.'.$iniciales_cliente == old('emisor'))
            selected
          @endif
          >{{$idclienteContacto.'.'.$iniciales_cliente}}</option>

          @foreach ($BancosEmisores as $key => $BE)
            <option value="{{$BE->nombre}}"

              @if ($BE->nombre == old('emisor'))
                selected
              @endif

              >{{$BE->nombre}}</option>
            @endforeach

          </select>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Agente Emisor</label>
          <select class="form-control" id="agente_emisor" name="agente_emisor" required="" value="{{old('agente_emisor')}}">
            <option value="">Elige una opción…</option>

            <option value="{{$idconta.'.'.$iniciales_cliente}}"
            @if ($idconta.'.'.$iniciales_cliente == old('agente_emisor'))
              selected
            @endif
            >{{$idconta.'.'.$iniciales_cliente}}</option>


            <option value="{{$idclienteContacto.'.'.$iniciales_cliente}}"
            @if ($idclienteContacto.'.'.$iniciales_cliente == old('agente_emisor'))
              selected
            @endif
            >{{$idclienteContacto.'.'.$iniciales_cliente}}</option>

            @foreach ($CatalogoTesorerias as $key => $CT)
              <option value="{{$CT->nomeclatura}}"

                @if ($CT->nomeclatura == old('agente_emisor'))
                  selected
                @endif

                >{{$CT->nomeclatura.' '.$CT->nombre}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label>Depositante</label>
            <select class="form-control" id="depositante" name="depositante" required="">
              <option value="">Elige una opción…</option>

              @foreach ([
                'MAMM' => 'MAMM - Maria de los Angeles Munguia Munguia',
                'ACL'  => 'ACL - Adela Casimiro Lovera',
                'EMY'	 => 'EMY - Eduardo Mauricio Yañez',
                'N/A'  => 'N/A'
                ] as $key => $value)

                <option value="{{$key}}"
                @if ($key == old('depositante'))
                  selected
                @endif
                >{{$value}}</option>
              @endforeach

            </select>
          </div>
        </div>
      </div>
      <!--*********************************************************************************************************************************************************************************************-->
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>Institución Receptora</label>
            <select class="form-control" id="receptor" name="receptor" required="">
              <option value="">Elige una opción…</option>

              <option value="{{$idconta.'.'.$iniciales_cliente}}"

              @if ($idconta.'.'.$iniciales_cliente == old('receptor'))
                selected
              @endif

              >{{$idconta.'.'.$iniciales_cliente}}</option>

              <option value="{{$idclienteContacto.'.'.$iniciales_cliente}}"

              @if ($idclienteContacto.'.'.$iniciales_cliente == old('receptor'))
                selected
              @endif

              >{{$idclienteContacto.'.'.$iniciales_cliente}}</option>

              @foreach ($BancosEmisores as $key => $BE)
                <option value="{{$BE->nombre}}"

                  @if ($BE->nombre == old('receptor'))
                    selected
                  @endif

                  >{{$BE->nombre}}</option>
                @endforeach

              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Agente Receptor</label>
              <select class="form-control" id="agente_receptor" name="agente_receptor" onchange="AgregarBeneficiario()" required="">

                <option value="">Elige una opción…</option>

                <option value="NEW"
                @if ("NEW" == old('agente_receptor'))
                  selected
                @endif
                >Nuevo Beneficiario</option>

                <option value="{{$idconta.'.'.$iniciales_cliente}}"
                @if ($idconta.'.'.$iniciales_cliente == old('agente_receptor'))
                  selected
                @endif
                >{{$idconta.'.'.$iniciales_cliente}}</option>

                <option value="{{$idclienteContacto.'.'.$iniciales_cliente}}"
                @if ($idclienteContacto.'.'.$iniciales_cliente == old('agente_receptor'))
                  selected
                @endif
                >{{$idclienteContacto.'.'.$iniciales_cliente}}</option>

                @foreach ($BeneficiariosProv as $key => $BP)
                  <option value="{{$BP->nombre}}"
                    @if ($BP->nombre == old('agente_receptor'))
                      selected
                    @endif
                    >{{$BP->nombre}}</option>
                  @endforeach

                  @foreach ($CatalogoTesorerias as $key => $CT)
                    <option value="{{$CT->nomeclatura}}"
                      @if ($CT->nomeclatura == old('agente_receptor'))
                        selected
                      @endif
                      >{{$CT->nomeclatura.' '.$CT->nombre}}</option>
                    @endforeach

                  </select>
                </div>
              </div>
            </div>

            <div id="nuevo_beneficiario" style="display: none" class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Nombre</label>
                  <input class="form-control" type="text" id="nombre_beneficiario" name="nombre_beneficiario" minlength="5" value="{{old('nombre_beneficiario')}}">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Cuenta</label>
                  <input class="form-control" type="text" id="cuenta_beneficiario" name="cuenta_beneficiario" minlength="10" value="{{old('cuenta_beneficiario')}}">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Clabe</label>
                  <input class="form-control" type="text" id="clabe_beneficiario" name="clabe_beneficiario" minlength="18" value="{{old('clabe_beneficiario')}}">
                </div>
              </div>
            </div>
            <!--*****************************************************************************************************************************************************************************************-->
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Tipo de Comprobante</label>
                  <select class="form-control" id="comprobante" name="comprobante" onchange="ocultar_referencia(this.value);" required="">
                    <option value="">Elige una opción…</option>
                    @foreach ($CatalogoComprobante as $key => $CC)
                      <option value="{{$CC->nombre}}"

                        @if ($CC->nombre == old('comprobante'))
                          selected
                        @endif

                        >{{$CC->nombre}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Numero de Referencia</label> <label id="respuesta_referecia"></label>
                    <input class="form-control" type="text" id="n_referencia" name="n_referencia" minlength="6" required="" onkeyup="buscar_referencia();" value="{{old('n_referencia')}}">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Numero de Actividad</label>
                    <input class="form-control" type="text" id="n_referencia_actividad" name="n_referencia_actividad" required="" onkeyup="" autocomplete="off" value="{{old('n_referencia_actividad')}}">
                  </div>
                </div>
              </div>
              <!--*****************************************************************************************************************************************************************************************-->
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Evidencia:</label>
                    <input type="file" placeholder="Evidencia de Comprobante" name="uploadedfile" id="comprobante_archivo" class="form-control" required="">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Comentarios:</label>
                    <textarea class="form-control" rows="2" id="descripcion" name="descripcion" maxlength="8950" required="">{{old('descripcion')}}</textarea>
                  </div>
                </div>
              </div>
              <!--*****************************************************************************************************************************************************************************************-->
              <div class="hr-line-dashed"></div>
              <input type="hidden" name="contacto_original" value="{{$idconta}}">
              <input type="hidden" id="concepto_general" name="concepto_general" value="{{old('concepto_general')}}">
              <input type="hidden" name="fecha_inicio" value="{{\Carbon\Carbon::now()}}">
              <input type="hidden" id="idinventario_apartado" name="idinventario_apartado" value="{{old('idinventario_apartado')}}" required="">
              <input type="hidden" id="refe_val" value="NO">
              <!--*****************************************************************************************************************************************************************************************-->
              <div class="form-group">
                <div class="col-lg-12">
                  <br>
                  <center>
                    <button class="btn btn-lg btn-primary" id="enviar" type="submit">Guardar</button>
                  </center>
                </div>
              </div>
            </form>
          </div>



        </div>
      </div>


      <script type="text/javascript">
      function MostrarForm(id) {
        if (id == "") {
          $("#principal").hide();
          $("#secundario").hide();
          $("#concepto_general").val(id);
          $("#concepto_general_venta").val(id);
          $("#cargos_ad").hide();
        }else if (id=="Compra Directa" || id=="Compra Directa" || id=="Venta Permuta" || id=="Compra Permuta" || id=="Cuenta de Deuda"  || id=="Devolución del VIN" || id=="Consignación") {
          $("#principal").show();
          $("#secundario").hide();
          $("#cargos_ad").hide();
          $("#concepto_general").val(id);
          $("#concepto_general_venta").val(id);
          if(id=="Cuenta de Deuda"){
            $("#emisor_venta option[value='']").remove();
            $("#agente_emisor_venta option[value='']").remove();



            $("#emisor_venta").attr('disabled','disabled');//.val(def);
            $("#agente_emisor_venta").attr('disabled','disabled');//.val(def);
          }
          else{
            $("#emisor_venta option:selected").before($('<option>',{value: "",text:"Elige una opcion..."}));
            $("#emisor_venta").removeAttr('disabled').val("");
            $("#agente_emisor_venta option:selected").before($('<option>',{value: "",text:"Elige una opcion..."}));
            $("#agente_emisor_venta").removeAttr('disabled').append($('<option>',{value: "",text:"Elige una opcion..."})).val("");
          }
        }else if(id=="Legalizacion" || id=="Comision de Compra" || id=="Traslado"){
          $("#principal").hide();
          $("#secundario").hide();
          $("#cargos_ad").show();
        }else{
          $("#principal").hide();
          $("#secundario").show();
          $("#concepto_general").val(id);
          $("#concepto_general_venta").val(id);
          $("#cargos_ad").hide();
        }
        if (id=="Devolución del VIN") {

          $("#cargo_select").attr({
            selected: true,
          });
        }else{
          $("#cargo_select").attr({
            selected: false,
          });
        }
        if (id=="Apartado" || id=="Abono" || id=="Descuento por Pago Anticipado" || id=="Préstamo" || id=="Devolución del VIN" || id=="Anticipo de Compra" || id=="Comisión por Mediación Mercantil") {
          $("#efecto option[value='suma']").remove();
          $("#efecto option[value='resta']").remove();
          var muestra = $("#muestra").val();
          console.log(muestra);
          $("#muestra1").val(muestra);
          $('#efecto').append($('<option>', {
            value: "resta",
            text: 'Negativo'
          }));
          $("#efecto option[value='suma']").remove();
        }else if (id=="Documentos por Pagar" || id=="Devolucion" || id=="Finiquito" || id=="Finiquito de Deuda") {
          $("#efecto option[value='suma']").remove();
          $("#efecto option[value='resta']").remove();
          $("#muestra1").val("");
          $('#efecto').append($('<option>', {
            value: "suma",
            text: 'Positivo'
          }),$('<option>', {
            value: "resta",
            text: 'Negativo'
          }));
          //$("#efecto option[value='resta']").remove();
        }else if(id=="Legalizacion" || id=="Comision de Compra" || id=="Traslado"){
          $("#concepto_general_cargo").val(id);
        }
        //alert("Recibido: "+id);

        if (id=="Otros Cargos") {
          $("#m_pago").append('<option id="cargos_otros_new" value="N/A">8 No Aplica</option>');
        }else{
          $("#cargos_otros_new").remove();
        }

        if (id=="Apartado"){
          $("#vin_apartado").show();
        }else{
          $("#vin_apartado").hide();
          $("#marca_venta_apartado").removeAttr("required", "required");
          $("#modelo_venta_apartado").removeAttr("required", "required");
          $("#color_venta_apartado").removeAttr("required", "required");
          $("#version_venta_apartado").removeAttr("required", "required");
          $("#vin_venta_apartado").removeAttr("required", "required");

        }
        if(id=="Traspaso"){
          $("#id_traspaso").show();
          $("#muestra1").val($("#muestra").val());
          $("#efecto option[value='suma']").remove();
          $("#efecto option[value='resta']").remove();
          $("#efecto").append($('<option>',{value:"resta",text:"Negativo"}));
          $("#depositante option:selected").before($('<option>',{value:"N/A",text:"N/A"}));
          $("#depositante").val("N/A").attr('disabled','disabled');
        }
        else{
          $("#id_traspaso").hide();
          $("#muestra1").val($("#muestra").val());
          $("#efecto option[value='suma']").remove();
          $("#efecto option[value='resta']").remove();
          $("#efecto").append($('<option>',{value:"resta",text:"Negativo"}));
          $("#cta_traspaso").removeAttr('required');
          //$("#depositante option:selected").before($('<option>',{value:"N/A",text:"N/A"}));
          //$("#depositante").val("N/A").attr('disabled','disabled');
        }

      }

      var Temporizador_VIN;
      var BusquedaVinTexto = null;

      function buscar_vin_bloqueado() {
        if (BusquedaVinTexto != $("#busqueda_vin").val().trim()) {
          BusquedaVinTexto = $("#busqueda_vin").val().trim();

          $('#resultadoBusquedaVin').html(`
            <div class="text-center">
            <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            </div>`);

            clearTimeout(Temporizador_VIN);
            Temporizador_VIN = setTimeout(function() {
              buscar_vin_bloqueado_Tempo();
            }, 350);
          }
        }



        //---------------------------------------------------------------------------------------------------------------------------------------------
        function buscar_vin_bloqueado_Tempo() {

          var textoBusquedaVin = $("#busqueda_vin").val().trim();

          if (textoBusquedaVin != "") {

            fetch("{{route('search.vin')}}", {
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
            .catch(function(error) {
              console.error('Error:', error)
            })
            .then(function(response) {

              console.log(response);

              if (response != null) {

                $("#resultadoBusquedaVin").html('');
                $("#marca_venta").attr("readonly", "readonly");
                $("#version_venta").attr("readonly", "readonly");
                $("#color_venta").attr("readonly", "readonly");
                $("#modelo_venta").attr("readonly", "readonly");
                $("#vin_venta").attr("readonly", "readonly");

                response.forEach(function logArrayElements(element, index, array) {

                  $("#resultadoBusquedaVin").append(`
                    <option class="sugerencias_vin" onclick="SugerenciaVIN('` +
                    (element.idinventario_trucks || element.idinventario) + `','` +
                    element.marca + `','` +
                    element.version + `','` +
                    element.color + `','` +
                    element.modelo + `','` +
                    element.vin_numero_serie + `')">` +
                    element.marca + `-` + element.version + `-` +
                    element.color + `-` + element.modelo + `-` +
                    element.vin_numero_serie + `</option>`);
                  });
                } else {
                  $("#resultadoBusquedaVin").html("<b>VIN NO Encontrado</b> <b>Completa los campos marcados<b>");
                  $("#marca_venta").val("").removeAttr("readonly").css("border-color", "#A0213C").focus();
                  $("#modelo_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                  $("#color_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                  $("#version_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                  $("#vin_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                  $("#orden_logistica").val("SI");
                }

              });


            } else {
              $("#resultadoBusquedaVin").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
            };
          }

          function SugerenciaVIN(id, marca, version, color, modelo, NoSerie) {

            var textoBusquedaVin = NoSerie;
            var unidad_marca = marca;
            var unidad_modelo = modelo;
            var unidad_version = version;
            var unidad_color = color;

            var idbusquedaContacto = '{{$idclienteContacto}}';

            $('#Myloader').fadeIn();

            fetch("{{route('search_lock.vin')}}", {
              headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
              },
              method: "post",
              credentials: "same-origin",
              body: JSON.stringify({
                valorBusqueda: textoBusquedaVin,
                idCliente: idbusquedaContacto
              })
            }).then(res => res.json())
            .catch(function(error) {
              console.error('Error:', error);
              $('#Myloader').fadeOut();
            })
            .then(function(mensaje_vin_bloqueado) {

              $('#Myloader').fadeOut();

              if (mensaje_vin_bloqueado == 3) { //El vin aparece como pendiente en el estado de cuenta general

                iziToast.error({
                  title: 'Atención',
                  message: 'El VIN se encontró como Pendiente de otro cliente',
                  position: 'topRight'
                });

                $("#marca_venta").val("").attr("readonly", "readonly");
                $("#modelo_venta").val("").attr("readonly", "readonly");
                $("#version_venta").val("").attr("readonly", "readonly");
                $("#color_venta").val("").attr("readonly", "readonly");
                $("#vin_venta").val("").attr("readonly", "readonly");
              } //end if; El vin aparece como pendiente en el estado de cuenta general
              else if (mensaje_vin_bloqueado == 2) { //El vin aparece activo en el inventario

                iziToast.error({
                  title: 'Atención',
                  message: 'El VIN se encontró activo en el Inventario',
                  position: 'topRight'
                });

                $("#marca_venta").val("").attr("readonly", "readonly");
                $("#modelo_venta").val("").attr("readonly", "readonly");
                $("#version_venta").val("").attr("readonly", "readonly");
                $("#color_venta").val("").attr("readonly", "readonly");
                $("#vin_venta").val("").attr("readonly", "readonly");
              }
              //end elseif; El vin aparece activo en el inventario
              else if (mensaje_vin_bloqueado == 1) { //El vin ya fue ingresado en una orden logistica

                iziToast.warning({
                  title: 'Atención',
                  message: 'El VIN se encontró activo en una Orden de Logistica',
                  position: 'topRight'
                });

                $("#marca_venta").val(unidad_marca).attr("readonly", "readonly");
                $("#modelo_venta").val(unidad_modelo).attr("readonly", "readonly");
                $("#version_venta").val(unidad_version).attr("readonly", "readonly");
                $("#color_venta").val(unidad_color).attr("readonly", "readonly");
                $("#vin_venta").val(textoBusquedaVin).attr("readonly", "readonly");
                $("#orden_logistica").val("NO");
              } //end elseif; El vin ya fue ingresado en una orden logistica
              else { //El VIN se puede recibir
                $("#marca_venta").val(unidad_marca).attr("readonly", "readonly");
                $("#modelo_venta").val(unidad_modelo).attr("readonly", "readonly");
                $("#version_venta").val(unidad_version).attr("readonly", "readonly");
                $("#color_venta").val(unidad_color).attr("readonly", "readonly");
                $("#vin_venta").val(textoBusquedaVin).attr("readonly", "readonly");
                $("#orden_logistica").val("SI");
              } //end else; El VIN se puede recibir
              $("#resultadoBusquedaVin").html("");

            });

          }



          var Temporizador_VIN_Apartado;
          var BusquedaVIN_ApartadoTexto = null;

          function buscar_vin_apartado() {
            if (BusquedaVIN_ApartadoTexto != $("#busqueda_vin_apartado").val().trim()) {
              BusquedaVIN_ApartadoTexto = $("#busqueda_vin_apartado").val().trim();

              $('#resultadoBusquedaVin_apartado').html(`
                <div class="text-center">
                <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                </div>`);

                clearTimeout(Temporizador_VIN_Apartado);
                Temporizador_VIN_Apartado = setTimeout(function() {
                  buscar_vin_apartado_Tempo();
                }, 350);
              }
            }

            function buscar_vin_apartado_Tempo() {

              var textoBusquedaVin = $("#busqueda_vin_apartado").val().trim();

              if (textoBusquedaVin != "") {

                fetch("{{route('search_apart.vin')}}", {
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
                .catch(function(error) {
                  console.error('Error:', error)
                })
                .then(function(response) {

                  $("#resultadoBusquedaVin_apartado").html('');

                  if (response != null) {

                    response.forEach(function logArrayElements(element, index, array) {

                      $("#resultadoBusquedaVin_apartado").append(`
                        <option class="sugerencias_vin_apartado" onclick="SugerenciaVINApartado('` +
                        (element.idinventario_trucks || element.idinventario) + `','` +
                        element.marca + `','` +
                        element.version + `','` +
                        element.color + `','` +
                        element.modelo + `','` +
                        element.vin_numero_serie + `')">` +
                        element.marca + `-` + element.version + `-` +
                        element.color + `-` + element.modelo + `-` +
                        element.vin_numero_serie + `</option>`);
                      });

                      $("#vin_venta_apartado").attr("readonly", "readonly");
                      $("#marca_venta_apartado").attr("readonly", "readonly");
                      $("#version_venta_apartado").attr("readonly", "readonly");
                      $("#color_venta_apartado").attr("readonly", "readonly");
                      $("#modelo_venta_apartado").attr("readonly", "readonly");

                    } else {
                      $("#resultadoBusquedaVin_apartado").html(mensaje_vin + " <b>Pide a el Área Correspondiente que Agrege el VIN<b>");
                      $("#vin_venta_apartado").removeAttr("readonly");
                      $("#marca_venta_apartado").removeAttr("readonly");
                      $("#version_venta_apartado").removeAttr("readonly");
                      $("#color_venta_apartado").removeAttr("readonly");
                      $("#modelo_venta_apartado").removeAttr("readonly");

                      $("#vin_venta_apartado").val("");
                      $("#marca_venta_apartado").val("");
                      $("#version_venta_apartado").val("");
                      $("#color_venta_apartado").val("");
                      $("#modelo_venta_apartado").val("");
                      $("#id_inventario_apartado").val("0");
                    }

                  });


                } else {
                  $("#resultadoBusquedaVin").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
                };
              }

              function SugerenciaVINApartado(id, marca, version, color, modelo, NoSerie) {
                $("#idinventario_apartado").val(id);
                $("#marca_venta_apartado").val(marca);
                $("#version_venta_apartado").val(version);
                $("#color_venta_apartado").val(color);
                $("#modelo_venta_apartado").val(modelo);
                $("#vin_venta_apartado").val(NoSerie);
                $("#resultadoBusquedaVin_apartado").html("");
              }

              $('select#tipo_moneda_principal').on('change', function() {
                var valor = $(this).val();
                Moneda('#tipo_cambio_principal', valor);
              });

              //--------------------------------------------------------------------
              $('select#tipo_moneda1').on('change', function() {
                var valor = $(this).val();
                Moneda('#tipo_cambio2', valor);
              });

              //--------------------------------------------------------------------
              $('select#tipo_moneda_cargo').on('change', function() {
                var valor = $(this).val();
                Moneda('#tipo_cambio_cargo', valor);
              });

              function Moneda(campo, valor) {

                var cambio1 = "19.50";
                var cambio2 = "15.20";
                var cambio3 = "1";
                var nada = "0";

                if (valor == 'USD') {
                  $(campo).val(parseFloat(cambio1));
                  $(campo).prop('readonly', false);
                  //alert(cambio1);
                } else if (valor == 'CAD') {
                  $(campo).val(parseFloat(cambio2));
                  $(campo).prop('readonly', false);
                  //alert(cambio2);
                } else if (valor == 'MXN') {
                  $(campo).val(parseFloat(cambio3));
                  $(campo).prop('readonly', true);
                  //alert(cambio3);
                } else if (valor == '') {
                  $(campo).val(parseFloat(nada));
                  //alert(cambio3);
                }
              }

              //--------------------------------------------------------------------
              $("#monto_entrada").keyup(function() {
                CalcularMontoAbono();
              });
              $("#tipo_moneda1").change(function() {
                CalcularMontoAbono();
              });
              $("#tipo_cambio2").keyup(function() {
                CalcularMontoAbono();
              });


              $("#tipo_moneda_principal").change(function() {
                CalcularMontoAbonoVenta();
              });
              $("#monto_abono_venta").keyup(function() {
                CalcularMontoAbonoVenta();
              });
              $("#tipo_cambio_principal").keyup(function() {
                CalcularMontoAbonoVenta();
              });

              function CalcularMontoAbonoVenta(){

                operacion_venta=$("#efecto_venta option:selected").val();

                if (operacion_venta=="") {
                  iziToast.warning({
                    title: 'Atención',
                    message: 'Seleccione un tipo de cambio',
                    position: 'topRight'
                  });
                  $("#monto_abono_venta").val("");
                  $("#saldo_nuevo_venta").val("");
                }else{

                  saldo_pendiente_venta=$("#saldo_venta").val();
                  monto_capturado_venta=$("#monto_abono_venta").val();
                  tipo=$("#tipo_cambio_principal").val();

                  if (operacion_venta=="suma") {
                    calculo_venta=parseFloat(saldo_pendiente_venta)+ (parseFloat(monto_capturado_venta)*parseFloat(tipo));
                    $("#saldo_nuevo_venta").val(calculo_venta);
                    buscar_letras("monto_abono_venta", "tipo_moneda_principal", "letra");
                  }
                  else if (operacion_venta=="resta") {
                    calculo_venta=parseFloat(saldo_pendiente_venta) - (parseFloat(monto_capturado_venta)*parseFloat(tipo));
                    $("#saldo_nuevo_venta").val(calculo_venta);
                    buscar_letras("monto_abono_venta", "tipo_moneda_principal", "letra");
                  }

                }
              }




              function CalcularMontoAbono() {
                tipo_cambio = $("#tipo_cambio2").val();

                if (tipo_cambio == "") {
                  iziToast.warning({
                    title: 'Atención',
                    message: 'Seleccione un tipo de cambio',
                    position: 'topRight'
                  });
                } else {
                  monto_entrada = $("#monto_entrada").val();
                  monto_entrada = parseFloat(monto_entrada);
                  tipo_cambio = parseFloat(tipo_cambio);
                  total = monto_entrada * tipo_cambio;

                  $("#monto_abono").val(total);
                  CalcularSaldoNuevo();
                }

              }

              function CalcularSaldoNuevo() {

                monto_capturado = $("#monto_abono").val();
                saldo_pendiente = $("#saldo").val();
                operacion = $("#efecto option:selected").val();

                monto_genereral_cifra = $("#monto_general").val(monto_capturado);
                //monto_genereral_serie = $("#serie_general").val("1/1"); //????????????????????????????????????????
                //alert("Operacion: "+operacion+" Monto Capturado: "+monto_capturado+" Saldo pendiente: "+saldo_pendiente);
                if (operacion == "") {

                  iziToast.warning({
                    title: 'Atención',
                    message: 'No se ha definido un efecto para la operación (Positivo, Negativo), imposible hacer el cálculo',
                    position: 'topRight'
                  });

                  $("#monto_abono").val("");
                  $("#saldo_nuevo").val("");
                } else if (operacion == "suma") {
                  calculo = parseFloat(saldo_pendiente) + parseFloat(monto_capturado);
                  $("#saldo_nuevo").val(calculo);
                  buscar_letras('monto_entrada', 'tipo_moneda1', 'letra1');
                } else if (operacion == "resta") {
                  calculo = parseFloat(saldo_pendiente) - parseFloat(monto_capturado);
                  $("#saldo_nuevo").val(calculo);
                  buscar_letras('monto_entrada', 'tipo_moneda1', 'letra1');
                }


              }

              //--------------------------------------------------------------------

              function buscar_letras(inputNum, SelectTC, Destino) {

                var numero = $("#" + inputNum).val();
                var tipo_cambio = $("#" + SelectTC).val();
                var InputDestino = $('#' + Destino);

                if (numero == "") {
                  InputDestino.val('');
                } else if (tipo_cambio == "") {
                  iziToast.warning({
                    title: 'Atención',
                    message: 'Seleccione un tipo de cambio',
                    position: 'topRight'
                  });
                } else {

                  var label = InputDestino.parent().find('label');
                  label.html('Monto Letra <i class="fas fa-spinner fa-spin" style="position: initial;"></i>');

                  fetch(" {{route('number.letters.convert',['',''])}}/" + numero + "/" + tipo_cambio, {
                    headers: {
                      "Content-Type": "application/json",
                      "Accept": "application/json",
                      "X-Requested-With": "XMLHttpRequest",
                      "X-CSRF-Token": '{{csrf_token()}}',
                    },
                    method: "get",
                    credentials: "same-origin",
                  }).then(res => res.json())
                  .catch(function(error) {
                    console.error('Error:', error);
                    label.html('Monto Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
                  })
                  .then(function(response) {

                    //console.log(response);

                    if (response.info == null) {
                      iziToast.error({
                        title: 'Error',
                        message: 'Error al obtener la cantidad en letras',
                      });
                      label.html('Monto Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
                      InputDestino.val('');
                    } else {
                      InputDestino.val(response.info);
                      label.html('Monto Letra');
                    }

                  });
                }
              }


              function SoloLetras(e) {
                key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toString();
                letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
                especiales = [8, 37, 39, 46, 6];

                tecla_especial = false
                for (var i in especiales) {
                  if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                  }
                }

                if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                  //alert('Tecla no aceptada');
                  return false;
                }
              }

              //<!-----Se utiliza para que el campo de texto solo acepte numeros----->
              function SoloNumeros(evt) {
                if (window.event) { //asignamos el valor de la tecla a keynum
                  keynum = evt.keyCode; //IE
                } else {
                  keynum = evt.which; //FF
                }
                //comprobamos si se encuentra en el rango numérico
                if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47) {
                  return true;
                } else {
                  return false;
                }
              }

              function AgregarBeneficiario() {
                if ($("#agente_receptor option:selected").val() == "NEW") {
                  $("#nuevo_beneficiario").fadeIn();
                } else {
                  $("#nuevo_beneficiario").fadeOut();
                }
              }

              function ocultar_referencia(id) {

                // if (id == "Notificación Digital") {
                // 	$("#n_referencia").attr("placeholder", "No Aplica");
                // 	$("#n_referencia").prop('disabled', true);
                // } else {
                // 	$("#n_referencia").attr("placeholder", "");
                // 	$("#n_referencia").prop('disabled', false);
                // }

                if (id == "Recibo Automático") {
                  $("#comprobante_archivo").prop('disabled', true);
                } else {
                  $("#comprobante_archivo").prop('disabled', false);
                }

              }

              function buscar_referencia() {

                var institucion_receptora = $("#receptor").val();
                var agente_receptor = $("#agente_receptor").val();
                var institucion_emisor = $("#emisor").val();
                var monto_general1 = $("#monto_general").val();
                var n_referencia = $("#n_referencia").val();
                var idco = $("#co").val();
                var monto_cantidad = $("#monto_abono").val();

                var TipoMovi = $('#tipo_general').val();

                if (institucion_emisor === "") {
                  SolicitarLLenado('emisor', 'agente_receptor', 'receptor');
                } else if (institucion_receptora === "") {
                  SolicitarLLenado('receptor', 'agente_receptor', 'emisor');
                } else if (agente_receptor === "") {
                  SolicitarLLenado('agente_receptor', 'receptor', 'emisor');
                } else if (agente_receptor != "" && institucion_receptora != "") {

                  $("#agente_receptor").css("border-color", "#E7E3E2");
                  $("#receptor").css("border-color", "#E7E3E2");
                  $("#emisor").css("border-color", "#E7E3E2");

                  var institucion_emisorx = institucion_emisor.split(".")[0]; //Solo quita el punto final

                  if (n_referencia == "") {
                    $("#respuesta_referecia").html((isNaN(institucion_emisorx) ? '<i class="fas fa-times-circle" style="color: red;"></i>' : ''));
                  } else {
                    $("#respuesta_referecia").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>');
                    fetch("{{route('search.ref')}}", {
                      headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": '{{csrf_token()}}',
                      },
                      method: "post",
                      credentials: "same-origin",
                      body: JSON.stringify({
                        ins_receptora: institucion_receptora,
                        ag_receptor: agente_receptor,
                        ref: n_referencia,
                        ins_e: institucion_emisor,
                        m_g: monto_general1,
                        ic: idco,
                        cantidad: monto_cantidad,
                        tipo_mov : TipoMovi
                      })
                    }).then(res => res.json())
                    .catch(function(error) {
                      console.error('Error:', error);
                      $("#respuesta_referecia").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
                    })
                    .then(function(response) {

                      console.log(response);


                      if (response == "Abono") {
                        $("#respuesta_referecia").html('<i class="fas fa-times-circle" style="color: red;">Referencia ocupada en un abono</i>');
                        document.getElementById('n_referencia').setCustomValidity("Referencia no valida");
                      }else if (response == "Cargo") {
                        $("#respuesta_referecia").html('<i class="fas fa-check-circle" style="color:red;">Referencia ocupada en un cargo</i>');
                        document.getElementById('n_referencia').setCustomValidity("");
                      }else if (response == "Longitud") {
                        $("#respuesta_referecia").html('<i class="fas fa-times-circle" style="color: red;">Se requiere 6 caracteres</i>');
                        document.getElementById('n_referencia').setCustomValidity("Referencia no valida");
                      } else if (response == "SI") {
                        $("#respuesta_referecia").html('<i class="fas fa-check-circle" style="color:green;"></i>');
                        document.getElementById('n_referencia').setCustomValidity("");
                      }else if (response == "Multiple") {
                        $("#respuesta_referecia").html('<i class="fas fa-check-circle" style="color:#f5891a;">'+TipoMovi+' con ref en uso</i>');
                        document.getElementById('n_referencia').setCustomValidity("");
                      }else{
                        $("#respuesta_referecia").html('<i class="fas fa-times-circle" style="color: red;">'+response+'</i>');
                        document.getElementById('n_referencia').setCustomValidity("Intentelo denuevo");
                      }

                      /*if (response == "SI") {
                      $("#respuesta_referecia").html('<i class="fas fa-check-circle" style="color:green;"></i>');
                      $("#refe_val").attr("value", "SI");
                    } else {
                    $("#refe_val").attr("value", "NO");
                    $("#respuesta_referecia").html('<i class="fas fa-times-circle" style="color: red;"></i>');
                  }*/

                });
              }
            }
          }


          //--------------------------------------------------------------------
          function buscar_referencia_venta() {

            document.getElementById('n_referencia_venta').setCustomValidity("Buscando Referencia");

            var institucion_receptora = $("#receptor_venta").val();
            var agente_receptor = $("#agente_receptor_venta").val();
            var institucion_emisor = $("#emisor_venta").val();
            //var monto_general1 = $("#monto_general").val();
            var n_referencia = $("#n_referencia_venta").val();
            //var monto_cantidad = $("#monto_abono").val();

            if (institucion_emisor === "") {
              document.getElementById('n_referencia_venta').value = "";
              SolicitarLLenado('emisor_venta', 'agente_receptor_venta', 'receptor_venta');
            } else if (institucion_receptora === "") {
              document.getElementById('n_referencia_venta').value = "";
              SolicitarLLenado('receptor_venta', 'agente_receptor_venta', 'emisor_venta');
            } else if (agente_receptor === "") {
              document.getElementById('n_referencia_venta').value = "";
              SolicitarLLenado('agente_receptor_venta', 'receptor_venta', 'emisor_venta');
            } else if (agente_receptor != "" && institucion_receptora != "") {


              $("#agente_receptor_venta").css("border-color", "#E7E3E2");
              $("#receptor_venta").css("border-color", "#E7E3E2");
              $("#emisor_venta").css("border-color", "#E7E3E2");

              var institucion_emisorx = institucion_emisor.split(".")[0]; //Solo quita el punto final

              if (n_referencia == "") {

                if (isNaN(institucion_emisorx) || true ) { //isNaN ya no se ocupa
                  $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;"></i>');
                  document.getElementById('n_referencia_venta').setCustomValidity("Se requiere una referencia");
                  document.getElementById('n_referencia_venta').reportValidity();
                }

              } else {
                $("#respuesta_referecia_venta").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>');
                fetch("{{route('search.ref.venta')}}", {
                  headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": '{{csrf_token()}}',
                  },
                  method: "post",
                  credentials: "same-origin",
                  body: JSON.stringify({
                    ins_receptora: institucion_receptora,
                    ag_receptor: agente_receptor,
                    ref: n_referencia,
                    ins_e: institucion_emisor,
                  })
                }).then(res => res.json())
                .catch(function(error) {
                  console.error('Error:', error);
                  $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
                })
                .then(function(response) {

                  console.log(response);

                  if (response == "Abono") {
                    $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Referencia ocupada en un abono </i>');
                    document.getElementById('n_referencia_venta').setCustomValidity("Referencia no valida");
                  }else if (response == "Longitud") {
                    $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Se requiere 6 caracteres</i>');
                    document.getElementById('n_referencia_venta').setCustomValidity("Referencia no valida");
                  } else if (response == "SI") {
                    $("#respuesta_referecia_venta").html('<i class="fas fa-check-circle" style="color:green;"></i>');
                    document.getElementById('n_referencia_venta').setCustomValidity("");
                  } else if (response == "Cargo") {
                    $("#respuesta_referecia_venta").html('<i class="fas fa-check-circle" style="color:#f5891a;">Cargo con referencia existente </i>');
                    document.getElementById('n_referencia_venta').setCustomValidity("");
                  }else{
                    $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Intente denuevo</i>');
                    document.getElementById('n_referencia_venta').setCustomValidity("Ocurrio un error");
                  }

                });
              }
            }
          }
          //------------------------------------

          function SolicitarLLenado(campo_uno, campo_dos, campo_tres) {

            $("#" + campo_uno).focus();
            $("#" + campo_uno).css("border-color", "red");
            $("#" + campo_dos).css("border-color", "#E7E3E2");
            $("#" + campo_tres).css("border-color", "#E7E3E2");

            iziToast.warning({
              title: 'Atención',
              message: 'Llena el campo indicado',
              position: 'topLeft'
            });

            document.getElementById(campo_uno).reportValidity();
          }

          $('#cobranza').submit(function(e) {
            $('#Myloader').fadeIn();
          });


          $('#venta').submit(function(e) {
            if ($("#fechapago_venta1").val() ==="") {
              iziToast.warning({
                title: 'Atención',
                message: 'Debes de Agregar la Fecha',
                position: 'topRight'
              });
              $("#fechapago_venta1").focus();
              event.preventDefault();
            }else{
              $('#Myloader').fadeIn();
            }
          });


          function buscar_marca(){
            var textoBusquedaMarca = $("#marca_venta").val();
            if (textoBusquedaMarca != "") {

              $("#resultadoMarca").html(`
                <div class="d-flex justify-content-center">
                <div class="spinner-grow text-info" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                </div>
                `);

                fetch("{{route('search.marca')}}", {
                  headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": '{{csrf_token()}}',
                  },
                  method: "post",
                  credentials: "same-origin",
                  body: JSON.stringify({
                    marca : textoBusquedaMarca
                  })
                }).then(res => res.json())
                .catch(function(error){
                  console.error('Error:', error);
                  $("#resultadoMarca").html('<p style="color:red">Error</p>');
                })
                .then(function(response){

                  if (response == null) {
                    $("#resultadoMarca").html('<b>Marca no Encontrada</b>');
                    $("#marca_venta").css("border-color","#A0213C");
                  }else{
                    $("#resultadoMarca").html('');
                    response.forEach(function logArrayElements(element, index, array) {
                      $("#resultadoMarca").append(`<option class='sugerencias_marca' value='`+element.marca+`'>`+element.marca+`</option>`);
                    });

                    $('.sugerencias_marca').click( function () {
                      aux_recibido=$(this).val();
                      var porcion = aux_recibido.split(';');
                      unidad_marca=porcion[0];
                      $("#marca_venta").val(unidad_marca).css("border-color","#e7eaec");
                      $("#resultadoMarca").html("");
                    });

                  }

                });

              }else {
                $("#resultadoMarca").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
                $("#marca_venta").css("border-color","#A0213C");
              };
            }

            function buscar_modelo(){
              var textoBusquedaModelo = $("#modelo_venta").val();
              if (textoBusquedaModelo != "") {

                $("#resultadoModelo").html(`
                  <div class="d-flex justify-content-center">
                  <div class="spinner-grow text-info" role="status">
                  <span class="sr-only">Loading...</span>
                  </div>
                  </div>
                  `);

                  fetch("{{route('search.modelo')}}", {
                    headers: {
                      "Content-Type": "application/json",
                      "Accept": "application/json",
                      "X-Requested-With": "XMLHttpRequest",
                      "X-CSRF-Token": '{{csrf_token()}}',
                    },
                    method: "post",
                    credentials: "same-origin",
                    body: JSON.stringify({
                      modelo : textoBusquedaModelo
                    })
                  }).then(res => res.json())
                  .catch(function(error){
                    console.error('Error:', error);
                    $("#resultadoModelo").html('<p style="color:red">Error</p>');
                  })
                  .then(function(response){
                    console.log(response);
                    if (response == null) {
                      $("#resultadoModelo").html('<b>Modelo no encontrado</b>');
                      $("#modelo_venta").css("border-color","#A0213C");
                    }else{
                      $("#resultadoModelo").html('');
                      response.forEach(function logArrayElements(element, index, array) {
                        $("#resultadoModelo").append(`<option class='sugerencias_modelo' value='`+element.modelo+`'>`+element.modelo+`</option>`);
                      });
                      $('.sugerencias_modelo').click(function () {
                        aux_recibido=$(this).val();
                        var porcion = aux_recibido.split(';');
                        unidad_modelo=porcion[0];
                        $("#modelo_venta").val(unidad_modelo).css("border-color","#e7eaec");
                        $("#resultadoModelo").html("");
                      });
                    }
                  });

                } else {
                  $("#resultadoModelo").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
                  $("#modelo_venta").css("border-color","#A0213C");
                };
              }

              function buscar_color(){
                var textoBusquedaColor = $("#color_venta").val();
                if (textoBusquedaColor != "") {

                  $("#resultadoColor").html(`
                    <div class="d-flex justify-content-center">
                    <div class="spinner-grow text-info" role="status">
                    <span class="sr-only">Loading...</span>
                    </div>
                    </div>
                    `);

                    fetch("{{route('search.color')}}", {
                      headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": '{{csrf_token()}}',
                      },
                      method: "post",
                      credentials: "same-origin",
                      body: JSON.stringify({
                        color : textoBusquedaColor
                      })
                    }).then(res => res.json())
                    .catch(function(error){
                      console.error('Error:', error);
                      $("#resultadoColor").html('<p style="color:red">Error</p>');
                    })
                    .then(function(response){
                      console.log(response);
                      if (response == null) {
                        $("#resultadoColor").html('<b>Color no encontrado</b>');
                        $("#color_venta").css("border-color","#A0213C");
                      }else{
                        $("#resultadoColor").html('');
                        response.forEach(function logArrayElements(element, index, array) {
                          $("#resultadoColor").append(`<option class='sugerencias_color' value='`+element.color+`'>`+element.color+`</option>`);
                        });
                        $('.sugerencias_color').click(function () {
                          aux_recibido=$(this).val();
                          var porcion = aux_recibido.split(';');
                          unidad_version=porcion[0];
                          $("#color_venta").val(unidad_version).css("border-color","#e7eaec");
                          $("#resultadoColor").html("");
                        });
                      }
                    });


                  } else {
                    $("#resultadoColor").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
                    $("#color_venta").css("border-color","#A0213C");
                  };
                }

                function buscar_version(){
                  var textoBusquedaVersion = $("#version_venta").val();
                  if (textoBusquedaVersion != "") {

                    $("#resultadoVersion").html(`
                      <div class="d-flex justify-content-center">
                      <div class="spinner-grow text-info" role="status">
                      <span class="sr-only">Loading...</span>
                      </div>
                      </div>
                      `);

                      fetch("{{route('search.version')}}", {
                        headers: {
                          "Content-Type": "application/json",
                          "Accept": "application/json",
                          "X-Requested-With": "XMLHttpRequest",
                          "X-CSRF-Token": '{{csrf_token()}}',
                        },
                        method: "post",
                        credentials: "same-origin",
                        body: JSON.stringify({
                          version : textoBusquedaVersion
                        })
                      }).then(res => res.json())
                      .catch(function(error){
                        console.error('Error:', error);
                        $("#resultadoVersion").html('<p style="color:red">Error</p>');
                      })
                      .then(function(response){
                        console.log(response);
                        if (response == null) {
                          $("#resultadoVersion").html('<b>Version no encontrada</b>');
                          $("#version_venta").css("border-color","#A0213C");
                        }else{
                          $("#resultadoVersion").html('');
                          response.forEach(function logArrayElements(element, index, array) {
                            $("#resultadoVersion").append(`<option class='sugerencias_version' value='`+element.version+`'>`+element.version+`</option>`);
                          });
                          $('.sugerencias_version').click(function () {
                            aux_recibido=$(this).val();
                            var porcion = aux_recibido.split(';');
                            unidad_version=porcion[0];
                            $("#version_venta").val(unidad_version).css("border-color","#e7eaec");
                            $("#resultadoVersion").html("");
                          });
                        }
                      });


                    } else {
                      $("#resultadoVersion").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
                      $("#version_venta").css("border-color","#A0213C");
                    };
                  }

                  $( "#vin_venta" ).keyup(function() {
                    //alert( "Handler for .keyup() called." );
                    var vin = $(this).val();
                    this.value = this.value.toUpperCase();
                    //alert(vin);
                    if (vin.length < 8 ) {
                      $('#validaVin').html('<strong class="text-danger">El campo no sebe ser menor que 8</strong>');
                      return false;
                    }else if(vin.length > 17){
                      $('#validaVin').html('<strong>El campo no sebe ser menor que 17</strong>');
                      return false;
                    }else if(vin.length < 0){
                      $('#validaVin').html('');
                      return false;
                    }

                    else {
                      $('#validaVin').html('');
                    }
                  });

                  </script>

                @endsection
