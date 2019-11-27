<?php

namespace App\Http\Controllers;

use App\Adicional;
use Illuminate\Http\Request;

class AdicionalController extends Controller
{

    public function lista() {
        return Adicional::select('id','descripcion')->get();
    }

    public function filtro() {
        return Adicional::select('id','descripcion')->get();
    }

    public function filtroPorId(Request $request) {
        return Adicional::findOrFail($request->id);
    }
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Adicional $adicional)
    {
        //
    }

    public function edit(Adicional $adicional)
    {
        //
    }

    public function update(Request $request, Adicional $adicional)
    {
        //
    }

    public function destroy(Adicional $adicional)
    {
        //
    }
}
