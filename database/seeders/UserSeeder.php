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
                'lname' => 'DELA CRUZ',
                'fname' => 'JUAN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'admin@dev.com',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],

            [
                'username' => 'student',
                'lname' => 'DOE',
                'fname' => 'JOHN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'student@dev.com',
                'role' => 'STUDENT',
                'password' => Hash::make('a')
            ],


        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
