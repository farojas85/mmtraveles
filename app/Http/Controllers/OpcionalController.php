<?php

namespace App\Http\Controllers;

use App\User;
use App\Adicional;
use App\Opcional;
use App\OpcionalDetalle;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;
use DB;
use Illuminate\Http\Request;

class OpcionalController extends Controller
{
    public function index()
    {
        return view('pasaje.opcional');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =[
            'pasajero' => 'required',
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required',
            'fecha_venta' => 'required',
            'moneda' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            'monto_pagar' => 'required'
        ];

        $mensaje= [
            'required' => 'Campo Obligatorio',
            //'max' => 'Pago Dolares no debe exceder de TOTAL'
            //'same' => 'Pago Dolares debe ser Igual a Total'
        ];
        
        $this->validate($request,$rules,$mensaje);
        
        $opcional = new Opcional();
        $opcional->counter_id = Auth::user()->id;
        $opcional->pasajero = $request->pasajero;
        $opcional->tipo_documento_id = $request->tipo_documento_id;
        $opcional->numero_documento = $request->numero_documento;

        $date = Carbon::now();
        
        $opcional->fecha =  (is_null($request->fecha_venta) || $request->fecha_venta == "" ) ?  $date->format('Y-m-d') : $request->fecha_venta;
        
        $opcional->monto_pagar = $request->monto_pagar;
        
        $opcional->moneda = $request->moneda;
        $opcional->cambio = $request->cambio;
        
        $opcional->pago_soles = ($request->pago_soles=='') ? 0 : $request->pago_soles;
        $opcional->pago_dolares =  ($request->pago_dolares=='') ? 0 : $request->pago_dolares;
        $opcional->pago_visa =  ($request->pago_visa=='') ? 0 : $request->pago_visa;
        $opcional->deposito_soles =  ($request->deposito_soles=='') ? 0 : $request->deposito_soles;
        $opcional->deposito_dolares =  ($request->deposito_dolares=='') ? 0 : $request->deposito_dolares;
        
        $opcional->sub_total =$request->sub_total;
        $opcional->igv = ($request->igv == 0) ? 0 : $request->igv;
        $opcional->total = $request->total;
        
        $suma_pago = $opcional->pago_soles + $opcional->pago_dolares*$opcional->cambio;
        
        if($suma_pago > $opcional->total*$request->cambio)
        {
            $opcional->redondeo = $suma_pago - ($opcional->total*$request->cambio) ;
        }
        else{
            $opcional->redondeo = 0;
        }

        $opcional->save();
        
        foreach($request->adicionales as $adic)
        {
            $opcional_adicional = new OpcionalDetalle();
            $opcional_adicional->opcional_id = $opcional->id;
            $opcional_adicional->adicional_id = $adic['adicional_id'];
            $opcional_adicional->detalle_otro = $adic['detalle'];
            $opcional_adicional->monto = $adic['monto'];
            $opcional_adicional->service_fee = $adic['service_fee'];
            $opcional_adicional->importe = $adic['importe'];
            
            //return $opcional_adicional;
           $opcional_adicional->save();
        }
        
        Session::put('opcional_id',$opcional->id);

        return response()->json([
            'opcional' => $opcional,
            'mensaje' => "Datos Guardados Satisfactoriamente"]);
    }

    
    public function mostrar()
    {
        return View('pasaje.mostrarAdicionales');    
    }
    
    
     public function listaPorUsuario()
    {
        $date = Carbon::now();

        $user = User::with('roles')->where('id',Auth::user()->id)->first();
        $role_name ='';
        $opcional = null;

        foreach($user->roles as $role)
        {
            $role_name = $role->name;
        }
         $condicion ='';
        if($role_name == 'Gerente' || $role_name == 'Administrador'){
            $condicion = '%';

            $opcional =  Opcional::with(['user','OpcionalDetalles'])
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
                $opcional =  Opcional::with(['user','OpcionalDetalles'])
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

                $opcional =  Opcional::with(['user','OpcionalDetalles'])
                            ->whereIn('counter_id',$useres)
                            ->orderBy('created_at','DESC')
                            ->get();
            }

        }
        else {
            $condicion2 = Auth::user()->id;
            $opcional= Opcional::with(['user','OpcionalDetalles'])
                        ->where('counter_id', Auth::user()->id)
                        ->orderBy('created_at','DESC')
                        ->get();
        }
        return $opcional;

    }
    public function show(Request $request)
    {
        $opcional_detalle = OpcionalDetalle::where('opcional_id',$request->id)->get();
        return view('pasaje.adicionaltabla',compact('opcional_detalle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Opcional  $opcional
     * @return \Illuminate\Http\Response
     */
    public function edit(Opcional $opcional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Opcional  $opcional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opcional $opcional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Opcional  $opcional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opcional $opcional)
    {
        //
    }
}
