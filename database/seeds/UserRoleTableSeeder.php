<?php

use App\User;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User Gerente 1
        $user1 = User::findOrFail(2);
        $user1->assignRole('Gerente');
        //User Gerente 1
        $user2 = User::findOrFail(3);
        $user2->assignRole('Gerente');
        //User Administrador
        $user3 = User::findOrFail(4);
        $user3->assignRole('Administrador');
        //User Responsable 1
        $user4 = User::findOrFail(5);
        $user4->assignRole('Responsable');
        //User Usuario 1
        $user5 = User::findOrFail(6);
        $user5->assignRole('Usuario');
        //User Usuario 2
        $user6 = User::findOrFail(7);
        $user6->assignRole('Usuario');
        //User Responsable 2
        $user7 = User::findOrFail(8);
        $user7->assignRole('Responsable');
        //User Usuario 3
        $user3 = User::findOrFail(9);
        $user3->assignRole('Usuario');
        //User Usuario 4
        $user3 = User::findOrFail(10);
        $user3->assignRole('Usuario');
        //User Usuario 5
        $user3 = User::findOrFail(11);
        $user3->assignRole('Usuario');
        //User Usuario 6
        $user3 = User::findOrFail(12);
        $user3->assignRole('Usuario');
        //User Usuario 7
        $user3 = User::findOrFail(13);
        $user3->assignRole('Usuario');
    }
}
