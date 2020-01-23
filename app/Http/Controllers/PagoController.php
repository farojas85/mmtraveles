<?php

namespace App\Http\Controllers;

use App\Pago;

use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function store(Request $request)
    {
        $rules =[
            'local_id' => 'required',
            'rubro' => 'required',
            'fecha' => 'required'
        ];

        $mensaje= [
            'required' => 'Campo Obligatorio',
        ];

        $this->validate($request,$rules,$mensaje);

        $pago = new Pago();
        $pago->local_id = $request->local_id;
        $pago->rubro = $request->rubro;
        $pago->fecha =($request->fecha < 10 ) ? '0'.$request->fecha : $request->fecha;
        $pago->monto_soles = ($request->monto_soles == '' || $request->monto_soles == null) ? 0 : $request->monto_soles;
        $pago->monto_dolares =($request->monto_dolares == '' || $request->monto_dolares == null) ? 0 : $request->monto_dolares;

        $pago->save();

        return response()->json([
            'pago' => $pago,
            'mensaje' => "Datos Guardados Satisfactoriamente"]);
    }

    public function listarRubroLocal(Request $request)
    {
        return Pago::where('local_id',$request->local)
                    ->select('rubro')
                    ->groupBy('rubro')
                    ->orderBy('rubro')
                    ->get();
    }
}
