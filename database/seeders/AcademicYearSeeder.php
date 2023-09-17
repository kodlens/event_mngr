<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
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
                'academic_year_code' => '2022-2023-1',
                'academic_year_desc' => '1ST SEMESTER ACADEMIC YEAR 2022-2023',
                'active' => 1
            ],

            [
                'academic_year_code' => '2022-2023-2',
                'academic_year_desc' => '2ND SEMESTER ACADEMIC YEAR 2022-2023',
                'active' => 0
            ],

            [
                'academic_year_code' => '2022-2023-S',
                'academic_year_desc' => 'SUMMER ACADEMIC YEAR 2022-2023',
                'active' => 0
            ],


        ];

        \App\Models\AcademicYear::insertOrIgnore($data);

    }
}
