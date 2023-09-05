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
                'lname' => 'PUCOT',
                'fname' => 'MARJHON',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'admin@dev.com',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],


        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
