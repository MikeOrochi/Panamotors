<div id="principal" style="display: none;">
  {{-- <p>CompraVentaController - Form Principal</p> --}}
  <form id="venta" name="venta" enctype="multipart/form-data" method="post" action="{{route('compraventa.store')}}" class="needs-validation confirmation">
    @csrf
    <div class="row OcultarRow">
      <div class="col-sm-4">
        <div class="form-group">
          <label>Tipo</label>

          <select class="form-control" id="tipo_general_venta" name="tipo_general_venta" required="">
            <option value="cargo">Cargo</option>
            <!--
            <option value="">Elige una opción…</option>
            <option value="abono">Abono</option>-->
          </select>

        </div>
      </div>

      <div class="col-sm-4">
        <div class="form-group">
          <label>Efecto</label>

          <select class="form-control" id="efecto_venta" name="efecto_venta" required="">
            <option value="suma">Positivo</option>
            <!---
            <option value="">Elige una opción…</option>
            <option value="resta">Negativo</option>-->
          </select>

        </div>
      </div>

      <div class="col-sm-4">
      </div>
    </div>

    <!--******************************************************************************************************************************************************************************-->
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <label>Saldo</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
            </div>
            <input class="form-control" type="text" id="saldo_venta" name="saldo_venta" value="{{$saldo_anterior}}" readonly="" required="">
            <div class="input-group-prepend">
              <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Precio</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
            </div>
            <input class="form-control" type="text" id="monto_abono_venta" name="monto_abono_venta" value="{{old('monto_abono_venta')}}" autocomplete="off"  onkeypress="return SoloNumeros(event);" required="" maxlength="9">
            <div class="input-group-prepend">
              <select class="input-group-text readonly" id="tipo_moneda_principal" name="tipo_moneda_principal" required="" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px;width: 85px;webkit-appearance: none;-moz-appearance: none;appearance: none;border: none;">
                @foreach (["USD","CAD","MXN"] as $key => $value)
                  <option value="{{$value}}"
                  @if ($value == old('tipo_moneda_principal') || $value == $Proveedor->col2)
                    selected
                  @endif
                  >{{$value}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" value="{{$idconta}}" id="co">
      <div class="col-sm-4">
        <div class="form-group">
          <label>Nuevo saldo</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
            </div>
            <input class="form-control" type="text" id="saldo_nuevo_venta" name="saldo_nuevo_venta" readonly="" required="" value="{{old('saldo_nuevo_venta')}}">
            <div class="input-group-prepend">
              <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px">{{$Proveedor->col2}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--******************************************************************************************************************************************************************************-->
    <div class="row">
      <div class="col-sm-8">
        <div class="form-group">
          <label>Precio letra</label>
          <input type="text" class="form-control" id="letra" name="letra" required="" readonly="" value="{{old('letra')}}">
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label>Fecha</label>
          <input class="form-control" type="date" id="fechapago_venta1" name="fechapago_venta1" required="" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" min="{{\Carbon\Carbon::yesterday()->format('Y-m-d')}}" max="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
        </div>
      </div>

      <div class="">
        <div class="form-group" style="display:none;">
          <label>Tipo de cambio</label>
          <input class="form-control" type="text" id="tipo_cambio_principal" name="tipo_cambio_principal" required="" onkeypress="return SoloNumeros(event);" value="!">
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom:15px;">
      <div class="col-sm-12">
        <label for="RangePagares" class="row">Número de Pagares: &nbsp;<p id="NumeroPagares"></p>  <button type="button" class="btn btn-success" onclick="MostrarAnticipo(this)" style="padding-top: 0px;padding-bottom: 0px;margin-left: 20px;"><i class="fas fa-plus"></i>&nbsp;Anticipo</button> </label>
        <input type="hidden" id="NumeroPagaresInput" name="NumeroPagares">
        <input type="range" class="custom-range" id="RangePagares" min="1" max="12" value="1" oninput="GenerarPagares(this)">
      </div>
      <div class="row" id="Pagares" style="width: 100%;justify-content: center;margin-left: 0px;">

        <div class="col-12 col-sm-12 col-md-12" id="Anticipo" style="display:none">
          <div class="" style="padding:15px;border-radius: 10px;">
            <div class="row" style="border-radius: 10px;padding: 10px;">

              <div class="col-sm-12" style="">
                <img src="https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/public/img/logo_gran_pana.png" alt="" style="height: 30px;position: absolute;top: -8px;right: 10px;">
                <p class="col" style="color:black;position: relative;top: -21px;text-align: center;">
                  <b class="" style="padding-left: 10px;padding-right: 10px;cursor: pointer;">Anticipo</b>
                </p>
              </div>

              <div class="col-sm-4" style="display:none;">
                <label for="CantidadAnticipoMXN">Monto</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
                  </div>
                  <input type="text" class="form-control readonly" id="CantidadAnticipoMXN" name="CantidadAnticipoMXN" placeholder="$0.00"  onkeypress="return SoloNumeros(event);" maxlength="10" disabled required>
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
                  </div>
                </div>
              </div>


              <div class="col-sm-4" style="">
                <label for="CantidadAnticipoUSD">Monto</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
                  </div>
                  <input type="text" class="form-control" id="CantidadAnticipoUSD" placeholder="$0.00"  onkeypress="return SoloNumeros(event);" onkeyup="CalculosAnticipo()" maxlength="10" disabled required>
                  <div class="input-group-prepend">
                    <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">USD</div>
                  </div>
                </div>
              </div>


              <div class="col-sm-4" style="">
                <label for="m_pago_anticipo">Metodo de pago</label>
                <select class="form-control" id="m_pago_anticipo" name="m_pago_anticipo" onchange="changeComprobantePrincipal();" disabled required>
                  <option value="" disabled>Elige una opción…</option>
                  @foreach ($MetodosPago as $key => $MP)
                    <option value="{{$MP->nomeclatura}}">{{$MP->nomeclatura.' '.$MP->nombre}}</option>
                  @endforeach
                </select>
              </div>



              <div class="col-sm-4" style="">
                <label for="comprobante_anticipo">Tipo de comprobante</label>
                <select class="form-control" id="comprobante_anticipo" name="comprobante_anticipo" onchange="ocultar_referencia_anticipo(this.value);" disabled required>
                  <option value="" disabled>Elige una opción…</option>
                  <option value="Recibo">Recibo</option>
                  <option value="Recibo Automático">Recibo automático</option>
                  <option value="Notificación digital">Notificación digital</option>
                  {{-- @foreach ($CatalogoComprobante as $key => $CC)
                  @if ($CC->nombre=='Contrato de Compra' || $CC->nombre=='Notificación Digital' || $CC->nombre=='Factura')
                  <option value="{{$CC->nombre}}">{{$CC->nombre}}</option>
                @endif
              @endforeach --}}
            </select>
          </div>


          <div class="col-sm-4">
            <label for="n_referencia_anticipo">Número de referencia</label>
            <label data-toggle="tooltip" data-placement="top" title="Referencia generada automaticamente"><i class="far fa-question-circle"></i></label>
            <label id="respuesta_referecia_anticipo"></label>
            <i class="fa fa-refresh btn redondo" style="color: #04058D;background-color: inherit;display:none;" onclick="generateReferenceAnticipo();" id="BtnReferenciaAnticipo" aria-hidden="true"></i>
            <input class="form-control" type="text" id="n_referencia_anticipo" name="n_referencia_anticipo" minlength="6" maxlength="30" onkeyup="BuscarVIN(this.value,3)" disabled required>
          </div>

          <div class="col-sm-4" style="">
            <label for="comprobante_archivo_anticipo">Evidencia:</label>
            <input type="file" placeholder="Evidencia de Comprobante" name="uploadedfile_anticipo" id="comprobante_archivo_anticipo" class="form-control"  accept="image/*, .pdf" disabled required>
          </div>

          <div class="col-sm-4" style="">
            <label for="ComentariosAnticipo">Comentarios</label>
            <input type="text" id="ComentariosAnticipo" name="ComentariosAnticipo" value="" class="ComentariosPagare form-control"  placeholder="Comentarios" disabled required maxlength="8950">
          </div>

        </div>
      </div>
    </div>






  </div>
</div>

<!--*****************************************************************************************************************************************************************************************-->
<div class="row" id="CampoBusquedaVIN">
  <div class="col-sm-12">
    <div class="form-group">
      <label>Buscar VIN</label>
      <input placeholder="Buscar" class="form-control" type="text" name="busqueda_vin" id="busqueda_vin" value="{{old('busqueda_vin')}}" maxlength="25" autocomplete="off" onkeyup="buscar_vin_bloqueado();" size="19" width="300%">
      <center>
        <div id="resultadoBusquedaVin"></div>
      </center>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <label>VIN</label><label id="respuestaVIN" style="margin-left: 5px;"></label>
      <input class="form-control DatosVIN" type="text" id="vin_venta" name="vin_venta" value="{{old('vin_venta')}}"  minlength="16" maxlength="18" readonly="readonly" required>
      <div class="invalid-feedback">
        El VIN debe de constar entre 16 min - 18 max caracteres
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <label>Marca</label>
      <input class="form-control DatosVIN Capitalizar" type="text" id="marca_venta" name="marca_venta" value="{{old('marca_venta')}}" required="" onkeyup="buscar_marca();" autocomplete="off" readonly="readonly" maxlength="30">
      <center>
        <div id="resultadoMarca"></div>
      </center>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <label>Modelo</label>
      <input class="form-control DatosVIN" type="text" id="modelo_venta" name="modelo_venta" value="{{old('modelo_venta')}}" required="" onkeyup="buscar_modelo();" autocomplete="off" onkeypress="return SoloNumeros(event);" readonly="readonly" min="1900" max="2021" minlength="4" maxlength="4">
      <center>
        <div id="resultadoModelo"></div>
      </center>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <label>Versión</label>
      <input class="form-control DatosVIN" type="text" id="version_venta" name="version_venta" value="{{old('version_venta')}}" required="" onkeyup="buscar_version();" autocpmplete="off" readonly="readonly" maxlength="60">
      <center>
        <div id="resultadoVersion" style="font-size: 13px;"></div>
      </center>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <label>Color</label>
      <input class="form-control DatosVIN" type="text" id="color_venta" name="color_venta" value="{{old('color_venta')}}" required="" onkeyup="buscar_color();" autocomplete="off" readonly="readonly" maxlength="20">
      <center>
        <div id="resultadoColor"></div>
      </center>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <label>Tipo</label>
      <select class="form-control" id="tipo_unidad" name="tipo_unidad" required="">

        @foreach ([
          'UNIDAD' => 'Unidad',
          'TRUCKS'  => 'Trucks',
          ] as $key => $value)

          <option value="{{$key}}"
          @if ($key == old('tipo_unidad'))
            selected
          @endif
          >{{$value}}</option>
        @endforeach

      </select>
    </div>
  </div>
</div>
<!--**************************************************************************************************************************************************************************************-->
<div class="row OcultarRow">
  <div class="col-sm-6">
    <div class="form-group">
      <label>Institución emisora</label>
      <select class="form-control" id="emisor_venta" name="emisor_venta" required="" >

        <option value="" disabled>Elige una opcion...</option>

        <option value="{{$idconta.'.'.$iniciales_cliente}}"
        @if ($idconta.'.'.$iniciales_cliente == old('emisor_venta'))
          selected
        @endif
        >{{$idconta.'.'.$iniciales_cliente}}</option>

        @foreach ($CatalogoTesorerias as $key => $CT)
          <option value="{{$CT->nomeclatura}}"

            @if ($CT->nomeclatura == old('emisor_venta'))
              selected
            @endif

            >{{$CT->nomeclatura.' '.$CT->nombre}}</option>
          @endforeach

        </select>

        <!--<input class="form-control" type="text" id="emisor_venta" name="emisor_venta" required="" value="" readonly="">-->
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label>Agente emisor</label>
        <select class="form-control" id="agente_emisor_venta" name="agente_emisor_venta" required="">

          <option value="" disabled >Elige una opcion...</option>

          <option value="{{$idconta.'.'.$iniciales_cliente}}"
          @if ($idconta.'.'.$iniciales_cliente == old('agente_emisor_venta'))
            selected
          @endif
          >{{$idconta.'.'.$iniciales_cliente}}</option>

          @foreach ($CatalogoTesorerias as $key => $CT)
            <option value="{{$CT->nomeclatura}}"

              @if ($CT->nomeclatura == old('agente_emisor_venta'))
                selected
              @endif

              >{{$CT->nomeclatura.' '.$CT->nombre}}</option>
            @endforeach

          </select>

          <!--<input class="form-control" type="text" id="agente_emisor_venta" name="agente_emisor_venta" required="" value="" readonly="">-->
        </div>
      </div>
    </div>
    <!--*****************************************************************************************************************************************************************************************-->
    <div class="row OcultarRow">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Institución receptora</label>
          <select class="form-control" id="receptor_venta" name="receptor_venta" required="">

            @foreach ($BancosEmisores as $key => $BE)
              <option value="{{$BE->nombre}}"

                @if ($BE->nombre == old('receptor_venta'))
                  selected
                @endif

                >{{$BE->nombre}}</option>
              @endforeach

            </select>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label>Agente receptor</label>
            <select class="form-control" id="agente_receptor_venta" name="agente_receptor_venta" required="">
              <option value="">Elige una opción…</option>

              @foreach ($CatalogoTesorerias as $key => $CT)
                <option value="{{$CT->nomeclatura}}"

                  @if ($CT->nomeclatura == old('agente_receptor_venta'))
                    selected
                  @endif

                  >{{$CT->nomeclatura.' '.$CT->nombre}}</option>
                @endforeach

              </select>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label>Número de referencia</label>
              <label data-toggle="tooltip" data-placement="top" title="Referencia generada automaticamente"><i class="far fa-question-circle"></i></label>
              <label id="respuesta_referecia_venta"></label>
              <input class="form-control" type="text" id="n_referencia_venta"  name="n_referencia_venta" value="{{old('n_referencia_venta')}}"  required="" maxlength="30" onkeyup="BuscarVIN(this.value,1,true);">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Tipo de comprobante</label>
              <select class="form-control" id="tipo_comprobante_compra" name="tipo_comprobante_compra" onchange="ocultar_referencia(this.value);" required="">
                <option value="">Elige una opción…</option>

                @foreach ($CatalogoComprobante as $key => $CC)
                  <option value="{{$CC->nombre}}"

                    @if ($CC->nombre == old('tipo_comprobante_compra'))
                      selected
                    @endif

                    >{{$CC->nombre}}</option>
                  @endforeach

                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Evidencia:</label>
                <input type="file" placeholder="Evidencia de Comprobante" name="comprobante_compra" value="{{old('comprobante_compra')}}" id="comprobante_compra" class="form-control" required="" accept=".jpg,.png,.pdf">
              </div>
            </div>
            <div class="col-sm-3" @if($idconta!=1341) style="display:none;" @endif>
              <div class="form-group">
                <br>
                <button type="button" class="btn btn-success" onclick="MostrarImportacion(this)" style="padding-top: 0px;padding-bottom: 0px;margin-left: 0px;"><i class="fas fa-plus"></i>&nbsp;$ Importación</button>
              </div>
            </div>

            <div class="col-sm-3" style="display: none;" id='div_inportacion'>
              <div class="form-group">
                <label>Costo de importación:</label>
                <input class="form-control" type="text" id="importacion" name="importacion" value="0" autocomplete="off" onkeyup="updateCompra()"  onkeypress="return SoloNumeros(event);" required="">
                <input type="hidden" id='temporal_saldo' value="0">
              </div>
            </div>
            <div class="col-sm-6" style="display: none;" id='div_saldos_sobrantes'>
              <div class="form-group">
                <label>Saldo disponible:</label>
                <input class="form-control" type="text" id="input_saldo_sobrante" name="input_saldo_sobrante" value="{{$saldo_compras}}" autocomplete="off" onkeypress="return SoloNumeros(event);" readonly>
              </div>
            </div>
            {{-- <div class="col-sm-6" style="display: none;" id='div_compra_restante'>
              <div class="form-group">
                <label>Pago restante por unidad:</label>
                <input class="form-control" type="text" id="compra_saldo_sobrante" name="input_saldo_sobrante" value="0" autocomplete="off" onkeypress="return SoloNumeros(event);" readonly>
                <input class="form-control" type="text" id="abono_saldo_sobrante" name="input_saldo_sobrante" value="0" autocomplete="off" onkeypress="return SoloNumeros(event);" readonly>
              </div>
            </div> --}}
            {{-- </div> --}}
            <!--**************************************************************************************************************************************************************************************-->
            <div class="col-sm-6" style="display:none">
              <div class="form-group">
                <label>Folio anterior</label>
                <input class="form-control" type="text" id="folio_anterior" name="folio_anterior" value="{{old('folio_anterior')}}">
              </div>
            </div>
          </div>
          <!--**************************************************************************************************************************************************************************************-->
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Comentarios:</label>
                <textarea class="form-control" rows="2" id="descripcion_venta" name="descripcion_venta" maxlength="8950" required="">{{old('descripcion_venta')}}</textarea>
              </div>
            </div>
          </div>

          <div class="hr-line-dashed"></div>
          <input type="hidden" id='coordenadas_main' name="coordenadas" value="">

          <input type="hidden" name="contacto_original_venta" value="{{$idconta}}" id="contacto_original_venta">
          <input type="hidden" id="concepto_general_venta" name="concepto_general_venta" value="{{old('concepto_general_venta')}}">
          <input type="hidden" id="fecha_inicio_venta" name="fecha_inicio_venta" value="{{\Carbon\Carbon::now()}}">
          <!--**************************************************************************************************************************************************************************-->
          <input type="hidden" name="orden_logistica" id="orden_logistica" value="{{old('orden_logistica')}}">
          <!--**************************************************************************************************************************************************************************-->
          <div class="form-group">
            <div class="col-lg-12">
              <br>
              <center>
                <button class="btn btn-lg btn-primary" type="submit">Guardar</button>
              </center>

            </div>
          </div>
        </form>

      </div>


      <script type="text/javascript">

      var PagaresCreados = 0;
      var FechaMinima = '{{\Carbon\Carbon::now()->format('Y-m-d')}}';
      GenerarPagares(document.getElementById('RangePagares'));

      $("#tipo_moneda_principal option[value='{{$Proveedor->col2}}']").attr("selected",true);
      $('#tipo_moneda_principal option:not(:selected)').prop('disabled', true);
      $('#tipo_moneda_principal option:not(:selected)').css('display', 'none');


      function GenerarPagares(input){


        while (input.value != PagaresCreados) {

          if (input.value > PagaresCreados) {
            var Logo = '{{secure_asset('public/img/logo_gran_pana.png')}}';
            var tipo_cambioOld =  '{{old('tipo_moneda_principal')}}';
            var tipo_cambioNew =  '{{$Proveedor->col2}}';
            var tipo_Cambio = tipo_cambioOld || tipo_cambioNew;


            var Pagare = `
            <div class="Pagare col-12 col-sm-12 col-md-6 fadeIn_izi" id="Pagare_`+PagaresCreados+`">
            <div class="" style="padding:15px;border-radius: 10px;background: rgb(70,69,78);background: linear-gradient(240deg, rgba(70,69,78,0.8883928571428571) 72%, rgba(29,28,28,1) 100%);">
            <div class="" style="border: solid #ddfbfb 2px;border-radius: 10px;padding: 10px;">
            <div class="row" style="margin-bottom: 7px;">

            <div class="col">
            <p class="row" style="color:white;margin-left: 0px;">
            <b>Pagare `+(PagaresCreados+1)+`/</b>
            <b class="CantidadPagares"></b>
            </p>
            </div>

            <p class="col" style="color:white;position: relative;top: -21px;">
            <b class="BTipoPagare" style="border-radius: 20px;border: solid 1px;padding-left: 10px;padding-right: 10px;cursor: pointer;" onclick="CambiarTipoPagare(`+PagaresCreados+`,this)">Virtual</b>
            </p>

            <img src="`+Logo+`" alt="" style="height: 30px;position: relative;top: -8px;right: 10px;">
            </div>

            <div class="row" style="margin-bottom: 7px;">
            <div style="padding-left: 15px;" class="LabelsPagare">
            <p style="color:white;">Vence el día &nbsp;</p>
            </div>
            <div class="col" style="position: relative;top: -8px;">
            <input type="date" name="FechaPagare_`+PagaresCreados+`" value="" class="FechaPagare form-control" min="`+FechaMinima+`" required>
            </div>
            </div>

            <div class="row">
            <div style="padding-left: 15px;" class="LabelsPagare">
            <p style="color:white;">Comentarios </p>
            </div>
            <div class="col" style="position: relative;top: -8px;">
            <input type="text" name="ComentariosPagare_`+PagaresCreados+`" value="" class="ComentariosPagare form-control" required placeholder="Comentarios">
            </div>
            </div>

            <div class="row" style="display: none;margin-top: 7px;">
            <div style="padding-left: 15px;padding-right: 22px;" class="LabelsPagare">
            <p style="color:white;">Evidencia</p>
            </div>
            <div class="col" style="position: relative;top: -8px;">
            <input type="file" name="Evidencia_`+PagaresCreados+`" id="Evidencia_`+PagaresCreados+`" value="" class="form-control" required disabled accept=".jpg,.png,.pdf">
            </div>
            </div>

            <div class="input-group mb-2" style="display:none;">
            <div style="padding-right: 57px;" class="LabelsPagare">
            <p style="color:white;">Monto </p>
            </div>
            <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
            </div>
            <input type="text" class="form-control PrecioPagareMXN" name="CantidadPagare_`+PagaresCreados+`" placeholder="$0.00" required onkeypress="return SoloNumeros(event);" maxlength="10">
            <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
            </div>
            </div>

            <div class="input-group mb-2">
            <div style="padding-right: 57px;" class="LabelsPagare">
            <p style="color:white;">Monto </p>
            </div>
            <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
            </div>
            <input type="text" class="form-control PrecioPagareUSD"  placeholder="$0.00" required onkeypress="return SoloNumeros(event);" onchange="CambiarMontoPagare(this.value,`+PagaresCreados+`)" maxlength="10">
            <div class="input-group-prepend">
            <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">`+tipo_Cambio+`</div>
            </div>
            </div>

            </div>
            </div>
            </div>
            `;
            $('#Pagares').append(Pagare);
            PagaresCreados++;

          }else{
            PagaresCreados--;

            var PagareEliminado = $('#Pagare_'+PagaresCreados).removeAttr('id');
            PagareEliminado.removeClass('fadeIn_izi');
            PagareEliminado.addClass('flipOutX_izi');
            PagareEliminado.fadeOut('slow',function(){
              $(this).remove();
            });


          }

        }




        MontoPagares();
        $('.CantidadPagares').html(input.value)
        document.getElementById('NumeroPagares').innerHTML = input.value;
        document.getElementById('NumeroPagaresInput').value = input.value;

        $('#venta button:submit').prop('disabled',false);

      }

      function CambiarTipoPagare(id,campo){
        if(campo.textContent == "Virtual"){
          campo.textContent = "Físico";
          $('#Evidencia_'+id).prop('disabled', false);
          $('#Evidencia_'+id).parent().parent().fadeIn();
        }else{
          campo.textContent = "Virtual";
          $('#Evidencia_'+id).prop('disabled', true);
          $('#Evidencia_'+id).parent().parent().fadeOut()
        }

      }


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
          monto_capturado_venta=$("#monto_abono_venta").val()||0;
          tipo=$("#tipo_cambio_principal").val();

          if (parseFloat(tipo) < 1) {
            iziToast.warning({
              title: 'Atención',
              message: 'No hay registro del tipo de cambio ->'+tipo,
              position: 'topRight'
            });
          }

          MontoPagares();

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

      function CalculosAnticipo(){
        var Abono = parseFloat($('#monto_abono_venta').val()) || 0;
        var Anticipo = parseFloat($('#CantidadAnticipoUSD').val()) || 0;

        if (Anticipo == 0) {
          document.getElementById('CantidadAnticipoUSD').reportValidity();
          $('#CantidadAnticipoUSD').val('');
          $('#CantidadAnticipoMXN').val('');
        }else if(Abono == 0){
          $('#monto_abono_venta').val('');
          document.getElementById('monto_abono_venta').reportValidity();
          $('#CantidadAnticipoUSD').val('');
          $('#CantidadAnticipoMXN').val('');
        }
        else if (Anticipo >= Abono) {
          $('#CantidadAnticipoUSD').val('');
          $('#CantidadAnticipoMXN').val('');
          iziToast.warning({
            title: 'Atención',
            message: 'El anticipo no puede ser mayor o igual a '+Abono,
          });
        }else{
          var TCambio = parseFloat($('#tipo_cambio_principal').val());
          $('#CantidadAnticipoMXN').val(Anticipo*TCambio);
        }

        MontoPagares();
      }

      function getFlooredFixed(v) {
        return parseFloat((Math.floor(v * Math.pow(10, 2)) / Math.pow(10, 2)).toFixed(2));
      }

      function MontoPagares(){

        var TCambio = parseFloat($('#tipo_cambio_principal').val());
        var Pre = $('#monto_abono_venta').val() || 0;
        var Anticipo = parseFloat($('#CantidadAnticipoUSD').val()) || 0;

        if (Anticipo >= Pre) {
          $('#CantidadAnticipoUSD').val('');
          $('#CantidadAnticipoMXN').val('');
        }

        if (Pre != 0) {
          var Precio = parseFloat(Pre);
          var Anticipo = parseFloat($('#CantidadAnticipoUSD').val()) || 0;
          var Total = (Precio-Anticipo).toFixed(2);

          var NumPagar = parseFloat($('#RangePagares').val());
          var PrecioPagare = getFlooredFixed((Total*TCambio)/NumPagar);

          $('.PrecioPagareMXN').val(PrecioPagare);
          $('.PrecioPagareUSD').val(PrecioPagare);

          $('.TCambioText').html($('#tipo_moneda_principal').val());

          if(PrecioPagare*NumPagar < Total){

            var Diferencia = getFlooredFixed( (Total - (PrecioPagare*NumPagar)).toFixed(2));
            var NuevoPrecio = parseFloat((PrecioPagare+Diferencia).toFixed(2));

            var SumaFinal = (parseFloat((PrecioPagare* (NumPagar-1)).toFixed(2)) +NuevoPrecio).toFixed(2);
            $($('.PrecioPagareMXN')[0]).val(NuevoPrecio);
            $($('.PrecioPagareUSD')[0]).val(NuevoPrecio);

            if(Total != SumaFinal){
              iziToast.warning({
                title: 'Atención',
                message: 'El calculo de los pagares no se pudo realizar correctamente '+SumaFinal,
              });
            }
          }


        }else{
          $('.PrecioPagareMXN').val('');
          $('.PrecioPagareUSD').val('');
          $('#CantidadAnticipoUSD').val('');
          $('#CantidadAnticipoMXN').val('');
        }
      }

      function CambiarMontoPagare(monto,id){

        var TCambio = parseFloat($('#tipo_cambio_principal').val());
        var Precio = parseFloat(monto) || 0;
        var AbonoTotal = parseFloat($('#monto_abono_venta').val()) || 0;
        var Anticipo = parseFloat($('#CantidadAnticipoUSD').val()) || 0;


        $('#Pagare_'+id).find('.PrecioPagareMXN').val(Precio*TCambio);


        var Montos = $('.PrecioPagareUSD');
        var SumaTotal = Anticipo;
        for (var i = 0; i < Montos.length; i++) {
          SumaTotal+= (parseFloat(Montos[i].value)||0);
        }

        if(SumaTotal != AbonoTotal){
          var Diferencia = getFlooredFixed(SumaTotal-AbonoTotal);
          var Signo = (Diferencia > 0) ? "<b>sobra la cantidad</b> de":"<b>falta la cantidad</b> de";

          iziToast.warning({
            title: 'Atención',
            message: 'La suma de los pagares no cuadra '+Signo+" "+Diferencia,
            position: 'center',
            transitionIn : 'bounceInRight',
            transitionOut: 'flipOutX',
            balloon : true,
            timeout : false,
            overlay: true,
          });

          $('#venta button:submit').prop('disabled',true);
        }else{
          $('#venta button:submit').prop('disabled',false);
        }
      }

      function MostrarImportacion(boton){


        if($(boton).find('i').hasClass("fa-plus")){
          $(boton).find('i').removeClass("fa-plus");
          $(boton).find('i').addClass("fa-minus");
          $(boton).removeClass("btn-success");
          $(boton).addClass("btn-danger");

          $('#div_inportacion').removeClass('fadeOutLeft');
          $('#div_inportacion').addClass('fadeInDown_izi');
          $('#div_inportacion').fadeIn('slow');
          $('#monto_abono_venta').attr('readonly',true);
          let monto_abono_venta = document.getElementById('monto_abono_venta').value;
          if (monto_abono_venta=='') { monto_abono_venta = 0; }
          document.getElementById('temporal_saldo').value=monto_abono_venta;
          updateCompra();
          // $('#Anticipo :required').prop('disabled',false);
        }else{
          $(boton).find('i').removeClass("fa-minus");
          $(boton).find('i').addClass("fa-plus");
          $(boton).removeClass("btn-danger");
          $(boton).addClass("btn-success");
          document.getElementById('importacion').value=0;
          document.getElementById('monto_abono_venta').value=temporal_saldo;
          updateCompra();
          $('#monto_abono_venta').attr('readonly',false);
          MontoPagares();
          // $(monto_abono_venta).attr("readonly");
          // $('#div_inportacion :required').prop('disabled',true);

          // $('#CantidadAnticipoUSD').val('');
          // $('#CantidadAnticipoMXN').val('');
          //
          $('#div_inportacion').removeClass('fadeInDown_izi');
          $('#div_inportacion').addClass('fadeOutLeft');
          $('#div_inportacion').fadeOut('slow');

        }

      }
      function updateCompra(){

        let importacion = document.getElementById('importacion').value;
        let monto_abono_venta = document.getElementById('monto_abono_venta').value;
        let temporal_saldo = document.getElementById('temporal_saldo').value;
        if (importacion=='') { importacion = 0; }
        if (monto_abono_venta=='') { monto_abono_venta = 0; }
        let nuevo_saldo = parseFloat(temporal_saldo) + parseFloat(importacion);
        document.getElementById('monto_abono_venta').value = nuevo_saldo;
        MontoPagares();
        CalcularMontoAbonoVenta();
        console.log(importacion);
      }
      function MostrarAnticipo(boton){


        if($(boton).find('i').hasClass("fa-plus")){
          $(boton).find('i').removeClass("fa-plus");
          $(boton).find('i').addClass("fa-minus");
          $(boton).removeClass("btn-success");
          $(boton).addClass("btn-danger");

          $('#Anticipo').removeClass('fadeOutLeft');
          $('#Anticipo').addClass('fadeInDown_izi');
          $('#Anticipo').fadeIn('slow');

          $('#Anticipo :required').prop('disabled',false);
        }else{
          $(boton).find('i').removeClass("fa-minus");
          $(boton).find('i').addClass("fa-plus");
          $(boton).removeClass("btn-danger");
          $(boton).addClass("btn-success");
          $('#Anticipo :required').prop('disabled',true);

          $('#CantidadAnticipoUSD').val('');
          $('#CantidadAnticipoMXN').val('');

          $('#Anticipo').removeClass('fadeInDown_izi');
          $('#Anticipo').addClass('fadeOutLeft');
          $('#Anticipo').fadeOut('slow');
          MontoPagares();
        }

      }


      function generateReferenceAnticipo(){

        var receptor = $('#agente_emisor_venta').val();

        function makeid(length) {
          var result           = '';
          var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
          var charactersLength = characters.length;
          for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
          }
          return result;
        }
        var datos_vin = $('#vin_venta').val();
        var Referencia = receptor+'_'+datos_vin+'_'+makeid(2);
        BuscarVIN(Referencia,3);
      }
      function changeComprobantePrincipal(){
        var m_pago_anticipo_select = document.getElementById("m_pago_anticipo");
        var m_pago_anticipo = m_pago_anticipo_select.options[m_pago_anticipo_select.selectedIndex].value;
        console.log(m_pago_anticipo);
        if (m_pago_anticipo==3) {
          console.log('Panamotors');
          $('#comprobante_anticipo').empty();
          // $('#comprobante').show();
          // $('#temp_comprobante').hide();

          document.getElementById("comprobante_anticipo").innerHTML += "<option disabled>"+"Selecciona una opción"+"</option>";
          document.getElementById("comprobante_anticipo").innerHTML += "<option value='Boucher'>"+"Boucher"+"</option>";
          // document.getElementById("comprobante_anticipo").innerHTML += "<option value='Notificación digital'>"+"Notificación digital"+"</option>";
          // document.getElementById("agente_emisor").value = "B2";
          // document.getElementById("comprobante").style.cssText = 'webkit-appearance: auto;-moz-appearance: auto;appearance: auto;';
          // $('#comprobante').removeClass('readonly');
        }else if (m_pago_anticipo==1) {
          // document.getElementById("comprobante").style.cssText = 'webkit-appearance: none;-moz-appearance: none;appearance: none;';
          // $('#comprobante').addClass('readonly');
          // document.getElementById("agente_emisor").value = "TP1";
          $('#comprobante_anticipo').empty();
          // $('#temp_comprobante').show();
          // $('#comprobante').hide();
          document.getElementById("comprobante_anticipo").innerHTML += "<option disabled>"+"Selecciona una opción"+"</option>";
          document.getElementById("comprobante_anticipo").innerHTML += "<option value='Recibo'>"+"Recibo"+"</option>";
          document.getElementById("comprobante_anticipo").innerHTML += "<option value='Recibo Automático'>"+"Recibo Automático"+"</option>";
          document.getElementById("comprobante_anticipo").innerHTML += "<option value='Notificación digital'>"+"Notificación digital"+"</option>";
          // document.getElementById("temp_comprobante").value = "Recibo";agente_emisor
        }
      }
      </script>


      <style media="screen">

      .Pagare:hover > div {
        box-shadow: 0 0 15px 2px rgba(0, 0, 0, 0.45);
      }

      .readonly{
        background: #e9ecef;
        cursor: default;
      }

      .BTipoPagare{
        background: #5a5961;
      }
      .BTipoPagare:hover{
        background: #79787f;
      }

      .Pagare{
        margin-top: 5px; margin-bottom:5px
      }

      .ComentariosPagare::placeholder{
        color:white;
      }

      @media (max-width: 576px) {
        .Pagare{
          padding: 0px;
        }
        .LabelsPagare{
          display: none;
        }
        .ComentariosPagare::placeholder{
          color:#495057;
        }
      }

      .fadeOutLeft{
        -webkit-animation: iziT-fadeOutLeft .5s ease both;
        animation: iziT-fadeOutLeft .5s ease both;
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

      .fadeIn_izi{
        .-webkit-animation: iziT-fadeIn .5s ease both;
        animation: iziT-fadeIn .5s ease both;
      }
      #marca_venta:focus+center>#resultadoMarca, #modelo_venta:focus+center>#resultadoModelo, #version_venta:focus+center>#resultadoVersion,#color_venta:focus+center>#resultadoColor{
        border-color: #c3c7cc;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgb(195 199 204 / 25%);
        margin: 0 1%;
      }
      #resultadoMarca > option,#resultadoModelo > option,#resultadoVersion > option, #resultadoColor > option{
        white-space: normal;
      }
      #resultadoMarca > option:hover,#resultadoModelo > option:hover ,#resultadoVersion > option:hover, #resultadoColor > option:hover{
        cursor: pointer;
        background-color: #882434;
        color: white;
      }

      </style>
