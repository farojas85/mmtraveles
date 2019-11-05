<?php

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    public function run()
    {
        Permission::firstOrCreate(['name' => 'administracion.index']);
        Permission::firstOrCreate(['name' => 'configuraciones.index']);
        Permission::firstOrCreate(['name' => 'roles.index']);
        Permission::firstOrCreate(['name' => 'roles.create']);
        Permission::firstOrCreate(['name' => 'roles.show']);
        Permission::firstOrCreate(['name' => 'roles.edit']);
        Permission::firstOrCreate(['name' => 'roles.destroy']);
        Permission::firstOrCreate(['name' => 'permissions.index']);
        Permission::firstOrCreate(['name' => 'permissions.create']);
        Permission::firstOrCreate(['name' => 'permissions.show']);
        Permission::firstOrCreate(['name' => 'permissions.edit']);
        Permission::firstOrCreate(['name' => 'permissions.destroy']);
        Permission::firstOrCreate(['name' => 'users.index']);
        Permission::firstOrCreate(['name' => 'users.create']);
        Permission::firstOrCreate(['name' => 'users.show']);
        Permission::firstOrCreate(['name' => 'users.edit']);
        Permission::firstOrCreate(['name' => 'users.destroy']);
    }
}
