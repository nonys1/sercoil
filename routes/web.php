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

/*Route::get('/', function () {
	return view('auth.login');
});*/
Route::get('/', 'WebController@index');
Route::name('web.calcula')->post('web/calcula','WebController@calcula');
Route::name('web.envia')->post('web/envia','WebController@envia');
Route::name('web.mostrarproducto')->get('web/mostrarproducto','WebController@mostrarproducto');
Route::get('/login', function () {
	return view('auth.login');
});
Route::get('/error', function () {
	    return view('error.index');
	});
Auth::routes();
	//Route::get('/codigo', 'HomeController@codigo')->name('codigo');

Route::group(['middleware' => 'auth'], function (){
	Route::get('/home', 'HomeController@index')->name('home');
	Route::group(['middleware' => ['permission:usuarios']], function() {
		//------------   USUARIO  -------
		Route::resource('usuario','UserController');
		Route::name('usuario.update')->post('usuario/update','UserController@update');
	});
	Route::group(['middleware' => ['permission:roles_permisos']], function() {
		//------------   ROLES  -------
		Route::resource('rol','RolController');
		Route::name('rol.busca')->post('rol/busca','RolController@busca');
		Route::name('rol.update')->post('rol/update','RolController@update');
		//------------   PERMISOS  -------
		Route::resource('permiso','PermisoController');
	});
	Route::group(['middleware' => ['permission:productos']], function() {
		//------------   PRODUCTOS  -------
		Route::resource('producto','ProductoController');
		Route::name('producto.busca')->post('producto/busca','ProductoController@busca');
		Route::name('producto.update')->post('producto/update','ProductoController@update');
	});

	Route::group(['middleware' => ['permission:clientes']], function() {
		//------------   CLIENTES  -------
		Route::resource('cliente','ClienteController');
		Route::name('cliente.update')->post('cliente/update','ClienteController@update');
	});

	Route::group(['middleware' => ['permission:categorias']], function() {
		//------------   CATEGORIAS  -------
		Route::resource('categoria','CategoriaController');
		Route::name('categoria.update')->post('categoria/update','CategoriaController@update');
	});

	Route::group(['middleware' => ['permission:ingresos']], function() {
		//------------   INGRESOS  -------
		Route::resource('ingreso','IngresoController');
		Route::get('/registro/ingreso/{id}', 'IngresoController@ingreso');
		//------------   INGRESO DETALLE  -------
		Route::resource('ingresoDetalle','IngresoDetalleController');
		Route::name('detalle.buscaProductos')->post('detalle/buscaProductos','IngresoDetalleController@buscaProductos');
	});
	Route::group(['middleware' => ['permission:proveedores']], function() {
		//------------   PROVEEDORES  -------
		Route::resource('proveedor','ProveedorController');
		Route::name('proveedor.update')->post('proveedor/update','ProveedorController@update');
	});

	Route::group(['middleware' => ['permission:ventas']], function() {
		//------------   VENTAS  -------
		Route::resource('venta','VentaController');
		Route::get('/registro/venta/{id}', 'VentaController@venta');
		Route::name('venta.finaliza')->post('venta/finaliza','VentaController@finaliza');

		Route::name('venta.eliminarproducto')->post('venta/eliminarproducto','VentaController@eliminarproducto');
		Route::name('venta.udateVenta')->post('venta/udateVenta','VentaController@udateVenta');

		Route::name('producto.busca')->post('producto/busca','ProductoController@busca');
		Route::name('venta.chofer')->post('venta/chofer','VentaController@chofer');
		Route::name('venta.ubicacion')->post('venta/ubicacion','VentaController@ubicacion');
		Route::get('/recibo/{id}', 'VentaController@recibo');
		Route::name('venta.empleado')->post('venta/empleado','VentaController@empleado');
		//------------   VENTAS DETALLE  -------
		Route::resource('ventaDetalle','VentaDetalleController');
		//------------   VENTAS DETALLE  -------
		Route::name('cliente.buscaCedula')->post('cliente/buscaCedula','ClienteController@buscaCedula');

	});

	Route::group(['middleware' => ['permission:cotizaciones']], function() {
		//------------   COTIZACIONES DRYWALL -------
		Route::resource('cotizacion','CotizacionController');
		Route::name('cotizacion.calcula')->post('cotizacion/calcula','CotizacionController@calcula');
		Route::name('cotizacion.guarda')->post('cotizacion/guarda','CotizacionController@guarda');
		Route::get('cotizacion-pdf/{id}', 'CotizacionController@imprimir');
		Route::get('/guardado', 'CotizacionController@guardado');
		Route::get('cotizacion/venta/{id}', 'CotizacionController@venta');
		Route::name('cotizacion.precio')->post('cotizacion/precio','CotizacionController@precio');
		Route::name('cotizacion.confirma')->post('cotizacion/confirma','CotizacionController@confirma');
		Route::get('cotizacion/seguimiento/{id}', 'CotizacionController@seguimiento');

		//------------   COTIZACIONES CIELO -------
		Route::resource('cotizacion_cielo','CotizacionCieloController');
		Route::name('cotizacion_cielo.calcula')->post('cotizacion_cielo/calcula','CotizacionCieloController@calcula');
		Route::name('cotizacion_cielo.guarda')->post('cotizacion_cielo/guarda','CotizacionCieloController@guarda');
		Route::get('cotizacion_cielo-pdf/{id}', 'CotizacionCieloController@imprimir');
		Route::get('/guardado_cielo', 'CotizacionCieloController@guardado');
		Route::get('cotizacion_cielo/venta/{id}', 'CotizacionCieloController@venta');
		Route::name('cotizacion_cielo.confirma')->post('cotizacion_cielo/confirma','CotizacionCieloController@confirma');

		//------------   COTIZACIONES PISO FLOTANTE -------
		Route::resource('cotizacion_piso','CotizacionPisoController');
		Route::name('cotizacion_piso.calcula')->post('cotizacion_piso/calcula','CotizacionPisoController@calcula');
		Route::name('cotizacion_piso.guarda')->post('cotizacion_piso/guarda','CotizacionPisoController@guarda');
		Route::get('cotizacion_piso-pdf/{id}', 'CotizacionPisoController@imprimir');
		Route::get('/guardado_piso', 'CotizacionPisoController@guardado');
		Route::get('cotizacion_piso/venta/{id}', 'CotizacionPisoController@venta');
		Route::name('cotizacion_piso.confirma')->post('cotizacion_piso/confirma','CotizacionPisoController@confirma');
		//------------   COTIZACIONES PERSONALIZADAS -------
		Route::resource('cotizacion_personal','CotizacionPersonalizadaController');
		Route::name('cotizacion_personal.calcula')->post('cotizacion_personal/calcula','CotizacionPersonalizadaController@calcula');
		Route::name('cotizacion_personal.guarda')->post('cotizacion_personal/guarda','CotizacionPersonalizadaController@guarda');
		Route::get('cotizacion_personal-pdf/{id}', 'CotizacionPersonalizadaController@imprimir');
		Route::get('/guardado_personal', 'CotizacionPersonalizadaController@guardado');
		Route::get('cotizacion_personal/venta/{id}', 'CotizacionPersonalizadaController@venta');
		Route::name('cotizacion_personal.confirma')->post('cotizacion_personal/confirma','CotizacionPersonalizadaController@confirma');
		Route::name('cotizacion.finaliza')->post('cotizacion/finaliza','CotizacionController@cotizacion_finaliza');

	});
	Route::group(['middleware' => ['permission:reportes']], function() {
		Route::resource('reporte','ReporteController');

		Route::name('reporte.fechas')->post('reporte/fechas','ReporteController@reporte_fechas');
		Route::get('reporte-fechas/{inicio}/{final}', 'ReporteController@fechas');

		Route::name('reporte.clientes')->post('reporte/clientes','ReporteController@reporte_clientes');
		Route::get('reporte-clientes/{id}', 'ReporteController@clientes');

		Route::name('reporte.productos')->post('reporte/productos','ReporteController@reporte_productos');
		Route::get('reporte-productos/{id}', 'ReporteController@productos');
		Route::get('reporte-ingresos/{inicio}/{final}', 'ReporteController@ingresos');

		Route::resource('grafico','GraficoController');
        Route::name('grafico.rangoFechas')->post('grafico/rangoFechas','GraficoController@rangoFechas');
        Route::name('grafico.rangoGrafic2')->post('grafico/rangoGrafic2','GraficoController@rangoGrafic2');
        Route::name('grafico.rangoGrafic3')->post('grafico/rangoGrafic3','GraficoController@rangoGrafic3');
	});


});
