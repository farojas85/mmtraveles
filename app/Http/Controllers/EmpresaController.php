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

    public function store(Request $request)
    {
        $request->validate([
            'razon_social' => 'required|max:191|string',
            'ruc' => 'required|min:11|max:11',
        ]);

        $empresa = Empresa::create([
            'razon_social' => $request->razon_social,
            'nombre_comercial' => $request->nombre_comercial,
            'ruc' => $request->ruc,
            'direccion' => $request->direccion
        ]);

        return response()->json([
            'mensaje' => 'Registro Agregado Satisfactoriamente'
        ]);
    }

    public function show(Request $request)
    {
        return Empresa::findOrFail($request->id);
    }

    public function edit(Request $request)
    {
        return Empresa::finOrFail($request->id);
    }

    public function update(Request $request)
    {
        $empresa = Empresa::findOrFail($request->id);
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre_comercial = $request->nombre_comercial;
        $empresa->ruc = $request->ruc;
        $empresa->direccion = $request->direccion;
        $empresa->save();

        return response()->json([
            'mensaje' => 'Registro Modificado Satisfactoriamente'
        ]);
    }


    public function destroy(Request $request)
    {
        $empresa = Empresa::findOrFail($request->id);
        $empresa->delete();

        return response()->json([
            'mensaje' => 'Empresa Retirada Satisfactoriamente'
        ]);
    }

    public function showdelete()
    {
        return Empresa::onlyTrashed()->paginate(10);
    }

    public function restoredelete(Request $request) {
        $empresa = Empresa::onlyTrashed()->where('id',$request->id)->first();

        $empresa->restore();

        return response()->json(['mensaje' => 'Registro Restaurado Satisfactoriamente']);
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
