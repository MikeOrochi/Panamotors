@extends('layouts.appAdmin')
@section('titulo', 'CCP | Detalles')


@section('head')
  <link rel="stylesheet" href="{{secure_asset('public/css/slick.css')}}">
  <link rel="stylesheet" href="{{secure_asset('public/css/slick-theme.css')}}">
  <link rel="stylesheet" href="{{secure_asset('public/css/fontawesome-stars.css')}}">

  <style>

  .tabla-1 {
    width: 100%;
    font-size: 11px;
    aling:center;
    background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png);
    background-repeat: no-repeat;
    background-position: center;
    border-collapse: none;
  }

  .tabla-1 td {
    //border: 1px solid #dddddd;
    text-align: center;
    //text-align: center;
  }
  .tabla-1 tr td{
    //border: 7px solid #fff;
  }

  .tabla-1 th {
    font-size: 14px;

    text-align: center;
  }
  .tabla-1 tr th{
    //background: linear-gradient(0deg,#c3c7cc,#ffffff,#c3c7cc);
    color: #131313;
  }

  .tabla-1 tr:nth-child(even) {
    padding: 0px;
    text-align: center;
  }
  .content-detail-car{
    display: flex;
    border-left: 20px solid #882439;
    position: relative;
  }
  .content-detail-car:before{
    content: '';
    position: absolute;
    width: 50%;
    height: 1px;
    background: #882439;
    bottom: 0;
    left: 0;
  }
  .detail-car{
    padding: 10px 13px;
    font-size: 18px;
    top: 70px;
    font-weight: bold;

    .detail-car span{
      font-weight: normal;
    }
    @media (max-width: 480px){
      .content-detail-car{
        display: block;
      }
      .detail-car{
        font-size: 14px;
      }
    }
    </style>
  @endsection

  @section('js')

    <script src="{{secure_asset('public/js/slick.min.js')}}"></script>
    <script src="{{secure_asset('public/js/jquery.barrating.min.js')}}"></script>

    <script type="text/javascript">
    $(document).ready(function(){
      $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
      });
      $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: true,
        centerMode: true,
        focusOnSelect: true,
        autoplay: true,
        autoplaySpeed: 1500,
        dots: false,
      });


      $('#example').barrating({
        theme: 'fontawesome-stars'
      });

      $('.reviewRating').barrating({
        theme: 'fontawesome-stars',
        readonly: true,
      });
    });
    </script>

  @endsection

  @section('content')


    <style media="screen">
    .content {
      padding-left: 0px !important;
    }
    .container {
      padding-left: 0px !important;
    }

    tr > td {
      text-align: center;
    }
    </style>






    <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
      <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
      <span class="text-secondary"> <a href="inventario_check.php"><b>Inventario Unidades</b></a> <i class="fa fa-angle-right"></i> </span>
      <span class="text-secondary"> Detalle</span>

      <div class="product-list">


        <div class="row">

          <div class="col-sm-5 col-12">
            <div class="slider-for border">

              @if (sizeof($Publicacion) > 0)
                @foreach ($Publicacion as $img)
                  <img src='{{str_replace('../../','https://www.panamotorscenter.com/Des/CCP/',$img->ruta_foto)}}' alt=''>
                @endforeach
              @else
                <img  src='https://www.panamotorscenter.com/Des/CCP/Fotos_Inventario/fondoblanco_actual.jpg' alt=''>
              @endif
            </div>
            <div class="slider-nav pl-4 pr-4 bg-secondary shadow">
              @if (sizeof($Publicacion) > 0)
                @foreach ($Publicacion as $img)
                  <img src='{{str_replace('../../','https://www.panamotorscenter.com/Des/CCP/',$img->ruta_foto)}}' alt=''>
                @endforeach
              @else
                <img  src='https://www.panamotorscenter.com/Des/CCP/Fotos_Inventario/fondoblanco_actual.jpg' alt=''>
              @endif
            </div>
          </div>

          <div class="col-sm-7 col-12">
            <div class="p-2">
              <div class="text-right">
                <p class="small"><strong>Estatus</strong>: <span class="text-primary">{{$Vehiculo->estatus_unidad}}</span></p>
              </div>
              <h2 class="mb-3">{{$Vehiculo->version}}</h2>
              <p class="small"><strong>{{$Vehiculo->marca}}</strong> {{$Vehiculo->modelo}}</p>

              <div class="mt-3 mb-4">
                <select id="example">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4" selected>4</option>
                  <option value="5">5</option>
                </select>
              </div>

              <h4>${{number_format($Vehiculo->precio_piso,2)}}</h4>
              <hr>

              <div class='content-detail-car'>
                @if ($OrdenC)
                  @if ($OrdenCDinamicoFacturable)
                    <p class='detail-car'>Facturable: <span>{{$OrdenCDinamicoFacturable->contenido}}</span></p>
                  @endif
                  @if ($OrdenCDinamicoTipoFac)
                    <p class='detail-car'>Tipo: <span>{{$OrdenCDinamicoTipoFac->contenido}}</span></p>
                  @endif
                  <p class='detail-car'>IVA: <span>Por definir</span></p>
                @else
                  <p class='detail-car'>Facturable: <span>NO</span></p>
                @endif
              </div>



            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="mt-4 mb-4 p-3 bg-white button-container border shadow-sm">
      <div class="product-list custom-tabs">
        <nav>
          <div class="nav nav-tabs nav-fill" id="nav-customContent" role="tablist">
            <a class="nav-item nav-link active" id="nav-profile" data-toggle="tab" href="#custom-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Descripción</a>
            <a class="nav-item nav-link" id="nav-contact" data-toggle="tab" href="#custom-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Documentación</a>
          </div>
        </nav>

        <div class="tab-content py-3 px-3 px-sm-0" id="nav-customContent">
          <!--Personal info tab-->
          <div class="tab-pane fade show active p-3" id="custom-profile" role="tabpanel" aria-labelledby="nav-profile">
            <h6 class="mb-3">Detalle Vin</h6>
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <th scope="row">Vin:</th>
                  <td>{{$Vehiculo->vin_numero_serie}}</td>
                </tr>
                <tr>
                  <th scope="row">Version:</th>
                  <td>{{$Vehiculo->version}}</td>
                </tr>
                <tr>
                  <th scope="row">Marca</th>
                  <td>{{$Vehiculo->marca}}</td>
                </tr>
                <tr>
                  <th scope="row">Modelo</th>
                  <td>{{$Vehiculo->modelo}}</td>
                </tr>
                <tr>
                  <th scope="row">Color</th>
                  <td>{{$Vehiculo->color}}</td>
                </tr>
                <tr>
                  <th scope="row">Precio Piso</th>
                  <td>${{number_format($Vehiculo->precio_piso,2)}}</td>
                </tr>
                <tr>
                  <th scope="row">Precio Digital</th>
                  <td>${{number_format($Vehiculo->precio_digital,2)}}</td>
                </tr>
                @if ($TipoUnidadTruck)
                  <tr>
                    <th scope="row">Origen</th>
                    <td>{{$Vehiculo->procedencia}}</td>
                  </tr>
                  <tr>
                    <th scope="row">Transmisión</th>
                    <td>{{$Vehiculo->transmision}}</td>
                  </tr>
                @endif
                @if (sizeof($InvDinamico_B) > 0)
                  @foreach ($InvDinamico_B as $K => $ValorInv)
                    <tr>
                      <th scope="row">{{ucwords($ValorInv->columna)}}</th>
                      <td>{{$ValorInv->contenido}}</td>
                    </tr>
                  @endforeach
                @endif

              </tbody>
            </table>
          </div>
          <div class="tab-pane fade p-3" id="custom-contact" role="tabpanel" aria-labelledby="nav-contact">
            @if ($tam_tabla == 1)
              <h6 class="mb-3">Detalle</h6>
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Tipo</th>
                    <th>Original</th>
                    <th>Copia</th>
                  </tr>
                </thead>
                <tbody>
                  {!!$tabla!!}
                </tbody>
              </table>
            @else
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <center>
                      <img src="https://www.panamotorscenter.com/Des/CCP/Perfiles2/Informativo/proximamente_check.jpg" alt="" style="widows: 200px;height: 200px;">
                    </center>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>



  @endsection
