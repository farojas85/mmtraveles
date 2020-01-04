<?php

use App\Http\Controllers\PasajeController;
use Codedge\Fpdf\Fpdf\Fpdf;

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

    $local = App\Local::where('id',$user->local_id)->first();

    $aerolinea='';
    switch($pasaje->aerolinea_id)
    {
        case 611 : $aerolinea='images/aerolineas/peruvian.png';break;
        case 612 : $aerolinea='images/aerolineas/latam.jpg';break;
        case 613 : $aerolinea='images/aerolineas/costamar.png';break;
        case 614 : $aerolinea='images/aerolineas/avianca.png';break;
        case 615 : $aerolinea='images/aerolineas/starperu.jpg';break;
        case 616 : $aerolinea='images/aerolineas/viva_air.png';break;
        case 617 : case 621 : $aerolinea='images/aerolineas/starperu.jpg';break;
        case 622 : $aerolinea='images/aerolineas/atsa.jpeg';break;
        case 623 : $aerolinea='images/aerolineas/aero_mexico.jpg';break;
        case 628 : $aerolinea='images/aerolineas/sky.jpg';break;

    }

    $aerolin = App\Aerolinea::findOrFail($pasaje->aerolinea_id);

     switch($empresa->id)
    {
        case 1 : $ancho = 40;break;
        case 2 : $ancho = 60;break;
        case 3 : $ancho = 50;break;
        case 4 ; $ancho = 50;break;
    }
    //oBTENEMOS EL uSUARIO
    $fpdf->AddPage();
    $fpdf->SetAutoPageBreak(false,15);
    $fpdf->Image($empresa->foto,2,2,$ancho);
    if($pasaje->aerolinea_id==622)
    {
    $fpdf->Image($aerolinea,120,4,80);
    }
    else {
    $fpdf->Image($aerolinea,130,2,40);
    }
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

    $fpdf->SetFont('Courier', '', 7);
    $fpdf->setXY(98,74);
    $fpdf->Cell(80,4,mb_substr($pasaje->direccion,0,48),0,0,'L',0);

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

    $fpdf->setXY(60,104);
    $fpdf->Cell(40,4, utf8_decode('Vuelo'),0,0,'C',0);

    $fpdf->setXY(100,104);
    $fpdf->Cell(10,4, utf8_decode('CL'),0,0,'C',0);

    $fpdf->setXY(110,104);
    $fpdf->Cell(20,4, utf8_decode('FECHA'),0,0,'C',0);

    $fpdf->setXY(130,104);
    $fpdf->Cell(20,4, utf8_decode('HORA'),0,0,'C',0);

    $fpdf->setXY(150,104);
    $fpdf->Cell(15,4, utf8_decode('ST'),0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(165,104);
    $fpdf->Cell(20,4, utf8_decode('BAG/EQP'),0,0,'C',0);


    $fpdf->SetFont('Courier', '', 10);

    if($pasaje->tipo_viaje == 2)
    {
        $fpdf->setXY(20,108);
        $fpdf->Cell(40,4,$pasaje->ruta,0,0,'C',0);

        $fpdf->setXY(20,112);
        $fpdf->Cell(40,4,$pasaje->ruta_vuelta,0,0,'C',0);

        $fpdf->setXY(60,108);
        $fpdf->Cell(40,4, $pasaje->vuelo,0,0,'C',0);

        $fpdf->setXY(60,112);
        $fpdf->Cell(40,4, $pasaje->vuelo_vuelta,0,0,'C',0);

        $fpdf->setXY(100,108);
        $fpdf->Cell(10,4, $pasaje->cl,0,0,'C',0);

        $fpdf->setXY(100,112);
        $fpdf->Cell(10,4, $pasaje->cl_vuelta,0,0,'C',0);

        $fpdf->setXY(110,108);
        $fpdf->Cell(20,4, $pasaje->fecha_vuelo,0,0,'C',0);

        $fpdf->setXY(110,112);
        $fpdf->Cell(20,4, $pasaje->fecha_retorno,0,0,'C',0);

        $fpdf->setXY(130,108);
        $fpdf->Cell(20,4, $pasaje->hora_vuelo,0,0,'C',0);

        $fpdf->setXY(130,112);
        $fpdf->Cell(20,4, $pasaje->hora_vuelta,0,0,'C',0);

        $fpdf->setXY(150,108);
        $fpdf->Cell(15,4, trim($pasaje->st),0,0,'C',0);

        $fpdf->setXY(150,112);
        $fpdf->Cell(15,4, trim($pasaje->st_vuelta),0,0,'C',0);

        $fpdf->setXY(165,108);
        $fpdf->Cell(20,4, $pasaje->equipaje,0,0,'C',0);

        $fpdf->setXY(165,112);
        $fpdf->Cell(20,4, $pasaje->equipaje_vuelta,0,0,'C',0);
    }
    else {

        $fpdf->setXY(20,108);
        $fpdf->Cell(40,4,$pasaje->ruta,0,0,'C',0);

        $fpdf->setXY(60,108);
        $fpdf->Cell(40,4, $pasaje->vuelo,0,0,'C',0);

        $fpdf->setXY(100,108);
        $fpdf->Cell(10,4, $pasaje->cl,0,0,'C',0);

        $fpdf->setXY(110,108);
        $fpdf->Cell(20,4, $pasaje->fecha_vuelo,0,0,'C',0);

        $fpdf->setXY(130,108);
        $fpdf->Cell(20,4, $pasaje->hora_vuelo,0,0,'C',0);

        $fpdf->setXY(150,108);
        $fpdf->Cell(15,4, trim($pasaje->st),0,0,'C',0);

         $fpdf->setXY(165,108);
        $fpdf->Cell(20,4, $pasaje->equipaje,0,0,'C',0);
    }

    $fpdf->SetFont('Courier', '', 10);

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
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->tax,2)." OD",0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(90,120);
    $fpdf->Cell(30,4,number_format($pasaje->igv,2)." OD",0,0,'L',0);
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
    $fpdf->MultiCell(165,3, utf8_decode('TODO PASAJERO DEBE PRESENTARDE CON LA DOCUMENTACION CORRESPONDIENTE EN EL COUNTER , DEBERA PRESENTARSE 02 HORAS ANTES DE LA SALIDA DE VUELO PROGRAMADO.'),0,'J',0);
    $fpdf->setXY(20,154);
    $fpdf->MultiCell(165,3, utf8_decode('PARA REALISAR EL CHECK-IN Y DECLARACION  DE LOS EQUIPAJES ,EL VUELO CIERRA 45 MINUTOS ANTES  EN CASO DE NO PRESENTARSE EN EL HORARIO ESTABLECIDO SERA CATALOGADO.'),0,'J',0);
    $fpdf->setXY(20,162);
    $fpdf->MultiCell(165,3, utf8_decode('COMO NO SHOW, PASAJERO CON ALGUNA NESECIDADO O CONDICION MEDICA  DEBE INFORMAR AL MOMENTO DE REALIZAR LA COMPRA , AL MOMENTO DE REALIZAR EL VIAJE.'),0,'J',0);
    $fpdf->setXY(20,170);
    $fpdf->MultiCell(165,3, utf8_decode('DEVOLUCIONES: SON TARIFAS NO REEMBOLSABLES DE ACUERDO A CADA POLITICA DE CADA LINEA AEREA.'),0,'J',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->setXY(20,176);
    $fpdf->Cell(165,4, utf8_decode('POLÍTICAS  Y CONDICIONES DE COMPRA '),1,1,'C',1);

    $fpdf->Image('images/sellos.PNG',100,230,100);
    $cond_y=182;
    if($pasaje->aerolinea_id == 622)
    {
        $fpdf->SetFont('Courier', '', 6);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('CANCELACIONES POR NO PAGO:ATSA SE RESERVA EL DERECHO DE EMBARQUE EN CASO NO SE HAYA CUMPLIDO CON EL PAGO OPORTUNO DE LA RESERVA GENERADA A TRAVES DE UNO DE LOS CANALES AUTORIZADOS O SI EL BOLETO HA SIDO ADQUIRIDO POR MEDIOS ILICITOS.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('VIGENCIA DEL PASAJE:LA VIGENCIA DE SU BOLETO ES DE 01 ANO COMO DOCUMENTO A CONTAR DE LA FECHA DE EMISION, SIN EMBARGO CONSIDERAR LA VALIDEZ DE LA TARIFA ADQUIRIDA (MAYOR DETALLE EN TERMINOS Y CONDICIONES).'),0,'J',0);
        $fpdf->setXY(20,$cond_y+16);
        $fpdf->MultiCell(165,3, utf8_decode('CAMBIOS:CONSIDERAR LAS REGULACIONES TARIFARIAS DETALLADAS EN TERMINOS Y CONDICIONES DE NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+20);
        $fpdf->MultiCell(165,3, utf8_decode('EQUIPAJE:CONSIDERAR LA INFORMACION QUE SE ENCUENTRA DETALLADA EN POLITICA DE EQUIPAJE EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+28);
        $fpdf->MultiCell(165,3, utf8_decode('TRANSPORTE DE MENORES NO ACOMPANADOS:FAVOR CONSIDERAR LA DOCUMENTACION REQUERIDA PARA EL TRANSPORTE DE UN MENOR VIAJANDO SOLO.PARA MAYOR DETALLE INGRESAR A SERVICIOS ESPECIALES EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM. NO SE ACEPTARAN INFANTES NI NINOS QUE NO HAYAN ALCANZADO 05 ANOS DE EDAD, VIAJANDO SOLOS.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+38);
        $fpdf->MultiCell(165,3, utf8_decode('POR CUALQUIER OTRA CONSULTA,COMUNIQUESE AL TELEFONO 717-3268,AL CORREO ATSAAIRLINES@ATSAPERU.COM O VISITE WWW.ATSAAIRLINES.COM.'),0,'J',0);
         $fpdf->SetFont('Courier', '', 7);
        $fpdf->setXY(20,$cond_y+104);
        $fpdf->MultiCell(165,3, utf8_decode('*PRESENTARSE EN COUNTER 02 HORAS ANTES DE SU VUELO PARA RECIBIR SU TARJETA/EQUIPAJE /01 Equipaje de Mano 05Kg por Pasajero '.
                                            ' / Equipaje de Bodega / 10 Kg. por Pasajero / No se permite Exceso de Equipaje'),0,'J',0);

    }
    else if($pasaje->aerolinea_id == 628) {
        $fpdf->SetFont('Courier', '', 5);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE Y OTROS SERVICIOS PROVISTOS POR LA COMPAÑÍA ESTÁN SUJETOS A LAS CONDICIONES DE TRANSPORTE, LAS CUALES SE INCORPORAN POR REFERENCIA. ESTAS CONDICIONES PUEDEN SER OBTENIDAS DE LA COMPAÑÍA EMISORA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('EL ITINERARIO/RECIBO CONSTITUYE EL BILLETE DE PASAJE A EFECTOS DEL ARTICULO 3 DE LA CONVENCION DE VARSOVIA, A MENOS QUE EL TRANSPORTISTA ENTREGUE AL PASAJERO OTRO DOCUMENTO QUE CUMPLA CON LOS REQUISITOS DEL ARTICULO 3.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+16);
        $fpdf->MultiCell(165,3, utf8_decode('SE INFORMA A LOS PASAJEROS QUE REALICEN VIAJES EN LOS QUE EL PUNTO DE DESTINO O UNA O MAS ESCALAS INTERMEDIAS SE EFECTUEN '.
                                            'EN UN PAIS QUE NO SEA EL DE PARTIDA DE SU VUELO, QUE PUEDEN SER DE APLICACION A LA TOTALIDAD DE SU VIAJE, INCLUIDA CUALQUIER '.
                                            'PARTE DEL MISMO DENTRO DE UN PAIS, LOS TRATADOS INTERNACIONALES COMO LA CONVENCION DE MONTREAL O SU PREDECESOR LA CONVENCION '.
                                            'DE VARSOVIA, INCLUYENDO SUS MODIFICACIONES (EL SISTEMA DE CONVENCION DE VARSOVIA).  EN EL CASO DE AQUELLOS PASAJEROS, EL '.
                                            'TRATADO APLICABLE, INCLUYENDO LAS CONDICIONES ESPECIALES DEL TRANSPORTE INCORPORADAS A CUALQUIER TARIFA APLICABLE, RIGE Y '.
                                            'PUEDE LIMITAR LA RESPONSABILIDAD DEL TRANSPORTISTA EN CASOS DE MUERTE O LESIONES PERSONALES, PERDIDA O DANOS AL EQUIPAJE Y RETRASOS.'),0,'J',0);

        $fpdf->setXY(20,$cond_y+34);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE DE MATERIALES PELIGROSOS TALES COMO AEROSOLES, FUEGOS ARTIFICIALES Y LIQUIDOS INFLAMABLES A BORDO DEL AVION '.
                                            'QUEDA ESTRICTAMENTE PROHIBIDO. SI USTED NO COMPRENDE ESTAS RESTRICCIONES, SIRVASE OBTENER MAYOR PARTIDA DE SU VUELO, QUE '.
                                            'PUEDEN SER DE APLICACION A LA TOTALIDAD DE SU VIAJE, INCLUIDA CUALQUIER PARTE DEL MISMO DENTRO DE UN PAIS, LOS TRATADOS '.
                                            'INTERNACIONALES COMO LA CONVENCION DE MONTREAL O SU PREDECESOR LA CONVENCION DE VARSOVIA, INCLUYENDO SUS MODIFICACIONES '.
                                            '(EL SISTEMA DE CONVENCION DE VARSOVIA).'),0,'J',0);
        $fpdf->SetFont('Courier', '', 4);
        $fpdf->setXY(20,$cond_y+48);
        $fpdf->MultiCell(80,3, utf8_decode('EN EL CASO DE AQUELLOS PASAJEROS, EL TRATADO APLICABLE, INCLUYENDO LAS CONDICIONES '.
                                            'ESPECIALES DEL TRANSPORTE INCORPORADAS A CUALQUIER TARIFA APLICABLE, RIGE Y PUEDE LIMITAR LA RESPONSABILIDAD DEL TRANSPORTISTA'.
                                            'EN CASOS DE MUERTE O LESIONES PERSONALES, PERDIDA O DANOS AL EQUIPAJE Y RETRASOS.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+60);
        $fpdf->MultiCell(80,3, utf8_decode('EL TRANSPORTE DE MATERIALES PELIGROSOS TALES COMO AEROSOLES, FUEGOS ARTIFICIALES Y LIQUIDOS INFLAMABLES A BORDO DEL AVION '.
                                            'QUEDA ESTRICTAMENTE PROHIBIDO. SI USTED NO COMPRENDE ESTAS RESTRICCIONES, SIRVASE OBTENER MAYOR INFORMACION A TRAVES DE SU COMPANIA AEREA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+70);
        $fpdf->MultiCell(80,3, utf8_decode('AVISO DE PROTECCION DE DATOS:US DATOS PERSONALES SE PROCESARAN DE ACUERDO CON LA POLITICA DE PRIVACIDAD DEL PROVEEDOR CORRESPONDIENTE Y, '.
                                            'SI SU RESERVA SE REALIZA A TRAVES DE UN PROVEEDOR DEL SISTEMA DE RESERVAS ( GDS "), CON SU POLITICA DE PRIVACIDAD. ESTAS POLITICAS SE '.
                                            'PUEDEN CONSULTAR EN http://www.iatatravelcenter.com/privacy O DESDE EL OPERADOR O GDS DIRECTAMENTE. DEBE LEER ESTA DOCUMENTACION, QUE '.
                                            'SE APLICA A SU RESERVA Y DESCRIBE, POR EJEMPLO, COMO SE RECOPILAN, ALMACENAN, USAN, PUBLICAN Y TRANSFIEREN SUS DATOS PERSONALES. '.
                                            '(TAMBIEN APLICABLE PARA ITINERARIOS QUE INCLUYEN MULTIPLES AEROLINEAS).'),0,'J',0);
    }
    else if($pasaje->aerolinea_id == 612 || $pasaje->aerolinea_id == 614 || $pasaje->aerolinea_id == 616) {
        $fpdf->SetFont('Courier', '', 6);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE Y OTROS SERVICIOS PROVISTOS POR LA COMPAÑÍA ESTÁN SUJETOS A LAS CONDICIONES DE TRANSPORTE, LAS CUALES SE INCORPORAN POR REFERENCIA. ESTAS CONDICIONES PUEDEN SER OBTENIDAS DE LA COMPAÑÍA EMISORA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('PASAJEROS EN UN VIAJE QUE INVOLUCRA A DESTINO DEFINITIVO O PARADA EN UN PAÍS QUE NO ES EL PAÍS, SE RECOMIENDA LA SALIDA '.
                                            'QUE LOS TRATADOS INTERNACIONALES SE CONOCEN COMO CONVENIO MONTEREAL, O SU PREDECESOR, EL CONVENIO DE VARSOVIA, INCLUYENDO '.
                                            'SU ENMIENDAS (EL SISTEMA DE CONVENCIÓN DE VARSOVIA), PUEDEN APLICARSE A TODO EL VIAJE, INCLUYENDO CUALQUIER PARTE DE DENTRO '.
                                            'DE UN PAÍS. PARA TALES PASAJEROS, EL TRATADO APLICABLE, INCLUIDOS LOS CONTRATOS ESPECIALES DE TRANSPORTE REALIZADOS EN CUALQUIERA '.
                                            'TARIFAS APLICABLES, GOBIERNOS Y PUEDEN LIMITAR LA RESPONSABILIDAD DEL PORTADOR. VERIFÍCALO CON SU PORTADOR PARA MÁS INFORMACIÓN.'),0,'J',0);
    }
    else {
        $fpdf->SetFont('Courier', '', 6);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE Y OTROS SERVICIOS PROVISTOS POR LA COMPAÑÍA ESTÁN SUJETOS A LAS CONDICIONES DE TRANSPORTE, LAS CUALES SE INCORPORAN POR REFERENCIA. ESTAS CONDICIONES PUEDEN SER OBTENIDAS DE LA COMPAÑÍA EMISORA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('PASAJEROS EN UN VIAJE QUE INVOLUCRA A DESTINO DEFINITIVO O PARADA EN UN PAÍS QUE NO ES EL PAÍS, SE RECOMIENDA LA SALIDA '.
                                            'QUE LOS TRATADOS INTERNACIONALES SE CONOCEN COMO CONVENIO MONTEREAL, O SU PREDECESOR, EL CONVENIO DE VARSOVIA, INCLUYENDO '.
                                            'SU ENMIENDAS (EL SISTEMA DE CONVENCIÓN DE VARSOVIA), PUEDEN APLICARSE A TODO EL VIAJE, INCLUYENDO CUALQUIER PARTE DE DENTRO '.
                                            'DE UN PAÍS. PARA TALES PASAJEROS, EL TRATADO APLICABLE, INCLUIDOS LOS CONTRATOS ESPECIALES DE TRANSPORTE REALIZADOS EN CUALQUIERA '.
                                            'TARIFAS APLICABLES, GOBIERNOS Y PUEDEN LIMITAR LA RESPONSABILIDAD DEL PORTADOR. VERIFÍCALO CON SU PORTADOR PARA MÁS INFORMACIÓN.'),0,'J',0);
    }
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


    /*$local = App\Local::join('local_user as lu','locals.id','=','lu.local_id')
                            ->where('lu.user_id',$pasaje->counter_id)
                            ->first();*/
    $local = App\Local::where('id',$pasaje->user->local_id)->first();

    $empresa = App\Empresa::where('id','=',$local->empresa->id)->first();


    $aerolinea='';
    switch($pasaje->aerolinea_id)
    {
        case 611 : $aerolinea='images/aerolineas/peruvian.png';break;
        case 612 : $aerolinea='images/aerolineas/latam.jpg';break;
        case 613 : $aerolinea='images/aerolineas/costamar.png';break;
        case 614 : $aerolinea='images/aerolineas/avianca.png';break;
        case 615 : $aerolinea='images/aerolineas/starperu.jpg';break;
        case 616 : $aerolinea='images/aerolineas/viva_air.png';break;
        case 617 : case 621 : $aerolinea='images/aerolineas/starperu.jpg';break;
        case 622 : $aerolinea='images/aerolineas/atsa.jpeg';break;
        case 623 : $aerolinea='images/aerolineas/aero_mexico.jpg';break;
        case 628 : $aerolinea='images/aerolineas/sky.jpg';break;
    }

    $aerolin = App\Aerolinea::findOrFail($pasaje->aerolinea_id);

    //oBTENEMOS EL uSUARIO
    $fpdf->AddPage();
    $fpdf->SetAutoPageBreak(false,15);
    switch($empresa->id)
    {
        case 1 : $ancho = 40;break;
        case 2 : $ancho = 60;break;
        case 3 : $ancho = 50;break;
        case 4 ; $ancho = 50;break;
    }
    $fpdf->Image($empresa->foto,2,2,$ancho);

    if($pasaje->aerolinea_id==622)
    {
    $fpdf->Image($aerolinea,120,4,80);
    }
    else {
    $fpdf->Image($aerolinea,130,2,40);
    }

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

    $fpdf->SetFont('Courier', '', 7);
    $fpdf->setXY(98,74);
    $fpdf->Cell(80,4,mb_substr($pasaje->direccion,0,48),0,0,'L',0);

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

    $fpdf->setXY(60,104);
    $fpdf->Cell(40,4, utf8_decode('Vuelo'),0,0,'C',0);

    $fpdf->setXY(100,104);
    $fpdf->Cell(10,4, utf8_decode('CL'),0,0,'C',0);

    $fpdf->setXY(110,104);
    $fpdf->Cell(20,4, utf8_decode('FECHA'),0,0,'C',0);

    $fpdf->setXY(130,104);
    $fpdf->Cell(20,4, utf8_decode('HORA'),0,0,'C',0);

    $fpdf->setXY(150,104);
    $fpdf->Cell(15,4, utf8_decode('ST'),0,0,'C',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->setXY(165,104);
    $fpdf->Cell(20,4, utf8_decode('BAG/EQP'),0,0,'C',0);


    $fpdf->SetFont('Courier', '', 10);

    if($pasaje->tipo_viaje == 2)
    {
        $fpdf->setXY(20,108);
        $fpdf->Cell(40,4,$pasaje->ruta,0,0,'C',0);

        $fpdf->setXY(20,112);
        $fpdf->Cell(40,4,$pasaje->ruta_vuelta,0,0,'C',0);

        $fpdf->setXY(60,108);
        $fpdf->Cell(40,4, $pasaje->vuelo,0,0,'C',0);

        $fpdf->setXY(60,112);
        $fpdf->Cell(40,4, $pasaje->vuelo_vuelta,0,0,'C',0);

        $fpdf->setXY(100,108);
        $fpdf->Cell(10,4, $pasaje->cl,0,0,'C',0);

        $fpdf->setXY(100,112);
        $fpdf->Cell(10,4, $pasaje->cl_vuelta,0,0,'C',0);

        $fpdf->setXY(110,108);
        $fpdf->Cell(20,4, $pasaje->fecha_vuelo,0,0,'C',0);

        $fpdf->setXY(110,112);
        $fpdf->Cell(20,4, $pasaje->fecha_retorno,0,0,'C',0);

        $fpdf->setXY(130,108);
        $fpdf->Cell(20,4, $pasaje->hora_vuelo,0,0,'C',0);

        $fpdf->setXY(130,112);
        $fpdf->Cell(20,4, $pasaje->hora_vuelta,0,0,'C',0);

        $fpdf->setXY(150,108);
        $fpdf->Cell(15,4, trim($pasaje->st),0,0,'C',0);

        $fpdf->setXY(150,112);
        $fpdf->Cell(15,4, trim($pasaje->st_vuelta),0,0,'C',0);

        $fpdf->setXY(165,108);
        $fpdf->Cell(20,4, $pasaje->equipaje,0,0,'C',0);

        $fpdf->setXY(165,112);
        $fpdf->Cell(20,4, $pasaje->equipaje_vuelta,0,0,'C',0);
    }
    else {

        $fpdf->setXY(20,108);
        $fpdf->Cell(40,4,$pasaje->ruta,0,0,'C',0);

        $fpdf->setXY(60,108);
        $fpdf->Cell(40,4, $pasaje->vuelo,0,0,'C',0);

        $fpdf->setXY(100,108);
        $fpdf->Cell(10,4, $pasaje->cl,0,0,'C',0);

        $fpdf->setXY(110,108);
        $fpdf->Cell(20,4, $pasaje->fecha_vuelo,0,0,'C',0);

        $fpdf->setXY(130,108);
        $fpdf->Cell(20,4, $pasaje->hora_vuelo,0,0,'C',0);

        $fpdf->setXY(150,108);
        $fpdf->Cell(15,4, trim($pasaje->st),0,0,'C',0);

         $fpdf->setXY(165,108);
        $fpdf->Cell(20,4, $pasaje->equipaje,0,0,'C',0);
    }



    $fpdf->SetFont('Courier', '', 10);

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
    $fpdf->Cell(30,4,$moneda." ".number_format($pasaje->tax,2)." OD",0,0,'L',0);
    $fpdf->SetFont('Courier', 'B', 10);

    $fpdf->setXY(90,120);
    $fpdf->Cell(30,4,number_format($pasaje->igv,2)." OD",0,0,'L',0);
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
    $fpdf->MultiCell(165,3, utf8_decode('TODO PASAJERO DEBE PRESENTARDE CON LA DOCUMENTACION CORRESPONDIENTE EN EL COUNTER , DEBERA PRESENTARSE 02 HORAS ANTES DE LA SALIDA DE VUELO PROGRAMADO.'),0,'J',0);
    $fpdf->setXY(20,154);
    $fpdf->MultiCell(165,3, utf8_decode('PARA REALISAR EL CHECK-IN Y DECLARACION  DE LOS EQUIPAJES ,EL VUELO CIERRA 45 MINUTOS ANTES  EN CASO DE NO PRESENTARSE EN EL HORARIO ESTABLECIDO SERA CATALOGADO.'),0,'J',0);
    $fpdf->setXY(20,162);
    $fpdf->MultiCell(165,3, utf8_decode('COMO NO SHOW, PASAJERO CON ALGUNA NESECIDADO O CONDICION MEDICA  DEBE INFORMAR AL MOMENTO DE REALIZAR LA COMPRA , AL MOMENTO DE REALIZAR EL VIAJE.'),0,'J',0);
    $fpdf->setXY(20,170);
    $fpdf->MultiCell(165,3, utf8_decode('DEVOLUCIONES: SON TARIFAS NO REEMBOLSABLES DE ACUERDO A CADA POLITICA DE CADA LINEA AEREA.'),0,'J',0);

    $fpdf->SetFont('Courier', 'B', 10);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->setXY(20,176);
    $fpdf->Cell(165,4, utf8_decode('POLÍTICAS  Y CONDICIONES DE COMPRA '),1,1,'C',1);

    $fpdf->Image('images/sellos.PNG',100,230,100);
    $cond_y=182;
    if($pasaje->aerolinea_id == 622)
    {
        $fpdf->SetFont('Courier', '', 6);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('CANCELACIONES POR NO PAGO:ATSA SE RESERVA EL DERECHO DE EMBARQUE EN CASO NO SE HAYA CUMPLIDO CON EL PAGO OPORTUNO DE LA RESERVA GENERADA A TRAVES DE UNO DE LOS CANALES AUTORIZADOS O SI EL BOLETO HA SIDO ADQUIRIDO POR MEDIOS ILICITOS.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('VIGENCIA DEL PASAJE:LA VIGENCIA DE SU BOLETO ES DE 01 ANO COMO DOCUMENTO A CONTAR DE LA FECHA DE EMISION, SIN EMBARGO CONSIDERAR LA VALIDEZ DE LA TARIFA ADQUIRIDA (MAYOR DETALLE EN TERMINOS Y CONDICIONES).'),0,'J',0);
        $fpdf->setXY(20,$cond_y+16);
        $fpdf->MultiCell(165,3, utf8_decode('CAMBIOS:CONSIDERAR LAS REGULACIONES TARIFARIAS DETALLADAS EN TERMINOS Y CONDICIONES DE NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+20);
        $fpdf->MultiCell(165,3, utf8_decode('EQUIPAJE:CONSIDERAR LA INFORMACION QUE SE ENCUENTRA DETALLADA EN POLITICA DE EQUIPAJE EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+28);
        $fpdf->MultiCell(165,3, utf8_decode('TRANSPORTE DE MENORES NO ACOMPANADOS:FAVOR CONSIDERAR LA DOCUMENTACION REQUERIDA PARA EL TRANSPORTE DE UN MENOR VIAJANDO SOLO.PARA MAYOR DETALLE INGRESAR A SERVICIOS ESPECIALES EN NUESTRA PAGINA WEB: WWW.ATSAAIRLINES.COM. NO SE ACEPTARAN INFANTES NI NINOS QUE NO HAYAN ALCANZADO 05 ANOS DE EDAD, VIAJANDO SOLOS.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+38);
        $fpdf->MultiCell(165,3, utf8_decode('POR CUALQUIER OTRA CONSULTA,COMUNIQUESE AL TELEFONO 717-3268,AL CORREO ATSAAIRLINES@ATSAPERU.COM O VISITE WWW.ATSAAIRLINES.COM.'),0,'J',0);
         $fpdf->SetFont('Courier', '', 7);
        $fpdf->setXY(20,$cond_y+104);
        $fpdf->MultiCell(165,3, utf8_decode('*PRESENTARSE EN COUNTER 02 HORAS ANTES DE SU VUELO PARA RECIBIR SU TARJETA/EQUIPAJE /01 Equipaje de Mano 05Kg por Pasajero '.
                                            ' / Equipaje de Bodega / 10 Kg. por Pasajero / No se permite Exceso de Equipaje'),0,'J',0);

    }
    else if($pasaje->aerolinea_id == 628) {
        $fpdf->SetFont('Courier', '', 5);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE Y OTROS SERVICIOS PROVISTOS POR LA COMPAÑÍA ESTÁN SUJETOS A LAS CONDICIONES DE TRANSPORTE, LAS CUALES SE INCORPORAN POR REFERENCIA. ESTAS CONDICIONES PUEDEN SER OBTENIDAS DE LA COMPAÑÍA EMISORA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('EL ITINERARIO/RECIBO CONSTITUYE EL BILLETE DE PASAJE A EFECTOS DEL ARTICULO 3 DE LA CONVENCION DE VARSOVIA, A MENOS QUE EL TRANSPORTISTA ENTREGUE AL PASAJERO OTRO DOCUMENTO QUE CUMPLA CON LOS REQUISITOS DEL ARTICULO 3.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+16);
        $fpdf->MultiCell(165,3, utf8_decode('SE INFORMA A LOS PASAJEROS QUE REALICEN VIAJES EN LOS QUE EL PUNTO DE DESTINO O UNA O MAS ESCALAS INTERMEDIAS SE EFECTUEN '.
                                            'EN UN PAIS QUE NO SEA EL DE PARTIDA DE SU VUELO, QUE PUEDEN SER DE APLICACION A LA TOTALIDAD DE SU VIAJE, INCLUIDA CUALQUIER '.
                                            'PARTE DEL MISMO DENTRO DE UN PAIS, LOS TRATADOS INTERNACIONALES COMO LA CONVENCION DE MONTREAL O SU PREDECESOR LA CONVENCION '.
                                            'DE VARSOVIA, INCLUYENDO SUS MODIFICACIONES (EL SISTEMA DE CONVENCION DE VARSOVIA).  EN EL CASO DE AQUELLOS PASAJEROS, EL '.
                                            'TRATADO APLICABLE, INCLUYENDO LAS CONDICIONES ESPECIALES DEL TRANSPORTE INCORPORADAS A CUALQUIER TARIFA APLICABLE, RIGE Y '.
                                            'PUEDE LIMITAR LA RESPONSABILIDAD DEL TRANSPORTISTA EN CASOS DE MUERTE O LESIONES PERSONALES, PERDIDA O DANOS AL EQUIPAJE Y RETRASOS.'),0,'J',0);

        $fpdf->setXY(20,$cond_y+34);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE DE MATERIALES PELIGROSOS TALES COMO AEROSOLES, FUEGOS ARTIFICIALES Y LIQUIDOS INFLAMABLES A BORDO DEL AVION '.
                                            'QUEDA ESTRICTAMENTE PROHIBIDO. SI USTED NO COMPRENDE ESTAS RESTRICCIONES, SIRVASE OBTENER MAYOR PARTIDA DE SU VUELO, QUE '.
                                            'PUEDEN SER DE APLICACION A LA TOTALIDAD DE SU VIAJE, INCLUIDA CUALQUIER PARTE DEL MISMO DENTRO DE UN PAIS, LOS TRATADOS '.
                                            'INTERNACIONALES COMO LA CONVENCION DE MONTREAL O SU PREDECESOR LA CONVENCION DE VARSOVIA, INCLUYENDO SUS MODIFICACIONES '.
                                            '(EL SISTEMA DE CONVENCION DE VARSOVIA).'),0,'J',0);
        $fpdf->SetFont('Courier', '', 4);
        $fpdf->setXY(20,$cond_y+48);
        $fpdf->MultiCell(80,3, utf8_decode('EN EL CASO DE AQUELLOS PASAJEROS, EL TRATADO APLICABLE, INCLUYENDO LAS CONDICIONES '.
                                            'ESPECIALES DEL TRANSPORTE INCORPORADAS A CUALQUIER TARIFA APLICABLE, RIGE Y PUEDE LIMITAR LA RESPONSABILIDAD DEL TRANSPORTISTA'.
                                            'EN CASOS DE MUERTE O LESIONES PERSONALES, PERDIDA O DANOS AL EQUIPAJE Y RETRASOS.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+60);
        $fpdf->MultiCell(80,3, utf8_decode('EL TRANSPORTE DE MATERIALES PELIGROSOS TALES COMO AEROSOLES, FUEGOS ARTIFICIALES Y LIQUIDOS INFLAMABLES A BORDO DEL AVION '.
                                            'QUEDA ESTRICTAMENTE PROHIBIDO. SI USTED NO COMPRENDE ESTAS RESTRICCIONES, SIRVASE OBTENER MAYOR INFORMACION A TRAVES DE SU COMPANIA AEREA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+70);
        $fpdf->MultiCell(80,3, utf8_decode('AVISO DE PROTECCION DE DATOS:US DATOS PERSONALES SE PROCESARAN DE ACUERDO CON LA POLITICA DE PRIVACIDAD DEL PROVEEDOR CORRESPONDIENTE Y, '.
                                            'SI SU RESERVA SE REALIZA A TRAVES DE UN PROVEEDOR DEL SISTEMA DE RESERVAS ( GDS "), CON SU POLITICA DE PRIVACIDAD. ESTAS POLITICAS SE '.
                                            'PUEDEN CONSULTAR EN http://www.iatatravelcenter.com/privacy O DESDE EL OPERADOR O GDS DIRECTAMENTE. DEBE LEER ESTA DOCUMENTACION, QUE '.
                                            'SE APLICA A SU RESERVA Y DESCRIBE, POR EJEMPLO, COMO SE RECOPILAN, ALMACENAN, USAN, PUBLICAN Y TRANSFIEREN SUS DATOS PERSONALES. '.
                                            '(TAMBIEN APLICABLE PARA ITINERARIOS QUE INCLUYEN MULTIPLES AEROLINEAS).'),0,'J',0);
    }
    else if($pasaje->aerolinea_id == 612 || $pasaje->aerolinea_id == 614 || $pasaje->aerolinea_id == 616) {
        $fpdf->SetFont('Courier', '', 6);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE Y OTROS SERVICIOS PROVISTOS POR LA COMPAÑÍA ESTÁN SUJETOS A LAS CONDICIONES DE TRANSPORTE, LAS CUALES SE INCORPORAN POR REFERENCIA. ESTAS CONDICIONES PUEDEN SER OBTENIDAS DE LA COMPAÑÍA EMISORA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('PASAJEROS EN UN VIAJE QUE INVOLUCRA A DESTINO DEFINITIVO O PARADA EN UN PAÍS QUE NO ES EL PAÍS, SE RECOMIENDA LA SALIDA '.
                                            'QUE LOS TRATADOS INTERNACIONALES SE CONOCEN COMO CONVENIO MONTEREAL, O SU PREDECESOR, EL CONVENIO DE VARSOVIA, INCLUYENDO '.
                                            'SU ENMIENDAS (EL SISTEMA DE CONVENCIÓN DE VARSOVIA), PUEDEN APLICARSE A TODO EL VIAJE, INCLUYENDO CUALQUIER PARTE DE DENTRO '.
                                            'DE UN PAÍS. PARA TALES PASAJEROS, EL TRATADO APLICABLE, INCLUIDOS LOS CONTRATOS ESPECIALES DE TRANSPORTE REALIZADOS EN CUALQUIERA '.
                                            'TARIFAS APLICABLES, GOBIERNOS Y PUEDEN LIMITAR LA RESPONSABILIDAD DEL PORTADOR. VERIFÍCALO CON SU PORTADOR PARA MÁS INFORMACIÓN.'),0,'J',0);
    }
    else {
        $fpdf->SetFont('Courier', '', 6);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->setXY(20,$cond_y);
        $fpdf->MultiCell(165,3, utf8_decode('EL TRANSPORTE Y OTROS SERVICIOS PROVISTOS POR LA COMPAÑÍA ESTÁN SUJETOS A LAS CONDICIONES DE TRANSPORTE, LAS CUALES SE INCORPORAN POR REFERENCIA. ESTAS CONDICIONES PUEDEN SER OBTENIDAS DE LA COMPAÑÍA EMISORA.'),0,'J',0);
        $fpdf->setXY(20,$cond_y+8);
        $fpdf->MultiCell(165,3, utf8_decode('PASAJEROS EN UN VIAJE QUE INVOLUCRA A DESTINO DEFINITIVO O PARADA EN UN PAÍS QUE NO ES EL PAÍS, SE RECOMIENDA LA SALIDA '.
                                            'QUE LOS TRATADOS INTERNACIONALES SE CONOCEN COMO CONVENIO MONTEREAL, O SU PREDECESOR, EL CONVENIO DE VARSOVIA, INCLUYENDO '.
                                            'SU ENMIENDAS (EL SISTEMA DE CONVENCIÓN DE VARSOVIA), PUEDEN APLICARSE A TODO EL VIAJE, INCLUYENDO CUALQUIER PARTE DE DENTRO '.
                                            'DE UN PAÍS. PARA TALES PASAJEROS, EL TRATADO APLICABLE, INCLUIDOS LOS CONTRATOS ESPECIALES DE TRANSPORTE REALIZADOS EN CUALQUIERA '.
                                            'TARIFAS APLICABLES, GOBIERNOS Y PUEDEN LIMITAR LA RESPONSABILIDAD DEL PORTADOR. VERIFÍCALO CON SU PORTADOR PARA MÁS INFORMACIÓN.'),0,'J',0);
    }

    $fpdf->Output();
});

Route::get('imprimirAdicional/{adicional_id}',function ($adicional_id){

    $fpdf = new Fpdf();

    $adicional_id = $adicional_id;

    $adicional = App\Opcional::with(['OpcionalDetalles','user'])->where('id',$adicional_id)->first();

    $local = App\Local::where('id',$adicional->user->local_id)->first();

    $empresa = App\Empresa::where('id','=',$local->empresa->id)->first();

    $fpdf->AddPage();

    switch($empresa->id)
    {
        case 1 : $ancho = 40;break;
        case 2 : $ancho = 60;break;
        case 3 : $ancho = 50;break;
        case 4 ; $ancho = 50;break;
    }
    $fpdf->Image($empresa->foto,5,10,$ancho);

    $fpdf->SetFont('Courier', 'B', 14);
    $fpdf->setXY(30,25);
    $fpdf->Cell(150,5, 'PASAJE ADICIONALES',0,0,'C',0);

    //detalles empresa
    $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->setXY(20,44);
    $fpdf->Cell(60,4, trim($empresa->razon_social),0,0,'C',0);
	$fpdf->SetFont('Courier', '', 12);
    $fpdf->setXY(20,48);
    $fpdf->Cell(60,4, $local->nombre,0,0,'L',0);
    $fpdf->SetFont('Courier', '', 12);
    $fpdf->setXY(20,52);
    $fpdf->Cell(60,4,utf8_decode((explode("//",$empresa->direccion))[1]),0,0,'L',0);
    $fpdf->SetFont('Courier', '', 8);
    $fpdf->setXY(15,56);
    $fpdf->Cell(60,4,"TELEPHONE/TELEFONO:",0,0,'L',0);
    $fpdf->SetFont('Courier', '', 8);
    $fpdf->setXY(48,56);
    $fpdf->Cell(60,4,$empresa->celular,0,0,'L',0);

    $fpdf->setXY(15,60);
    $fpdf->Cell(60,4,"EMAIL/CORREO:",0,0,'L',0);
    $fpdf->setXY(37,60);
    $fpdf->Cell(60,4,$empresa->email,0,0,'L',0);

    //cabecera pasaje
    $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->setXY(110,44);
    $fpdf->Cell(40,4, utf8_decode('FECHA DE EMISIÓN:'),0,0,'R',0);
    $fpdf->SetFont('Courier', '', 12);
    $fpdf->setXY(150,44);
    $fpdf->Cell(30,4, explode(" ",$adicional->fecha)[0],0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->setXY(105,52);
    $fpdf->Cell(30,4, utf8_decode('FOID/DNI:'),0,0,'R',0);

    $fpdf->SetFont('Courier', '', 12);
    $fpdf->setXY(134,52);
    $fpdf->Cell(40,4,$adicional->numero_documento,0,0,'L',0);

    $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->setXY(105,60);
    $fpdf->Cell(30,4, utf8_decode('NAME/NOMBRE:'),0,0,'R',0);

    $fpdf->SetFont('Courier', '', 10);
    $fpdf->setXY(134,60);
    $fpdf->Cell(50,4, $adicional->pasajero,0,0,'L',0);

    $det_y=80; $det_x=20;

    $fpdf->setXY($det_x,$det_y);
    $fpdf->SetFont('Courier', 'B', 12);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->Cell(12,6, utf8_decode('CANT'),1,0,'C',1);
    $fpdf->setXY($det_x+12,$det_y);
    $fpdf->Cell(80,6, utf8_decode('DETALLE'),1,0,'C',1);
    $fpdf->setXY($det_x+92,$det_y);
    $fpdf->Cell(25,6, utf8_decode('MONTO'),1,0,'C',1);
    $fpdf->setXY($det_x+117,$det_y);
    $fpdf->Cell(25,6, utf8_decode('Serv. Fee'),1,0,'C',1);
    $fpdf->setXY($det_x+142,$det_y);
    $fpdf->Cell(25,6, utf8_decode('IMPORTE'),1,0,'C',1);

    $det_y +=6;
    $fpdf->SetFont('Courier', 'B', 9);
    $fpdf->SetFillColor(255,255,255);

    foreach($adicional->OpcionalDetalles as $detalle)
    {
        //cantidad
        $fpdf->setXY($det_x,$det_y);
        $fpdf->Cell(12,10, utf8_decode('1'),1,0,'C',1);
        //descripción
        $fpdf->setXY($det_x+12,$det_y);
        $fpdf->Cell(80,10, utf8_decode($detalle->detalle_otro),1,0,'C',1);
        //MOntp
        $fpdf->setXY($det_x+92,$det_y);
        $fpdf->Cell(25,10, utf8_decode($detalle->monto),1,0,'C',1);
        //Service Fee
        $fpdf->setXY($det_x+117,$det_y);
        $fpdf->Cell(25,10, utf8_decode($detalle->service_fee),1,0,'C',1);
        //Importe
        $fpdf->setXY($det_x+142,$det_y);
        $fpdf->Cell(25,10, utf8_decode($detalle->importe),1,0,'C',1);

        $det_y+=10;
    }

    $fpdf->SetFont('Courier', 'B', 9);
    $fpdf->SetFillColor(210,210,210);
    $fpdf->setXY(137,$det_y);
    $fpdf->Cell(25,8, utf8_decode('SUBTOTAL US$'),1,0,'CR',1);
    $fpdf->setXY(137,$det_y+8);
    $fpdf->Cell(25,8, utf8_decode('I.G.V US$'),1,0,'R',1);
    $fpdf->setXY(137,$det_y+16);
    $fpdf->Cell(25,8, utf8_decode('TOTAL US$'),1,0,'R',1);
    $fpdf->SetFillColor(255,255,255);
    $fpdf->setXY(162,$det_y);
    $fpdf->Cell(25,8, utf8_decode($adicional->sub_total),1,0,'C',0);
    $fpdf->setXY(162,$det_y+8);
    $fpdf->Cell(25,8, utf8_decode($adicional->igv),1,0,'C',0);
    $fpdf->setXY(162,$det_y+16);
    $fpdf->Cell(25,8, utf8_decode($adicional->total),1,0,'C',0);

    $det_y+=40;

    $fpdf->SetFillColor(210,210,210);
    $fpdf->SetFont('Courier', 'B', 9);
    $fpdf->setXY(20,$det_y);
    $fpdf->Cell(165,5, utf8_decode('ESTE DOCUMENTO ES ACEPTADO TRIBUTARIAMENTE POR LA SUNAT'),1,1,'C',1);



    $fpdf->Output();
});
