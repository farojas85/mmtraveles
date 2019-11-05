<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class CountersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => 'counters.index']);
        Permission::firstOrCreate(['name' => 'counters.create']);
        Permission::firstOrCreate(['name' => 'counters.show']);
        Permission::firstOrCreate(['name' => 'counters.edit']);
        Permission::firstOrCreate(['name' => 'counters.destroy']);

        $gerente = Role::where('name','Gerente')->first();

        $gerente->givePermissionTo([
            'counters.index',
            'counters.create',
            'counters.show',
            'counters.edit',
            'counters.destroy'
        ]);

        $administrador = Role::where('name','Administrador')->first();

        $administrador->givePermissionTo([
            'counters.index',
            'counters.create',
            'counters.show',
            'counters.edit',
            'counters.destroy'
        ]);
    }
}
