<?php

namespace App\Http\Controllers;

use Session;
use App\Lugar;
use App\Pasaje;
use App\Opcional;
use App\OpcionalDetalle;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
                        ->leftJoin('etapa_persona as ep','pasaje.etapa_persona_id','=','ep.id')
                        ->where('l.lugar_id','LIKE',$request->lugar)
                        ->where('l.id','LIKE',$request->local)
                        ->where('u.id','LIKE',$request->counter)
                        ->where('pasaje.aerolinea_id','LIKE',$request->aerolinea)
                        ->whereNull('pasaje.deuda_detalle')
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->select('pasaje.id','u.name as counter','viajecode','ae.name as aero',
                                    'pasaje.pasajero','pasaje.tax','pasaje.service_fee','pasaje.ticket_number',
                                    'pasaje.total','pasaje.deposito_soles','pasaje.deposito_dolares',
                                    'ruta','pasaje.tarifa','pago_soles','pago_dolares',
                                    'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at_venta',
                                    'pasaje.deleted_at','ep.nombre as etapa_persona','ep.abreviatura as etapa_mini')
                        ->orderBy('pasaje.created_at','DESC')
                        ->get();

        $deudas = Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                        ->join('locals as l','u.local_id','=','l.id')
                        ->join('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->leftJoin('etapa_persona as ep','pasaje.etapa_persona_id','=','ep.id')
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->where('l.lugar_id','LIKE',$request->lugar)
                        ->where('l.id','LIKE',$request->local)
                        ->where('pasaje.counter_id','LIKE',$request->counter)
                        ->where('pasaje.aerolinea_id','LIKE',$request->aerolinea)
                        ->where("pasaje.deuda_detalle",'=',"Es-Salud")
                        ->select('pasaje.id','u.name as counter','viajecode','ae.name as aero',
                                    'pasaje.deuda_detalle','pasaje.deuda_monto','pasaje.deuda_soles','pasaje.deuda_dolares',
                                    'pasaje.deuda_visa','deuda_depo_soles','deuda_depo_dolares',
                                    'pasaje.pasajero','pasaje.ticket_number','pasaje.created_at_venta',
                                    'pasaje.deleted_at','ep.nombre as etapa_persona','ep.abreviatura as etapa_mini')
                        ->orderBy('pasaje.created_at','DESC')
                        ->get();

        $adicionales = Opcional::with(['OpcionalDetalles','user'])
                            ->where('counter_id','like',$request->counter)
                            ->where('fecha','>=',$request->fecha_ini)
                            ->where('fecha','<=',$request->fecha_fin)
                            ->orderBy('created_at','DESC')
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

    public function editarAdicional() {
        return view('Reportes.editar-adicional');
    }

    public function obtenerAdicional(Request $request)
    {
        $opcional = Opcional::join('user as u','u.id','=','opcionals.counter_id')
                            ->select('opcionals.*',
                                    DB::Raw("CONCAT(u.name,' ',u.lastname) as counter"))
                            ->where('opcionals.id',$request->id)->first();

        $opcional_detalle = OpcionalDetalle::select(
                                'adicional_id','detalle_otro as detalle',
                                'monto','service_fee','importe')
                            ->where('opcional_id',$request->id)->get();

        return response()->json([
            'adicional' => $opcional,
            'adicional_detalle' => $opcional_detalle
        ]);
    }

    public function actualizarAdicional(Request $request)
    {
        //Actualizamos Adicional Datos
        $adicional = Opcional::findOrFail($request->id);

        $adicional->counter_id=$request->counter_id;
        $adicional->pasajero = $request->pasajero;
        $adicional->tipo_documento_id = $request->tipo_documento_id;
        $adicional->numero_documento = $request->numero_documento;
        $adicional->fecha = $request->fecha;
        $adicional->monto_pagar = $request->monto_pagar;
        $adicional->sub_total = $request->sub_total;
        $adicional->igv = $request->igv;
        $adicional->total = $request->total;
        $adicional->pago_dolares = $request->pago_dolares;
        $adicional->pago_soles = $request->pago_soles;
        $adicional->pago_visa = $request->pago_visa;
        $adicional->deposito_soles = $request->deposito_soles;
        $adicional->deposito_dolares = $request->deposito_dolares;
        $adicional->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $adicional->save();

        //Acualizamos
        foreach($request->adicional_detalle as $ad)
        {
            $opcional_detalle_count = OpcionalDetalle::where('opcional_id','=',$request->id)
                                                ->where('adicional_id',$ad['adicional_id'])
                                                ->count();
            if($opcional_detalle_count >0)
            {
                $opcional_detalle = OpcionalDetalle::where('opcional_id','=',$request->id)
                                            ->where('adicional_id',$ad['adicional_id'])
                                            ->first();
                $opcional_detalle->detalle_otro = $ad['detalle'];
                $opcional_detalle->monto = $ad['monto'];
                $opcional_detalle->service_fee = $ad['service_fee'];
                $opcional_detalle->importe = $ad['importe'];
                $opcional_detalle->updated_at = Carbon::now()->format('Y-m-d H:i:s');
                $opcional_detalle->save();
            }
            else {
                $opcional_detalle = new OpcionalDetalle();

                $opcional_detalle->opcional_id = $request->id;
                $opcional_detalle->adicional_id = $ad['adicional_id'];
                $opcional_detalle->detalle_otro = $ad['detalle'];
                $opcional_detalle->monto = $ad['monto'];
                $opcional_detalle->service_fee = $ad['service_fee'];
                $opcional_detalle->importe = $ad['importe'];
                $opcional_detalle->save();
            }
        }

        return response()->json([
            'mensaje' => 'Adicionales Modificados Satisfactoriamente'
        ]);
    }

    public function eliminarAdicionalTemporal(Request $request)
    {
        $adicional = Opcional::withTrashed()
                        ->where('id',$request->id)->first()->Delete();

        return response()->json([
            'adicional' =>$adicional,
            'mensaje' => 'el Adicional ha sido enviado a Papelera de Reciclaje'
        ]);
    }

    public function eliminarAdicionalPermanente(Request $request)
    {
        $adicional = Opcional::withTrashed()
                        ->where('id',$request->id)->first()->forceDelete();

        return response()->json([
            'adicional' =>$adicional,
            'mensaje' => 'el Adicional ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function showPasajePagado(Request $request)
    {
        return Pasaje::where('id',$request->id)->first();
    }

    public function guardarPasajePagado(Request $request)
    {
        $rules =[
            'pasajero' => 'required',
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required',
            'created_at_venta' => 'required',
            'ticket_number' => 'required',
            'aerolinea_id' => 'required',
            'ruta' => 'required',
            'tipo_viaje' => 'required',
            'fecha_vuelo' => 'required',
            'hora_vuelo' => 'required',
            'vuelo' => 'required',
            'moneda' => 'required',
            'tarifa' => 'required',
            'tax' => 'required',
            'service_fee' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            'monto_neto' => 'required'
        ];

        $mensaje= [
            'required' => 'Campo Obligatorio'
        ];

        $this->validate($request,$rules,$mensaje);

        $pasaje =Pasaje::where('id',$request->id)->first();

        $pasaje->counter_id = $request->counter_id;
        $pasaje->pasajero = $request->pasajero;
        $pasaje->tipo_documento_id = $request->tipo_documento_id;
        $pasaje->numero_documento = $request->numero_documento;
        $pasaje->dni = null;

        $date = Carbon::now();
        if(is_null($request->created_at_venta) || $request->created_at_venta == "" )
        {
            $pasaje->created_at_venta =  $date->format('Y-m-d H:i:s');
        }
        else{
            $pasaje->created_at_venta =  Carbon::parse($request->created_at_venta)->format('Y-m-d H:i:s');
        }
        $pasaje->ticket_number = $request->ticket_number;
        $pasaje->aerolinea_id=$request->aerolinea_id;
        $pasaje->direccion= $request->direccion;
        $pasaje->ruc = $request->ruc;
        $pasaje->viajecode = $request->viajecode;
        $pasaje->ruta = $request->ruta;
        $pasaje->ruta_vuelta =  ($request->ruta_vuelta== '') ?null : $request->ruta_vuelta;
        $pasaje->tipo_viaje = $request->tipo_viaje;
        $pasaje->fecha_vuelo = $request->fecha_vuelo;
        $pasaje->fecha_retorno =  ($request->fecha_retorno== '') ?null : $request->fecha_retorno;
        $pasaje->hora_vuelo = $request->hora_vuelo;
        $pasaje->hora_vuelta = ($request->hora_vuelta== '') ? null : $request->hora_vuelta;
        $pasaje->vuelo = $request->vuelo;
        $pasaje->vuelo_vuelta = ($request->vuelo_vuelta== '') ? null : $request->vuelo_vuelta;
        $pasaje->cl = $request->cl;
        $pasaje->cl_vuelta = ($request->cl_vuelta== '') ? null : $request->cl_vuelta;
        $pasaje->st = 'OK';
        if($pasaje->tipo_viaje == 2){
            $pasaje->st_vuelta = 'OK';
        }
        $pasaje->equipaje = $request->equipaje;
        $pasaje->equipaje_vuelta = ($request->equipaje_vuelta== '') ? null : $request->equipaje_vuelta;
        $pasaje->monto_neto = $request->monto_neto;

        $pasaje->moneda = $request->moneda;

        $pasaje->cambio = $request->cambio;
        $pasaje->pago_soles = ($request->pago_soles=='') ? 0 : $request->pago_soles;
        $pasaje->pago_dolares =  ($request->pago_dolares=='') ? 0 : $request->pago_dolares;
        $pasaje->pago_visa =  ($request->pago_visa=='') ? 0 : $request->pago_visa;
        $pasaje->deposito_soles =  ($request->deposito_soles=='') ? 0 : $request->deposito_soles;
        $pasaje->deposito_dolares =  ($request->deposito_dolares=='') ? 0 : $request->deposito_dolares;

        $pasaje->tarifa = $request->tarifa;
        $pasaje->tax = $request->tax;
        $pasaje->service_fee = $request->service_fee;
        $pasaje->sub_total = $pasaje->tarifa + $pasaje->tax + $pasaje->service_fee;
        $pasaje->not_igv = $request->not_igv;

        $pasaje->igv = ($request->igv == 0) ? 0 : $request->igv;

        $pasaje->total = $request->total;

        $suma_pago = $pasaje->pago_soles + $pasaje->pago_dolares*$pasaje->cambio;

        if($suma_pago > $pasaje->total*$request->cambio)
        {
            $pasaje->redondeo = $suma_pago - ($pasaje->total*$request->cambio) ;
        }
        else{
            $pasaje->redondeo = 0;
        }

        $pasaje->deuda_detalle=$request->deuda_detalle;
        $pasaje->deuda_monto=$request->deuda_monto;
        $pasaje->deuda_soles = ($request->deuda_soles=='') ? 0 : $request->deuda_soles;
        $pasaje->deuda_dolares = ($request->deuda_dolares=='') ? 0 : $request->deuda_dolares;
        $pasaje->deuda_visa = ($request->deuda_visa=='') ? 0 : $request->deuda_visa;
        $pasaje->deuda_depo_soles = ($request->deuda_depo_soles=='') ? 0 : $request->deuda_depo_soles;
        $pasaje->deuda_depo_dolares = ($request->deuda_depo_dolares=='') ? 0 : $request->deuda_depo_dolares;

        $pasaje->save();

        return response()->json([
            'mensaje' => 'Pasaje Modificado Satisfactoriamente'
        ]);
    }
}
