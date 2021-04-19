@extends('layouts.appAdmin')
@section('titulo', 'Agregar traspaso')
@section('content')

  <style media="screen">
    #select2-search_contact-container{
      font-size: 17px;
    }
    #select2-search_contact-results > li{
      color: #161714;
      font-size: 17px;
    }
  </style>
  <div class="row mt-3">
    <div class="col-sm-12">
      <form enctype="multipart/form-data" class="needs-validation" action="{{route('transfer.store')}}" method="post" id='mi_formulario'>
        @csrf
        <div class="shadow panel-head-primary" style="padding: 20px;">
          <h6 class="text-center mt-3 mb-3"><strong>Nuevo traspaso</strong></h6>
          <div class="table-responsive">
            <div class="container">
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                  <label for="type_person">Institución emisora</label>
                  <select class="form-control form-control-sm" id="bank_emisor" name="bank_emisor" required>
                    <option disabled>Selecciona una opción</option>
                    @foreach ($banks_emisor as $bank_emisor)
                      <option value="{{$bank_emisor->nombre}}">{{$bank_emisor->nombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                  <label for="type_person">Agente Emisor</label>
                  <select class="form-control form-control-sm" id="treasury_catalog" name="treasury_catalog" required>
                    <option disabled>Selecciona una opción</option>
                    @foreach ($treasuries_catalog as $treasury_catalog)
                      <option value="{{$treasury_catalog->nomeclatura}}">{{$treasury_catalog->nomeclatura}} - {{$treasury_catalog->nombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-top:30px">
                  <label for="search_contact">Buscar Receptor</label>
                  <select class="form-control js-example-basic-single" style="width: 100%" id='search_contact' name="search_provider_client" required>
                    <option disabled>Escribe para buscar proveedor...</option>
                  </select>
                  <div class="invalid-feedback">Busca un receptor para continuar</div>
                  <div class="valid-feedback">Receptor valido</div>
                  <input type="hidden" name="id_agent_emisor" id='id_agent_emisor'>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="margin-top:30px">
                  <label>Institución receptora:</label>
                  <input type="hidden" class="form-control form-control-sm" id="institution_receptor" name="institution_receptor" required>
                  <span id='institution_receptor_span'></span>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="margin-top:30px">
                  <label>Agente receptor:</label>
                  <span id='agent_receptor_span'></span>
                  <input type="hidden" class="form-control form-control-sm" id="agent_receptor" name="agent_receptor"  required>
                  <input type="hidden" class="form-control form-control-sm" id="agent_nomenclatura" name="agent_nomenclatura"  required>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Tipo</label>
                  <select class="form-control form-control-sm" id="type_movement" name="type_movement" required>
                    <option value="abono">Abono</option>
                  </select>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Efecto</label>
                  <select class="form-control form-control-sm" id="efect" name="efect" required>
                    <option value="resta">Negativo</option>
                  </select>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Fecha</label>
                  <input type="date" class="form-control form-control-sm" id="date" name="date" value='{{\Carbon\Carbon::now()->format('Y-m-d')}}' required>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Método de pago</label>
                  <select class="form-control form-control-sm" id="type_payment" name="type_payment" required>
                    @foreach ($types_payment as $type_payment)
                      <option value="{{$type_payment->idcatalogo_metodos_pago}}">{{$type_payment->nombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Tipo de Moneda</label>
                  <select class="form-control form-control-sm" id="tipo_moneda" name="tipo_moneda" onchange="typeChange()" required>
                    <option value="" disabled>Elige una opción…</option>
                    <option value="MXN">MXN</option>
                    <option value="USD">USD</option>
                    <option value="CAD">CAD</option>
                  </select>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Tipo de cambio</label>
                  <input type="text" class="form-control form-control-sm" id="type_change" name="type_change" value='1.00' disabled>
                  <input type="hidden" class="form-control form-control-sm" id="type_change_hid" name="type_change_hid" value='1.00'>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Saldo</label>
                  <input type="text" class="form-control form-control-sm" id="earnings" name="earnings" value='{{number_format($saldo, 2, '.', '')}}' disabled>
                  <input type="hidden" class="form-control form-control-sm" id="earnings_hid" name="earnings_hid" value='{{number_format($saldo, 2, '.', '')}}'>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Monto</label>
                  <input type="text" class="form-control form-control-sm" id="quantity" name="quantity" value='0' onkeyup="updateNewSaldo()" required>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Nuevo saldo</label>
                  <input type="text" class="form-control form-control-sm" id="new_earnings" name="new_earnings" value='{{number_format($saldo, 2, '.', '')}}' disabled>
                  <input type="hidden" class="form-control form-control-sm" id="new_earnings_hid" name="new_earnings_hid" value='{{number_format($saldo, 2, '.', '')}}'>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-top:30px">
                  <label>Monto Letra</label>
                  <input type="text" class="form-control form-control-sm" id="quantity_letter" name="quantity_letter" value='CERO CON 00/100 MXN' required>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Tipo de Comprobante</label>
                  <select class="form-control form-control-sm" id="type_ticket" name="type_ticket" required>
                    <option value="" disabled>Elige una opción…</option>
                    @foreach ($type_tickets as $type_ticket)
                      <option value="{{$type_ticket->nombre}}">{{$type_ticket->nombre}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label id='label_reference'>Número de referencia: </label>
                  <input type="text" class="form-control form-control-sm" id="reference" name="reference" onkeyup="validateReference()" onclick="validateReference()" onchange="validateReference()" minlength="6" maxlength="6" required>
                  <div class="invalid-feedback" id='reference_feed'>Teléfono ya ocupado</div>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="margin-top:30px">
                  <label>Evidencia</label>
                  <input class="form-control" type="file" name='evidence' required>
                  {{-- <h1>{{\Carbon\Carbon::now()->format('d/m/Y')}}</h1> --}}
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-top:30px">
                  <label for="exampleFormControlTextarea1">Comentarios</label>
                  <textarea class="form-control" id="comments" name="comments" rows="3" required></textarea>
                  <div class="valid-feedback">Comentario valido</div>
                  <div class="invalid-feedback">Ingresa un comentario respecto al traspaso</div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-top:30px" align='center'>
                  <input type="hidden" name="provider" value='{{$id}}'>
                  <input type="hidden" name="date_created" value='{{\Carbon\Carbon::now()}}'>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  @include('admin.partials.transfer.js_general')
@endsection
