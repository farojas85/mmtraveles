<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class PagosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'pagos.index']);
        Permission::firstOrCreate(['name' => 'pagos-personal.index']);
        Permission::firstOrCreate(['name' => 'pagos-fijos.index']);

        $gerente = Role::where('name','Gerente')->first();

        $gerente->givePermissionTo([
            'pagos.index',
            'pagos-personal.index',
            'pagos-fijos.index'
        ]);

        $administrador = Role::where('name','Administrador')->first();

        $administrador->givePermissionTo([
            'pagos.index',
            'pagos-personal.index',
            'pagos-fijos.index'
        ]);
    }
}
