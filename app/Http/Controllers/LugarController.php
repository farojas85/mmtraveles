<?php

namespace App\Http\Controllers;

use App\Lugar;
use Auth;
use Illuminate\Http\Request;

class LugarController extends Controller
{

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

    public function show(Lugar $lugar)
    {
        //
    }

    public function edit(Lugar $lugar)
    {
        //
    }

    public function update(Request $request, Lugar $lugar)
    {
        //
    }

    public function destroy(Lugar $lugar)
    {
        //
    }

    public function listarPorUsuario(){
        return Lugar::join('user_category as uc','category.id','=','uc.category_id')
                    ->where('uc.user_id',Auth::user()->id)
                    ->select('category.id','category.name')
                    ->get();
    }
}
