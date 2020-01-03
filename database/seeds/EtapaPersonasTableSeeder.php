<?php

use App\EtapaPersona;
use Illuminate\Database\Seeder;

class EtapaPersonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EtapaPersona::firstOrCreate(['abreviatura' => 'ADT','nombre' => 'ADULTO']);
        EtapaPersona::firstOrCreate(['abreviatura' => 'CHD','nombre' => 'NIÑO']);
        EtapaPersona::firstOrCreate(['abreviatura' => 'INF','nombre' => 'INFANTE']);
    }
}
