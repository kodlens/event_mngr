<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\AcademicYear;
use App\Models\EventAttendee;

class AndroidMyEventController extends Controller
{
    //


    public function myEvents(Request $req){
        $ay = AcademicYear::where('active', 1)->first();

        $userId = $req->id;

        $data = EventAttendee::with(['user', 'event', 'event.academic_year'])
            ->where('user_id', $userId)
            ->orderBy('event_id', 'desc');

        return $data->get();

    }
}
