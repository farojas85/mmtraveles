<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function egresos()
    {
        return view('extras.egresos.index');
    }
}
