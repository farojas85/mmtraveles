<?php

namespace App\Http\Controllers;

use App\Aerolinea;
use Illuminate\Http\Request;

class AerolineaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('entidad.aerolinea.index');
    }

    public function lista() {
        return Aerolinea::paginate(10);
    }

    public function filtro() {
        return Aerolinea::select('id','name')->get();
    }

    public function filtroById(Request $request) {
        return Aerolinea::where('id',$request->id)
                        ->select('id','name','description','ruc','direccion')
                        ->first();
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Aerolinea $aerolinea)
    {
        //
    }

    public function edit(Aerolinea $aerolinea)
    {
        //
    }

    public function update(Request $request, Aerolinea $aerolinea)
    {
        //
    }

    public function destroy(Aerolinea $aerolinea)
    {
        //
    }

}
