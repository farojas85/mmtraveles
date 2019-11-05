<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class ReporteCajaGeneralTableSeeder extends Seeder
{
    public function run()
    {
        Permission::firstOrCreate(['name' => 'pasajes.comisiones']);
        Permission::firstOrCreate(['name' => 'pasajes.depositos']);
        Permission::firstOrCreate(['name' => 'reporte-caja-general.index']);
        Permission::firstOrCreate(['name' => 'reporte-resumido.index']);
        Permission::firstOrCreate(['name' => 'reporte-plantilla.index']);
        Permission::firstOrCreate(['name' => 'reporte-costamar.index']);
        Permission::firstOrCreate(['name' => 'reporte-caja-viva.index']);
        Permission::firstOrCreate(['name' => 'reporte-comisiones-generales.index']);
        Permission::firstOrCreate(['name' => 'reporte-comisiones-deudas.index']);
        Permission::firstOrCreate(['name' => 'reporte-trimestre.index']);

        $gerente = Role::where('name','Gerente')->first();

        $gerente->givePermissionTo([
            'pasajes.comisiones',
            'pasajes.depositos',
            'reporte-caja-general.index',
            'reporte-resumido.index',
            'reporte-plantilla.index',
            'reporte-costamar.index',
            'reporte-caja-viva.index',
            'reporte-comisiones-generales.index',
            'reporte-comisiones-deudas.index',
            'reporte-trimestre.index',
        ]);

        $administrador = Role::where('name','Administrador')->first();

        $administrador->givePermissionTo([
            'pasajes.comisiones',
            'pasajes.depositos',
            'reporte-caja-general.index',
            'reporte-resumido.index',
            'reporte-plantilla.index',
            'reporte-costamar.index',
            'reporte-caja-viva.index',
            'reporte-comisiones-generales.index',
            'reporte-comisiones-deudas.index',
            'reporte-trimestre.index',
        ]);

        $responsable = Role::where('name','Responsable')->first();

        $responsable->givePermissionTo([
            'reporte-caja-general.index',
            'reporte-resumido.index',
            'reporte-plantilla.index',
        ]);
    }
}
