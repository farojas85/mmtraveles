<?php

use App\Http\Controllers\PasajeController;
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
    Route::post('destroy','PasajeController@destroy')->name('pasajes.destroy');
    Route::post('eliminarSeleccionados','PasajeController@eliminarSeleccionados')->name('pasajes.eliminarSeleccionados');
});

Route::group(['prefix' => 'pasaje-emitidos', 'middleware' => 'auth'], function(){
    Route::get('/', 'PasajeController@pasajeEmitidos')->name('pasaje-emitidos.index');
    Route::get('tabla','PasajeController@reporteEmitidos')->name('pasaje-emitidos.reporte');
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

Route::group(['prefix' => 'tipo-documentos', 'middleware' => 'auth'], function(){
    Route::get('/lista', 'TipoDocumento@listas')->name('tipo-documentos.lista');
    Route::get('filtro','TipoDocumentoController@filtro');
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
    $pasaje_id = Session::get('pasaje_id');
    $user = App\User::with(['roles','local'])->where('id',Auth::user()->id)->first();
    $role_name ='';
    $pasaje = null;
    foreach($user->roles as $role)
    {
        $role_name = $role->name;
    }
    $pasaje = App\Pasaje::with(['user','aerolinea'])->where('id',$pasaje_id)->first();


    $empresa = App\Empresa::where('id','=',$user->local->empresa_id)->first();

    $local = App\Local::join('local_user as lu','locals.id','=','lu.local_id')
                            ->where('lu.user_id',Auth::user()->id)
                            ->first();

    $aerolinea='';
    switch($pasaje->aerolinea_id)
    {
        case 612 : $aerolinea='images/aerolineas/latam.jpg';break;
        case 614 : $aerolinea='images/aerolineas/avianca.png';break;
        case 622 : $aerolinea='images/aerolineas/atsa.jpeg';break;
        case 613 : $aerolinea='images/aerolineas/costamar.png';break;
        case 611 : $aerolinea='images/aerolineas/peruvian.png';break;
        case 615 : $aerolinea='images/aerolineas/starperu.jpg';break;
    }

    $aerolin = App\Aerolinea::findOrFail($pasaje->aerolinea_id);

    //oBTENEMOS EL uSUARIO
    $fpdf->AddPage();
    $fpdf->Image($empresa->foto,2,2,30);
    $fpdf->Image($aerolinea,120,2,60);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(30,25);
    $fpdf->Cell(150,5, 'ELECTRONIC TICKET',0,0,'C',0);
    $fpdf->setXY(30,30);
    $fpdf->Cell(150,5, 'PASSENGER ITINERARY/RECEIPT',0,0,'C',0);
    //detalles empresa
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,44);
    $fpdf->Cell(60,4, trim($empresa->razon_social),0,0,'C',0);
	$fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,48);
    $fpdf->Cell(60,4, $local->nombre,0,0,'L',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,52);
    $fpdf->Cell(60,4,(explode("//",$empresa->direccion))[1],0,0,'L',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,56);
    $fpdf->Cell(60,4,"TELEPHONE/TELEFONO:",0,0,'L',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,60);
    $fpdf->Cell(60,4,"EMAIL/CORREO:",0,0,'L',0);

    //cabecera pasaje
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,44);
    $fpdf->Cell(40,4, utf8_decode('FECHA DE EMISIÓN:'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,44);
    $fpdf->Cell(30,4, explode(" ",$pasaje->created_at)[0],0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
	$fpdf->setXY(110,48);
    $fpdf->Cell(40,4, utf8_decode('N° Ticket:'),0,0,'R',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,48);
    $fpdf->Cell(30,4, $pasaje->ticket_number,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,52);
    $fpdf->Cell(40,4, utf8_decode('NAME/NOMBRE:'),0,0,'R',0);


    $fpdf->SetFont('Courier', '', 8);
    $fpdf->setXY(150,52);
    $fpdf->Cell(40,4, $pasaje->pasajero,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,56);
    $fpdf->Cell(40,4, utf8_decode('FOID/DNI:'),0,0,'R',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,56);
    $fpdf->Cell(40,4,$pasaje->numero_documento,0,0,'L',0);

    //aerolínea
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,70);
    $fpdf->Cell(78,4, utf8_decode('ISSUING AIRLINE/LINEA AEREA EMISORA:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,70);
    $fpdf->Cell(80,4, $aerolin->barcode,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,74);
    $fpdf->Cell(78,4, utf8_decode('ADRESS/DIRECCION:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,74);
    $fpdf->Cell(80,4, $pasaje->direccion,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,78);
    $fpdf->Cell(78,4, utf8_decode('RUC:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,78);
    $fpdf->Cell(60,4, $pasaje->ruc,0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,82);
    $fpdf->Cell(78,4, utf8_decode('TICKET NUMBER/NRO DE BOLETO:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,82);
    $fpdf->Cell(60,4, $pasaje->ticket_number,0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,86);
    $fpdf->Cell(78,4, utf8_decode('BOOKING REF./CODIGO DE RESERVA:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,86);
    $fpdf->Cell(50,4, $pasaje->viajecode,0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,96);
    $fpdf->Cell(90,4, utf8_decode('DETALLES DE  VUELO /ITINERARIO DE VUELO:'),0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,104);
    $fpdf->Cell(40,4, utf8_decode('Desde/Hacia'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,108);
    $fpdf->Cell(40,4, $pasaje->ruta,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(60,104);
    $fpdf->Cell(40,4, utf8_decode('Vuelo'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,108);
    $fpdf->Cell(40,4, $pasaje->vuelo,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(100,104);
    $fpdf->Cell(10,4, utf8_decode('CL'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(100,108);
    $fpdf->Cell(10,4, $pasaje->cl,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,104);
    $fpdf->Cell(20,4, utf8_decode('FECHA'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(110,108);
    $fpdf->Cell(20,4, $pasaje->fecha_vuelo,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(130,104);
    $fpdf->Cell(20,4, utf8_decode('HORA'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(130,108);
    $fpdf->Cell(20,4, $pasaje->hora_vuelo,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(150,104);
    $fpdf->Cell(15,4, utf8_decode('ST'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,108);
    $fpdf->Cell(15,4, trim($pasaje->st),0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(165,104);
    $fpdf->Cell(20,4, utf8_decode('BAG/EQP'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(165,108);
    $fpdf->Cell(20,4, $pasaje->equipaje,0,0,'C',0);

    //deetalle montos
    $moneda = ($pasaje->moneda == 'PEN') ? 'S/' : 'USD';

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,116);
    $fpdf->Cell(40,4, utf8_decode('AIR FARE/TARIFA :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,116);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->tarifa,2),0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,120);
    $fpdf->Cell(40,4, utf8_decode('TAX/TUAA :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,120);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->tax,2)." PE",0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(90,120);
    $fpdf->Cell(30,4,number_format($pasaje->tax*$pasaje->cambio,2)." OD",0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,124);
    $fpdf->Cell(40,4, utf8_decode('SERVICE FEE  :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,124);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->service_fee,2),0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,128);
    $fpdf->Cell(40,4, utf8_decode('TOTAL :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,128);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->total,2),0,0,'L',0);

    //POLITICAS DE VUELO
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->setXY(20,140);
    $fpdf->Cell(165,4, utf8_decode('ESTE DOCUMENTO ES ACEPTADO TRIBUTARIAMENTE POR LA SUNAT'),1,1,'C',1);

    $fpdf->SetFont('Courier', '', 7);
    $fpdf->SetFillColor(255,255,255);
    $fpdf->setXY(20,146);
    $fpdf->MultiCell(165,4, utf8_decode('TODO PASAJERO DEBE PRESENTARDE CON LA DOCUMENTACION CORRESPONDIENTE EN EL COUNTER , DEBERA PRESENTARSE 02 HORAS ANTES DE LA SALIDA DE VUELO PROGRAMADO.'),0,'J',0);
    $fpdf->setXY(20,150);
    $fpdf->MultiCell(165,4, utf8_decode('PARA REALISAR EL CHECK-IN Y DECLARACION  DE LOS EQUIPAJES ,EL VUELO CIERRA 45 MINUTOS ANTES  EN CASO DE NO PRESENTARSE EN EL HORARIO ESTABLECIDO SERA CATALOGADO.'),0,'J',0);
    $fpdf->setXY(20,164);
    $fpdf->MultiCell(165,4, utf8_decode('COMO NO SHOW, PASAJERO CON ALGUNA NESECIDADO O CONDICION MEDICA  DEBE INFORMAR AL MOMENTO DE REALIZAR LA COMPRA , AL MOMENTO DE REALIZAR EL VIAJE.'),0,'J',0);
    $fpdf->setXY(20,172);
    $fpdf->MultiCell(165,4, utf8_decode('DEVOLUCIONES: SON TARIFAS NO REEMBOLSABLES DE ACUERDO A CADA POLITICA DE CADA LINEA AEREA.'),0,'J',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->setXY(20,182);
    $fpdf->Cell(165,4, utf8_decode('POLÍTICAS  Y CONDICIONES DE COMPRA '),1,1,'C',1);

     $fpdf->SetFont('Courier', '', 6);
    $fpdf->SetFillColor(255,255,255);
    $fpdf->setXY(20,186);
    $fpdf->MultiCell(165,4, utf8_decode('CANCELACIONES POR NO PAGO:ATSA SE RESERVA EL DERECHO DE EMBARQUE EN CASO NO SE HAYA CUMPLIDO CON EL PAGO OPORTUNO DE LA RESERVA GENERADA A TRAVES DE UNO DE LOS CANALES AUTORIZADOS O SI EL BOLETO HA SIDO ADQUIRIDO POR MEDIOS ILICITOS.'),0,'J',0);
    $fpdf->setXY(20,194);
    $fpdf->MultiCell(165,4, utf8_decode('VIGENCIA DEL PASAJE:LA VIGENCIA DE SU BOLETO ES DE 01 ANO COMO DOCUMENTO A CONTAR DE LA FECHA DE EMISION, SIN EMBARGO CONSIDERAR LA VALIDEZ DE LA TARIFA ADQUIRIDA (MAYOR DETALLE EN TERMINOS Y CONDICIONES).'),0,'J',0);
    $fpdf->setXY(20,202);
    $fpdf->MultiCell(165,4, utf8_decode('CAMBIOS:CONSIDERAR LAS REGULACIONES TARIFARIAS DETALLADAS EN TERMINOS Y CONDICIONES DE NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
    $fpdf->setXY(20,206);
    $fpdf->MultiCell(165,4, utf8_decode('EQUIPAJE:CONSIDERAR LA INFORMACION QUE SE ENCUENTRA DETALLADA EN POLITICA DE EQUIPAJE EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
    $fpdf->setXY(20,214);
    $fpdf->MultiCell(165,4, utf8_decode('TRANSPORTE DE MENORES NO ACOMPANADOS:FAVOR CONSIDERAR LA DOCUMENTACION REQUERIDA PARA EL TRANSPORTE DE UN MENOR VIAJANDO SOLO.PARA MAYOR DETALLE INGRESAR A SERVICIOS ESPECIALES EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM. NO SE ACEPTARAN INFANTES NI NINOS QUE NO HAYAN ALCANZADO 05 ANOS DE EDAD, VIAJANDO SOLOS.'),0,'J',0);
    $fpdf->setXY(20,226);
    $fpdf->MultiCell(165,4, utf8_decode('POR CUALQUIER OTRA CONSULTA,COMUNIQUESE AL TELEFONO 717-3268,AL CORREO ATSAAIRLINES@ATSAPERU.COM O VISITE WWW.ATSAAIRLINES.COM.'),0,'J',0);

    $fpdf->Image('images/sellos.PNG',100,230,100);
    $fpdf->Output();
});

Route::get('imprimirPasaje/{pasaje_id}', function ($pasaje_id) {
    $fpdf = new Fpdf();

    $pasaje_id = $pasaje_id;
    $user = App\User::with(['roles','local'])->where('id',Auth::user()->id)->first();
    $role_name ='';
    $pasaje = null;
    foreach($user->roles as $role)
    {
        $role_name = $role->name;
    }
    $pasaje = App\Pasaje::with(['user','aerolinea'])->where('id',$pasaje_id)->first();


    $local = App\Local::join('local_user as lu','locals.id','=','lu.local_id')
                            ->where('lu.user_id',$pasaje->counter_id)
                            ->first();

    $empresa = App\Empresa::where('id','=',$local->empresa->id)->first();


    $aerolinea='';
    switch($pasaje->aerolinea_id)
    {
        case 612 : $aerolinea='images/aerolineas/latam.jpg';break;
        case 614 : $aerolinea='images/aerolineas/avianca.png';break;
        case 622 : $aerolinea='images/aerolineas/atsa.jpeg';break;
        case 613 : $aerolinea='images/aerolineas/costamar.png';break;
        case 611 : $aerolinea='images/aerolineas/peruvian.png';break;
        case 615 : $aerolinea='images/aerolineas/starperu.jpg';break;
    }

    $aerolin = App\Aerolinea::findOrFail($pasaje->aerolinea_id);

    //oBTENEMOS EL uSUARIO
    $fpdf->AddPage();
    $fpdf->Image($empresa->foto,2,2,40);
    $fpdf->Image($aerolinea,120,2,50);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(30,25);
    $fpdf->Cell(150,5, 'ELECTRONIC TICKET',0,0,'C',0);
    $fpdf->setXY(30,30);
    $fpdf->Cell(150,5, 'PASSENGER ITINERARY/RECEIPT',0,0,'C',0);
    //detalles empresa
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,44);
    $fpdf->Cell(60,4, trim($empresa->razon_social),0,0,'C',0);
	$fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,48);
    $fpdf->Cell(60,4, $local->nombre,0,0,'L',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,52);
    $fpdf->Cell(60,4,(explode("//",$empresa->direccion))[1],0,0,'L',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,56);
    $fpdf->Cell(60,4,"TELEPHONE/TELEFONO:",0,0,'L',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,60);
    $fpdf->Cell(60,4,"EMAIL/CORREO:",0,0,'L',0);

    //cabecera pasaje
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,44);
    $fpdf->Cell(40,4, utf8_decode('FECHA DE EMISIÓN:'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,44);
    $fpdf->Cell(30,4, explode(" ",$pasaje->created_at)[0],0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
	$fpdf->setXY(110,48);
    $fpdf->Cell(40,4, utf8_decode('N° Ticket:'),0,0,'R',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,48);
    $fpdf->Cell(30,4, $pasaje->ticket_number,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,52);
    $fpdf->Cell(40,4, utf8_decode('NAME/NOMBRE:'),0,0,'R',0);


    $fpdf->SetFont('Courier', '', 8);
    $fpdf->setXY(150,52);
    $fpdf->Cell(40,4, $pasaje->pasajero,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,56);
    $fpdf->Cell(40,4, utf8_decode('FOID/DNI:'),0,0,'R',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,56);
    $fpdf->Cell(40,4,$pasaje->numero_documento,0,0,'L',0);

    //aerolínea
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,70);
    $fpdf->Cell(78,4, utf8_decode('ISSUING AIRLINE/LINEA AEREA EMISORA:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,70);
    $fpdf->Cell(80,4, $aerolin->barcode,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,74);
    $fpdf->Cell(78,4, utf8_decode('ADRESS/DIRECCION:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,74);
    $fpdf->Cell(80,4, $pasaje->direccion,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,78);
    $fpdf->Cell(78,4, utf8_decode('RUC:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,78);
    $fpdf->Cell(60,4, $pasaje->ruc,0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,82);
    $fpdf->Cell(78,4, utf8_decode('TICKET NUMBER/NRO DE BOLETO:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,82);
    $fpdf->Cell(60,4, $pasaje->ticket_number,0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,86);
    $fpdf->Cell(78,4, utf8_decode('BOOKING REF./CODIGO DE RESERVA:'),0,0,'',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(98,86);
    $fpdf->Cell(50,4, $pasaje->viajecode,0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,96);
    $fpdf->Cell(90,4, utf8_decode('DETALLES DE  VUELO /ITINERARIO DE VUELO:'),0,0,'',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,104);
    $fpdf->Cell(40,4, utf8_decode('Desde/Hacia'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(20,108);
    $fpdf->Cell(40,4, $pasaje->ruta,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(60,104);
    $fpdf->Cell(40,4, utf8_decode('Vuelo'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,108);
    $fpdf->Cell(40,4, $pasaje->vuelo,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(100,104);
    $fpdf->Cell(10,4, utf8_decode('CL'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(100,108);
    $fpdf->Cell(10,4, $pasaje->cl,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(110,104);
    $fpdf->Cell(20,4, utf8_decode('FECHA'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(110,108);
    $fpdf->Cell(20,4, $pasaje->fecha_vuelo,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(130,104);
    $fpdf->Cell(20,4, utf8_decode('HORA'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(130,108);
    $fpdf->Cell(20,4, $pasaje->hora_vuelo,0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(150,104);
    $fpdf->Cell(15,4, utf8_decode('ST'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(150,108);
    $fpdf->Cell(15,4, trim($pasaje->st),0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(165,104);
    $fpdf->Cell(20,4, utf8_decode('BAG/EQP'),0,0,'C',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(165,108);
    $fpdf->Cell(20,4, $pasaje->equipaje,0,0,'C',0);

    //deetalle montos
    $moneda = ($pasaje->moneda == 'PEN') ? 'S/' : 'USD';

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,116);
    $fpdf->Cell(40,4, utf8_decode('AIR FARE/TARIFA :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,116);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->tarifa,2),0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,120);
    $fpdf->Cell(40,4, utf8_decode('TAX/TUAA :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,120);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->tax,2)." PE",0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(90,120);
    $fpdf->Cell(30,4,number_format($pasaje->tax*$pasaje->cambio,2)." OD",0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,124);
    $fpdf->Cell(40,4, utf8_decode('SERVICE FEE  :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,124);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->service_fee,2),0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(20,128);
    $fpdf->Cell(40,4, utf8_decode('TOTAL :'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(60,128);
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->total,2),0,0,'L',0);

    //POLITICAS DE VUELO
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->setXY(20,140);
    $fpdf->Cell(165,4, utf8_decode('ESTE DOCUMENTO ES ACEPTADO TRIBUTARIAMENTE POR LA SUNAT'),1,1,'C',1);

    $fpdf->SetFont('Courier', '', 7);
    $fpdf->SetFillColor(255,255,255);
    $fpdf->setXY(20,146);
    $fpdf->MultiCell(165,4, utf8_decode('TODO PASAJERO DEBE PRESENTARDE CON LA DOCUMENTACION CORRESPONDIENTE EN EL COUNTER , DEBERA PRESENTARSE 02 HORAS ANTES DE LA SALIDA DE VUELO PROGRAMADO.'),0,'J',0);
    $fpdf->setXY(20,150);
    $fpdf->MultiCell(165,4, utf8_decode('PARA REALISAR EL CHECK-IN Y DECLARACION  DE LOS EQUIPAJES ,EL VUELO CIERRA 45 MINUTOS ANTES  EN CASO DE NO PRESENTARSE EN EL HORARIO ESTABLECIDO SERA CATALOGADO.'),0,'J',0);
    $fpdf->setXY(20,164);
    $fpdf->MultiCell(165,4, utf8_decode('COMO NO SHOW, PASAJERO CON ALGUNA NESECIDADO O CONDICION MEDICA  DEBE INFORMAR AL MOMENTO DE REALIZAR LA COMPRA , AL MOMENTO DE REALIZAR EL VIAJE.'),0,'J',0);
    $fpdf->setXY(20,172);
    $fpdf->MultiCell(165,4, utf8_decode('DEVOLUCIONES: SON TARIFAS NO REEMBOLSABLES DE ACUERDO A CADA POLITICA DE CADA LINEA AEREA.'),0,'J',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->setXY(20,182);
    $fpdf->Cell(165,4, utf8_decode('POLÍTICAS  Y CONDICIONES DE COMPRA '),1,1,'C',1);

     $fpdf->SetFont('Courier', '', 6);
    $fpdf->SetFillColor(255,255,255);
    $fpdf->setXY(20,186);
    $fpdf->MultiCell(165,4, utf8_decode('CANCELACIONES POR NO PAGO:ATSA SE RESERVA EL DERECHO DE EMBARQUE EN CASO NO SE HAYA CUMPLIDO CON EL PAGO OPORTUNO DE LA RESERVA GENERADA A TRAVES DE UNO DE LOS CANALES AUTORIZADOS O SI EL BOLETO HA SIDO ADQUIRIDO POR MEDIOS ILICITOS.'),0,'J',0);
    $fpdf->setXY(20,194);
    $fpdf->MultiCell(165,4, utf8_decode('VIGENCIA DEL PASAJE:LA VIGENCIA DE SU BOLETO ES DE 01 ANO COMO DOCUMENTO A CONTAR DE LA FECHA DE EMISION, SIN EMBARGO CONSIDERAR LA VALIDEZ DE LA TARIFA ADQUIRIDA (MAYOR DETALLE EN TERMINOS Y CONDICIONES).'),0,'J',0);
    $fpdf->setXY(20,202);
    $fpdf->MultiCell(165,4, utf8_decode('CAMBIOS:CONSIDERAR LAS REGULACIONES TARIFARIAS DETALLADAS EN TERMINOS Y CONDICIONES DE NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
    $fpdf->setXY(20,206);
    $fpdf->MultiCell(165,4, utf8_decode('EQUIPAJE:CONSIDERAR LA INFORMACION QUE SE ENCUENTRA DETALLADA EN POLITICA DE EQUIPAJE EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
    $fpdf->setXY(20,214);
    $fpdf->MultiCell(165,4, utf8_decode('TRANSPORTE DE MENORES NO ACOMPANADOS:FAVOR CONSIDERAR LA DOCUMENTACION REQUERIDA PARA EL TRANSPORTE DE UN MENOR VIAJANDO SOLO.PARA MAYOR DETALLE INGRESAR A SERVICIOS ESPECIALES EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM. NO SE ACEPTARAN INFANTES NI NINOS QUE NO HAYAN ALCANZADO 05 ANOS DE EDAD, VIAJANDO SOLOS.'),0,'J',0);
    $fpdf->setXY(20,226);
    $fpdf->MultiCell(165,4, utf8_decode('POR CUALQUIER OTRA CONSULTA,COMUNIQUESE AL TELEFONO 717-3268,AL CORREO ATSAAIRLINES@ATSAPERU.COM O VISITE WWW.ATSAAIRLINES.COM.'),0,'J',0);

    $fpdf->Image('images/sellos.PNG',100,230,100);
    $fpdf->Output();
});









