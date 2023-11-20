<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
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
                'code' => 'STE',
                'department' => 'STE',
                'active' => 1
            ],
           
            [
                'code' => 'SET',
                'department' => 'SET',
                'active' => 1
            ],
            [
                'code' => 'SAS',
                'department' => 'SAS',
                'active' => 1
            ],
            [
                'code' => 'SAES',
                'department' => 'SAES',
                'active' => 1
            ],
            [
                'code' => 'SICT',
                'department' => 'SICT',
                'active' => 1
            ],
            [
                'code' => 'SBAM',
                'department' => 'SBAM',
                'active' => 1
            ],


        ];

        \App\Models\Department::insertOrIgnore($data);
    }
}
