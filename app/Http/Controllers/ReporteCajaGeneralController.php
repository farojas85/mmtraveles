<?php

namespace App\Http\Controllers;

use Session;
use App\Lugar;
use App\Pasaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class ReporteCajaGeneralController extends Controller
{
    public function index()
    {
        return view('Reportes.cajageneral');
    }

    public function listarAerolineas(Request $request)
    {
        return Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                    ->join('locals as lo','lo.id','=','u.local_id')
                    ->join('category as lu','lu.id','=','lo.lugar_id')
                    ->join('product as ae','pasaje.aerolinea_id','=','ae.id')
                    ->select('ae.id','ae.name')
                    ->where('lu.id','LIKE',$request->lugar)
                    ->where('lo.id','LIKE',$request->local)
                    ->where('u.id','LIKE',$request->counter)
                    ->groupBy('ae.id','ae.name')
                    ->get();
    }

    public function tabla(Request $request){
        $mensajes=[
            'required' => '*Campo Obligatorio'
        ];

        $rules =[
            'lugar' => 'required',
            'local' => 'required',
            'counter' => 'required',
            'aerolinea' => 'required',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required'
        ];

        $this->validate($request,$rules,$mensajes);

        $condicion = "";
        switch($request->lugar_id){
            case '%': $condicion='%';break;
            case '10': $condicion = '%IQT%';break;
            case '20': $condicion = '%HUU%';break;
        }
        //return $request;
        $pasaje = Pasaje::leftJoin('user as u','pasaje.counter_id','=','u.id')
                        ->leftJoin('locals as l','u.local_id','=','l.id')
                        ->leftJoin('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->where('l.lugar_id','LIKE',$request->lugar_id)
                        ->where('pasaje.aerolinea_id','LIKE',$request->aerolinea_id)
                        ->select('pasaje.id','u.name as counter','viajecode','ae.name as aero',
                                    'pasaje.pasajero','pasaje.tax','pasaje.service_fee','pasaje.ticket_number',
                                    'pasaje.total','pasaje.deposito_soles','pasaje.deposito_dolares',
                                    'ruta','pasaje.tarifa','pago_soles','pago_dolares',
                                    'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at')
                        ->orderBy('pasaje.created_at','DESC')
                        ->get();
        $asuma = 0;
        $sumatuaa=0;
        $s2= 0;
        $s3=0;
        $s4=0;
        $s5=0;
        $s6=0;
        $s7=0;
        $s8=0;
        $pasa = array();
        foreach($pasaje as $pa)
        {
            $tempo = array(
                'id' => $pa->id,
                'counter' => $pa->counter,
                'ticket' => "$pa->ticket_number",
                'viajecode' => $pa->viajecode,
                'aero' => $pa->aero,
                'pasajero' => $pa->pasajero,
                'ruta' => $pa->ruta,
                'tarifa' => $pa->tarifa,
                'tuaa' => $pa->tax,
                'service_fee' => $pa->service_fee,
                'total' => $pa->total,
                'pago_soles' => $pa->pago_soles,
                'pago_dolares' => $pa->pago_dolares,
                'pago_visa' => $pa->visa,
                'deposito_soles' => $pa->deposito_soles,
                'deposito_dolares' => $pa->deposito_dolares,
                'createad_at' => $pa->created_at
            );
            $asuma = $asuma + $pa->tarifa;
            $sumatuaa  = $sumatuaa +  $pa->tax;
            $s2 +=  $pa->service_fee;
            $s3 +=  $pa->pago_soles;
            $s4 +=  $pa->pago_dolares;
            $s5 +=  $pa->visa;
            $s6 +=  $pa->deposito_soles;
            $s7 +=  $pa->deposito_dolares;
            $s8 += $pa->total;
            array_push($pasa,$tempo);
        }

       $tempo = array(
                'id' => '',
                'counter' => '',
                'ticket' =>'',
                'viajecode' =>'',
                'aero' => '',
                'pasajero' => '',
                'ruta' => 'TOTAL',
                'tarifa' => $asuma,
                'tax' => $sumatuaa,
                'service_fee' => $s2,
                'total' => $s8,
                'pago_soles' => $s3,
                'pago_dolares' => $s4,
                'pago_visa' => $s5,
                'deposito_soles' => $s6,
                'deposito_dolares' => $s7,
                'createad_at' => ''
            );

        array_push($pasa,$tempo);
        Session::put('pasajes',$pasa);
        return $pasaje;
    }
}
