<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            UserRoleTableSeeder::class,
            PasajesPermissionsTableSeeder::class,
            ExtrasTableSeeder::class,
            PagosTableSeeder::class,
            EmpresasTableSeeder::class,
            CountersTableSeeder::class,
            ReporteCajaGeneralTableSeeder::class,
            EmpresaUserTableSeeder::class
        ]);
    }
}
