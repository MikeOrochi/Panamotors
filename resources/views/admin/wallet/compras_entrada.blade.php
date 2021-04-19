@extends('layouts.appAdmin')
@section('titulo', 'CCP | Carga movimiento')

@section('content')


	<div class="col-lg-12" style="margin-bottom: 20px;">
		@if (!empty(session('recibos_proveedores')))
			{{-- {{session('recibos_proveedores')}} --}}
			<script type="text/javascript">
			$( document ).ready(function() {
				$('#exampleModal').modal('toggle')
			});


			</script>

			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Abono en efectivo</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body" align='center'>
							¿Deseas visualizar el comprobante de pago?<br>
							<a href="{{route('vouchers.viewVoucher',['type_view'=>'pdf','id'=>Crypt::encrypt(session('recibos_proveedores'))])}}" id='document_1' target="_blank" onclick="closeTootips();" class="btn btn-info" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Recibo de pago"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>
							{{---<a href="{{route('vouchers.viewVoucherExpenses',['id'=>Crypt::encrypt(session('comprobantes_transferencia'))])}}" id='document_2' target="_blank" onclick="closeTootips();" class="btn btn-success" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Comprobante de transferencia"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>--}}
						</div>
						{{-- <div class="modal-footer"> --}}
						{{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
						{{-- </div> --}}
					</div>
				</div>
			</div>
			@php
			session()->forget('recibos_proveedores');
			session()->forget('comprobantes_transferencia');
			@endphp
		@endif
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<a class="btn-back" style="margin-left:1px;" href="{{route('account_status.showAccountStatus',$idconta)}}"><i class="fas fa-chevron-left"></i> Resumen de movimientos</a>
			{{-- {{$idconta}} --}}
		</div>
		<center>
			<h2>{{$nombre_completo}}</h2>
			<i class="fa fa-balance-scale fa-2x" aria-hidden="true"></i>
		</center>

	</div>


	<div class="card">
		<div class="card-header row">
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				Nuevo movimiento
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<select class="custom-select" onChange="MostrarForm(this.value); resetear();" id="muestra" name="muestra" autocomplete="off">
					<option selected>Elije una opción</option>
					@foreach ($catalogo_cobranza as $key => $CC)
						@if ($CC->nombre != "Devolución del VIN")
							@if ($CC->nombre == "Cuenta de Deuda")
								<option value="{{$CC->nombre}}">{{$CC->nomeclatura.' - A '.$CC->nombre}}</option>
							@else
								<option value="{{$CC->nombre}}">{{$CC->nomeclatura.' - '.$CC->nombre}}</option>
							@endif
						@endif
					@endforeach
				</select>
			</div>


		</div>
		<div class="card-body">
			<div class="1">
				@include('admin.partials.FormPrincipal')
			</div>
			<div class="2">
				@include('admin.partials.FormSecundario')
			</div>


		</div>
	</div>


	<script type="text/javascript">

	Moneda('#tipo_cambio_principal', '{{$Proveedor->col2}}');
	Moneda('#tipo_cambio2', '{{$Proveedor->col2}}');


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

	function MostrarForm(id) {


		if (id == 'Otros Cargos') {
			try {
				$('#type_movment_select').fadeIn();
				// document.getElementById("busqueda_vin_apartado").value = 'no_ok';
				// {{$otroscargos = 'ok'}}
				referenceOtrosAbonos();


				$('#i_abono').fadeOut();
				$('#i_otros').fadeIn();
				// tipo_cambio2
				tipo_cambio = document.getElementById('tipo_cambio2').value;
				document.getElementById("saldo").value = {{$saldo_anterior}};
				document.getElementById("monto_entrada").value = {{$saldo_anterior}}/tipo_cambio;
				document.getElementById("pagare").value = 0;
				document.getElementById("no_pagare").value = 'N/A';
				document.getElementById("monto_abono").value = '0';
				document.getElementById("saldo_nuevo").value = '0';
				document.getElementById("resto_deuda_temp").value = {{$saldo_anterior}}/tipo_cambio;

			} catch (e) {}
			$('#movimiento_general').hide();
			$('#no_disponse_bougths').hide();
			$('#movimiento_general').removeAttr("required");
		}
		if (id == 'Abono') {
			try {
				$('#i_otros').fadeOut();
				$('#i_abono').fadeIn();
				$('#type_movment_select').fadeOut();
				getAbonosPendientesMxn();
				$('#no_disponse_bougths').hide();
				$('#no_disponse_bougths').hide();
				$('#movimiento_general').show();
			} catch (e) {
				$('#no_disponse_bougths').show();
				$('#movimiento_general').hide();
			}
			$('#movimiento_general').attr("required");
		}
		if(id == "Compra Directa" || id == "Cuenta de Deuda"){

			$('.OcultarRow').hide();
			$('#CampoBusquedaVIN').hide();


			$("#resultadoBusquedaVin").html("");
			$("#marca_venta").val("").removeAttr("readonly");
			$("#modelo_venta").val("").removeAttr("readonly");
			$("#color_venta").val("").removeAttr("readonly");
			$("#version_venta").val("").removeAttr("readonly");
			$("#vin_venta").val("").removeAttr("readonly");
			$("#orden_logistica").val("SI");

			$('#receptor_venta option[value="Panamotors Center, S.A. de C.V."]').attr("selected",true);
			$('#receptor_venta option:not(:selected)').prop('disabled', true);
			$('#receptor_venta option:not(:selected)').css('display', 'none');

			$('#tipo_comprobante_compra option[value=""]').attr("selected",true);
			var campos = $('#tipo_comprobante_compra option:not([value=""],[value="Factura"],[value="Contrato de Compra"],[value="Notificación Digital"])');
			campos.prop('disabled', true);
			campos.css('display', 'none');

			var Emisor = '{{$idconta.'.'.$iniciales_cliente}}';

			SeleccionSelect('emisor_venta',Emisor,true);
			SeleccionSelect('agente_emisor_venta',Emisor,true);
			SeleccionSelect('agente_receptor_venta','INV',true);
			SeleccionSelect('agente_receptor_venta','INV',true);

		}else{

			/*
			$('.OcultarRow').show();
			$('#CampoBusquedaVIN').show();
			$("#resultadoBusquedaVin").html('');
			$("#marca_venta").attr("readonly", "readonly");
			$("#version_venta").attr("readonly", "readonly");
			$("#color_venta").attr("readonly", "readonly");
			$("#modelo_venta").attr("readonly", "readonly");
			$("#vin_venta").attr("readonly", "readonly");



			SeleccionSelect('tipo_comprobante_compra',null,false);
			SeleccionSelect('receptor_venta',null,false);
			SeleccionSelect('emisor_venta',null,false);
			SeleccionSelect('agente_emisor_venta',null,false);
			SeleccionSelect('agente_receptor_venta',null,false);
			*/

		}


		if (id == "") {
			$("#principal").hide();
			$("#secundario").hide();
			$("#concepto_general").val(id);
			$("#concepto_general_venta").val(id);
			$("#cargos_ad").hide();
		}else if (id=="Compra Directa" ||  id=="Venta Permuta" || id=="Compra Permuta" || id=="Cuenta de Deuda"  || id=="Devolución del VIN" || id=="Consignación") {
			$("#principal").show();
			$("#secundario").hide();
			$("#cargos_ad").hide();
			$("#concepto_general").val(id);
			$("#concepto_general_venta").val(id);
			if(id=="Cuenta de Deuda"){
				//$("#emisor_venta option[value='']").remove();
				//$("#agente_emisor_venta option[value='']").remove();
				//$("#emisor_venta").attr('disabled','disabled');//.val(def);
				//$("#agente_emisor_venta").attr('disabled','disabled');//.val(def);
			}
			else{
				//$("#emisor_venta option:selected").before($('<option>',{value: "",text:"Elige una opcion..."}));
				//$("#emisor_venta").removeAttr('disabled');
				//$("#agente_emisor_venta option:selected").before($('<option>',{value: "",text:"Elige una opcion..."}));
				//$("#agente_emisor_venta").removeAttr('disabled');//.append($('<option>',{value: "",text:"Elige una opcion..."})).val("");
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

						var cambio1 = "1";
						var cambio2 = "1";
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


					function CalcularMontoAbono() {
						tipo_cambio = $("#tipo_cambio2").val();

						if (tipo_cambio == "") {
							iziToast.warning({
								title: 'Atención',
								message: 'Seleccione un tipo de cambio',
								position: 'topRight'
							});
						} else {
							monto_entrada = parseFloat($("#monto_entrada").val());
							tipo_cambio = parseFloat(tipo_cambio);
							total = monto_entrada * tipo_cambio;

							$("#monto_abono").val(total);
							CalcularSaldoNuevo();
						}

					}

					function CalcularSaldoNuevo() {

						monto_capturado = $("#monto_abono").val();
						saldo_pendiente = $("#saldo").val();
						//operacion = $("#efecto option:selected").val();
						var tipo_general_select = document.getElementById("tipo_general");
						var tipo_general = tipo_general_select.options[tipo_general_select.selectedIndex].value;
						console.log(tipo_general);
						operacion = "resta";
						if (tipo_general=='abono') {
							operacion = "resta";
						}else {
							operacion = "suma";
						}
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
							$("#saldo_nuevo").val(calculo.toFixed(2));
							verifyLimitSaldo();
							buscar_letras('monto_entrada', 'tipo_moneda1', 'letra1');
						} else if (operacion == "resta") {
							calculo = parseFloat(saldo_pendiente) - parseFloat(monto_capturado);
							$("#saldo_nuevo").val(calculo.toFixed(2));
							verifyLimitSaldo();
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

								//console.log(response);

								if (response.info == null) {
									iziToast.error({
										title: 'Error',
										message: 'Error al obtener la cantidad en letras',
									});
									label.html('Precio Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
									InputDestino.val('');
								} else {
									InputDestino.val(response.info);
									label.html('Precio Letra');
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
					function ocultar_referencia_anticipo(id) {
						if (id == "Recibo Automático") {
							$("#comprobante_archivo_anticipo").prop('disabled', true);
						} else {
							$("#comprobante_archivo_anticipo").prop('disabled', false);
						}
					}
					function buscar_referencia() {

						var institucion_receptora = $("#receptor").val();
						var agente_receptor = $("#agente_receptor").val();
						var institucion_emisor = $("#emisor").val();
						var agente_emisor = $("#agente_emisor").val();
						var monto_general1 = $("#monto_general").val();
						var n_referencia = $("#n_referencia").val();
						var idco = $("#co").val();
						var monto_cantidad = $("#monto_abono").val();

						var TipoMovi = $('#tipo_general').val();

						if (agente_receptor === "") {
							SolicitarLLenado('emisor', 'agente_receptor', 'receptor');
						}else if (institucion_emisor === "") {
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
										ag_emisora : agente_emisor,
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
								console.log(response);
								// if(event.which != 32){
									// response.forEach(function logArrayElements(element, index, array) {
									// 	var miString = 'HOlA qUe PaSa';
									// 	var Capitalizado = miString.trim().toLowerCase().replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())));
									// 	console.log(Capitalizado);
									// });
									let marcas = [];
									response.forEach(function logArrayElements(element, index, array) {
										let miString = element.marca;
										let Capitalizado = miString.trim().toLowerCase().replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())));
										let marcasFull = marcas.push(Capitalizado);
									});
									console.log(marcas);
						    // }
								marcas.forEach(function logArrayElements(marcas, index, array) {
									$("#resultadoMarca").append(`<option class='sugerencias_marca' value='`+marcas+`'>`+marcas+`</option>`);
								});
								// response.forEach(function logArrayElements(element, index, array) {
								// 	$("#resultadoMarca").append(`<option class='sugerencias_marca' value='`+element.marca+`'>`+element.marca+`</option>`);
								// });

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
					var textoBusquedaModelo = $("#modelo_venta").val().trim();
					var textoBusquedaMarca 	= $("#marca_venta").val().trim();

					console.log(textoBusquedaMarca);

					if(textoBusquedaMarca  == ""){
						$("#resultadoModelo").html('<p><b>No es posible realizar la busqueda sin la marca.</b></p>');
						$("#modelo_venta").css("border-color","#A0213C");
					}else if (textoBusquedaModelo != "") {

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
									marca : textoBusquedaMarca,
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
										let colors = [];
										/*************************************/
										response.forEach(function logArrayElements(element, index, array) {
											let miString = element.color;
											// let Capitalizado = miString.trim().toLowerCase().replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())));
											let colorsFull = colors.push(element.color.toLowerCase());
										});
										console.log(colors);
							    // }
									colors.forEach(function logArrayElements(colors, index, array) {
										$("#resultadoColor").append(`<option class='sugerencias_color' value='`+colors+`'>`+colors+`</option>`);
									});
									/*************************************/
										// response.forEach(function logArrayElements(element, index, array) {
										// 	$("#resultadoColor").append(`<option class='sugerencias_color' value='`+element.color+`'>`+element.color+`</option>`);
										// });
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

							var textoBusquedaVersion = $("#version_venta").val().trim();
							var textoBusquedaMarca 	 = $("#marca_venta").val().trim();

							if(textoBusquedaMarca == ""){

								$("#resultadoVersion").html('<p><b>No es posible realizar la busqueda sin la marca.</b></p>');
								$("#version_venta").css("border-color","#A0213C");

							}else if (textoBusquedaVersion != "") {

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
											marca : textoBusquedaMarca,
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
											idCliente: {{$idconta}},
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


										/*
										if (response == "SI") {
											document.getElementById('vin_venta').setCustomValidity("");
											$("#respuestaVIN").html('<i class="fas fa-check-circle" style="color:green;"></i>');

											var Referencia_VIN = $('#emisor_venta').val()+"_"+vin;
											//$('#vin_venta').val(Referencia_VIN);
											BuscarVIN(Referencia_VIN,1);

										}else if (response == "NO"){
											document.getElementById('vin_venta').setCustomValidity("VIN en uso");
											$("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;">VIN en uso</i>');

											document.getElementById('n_referencia_venta').setCustomValidity("VIN en uso");
											$("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">VIN en uso</i>');

											document.getElementById('n_referencia_anticipo').setCustomValidity("VIN en uso");
											$("#respuesta_referecia_anticipo").html('<i class="fas fa-times-circle" style="color: red;">VIN en uso</i>');

										}else{
											document.getElementById('vin_venta').setCustomValidity("Error");
											$("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');

											document.getElementById('n_referencia_venta').setCustomValidity("Error");
											$("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');

											document.getElementById('n_referencia_anticipo').setCustomValidity("Error");
											$("#respuesta_referecia_anticipo").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
										}*/


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


							$(".readonly").on('keydown paste focus mousedown', function(e){
								e.preventDefault();
							});


							@if (session('Anticipo'))

							var Anticipo = '{{ session('Anticipo') }}';

							SeleccionSelect('muestra',"Abono",true);
							SeleccionSelect('movimiento_general',Anticipo,true);
							MostrarForm('Abono');
							@endif

							function closeTootips(){
								$('#document_1').tooltip('hide')
								$('#document_2').tooltip('hide')
							}

							</script>



						@endsection
