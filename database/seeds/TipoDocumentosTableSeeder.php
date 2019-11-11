<?php

use Illuminate\Database\Seeder;
use App\TipoDocumento;

class TipoDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::firstOrCreate(['tipo' => '01','nombre' => 'Documento Nacional de Identidad',
                                    'nombre_corto' => 'D. N. I.']);
        TipoDocumento::firstOrCreate(['tipo' => '04','nombre' => 'Carnet de Extranjería',
                                    'nombre_corto' => 'CARNET EXT.']);
        TipoDocumento::firstOrCreate(['tipo' => '07','nombre' => 'Pasaporte',
                                    'nombre_corto' => 'PASAPORTE']);
    }
}
