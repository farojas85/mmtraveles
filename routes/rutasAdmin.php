<?php

Route::group(['prefix' => 'configuraciones', 'middleware' => 'auth'], function(){
    Route::get('/', 'ConfiguracionController@index')->name('configuracion.index');
});

Route::group(['prefix' => 'aerolinea', 'middleware' => 'auth'], function(){
    Route::get('/', 'AerolineaController@index')->name('aerolinea.index');
    Route::get('lista','AerolineaController@lista')->name('aerolinea.lista');
    Route::get('filtro','AerolineaController@filtro')->name('aerolinea.filtro');
    Route::get('filtro-id','AerolineaController@filtroById')->name('aerolinea.filtro-id');
});

Route::group(['prefix' => 'roles', 'middleware' => 'auth'], function(){
    Route::get('/', 'RoleController@index')->name('roles.index');
    Route::get('lista','RoleController@lista')->name('roles.lista');
    Route::get('filtro','RoleController@filtro')->name('roles.filtro');
    Route::get('mostrarEliminados', 'RoleController@showdeletes')->name('roles.showdeletes');
});

Route::group(['prefix' => 'permissions', 'middleware' => 'auth'], function(){
    Route::get('/', 'PermissionController@index')->name('permisos.index');
    Route::get('lista','PermissionController@lista')->name('permisos.lista');
    Route::get('filtro','PermissionController@filtro')->name('permisos.filtro');
    Route::get('buscar','PermissionController@search')->name('permisos.buscar');
    Route::get('mostrar','PermissionController@show')->name('permisos.mostrar');
    Route::post('guardar','PermissionController@store')->name('permisos.guardar');
    Route::post('actualizar','PermissionController@update')->name('permisos.actualizar');
    Route::post('eliminar','PermissionController@destroy')->name('permisos.eliminar');
});
Route::group(['prefix' => 'permission-role', 'middleware' => 'auth'], function(){
    Route::get('listarPermissionRoles', 'PermissionController@listarPermissionRoles')->name('permisos.listarPermissionRoles');
    Route::post('guardar','PermissionController@guardarPermissionRole')->name('permission-role.guardarPermissionRole');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
    Route::get('/', 'UserController@index')->name('user.index');
    Route::get('lista','UserController@lista')->name('user.lista');
    Route::post('store','UserController@store')->name('user.store');
    Route::get('show','UserController@show');
    Route::put('update','UserController@update');
    Route::post('destroy','UserController@destroy');
    Route::get('search','UserController@search');
});

Route::get('pasajeCreate','PasajeController@create')->name('pasajes.create');
Route::get('pasajeVentas','PasajeController@mostrar')->name('pasajes.ventas');
Route::get('opcionalesVentas','OpcionalController@index')->name('opcional.index');
Route::get('opcionalesListado','OpcionalController@mostrar')->name('opcional.mostrar');
//Route::get('pasajeEditar/{id}','PasajeController@editar')->name('pasaje.editar');

Route::group(['prefix' => 'pasajes', 'middleware' => 'auth'], function(){
    Route::get('/', 'PasajeController@index')->name('pasajes.index');
    Route::get('lista','PasajeController@lista')->name('pasajes.lista');
    Route::post('guardar','PasajeController@store')->name('role.store');
    Route::get('ventas','PasajeController@listaPorUsuario')->name('pasajes.ventas');
    Route::post('destroy','PasajeController@destroy')->name('pasajes.destroy');
    Route::post('eliminarSeleccionados','PasajeController@eliminarSeleccionados')->name('pasajes.eliminarSeleccionados');
});

Route::group(['prefix' => 'pasaje-emitidos', 'middleware' => 'auth'], function(){
    Route::get('/', 'PasajeController@pasajeEmitidos')->name('pasaje-emitidos.index');
    Route::get('activos','PasajeController@reporteEmitidos')->name('pasaje-emitidos.reporte');
    Route::get('todos','PasajeController@todos')->name('pasaje-emitidos.todos');
    Route::get('eliminados','PasajeController@eliminados')->name('pasaje-emitidos.eliminados');
    Route::get('pasaje-adicional','PasajeController@pasajeAdicionales');
    Route::get('listar-lugar','PasajeController@listarLugar');
    Route::get('listar-local','PasajeController@listarLocal');
    Route::get('listar-counter','PasajeController@listarCounter');
    Route::get('show','PasajeController@show');
    Route::get('editar','PasajeController@editar');
    Route::post('eliminar-temporal','PasajeController@eliminarTemporal');
    Route::post('eliminar-permanente','PasajeController@eliminarPermanente');
    Route::post('restaurar','PasajeController@restaurar');
    Route::post('eliminar-seleccionados-temporal','PasajeController@eliminarSeleccionadosTemporal');
    Route::post('eliminar-seleccionados-permanente','PasajeController@eliminarSeleccionadosPermanente');
});

Route::group(['prefix' => 'empresas', 'middleware' => 'auth'], function(){
    Route::get('/', 'EmpresaController@index')->name('empresas.index');
    Route::get('lista','EmpresaController@lista')->name('empresas.lista');
    Route::get('filtro','EmpresaController@filtro')->name('empresas.filtro');
    Route::get('empresaUsuario','EmpresaController@empresaPorUsuario');
    Route::post('store','EmpresaController@store');
    Route::get('mostrarEliminados','EmpresaController@showdelete');
    Route::get('show','EmpresaController@show');
    Route::put('update','EmpresaController@update');
    Route::post('destroy','EmpresaController@destroy');
    Route::post('restaurar','EmpresaController@restoredelete');
});

Route::group(['prefix' => 'locales', 'middleware' => 'auth'], function(){
    Route::get('/', 'LocalController@index')->name('locales.index');
    Route::get('lista','LocalController@lista')->name('locales.lista');
    Route::get('filtro','LocalController@filtro')->name('locales.filtro');
    Route::post('store','LocalController@store');
    Route::get('mostrarEliminados','LocalController@showdelete');
    Route::get('show','LocalController@show');
    Route::put('update','LocalController@update');
    Route::post('destroy','LocalController@destroy');
    Route::post('restaurar','LocalController@restoredelete');
});

Route::group(['prefix' => 'adicional', 'middleware' => 'auth'], function(){
    Route::get('lista','AdicionalController|@lista')->name('adicional.lista');
    Route::get('filtro','AdicionalController@filtro')->name('adicional.filtro');
    Route::get('filtroId','AdicionalController@filtroPorId');
    Route::get('mostrarEliminados','AdicionalController@showdelete');
    Route::get('show','AdicionalController@show');
    Route::put('update','AdicionalController@update');
    Route::post('destroy','AdicionalController@destroy');
    Route::post('restaurar','AdicionalController@restoredelete');
});
Route::group(['prefix' => 'opcional', 'middleware' => 'auth'], function(){
    Route::get('lista','OpcionalController@lista')->name('locales.lista');
    Route::get('filtro','OpcionalController@filtro')->name('locales.filtro');
    Route::post('guardar','OpcionalController@store');
    Route::get('ventas','OpcionalController@listaPorUsuario')->name('opcional.ventas');
    Route::get('mostrarEliminados','OpcionalController@showdelete');
    Route::get('show','OpcionalController@show');
    Route::put('update','OpcionalController@update');
    Route::post('destroy','OpcionalController@destroy');
    Route::post('restaurar','OpcionalController@restoredelete');
});

Route::group(['prefix' => 'lugares', 'middleware' => 'auth'], function(){
    Route::get('/lista', 'LugarController@listarPorUsuario')->name('lugar.listarPorUsuario');
    Route::get('filtro','LugarController@filtro');
});

Route::group(['prefix' => 'tipo-documentos', 'middleware' => 'auth'], function(){
    Route::get('/lista', 'TipoDocumento@listas')->name('tipo-documentos.lista');
    Route::get('filtro','TipoDocumentoController@filtro');
});
Route::group(['prefix' => 'etapa-persona', 'middleware' => 'auth'], function(){
    Route::get('filtro','EtapaPersonaController@filtro');
});

Route::group(['prefix' => 'reporte-caja-general', 'middleware' => 'auth'], function(){
    Route::get('/', 'ReporteCajaGeneralController@index')->name('reportecajageneral.index');
    Route::get('/tabla','ReporteCajaGeneralController@tabla')->name('reportecajageneral.tabla');
    Route::get('listarAerolineas','ReporteCajaGeneralController@listarAerolineas');
    Route::get('lista-usuarios','ReporteCajaGeneralController@listarUsuarios');
    Route::get('editar-adicional','ReporteCajaGeneralController@editarAdicional');
    Route::get('lista-adicional','ReporteCajaGeneralController@obtenerAdicional');
    Route::get('show-pasaje','ReporteCajaGeneralController@showPasajePagado');
    Route::post('guardar-pasaje','ReporteCajaGeneralController@guardarPasajePagado');
    Route::post('actualizar-adicional','ReporteCajaGeneralController@actualizarAdicional');
    Route::post('eliminar-adicional-temporal','ReporteCajaGeneralController@eliminarAdicionalTemporal');
    Route::post('eliminar-adicional-permanente','ReporteCajaGeneralController@eliminarAdicionalPermanente');

});

Route::group(['prefix' => 'graficas', 'middleware' => 'auth'], function(){
    Route::get('local-pagados', 'PasajeController@pagadoLocal');
    Route::get('total-aerolinea','PasajeController@pasajesAerolinea');
    Route::get('resumen-counter','PasajeController@pasajeResumen');
});

Route::group(['prefix' => 'reporte-plantilla', 'middleware' => 'auth'], function(){
    Route::get('/', 'ReportePlantillaController@index')->name('reporteplantilla.index');
    Route::get('/tabla','ReportePlantillaController@tabla')->name('reporteplantilla.tabla');

});
