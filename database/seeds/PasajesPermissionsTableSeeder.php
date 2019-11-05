<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class PasajesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'pasajes.index']);
        Permission::firstOrCreate(['name' => 'pasajes.create']);
        Permission::firstOrCreate(['name' => 'pasajes.show']);
        Permission::firstOrCreate(['name' => 'pasajes.edit']);
        Permission::firstOrCreate(['name' => 'pasajes.destroy']);

        $gerente = Role::where('name','Gerente')->first();

        $gerente->givePermissionTo([
            'pasajes.index',
            'pasajes.create',
            'pasajes.show',
            'pasajes.edit',
            'pasajes.destroy'
        ]);

        $administrador = Role::where('name','Administrador')->first();

        $administrador->givePermissionTo([
            'pasajes.index',
            'pasajes.create',
            'pasajes.show',
            'pasajes.edit',
            'pasajes.destroy'
        ]);

        $responsable = Role::where('name','Responsable')->first();

        $responsable->givePermissionTo([
            'pasajes.index',
            'pasajes.create',
            'pasajes.show',
            'pasajes.edit',
            'pasajes.destroy'
        ]);

        $usuario = Role::where('name','Usuario')->first();

        $usuario->givePermissionTo([
            'pasajes.index',
            'pasajes.create',
            'pasajes.show',
        ]);
    }
}
