<?php

namespace App\Http\Controllers;

use App\Opcional;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Opcional  $opcional
     * @return \Illuminate\Http\Response
     */
    public function show(Opcional $opcional)
    {
        //
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
