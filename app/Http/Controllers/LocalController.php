<?php

namespace App\Http\Controllers;

use App\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('permission:empresas.create')->only(['create','store']);
        $this->middleware('permission:empresas.index')->only('index');
        $this->middleware('permission:empresas.edit')->only(['edit','update']);
        $this->middleware('permission:empresas.show')->only('show');
        $this->middleware('permission:empresas.destroy')->only('destroy');
        $this->middleware('permission:empresas.showdelete')->only('showdelete');
    }*/

    public function index()
    {
        return view('entidad.local.index');
    }

    public function lista()
    {
        return Local::with(['empresa','lugar'])->latest()->paginate(10);
    }

    public function filtro()
    {
        return Local::select('id','nombre')->get();
    }
    public function create()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:191|string'
        ]);

        $local = local::create([
            'nombre' => $request->nombre,
            'empresa_id' => $request->empresa_id,
            'lugar_id' => $request->lugar_id
        ]);

        return response()->json([
            'mensaje' => 'Registro Agregado Satisfactoriamente'
        ]);
    }

    public function show(Request $request)
    {
        return Local::findOrFail($request->id);
    }

    public function edit(Request $request)
    {
        return Local::finOrFail($request->id);
    }

    public function update(Request $request)
    {
        $local = Local::findOrFail($request->id);
        $local->nombre = $request->nombre;
        $local->empresa_id = $request->empresa_id;
        $local->lugar_id = $request->lugar_id;
        $local->estado = $request->estado;
        $local->save();

        return response()->json([
            'mensaje' => 'Registro Modificado Satisfactoriamente'
        ]);
    }


    public function destroy(Request $request)
    {
        $local = Local::findOrFail($request->id);
        $local->delete();

        return response()->json([
            'mensaje' => 'Local Retirado Satisfactoriamente'
        ]);
    }

    public function showdelete()
    {
        return Local::with(['empresa','lugar'])->onlyTrashed()->paginate(10);
    }

    public function restoredelete(Request $request) {
        $local = Local::onlyTrashed()->where('id',$request->id)->first();

        $local->restore();

        return response()->json(['mensaje' => 'Registro Restaurado Satisfactoriamente']);
    }
}
