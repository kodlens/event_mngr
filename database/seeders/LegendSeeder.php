<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LegendSeeder extends Seeder
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
                'rating' => 1,
                'rating_description' => 'VERY BAD'
            ],
            [
                'rating' => 2,
                'rating_description' => 'BAD'
            ],
            [
                'rating' => 3,
                'rating_description' => 'FAIR'
            ],
            [
                'rating' => 4,
                'rating_description' => 'GOOD'
            ],
            [
                'rating' => 5,
                'rating_description' => 'VERY GOOD'
            ],


        ];

        \App\Models\Legend::insertOrIgnore($data);


    }
}
