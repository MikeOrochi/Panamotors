<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/DemonPromissoryNotes', 'Admin\DemonPagareController@createPromissoryNotes')->name('demon_one');
Route::get('/DemonValidarAbonosPagaresP', 'Admin\DemonPagareController@ValidarAbonosPagaresP')->name('demon_two');
Route::get('/DemonCuadrarPapagresPagados', 'Admin\DemonPagareController@CuadrarPapagresPagados')->name('demon_three');
Route::get('/DemonPagaresSobrantes', 'Admin\DemonPagareController@PagaresSobrantes')->name('demon_four');


Route::get('/Demon', 'Admin\DemonV2PagareController@createPromissoryNotes');

Route::get('/', function () {
	return view('welcome');
});

// Route::get('/404', function () {
//   return view('errors.404');
// });
Auth::routes();

Route::get('/logout', function () {
	\Auth::logout();
	return redirect()->route('login');
})->name('logout');


Route::get('/login-externo/{modulo}/{password}', 'Auth\LoginController@LoginExterno')->name('login.externo');
Route::get('/logout-externo', 'Auth\LoginController@LogOutExteno')->name('logout.externo');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/prueba', 'Controller@index')->name('prueba');
Route::get('/template'       ,['as' => 'template'               ,'uses' => 'Admin\WalletController@template']);


Route::get('cambiar/password'                                  ,['as' => 'change_password_automatic.changePassword'             ,'uses' => 'Auth\ChangePasswordAutomaticController@changePassword']);
Route::post('cambiar/password/save'                            ,['as' => 'change_password_automatic.storePassword'              ,'uses' => 'Auth\ChangePasswordAutomaticController@storePassword']);
Route::post('verificar-tiempo-password'                        ,['as' => 'change_password_automatic.verifyTimePassword'         ,'uses' => 'Auth\ChangePasswordAutomaticController@verifyTimePassword']);

Route::get('administrador/perfiles'                             ,['as' => 'admin.profiles'             ,'uses' => 'Admin\AdminController@profiles']);
Route::post('administrador/perfiles_home'                       ,['as' => 'admin.profiles_home'        ,'uses' => 'Admin\AdminController@profiles_home']);
Route::post('administrador/perfiles-buscar'                     ,['as' => 'admin.profiles.buscar'      ,'uses' => 'Admin\AdminController@searchModules']);
Route::group(['middleware' => 'check.cookies'], function() {
	Route::get('consultar-codigo-postal/{zip}'                   ,['as' => 'zip.show'                   ,'uses' => 'Admin\ZipController@show']);
	Route::group(["prefix" => 'administrador'],function () {
		Route::get('/'                                             ,['as' => 'admin.index'                ,'uses' => 'Admin\AdminController@index']);
		Route::post('/save'                                        ,['as' => 'admin.save'                 ,'uses' => 'Admin\AdminController@save']);
		Route::post('/busqueda'                                    ,['as' => 'admin.search'               ,'uses' => 'Admin\AdminController@Busqueda']);
	});
	Route::group(["prefix" => 'provedores'],function () {
		Route::get('/'                                              ,['as' => 'provider.index'             ,'uses' => 'Admin\ProviderController@index']);
		// Route::get('/revisar'                                       ,['as' => 'provider.index'             ,'uses' => 'Admin\ProviderController@index']);
		Route::post('/store'                                        ,['as' => 'provider.store'             ,'uses' => 'Admin\ProviderController@store']);
		Route::get('/buscador-de-provedores/{search}'               ,['as' => 'provider.search'            ,'uses' => 'Admin\ProviderController@search']);
		Route::get('/editar/{id}'                                   ,['as' => 'provider.edit'              ,'uses' => 'Admin\ProviderController@edit']);
		Route::post('/update'                                       ,['as' => 'provider.update'            ,'uses' => 'Admin\ProviderController@update']);
		Route::get('/buscador-por-id/{id}'                          ,['as' => 'provider.search.byid'       ,'uses' => 'Admin\ProviderController@searchById']);
		Route::get('/buscador-por-nombre/{name}/{lastname}'         ,['as' => 'provider.search.byname'     ,'uses' => 'Admin\ProviderController@searchByName']);
		Route::get('/buscador-por-rfc/{rfc}'                        ,['as' => 'provider.search.rfc'        ,'uses' => 'Admin\ProviderController@searchRfc']);
		Route::get('/buscador-por-alias/{alias}'                    ,['as' => 'provider.search.alias'      ,'uses' => 'Admin\ProviderController@searchAlias']);
		Route::get('/buscador-por-phone/{phone}'                    ,['as' => 'provider.search.phone'      ,'uses' => 'Admin\ProviderController@searchPhone']);
		Route::get('/buscador-por-email/{email}'                    ,['as' => 'provider.search.email'      ,'uses' => 'Admin\ProviderController@searchEmail']);
	});
	Route::group(["prefix" => 'traspasos'],function () {
		Route::get('/{id}'                                         ,['as' => 'transfer.show'               ,'uses' => 'Admin\TransferController@show']);
		Route::post('/guardar'                                     ,['as' => 'transfer.store'              ,'uses' => 'Admin\TransferController@store']);
		Route::get('/buscador-de-contactos/{search}'               ,['as' => 'contact.search'              ,'uses' => 'Admin\ContactController@search']);
		Route::get('/buscador-de-contactos-id/{id}'                ,['as' => 'contact.show'                ,'uses' => 'Admin\ContactController@show']);
		Route::get('/numero-a-letras/{number}/{type_change}'       ,['as' => 'number.letters.convert'      ,'uses' => 'Admin\TransferController@getNumberToLetters']);
	});
	Route::group(["prefix" => 'cartera'],function () {
		Route::get('/'                                                                    ,['as' => 'wallet.index'                                         ,'uses' => 'Admin\WalletController@index']);
		Route::get('/proveedor/detalles/{id}'                                             ,['as' => 'wallet.showProvider'                                  ,'uses' => 'Admin\WalletController@showProvider']);
		Route::get('/proveedor/estado_cuenta/{id}'                                        ,['as' => 'account_status.showAccountStatus'                     ,'uses' => 'Admin\AccountStatusController@showAccountStatus']);
		Route::get('/proveedor/estado_cuenta_interno/pdf/{id}'                            ,['as' => 'account_status.pdfAccountStatusProviderInternal'      ,'uses' => 'Admin\AccountStatusController@pdfAccountStatusProviderInternal']);
		Route::get('/proveedor/pagares_proveedor/{id}'                                    ,['as' => 'account_status.promisoryNotesProvider'                ,'uses' => 'Admin\AccountStatusController@promisoryNotesProvider']);
		Route::get('/proveedor/pagares_pagos_proveedores/{id}'                            ,['as' => 'account_status.pagaresPagosProveedores'               ,'uses' => 'Admin\AccountStatusController@pagaresPagosProveedores']);
		Route::get('/proveedor/abono_pagares_proveedores/{id_proveedor}/{id_document}'    ,['as' => 'account_status.paymentsPromisoryNotesProviders'       ,'uses' => 'Admin\AccountStatusController@paymentsPromisoryNotesProviders']);
		Route::post('/proveedor/abono_pagares_proveedores/guardar'                        ,['as' => 'account_status.savePaymentsPromisoryNotesProviders'   ,'uses' => 'Admin\AccountStatusController@savePaymentsPromisoryNotesProviders']);
		Route::get('/proveedor/estado_cuenta/pdf/{id}'                                    ,['as' => 'account_status.pdfAccountStatusProviders'             ,'uses' => 'Admin\AccountStatusController@pdfAccountStatusProviders']);
		Route::get('/proveedor/reporte_compras_directas/{type_report}/{id}'             ,['as' => 'account_status.reportDirectPurchasesProviders'        ,'uses' => 'Admin\ReportsDirectPurchasesController@reportDirectPurchasesProviders']);

		Route::get('/compras_entrada/{idconta}/{fecha_inicio}'                            ,['as' => 'shopping_entrance.index'                              ,'uses' => 'Admin\MovementsController@show']);
		Route::post('/busqueda-vin'                                                       ,['as' => 'search.vin'                                           ,'uses' => 'Admin\MovementsController@BusquedaVIN']);
		Route::post('/busqueda-vin-bloqueado'                                             ,['as' => 'search_lock.vin'                                      ,'uses' => 'Admin\MovementsController@BusquedaVinBloqueado']);
		Route::post('/busqueda-vin-apartado'                                              ,['as' => 'search_apart.vin'                                     ,'uses' => 'Admin\MovementsController@BusquedaVIN_Apartado']);
		Route::post('/busqueda-referencia'                                                ,['as' => 'search.ref'                                           ,'uses' => 'Admin\MovementsController@BuscarReferencia']);
		Route::post('/busqueda-referencia-venta'                                          ,['as' => 'search.ref.venta'                                     ,'uses' => 'Admin\MovementsController@BuscarReferenciaVenta']);
		Route::post('/guardar-movimiento'                                                 ,['as' => 'movement.store'                                       ,'uses' => 'Admin\SaveMovementController@store']);
		Route::get('/gastos_diversos_financiamiento/{id}/{vin}'                                 ,['as' => 'financial.expenses'                                   ,'uses' => 'Admin\MovementsController@GastosFinacieros']);


		Route::post('/buscar-marca'                                                       ,['as' => 'search.marca'                                         ,'uses' => 'Admin\MovementsController@BuscarMarca']);
		Route::post('/buscar-modelo'                                                      ,['as' => 'search.modelo'                                        ,'uses' => 'Admin\MovementsController@BuscarModelo']);
		Route::post('/buscar-color'                                                       ,['as' => 'search.color'                                         ,'uses' => 'Admin\MovementsController@BuscarColor']);
		Route::post('/buscar-version'                                                     ,['as' => 'search.version'                                       ,'uses' => 'Admin\MovementsController@BuscarVersion']);

		Route::post('/compra-venta'                                                       ,['as' => 'compraventa.store'                                    ,'uses' => 'Admin\CompraVentaController@store']);
		Route::post('/verficar-vin'                                                       ,['as' => 'compraventa.vin'                                      ,'uses' => 'Admin\CompraVentaController@BuscarVinRepetido']);

		Route::get('/saldo-otros-cargos/{idconta}'                                        ,['as' => 'movimientos.saldoOtrosCargos'                         ,'uses' => 'Admin\MovementsController@saldoOtrosCargos']);
		Route::post('/saldo-otros-cargos/save'                                             ,['as' => 'movimientos.guardarSaldoOtrosCargos'                  ,'uses' => 'Admin\SaveMovementController@guardarSaldoOtrosCargos']);

	});
	Route::get('/vista-recibo/{type_view}/{id_voucher}'                                ,['as' => 'vouchers.viewVoucher'                                     ,'uses' => 'Admin\VouchersController@viewVoucherProviders']);
	Route::get('/comprobante-egreso/{id_comprobante}'                                       ,['as' => 'vouchers.viewVoucherExpenses'                                        ,'uses' => 'Admin\VouchersController@viewVoucherExpenses']);
	Route::get('/reporte/ejecutivo/admon-compras'                                       ,['as' => 'reportExecutive.reportExecutive'                                        ,'uses' => 'Admin\ReportExecutiveController@reportExecutive']);


	Route::group(["prefix" => 'estado_cuenta'],function () {
		Route::get('resumen/{idEC}'                                           ,['as' => 'account.summary.index'         ,'uses' => 'Admin\SummaryController@ResumenUnidadPagos']);
		Route::get('resumen/abono-unidad/cont/{idcontacto}/mov/{idmovmiento}' ,['as' => 'account.abono_unidad.show'     ,'uses' => 'Admin\CompraVentaController@show']);
		Route::get('resumen/pagares/cont/{idcontacto}/mov/{idmovmiento}'      ,['as' => 'account.summary.pagare'        ,'uses' => 'Admin\SummaryController@Pagares']);
		Route::post('resumen/guardar-pagare'                                 ,['as' => 'account.pagare.save'            ,'uses' => 'Admin\SummaryController@GuardarPagare']);
		Route::post('obtener-diferencia'                                     ,['as' => 'state_providers.saldo.getSaldo' ,'uses' => 'Admin\SaveMovementController@getSaldo']);
	});

	Route::group(["prefix" => 'pagares'],function () {
		Route::get('/'                                           ,['as' => 'pagare.index'         ,'uses' => 'Admin\PagareController@index']);
		Route::get('/semana'                                     ,['as' => 'pagare.week'          ,'uses' => 'Admin\PagareController@Pagares_Semana']);
		Route::post('buscar-estado-de-cuenta'                    ,['as' => 'pagare.search'        ,'uses' => 'Admin\PagareController@BuscarEstadoCuenta']);
		Route::post('buscar-abonodUP'                           ,['as' => 'pagare.search.AUP'     ,'uses' => 'Admin\PagareController@BuscarAbonosUnidadesP']);
		Route::post('contar-pagares'                            ,['as' => 'pagare.notification'   ,'uses' => 'Admin\PagareController@ContarPagares']);
	});

	Route::group(["prefix" => 'recibos'],function () {
		Route::get('/{id}'                                           ,['as' => 'recibos.show'         ,'uses' => 'Admin\ReceiptsController@show']);
	});

});

Route::post('/enviar-coordenadas'                                  ,['as' => 'infoConection.enviasCoordenadas'                            ,'uses' => 'Admin\InfoConectionController@globalLocation']);
Route::get('/verificar/{url}'                                      ,['as' => 'vouchers.verifyVoucher'                                     ,'uses' => 'Admin\VouchersController@verifyVoucher']);
Route::get('/visualizar/recibo/{id}'                               ,['as' => 'vouchers.verifyNextVoucher'                                 ,'uses' => 'Admin\VouchersController@verifyNextVoucher']);



Route::get('/proveedores-moneda'     ,['as' => 'proveedores.moneda'   ,'uses' => 'Admin\ProviderController@checkMoneda']);
Route::get('/video-example'     ,['as' => 'video.example'   ,'uses' => 'Prueba\VideoController@index']);
Route::post('/video-store'     ,['as' => 'video.store'   ,'uses' => 'Prueba\VideoController@store']);

Route::group(['middleware' => 'check.cookies'], function() {
	Route::group(["prefix" => 'Credito_Cobranza'],function () {
		Route::get('/', 'CreditoCobranza\AdminController@index')->name('CreditoCobranza.AdminController.index');
		Route::get('/cartera', 'CreditoCobranza\ContactController@index')->name('CreditoCobranza.contact.index');
		Route::get('/nuevo-contacto', 'CreditoCobranza\ContactController@new')->name('CreditoCobranza.contact.new');
		Route::post('/guardar-contacto', 'CreditoCobranza\ContactController@store')->name('CreditoCobranza.contact.store');
		Route::post('/verificar-telefono', 'CreditoCobranza\ContactController@verifyMobilePhone')->name('CreditoCobranza.contact.verifyMobilePhone');
		Route::get('/ver-contacto/{idcontacto}', 'CreditoCobranza\ContactController@show')->name('CreditoCobranza.contact.show');
		Route::get('/estado-cuenta/{idcontacto}', 'CreditoCobranza\StateAccountController@show')->name('CreditoCobranza.state_account.show');
	});
});
/////Agregar Rutas Caja Chica
Route::get('administradorcCaja_Chica/perfiles' ,['as' => 'Caja_Chica.profiles'  ,'uses' => 'Caja_Chica\AdminController@profiles']);
Route::post('administradorcCaja_Chica/perfiles_home',['as' => 'Caja_Chica.profiles_home' ,'uses' => 'Caja_Chica\AdminController@profiles_home']);
Route::post('administradorcCaja_Chica/perfiles-buscar' ,['as' => 'Caja_Chica.profiles.buscar','uses' => 'Caja_Chica\AdminController@searchModules']);
Route::group(['middleware' => 'check.cookies'], function() {
	Route::group(["prefix" => 'administrador'],function () {
		Route::get('/home', 'Caja_Chica\AdminController@index')->name('Caja_Chica.index');
		Route::get('/auxiliares', 'Caja_Chica\BuscarAuxiliaresController@index')->name('Caja_Chica.auxiliares');
		Route::post('auxiliares_buscar', 'Caja_Chica\BuscarAuxiliaresController@buscar_auxiliares')->name('Caja_Chica.auxiliares_buscar');
		Route::get('/detalle_auxiliares/{aux}', 'Caja_Chica\BuscarAuxiliaresController@detalle_auxiliar')->name('Caja_Chica.detalle_auxiliares');
		Route::get('/agregar_cargo_auxiliar_secundario/{aux}', 'Caja_Chica\BuscarAuxiliaresController@movimiento_balance')->name('Caja_Chica.agregar_cargo_auxiliar_secundario');
		Route::get('/interno/{aux_request}', 'Caja_Chica\BuscarAuxiliaresController@interno_pdf')->name('Caja_Chica.PDF.interno');
		Route::get('/externo/{aux_request}', 'Caja_Chica\BuscarAuxiliaresController@externo_pdf')->name('Caja_Chica.PDF.externo');
		Route::get('/balance_logistica/{aux_request}', 'Caja_Chica\BuscarAuxiliaresController@balance_logistica_pdf')->name('Caja_Chica.PDF.balance_logistica');
		Route::get('/filtrado/{aux_request}', 'Caja_Chica\BuscarAuxiliaresController@filtrado_pdf')->name('Caja_Chica.PDF.filtrado');
		Route::get('/detalle_recebos_auxliar/{aux_request}', 'Caja_Chica\BuscarAuxiliaresController@detalle_recebos_auxliar')->name('Caja_Chica.PDF.detalle_recebos_auxliar');
		Route::get('/referencias_coincidencias/{aux_request}', 'Caja_Chica\BuscarAuxiliaresController@referencias_coincidencias')->name('Caja_Chica.referencias_coincidencias');
		Route::get('/registrar_auxiliar/{aux_request}', 'Caja_Chica\BuscarAuxiliaresController@registrar_auxiliar')->name('Caja_Chica.registrar_auxiliar');
		Route::post('/store_caja_chica' , 'Caja_Chica\MovAuxiliaresController@store')->name('Caja_Chica.store');
		Route::post('/find_concepts' , 'Caja_Chica\MovAuxiliaresController@buscar_conceptos')->name('Caja_Chica.buscar_conceptos');
		Route::post('/find_refer' , 'Caja_Chica\MovAuxiliaresController@verificar_referencias')->name('Caja_Chica.verificar_referencias');
		Route::post('/find_provider', 'Caja_Chica\MovAuxiliaresController@find_provider')->name('Caja_Chica.find_provider');

		Route::post('/buscar_auxiliares_tokenfield','Caja_Chica\MovAuxiliaresController@auxiliares_tokenfield')->name('Caja_Chica.auxiliares_tokenkenfield');
		Route::get('/resumen_abonos_estado_cuenta_requisicion/{idecr}/{aux}','Caja_Chica\ResumenAbonosEstadoController@inicio')->name('Caja_Chica.resumen_abonos_estado_cuenta_requisicion');

		Route::post('/buscar_acceso_pago','Caja_Chica\BuscarAuxiliaresController@find_acceso_pago')->name('Caja_Chica.validar_user_password_pagos');

		Route::get('/recibo_qr-pdf/{id}','Caja_Chica\MovAuxiliaresController@generar_recibo_pdf_qr')->name('Caja_Chica.recibo_qr_pdf');

		Route::get('/agregar_requisicion_abono/{idecr}/{aux}','Caja_Chica\ResumenAbonosEstadoController@agregar_abono_especifico')->name('Caja_Chica.agregar_requisicion_abono');
	});
});
/////Agregar Rutas Caja Chica


//Rutas Inventario AdmonVentas
Route::group(['middleware' => 'check.cookies'], function() {
	Route::group(["prefix" => 'InventarioVentas'],function () {
		Route::get('/index', 'InventarioVentas\InventarioVController@index')->name('Inv_Ventas.index');
		Route::get('/inventario_check/{marca}/{truck}', 'InventarioVentas\InventarioVController@Inventario')->name('Inv_Ventas.check');
		Route::get('/inventario_check_trucks/{marca}/{truck}', 'InventarioVentas\InventarioVController@Inventario')->name('Inv_Ventas_Trucks.check');
		Route::get('/product-detail/{id}', 'InventarioVentas\DetallesInController@details')->name('Inv_Ventas.details');
		Route::get('/detalle_vin_pdf/{id}/{vin}', 'InventarioVentas\InventarioPDF@CrearPDF')->name('Inv_Ventas.pdf');
	});
});

//Rutas Costo Total VIN
Route::group(['middleware' => 'check.cookies'], function() {
	Route::group(["prefix" => 'Costo_total_VIN'],function () {
		Route::get('/index', 'CostoTotalVIN\CostoTotalVINController@index')->name('CostoTotalVIN.index');
		Route::post('/searh', 'CostoTotalVIN\CostoTotalVINController@searh')->name('CostoTotalVIN.searh');
		Route::get('/costo_total/{vin}', 'CostoTotalVIN\CostoTotalVINController@CostoTotal')->name('CostoTotalVIN.show');
		Route::post('/validarPassword', 'CostoTotalVIN\CostoTotalVINController@ValidatePassword')->name('CostoTotalVIN.password');

		Route::get('/costo_total_pdf2_V2/{vin}/{fecha}/{coordenadas}', 'CostoTotalVIN\PDFCTVController@pdfV2')->name('CostoTotalVIN.pdfV2');
		Route::get('/costo_total_pdf2/{vin}/{fecha}/{coordenadas}', 'CostoTotalVIN\PDFCTVController@pdf')->name('CostoTotalVIN.pdf');

	});
});


//Vista Previa Movimiento Exitoso
Route::group(['middleware' => 'check.cookies'], function() {
	Route::group(["prefix" => 'Vista_Previa_Movimiento_Exitoso'],function () {

		Route::get('/editar_movimiento/{idVP}', 'VPMovimientoExitoso\EditDatosController@editMovement')->name('vpMovimientoExitoso.edit_Movement');
		Route::get('/index', 'VPMovimientoExitoso\VPMovimientoExitosoController@index')->name('VPMovimientoExitoso.index');
		Route::post('/searh', 'VPMovimientoExitoso\VPMovimientoExitosoController@searh')->name('VPMovimientoExitoso.searh');
		Route::post('/solicitar_descuento', 'VPMovimientoExitoso\VPMovimientoExitosoController@SolicitarDescuento')->name('VPMovimientoExitoso.solicitudDescuento');
		Route::get('/lista_ventas', 'VPMovimientoExitoso\VPMovimientoExitosoController@ListaVentas')->name('VPMovimientoExitoso.listaVentas');
		Route::post('/mis_descuentos', 'VPMovimientoExitoso\VPMovimientoExitosoController@MisDescuentosSolicitados')->name('VPMovimientoExitoso.misDescuentos');
		Route::post('/buscarVIN', 'VPMovimientoExitoso\VPMovimientoExitosoController@BuscarVIN')->name('VPMovimientoExitoso.BuscarVIN');
		Route::post('/BuscarFechaApartado', 'VPMovimientoExitoso\VPMovimientoExitosoController@BuscarFechaApartado')->name('VPMovimientoExitoso.BuscarFechaApartado');
		Route::post('/buscar-imagen', 'VPMovimientoExitoso\VPMovimientoExitosoController@BuscarImagen')->name('VPMovimientoExitoso.BuscarImagen');
		Route::get('/actualizar-movimiento/{id}/{estatus}', 'VPMovimientoExitoso\VPMovimientoExitosoController2@updateMovement')->name('vpMovimientoExitoso.updateMovement');
		Route::get('/Nuevos-pagares/{id}', 'VPMovimientoExitoso\VPMovimientoExitosoController@VistaPagares')->name('vpMovimientoExitoso.VistaPagares');
		Route::post('Guardar/Nuevos-pagares', 'VPMovimientoExitoso\VPMovimientoExitosoController@GuardarPagares')->name('vpMovimientoExitoso.GuardarPagares');
		Route::get('/datos_extra/{id}', 'VPMovimientoExitoso\DatosExtraController@DatosExtra')->name('vpMovimientoExitoso.DatosExtra');
		Route::get('/repuve', 'VPMovimientoExitoso\DatosExtraController@REPUVE')->name('vpMovimientoExitoso.REPUVE');
		Route::post('/Guardar-datos', 'VPMovimientoExitoso\DatosExtraController@GuardarDatos')->name('vpMovimientoExitoso.GuardarDatos');
		Route::post('/cambio-unidad', 'VPMovimientoExitoso\EditDatosController@CambioUnidad')->name('vpMovimientoExitoso.CambioUnidad');
		Route::post('/cambio-datos', 'VPMovimientoExitoso\EditDatosController@CambioDatos')->name('vpMovimientoExitoso.CambioDatos');
		Route::post('/cambiar-contacto', 'VPMovimientoExitoso\EditDatosController@CambioContacto')->name('vpMovimientoExitoso.CambioContacto');
		Route::post('/cambiar-nuevo-contaco', 'VPMovimientoExitoso\EditDatosController@CambioNuevoContacto')->name('vpMovimientoExitoso.CambioNuevoContacto');
		Route::post('/cambiar-tipo-venta', 'VPMovimientoExitoso\EditDatosController@cambioTipoVenta')->name('vpMovimientoExitoso.cambioTipoVenta');
		Route::get('/verificar-venta/{id}/{activacion}', 'VPMovimientoExitoso\DatosExtraController@verificarAprobarVenta')->name('vpMovimientoExitoso.verificarAprobarVenta');
		Route::post('/guardar-codigo-aprovacion', 'VPMovimientoExitoso\AprobacionController@GuardarCodigo')->name('vpMovimientoExitoso.guardarCodigo');
		Route::post('/aceptar-codigo-aprovacion', 'VPMovimientoExitoso\AprobacionController@UsarCodigo')->name('vpMovimientoExitoso.UsarCodigo');


		Route::get('/nuevo'                      ,['as' => 'vpMovimientoExitoso.newMovement'                        ,'uses' => 'VPMovimientoExitoso\VPMovimientoExitosoController2@newMovement']);
		Route::get('/buscar/{search}'            ,['as' => 'vpMovimientoExitoso.search'                             ,'uses' => 'VPMovimientoExitoso\VPMovimientoExitosoController2@search']);
		Route::post('/guardar/solicitud'         ,['as' => 'vpMovimientoExitoso.storeNewMovement'                   ,'uses' => 'VPMovimientoExitoso\VPMovimientoExitosoController2@storeNewMovement']);

		Route::get('/facturacion/{id}'               ,['as' => 'vpMovimientoExitoso.facturacion'                     ,'uses' => 'VPMovimientoExitoso\FacturacionController@facturacion']);
		Route::post('/busqueda-facturacion'          ,['as' => 'vpMovimientoExitoso.busquedaFacturacion'             ,'uses' => 'VPMovimientoExitoso\FacturacionController@busquedaFacturacion']);
		Route::post('/busqueda-informacion'          ,['as' => 'vpMovimientoExitoso.busquedaInformacion'             ,'uses' => 'VPMovimientoExitoso\FacturacionController@busquedaInformacion']);
		Route::post('/guardar_orden'          				,['as' => 'vpMovimientoExitoso.guardar_orden'             		,'uses' => 'VPMovimientoExitoso\FacturacionController@guardar_orden']);


		//PDF
		Route::get('/contrato/venta-credito'                ,['as' => 'vpme.pdf.contratoCredito'                   ,'uses' => 'VPMovimientoExitoso\PDFController@contratoCredito']);
		Route::get('/contrato/venta-directa-contado/{id}'   ,['as' => 'vpme.pdf.contratoDirectaContado'            ,'uses' => 'VPMovimientoExitoso\PDFController@contratoDirectaContado']);
		Route::get('/vista-previa/{id}'                     ,['as' => 'vpme.pdf.vistaPrevia'                       ,'uses' => 'VPMovimientoExitoso\PDFController@vistaPrevia']);
		Route::get('/personas-fisicas/{id}'                 ,['as' => 'vpme.pdf.personasFisicas'                   ,'uses' => 'VPMovimientoExitoso\PDFController@personasFisicas']);
		Route::get('/aviso-de-privacidad/{id}'              ,['as' => 'vpme.pdf.aviso_privacidad'                   ,'uses' => 'VPMovimientoExitoso\PDFController@AvisoPrivacidad']);
	});
});


//Modulo Inventario Admin
Route::group(["prefix" => 'inventario/admin', 'middleware' => 'check.cookies'], function() {
	Route::get('/'                                                       ,['as' => 'inventoryAdmin.index'                                       ,'uses' => 'InventarioAdmin\InventoryController@index']);
	Route::get('/ver/{tipo}/{marca}'                                     ,['as' => 'inventoryAdmin.showMark'                                    ,'uses' => 'InventarioAdmin\InventoryController@showMark']);
	Route::get('/ver/detalle/{tipo}/{id}'                                ,['as' => 'inventoryAdmin.showDetailsUnit'                             ,'uses' => 'InventarioAdmin\InventoryController@showDetailsUnit']);
	Route::get('/editar/detalles/{tipo}/{id}/{vin}'                      ,['as' => 'inventoryAdmin.editDetailsUnit'                             ,'uses' => 'InventarioAdmin\InventoryController@editDetailsUnit']);
	Route::post('/editar/guardar/cambios/detalles/'                      ,['as' => 'inventoryAdmin.storeEditDetailsUnit'                        ,'uses' => 'InventarioAdmin\InventoryController@storeEditDetailsUnit']);
	Route::post('/editar/guardar/cambios/detalles/trucks'                ,['as' => 'inventoryAdmin.storeEditDetailsTruck'                       ,'uses' => 'InventarioAdmin\InventoryController@storeEditDetailsTruck']);

	Route::get('/editar/agregar/fichas/tecnicas/{id}/{vin}'	             ,['as' => 'inventoryAdmin.addTechnicalSheets'                          ,'uses' => 'InventarioAdmin\InventoryController@addTechnicalSheets']);

	Route::post('/guardar/galeria/imagenes'                              ,['as' => 'inventoryAdmin.saveGalleryImages'                           ,'uses' => 'InventarioAdmin\InventoryController@saveGalleryImages']);
	Route::post('/actualizar/tipo/galeria/imagenes'                      ,['as' => 'inventoryAdmin.updateGalleryTypeTruck'                      ,'uses' => 'InventarioAdmin\InventoryController@updateGalleryTypeTruck']);
	Route::post('/obtener/tipos/sub/especificaciones/vin'                ,['as' => 'inventoryAdmin.getSubEspecificationsVin'                    ,'uses' => 'InventarioAdmin\InventoryController@getSubEspecificationsVin']);
});
Route::group(['middleware' => 'check.cookies'], function() {
	Route::group(["prefix" => 'taller-tracktocamiones'],function () {
		//Estadisticas
		Route::get('/', 'TallerTracktocamiones\EstadisticasController@index')->name('TallerTrack.stadistics.index');
		//Nuevo ingreso
		Route::get('/nuevo', 'TallerTracktocamiones\TallerTracktoController@index')->name('TallerTracktoController.new');
		Route::post('/store-solicitud-taller',['as' => 'trackto.store','uses' => 'TallerTracktocamiones\TallerTracktoController@store']);
		//Gestionar procesos
		Route::get('/ver-salidas', 'TallerTracktocamiones\SalidasTallerTracktoController@index')->name('SalidasTallerTrackto.index');
		Route::get('/documentar-salida/{id}', 'TallerTracktocamiones\SalidasTallerTracktoController@new')->name('SalidasTallerTrackto.new');
		Route::post('/store-liberacion-taller',['as' => 'trackto.free.store','uses' => 'TallerTracktocamiones\SalidasTallerTracktoController@store']);
		Route::get('/documentar-revision/{id}', 'TallerTracktocamiones\ChecksTracktoController@new')->name('taller_trackto.checks.new');
		Route::post('/guardar-revision', 'TallerTracktocamiones\ChecksTracktoController@store')->name('taller_trackto.checks.store');
		//Funciones
		Route::post('/busqueda-solicitud-trackto',['as' => 'search.trackto.solicitud','uses' => 'TallerTracktocamiones\SalidasTallerTracktoController@BusquedaVIN']);
		Route::post('/busqueda-vin-trackto',['as' => 'search.trackto.vin','uses' => 'TallerTracktocamiones\TallerTracktoController@BusquedaVIN']);
		//PDF
		Route::get('/asignacion/{id}', 'TallerTracktocamiones\TallerTracktoController@formatoAsignar')->name('taller_trackto.asignacion.pdf');
		Route::get('/liberacion/{id}', 'TallerTracktocamiones\SalidasTallerTracktoController@formatoLiberacion')->name('taller_trackto.liberacion.pdf');
		//Historial
		Route::get('/historial', 'TallerTracktocamiones\SalidasTallerTracktoController@historial')->name('SalidasTallerTrackto.historial');

	});
});
