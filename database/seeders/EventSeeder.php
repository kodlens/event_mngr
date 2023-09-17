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
                'event' => 'Online Process Enrolment',
                'academic_year_id' => 1,
                'event_description' => 'Good day Alfonsos!
                    Please be guided with the Online Process for Pre-Enrollment for New and Transferee Students
                    Step 1: Access your GADTEST Account to retrieve your Admission Code prior to pre-registration
                    Step 2: Visit admission.gadtc.edu.ph and log in',
                'event_datetime' => '2023-09-18 08:00:00',
                'img_path' => 'KyNZ8E9plc4QizsDBET6orGOWaSa2Dm5FVnBVxJV.jpg'
            ],

            [
                'event' => 'GADTEST',
                'academic_year_id' => 1,
                'event_description' => 'Hello Future Alfonsos!
                The GADTC Admission Test for the 1st Semester of AY 2023-2024 will  officially start on June 5, 2023. The exam will be administered at the 2nd Floor, GADTC Computer Laboratory. You may begin reserving your slots from April 12- May ',
                'event_datetime' => '2023-09-18 08:00:00',
                'img_path' => 'vmQKFulrW4capBBKQSrGtsiOqvpryj3xsLVeDlKf.jpg'
            ],

            [
                'event' => 'KUMUSTAHAN',
                'academic_year_id' => 1,
                'event_description' => '??????? ??? ????? ????? ????? ?? ????, ??? ?? ??? ??????? ?
                ??? ?? ??? ??????, ????? ????? ??? ??????? ??? ??? ?? ????? ??? ??? ?????? ?? ????? Alive and kicking pa ba ang tanan after 4 weeks of classes? Ayaw pag luya luya kay maalkansi ka! ?
                Indeed, t',
                'event_datetime' => '2023-09-25 08:00:00',
                'img_path' => 'borDTRm9JryvwEollD25kn7xmWBNBshgTp1WvvYu.jpg'
            ],


            [
                'event' => 'Online Process Enrolment',
                'academic_year_id' => 1,
                'event_description' => 'Greetings from the Light of the World! ?
                    Please be informed that ALL First and Fourth Year students are REQUIRED to attend the Monthly Mass and President\'s Time on September 15, 2023, (3:00 - 5:00 PM), at People\'s Gymnasium.
                    Note:
                    1. For Non- Catho',
                'event_datetime' => '2023-09-22 15:00:00',
                'img_path' => 'gbeDdXVEl7nljb93hFvE4vVc2pA8jhzqH9ChDqHe.jpg'
            ],



        ];

        \App\Models\Event::insertOrIgnore($data);

    }
}
