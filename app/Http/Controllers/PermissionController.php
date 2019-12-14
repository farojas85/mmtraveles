<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:permisos.nuevo')->only(['create','store']);
        // $this->middleware('permission:permisos.inicio')->only('index');
        // $this->middleware('permission:permisos.editar')->only(['edit','update']);
        // $this->middleware('permission:permisos.mostrar')->only('show');
        // $this->middleware('permission:permisos.eliminar')->only('destroy');
    }

    public function lista()
    {
        return Permission::paginate(10);
    }

    public function filtro()
    {
        return Permission::select('id','name')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:191'
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name  = 'web';
        $permission->save();

        return response()->json(['mensaje' => 'Permiso Registrado Satisfactoriamente']);
    }

    public function search(Request $request){
        return Permission::where('name' ,'like','%'.$request->texto.'%')->paginate(10);
    }

    public function show(Request $request)
    {
        return Permission::where('id',$request->id)
                            ->select('id','name','guard_name')
                            ->first();
    }

    public function update(Request $request)
    {
        $permission = Permission::findOrFail($request->id);

        $permission->name = $request->name;
        $permission->save();

        return response()->json(['mensaje' => 'El permiso ha sido modificado satisfactoriamente']);
    }

    public function destroy(Request $request)
    {
        $permission = Permission::findOrFail($request->id);
        $permission->delete();

        return response()->json(['mensaje' => 'El permiso ha sido eliminado Satisfactoriamente']);
    }

    public function listarPermissionRoles(Request $request)
    {
        return Role::with('permissions')->where('roles.id',$request->id)->get();
    }

    public function guardarPermissionRole(Request $request)
    {
        $role = Role::where('id',$request->role_id)->first();

        $role->syncPermissions($request->permission_name);

        return response()->json(['mensaje' => 'Permisos asignados satisfactoriamente']);
    }
}
