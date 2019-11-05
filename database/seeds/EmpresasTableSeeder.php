<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Empresa;

class EmpresasTableSeeder extends Seeder
{

    public function run()
    {
        Empresa::firstOrCreate([
            'razon_social' =>'M & M TRAVEL',
            'nombre_comercial' =>'M&M Travel',
            'ruc' => '20567283501',
            'direccion' =>'JR. CRESPO Y CASTILLO NRO. 451 - HUANUCO',
            'foto' => 'images/logo.png'
        ]);
        Empresa::firstOrCreate([
            'razon_social' =>'LORENZA F.C.E.I.R.L.',
            'nombre_comercial' =>'M&M Travel',
            'ruc' => '20567283501',
            'direccion' => 'JR. CRESPO Y CASTILLO NRO. 451 - HUANUCO',
            'foto' => 'images/empresa/lorenza.jpeg'
        ]);
        Empresa::firstOrCreate([
            'razon_social' =>'VICTORIA & ZABRINA E.I.R.L.',
            'nombre_comercial' =>'VICTORIA & ZABRINA E.I.R.L.',
            'ruc' => '20567288995',
            'direccion' => 'JR. CRESPO Y CASTILLO NRO. 451 - HUANUCO',
            'foto' => 'images/empresa/vz.jpg'
        ]);


        Permission::firstOrCreate(['name' => 'entidad.index']);
        Permission::firstOrCreate(['name' => 'empresas.index']);
        Permission::firstOrCreate(['name' => 'locales.index']);
        Permission::firstOrCreate(['name' => 'aerolineas.index']);
        Permission::firstOrCreate(['name' => 'empresas.create']);
        Permission::firstOrCreate(['name' => 'empresas.edit']);
        Permission::firstOrCreate(['name' => 'empresas.show']);
        Permission::firstOrCreate(['name' => 'empresas.destroy']);
        Permission::firstOrCreate(['name' => 'empresas.showdelete']);


        $gerente = Role::where('name','Gerente')->first();

        $gerente->givePermissionTo([
            'entidad.index',
            'empresas.index',
            'locales.index',
            'aerolineas.index',
            'ciudades.index',
            'empresas.create',
            'empresas.edit',
            'empresas.show',
            'empresas.destroy',
            'empresas.showdelete'
        ]);

        $administrador = Role::where('name','Administrador')->first();

        $administrador->givePermissionTo([
            'entidad.index',
            'empresas.index',
            'locales.index',
            'aerolineas.index',
            'ciudades.index',
            'empresas.create',
            'empresas.edit',
            'empresas.show',
            'empresas.destroy',
            'empresas.showdelete'
        ]);
    }
}
