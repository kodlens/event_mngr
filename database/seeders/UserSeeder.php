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
                'qr_code' => 'ABC123',
                'username' => 'admin',
                'lname' => 'SARSABA',
                'fname' => 'ELNIE CHAN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'elniechan.sarsaba@nmsc.edu.ph',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],
            [
                'qr_code' => 'AAA222',
                'username' => 'mark',
                'lname' => 'PRIETO',
                'fname' => 'MARK ANTHONY',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'markanthony.prieto@nmsc.edu.ph',
                'role' => 'REQUESTING PARTY',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],



            [
                'qr_code' => '847F4671',
                'username' => 'sheen',
                'lname' => 'DELOSA',
                'fname' => 'SHEEN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'FEMALE',
                'email' => 'sheen.delosa@nmsc.edu.ph',
                'role' => 'ATTENDEE',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],
            [
                'qr_code' => 'D2823EDF',
                'username' => 'Cherryl',
                'lname' => 'GALLEGO',
                'fname' => 'CHERRYL',
                'mname' => 'LANSAM',
                'suffix' => '',
                'sex' => 'FEMALE',
                'email' => 'cherryl.gallego@nmsc.edu.ph',
                'role' => 'ATTENDEE',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],


            //sample dummy user
            [
                'qr_code' => 'D2823E111',
                'username' => 'juan',
                'lname' => 'DELA CRUZ',
                'fname' => 'JUAN',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'juan@nmsc.edu.ph',
                'role' => 'ATTENDEE',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],
            [
                'qr_code' => 'D2823222',
                'username' => 'jane',
                'lname' => 'GOMEZ',
                'fname' => 'JANE',
                'mname' => '',
                'suffix' => '',
                'sex' => 'FEMALE',
                'email' => 'jane@nmsc.edu.ph',
                'role' => 'ATTENDEE',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],
            [
                'qr_code' => 'D2823333',
                'username' => 'jenny',
                'lname' => 'GALEZ',
                'fname' => 'JENNY',
                'mname' => '',
                'suffix' => '',
                'sex' => 'FEMALE',
                'email' => 'jenny@nmsc.edu.ph',
                'role' => 'APPROVING OFFICER',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],
            [
                'qr_code' => 'D2824444',
                'username' => 'rhea',
                'lname' => 'MENDEZ',
                'fname' => 'RHEA',
                'mname' => '',
                'suffix' => '',
                'sex' => 'FEMALE',
                'email' => 'rhea@nmsc.edu.ph',
                'role' => 'APPROVING OFFICER',
                'password' => Hash::make('a'),
                'email_verified_at' => '2023-11-20 14:49:07',
                'active' => 1
            ],

           

        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
