@extends('layouts.appAdmin')
@section('titulo', 'Salida de tracktocamiones de taller')
@section('content')
  <style media="screen">
  input[type='range'] {
    display: block;
    /* width: 250px; */
  }

  input[type='range']:focus {
    outline: none;
  }

  input[type='range'],
  input[type='range']::-webkit-slider-runnable-track,
  input[type='range']::-webkit-slider-thumb {
    -webkit-appearance: none;
  }

  input[type=range]::-webkit-slider-thumb {
    background-color: #777;
    width: 20px;
    height: 20px;
    border: 3px solid #333;
    border-radius: 50%;
    margin-top: -9px;
  }

  input[type=range]::-moz-range-thumb {
    background-color: #777;
    width: 15px;
    height: 15px;
    border: 3px solid #333;
    border-radius: 50%;
  }

  input[type=range]::-ms-thumb {
    background-color: #777;
    width: 20px;
    height: 20px;
    border: 3px solid #333;
    border-radius: 50%;
  }

  input[type=range]::-webkit-slider-runnable-track {
    background-color: #777;
    height: 3px;
  }

  input[type=range]:focus::-webkit-slider-runnable-track {
    outline: none;
  }

  input[type=range]::-moz-range-track {
    background-color: #777;
    height: 3px;
  }

  input[type=range]::-ms-track {
    background-color: #777;
    height: 3px;
  }

  input[type=range]::-ms-fill-lower {
    background-color: HotPink
  }

  input[type=range]::-ms-fill-upper {
    background-color: black;
  }
}
</style>
<div class="row mt-3">
  <div class="col-sm-12">
    <div class="shadow panel-head-primary">
      <div class="container" style="padding-bottom: 50px; padding-top: 50px;">
        {{-- <center><h4>Nueva revisión</h4></center> --}}
        <form action="{{route('taller_trackto.checks.store')}}" method="post">
          @csrf
          <input type="hidden" name="id_solicitud_taller_trucks" value="{{$solicitud_taller_trucks->id}}">
          <div class="row" style="margin-left: 10%; margin-right: 10%;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-header" align='center'>
                  Nueva revisión
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                      <center><h6><b>Datos unidad</b> </h6></center>
                      <p><b>VIN </b>{{$inventario_trucks->vin_numero_serie}}</p>
                      <p><b>Marca </b> {{$inventario_trucks->marca}}</p>
                      <p><b>Version </b> {{$inventario_trucks->version}}</p>
                      <p><b>Color </b> {{$inventario_trucks->color}}</p>
                      <p><b>Modelo </b> {{$inventario_trucks->modelo}}</p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                      <center><h6><b>Datos de actividad</b> </h6></center>
                      <p><b>Responsable </b> {{$empleados->nombre}} {{$empleados->apellido_paterno}} {{$empleados->apellido_materno}}</p>
                      <p><b>Actividad </b> {{$solicitud_taller_trucks->descripcion}}</p>
                      <p><b>Piezas solicitadas </b>
                        @php $max = $solicitud_piezas_trucks->count() @endphp
                        @foreach ($solicitud_piezas_trucks as $key => $solicitud_pieza)
                          @if ($max>($key+1)) {{$solicitud_pieza->concepto.', '}}
                          @else {{$solicitud_pieza->concepto}} @endif
                        @endforeach
                      </p>
                      <p><b>Fecha estimada de entrega</b> {{\Carbon\Carbon::parse($solicitud_taller_trucks->fecha_estimada)->format('d-m-Y')}}</p>
                      <p><b>Prioridad</b> {{$solicitud_taller_trucks->prioridad}}</p>
                      @if ($desempeno>0)
                        <p><b>Nivel de aprobación</b> {{$desempeno}}%</p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><br>
              <label for="customRange1">Evaluar desempeño actual de la tarea</label>
              <select class="form-control" name="work">
                <option value="4">Excelente</option>
                <option value="3">Bueno</option>
                <option value="2">Regular</option>
                <option value="1">Deficiente</option>
              </select>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label for="customRange1">Porcentaje de avance observado</label>
              @if ($revision_reparacion_trucks->count()>0)
                <input style="width:100%" type="range" class="custom-range" min="{{$revision_reparacion_trucks->first()->avance}}" max="100" name="percent_range" value='{{$revision_reparacion_trucks->first()->avance}}' id="percent_range" oninput="this.className = ''">
                <small id="percent">Avance: {{$revision_reparacion_trucks->first()->avance}}%</small><br>
              @else
                <input style="width:100%" type="range" class="custom-range" min="0" max="100" name="percent_range" value='0' id="percent_range" oninput="this.className = ''">
                <small id="percent">Avance: 0%</small><br>
              @endif
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <label for="exampleFormControlTextarea1">Obsevaciones</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="" rows="2" name="comments"></textarea>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" align='center' style="margin-top:10px; margin-bottom:10px;">
              <input style="display:none;" type="dateTime" name="date_start" value="{{\Carbon\Carbon::now()}}">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </form>
        <center><h4>Historial revisiones</h4></center>
        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaVencidos">
          <thead>
            <tr>
              <th>#</th>
              <th>Avance</th>
              <th>Observaciones</th>
              <th>Fecha de revisión</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($revision_reparacion_trucks as $key => $revision_reparacion_truck)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$revision_reparacion_truck->avance}}</td>
                <td>{{$revision_reparacion_truck->observaciones}}</td>
                <td>{{\Carbon\Carbon::parse($revision_reparacion_truck->fecha_guardado)->format('d-m-Y')}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $('#percent_range').change(function() {
    let percent_range = $("#percent_range").val();
    document.getElementById('percent').innerHTML = 'Avance: '+percent_range+'%';
  });
  $('#percent_range').mousemove(function() {
    let percent_range = $("#percent_range").val();
    document.getElementById('percent').innerHTML = 'Avance: '+percent_range+'%';
  });

});

</script>
@endsection
