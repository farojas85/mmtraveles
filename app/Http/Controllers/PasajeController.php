<?php

namespace App\Http\Controllers;

use App\User;
use App\Pasaje;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pasaje.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pasaje = new Pasaje();
        $pasaje->pasajero = $request->pasajero;
        $pasaje->viajecode = $request->codigo;
        $pasaje->ruta = $request->ruta;
        $pasaje->tipo_viaje = $request->tipo_viaje;
        $pasaje->pasaje_total = $request->pasaje_total;
        $pasaje->monto_neto = $request->monto_neto;
        $pasaje->fare = $request->monto_neto/1.18;
        $pasaje->igv = $pasaje->fare*0.18;
        $pasaje->tuaa = $request->tuaa;
        $pasaje->not_igv = $request->not_igv;
        $pasaje->razon_social = $request->razon_social;
        $pasaje->direccion= $request->direccion;

        if($request->not_igv == 1){
            $pasaje->comision = $pasaje->pasaje_total - $pasaje->fare - $pasaje->tuaa;
        }
        else {
            $pasaje->comision = $pasaje->pasaje_total - $pasaje->monto_neto - $pasaje->tuaa;
        }

        $pasaje->comision_costamar = 0;
        $pasaje->comision_kiu = 0;
        $pasaje->comision_sabre = 0;

        //COMISIONES COSTAMAR
        //COMISIONES COSTAMAR
        //AVIANCA 614
        if($request->aerolinea_id==614)
        {
        $pasaje->comision_costamar = $pasaje->monto_neto; //CAMBIAMOS $pasaje->monto_neto*0.02
        }
        //PERUVIAN 611
        if($request->aerolinea_id==611)
        {
        $pasaje->comision_costamar = $pasaje->monto_neto*0.06;
        }
        //LC PERU 613 COSTAMAR
        if($request->aerolinea_id==613)
        {
        $pasaje->comision_costamar = $pasaje->monto_neto*0.08;
        }
        //LC PERU 618 COSTAMAR 2
        if($request->aerolinea_id==618)
        {
        $pasaje->comision_costamar = $pasaje->monto_neto*0.08;
        }
        if($request->aerolinea_id==617)
        {
        $pasaje->comision_costamar = $pasaje->monto_neto*0.08;
        }

        //COMISIONES SABRE
            //PERUVIAN 611 y AVIANCA 614 y LATAM 612 y LC PERU 613
        if($request->aerolinea_id==611
            || $request->aerolinea_id==612
            || $request->aerolinea_id==613
            || $request->aerolinea_id==614
            || $request->aerolinea_id==617)
        {
            if ($pasaje->tipo_viaje==1) {
                $pasaje->comision_sabre = 1;
            }
            else{
                $pasaje->comision_sabre = 2;
            }
        }


    //COMISIONES KIU
        //STAR PERU 615
        if($request->aerolinea_id==615)
        {
            $pasaje->comision = $pasaje->pasaje_total-$pasaje->monto_neto-$pasaje->tuaa;
            $pasaje->comision_kiu = $pasaje->fare*0.04;

            if($request->not_igv){
             $pasaje->comision = $pasaje->pasaje_total-$pasaje->fare-$pasaje->tuaa;

            }
            else{
            $pasaje->comision = $pasaje->pasaje_total-$pasaje->monto_neto-$pasaje->tuaa;
            }

        //$pasaje->comision_kiu = $pasaje->monto_neto*0.02;
        }

        $pasaje->pago_soles = $request->pago_soles;
        $pasaje->pago_dolares = $request->pago_dolares;
        $pasaje->pago_visa = 0;

        $pasaje->deposito_soles = $request->deposito_soles;
        $pasaje->deposito_dolares = 0;

        $pasaje->aerolinea_id=$request->aerolinea_id;
        $pasaje->telefono=$request->telefono;
        $pasaje->observaciones=$request->observaciones;

        $pasaje->counter_id = Auth::user()->id;

        if ($request->internacional==1) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.01;
        }
        if ($request->internacional==2) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.02;
        }
        if ($request->internacional==3) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.03;
        }
        if ($request->internacional==4) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.04;
        }
        if ($request->internacional==5) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.05;
        }
        if ($request->internacional==6) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.06;
        }
        if ($request->internacional==7) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.07;
        }
        if ($request->internacional==8) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.08;
        }
        if ($request->internacional==9) {
            $pasaje->comision_costamar = $pasaje->monto_neto*0.09;
        }

        if(is_null($request->fecha_venta) || $request->fecha_venta == "" )
        {
            $date = Carbon::now();
            $pasaje->created_at_venta =  $date->format('Y-m-d H:i:s');
            $pasaje->created_at = $date->format('Y-m-d H:i:s');
            $pasaje->save();
        }
        else{
            $pasaje->created_at_venta =  Carbon::parse($request->fecha_venta)->format('Y-m-d H:i:s');
            $pasaje->created_at =  Carbon::parse($request->fecha_venta)->format('Y-m-d H:i:s');
            $pasaje->save(); //exit();
        }
        return "Datos Guardados Satisfactoriamente";
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
        if($role_name == 'Responsable' || $role_name == 'Gerente' || $role_name == 'Administrador'){
            $condicion = '%';

            $pasaje =  Pasaje::with(['user','aerolinea'])
                            ->where('created_at','>=', $date->format('Y-m-d'))
                            ->orderBy('created_at','DESC')
                            ->get();
        }
        else {
            $condicion2 = Auth::user()->id;
            $pasaje= Pasaje::with(['user','aerolinea'])
                        ->where('counter_id', Auth::user()->id)
                        ->where('created_at','>=', $date->format('Y-m-d'))
                        ->orderBy('created_at','DESC')
                        ->get();
        }
        return $pasaje;

    }
    public function mostrar()
    {
        return view('pasaje.mostrar');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Pasaje  $pasaje
     * @return \Illuminate\Http\Response
     */
    public function show(Pasaje $pasaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pasaje  $pasaje
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasaje $pasaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pasaje  $pasaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pasaje $pasaje)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pasaje  $pasaje
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasaje $pasaje)
    {
        //
    }
}
