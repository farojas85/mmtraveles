<?php

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Añadiendo Roles
        $gerente =Role::firstOrCreate(['name' => 'Gerente']);
        $administrador = Role::firstOrCreate(['name' => 'Administrador']);
        Role::firstOrCreate(['name' => 'Responsable']);
        Role::firstOrCreate(['name' => 'Usuario']);

        //Gerente
        $gerente->givePermissionTo([
            'administracion.index',
            'configuraciones.index',
            'roles.index',
            'roles.create',
            'roles.show',
            'roles.edit',
            'roles.destroy',
            'permissions.index',
            'permissions.create',
            'permissions.show',
            'permissions.edit',
            'permissions.destroy',
            'users.index',
            'users.create',
            'users.show',
            'users.edit',
            'users.destroy'
        ]);

        //Administrador
        $administrador->givePermissionTo([
            'administracion.index',
            'configuraciones.index',
            'roles.index',
            'roles.create',
            'roles.show',
            'roles.edit',
            'roles.destroy',
            'permissions.index',
            'permissions.create',
            'permissions.show',
            'permissions.edit',
            'permissions.destroy',
            'users.index',
            'users.create',
            'users.show',
            'users.edit',
            'users.destroy'
        ]);
    }
}
