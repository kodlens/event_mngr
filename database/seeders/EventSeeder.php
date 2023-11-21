<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
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
                'event' => 'TES & TDP RELEASE',
                'academic_year_id' => 1,
                'content' => 'ATTENTION FOR ALL TES AND TDP GRANTEES! THERE WILL BE AN UPCOPING RELEASE FOR YOUR GRANTS THIS COMING FRIDAY NOVEMBER 17,2023 IN THE ADMINSTRATION BULDING, RELEASE WILL START AT EXACTLY 8:00AM IN THE MORNING. THANK YOU!',
                'event_datetime' => '2023-09-22 15:00:00',
                'img_path' => 'gbeDdXVEl7nljb93hFvE4vVc2pA8jhzqH9ChDqHe.jpg',
                'approval_status' => 1,
                'is_open' => 0

            ],

            [
                'event' => 'Monthly Mass',
                'academic_year_id' => 1,
                'content' => '<p><strong>Announcement Blue Generals.</strong></p><p><br></p><p><br></p><p>We will have a monthly mass this afternoon. All students are required to attend.</p>',
                'event_datetime' => '2023-09-22 15:00:00',
                'img_path' => 'T6qZYwDpIdOmhDkLvkFUTPV306j7DsoL18ieCxTG.jpg',
                'approval_status' => 1,
                'is_open' => 1
            ],


        ];

        \App\Models\Event::insertOrIgnore($data);

    }
}
