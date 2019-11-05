<?php

namespace App\Http\Controllers;

use App\Lugar;
use App\Pasaje;
use Illuminate\Http\Request;

class ReportePlantillaController extends Controller
{
    public function index()
    {
        return view('Reportes.plantillas');
    }
}
