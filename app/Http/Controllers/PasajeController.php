<?php

namespace App\Http\Controllers;

use App\User;
use App\Pasaje;
use App\PasajeAdicional;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Http\Request;
use Session;
use DB;

class PasajeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:pasajes.create')->only(['create','store']);
        $this->middleware('permission:pasajes.index')->only('index');
        $this->middleware('permission:pasajes.edit')->only(['edit','update']);
        $this->middleware('permission:pasajes.show')->only('show');
        $this->middleware('permission:pasajes.destroy')->only('destroy');
    }
    public function index()
    {
        return view('');
    }

    public function create()
    {
        return view('pasaje.create');
    }

    public function store(Request $request)
    {
        $rules =[
            'pasajero' => 'required',
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required',
            'fecha_venta' => 'required',
            'ticket_number' => 'required',
            'aerolinea_id' => 'required',
            'codigo' => 'required',
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
            'required' => 'Campo Obligatorio',
            //'max' => 'Pago Dolares no debe exceder de TOTAL'
            //'same' => 'Pago Dolares debe ser Igual a Total'
        ];

        $this->validate($request,$rules,$mensaje);

        $pasaje = new Pasaje();
        $pasaje->counter_id = Auth::user()->id;
        $pasaje->pasajero = $request->pasajero;
        $pasaje->tipo_documento_id = $request->tipo_documento_id;
        $pasaje->numero_documento = $request->numero_documento;
        $pasaje->dni = null;

        $date = Carbon::now();
        if(is_null($request->fecha_venta) || $request->fecha_venta == "" )
        {
            $pasaje->created_at_venta =  $date->format('Y-m-d H:i:s');
            $pasaje->created_at = $date->format('Y-m-d H:i:s');

        }
        else{
            $pasaje->created_at_venta =  Carbon::parse($request->fecha_venta)->format('Y-m-d H:i:s');
            $pasaje->created_at = $date->format('Y-m-d H:i:s');

        }
        $pasaje->ticket_number = $request->ticket_number;
        $pasaje->aerolinea_id=$request->aerolinea_id;
        $pasaje->direccion= $request->direccion;
        $pasaje->ruc = $request->ruc;
        $pasaje->viajecode = $request->codigo;
        $pasaje->ruta = $request->ruta;
        $pasaje->tipo_viaje = $request->tipo_viaje;
        $pasaje->fecha_vuelo = $request->fecha_vuelo;
        $pasaje->fecha_retorno =  ($request->fecha_retorno== '') ?null : $request->hora_vuelta;
        $pasaje->hora_vuelo = $request->hora_vuelo;
        $pasaje->hora_vuelta = ($request->hora_vuelta== '') ? null : $request->hora_vuelta;
        $pasaje->vuelo = $request->vuelo;
        $pasaje->cl = $request->cl;
        $pasaje->st = $request->st;
        $pasaje->equipaje = $request->equipaje;

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

        $pasaje->save();



        /*foreach($request->adicionales as $adic)
        {
            $pasaje_adicional = new PasajeAdicional();
            $pasaje_adicional->pasaje_id = $pasaje->id;
            $pasaje_adicional->descripcion = $adic['detalle'];
            $pasaje_adicional->monto = $adic['monto'];
            $pasaje_adicional->tuaa = $adic['service_fee'];
            $pasaje_adicional->total = $adic['importe'];

            //return $pasaje_adicional;
           $pasaje_adicional->save();
        }*/

        Session::put('pasaje_id',$pasaje->id);

        return response()->json([
            'pasaje' => $pasaje,
            'mensaje' => "Datos Guardados Satisfactoriamente"]);
    }

    public function listaPorUsuario()
    {
        $date = Carbon::now();

        $user = User::with('roles')->where('id',Auth::user()->id)->first();
        $role_name ='';
        $pasaje = null;

        foreach($user->roles as $role)
        {
            $role_name = $role->name;
        }
         $condicion ='';
        if($role_name == 'Gerente' || $role_name == 'Administrador'){
            $condicion = '%';

            $pasaje =  Pasaje::with(['user','aerolinea'])
                            ->orderBy('created_at','DESC')
                            ->get();
        }
        else if($role_name == 'Responsable' )
        {
            $usercat = DB::table('user_category')
                            ->where('user_id',Auth::user()->id)
                            ->select('category_id')
                            ->first();

            $userd = DB::table('user_category')
                            ->where('category_id',$usercat->category_id)
                            ->select('user_id')
                            ->get();
            $userd_count = DB::table('user_category')
                            ->where('category_id',$usercat->category_id)
                            ->count();

            if(Auth::user()->id == 8){
                $pasaje =  Pasaje::with(['user','aerolinea'])
                            ->orderBy('created_at','DESC')
                            ->get();

            }
            else
            {
                $useres =array();
                foreach($userd as $det)
                {
                    array_push($useres,$det->user_id);
                }

                $pasaje =  Pasaje::with(['user','aerolinea'])
                            ->whereIn('counter_id',$useres)
                            ->orderBy('created_at','DESC')
                            ->get();
            }

        }
        else {
            $condicion2 = Auth::user()->id;
            $pasaje= Pasaje::with(['user','aerolinea'])
                        ->where('counter_id', Auth::user()->id)
                        ->orderBy('created_at','DESC')
                        ->get();
        }
        return $pasaje;

    }
    public function mostrar()
    {
        return view('pasaje.mostrar');
    }
    public function imprimir(Request $request) {
        ob_end_clean();
        Fpdf::AddPage();
        Fpdf::SetTitle('Boleta Cobranza');
       // Fpdf::Image('assets/images/logo_dark.png',5,4,30);
        //Establecemos el Encabezado  de la serie y Número
        Fpdf::SetFont('Courier', 'B', 7);
        Fpdf::setXY(40,3);
        Fpdf::setFillColor(220,220,220);
        Fpdf::Cell(30, 5, 'BOLETA DE COBRANZA',1,1,'C',1);
        Fpdf::setFillColor(255,255,255);
        Fpdf::setXY(40,8);
        Fpdf::Cell(30, 5, '',1,1,'C',1);
        Fpdf::SetFont('Courier', '', 7);
        Fpdf::Line(4,15,70,15);
        Fpdf::setXY(4,16);
        Fpdf::Output();
    }

    public function show(Request $request)
    {
        return response()->json(['pasaje'=> Pasaje::where('id',$request->id)->first()]);
    }

    public function pasajeEmitidos()
    {
        return view('pasaje.emitidos');
    }

    public function reporteEmitidos(Request $request)
    {
        $rules =[
            'lugar' => 'required',
            'local' => 'required',
            'counter' => 'required',
            'aerolinea' => 'required',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required'
        ];

        $mensaje= [
            'required' => 'Campo Obligatorio'
        ];

        $this->validate($request,$rules,$mensaje);

        $pasaje = Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                        ->leftJoin('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->join('locals as lo','lo.id','=','u.local_id')
                        ->join('category as lu','lu.id','=','lo.lugar_id')
                        ->select('pasaje.id',
                                DB::Raw("CONCAT(u.name,' ',u.lastname) as counter"),
                                'viajecode','ae.name as aero',
                                'pasaje.pasajero','pasaje.moneda','pasaje.cambio',
                                'ruta','pasaje.total','pago_soles','pago_dolares',
                                'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at',
                                'pasaje.created_at_venta','pasaje.deleted_at')
                        ->where('lu.id','like',$request->lugar)
                        ->where('lo.id','like',$request->local)
                        ->where('u.id','like',$request->counter)
                        ->where('ae.id','like',$request->aerolinea)
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->get();


        return response()->json(['pasaje' => $pasaje]);

    }

    public function todos(Request $request)
    {
        $rules =[
            'lugar' => 'required',
            'local' => 'required',
            'counter' => 'required',
            'aerolinea' => 'required',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required'
        ];

        $mensaje= [
            'required' => 'Campo Obligatorio'
        ];

        $this->validate($request,$rules,$mensaje);

        $pasaje = Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                        ->leftJoin('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->join('locals as lo','lo.id','=','u.local_id')
                        ->join('category as lu','lu.id','=','lo.lugar_id')
                        ->select('pasaje.id',
                                DB::Raw("CONCAT(u.name,' ',u.lastname) as counter"),
                                'viajecode','ae.name as aero',
                                'pasaje.pasajero','pasaje.moneda','pasaje.cambio',
                                'ruta','pasaje.total','pago_soles','pago_dolares',
                                'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at',
                                'pasaje.created_at_venta','pasaje.deleted_at')
                        ->where('lu.id','like',$request->lugar)
                        ->where('lo.id','like',$request->local)
                        ->where('u.id','like',$request->counter)
                        ->where('ae.id','like',$request->aerolinea)
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->withTrashed()->get();


        return response()->json(['pasaje' => $pasaje]);
    }

    public function eliminados(Request $request)
    {
        $rules =[
            'lugar' => 'required',
            'local' => 'required',
            'counter' => 'required',
            'aerolinea' =>'required',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required'
        ];

        $mensaje= [
            'required' => 'Campo Obligatorio'
        ];

        $this->validate($request,$rules,$mensaje);

        $pasaje = Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                        ->leftJoin('product as ae','pasaje.aerolinea_id','=','ae.id')
                        ->join('locals as lo','lo.id','=','u.local_id')
                        ->join('category as lu','lu.id','=','lo.lugar_id')
                        ->select('pasaje.id',
                                DB::Raw("CONCAT(u.name,' ',u.lastname) as counter"),
                                'viajecode','ae.name as aero',
                                'pasaje.pasajero','pasaje.moneda','pasaje.cambio',
                                'ruta','pasaje.total','pago_soles','pago_dolares',
                                'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at',
                                'pasaje.created_at_venta','pasaje.deleted_at')
                        ->where('lu.id','like',$request->lugar)
                        ->where('lo.id','like',$request->local)
                        ->where('u.id','like',$request->counter)
                        ->where('ae.id','like',$request->aerolinea)
                        ->where('pasaje.created_at_venta','>=',$request->fecha_ini)
                        ->where('pasaje.created_at_venta','<=',$request->fecha_fin)
                        ->onlyTrashed()->get();


        return response()->json(['pasaje' => $pasaje]);
    }
    public function pasajeAdicionales(Request $request)
    {
        return PasajeAdicional::where('pasaje_id',$request->id)->get();
    }

    public function eliminarSeleccionadosTemporal(Request $request)
    {
        $pasaje = Pasaje::withTrashed()->whereIn('id' , $request)->get();

        foreach($pasaje as $pa)
        {
            $pa->delete();
        }

        return response()->json([
            'mensaje' => "Los Registros han sido enviados a Papelera de Reciclaje"]);
    }

    public function eliminarSeleccionadosPermanente(Request $request)
    {
        $pasaje = Pasaje::withTrashed()->whereIn('id' , $request)->get();

        foreach($pasaje as $pa)
        {
            $pa->forceDelete();
        }

        return response()->json([
            'mensaje' => "Los Registros han sido enviados a Papelera de Reciclaje"]);
    }


    public function eliminarTemporal(Request $request)
    {
        $pasaje = Pasaje::withTrashed()
                        ->where('id',$request->id)->first()->Delete();

        return response()->json([
            'pasaje' =>$pasaje,
            'mensaje' => 'el Pasaje ha sido enviada a Papelera de Reciclaje'
        ]);
    }

    public function eliminarPermanente(Request $request)
    {
        $pasaje = Pasaje::withTrashed()
                        ->where('id',$request->id)->first()->forceDelete();

        return response()->json([
            'pasaje' =>$pasaje,
            'mensaje' => 'el Pasaje ha sido eliminado Satisfactoriamente'
        ]);
    }

    public function restaurar(Request $request) {
        $pasaje = Pasaje::onlyTrashed()
                        ->where('id',$request->id)->first()->restore();

        return response()->json([
            'pasaje' => $pasaje,
            'mensaje' => 'El Pasaje ha sido restaurado Satisfactoriamente'
        ]);
    }

    public function destroy(Request $request)
    {
        $pasaje = Pasaje::findOrFail($request->id);
        $pasaje->delete();

        return response()->json([
            'mensaje' => 'Pasaje Eliminado Satisfactoriamente'
        ]);
    }

    public function listarLugar() {
        return Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                    ->join('locals as lo','lo.id','=','u.local_id')
                    ->join('category as lu','lu.id','=','lo.lugar_id')
                    ->select('lu.id','lu.name')
                    ->groupBy('lu.id','lu.name')
                    ->get();
    }

    public function listarLocal(Request $request) {
        return Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                    ->join('locals as lo','lo.id','=','u.local_id')
                    ->join('category as lu','lu.id','=','lo.lugar_id')
                    ->select('lo.id','lo.nombre')
                    ->where('lu.id','LIKE',$request->lugar)
                    ->groupBy('lo.id','lo.nombre')
                    ->get();
    }

    public function listarCounter(Request $request) {
        return Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                    ->join('locals as lo','lo.id','=','u.local_id')
                    ->join('category as lu','lu.id','=','lo.lugar_id')
                    ->select('u.id','u.name','u.lastname')
                    ->where('lu.id','LIKE',$request->lugar)
                    ->where('lo.id','LIKE',$request->local)
                    ->groupBy('u.id','u.name','u.lastname')
                    ->get();
    }

    public function editar(Request $request)
    {
        return Pasaje::findOrFail($request->id);
    }
}
