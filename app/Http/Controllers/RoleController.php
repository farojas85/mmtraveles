<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.create')->only(['create','store']);
        $this->middleware('permission:roles.index')->only('index');
        $this->middleware('permission:roles.edit')->only(['edit','update']);
        $this->middleware('permission:roles.show')->only('show');
        $this->middleware('permission:roles.destroy')->only('destroy');
    }

    public function lista()
    {
        return Role::paginate(5);
    }

    public function filtro()
    {
        return Role::select('id','name')->get();
    }
}
