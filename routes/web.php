<?php

use App\Exports\PasajesExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/excelReporte', function () {
    $datos = Session()->get('pasajes');
    
    return Excel::download(new PasajesExport($datos), 'Pasaje.xlsx');
})->middleware('auth');


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Rutas Administrador
require __DIR__.'/rutasAdmin.php';
