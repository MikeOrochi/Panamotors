@extends('layouts.appAdmin')
@section('titulo', 'CCP | Abonar a partir de otros cargos')
@section('content')
	<style media="screen">
	.bounceInUp_izi {
		-webkit-animation: iziT-bounceInUp .7s ease-in-out both;
		animation: iziT-bounceInUp .7s ease-in-out both;
	}
	</style>
	<div class="col-lg-12" style="margin-bottom: 20px;">
		<center>
			<h2>{{$provider->nombre}} {{$provider->apellidos}}</h2>
			<i class="fa fa-balance-scale fa-2x" aria-hidden="true"></i>
		</center>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="col-sm-12">
				<div class="form-group">
					{{-- <label>Compra a la que deseas abonar</label>
					<select class="form-control" id="movimiento_general" name="movimiento_general" required="" value="" onchange="getAbonosPendientesMxn()">
					<option value="{{$compra_pendiente->idestado_cuenta_proveedores}}">{{$compra_pendiente->idestado_cuenta_proveedores}}-{{$compra_pendiente->referencia}}-{{$compra_pendiente->datos_marca}}-{{$compra_pendiente->datos_version}}-{{$compra_pendiente->datos_vin}}</option>
				</select> --}}
				<form class="" action="{{route('movimientos.guardarSaldoOtrosCargos')}}" method="post">
					@csrf
					<div class="row">
						<div class="card col-12">
							<div class="">
								<div class="card-body">
									<div class="row">
										<span class="col-sm-12 col-md-4 col-lg-4 col-xl-4">Saldo otros cargos MXN: </span>
										<input type="text" id='saldo_otros_cargos' class="form-control col-sm-12 col-md-8 col-lg-8 col-xl-8" name="" value="{{$saldo_otros_cargos}}" readonly>
										<br><br>
										<span  @if($provider->col2 == 'MXN') style='display: none;' @endif class="col-sm-12 col-md-4 col-lg-4 col-xl-4">Saldo otros cargos {{$provider->col2}}: </span>
											<input @if($provider->col2 == 'MXN') style='display: none;' @endif type="text" id='saldo_otros_cargos_change' class="form-control col-sm-12 col-md-3 col-lg-3 col-xl-3" name="" value="{{$saldo_otros_cargos/$tipo_cambio}}" readonly>
												<span  @if($provider->col2 == 'MXN') style='display: none;' @endif class="col-sm-12 col-md-3 col-lg-3 col-xl-3">Tipo de cambio: </span>
													<input @if($provider->col2 == 'MXN') style='display: none;' @endif type="text" id='tipo_cambio' class="form-control col-sm-12 col-md-2 col-lg-2 col-xl-2" name="tipo_cambio" value="{{$tipo_cambio}}">
													</div>
												</div>
											</div>
										</div>

										@if ($compras_pendientes->count()>0)
											@foreach ($compras_pendientes as $compra_pendiente)
												<div class="card col-sm-12 col-md-6 col-lg-6 col-xl-6 bounceInUp_izi">
													<div class="card-body">
														<div align='center'>
															<h5 class="card-title">{{$compra_pendiente->datos_marca}}</h5>
															<h6 class="card-subtitle mb-2 text-muted">{{$compra_pendiente->datos_version}}</h6>
														</div>
														<p class="card-text"><b>Referencia: </b>{{$compra_pendiente->referencia}}</p><br>
														<p class="card-text"><b>VIN: </b>{{$compra_pendiente->datos_vin}}</p><br>
														<p class="card-text"><b>Saldo deuda: </b>{{$compra_pendiente->saldos['deuda_unidad']/$tipo_cambio}}</p><br>
														<p class="card-text"><b>No. pagaré: </b>{{$compra_pendiente->saldos['no_pagare']}}</p><br>
														<p class="card-text"><b>Saldo pagaré: </b>{{$compra_pendiente->saldos['monto_restante']/$tipo_cambio}}</p><br>
														<input type="text" class="form-control" name="id_estado_cuenta" value="{{$compra_pendiente->idestado_cuenta_proveedores}}" placeholder="$0.00"><br>
														<input type="text" class="form-control" id='deuda_{{$compra_pendiente->idestado_cuenta_proveedores}}'name="monto" value="{{$compra_pendiente->saldos['deuda_unidad']/$tipo_cambio}}" placeholder="$0.00"><br>
														<input type="text" class="form-control" id='{{$compra_pendiente->idestado_cuenta_proveedores}}' onkeyup="verifyPayments('{{$compra_pendiente->idestado_cuenta_proveedores}}','deuda_{{$compra_pendiente->idestado_cuenta_proveedores}}');" name="monto" value="0" placeholder="$0.00"><br>
														{{-- <div class="" align='right'>
														<button type="submit" id='btn_{{$compra_pendiente->idestado_cuenta_proveedores}}' class="btn btn-primary">Abonar</button>
													</div> --}}
												</div>
											</div>
										@endforeach
									@endif
									@php $cont=0; @endphp
									@if ($compras_pendientes->count()>0)
										@foreach ($compras_pendientes as $compra_pendiente)
											@php
											$compras[$cont] = $compra_pendiente->idestado_cuenta_proveedores;
											$compras_money[$cont] = 0;
											$cont++;
											@endphp

										@endforeach
										@php $compr = implode(",", $compras) @endphp
										@php $compr_money = implode(",", $compras_money) @endphp
									@endif
									{{-- @php dd($compras); @endphp --}}
									<input type="text" class="form-control" id='compr' name="values" value="{{$compr}}"><br>
									<input type="text" class="form-control" id='compr_money' name="compr_money" value="{{$compr_money}}"><br>
									<button type="submit" class="btn btn-primary" name="button">Generar cargos</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
			function verifyPayments(id_input, deuda){
				let tipo_cambio = document.getElementById("tipo_cambio").value;
				let saldo_otros_cargos_original={{$saldo_otros_cargos}}/tipo_cambio;
				let saldo_otros_cargos = parseFloat(document.getElementById("saldo_otros_cargos_change").value);
				let abono = parseFloat(document.getElementById(id_input).value);
				let inp_deuda = parseFloat(document.getElementById(deuda).value);
				let total = saldo_otros_cargos_original;
				let total_otros_inputs = 0;
				@if ($compras_pendientes->count()>0)
				@foreach ($compras_pendientes as $compra_pendiente)
				if ({{$compra_pendiente->idestado_cuenta_proveedores}} != id_input) {
					total_otros_inputs = total_otros_inputs+parseFloat(document.getElementById('{{$compra_pendiente->idestado_cuenta_proveedores}}').value)
				}
				@endforeach

				@endif
				total = total-total_otros_inputs;
				total = total-abono;
				// console.log(total);
				document.getElementById("saldo_otros_cargos_change").value=total;
				if (abono>saldo_otros_cargos && abono <= inp_deuda) {
					document.getElementById(id_input).value=0;
					abono = 0;
					total = saldo_otros_cargos_original;
					total = total-total_otros_inputs;
					total = total-abono;
					document.getElementById("saldo_otros_cargos_change").value=total;
					swal("Error!", "No puedes abonar mas del saldo disponible ni que el valor de la deuda", "error");
					// console.log(abono);
					// console.log(saldo_otros_cargos);
				}
				let money='';
				let value='0';
				@foreach ($compras_pendientes as $compra_pendiente)
				if (document.getElementById('{{$compra_pendiente->idestado_cuenta_proveedores}}').value=='') {
					console.log('xD');
					value='0';
				}else {
					value=document.getElementById('{{$compra_pendiente->idestado_cuenta_proveedores}}').value;
				}
				money =money+value+',';
				@endforeach
				console.log(money);
				document.getElementById('compr_money').value = money;
			}
			</script>
		@endsection
