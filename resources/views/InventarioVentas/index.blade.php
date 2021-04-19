@extends('layouts.appAdmin')
@section('titulo', 'CCP | Pagares')

@section('js')
  <script src="{{secure_asset('public/js/jquery.sparkline.min.js.gz')}}"></script>

  <script type="text/javascript">
  CrearGraficaBarras('incomeBar',[
    @foreach ($Inventario as $key => $Vehiculo)
    {{($Vehiculo->Total*100).','}}
    @endforeach
    @foreach ($InventarioTrucks as $key => $Vehiculo)
    {{($Vehiculo->Total*100).','}}
    @endforeach
  ],'#23649e');
  CrearGraficaBarras('expensesBar',[
    @foreach ($Inventario as $key => $Vehiculo)
    {{($Vehiculo->Total*100).','}}
    @endforeach
  ],'#ea5941');
  CrearGraficaBarras('profitBar',[
    @foreach ($InventarioTrucks as $key => $Vehiculo)
    {{($Vehiculo->Total*100).','}}
    @endforeach
  ],'#1d915d');

  </script>

@endsection

@section('content')


  <style media="screen">

  .container {
    padding-left: 0px !important;
  }

  tr > td {
    text-align: center;
  }
  </style>






  <div class="container">
    <div class="row">

      <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
        <div class="bg-white border shadow">
          <div class="p-2 text-center">
            <h5 class="mb-0 mt-2 text-theme"><small><strong>Inventario Total</strong></small></h5>
            <h1>{{$Inventario->sum('Total')+$InventarioTrucks->sum('Total')}}</h1>
          </div>
          <div class="align-bottom">
            <span id="incomeBar"></span>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
        <div class="bg-white border shadow">
          <div class="p-2 text-center">
            <a href="inventario_check.php?ma=" class="">
              <h5 class="mb-0 mt-2 text-danger"><small><strong>Unidades</strong></small></h5>
              <h1>{{$Inventario->sum('Total')}}</h1>
            </a>
          </div>
          <div class="align-bottom">
            <span id="expensesBar"></span>
          </div>
        </div>
      </div>


      <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
        <div class="bg-white border shadow">
          <div class="p-2 text-center">
            <a href="inventario_check_trucks.php?ma=" class="">

              <h5 class="mb-0 mt-2 text-green"><small><strong>Tractocamiones</strong></small></h5>
              <h1>{{$InventarioTrucks->sum('Total')}}</h1>
            </a>
          </div>
          <div class="align-bottom">
            <span id="profitBar"></span>
          </div>
        </div>
      </div>

    </div>


    <div class="row">
      @foreach ($Inventario as $key => $Vehiculo)
        <div class="col-sm-4 custom-card">
          <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
            <div class="text-center mb-3">
              <h1>{{$Vehiculo->marca}}</h1>
              <h2>{{$Vehiculo->Total}}</h2>
            </div>
            <center><a href="{{route('Inv_Ventas.check',[Crypt::encrypt($Vehiculo->marca),'0'])}}">
              <img onerror="SinImagen(this)" src="{{secure_asset('storage/app/logos_marcas/unidades/'.str_replace(" ", "", strtolower($Vehiculo->marca)).'.png')}}" alt="" style="width:50%; height:50%; margin:0 auto;" > </a>
            </center>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      @foreach ($InventarioTrucks as $key => $Vehiculo)
        <div class="col-sm-4 custom-card">
          <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
            <div class="text-center mb-3">
              <h1>{{$Vehiculo->marca}}</h1>
              <h2>{{$Vehiculo->Total}}</h2>
            </div>
            <center><a href="{{route('Inv_Ventas_Trucks.check',[Crypt::encrypt($Vehiculo->marca),'1'])}}">
              <img onerror="SinImagen(this)" src="{{secure_asset('storage/app/logos_marcas/trucks/'.str_replace(" ", "", strtolower($Vehiculo->marca)).'.png')}}" alt="" style="width:50%; height:50%; margin:0 auto;" > </a>
            </center>
          </div>
        </div>
      @endforeach
    </div>

  </div>

  <script type="text/javascript">

  function SinImagen(img){
    img.src = '{{secure_asset('storage/app/logos_marcas/unidades/sports-car.png')}}';
  }




  function CrearGraficaBarras(id,Valores,color){
    $('#'+id).sparkline(Valores, {
      type: 'bar',
      barColor: [color],
      barWidth: '7px',
      height: '60px',
      disableTooltips: true,
    });
  }
  </script>

@endsection
