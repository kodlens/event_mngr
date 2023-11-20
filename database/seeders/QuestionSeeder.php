<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
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
                'order_no' => 1,
                'question' => 'What is your level of satisfaction with this events?',
                'active' => 1
            ],

            [
                'order_no' => 2,
                'question' => 'How likely are you going to tell a friend about this event?',
                'active' => 1
            ],
            
            [
                'order_no' => 3,
                'question' => 'How would you rate our event venue and equipment in regards to how it served you keynote?',
                'active' => 1
            ],
            [
                'order_no' => 4,
                'question' => 'How satisfied were you with the speakers and sessions at our event?',
                'active' => 1
            ],
          

        ];

        \App\Models\Question::insertOrIgnore($data);


    }
}
