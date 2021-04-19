@extends('layouts.appAdmin')

@section('titulo', 'Dashboard')

@section('content')

<div class="row mt-3">
    <div class="col-sm-12">
        <div class="shadow panel-head-primary">
            <div class="table-responsive">
                <div class="container">
                    <div class="row" style="padding:30px">


                        <!-- --------------------------------------------------------------------------------- -->



                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                                    <div class="bg-white border shadow">
                                        <div class="p-2 text-center">
                                            <h5 class="mb-0 mt-2 text-theme"><small><strong>Inventario Total</strong></small></h5>
                                            <h1><?php echo $suma_unidades; ?></h1>
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
                                                <h1><?php echo $count; ?></h1>
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
                                                <h1><?php echo $count1; ?></h1>
                                            </a>
                                        </div>
                                        <div class="align-bottom">
                                            <span id="profitBar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <!--Custom cards section-->
                        <div class="row">
                            <!--Visitors statistics card-->

                            @foreach($marcas_cantidad as $value)
                            @if(!empty($value))
                            @if($value->cantidad > 0)
                            <div class="col-sm-4 custom-card">
                                <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
                                    <div class="text-center mb-3">
                                        <h1>@if(!empty($value->marca)){{$value->marca}}@else N/A @endif</h1>
                                        <h2>@if(!empty($value->cantidad)){{$value->cantidad}}@else N/A @endif</h2>
                                    </div>
                                    <center><a href="{{route('inventoryAdmin.showMark',['type'=>'unidades','marca'=>$value->name_encrypt])}}">
                                        <img src="{{asset('public/img/logos_marcas/unidades/'.$value->img.'.png')}}" alt="" style="width:50%; height:50%; margin:0 auto;" > </a>
                                    </center>
                                </div>
                            </div>
                            @endif
                            @endif
                            @endforeach

                            <!--/Visitors statistics card-->

                        </div>
                        <!--Custom cards Section-->


                        <!--Custom cards section-->
                        <div class="row">
                            <!--Visitors statistics card-->

                            @foreach($marcas_trucks_cantidad as $value)
                            @if(!empty($value))
                            @if($value->cantidad > 0)
                            <div class="col-sm-4 custom-card">
                                <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
                                    <div class="text-center mb-3">
                                        <h1>@if(!empty($value->marca)){{$value->marca}}@else N/A @endif</h1>
                                        <h2>@if(!empty($value->cantidad)){{$value->cantidad}}@else N/A @endif</h2>
                                    </div>
                                    <center><a href="{{route('inventoryAdmin.showMark',['type'=>'trucks','marca'=>$value->name_encrypt])}}">
                                        <img src="{{asset('public/img/logos_marcas/trucks/'.$value->img.'.png')}}" alt="" style="width:50%; height:50%; margin:0 auto;" > </a>
                                    </center>
                                </div>
                            </div>
                            @endif
                            @endif
                            @endforeach

                            <!--/Visitors statistics card-->

                        </div>
                        <!--Custom cards Section-->










                        <!-- ------------------------------------------------------------- -->



                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
