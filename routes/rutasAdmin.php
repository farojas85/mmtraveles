<?php

use Codedge\Fpdf\Fpdf\Fpdf;

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
    Route::get('filtro','RoleController@filtro')->name('roles.filtro');
    Route::get('mostrarEliminados', 'RoleController@showdeletes')->name('roles.showdeletes');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
    Route::get('/', 'UserController@index')->name('user.index');
    Route::get('lista','UserController@lista')->name('user.lista');
    Route::post('store','UserController@store')->name('user.store');
    Route::get('show','UserController@show');
    Route::put('update','UserController@update');
    Route::post('destroy','UserController@destroy');
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


Route::group(['prefix' => 'lugares', 'middleware' => 'auth'], function(){
    Route::get('/lista', 'LugarController@listarPorUsuario')->name('lugar.listarPorUsuario');
    Route::get('filtro','LugarController@filtro');
});

Route::group(['prefix' => 'reporte-caja-general', 'middleware' => 'auth'], function(){
    Route::get('/', 'ReporteCajaGeneralController@index')->name('reportecajageneral.index');
    Route::get('/tabla','ReporteCajaGeneralController@tabla')->name('reportecajageneral.tabla');
});

Route::group(['prefix' => 'reporte-plantilla', 'middleware' => 'auth'], function(){
    Route::get('/', 'ReportePlantillaController@index')->name('reporteplantilla.index');
    Route::get('/tabla','ReportePlantillaController@tabla')->name('reporteplantilla.tabla');
});

Route::get('pasajePdf', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {
    ob_end_clean();
    $fpdf->AddPage();
    $fpdf->SetFont('Courier', 'B', 18);
    $fpdf->Cell(50, 25, 'Hello World!');
    $fpdf->Output();
});
