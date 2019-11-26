<?php

use App\Adicional;
use Illuminate\Database\Seeder;

class AdicionalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Adicional::firstOrCreate(['descripcion' => 'Equipaje']);
        Adicional::firstOrCreate(['descripcion' => 'Cambio de Fecha']);
        Adicional::firstOrCreate(['descripcion' => 'Cambio de Nombre']);
        Adicional::firstOrCreate(['descripcion' => 'Checking']);
        Adicional::firstOrCreate(['descripcion' => 'Otros']);
    }
}
