<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'username' => 'admin',
                'lname' => 'SARSABA',
                'fname' => 'ELNIE CHAN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'admin@dev.com',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],

            [
                'username' => 'sheen',
                'lname' => 'DELOSA',
                'fname' => 'SHEEN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'sheen@dev.com',
                'role' => 'STUDENT',
                'password' => Hash::make('a')
            ],

            [
                'username' => 'mark',
                'lname' => 'PRIETO',
                'fname' => 'MARK ANTHONY',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'sheen@dev.com',
                'role' => 'STUDENT',
                'password' => Hash::make('a')
            ],


        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
