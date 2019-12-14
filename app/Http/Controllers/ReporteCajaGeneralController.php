<?php

namespace App\Http\Controllers;

use Session;
use App\Lugar;
use App\Pasaje;
use App\Opcional;
use App\OpcionalDetalle;
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

    public function listarUsuarios()
    {
        return Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                    ->select('u.id','u.name','u.lastname')
                    ->groupBy('u.id','u.name','u.lastname')
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
        $pasajes = Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                        ->join('locals as l','u.local_id','=','l.id')
                        ->join('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->where('l.lugar_id','LIKE',$request->lugar)
                        ->where('l.id','LIKE',$request->local)
                        ->where('u.id','LIKE',$request->counter)
                        ->where('pasaje.aerolinea_id','LIKE',$request->aerolinea)
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->whereNull('pasaje.deuda_monto')
                        ->orWhere('pasaje.deuda_monto','=',0)
                        ->select('pasaje.id','u.name as counter','viajecode','ae.name as aero',
                                    'pasaje.pasajero','pasaje.tax','pasaje.service_fee','pasaje.ticket_number',
                                    'pasaje.total','pasaje.deposito_soles','pasaje.deposito_dolares',
                                    'ruta','pasaje.tarifa','pago_soles','pago_dolares',
                                    'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at_venta',
                                    'pasaje.deleted_at')
                        ->orderBy('pasaje.created_at','DESC')
                        ->get();

        $deudas = Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                        ->join('locals as l','u.local_id','=','l.id')
                        ->join('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->where('l.lugar_id','LIKE',$request->lugar)
                        ->where('l.id','LIKE',$request->local)
                        ->where('pasaje.counter_id','LIKE',$request->counter)
                        ->where('pasaje.aerolinea_id','LIKE',$request->aerolinea)
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->where('pasaje.deuda_monto','>',0)
                        ->select('pasaje.id','u.name as counter','viajecode','ae.name as aero',
                                    'pasaje.deuda_detalle','pasaje.deuda_monto',
                                    'pasaje.pasajero','pasaje.ticket_number','pasaje.created_at_venta',
                                    'pasaje.deleted_at')
                        ->orderBy('pasaje.created_at','DESC')
                        ->get();

        $adicionales = Opcional::join('user as u','opcionals.counter_id','=','u.id')
                            ->join('opcional_detalles as op','opcionals.id','=','op.opcional_id')
                            ->select(
                                'opcionals.id','u.name as counter','opcionals.pasajero',
                                'op.detalle_otro','op.monto','op.service_fee','op.importe','pago_soles',
                                'pago_dolares','pago_visa','deposito_soles','deposito_dolares',
                                'opcionals.created_at','opcionals.fecha'
                            )
                            ->where('opcionals.counter_id','like',$request->counter)
                            ->where('opcionals.fecha','>=',$request->fecha_ini)
                            ->where('opcionals.fecha','<=',$request->fecha_fin)
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
        foreach($pasajes as $pa)
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

        return response()->json([
                'pasajes' => $pasajes,
                'deudas' => $deudas,
                'adicionales' => $adicionales
        ]);
    }
}
