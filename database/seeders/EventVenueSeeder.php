<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventVenueSeeder extends Seeder
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
                'event_venue' => 'LEGARDA HALL (Session Hall/Coffee Shop)',
                'active' => 1,
            ],

            [
                'event_venue' => 'NMSC GYMNASIUM',
                'active' => 1,
            ],
            [
                'event_venue' => 'ISOLATION FACILITY',
                'active' => 1,
            ],
            [
                'event_venue' => 'MULTI-PURPOSE CONFERENCE ROOM',
                'active' => 1,
            ],
            [
                'event_venue' => 'PE ACADEMIC BLDG',
                'active' => 1,
            ],
            [
                'event_venue' => 'STE CONFERENCE ROOM',
                'active' => 1,
            ],
            [
                'event_venue' => 'BOARD ROOM',
                'active' => 1,
            ],
            [
                'event_venue' => 'THEATRE ARTS',
                'active' => 1,
            ],
            [
                'event_venue' => 'CONVENTION HALL/BALLROOM',
                'active' => 1,
            ],


        ];

        \App\Models\EventVenue::insertOrIgnore($data);


    }
}
