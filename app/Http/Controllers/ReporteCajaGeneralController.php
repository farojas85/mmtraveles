<?php

namespace App\Http\Controllers;

use Session;
use App\Lugar;
use App\Pasaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReporteCajaGeneralController extends Controller
{
    public function index()
    {
        return view('Reportes.cajageneral');
    }

    public function tabla(Request $request){
        $condicion = "";
        switch($request->lugar_id){
            case '%': $condicion='%';break;
            case '10': $condicion = '%IQT%';break;
            case '20': $condicion = '%HUU%';break;
        }
        //return $request;
        $pasaje = Pasaje::leftJoin('user as u','pasaje.counter_id','=','u.id')
                        ->leftJoin('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->where('pasaje.created_at','>=',$request->fecha_ini)
                        ->where('pasaje.created_at','<=',$request->fecha_fin)
                        ->where('ruta','LIKE',$condicion)
                        ->select('pasaje.id','u.name as counter','viajecode','ae.name as aero',
                                    'pasaje.pasajero',
                                    'ruta','pasaje.pasaje_total','pago_soles','pago_dolares',
                                    'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at')
                        ->orderBy('pasaje.created_at','DESC')
                        ->get();

        Session::put('pasajes',$pasaje->toArray());
        
        return $pasaje;
        // return Pasaje::with(['user','aerolinea'])->where('pasaje.created_at','>=',$request->fecha_ini)
        //         ->where('pasaje.created_at','<=',$request->fecha_fin)
        //         ->where('ruta','LIKE',$condicion)
        //         ->get();
    }
}
