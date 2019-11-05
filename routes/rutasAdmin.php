<?php

Route::group(['prefix' => 'configuraciones', 'middleware' => 'auth'], function(){
    Route::get('/', 'ConfiguracionController@index')->name('configuracion.index');
});

Route::group(['prefix' => 'aerolinea', 'middleware' => 'auth'], function(){
    Route::get('/', 'AerolineaController@index')->name('aerolinea.index');
    Route::get('lista','AerolineaController@lista')->name('aerolinea.lista');
    Route::get('filtro','AerolineaController@filtro')->name('aerolinea.filtro');
});

Route::group(['prefix' => 'roles', 'middleware' => 'auth'], function(){
    Route::get('/', 'RoleController@index')->name('roles.index');
    Route::get('lista','RoleController@lista')->name('roles.lista');
    Route::get('mostrarEliminados', 'RoleController@showdeletes')->name('roles.showdeletes');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
    Route::get('/', 'UserController@index')->name('user.index');
    Route::get('lista','UserController@lista')->name('user.lista');

});

Route::get('pasajeCreate','PasajeController@create')->name('pasajes.create');
Route::get('pasajeVentas','PasajeController@mostrar')->name('pasajes.ventas');

Route::group(['prefix' => 'pasajes', 'middleware' => 'auth'], function(){
    Route::get('/', 'PasajeController@index')->name('pasajes.index');
    Route::get('lista','PasajeController@lista')->name('pasajes.lista');
    Route::post('guardar','PasajeController@store')->name('role.store');
    Route::get('ventas','PasajeController@listaPorUsuario')->name('pasajes.ventas');
});

Route::group(['prefix' => 'empresas', 'middleware' => 'auth'], function(){
    Route::get('/', 'EmpresaController@index')->name('empresas.index');
    Route::get('lista','EmpresaController@lista')->name('empresas.lista');
    Route::get('filtro','EmpresaController@filtro')->name('empresas.filtro');
});

Route::group(['prefix' => 'lugares', 'middleware' => 'auth'], function(){
    Route::get('/lista', 'LugarController@listarPorUsuario')->name('lugar.listarPorUsuario');

});

Route::group(['prefix' => 'reporte-caja-general', 'middleware' => 'auth'], function(){
    Route::get('/', 'ReporteCajaGeneralController@index')->name('reportecajageneral.index');
    Route::get('/tabla','ReporteCajaGeneralController@tabla')->name('reportecajageneral.tabla');
});

Route::group(['prefix' => 'reporte-plantilla', 'middleware' => 'auth'], function(){
    Route::get('/', 'ReportePlantillaController@index')->name('reporteplantilla.index');
    Route::get('/tabla','ReportePlantillaController@tabla')->name('reporteplantilla.tabla');
});

