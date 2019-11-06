<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;
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
        return Empresa::select('id','razon_social','foto')->get();
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

    public function update(Request $request, Empresa $empresa)
    {
        //
    }


    public function destroy(Empresa $empresa)
    {
        //
    }

    public function empresaPorUsuario()
    {
        $user = User::with('roles')->where('id',Auth::user()->id)->first();
        $role_name ='';
        $pasaje = null;
        foreach($user->roles as $role)
        {
            $role_name = $role->name;
        }

        $empresa = '';
        if($role_name=='Administrador' || $role_name=='Gerente')
        {
            return Empresa::select('id','razon_social','foto')->get();
        }

        return Empresa::join('empresa_user as eu','empresas.id','=','eu.empresa_id')
                        ->select('empresas.id','razon_social','empresas.foto')
                        ->where('eu.user_id',Auth::user()->id)->get();
    }
}
