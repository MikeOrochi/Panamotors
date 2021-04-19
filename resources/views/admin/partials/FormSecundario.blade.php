<style media="screen">
.redondo{
  border:0px;
  border-radius: 50%;
  background-color: white;
}
.redondo:hover {
  animation: fa-spin 2s infinite linear;
  border:0px;
  color: rgba(4, 82, 141, 1) !important;
  background-color: white;
  /* box-shadoxw: 0 4px 16px rgba(0, 0, 0, 1); */
  transition: all 0.2s ease;
  transform: rotate(-360deg);
  -webkit-transform: rotate(-360deg); // IE 9
  -moz-transform: rotate(-360deg); // Firefox
  -o-transform: rotate(-360deg); // Safari and Chrome
  -ms-transform: rotate(-360deg); // Opera
}
</style>
<div id="secundario" style="display: none;">
  {{-- <p>SaveMovementController - Form Secundario</p> --}}
  <form id="cobranza" name="cobranza" enctype="multipart/form-data" method="post" action="{{route('movement.store')}}" class="needs-validation confirmation">
    @csrf
    <div id="extra"><input type="hidden" name="muestra" id="muestra1"></div>
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-danger" role="alert" align='center' id='no_disponse_bougths' style="display: none;">
          No hay compras disponibles a las cuales abonar.
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label>Compra a la que deseas abonar</label>
          <select class="form-control" id="movimiento_general" name="movimiento_general" required="" value="" onchange="getAbonosPendientesMxn()">
            @foreach ($compras_pendientes as $compra_pendiente)
              <option value="{{$compra_pendiente->idestado_cuenta_proveedores}}">{{$compra_pendiente->idestado_cuenta_proveedores}}-{{$compra_pendiente->referencia}}-{{$compra_pendiente->datos_marca}}-{{$compra_pendiente->datos_version}}-{{$compra_pendiente->datos_vin}}</option>
            @endforeach
          </select>

        </div>
      </div>
      <div class="col-sm-4" id='type_movment_select'>
        <div class="form-group">
          <label>Tipo</label>
          <select class="form-control" id="tipo_general" name="tipo_general" required="" value="{{old('tipo_general')}}"  onkeyup="buscar_referencia_venta();" maxlength="20">
            <option value="abono" selected>Abono</option>
            <option value="cargo">Cargo</option>
          </select>
        </div>
      </div>
      <div class="col-sm-4" style="display:none;">
        <div class="form-group">
          <label>Efecto</label>
          <input class="form-control" type="hidden" id="efecto" name="efecto" value="resta" readonly="" required="">
          <input class="form-control" type="text" id="" name="" value="Negativo" readonly="" required="">

          {{-- <select class="form-control" id="efecto" name="efecto" required="" value="{{old('efecto')}}">

          <option value="resta">Negativo</option>
        </select> --}}
      </div>
    </div>
    <!--******************************************************************************************************************************************************************************-->

    {{-- </div> --}}
    <!--******************************************************************************************************************************************************************************-->
    {{-- <div class="row"> --}}

    <!--******************************************************************************************************************************************************************************-->

    <!--******************************************************************************************************************************************************************************-->

    {{-- </div> --}}
    <!--******************************************************************************************************************************************************************************-->
    {{-- <div class="row"> --}}
    <div class="col-sm-4">
      <div class="form-group">
        <label>Saldo proveedor</label>
        {{-- <input class="form-control" type="text" id="saldo" name="saldo" value="{{$compra_pendiente[0]->datos_precio}}" readonly="" required=""> --}}
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
          </div>
          <input class="form-control" type="text" id="saldo_prov" name="saldo_prov" value="{{$saldo_anterior}}" readonly="" required="">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Saldo compra</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
          </div>
          <input class="form-control" type="text" id="saldo" name="saldo" value="" readonly="" required="" onload="buscar_referencia()">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
          </div>
          {{-- <input class="form-control" type="text" id="saldo" name="saldo" value="{{$compras_pendientes[0]->datos_precio}}" readonly="" required=""> --}}
          {{-- <input class="form-control" type="text" id="saldo" name="saldo" value="{{$saldo_anterior}}" readonly="" required=""> --}}
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Saldo pagare</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
          </div>
          <input class="form-control" type="text" id="pagare" name="pagare" value="" readonly="" required="">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
          </div>
          {{-- <input class="form-control" type="text" id="saldo" name="saldo" value="{{$compras_pendientes[0]->datos_precio}}" readonly="" required=""> --}}
          {{-- <input class="form-control" type="text" id="saldo" name="saldo" value="{{$saldo_anterior}}" readonly="" required=""> --}}
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>No. Pagare</label>
        <input class="form-control" type="text" id="no_pagare" name="no_pagare" value="" readonly="" required="">
        {{-- <input class="form-control" type="text" id="saldo" name="saldo" value="{{$compras_pendientes[0]->datos_precio}}" readonly="" required=""> --}}
        {{-- <input class="form-control" type="text" id="saldo" name="saldo" value="{{$saldo_anterior}}" readonly="" required=""> --}}
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Cantidad</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
          </div>
          <input class="form-control" type="text" id="monto_abono" name="monto_abono" required="" readonly="" value="{{old('monto_abono')}}">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Nuevo Saldo</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
          </div>
          <input class="form-control" type="text" id="saldo_nuevo" name="saldo_nuevo" readonly="" required="" value="{{old('saldo_nuevo')}}">
          <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
          </div>
        </div>
      </div>
    </div>
    {{-- </div>
    <div class="row"> --}}
    <div class="col-lg-4" style="display:none;">
      <div class="form-group">
        <label>Tipo de Moneda</label>
        <input class='form-control' type="text" name="tipo_moneda1" id='tipo_moneda1' value="{{$Proveedor->col2}}" readonly>
        {{-- <select class="form-control" id="tipo_moneda1" name="tipo_moneda1" required=""> --}}
        {{-- <option value="">Elige una opción…</option> --}}
        {{-- @foreach (["USD","CAD","MXN"] as $key => $value)
        <option value="{{$value}}"
        @if ($value == old('tipo_moneda_principal') || $value == $Proveedor->col2)
        selected
      @endif --}}
      {{-- >{{$value}}</option> --}}
      {{-- @endforeach --}}
      {{-- @foreach (["USD","CAD","MXN"] as $key => $value)
      <option value="{{$value}}"
      @if ($value == old('tipo_moneda1'))
      selected
    @endif
    >{{$value}}</option>
  @endforeach --}}
</select>
</div>
</div>
<div class="col-lg-4" style="display: none;">
  <div class="form-group">
    <label>Tipo de Cambio</label>
    <input class="form-control" type="text" id="tipo_cambio2" name="tipo_cambio2" required="" onkeypress="return SoloNumeros(event);" value='1'>
  </div>
</div>
<div class="col-lg-4">
  <div class="form-group">
    <label>Monto</label>
    <div class="input-group mb-2">
      <div class="input-group-prepend">
        <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
      </div>
      <input class="form-control" type="text" id="monto_entrada" name="monto_entrada" required="" onkeypress="return SoloNumeros(event);" value="{{old('monto_entrada')}}" minlength='1'>
      <div class="input-group-prepend">
        <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
      </div>
    </div>
    <input type="hidden" class="form-control" id='resto_deuda_temp' value="0">
  </div>
</div>
<div class="col-sm-4" @if($saldo_compras<1) style="display: none;" @endif>
  <div class="form-group">
    <br>
    <button type="button" id='saldo_sobrante' class="btn btn-success" onclick="MostrarSaldoSobrante(this)" style="padding-top: 0px;padding-bottom: 0px;margin-left: 0px;"><i class="fas fa-plus"></i>&nbsp;$ Abonar saldos sobrantes</button>
    <input type="hidden" id='validar_abono_sobrante' name="validar_abono_sobrante" value="0" autocomplete="off" readonly>
  </div>
</div>
<div class="col-sm-4" style="display: none;" id='div_saldos_sobrantes1'>
  <div class="form-group">
    <label>Saldo de abonos:</label>
    <input class="form-control" type="text" id="input_saldo_sobrante1" name="input_saldo_sobrante1" value="{{$saldo_compras}}" autocomplete="off" onkeypress="return SoloNumeros(event);" readonly>
  </div>
</div>
<div class="col-sm-6" style="display: none;">
  <div class="form-group">
    <label>Monto General</label>
    <input class="form-control" type="text" id="monto_general" name="monto_general" onkeypress="return SoloNumeros(event);" required="" value="{{old('monto_general')}}">
  </div>
</div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="form-group">
      <label>Monto letra</label>
      <input type="text" class="form-control" id="letra1" name="letra" required="" readonly="" value="{{old('letra')}}">
      <input placeholder="Buscar" class="form-control" type="hidden" name="busqueda_vin_apartado" id="busqueda_vin_apartado"  maxlength="25" autocomplete="off" size="19" width="300%" value="">

    </div>
  </div>
</div>
<!--******************************************************************************************************************************************************************************-->

<div style="display: block;" id="vin_apartado">
  {{-- <div style="display: block;" > --}}
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label>Buscar VIN</label>
        <input placeholder="Buscar" class="form-control" type="text" name="busqueda_vin_apartado" id="busqueda_vin_apartado"  maxlength="25" autocomplete="off" onkeyup="buscar_vin_apartado();" size="19" width="300%" value="{{old('busqueda_vin_apartado')}}">
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
        <input class="form-control" type="text" id="marca_venta_apartado" name="marca_venta_apartado" value="{{old('marca_venta_apartado')}}">
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Modelo</label>
        <input class="form-control" type="text" id="modelo_venta_apartado" name="modelo_venta_apartado" value="{{old('modelo_venta_apartado')}}">
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Color</label>
        <input class="form-control" type="text" id="color_venta_apartado" name="color_venta_apartado" value="{{old('color_venta_apartado')}}">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label>Versión</label>
        <input class="form-control" type="text" id="version_venta_apartado" name="version_venta_apartado" value="{{old('version_venta_apartado')}}">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label>VIN</label>
        <input class="form-control" type="text" id="vin_venta_apartado" name="vin_venta_apartado" minlength="8" maxlength="17" value="{{old('vin_venta_apartado')}}">
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
<div class="row" style="display: none;">
  <div class="col-sm-6">
    <div class="form-group">
      <label>Institución Emisora</label>
      <input class="form-control" type="text" name="emisor" id='emisor' value="{{$BancosEmisores[0]->nombre}}" readonly>
      {{-- <select class="form-control" id="emisor" name="emisor" required=""> --}}
      {{-- @foreach ($BancosEmisores as $key => $BE) --}}
      {{-- <option value="{{$BancosEmisores[0]->nombre}}"
      @if ($BancosEmisores[0]->nombre == old('receptor_venta'))
      selected
    @endif
    >{{$BancosEmisores[0]->nombre}}</option> --}}
    {{-- @endforeach --}}

    {{-- </select> --}}
  </div>
</div>
<div class="col-sm-6">
  <div class="form-group">
    <label>Agente Emisor</label>
    @foreach ($CatalogoTesorerias as $key => $CT)
      @if ($CT->nombre=='Inventario')
        @php
        $nomenclatur_a_receptor = $CT->nomeclatura;
        $nombre_a_receptor = $CT->nomeclatura.' '.$CT->nombre;
        @endphp
      @endif
    @endforeach
    <input type="text" class='form-control' name="agente_emisor" id='agente_emisor' value="TP1" readonly>
    {{-- <input type="text" class='form-control' value="TP1" readonly> --}}

  </div>
</div>
</div>
<div class="row" style="display: none;">
  <div class="col-sm-6">
    <div class="form-group">
      <label>Institución Receptora</label>
      <input class="form-control" type="text" id="receptor" name="receptor" value="{{$idconta.'.'.$iniciales_cliente}}" readonly="" required="">
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label>Agente Receptor</label>
      <input class="form-control" type="text" id="agente_receptor" name="agente_receptor" value="{{$idconta.'.'.$iniciales_cliente}}" readonly="" required="">
    </div>
  </div>
</div>
<!--*********************************************************************************************************************************************************************************************-->
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
      <label>Método de pago</label>

      <select class="form-control" id="m_pago" name="m_pago" required="" onchange="changeComprobante();">
        <option value="" disabled>Elige una opción…</option>
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
    <div class="col-sm-4">
      <div class="form-group">
        <label>Tipo de comprobante</label>
        {{-- <input type="text" class="form-control" id='temp_comprobante' value="Recibo" readonly> --}}
        <select class="form-control" id="comprobante" name="comprobante" onchange="ocultar_referencia(this.value);" required="">
          <option value="" disabled>Elige una opción</option>
          <option value="Recibo">Recibo</option>
          <option value="Recibo Automático">Recibo Automático</option>
          <option value="Notificación digital">Notificación digital</option>
          {{-- @foreach ($CatalogoComprobante as $key => $CC)
          @if ($CC->nombre=='Contrato de Compra' || $CC->nombre=='Notificación Digital' || $CC->nombre=='Factura')
          <option value="{{$CC->nombre}}"
          @if ($CC->nombre == old('tipo_comprobante_compra'))
          selected
        @endif
        >{{$CC->nombre}}</option>
      @endif
    @endforeach --}}
  </select>
</div>
</div>
<div class="col-sm-4">
  <div class="form-group">
    <label>Número de referencia</label>
    <i id='i_abono' class="fa fa-refresh btn redondo" style="color: #04058D;" onclick="getAbonosPendientesMxn();" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar nueva referencia aleatoria"></i>
    <i id='i_otros' class="fa fa-refresh btn redondo" style="color: #04058D; display:none;" onclick="referenceOtrosAbonos();" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Generar nueva referencia aleatoria"></i>
    {{-- <label>Número de Referencia</label> <a class='btn redondo' style="color: #04058D;" onclick="getAbonosPendientesMxn();"><i class="fa fa-refresh" aria-hidden="true"></i></a> --}}
    <input class="form-control" type="text" id="n_referencia" name="n_referencia" minlength="6" required="" onkeyup="buscar_referencia();" value="{{old('n_referencia')}}">
    <label id="respuesta_referecia"></label>
  </div>
</div>
<div class="col-sm-4">
  <div class="form-group">
    <label>Fecha </label>
    <input class="form-control" type="date" id="fechapago1" name="fechapago1" required="" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" min="{{\Carbon\Carbon::yesterday()->format('Y-m-d')}}" max="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
  </div>
</div>
<div class="col-sm-4">
  <div class="form-group">
    <label>Evidencia:</label>
    <input type="file" placeholder="Evidencia de Comprobante" name="uploadedfile" id="comprobante_archivo" class="form-control" required=""  accept=".jpg, .jpeg, .png, .pdf">
  </div>
</div>
{{-- <div class="col-sm-4">
<div class="form-group">
<label>Numero de Actividad</label>
<input class="form-control" type="text" id="n_referencia_actividad" name="n_referencia_actividad" required="" onkeyup="" autocomplete="off" value="{{old('n_referencia_actividad')}}">
</div>
</div> --}}
</div>
<!--*****************************************************************************************************************************************************************************************-->
<div class="row">
  <div class="col-sm-12">
    <div class="form-group">
      <label>Comentarios:</label>
      <textarea class="form-control" rows="2" id="descripcion" name="descripcion" maxlength="8950" required="">{{old('descripcion')}}</textarea>
    </div>
  </div>
</div>
<!--*****************************************************************************************************************************************************************************************-->
<div class="hr-line-dashed"></div>
<input type="hidden" name="contacto_original" value="{{$idconta}}">
<input type="hidden" id='coordenadas' name="coordenadas" value="">
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
<script type="text/javascript">


function updateSaldosRestantes(){
  let saldo = document.getElementById('saldo').value;
  if (saldo=='') {
    $('#saldo_sobrante').find('i').removeClass("fa-minus");
    $('#saldo_sobrante').find('i').addClass("fa-plus");
    $('#saldo_sobrante').removeClass("btn-danger");
    $('#saldo_sobrante').addClass("btn-success");
    $('#div_saldos_sobrantes1').removeClass('fadeInDown_izi');
    $('#div_saldos_sobrantes1').addClass('fadeOutLeft');
    $('#div_saldos_sobrantes1').fadeOut('slow');
    swal ( "Debes hacer una compra para hacer uso de esta opcion" ,  "" ,  "error" )
  }
  $('#monto_entrada').attr('readonly',true);
  let input_saldo_sobrante1 = document.getElementById('input_saldo_sobrante1').value;
  if (parseFloat(input_saldo_sobrante1)>parseFloat(saldo)) {
    document.getElementById('monto_entrada').value=saldo;
    console.log('Saldo'+saldo);
  }else {
    document.getElementById('monto_entrada').value=input_saldo_sobrante1;
    console.log('Sobrante'+input_saldo_sobrante1);
  }
}
function MostrarSaldoSobrante(boton){
  if($(boton).find('i').hasClass("fa-plus")){
    $(boton).find('i').removeClass("fa-plus");
    $(boton).find('i').addClass("fa-minus");
    $(boton).removeClass("btn-success");
    $(boton).addClass("btn-danger");

    $('#div_saldos_sobrantes1').removeClass('fadeOutLeft');
    $('#div_saldos_sobrantes1').addClass('fadeInDown_izi');
    $('#div_saldos_sobrantes1').fadeIn('slow');
    updateSaldosRestantes();
    CalcularMontoAbono();
    document.getElementById('validar_abono_sobrante').value=1;

    // $('#div_compra_restante').removeClass('fadeOutLeft');
    // $('#div_compra_restante').addClass('fadeInDown_izi');
    // $('#div_compra_restante').fadeIn('slow');

    // $('#monto_abono_venta').attr('readonly',true);
    // updateSaldosRestantes();
    // document.getElementById('temporal_saldo').value=monto_abono_venta;
    // updateCompra();
    // $('#Anticipo :required').prop('disabled',false);
  }else{
    $(boton).find('i').removeClass("fa-minus");
    $(boton).find('i').addClass("fa-plus");
    $(boton).removeClass("btn-danger");
    $(boton).addClass("btn-success");
    $('#div_saldos_sobrantes1').removeClass('fadeInDown_izi');
    $('#div_saldos_sobrantes1').addClass('fadeOutLeft');
    $('#div_saldos_sobrantes1').fadeOut('slow');
    document.getElementById('monto_entrada').value=document.getElementById('pagare').value;
    $('#monto_entrada').attr('readonly',false);
    document.getElementById('validar_abono_sobrante').value=0;
    CalcularMontoAbono();
  }
}
getAbonosPendientesMxn();
// console.log('xD');
//document.getElementById("muestra").addEventListener("onchange", checkConcept);
// document.addEventListener("DOMContentLoaded", function(event) {
//   document.getElementById('muestra').addEventListener('onchange',
//   checkConcept)
// });
// $('#muestra').change(function(){
// 	console.log($(this).val());
// });
function checkConcept(){
  // 	var conceppto_select = document.getElementById("muestra");
  // 	console.log(conceppto_select);
  // console.log('xD');
}
// CalcularMontoAbono();
function getAbonosPendientesMxn(){
  var idestado_cuenta_proveedores_select = document.getElementById("movimiento_general");
  var idestado_cuenta_proveedores = idestado_cuenta_proveedores_select.options[idestado_cuenta_proveedores_select.selectedIndex].value;
  // console.log(idestado_cuenta_proveedores);
  fetch("{{route('state_providers.saldo.getSaldo')}}", {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-Token": '{{csrf_token()}}',
    },
    method: "post",
    credentials: "same-origin",
    body: JSON.stringify({
      id_estado_cuenta_proveedores: idestado_cuenta_proveedores,
    })
  }).then(res => res.json())
  .catch(function(error) {
    console.error('Error:', error);
    $('#no_disponse_bougths').fadeIn();
    //
    // document.getElementById('label_reference').innerHTML = 'Número de referencia: <i class="fas fa-times-circle" style="color: red;">';
    // // reference_ok = false;
  })
  .then(function(response) {
    // console.log(response);
    $('#no_disponse_bougths').fadeOut();
    // console.log(response);
    tipo_cambio = document.getElementsByName("tipo_cambio2")[0].value;

    console.log(response);
    document.getElementById("monto_entrada").value = (parseFloat((response.monto_restante)/tipo_cambio)).toFixed(2);
    document.getElementById("resto_deuda_temp").value = (parseFloat((response.monto_restante)/tipo_cambio)).toFixed(2);
    document.getElementById("saldo").value = (parseFloat(response.deuda_unidad)).toFixed(2);
    document.getElementById("busqueda_vin_apartado").value = response.vin;
    document.getElementById("pagare").value = (parseFloat(response.monto_restante)).toFixed(2);
    document.getElementById("no_pagare").value = response.no_pagare;
    document.getElementById("marca_venta_apartado").value = response.estado_cuenta_proveedor.datos_marca;
    document.getElementById("modelo_venta_apartado").value = response.estado_cuenta_proveedor.datos_modelo;
    document.getElementById("color_venta_apartado").value = response.estado_cuenta_proveedor.datos_color;
    document.getElementById("version_venta_apartado").value = response.estado_cuenta_proveedor.datos_version;
    document.getElementById("vin_venta_apartado").value = response.estado_cuenta_proveedor.datos_vin;
    let reference = generateReference(response.vin);
    BuscarVIN(reference,2);
    // console.log(reference);
    CalcularMontoAbono();
  });
}
function generateReference(datos_vin){
  if (datos_vin==='no_ok') {
    datos_vin = '{{\Carbon\Carbon::now()->format('Ymd')}}'+makeid(8);
  }
  var receptor = document.getElementsByName("receptor")[0].value;
  function makeid(length) {
    var result           = '';
    var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
  }
  return receptor+'_'+datos_vin+'_'+makeid(2);
  // console.log();
}
function referenceOtrosAbonos(){
  let reference = generateReference('no_ok');
  BuscarVIN(reference,2);
}
function verifyLimitSaldo(){
  let saldo = parseFloat(document.getElementById('saldo').value);
  let monto_abono = parseFloat(document.getElementById('monto_abono').value);
  let pagare = parseFloat(document.getElementById('pagare').value);
  // console.log(saldo);
  // console.log(monto_abono);
  var tipo_general_select = document.getElementById("tipo_general");
  var tipo_general = tipo_general_select.options[tipo_general_select.selectedIndex].value;
  if (monto_abono>saldo && tipo_general=='abono') {
    resto_deuda_temp
    if (pagare > saldo) {
      // document.getElementById("monto_entrada").value = (saldo);
      // document.getElementById("pagare").value = (saldo);
      // document.getElementById("monto_entrada").value = (resto_deuda_temp);
      // CalcularMontoAbono();
      // swal("Monto incorrecto", "No puedes abonar mas que el valor de la deuda", "error");
      // break;
    }else {
      // resto_deuda_temp = document.getElementById('resto_deuda_temp').value;
      // document.getElementById("monto_entrada").value = (resto_deuda_temp);
      // CalcularMontoAbono();
      // swal("Monto incorrecto", "No puedes abonar mas que el valor de la deuda", "error");
      // console.log('cancelar compra');
    }
    // break;
  }else {
    console.log('continuar');
  }
}
var valor = document.getElementById("tipo_general").value;
function resetear() {
  document.getElementById("tipo_general").value = valor;
}
setLocation();
function setLocation(){
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPositions);
    // console.log('=>'+showPositions);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}
function showPositions() {



  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(objPosition) {
      var longitud = objPosition.coords.longitude;
      var latitud = objPosition.coords.latitude;
      var Coordenadas = latitud + ", " + longitud;
      // return Coordenadas;
      console.log('Aqui => '+Coordenadas);
      document.getElementById('coordenadas').value = Coordenadas;
      document.getElementById('coordenadas_main').value = Coordenadas;
      //document.getElementById("lat_long").value = Coordenadas;

      // content.innerHTML = "<p><strong>Latitud:</strong> " + latitud + "</p><p><strong>Longitud:</strong> " + latitud + "</p>";

      var x = latitud + ", " + longitud;
      parametros = {
        "x": x
      };
      /*
      $.ajax({
      data: parametros,
      url: 'guardar_inicio_sesion.php',
      type: 'post',
      success: function(mensaje) {
      response = $.trim(mensaje);

    }
  });*/

}, function(objPositionError) {
  switch (objPositionError.code) {
    case objPositionError.PERMISSION_DENIED:
    //content.innerHTML = "No se ha permitido el acceso a la posición del usuario.";
    break;
    case objPositionError.POSITION_UNAVAILABLE:
    //content.innerHTML = "No se ha podido acceder a la información de su posición.";
    break;
    case objPositionError.TIMEOUT:
    //content.innerHTML = "El servicio ha tardado demasiado tiempo en responder.";
    break;
    default:
    //content.innerHTML = "Error desconocido.";
  }
}, {
  maximumAge: 75000,
  timeout: 15000
});
} else {
  content.innerHTML = "Su navegador no soporta la API de geolocalización.";
}
}
function changeComprobante(){
  var m_pagos_select = document.getElementById("m_pago");
  var m_pago = m_pagos_select.options[m_pagos_select.selectedIndex].value;
  if (m_pago==3) {
    console.log('Panamotors');
    $('#comprobante').empty();
    // $('#comprobante').show();
    // $('#temp_comprobante').hide();

    document.getElementById("comprobante").innerHTML += "<option disabled>"+"Selecciona una opción"+"</option>";
    document.getElementById("comprobante").innerHTML += "<option value='Boucher'>"+"Boucher"+"</option>";
    // document.getElementById("comprobante").innerHTML += "<option value='Notificación digital'>"+"Notificación digital"+"</option>";
    document.getElementById("agente_emisor").value = "B2";
    // document.getElementById("comprobante").style.cssText = 'webkit-appearance: auto;-moz-appearance: auto;appearance: auto;';
    // $('#comprobante').removeClass('readonly');
  }else if (m_pago==1) {
    // document.getElementById("comprobante").style.cssText = 'webkit-appearance: none;-moz-appearance: none;appearance: none;';
    // $('#comprobante').addClass('readonly');
    document.getElementById("agente_emisor").value = "TP1";
    $('#comprobante').empty();
    // $('#temp_comprobante').show();
    // $('#comprobante').hide();
    document.getElementById("comprobante").innerHTML += "<option disabled>"+"Selecciona una opción"+"</option>";
    document.getElementById("comprobante").innerHTML += "<option value='Recibo'>"+"Recibo"+"</option>";
    document.getElementById("comprobante").innerHTML += "<option value='Recibo Automático'>"+"Recibo Automático"+"</option>";
    document.getElementById("comprobante").innerHTML += "<option value='Notificación digital'>"+"Notificación digital"+"</option>";
    document.getElementById("temp_comprobante").value = "Recibo";agente_emisor
  }
}
</script>
