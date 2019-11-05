<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class ExtrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'extras.index']);
        Permission::firstOrCreate(['name' => 'entradas.index']);
        Permission::firstOrCreate(['name' => 'salidas.index']);

        $gerente = Role::where('name','Gerente')->first();

        $gerente->givePermissionTo([
            'extras.index',
            'entradas.index',
            'salidas.index'
        ]);

        $administrador = Role::where('name','Administrador')->first();

        $administrador->givePermissionTo([
            'extras.index',
            'entradas.index',
            'salidas.index'
        ]);

        $responsable = Role::where('name','Responsable')->first();

        $responsable->givePermissionTo([
            'extras.index',
            'entradas.index',
            'salidas.index'
        ]);

    }
}
