<style media="screen">
.display-none{
  display: none;
}

@media (max-width: 576px) {
  #card{
    width: 100% !important;
  }
}

#card{
  width: 450px;
}
</style>

<div id="principal" >
  {{-- <p>CompraVentaController - Form Principal</p> --}}




  <div id="card" class="card" style="margin:0 auto; min-height:450px;border-radius: 20px;background: #dadbe0;box-shadow: 0px 0px 20px rgb(136 36 57 / 20%);position: relative;overflow: hidden;">
    <div class="card-header" style="padding:10px;background: #F3F3F3;">
      <h2 style="text-align:center;" id="td-vin-numero-serie"></h2>
    </div>
    <div class="card-body" id="datos-principales" style="padding:0px;">
      <div class="col-lg-12 imagen-perfil" style="background: #fff;padding: 20px 0px;">
        <div class="" style="text-align: right;">
        </div>
        <div class="text-center" id="img-header-unidad">
          {{--@if (!empty($foto))
          <img alt='image' width='150' height='150' class='rounded-circle' src="{{url('/').'/'.$foto}}" alt="">
        @else--}}
        <!-- <img alt='image' width='150' height='150' class='rounded-circle' src="https://www.panamotorscenter.com/Des/CCP/Fotos_Inventario/fondoblanco_actual.jpg" alt=""> -->
      </div>

    </div>

    <h1 class="mt-3 mb-3" style="text-align: center; font-size:1rem;"><strong>

    </strong></h1>
    <div class="table-responsive not-dataTable">
      <table class="table table-striped not-dataTable">
        <tbody>
          <tr>
            <td colspan="4" style="text-align:center;" id="td-version"><b>

            </b></td>
          </tr>
          <tr style="text-align:center;">
            <td id="td-marca">

            </td>
            <td id="td-color">

            </td>
            <td id="td-modelo">

            </td>
          </tr>
          <tr>
            <td colspan="3"style="text-align:center;">Precio digital: $
              <b id="td-precio-digital">

              </b></td>
            </tr>
            <tr>
              <td colspan="3">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Precio letra</label>
                    <input type="text" class="form-control" id="letra" name="letra" required="" readonly="" value="{{old('letra')}}" style="text-align:center;">
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>









  <!--*****************************************************************************************************************************************************************************************-->

  <div class="row" style="display:none;">
    <div class="col-sm-4">
      <div class="form-group">
        <label>VIN</label><label id="respuestaVIN" style="margin-left: 5px;"></label>
        <input class="form-control DatosVIN" type="text" id="vin_venta" name="vin_venta" value="{{old('vin_venta')}}"  minlength="16" maxlength="18" readonly="readonly" required>
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
  <div class="row" style="display:none;">
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
        <select class="form-control readonly" id="tipo_unidad" name="tipo_unidad" required="">

          @foreach ([
            'Unidad' => 'Unidad',
            'Trucks'  => 'Trucks',
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


  <div class="shadow panel-head-primary" style="padding-top: 2%; padding-bottom:2%; margin-top:3%; margin-bottom:3%;">

    <div class="col-lg-12">

      <div class="panel-body datatable-panel">


        <!--******************************************************************************************************************************************************************************-->
        <div class="row">
          <div class="col-sm-4" style="display:none;">
            <div class="form-group">
              <label>Precio Digital</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
                </div>
                <input class="form-control readonly" type="text" id="monto_abono_venta" name="monto_abono_venta" value="{{old('monto_abono_venta')}}" autocomplete="off"  onkeypress="return SoloNumeros(event);" required="" maxlength="9" style="border-radius: 0px !important;">
                <div class="input-group-prepend">
                  <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px">
                    MXN
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-sm-4" style="display:none;">
            <label for="RangeDescuento" class="row">
              <p>Descuento:</p>
              <p id="NumeroDescuento">0%</p>
              <label class="col" style="text-align: center;" data-toggle="modal" data-target="#ModalDescuento">
                <i class="far fa-question-circle btn btn-success" aria-hidden="true" style="border-radius: 20px;padding:0px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Solicitar aumento del descuento" onclick="VerMisDescuentos()"></i>
              </label>
            </label>
            <input type="range" class="custom-range" id="RangeDescuento" name="RangeDescuento" min="0" max="10" value="0" oninput="CalculoDescuento(this)">
          </div>

          <div class="col-sm-4" style="display:none;" id="DivMetodosPago">
            <label for="metodo_pago">Metodo de pago</label>
            <select class="form-control" id="metodo_pago" name="metodo_pago" onchange="changeComprobantePrincipal();" required disabled>
              <option value="" disabled>Elige una opción…</option>
              <option value="Por definir">Por Definir</option>
              <option value="Definir">Definir</option>
            </select>
          </div>

          <div class="col-sm-4" style="display:none;">
            <div class="form-group">
              <label>Precio Digital</label> <!-- Antes precio con descuento -->
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
                </div>
                <input class="form-control" type="text" id="saldo_nuevo_venta" name="saldo_nuevo_venta" readonly="" required="" value="{{old('saldo_nuevo_venta')}}" style="border-radius: 0px !important;">
                <div class="input-group-prepend">
                  <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px">
                    MXN
                  </div>
                </div>
              </div>
            </div>
          </div>







          <div class="col-sm-4">
            <div class="form-group">
              <label>Fecha</label>
              <input class="form-control" type="date" id="fechapago_venta1" name="fechapago_venta1" required="" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" min="{{\Carbon\Carbon::yesterday()->format('Y-m-d')}}" max="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
            </div>
          </div>
        </div>


        <div id="metodos_pago_mixto">


        </div>
        <input type="hidden" name="NumPagos" value="0" class="form-control" id="NumPagos">

        <div class="row display-none" style="text-align:right;" id="buttons-add-pago">
          <div class="col-12 col-md-12" style="padding-bottom: 15px;">
            <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Eliminar metodo de pago" style="border-radius: 10px;display:none;" onclick="EliminarMetodoPago()" id="BtnEliminarPago">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Agregar metodo de pago" style="border-radius: 10px" onclick="AgregarMetodoPago()" id="BtnAgregarPago">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>

        <!--******************************************************************************************************************************************************************************-->
        <div class="row">


          <div class="">
            <div class="form-group" style="display:none;">
              <label>Tipo de cambio</label>
              <input class="form-control" type="text" id="tipo_cambio_principal" name="tipo_cambio_principal" required="" onkeypress="return SoloNumeros(event);" value="1">
            </div>
          </div>
        </div>

        <div class="row" style="margin-bottom:15px;">



          <div class="row" id="Pagares" style="width: 100%;justify-content: center;margin-left: 0px;">

            <div class="col-12 col-sm-12 col-md-12" id="Anticipo" style="display:none">
              <div class="" style="padding:15px;border-radius: 10px;background: rgb(185 185 185 / 30%);">
                <div class="row" style="border-radius: 10px;padding: 10px;">

                  <div class="col-sm-12" style="">
                    <img src="https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/public/img/logo_gran_pana.png" alt="" style="height: 30px;position: absolute;top: -8px;right: 10px;">
                    <p class="col" style="color:black;position: relative;top: -21px;text-align: center;">
                      <b class="" style="padding-left: 10px;padding-right: 10px;cursor: pointer;">Enganche</b>
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
                      <input type="text" class="form-control" id="CantidadAnticipoUSD" name="CantidadAnticipoUSD" placeholder="$0.00"  onkeypress="return SoloNumeros(event);" onkeyup="CalculosAnticipo()" maxlength="10" disabled required style="border-radius: 0px !important;">
                      <div class="input-group-prepend">
                        <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-8">
                    <div class="form-group">
                      <label>Monto letra</label>
                      <input type="text" class="form-control" id="letra_anticipo" name="letra_anticipo" required="" readonly="" value="{{old('letra_anticipo')}}">
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




              <div class="col-sm-4" style="">
                <label for="ComentariosAnticipo">Comentarios</label>
                <input type="text" id="ComentariosAnticipo" name="ComentariosAnticipo" value="Autorización para el movimiento" class="ComentariosPagare form-control"  placeholder="Comentarios" disabled required maxlength="8950">
              </div>

            </div>
          </div>
        </div>

        <div class="col-sm-12" style="margin-top:15px;">
          <label for="RangePagares" class="row">Número de Pagares: &nbsp;<p id="NumeroPagares"></p>  <button type="button" class="btn btn-success" onclick="MostrarAnticipo(this)" style="padding-top: 0px;padding-bottom: 0px;margin-left: 20px;"><i class="fas fa-plus"></i>&nbsp;Enganche</button> </label>
          <input type="hidden" id="NumeroPagaresInput" name="NumeroPagares" value="0">
          <input type="range" class="custom-range" id="RangePagares" min="0" max="12" value="0" oninput="GenerarPagares(this)" style="border:none;">
        </div>
        <div class="col-sm-12" style="margin-top:15px;text-align: center;">
          <label id="linea_credito">Linea de credito</label>
        </div>






      </div>
    </div>



    <!--*****************************************************************************************************************************************************************************************-->
    <div class="row" style="display:none;">
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


          <div class="col-sm-6" style="display:none">
            <div class="form-group">
              <label>Tipo de comprobante</label>
              <select class="form-control readonly" id="tipo_comprobante_compra" name="tipo_comprobante_compra" onchange="ocultar_referencia(this.value);" required="">
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
            <!--
            <div class="col-sm-6">
            <div class="form-group">
            <label>Evidencia:</label>
            <input type="file" placeholder="Evidencia de Comprobante" name="comprobante_compra" value="{{old('comprobante_compra')}}" id="comprobante_compra" class="form-control" required="" accept=".jpg,.png,.pdf">
          </div>
        </div>
      -->
    </div>
    <div class="row">
      <div class="col-sm-3" @if('?'!=1341) style="display:none;" @endif>
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
          <input class="form-control" type="text" id="input_saldo_sobrante" name="input_saldo_sobrante" value="0" autocomplete="off" onkeypress="return SoloNumeros(event);" readonly>
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

<input type="hidden" name="contacto_original_venta" value="?" id="contacto_original_venta">
<input type="hidden" id="concepto_general_venta" name="concepto_general_venta" value="{{old('concepto_general_venta')}}">
<input type="hidden" id="fecha_inicio_venta" name="fecha_inicio_venta" value="{{\Carbon\Carbon::now()}}">
<!--**************************************************************************************************************************************************************************-->
<input type="hidden" name="orden_logistica" id="orden_logistica" value="{{old('orden_logistica')}}">
<!--**************************************************************************************************************************************************************************-->


</div>



</div>
</div>
</div>


<script type="text/javascript">

var PagaresCreados = 0;
var FechaMinima = '{{\Carbon\Carbon::now()->format('Y-m-d')}}';

$("#tipo_moneda_principal option[value='?']").attr("selected",true);
$('#tipo_moneda_principal option:not(:selected)').prop('disabled', true);
$('#tipo_moneda_principal option:not(:selected)').css('display', 'none');


function GenerarPagares(input){


  while (input.value != PagaresCreados) {

    if (input.value > PagaresCreados) {
      var Logo = '{{secure_asset('public/img/logo_gran_pana.png')}}';
      var tipo_cambioOld =  '{{old('tipo_moneda_principal')}}';
      var tipo_cambioNew =  '0';
      //var tipo_Cambio = tipo_cambioOld || tipo_cambioNew;
      var tipo_Cambio = 'MXN';


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
      <b class="BTipoPagare" style="border-radius: 20px;border: solid 1px;padding-left: 10px;padding-right: 10px;cursor: pointer;" onclick="CambiarTipoPagare(`+PagaresCreados+`,this)">Físico</b>
      <input type="hidden" name="TipoPagare_`+PagaresCreados+`" value="Físico" id="TipoPagare_`+PagaresCreados+`">
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
      <input type="text" name="ComentariosPagare_`+PagaresCreados+`" value="Pagare #`+(PagaresCreados+1)+`" class="ComentariosPagare form-control" required placeholder="Comentarios">
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
      <input type="text" class="form-control PrecioPagareUSD" id="monto_pagare_`+PagaresCreados+`"  placeholder="$0.00" required onkeypress="return SoloNumeros(event);" onchange="CambiarMontoPagare(this.value,`+PagaresCreados+`)" maxlength="10" style="border-radius: 0px !important;">
      <div class="input-group-prepend">
      <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">`+tipo_Cambio+`</div>
      </div>
      </div>

      <div class="row">
      <div style="padding-left: 15px;padding-right: 10px;" class="LabelsPagare">
      <p style="color:white;">Precio letra</p>
      </div>
      <div class="col" style="position: relative;">
      <textarea name="precio_letra_pagare_`+PagaresCreados+`" id="precio_letra_pagare_`+PagaresCreados+`" value="" class="ComentariosPagare form-control"  style="font-size:12px !important;" disabled></textarea>
      </div>
      </div>

      </div>
      </div>
      </div>
      `;
      /*
      <div class="row" style="display: none;margin-top: 7px;">
      <div style="padding-left: 15px;padding-right: 22px;" class="LabelsPagare">
      <p style="color:white;">Evidencia</p>
      </div>
      <div class="col" style="position: relative;top: -8px;">
      <input type="file" name="Evidencia_`+PagaresCreados+`" id="Evidencia_`+PagaresCreados+`" value="" class="form-control" required disabled accept=".jpg,.png,.pdf">
      </div>
      </div>
      */

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

  for (var i = 0; i < PagaresCreados; i++) {
    buscar_letras("monto_pagare_"+i, "precio_letra_pagare_"+i);
  }

}

function CalculoDescuento(input){
  var Porcentaje = input.value;
  $('#NumeroDescuento').html(Porcentaje+'%')
  MontoPagares();
}

function CambiarTipoPagare(id,campo){
  if(campo.textContent == "Virtual"){
    campo.textContent = "Físico";
    $('#TipoPagare_'+id).val('Físico');
    //$('#Evidencia_'+id).prop('disabled', false);
    //$('#Evidencia_'+id).parent().parent().fadeIn();
  }else{
    campo.textContent = "Virtual";
    $('#TipoPagare_'+id).val('Virtual');
    //$('#Evidencia_'+id).prop('disabled', true);
    //$('#Evidencia_'+id).parent().parent().fadeOut()
  }

}



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

    //saldo_pendiente_venta= $("#saldo_venta").val();
    saldo_pendiente_venta= 0;
    monto_capturado_venta=$("#monto_abono_venta").val()||0;
    tipo=$("#tipo_cambio_principal").val();

    MontoPagares();

    if (operacion_venta=="suma") {
      calculo_venta=parseFloat(saldo_pendiente_venta)+ (parseFloat(monto_capturado_venta)*parseFloat(tipo));
      $("#saldo_nuevo_venta").val(calculo_venta);
      buscar_letras("saldo_nuevo_venta", "letra");
    }
    else if (operacion_venta=="resta") {
      calculo_venta=parseFloat(saldo_pendiente_venta) - (parseFloat(monto_capturado_venta)*parseFloat(tipo));
      $("#saldo_nuevo_venta").val(calculo_venta);
      buscar_letras("saldo_nuevo_venta", "letra");
    }
  }
}

function CalculosAnticipo(){
  var Abono = parseFloat($('#monto_abono_venta').val()) || 0;
  var Anticipo = parseFloat($('#CantidadAnticipoUSD').val()) || 0;


  buscar_letras("CantidadAnticipoUSD", "letra_anticipo");

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

  if(Abono >= Anticipo){
    linea_credito = Abono - Anticipo;
    $('#linea_credito').html("Linea de credito: $"+linea_credito);

  }else {
    $('#linea_credito').html("Linea de credito: 0");

  }

  MontoPagares();
}

function getFlooredFixed(v) {
  return parseFloat((Math.floor(v * Math.pow(10, 2)) / Math.pow(10, 2)).toFixed(2));
}

function MontoPagares(){
  //var TCambio = parseFloat($('#tipo_cambio_principal').val());
  var TCambio = 1;
  var Pre = $('#monto_abono_venta').val() || 0;
  if(Pre > 0){
    var PorcentejeDesc = $('#RangeDescuento').val() || 0;
    var Decuento = (Pre/100)*PorcentejeDesc;
    Pre -= Decuento;
  }

  $('#saldo_nuevo_venta').val(Pre);
  buscar_letras("saldo_nuevo_venta", "letra");
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
      buscar_letras("saldo_nuevo_venta", "letra");

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

  if($("#monto_pagare_0").val() != "" && $("#monto_pagare_0").val() != null)buscar_letras("monto_pagare_0", "precio_letra_pagare_0");
}

function CambiarMontoPagare(monto,id){

  var TCambio = parseFloat($('#tipo_cambio_principal').val());
  var Precio = parseFloat(monto) || 0;
  var AbonoTotal = parseFloat($('#monto_abono_venta').val()) || 0;
  var Anticipo = parseFloat($('#CantidadAnticipoUSD').val()) || 0;


  $('#Pagare_'+id).find('.PrecioPagareMXN').val(Precio*TCambio);
  buscar_letras("monto_pagare_"+id, "precio_letra_pagare_"+id);

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
  var m_pago_anticipo = $('#m_pago_anticipo').val();
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
    AgregarMetodoPago();
    calcularSaldoPagosMixtos(document.getElementById('monto_pago_mixto_0'),0);
    // $('#temp_comprobante').show();
    // $('#comprobante').hide();
    document.getElementById("comprobante_anticipo").innerHTML += "<option disabled>"+"Selecciona una opción"+"</option>";
    document.getElementById("comprobante_anticipo").innerHTML += "<option value='Recibo'>"+"Recibo"+"</option>";
    document.getElementById("comprobante_anticipo").innerHTML += "<option value='Recibo Automático'>"+"Recibo Automático"+"</option>";
    document.getElementById("comprobante_anticipo").innerHTML += "<option value='Notificación digital'>"+"Notificación digital"+"</option>";
    // document.getElementById("temp_comprobante").value = "Recibo";agente_emisor
  }
}

var Temporizador_VIN;
var BusquedaVinTexto = null;
var BuscandoVIN = false;

function buscar_vin_bloqueado() {
  if (BusquedaVinTexto != $("#busqueda_vin").val().trim()) {
    BusquedaVinTexto = $("#busqueda_vin").val().trim();

    if (!BuscandoVIN) {
      $('#resultadoBusquedaVin_X').html(`
        <div style="height: 100px;">
        <div class="loaderT">
        <div class="innerLoading one"></div>
        <div class="innerLoading two"></div>
        <div class="innerLoading three"></div>
        </div>
        </div>`
      );
      BuscandoVIN = true;
    }

    $('#LoadingBusquedaVIN').fadeIn();
    clearTimeout(Temporizador_VIN);
    Temporizador_VIN = setTimeout(function() {
      buscar_vin_bloqueado_Tempo();
    }, 350);
  }
}


var Temporizador_VIN_Permuta;
var BusquedaVinTexto_Permuta = null;

function buscar_vin_bloqueado_Permuta() {
  if (BusquedaVinTexto_Permuta != $("#busqueda_vin_Permuta").val().trim()) {
    BusquedaVinTexto_Permuta = $("#busqueda_vin_Permuta").val().trim();

    if (BusquedaVinTexto_Permuta.length >= 2) {
      $('#LoadingBusquedaVIN_Permuta').fadeIn();
      clearTimeout(Temporizador_VIN_Permuta);
      Temporizador_VIN_Permuta = setTimeout(function() {
        buscar_vin_bloqueado_Permuta_Tempo();
      }, 350);
    }else{
      document.getElementById('busqueda_vin_Permuta').reportValidity();
    }

  }
}

function buscar_vin_bloqueado_Permuta_Tempo() {
  var textoBusquedaVin = $("#busqueda_vin_Permuta").val().trim();

  if (textoBusquedaVin != "") {

    fetch("{{route('VPMovimientoExitoso.BuscarVIN')}}", {
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

        $("#resultadoBusquedaVin_Permuta").empty();
        $('#LoadingBusquedaVIN_Permuta').fadeOut();

        if (response.length > 0) {
          $("#resultadoBusquedaVin_Permuta").append(`<option value="" disabled selected>Seleccione una opción</option>`);
        }


        response.forEach(function logArrayElements(element, index, array) {

          $("#resultadoBusquedaVin_Permuta").append(`
            <option class="sugerencias_vin" value="` +
            (element.idinventario_trucks || element.idinventario) + `~*~` +
            element.marca + `~*~` +
            element.version + `~*~` +
            element.color + `~*~` +
            element.modelo + `~*~` +
            element.vin_numero_serie + `~*~`+
            element.precio_digital +`~*~`+
            element.tipo +`~*~`+
            element.pasa_compra_permuta +`~*~`+
            element.img +`">` +(element.tipo == "Unidad" ?  '':'' ) +'&nbsp;'+
            element.vin_numero_serie + `-` +
            element.marca + `-` +  element.color + `-` +
            element.version + `-` + element.modelo + `-` +
            `</option>`);
          });
        } else {
          //$("#resultadoBusquedaVin").html("<b>VIN NO Encontrado</b> <b>Completa los campos marcados<b>");
          $('#resultadoBusquedaVin_Permuta').empty();
        }

      });


    } else {
      $('#resultadoBusquedaVin_Permuta').empty();
    };

  }

  //---------------------------------------------------------------------------------------------------------------------------------------------
  function buscar_vin_bloqueado_Tempo() {

    var textoBusquedaVin = $("#busqueda_vin").val().trim();

    if (textoBusquedaVin != "") {

      fetch("{{route('VPMovimientoExitoso.BuscarVIN')}}", {
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
        console.error('Error:', error);
        BuscandoVIN = false;
      })
      .then(function(response) {

        //console.log(response);
        BuscandoVIN = false;
        if (response != null) {

          $("#resultadoBusquedaVin_X").empty();
          $('#LoadingBusquedaVIN').fadeOut();
          $("#marca_venta").attr("readonly", "readonly");
          $("#version_venta").attr("readonly", "readonly");
          $("#color_venta").attr("readonly", "readonly");
          $("#modelo_venta").attr("readonly", "readonly");
          $("#vin_venta").attr("readonly", "readonly");


          if (response.length == 0) {

            document.getElementById("resultadoBusquedaVin_X").innerHTML +=
            `<div class="content-op-busqueda" >
              <p class="opcion">
                <b>VIN NO Encontrado</b> <b>Completa los campos marcados<b>
              </p>
            </div>`;
          }


          var DivResultado = document.getElementById("resultadoBusquedaVin_X");
          response.forEach(function logArrayElements(element, index, array) {

            DivResultado.innerHTML +=
            `<div class="content-op-busqueda" onclick="SugerenciaVIN('` +
            (element.idinventario_trucks || element.idinventario) + `~*~` +
            element.marca + `~*~` +
            element.version + `~*~` +
            element.color + `~*~` +
            element.modelo + `~*~` +
            element.vin_numero_serie + `~*~`+
            element.precio_digital +`~*~`+
            element.tipo +`~*~`+
            element.pasa_compra_permuta +`~*~`+
            element.img +`',this)">
              <p class="opcion" style="font-family: 'FontAwesome';`+(element.pasa_compra_permuta  == "NO" ? 'color:red;':'')+`">
              ` +(element.tipo == "Unidad" ?  '':'' ) +'&nbsp;'+
              element.vin_numero_serie + `-` +
              element.marca + `-` +  element.color + `-` +
              element.version + `-` + element.modelo + `-` +
              `</p>
            </div>`;

            /*$("#resultadoBusquedaVin_X").append(`
              <option class="sugerencias_vin" `
              +(  element.pasa_compra_permuta  == "NO" ? 'style="color:red;"':'')
              +`value="` +
              (element.idinventario_trucks || element.idinventario) + `~*~` +
              element.marca + `~*~` +
              element.version + `~*~` +
              element.color + `~*~` +
              element.modelo + `~*~` +
              element.vin_numero_serie + `~*~`+
              element.precio_digital +`~*~`+
              element.tipo +`~*~`+
              element.pasa_compra_permuta +`~*~`+
              element.img +`">` +(element.tipo == "Unidad" ?  '':'' ) +'&nbsp;'+
              element.vin_numero_serie + `-` +
              element.marca + `-` +  element.color + `-` +
              element.version + `-` + element.modelo + `-` +
              `</option>`);*/
            });
          } else {
            //$("#resultadoBusquedaVin").html("<b>VIN NO Encontrado</b> <b>Completa los campos marcados<b>");
            $('#resultadoBusquedaVin_X').empty();
            $("#marca_venta").val("").removeAttr("readonly").css("border-color", "#A0213C").focus();
            $("#modelo_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#color_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#version_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#vin_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#orden_logistica").val("SI");
          }

        });


      } else {
        //$("#resultadoBusquedaVin").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
        $('#resultadoBusquedaVin_X').empty();
      };
    }


    function SugerenciaVIN(DatosRecibidos,div){

      $('.Seleccion_VIN').removeClass('SeleccionLista');
      $(div).addClass('SeleccionLista Seleccion_VIN');

      var Datos = DatosRecibidos.split('~*~');

      console.log(Datos);


      var idInventario = Datos[0];
      var unidad_marca = Datos[1];
      var unidad_version = Datos[2];
      var unidad_color = Datos[3];
      var unidad_modelo = Datos[4];
      var textoBusquedaVin = Datos[5];
      var precioPiso = parseFloat(Datos[6]);
      var tipo = Datos[7];
      var pasa_compra_permuta = Datos[8];

      $('#DivPrecioSinDescuento').fadeIn();
      $('#BotonesMostrarDescuento').fadeIn();

      $('#tipo_unidad').val(tipo);


      if (pasa_compra_permuta == 'NO') {


        iziToast.warning({
          title: 'Atención',
          message: 'El VIN seleccionado contiene inconsistencia de ingreso.!',
        });

        /*$('#monto_abono_venta').val('');
        $('#PrecioPisoDescuento').val('');
        $("#marca_venta").val('');
        $("#modelo_venta").val('');
        $("#version_venta").val('');
        $("#color_venta").val('');
        $("#vin_venta").val('');

        $('#nextBtn').prop('disabled',true);*/

      }


      var Cantidad_Minima = parseFloat(precioPiso - ((precioPiso/100)*15));

      if (Cantidad_Minima == 0) {

        iziToast.warning({
          title: 'Atencion',
          message: 'La unidad no cuenta con un precio establecido, <br>comunicarse con el area correspondiente',
          position: 'center',
          overlay: true,
          transitionIn: 'flipInX',
          transitionOut: 'flipOutX',
        });

        $('#MontoConDescuento').attr('min', 0);
        //$('#MontoConDescuento').attr('max',precioPiso);
        $('#MontoConDescuento').val('');
        $('#MontoConDescuento').addClass('readonly');
      }else{
        $('#MontoConDescuento').attr('min', Cantidad_Minima);
        //$('#MontoConDescuento').attr('max',precioPiso);
        $('#MontoConDescuento').val(precioPiso);
        $('#MontoConDescuento').removeClass('readonly');
      }



      $('#MontoSinDescuento').val(precioPiso);
      $('#saldo_nuevo_venta').val(precioPiso);
      $('#td-precio-digital').html(precioPiso);
      $('#monto_abono_venta').val(precioPiso);
      $('#PrecioPisoDescuento').val(precioPiso);

      buscar_letras("MontoSinDescuento", "MontoSinDescuentoLetra");
      buscar_letras("MontoConDescuento", "MontoConDescuentoLetra");

      $("#marca_venta").val(unidad_marca);
      $("#modelo_venta").val(unidad_modelo);
      $("#version_venta").val(unidad_version);
      $("#color_venta").val(unidad_color);
      $("#vin_venta").val(textoBusquedaVin);

      $("#td-marca").html(unidad_marca);
      $("#td-modelo").html(unidad_modelo);
      $("#td-version").html(unidad_version);
      $("#td-color").html(unidad_color);
      $("#td-vin-numero-serie").html(textoBusquedaVin);
      $("#linea_credito").html("Linea de credito: $ "+precioPiso);


      $('#nextBtn').prop('disabled',false);

      MontoPagares();
      // nextPrev(1);
      buscar_letras("saldo_nuevo_venta", "letra");



    }

    var idbusquedaContacto = 'N/A';
    var idBusquedaInventario = null;





    $("#vin_venta").keyup(function() {
      var vin = $(this).val();

      if (vin.length >= 16) {
        document.getElementById('vin_venta').setCustomValidity("Buscando VIN");
        document.getElementById('n_referencia_venta').setCustomValidity("Buscando VIN");
        document.getElementById('n_referencia_anticipo').setCustomValidity("Buscando VIN");
        $("#respuestaVIN").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>');
        $("#respuesta_referecia_venta").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>');
        $("#respuesta_referecia_anticipo").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>');
        $('#BtnReferenciaAnticipo').fadeOut();

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
            idCliente: idbusquedaContacto,
            valorBusqueda : vin
          })
        }).then(res => res.json())
        .catch(function(error){
          console.error('Error:', error);
          $("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
          $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
          $("#respuesta_referecia_anticipo").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
        })
        .then(function(mensaje_vin_bloqueado){

          console.log(mensaje_vin_bloqueado);

          if (mensaje_vin_bloqueado == 3 || mensaje_vin_bloqueado == 2 ) { //El vin aparece como pendiente en el estado de cuenta general || //El vin aparece activo en el inventario

            iziToast.error({
              title: 'Atención',
              message: mensaje_vin_bloqueado == 3 ? 'El VIN se encontró como Pendiente de otro cliente' : 'El VIN se encontró activo en el Inventario',
              position: 'topRight'
            });

            $('.DatosVIN').val('');

            $("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;"></i>');
            $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;"></i>');
            $("#respuesta_referecia_anticipo").html('<i class="fas fa-times-circle" style="color: red;"></i>');

          }else if(mensaje_vin_bloqueado == 0 || mensaje_vin_bloqueado == 1 ||  mensaje_vin_bloqueado == 4 || mensaje_vin_bloqueado == 5){
            // 0 El VIN se puede recibir
            // 1 El vin ya fue ingresado en una orden logistica
            // 4 El VIN esta Pendiente con el cliente y no aparece en nada mas
            // 5 El VIN esta Pagado con el cliente y no aparece en nada mas
            //---------------------------------------------------------------
            document.getElementById('vin_venta').setCustomValidity("");
            $("#respuestaVIN").html('<i class="fas fa-check-circle" style="color:green;"></i>');
            var Referencia_VIN = $('#emisor_venta').val()+"_"+vin;
            BuscarVIN(Referencia_VIN,1);

            if (mensaje_vin_bloqueado == 1) {
              iziToast.warning({
                title: 'Atención',
                message: 'El VIN se encontró activo en una Orden de Logistica',
                position: 'topRight'
              });
              $("#orden_logistica").val("NO");
            }else{
              $("#orden_logistica").val("SI");
            }
            //---------------------------------------------------------------
          }else if(mensaje_vin_bloqueado = 'NO'){
            $("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;">No disponible</i>');
            $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;"></i>');
            $("#respuesta_referecia_anticipo").html('<i class="fas fa-times-circle" style="color: red;"></i>');
          }else{
            document.getElementById('vin_venta').setCustomValidity("Error");
            document.getElementById('n_referencia_venta').setCustomValidity("Error");
            document.getElementById('n_referencia_anticipo').setCustomValidity("Error");
            $("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
            $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
            $("#respuesta_referecia_anticipo").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
          }

        });

      }else{ //No tiene la longitud requerida
        $("#respuestaVIN").html('...');
        $("#respuesta_referecia_venta").html('...');
        $("#respuesta_referecia_anticipo").html('...');
        document.getElementById('vin_venta').setCustomValidity("Se requieren al menos 16 caracteres");
        document.getElementById('n_referencia_venta').setCustomValidity("Se requieren al menos 16 caracteres");
        document.getElementById('n_referencia_anticipo').setCustomValidity("Se requieren al menos 16 caracteres");
        $('#BtnReferenciaAnticipo').fadeOut();
      }
    });

    function BuscarVIN(Referencia,Formulario,ReferenciaKeyUp = false){

      if (Formulario == 1) {
        $("#respuesta_referecia_venta").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>Buscando Referencia');
        document.getElementById('n_referencia_venta').value = Referencia;
        if (!ReferenciaKeyUp) {
          $('#BtnReferenciaAnticipo').fadeOut();
        }
      }else if (Formulario == 2) {
        $("#respuesta_referecia").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>Buscando Referencia');
        document.getElementById('n_referencia').value = Referencia;
      }else{
        $("#respuesta_referecia_anticipo").html('<i class="fas fa-spinner fa-spin" style="position: initial;color:green;"></i>');
        document.getElementById('n_referencia_anticipo').value = Referencia;
        $('#BtnReferenciaAnticipo').fadeOut();
      }


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
          ref : Referencia,
          tabla : Formulario == 1 ? 'ECP':'APP'
        })
      }).then(res => res.json())
      .catch(function(error) {
        console.error('Error:', error);

        if (Formulario == 1) {
          $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
        }else if (Formulario == 2) {
          $("#respuesta_referecia").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
        }else{
          $("#respuesta_referecia_anticipo").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
          $('#BtnReferenciaAnticipo').fadeIn();
        }

      })
      .then(function(response) {

        console.log(response);

        if ( (response == "Abono" || response == "Cargo") && Formulario == 1) {

          $("#respuesta_referecia_venta").html('<i class="fas fa-check-circle" style="color:#f5891a;">Cargo con referencia existente </i>');
          document.getElementById('n_referencia_venta').setCustomValidity("Ref. Duplicada en "+response);

          if (!ReferenciaKeyUp) {
            $("#respuesta_referecia_anticipo").html('<i class="fas fa-check-circle" style="color:#f5891a;">Cargo con referencia existente </i>');
            document.getElementById('n_referencia_anticipo').setCustomValidity("Ref. Duplicada "+response);
          }

        } else if (response == "SI") {

          if (Formulario == 1) {
            SetValidInput('respuesta_referecia_venta','','n_referencia_venta',null,true);
            if (!ReferenciaKeyUp) {
              generateReferenceAnticipo();
            }
          }else if (Formulario == 2) {
            SetValidInput('respuesta_referecia','','n_referencia',null,true);
          }else{
            SetValidInput('respuesta_referecia_anticipo','','n_referencia_anticipo',null,true);
            $('#BtnReferenciaAnticipo').fadeIn();
          }

        }else{

          if (Formulario == 1) {
            SetValidInput('respuesta_referecia_venta','Intente denuevo','n_referencia_venta','Ocurrio un error',false);
            if (!ReferenciaKeyUp) {
              SetValidInput('respuesta_referecia_anticipo','Intente denuevo','n_referencia_anticipo','Ocurrio un error',false);
            }
          }else if (Formulario == 2) {
            SetValidInput('respuesta_referecia','Intente denuevo','n_referencia','Ocurrio un error',false);
          }else{
            SetValidInput('respuesta_referecia_anticipo','Intente denuevo','n_referencia_anticipo','Ocurrio un error',false);
            $('#BtnReferenciaAnticipo').fadeIn();
          }

        }

      });
    }


    function SetValidInput(Label_respuesta,Mensaje_Label,Input_respuesta,Mensaje_Input,estado){
      if (estado) {
        $("#"+Label_respuesta).html('<i class="fas fa-check-circle" style="color:green;">'+Mensaje_Label+'</i>');
        document.getElementById(Input_respuesta).setCustomValidity("");
      }else{
        $("#"+Label_respuesta).html('<i class="fas fa-times-circle" style="color: red;">'+Mensaje_Label+'</i>');
        document.getElementById(Input_respuesta).setCustomValidity(Mensaje_Input);
      }
    }

    $(document).on('keydown paste focus mousedown', '.readonly', function (e) {
      e.preventDefault();
    });

    function SeleccionSelect(id,val,estado){
      if (estado) {
        $("#"+id+" option[value='"+val+"']").attr("selected",true);
        $('#'+id+' option:not(:selected)').prop('disabled', true);
        $('#'+id+' option:not(:selected)').css('display', 'none');
      }else{
        $('#'+id+' option:not(:selected)').prop('disabled', false);
        $('#'+id+' option:not(:selected)').css('display', 'block');
      }
    }


    function buscar_letras(inputNum, Destino) {

      var numero = $("#" + inputNum).val();
      var tipo_cambio = 'MXN';

      if (numero != "") {

        var label = $('#' + Destino).parent().find('label');
        label.html('Precio Letra <i class="fas fa-spinner fa-spin" style="position: initial;"></i>');

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
          label.html('Precio Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
        })
        .then(function(response) {

          if (response.info == null) {
            iziToast.error({
              title: 'Error',
              message: 'Error al obtener la cantidad en letras',
            });
            label.html('Precio Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
            $('#' + Destino).val('');
          } else {
            $('#' + Destino).val(response.info);
            label.html('Precio Letra');
          }

        });
      }
    }


    var PagosExtra = 0;

    var opciones
    function AgregarMetodoPago(){

      $('#metodos_pago_mixto').append(`

        <div class="row">
        <div class="col-sm-4">
        <label for="metodo_pago">Metodo de pago `+(PagosExtra+1)+`</label>
        <select class="form-control" id="metodo_pago_mixto_`+(PagosExtra)+`" name="metodo_pago_mixto_`+(PagosExtra)+`" onchange="" required>
        ` +(PagosExtra == 0 ? `
          <option value="Efectivo">Efectivo</option>
          <option value="Transferencia">Transferencia</option>
          `:`
          <option value="Transferencia">Transferencia</option>
          `)+`
          </select>
          </div>

          <div class="col-sm-4">
          <div class="form-group">
          <label>Monto `+(PagosExtra+1)+`</label>
          <div class="input-group mb-2">
          <div class="input-group-prepend">
          <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
          </div>
          <input class="form-control montos-pagos-mixtos" type="text" id="monto_pago_mixto_`+(PagosExtra)+`" name="monto_pago_mixto_`+(PagosExtra)+`" onkeyup="calcularSaldoPagosMixtos(this,`+(PagosExtra)+`)" required value="0" style="border-radius: 0px !important;">
          <div class="input-group-prepend">
          <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px">
          MXN
          </div>
          </div>
          </div>
          </div>
          </div>

          <div class="col-sm-4">
          <div class="form-group">
          <label>Saldo</label>
          <div class="input-group mb-2">
          <div class="input-group-prepend">
          <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
          </div>
          <input class="form-control" type="text" id="saldo_pago_mixto_`+(PagosExtra)+`" name="saldo_pago_mixto_`+(PagosExtra)+`" value="0" required style="border-radius: 0px !important;" readonly>
          <div class="input-group-prepend">
          <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px">
          MXN
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>

          `);
          if (PagosExtra >= 2) {
            $('#BtnEliminarPago').fadeIn(function(){
              $('#BtnAgregarPago').fadeOut();
            });
          }
          PagosExtra++;
          $('#NumPagos').val(PagosExtra);
        }

        function EliminarMetodoPago(){
          $('#metodos_pago_mixto').children().last().remove();

          if (PagosExtra <= 2) {
            $('#BtnEliminarPago').fadeOut(function(){
              $('#BtnAgregarPago').fadeIn();
            });
          }

          PagosExtra--;
          $('#NumPagos').val(PagosExtra);
        }


        function calcularSaldoPagosMixtos(input, id){
          obj = $(".montos-pagos-mixtos");
          saldo = $('#saldo_nuevo_venta').val();

          if(PagosExtra == 1){
            $('#saldo_pago_mixto_0').val(0);
            $('#monto_pago_mixto_0').val(saldo);
          }
          if(PagosExtra == 2){
            monto = $('#monto_pago_mixto_0').val();
            if(monto <= saldo){
                saldo = saldo - monto;
                $('#saldo_pago_mixto_0').val(saldo);
                $('#monto_pago_mixto_1').val(saldo);
                temp_saldo = saldo;
                saldo = saldo - temp_saldo;
                $('#saldo_pago_mixto_1').val(saldo);
            }else {
                $('#monto_pago_mixto_0').val(saldo);
                $('#saldo_pago_mixto_0').val(0);
                $('#monto_pago_mixto_1').val(0);
                $('#saldo_pago_mixto_1').val(0);
            }

          }
          if(PagosExtra == 3){
            // monto = $('#monto_pago_mixto_0').val();
            // saldo = saldo - monto;
            //
            // monto2 = $('#monto_pago_mixto_1').val();
            // if(monto2 == 0){
            //   $('#monto_pago_mixto_1').val(saldo);
            //   temp_saldo = saldo;
            //   saldo = saldo - temp_saldo;
            //   $('#saldo_pago_mixto_1').val(saldo);
            // }else {
            //   saldo = saldo - monto2;
            //   $('#saldo_pago_mixto_1').val(saldo);
            // }
            // if(saldo > 0){
            //   monto3 = $('#monto_pago_mixto_2').val();
            //   if(monto3 == 0){
            //     $('#monto_pago_mixto_2').val(saldo);
            //     temp_saldo = saldo;
            //     saldo = saldo - temp_saldo;
            //     $('#saldo_pago_mixto_2').val(saldo);
            //   }else {
            //     saldo = saldo - monto3;
            //     $('#saldo_pago_mixto_2').val(saldo);
            //   }
            // }
            if(id == 0){
                monto = $('#monto_pago_mixto_0').val();
                saldo = saldo - monto;
                $('#saldo_pago_mixto_0').val(saldo);

                pago_2 = ( saldo /2 );
                pago_2 = pago_2.toFixed(2);
                $('#monto_pago_mixto_1').val(pago_2);
                saldo = (saldo - pago_2);
                saldo = saldo.toFixed(2);
                $('#saldo_pago_mixto_1').val(saldo);

                pago_3 = (saldo - pago_2);
                pago_3= pago_3.toFixed(2);
                $('#saldo_pago_mixto_2').val(pago_3);

                saldo = (saldo - pago_3);
                saldo = saldo.toFixed(2);
                $('#monto_pago_mixto_2').val(saldo);
            }

          }


        }

        $(document).ready(function(){

          $("#metodo_pago").click(function(){
            if($('#metodo_pago').val() == "Por definir"){
              $('#buttons-add-pago').addClass('display-none');
              $('#metodos_pago_mixto').empty();
              PagosExtra = 0;
            }else {
              $('#buttons-add-pago').removeClass('display-none');

            }
          });

        });



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
