<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:empresas.create')->only(['create','store']);
        $this->middleware('permission:empresas.index')->only('index');
        $this->middleware('permission:empresas.edit')->only(['edit','update']);
        $this->middleware('permission:empresas.show')->only('show');
        $this->middleware('permission:empresas.destroy')->only('destroy');
        $this->middleware('permission:empresas.showdelete')->only('showdelete');
    }

    public function index()
    {
        return view('entidad.empresa.index');
    }

    public function lista()
    {
        return Empresa::latest()->paginate(10);
    }

    public function filtro()
    {
        return Empresa::select('id','razon_social')->get();
    }
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
