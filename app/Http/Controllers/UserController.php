<?php

namespace App\Http\Controllers;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function create()
    {

    }

    public function lista(){
        return User::with(['roles','local'])->orderBy('username','ASC')->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191|string',
            'lastname' => 'required|max:191|string',
            'email' => 'required|max:191|string|email',
            'password' => 'required|min:8|string',
            'username' => 'required',
            'local_id' => 'required',
            'role_id' => 'required'
        ]);

        $role = Role::findOrFail($request->role_id);

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->password2 = $request->password;
        $user->local_id = $request->local_id;
        $user->tipo = $role->name;
        $user->created_at = Carbon::now();
        $user->save();

        $user->assignRole($role->name);

        return response()->json([
            'mensaje' => 'Registro Agregado Satisfactoriamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\USer  $uSer
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        return User::with(['roles','local'])
                ->where('name','like','%'.$request->texto.'%')
                ->paginate(10);
    }

    public function show(Request $request)
    {
        return User::with(['roles','local'])->where('id',$request->id)->first();
    }

    public function edit(Request $request)
    {
        return User::with(['roles','local'])->where('id',$request->id)->first();
    }

    public function update(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $user = User::with(['roles','local'])->where('id',$request->id)->first();

        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->username = $request->username;
        if($request->password != ''){
            $user->password = Hash::make($request->password);
            $user->password2 = $request->password;

            //$decrypted = Crypt::decryptString($encrypted);
        }
        $user->local_id = $request->local_id;
        $user->tipo = $role->name;
        $user->save();

        $user->syncRoles($role->name);

        return response()->json([
            'mensaje' => 'Registro Modificado Satisfactoriamente'
        ]);
    }
    public function destroy(Request $request)
    {
        $user = User::where('id',$request->id)->first();

        $user->delete();

        return response()->json([
            'mensaje' => 'Usuario Eliminado Satisfactoriamente'
        ]);
    }
}
