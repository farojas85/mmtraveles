<?php

use Illuminate\Database\Seeder;
class EmpresaUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresa_user')->insert(
            ['user_id' => 2, 'empresa_id' => 1]);
        DB::table('empresa_user')->insert(
            ['user_id' => 2, 'empresa_id' => 2]);
        DB::table('empresa_user')->insert(
            ['user_id' => 2, 'empresa_id' => 3]);
        DB::table('empresa_user')->insert(
            ['user_id' => 3, 'empresa_id' => 1]);
        DB::table('empresa_user')->insert(
            ['user_id' => 3, 'empresa_id' => 2]);
        DB::table('empresa_user')->insert(
            ['user_id' => 3, 'empresa_id' => 3]);
        DB::table('empresa_user')->insert(
            ['user_id' => 4, 'empresa_id' => 1]);
        DB::table('empresa_user')->insert(
            ['user_id' => 4, 'empresa_id' => 2]);
        DB::table('empresa_user')->insert(
            ['user_id' => 4, 'empresa_id' => 3]);
        DB::table('empresa_user')->insert(
            ['user_id' => 5, 'empresa_id' => 4]);
        DB::table('empresa_user')->insert(
            ['user_id' => 6, 'empresa_id' => 4]);
        DB::table('empresa_user')->insert(
            ['user_id' => 7, 'empresa_id' => 4]);
        DB::table('empresa_user')->insert(
            ['user_id' => 8, 'empresa_id' => 1]);
        DB::table('empresa_user')->insert(
            ['user_id' => 9, 'empresa_id' => 2]);
        DB::table('empresa_user')->insert(
            ['user_id' => 10, 'empresa_id' => 2]);
        DB::table('empresa_user')->insert(
            ['user_id' => 11, 'empresa_id' => 1]);
        DB::table('empresa_user')->insert(
            ['user_id' => 12, 'empresa_id' => 2]);
        DB::table('empresa_user')->insert(
            ['user_id' => 13, 'empresa_id' => 1]);

    }
}
