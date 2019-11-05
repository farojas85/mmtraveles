<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

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
     * @param  \App\USer  $uSer
     * @return \Illuminate\Http\Response
     */
    public function show(USer $uSer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\USer  $uSer
     * @return \Illuminate\Http\Response
     */
    public function edit(USer $uSer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\USer  $uSer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, USer $uSer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\USer  $uSer
     * @return \Illuminate\Http\Response
     */
    public function destroy(USer $uSer)
    {
        //
    }
}
