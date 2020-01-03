<?php

namespace App\Http\Controllers;

use App\EtapaPersona;
use Illuminate\Http\Request;

class EtapaPersonaController extends Controller
{

    public function filtro() {
        return EtapaPersona::select('id','abreviatura','nombre')->get();
    }
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EtapaPersona  $etapaPersona
     * @return \Illuminate\Http\Response
     */
    public function show(EtapaPersona $etapaPersona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EtapaPersona  $etapaPersona
     * @return \Illuminate\Http\Response
     */
    public function edit(EtapaPersona $etapaPersona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EtapaPersona  $etapaPersona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EtapaPersona $etapaPersona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EtapaPersona  $etapaPersona
     * @return \Illuminate\Http\Response
     */
    public function destroy(EtapaPersona $etapaPersona)
    {
        //
    }
}
