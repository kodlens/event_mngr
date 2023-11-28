<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
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
                'event_type' => 'MEETING',
                'active' => 1,
            ],

            [
                'event_type' => 'PROGRAM',
                'active' => 1,
            ],
            [
                'event_type' => 'SEMINAR',
                'active' => 1,
            ],
            [
                'event_type' => 'SYMPOSIUM',
                'active' => 1,
            ],
            [
                'event_type' => 'STAKEHOLDERS',
                'active' => 1,
            ],
            [
                'event_type' => 'OTHERS',
                'active' => 1,
            ],

           

        ];

        \App\Models\EventType::insertOrIgnore($data);

    }
}
